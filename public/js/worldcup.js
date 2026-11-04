// 48개국 월드컵(2026 방식) 엔진: 12개 조 → 각 조 1·2위 + 3위 상위 8팀 → 32강부터 결승
//   var wc = WorldCupEngine.create(WC_DATA);
//   var stat = wc.run(10000);        // 1만 번 치른 단계별 횟수
//   var one = wc.single(seed);       // 조별리그 한 번 + 32강 대진
//   var g = wc.playKnockout(h, a, seed) // 토너먼트 한 경기 (연장·승부차기 포함)
// 순위 규정(FIFA 월드컵 2026 규정):
//   조 순위: 승점 → 동률 팀끼리 승점·득실차·다득점(남은 동률 팀끼리 다시 적용) → 전체 득실차 → 다득점 → (페어플레이) → FIFA 랭킹
//   3위 비교: 승점 → 득실차 → 다득점 → (페어플레이) → FIFA 랭킹
//   페어플레이 점수는 미리 알 수 없어 건너뛰고, FIFA 랭킹 자리에는 Elo 전력 점수를 써요
(function (root) {
    'use strict';

    var MAX_GOALS = 10;

    function makeRand(seed) {
        var a = seed >>> 0;
        return function () {
            a = (a + 0x6D2B79F5) >>> 0;
            var t = a;
            t = Math.imul(t ^ (t >>> 15), t | 1);
            t ^= t + Math.imul(t ^ (t >>> 7), t | 61);
            return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
        };
    }

    function poissonPmf(lambda, k) {
        var p = Math.exp(-lambda);
        for (var i = 1; i <= k; i++) p *= lambda / i;
        return p;
    }

    function poissonSample(lambda, rand) {
        var l = Math.exp(-lambda), k = 0, p = 1;
        do { k++; p *= rand(); } while (p > l);
        return k - 1;
    }

    function create(data) {
        var teams = data.teams, model = data.model;
        var codes = Object.keys(teams);
        var groupNames = Object.keys(data.groups);
        var groupOf = {};
        groupNames.forEach(function (g) { data.groups[g].forEach(function (c) { groupOf[c] = g; }); });
        var hosts = {};
        data.hosts.forEach(function (c) { hosts[c] = true; });
        var BRACKET = data.bracket || data.r32; // 첫 토너먼트 라운드 대진 (위에서부터)
        var FIRST = BRACKET.length === 16 ? 0 : 1; // 32강부터면 0, 16강부터면 1
        var thirdMap = {};
        data.thirds.split(' ').forEach(function (x) { var p = x.split(':'); thirdMap[p[0]] = p[1]; });

        // 조별리그: 개최국은 자기 나라에서 경기해서 홈 이점을 받아요. 토너먼트는 중립으로 봐요
        function lambdas(h, a, groupStage) {
            var bonus = groupStage || data.hostKO ? (hosts[h] ? model.home : 0) - (hosts[a] ? model.home : 0) : 0;
            var dr = teams[h].elo + bonus - teams[a].elo;
            return [model.mu * Math.exp(model.c * dr), model.mu * Math.exp(-model.c * dr)];
        }

        var tables = {};
        function table(h, a, groupStage) {
            var k = h + a + (groupStage ? 'g' : '');
            if (tables[k]) return tables[k];
            var l = lambdas(h, a, groupStage), cells = [], sum = 0;
            for (var i = 0; i <= MAX_GOALS; i++) {
                for (var j = 0; j <= MAX_GOALS; j++) {
                    var p = poissonPmf(l[0], i) * poissonPmf(l[1], j);
                    cells.push([i, j, p]);
                    sum += p;
                }
            }
            var acc = 0, w = 0, d = 0;
            cells.forEach(function (c) {
                c[2] /= sum;
                if (c[0] > c[1]) w += c[2]; else if (c[0] === c[1]) d += c[2];
                acc += c[2];
                c.push(acc);
            });
            return (tables[k] = { cells: cells, w: w, d: d });
        }

        function sample(tab, rand) {
            var r = rand(), cells = tab.cells, lo = 0, hi = cells.length - 1;
            while (lo < hi) {
                var mid = (lo + hi) >> 1;
                if (cells[mid][3] < r) lo = mid + 1; else hi = mid;
            }
            return [cells[lo][0], cells[lo][1]];
        }

        // 조마다 6경기 (네 팀이 한 번씩)
        var fixtures = [];
        groupNames.forEach(function (g) {
            var t = data.groups[g];
            for (var i = 0; i < 4; i++) for (var j = i + 1; j < 4; j++) fixtures.push({ g: g, h: t[i], a: t[j] });
        });

        function tally(list, only) {
            var s = {};
            only.forEach(function (c) { s[c] = { p: 0, w: 0, d: 0, l: 0, gf: 0, ga: 0, gd: 0, pts: 0 }; });
            list.forEach(function (g) {
                var h = s[g.h], a = s[g.a];
                if (!h || !a) return;
                h.p++; a.p++;
                h.gf += g.hg; h.ga += g.ag; a.gf += g.ag; a.ga += g.hg;
                if (g.hg > g.ag) { h.w++; a.l++; h.pts += 3; }
                else if (g.hg < g.ag) { a.w++; h.l++; a.pts += 3; }
                else { h.d++; a.d++; h.pts++; a.pts++; }
            });
            only.forEach(function (c) { s[c].gd = s[c].gf - s[c].ga; });
            return s;
        }

        function cmpBy(keys, s) {
            return function (x, y) {
                for (var i = 0; i < keys.length; i++) {
                    var d = s[y][keys[i]] - s[x][keys[i]];
                    if (d) return d;
                }
                return 0;
            };
        }

        function blocks(list, cmp) {
            var out = [], i = 0;
            while (i < list.length) {
                var j = i + 1;
                while (j < list.length && cmp(list[i], list[j]) === 0) j++;
                out.push(list.slice(i, j));
                i = j;
            }
            return out;
        }

        var byElo = function (x, y) { return teams[y].elo - teams[x].elo; };

        function breakTie(tied, games, all) {
            if (tied.length === 1) return tied;
            var h = tally(games, tied), cmp = cmpBy(['pts', 'gd', 'gf'], h);
            var parts = blocks(tied.slice().sort(cmp), cmp);
            if (parts.length > 1) return parts.reduce(function (acc, p) { return acc.concat(breakTie(p, games, all)); }, []);
            var o = cmpBy(['gd', 'gf'], all);
            return tied.slice().sort(function (x, y) { return o(x, y) || byElo(x, y); });
        }

        function rankGroup(g, games) {
            var all = tally(games, data.groups[g]), byPts = cmpBy(['pts'], all);
            var order = blocks(data.groups[g].slice().sort(byPts), byPts)
                .reduce(function (acc, b) { return acc.concat(breakTie(b, games, all)); }, []);
            return { order: order, tab: all };
        }

        // 조 순위와 32강에 오른 3위 팀의 조 목록으로 32강 대진 만들기 (FIFA 규정 부록 C 조합표)
        function bracketOf(ranks, thirdGroups) {
            var opp = thirdMap[thirdGroups.slice().sort().join('')];
            function slot(s, home) {
                if (s === 'T') return ranks[opp[data.thirdSlots.indexOf(home[1])]][2];
                return ranks[s[1]][+s[0] - 1];
            }
            return BRACKET.map(function (p) { return [slot(p[0]), slot(p[1], p[0])]; });
        }

        // 조별리그 한 번 → 조 순위, 3위 순위, 32강 대진
        function groupStage(rand) {
            var games = fixtures.map(function (f) {
                var s = sample(table(f.h, f.a, true), rand);
                return { g: f.g, h: f.h, a: f.a, hg: s[0], ag: s[1] };
            });
            var ranks = {}, tab = {}, thirds = [];
            groupNames.forEach(function (g) {
                var r = rankGroup(g, games.filter(function (x) { return x.g === g; }));
                ranks[g] = r.order;
                r.order.forEach(function (c) { tab[c] = r.tab[c]; });
                thirds.push(r.order[2]);
            });
            var cmp = cmpBy(['pts', 'gd', 'gf'], tab);
            thirds.sort(function (x, y) { return cmp(x, y) || byElo(x, y); });
            var best = thirds.slice(0, data.bestThirds || 8);
            var r32 = bracketOf(ranks, best.map(function (c) { return groupOf[c]; }));
            return { games: games, ranks: ranks, tab: tab, thirds: thirds, best: best, r32: r32 };
        }

        // 토너먼트 한 경기: 90분 → 연장전(예상 득점 1/3) → 승부차기 50:50
        function knockoutGame(h, a, rand) {
            var s = sample(table(h, a, false), rand);
            var g = { h: h, a: a, hg: s[0], ag: s[1] };
            if (s[0] !== s[1]) { g.winner = s[0] > s[1] ? h : a; return g; }
            var l = lambdas(h, a, false);
            var eh = poissonSample(l[0] / 3, rand), ea = poissonSample(l[1] / 3, rand);
            g.et = true; g.hg += eh; g.ag += ea;
            if (eh !== ea) { g.winner = eh > ea ? h : a; return g; }
            g.pens = true; g.winner = rand() < 0.5 ? h : a;
            return g;
        }

        var STAGES = ['r32', 'r16', 'qf', 'sf', 'final', 'champ'];

        function run(n, seed) {
            var rand = makeRand(seed || 2026), stat = {};
            codes.forEach(function (c) { stat[c] = { pos: [0, 0, 0, 0], r32: 0, r16: 0, qf: 0, sf: 0, final: 0, champ: 0 }; });
            for (var it = 0; it < n; it++) {
                var gs = groupStage(rand);
                groupNames.forEach(function (g) { gs.ranks[g].forEach(function (c, i) { stat[c].pos[i]++; }); });
                var round = gs.r32.map(function (p) { return p.slice(); });
                var stage = FIRST;
                while (true) {
                    round.forEach(function (p) { stat[p[0]][STAGES[stage]]++; stat[p[1]][STAGES[stage]]++; });
                    var winners = round.map(function (p) { return knockoutGame(p[0], p[1], rand).winner; });
                    stage++;
                    if (winners.length === 1) { stat[winners[0]].champ++; break; }
                    round = [];
                    for (var k = 0; k < winners.length; k += 2) round.push([winners[k], winners[k + 1]]);
                }
            }
            return { n: n, teams: stat };
        }

        function etWin(h, a) {
            var l = lambdas(h, a, false), w = 0, d = 0;
            for (var i = 0; i <= MAX_GOALS; i++) {
                for (var j = 0; j <= MAX_GOALS; j++) {
                    var p = poissonPmf(l[0] / 3, i) * poissonPmf(l[1] / 3, j);
                    if (i > j) w += p; else if (i === j) d += p;
                }
            }
            return w + d / 2;
        }

        var probs = {};
        function advanceProb(h, a) {
            var k = h + a;
            if (k in probs) return probs[k];
            var t = table(h, a, false);
            return (probs[k] = t.w + t.d * etWin(h, a));
        }

        return {
            teams: teams,
            codes: codes,
            groups: data.groups,
            groupNames: groupNames,
            groupOf: groupOf,
            run: run,
            single: function (seed) { return groupStage(makeRand(seed)); },
            playKnockout: function (h, a, seed) { return knockoutGame(h, a, makeRand(seed)); },
            advanceProb: advanceProb,
            firstStage: FIRST,
            bracketOf: bracketOf
        };
    }

    root.WorldCupEngine = { create: create };
})(window);
