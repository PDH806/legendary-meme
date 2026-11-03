// 네이션스리그(조별 홈·원정 리그 + 조 3·4위 팀끼리 비교) 경우의 수 엔진
//   var nl = NationsEngine.create(UNL_DATA);
//   var stat = nl.run(10000, { 3: [0, 2] });  // 3번 경기를 0:2로 고정하고 1만 번
//   var now = nl.standings({});               // 끝난(정한) 경기만으로 만든 지금 순위
// 순위 규정(UEFA 네이션스리그 2026/27 규정):
//   조 순위: 승점 → 동률 팀끼리 승점·득실차·다득점(남은 동률 팀끼리 다시 적용) → 전체 득실차 → 다득점
//            → 원정 다득점 → 다승 → 원정 다승 → (징계 점수) → access list 순위
//   3위·4위 비교: 승점 → 득실차 → 다득점 → 원정 다득점 → 다승 → 원정 다승 → (징계 점수) → access list 순위
//   징계 점수(경고·퇴장)는 미리 알 수 없어서 건너뛰어요
// 토너먼트: 8강 추첨(조 1위 vs 다른 조 2위)을 무작위로 하고, 8강 홈·원정 → 4강 추첨 → 중립 단판 4강·결승까지 시뮬레이션해요
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

    function create(data) {
        var teams = data.teams, model = data.model;
        var codes = Object.keys(teams);
        var groupIds = Object.keys(data.groups);
        var groupOf = {};
        groupIds.forEach(function (g) { data.groups[g].forEach(function (c) { groupOf[c] = g; }); });
        var played = data.played.map(function (p) { return { g: String(p[0]), h: p[1], a: p[2], hg: p[3], ag: p[4] }; });
        var matches = data.matches.map(function (m) {
            return { id: m[0], g: String(m[1]), md: m[2], h: m[3], a: m[4], date: m[5] };
        });

        // 홈팀은 Elo에 홈 이점을 더해요. 예상 득점 = mu × e^(±c × 점수 차)
        // neutral이면(파이널스 같은 중립 경기) 홈 이점 없이
        function lambdas(h, a, neutral) {
            var dr = teams[h].elo + (neutral ? 0 : model.home) - teams[a].elo;
            return [model.mu * Math.exp(model.c * dr), model.mu * Math.exp(-model.c * dr)];
        }

        function scoreTable(h, a, neutral) {
            var l = lambdas(h, a, neutral), cells = [], sum = 0;
            for (var i = 0; i <= MAX_GOALS; i++) {
                for (var j = 0; j <= MAX_GOALS; j++) {
                    var p = poissonPmf(l[0], i) * poissonPmf(l[1], j);
                    cells.push([i, j, p]);
                    sum += p;
                }
            }
            var acc = 0, w = 0, d = 0, lo = 0;
            cells.forEach(function (c) {
                c[2] /= sum;
                if (c[0] > c[1]) w += c[2]; else if (c[0] === c[1]) d += c[2]; else lo += c[2];
                acc += c[2];
                c.push(acc);
            });
            return { cells: cells, wdl: [w, d, lo] };
        }

        var tables = {};
        matches.forEach(function (m) { tables[m.id] = scoreTable(m.h, m.a); });

        // 토너먼트용 점수표 (대진마다 처음 쓸 때 만들어 둬요)
        var koTables = {};
        function koTable(h, a, neutral) {
            var k = h + a + (neutral ? 'n' : '');
            return koTables[k] || (koTables[k] = scoreTable(h, a, neutral));
        }

        function sample(tab, rand) {
            var r = rand(), cells = tab.cells, lo = 0, hi = cells.length - 1;
            while (lo < hi) {
                var mid = (lo + hi) >> 1;
                if (cells[mid][3] < r) lo = mid + 1; else hi = mid;
            }
            return [cells[lo][0], cells[lo][1]];
        }

        // only가 있으면 그 팀들끼리 치른 경기만 세요 (맞대결 기록)
        function tally(list, only) {
            var s = {};
            (only || codes).forEach(function (c) { s[c] = { p: 0, w: 0, d: 0, l: 0, gf: 0, ga: 0, gd: 0, pts: 0, agf: 0, aw: 0 }; });
            list.forEach(function (g) {
                var h = s[g.h], a = s[g.a];
                if (!h || !a) return;
                h.p++; a.p++;
                h.gf += g.hg; h.ga += g.ag; a.gf += g.ag; a.ga += g.hg; a.agf += g.ag;
                if (g.hg > g.ag) { h.w++; a.l++; h.pts += 3; }
                else if (g.hg < g.ag) { a.w++; a.aw++; h.l++; a.pts += 3; }
                else { h.d++; a.d++; h.pts++; a.pts++; }
            });
            Object.keys(s).forEach(function (c) { s[c].gd = s[c].gf - s[c].ga; });
            return s;
        }

        function cmpBy(keys, s) {
            return function (x, y) {
                for (var i = 0; i < keys.length; i++) {
                    var k = keys[i], d = s[y][k] - s[x][k];
                    if (d) return d;
                }
                return 0;
            };
        }

        // 같은 값끼리 묶기 (정렬된 목록 기준)
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

        var H2H = ['pts', 'gd', 'gf'];
        var OVERALL = ['gd', 'gf', 'agf', 'w', 'aw'];
        var bySeed = function (x, y) { return teams[x].seed - teams[y].seed; };

        // 승점이 같은 팀들: 맞대결 → (남은 동률 팀끼리 다시) → 전체 기록 → access list
        function breakTie(tied, games, all) {
            if (tied.length === 1) return tied;
            var h = tally(games, tied), cmp = cmpBy(H2H, h);
            var parts = blocks(tied.slice().sort(cmp), cmp);
            if (parts.length > 1) {
                return parts.reduce(function (acc, p) { return acc.concat(breakTie(p, games, all)); }, []);
            }
            var o = cmpBy(OVERALL, all);
            return tied.slice().sort(function (x, y) { return o(x, y) || bySeed(x, y); });
        }

        function rankGroup(g, list) {
            var games = list.filter(function (x) { return x.g === g; });
            var all = tally(games, data.groups[g]);
            var byPts = cmpBy(['pts'], all);
            var sorted = data.groups[g].slice().sort(byPts);
            var order = blocks(sorted, byPts).reduce(function (acc, b) { return acc.concat(breakTie(b, games, all)); }, []);
            return { order: order, tab: all };
        }

        // 조 3위끼리, 4위끼리 비교
        function rankAcross(list, tab) {
            var cmp = cmpBy(['pts', 'gd', 'gf', 'agf', 'w', 'aw'], tab);
            return list.slice().sort(function (x, y) { return cmp(x, y) || bySeed(x, y); });
        }

        function allGames(fixed, rand) {
            var list = played.slice();
            matches.forEach(function (m) {
                var r = fixed[m.id] || data.results[m.id];
                if (!r && rand) r = sample(tables[m.id], rand);
                if (r) list.push({ id: m.id, g: m.g, h: m.h, a: m.a, hg: r[0], ag: r[1] });
            });
            return list;
        }

        // 결과: 'qf' 8강, 'stay' 리그 A 잔류(3위 상위 2팀), 'po' 승강 플레이오프, 'rel' 리그 B 강등
        function outcome(list) {
            var tab = {}, order = {}, pos = {}, fate = {}, thirds = [], fourths = [];
            groupIds.forEach(function (g) {
                var r = rankGroup(g, list);
                order[g] = r.order;
                r.order.forEach(function (c, i) { pos[c] = i + 1; tab[c] = r.tab[c]; });
                r.order.slice(0, 2).forEach(function (c) { fate[c] = 'qf'; });
                thirds.push(r.order[2]);
                fourths.push(r.order[3]);
            });
            var t3 = rankAcross(thirds, tab), t4 = rankAcross(fourths, tab);
            t3.forEach(function (c, i) { fate[c] = i < 2 ? 'stay' : 'po'; });
            t4.forEach(function (c, i) { fate[c] = i < 2 ? 'po' : 'rel'; });
            return { tab: tab, order: order, pos: pos, fate: fate, thirds: t3, fourths: t4 };
        }

        function poissonSample(lambda, rand) {
            var l = Math.exp(-lambda), k = 0, p = 1;
            do { k++; p *= rand(); } while (p > l);
            return k - 1;
        }

        // 비겼을 때: 연장전(예상 득점의 1/3, 30분) → 그래도 같으면 승부차기 50:50
        function extraTime(h, a, neutral, rand) {
            var l = lambdas(h, a, neutral);
            var eh = poissonSample(l[0] / 3, rand), ea = poissonSample(l[1] / 3, rand);
            if (eh !== ea) return eh > ea ? h : a;
            return rand() < 0.5 ? h : a;
        }

        // 8강: 1차전은 조 2위 팀 홈, 2차전은 조 1위 팀 홈. 합산 점수 → 연장(2차전 홈) → 승부차기 (원정 다득점 없음)
        function twoLegs(winner, runner, rand) {
            var l1 = sample(koTable(runner, winner), rand), l2 = sample(koTable(winner, runner), rand);
            var w = l1[1] + l2[0], r = l1[0] + l2[1];
            if (w !== r) return w > r ? winner : runner;
            return extraTime(winner, runner, false, rand);
        }

        // 파이널스(4강·결승)는 중립 경기 단판
        function single(h, a, rand) {
            var s = sample(koTable(h, a, true), rand);
            if (s[0] !== s[1]) return s[0] > s[1] ? h : a;
            return extraTime(h, a, true, rand);
        }

        // 8강 추첨: 조 1위와 다른 조 2위를 무작위로 짝지어요
        function drawQuarters(winners, runners, rand) {
            for (;;) {
                var perm = runners.slice();
                for (var i = perm.length - 1; i > 0; i--) {
                    var j = Math.floor(rand() * (i + 1)), t = perm[i];
                    perm[i] = perm[j]; perm[j] = t;
                }
                var ok = perm.every(function (r, k) { return groupOf[r] !== groupOf[winners[k]]; });
                if (ok) return winners.map(function (w, k) { return [w, perm[k]]; });
            }
        }

        // 추첨부터 결승까지 한 번. 결과: 4강 팀, 결승 팀, 우승 팀
        function knockout(res, rand) {
            var winners = groupIds.map(function (g) { return res.order[g][0]; });
            var runners = groupIds.map(function (g) { return res.order[g][1]; });
            var semis = drawQuarters(winners, runners, rand).map(function (tie) { return twoLegs(tie[0], tie[1], rand); });
            // 4강 추첨도 무작위
            for (var i = semis.length - 1; i > 0; i--) {
                var j = Math.floor(rand() * (i + 1)), t = semis[i];
                semis[i] = semis[j]; semis[j] = t;
            }
            var finalists = [single(semis[0], semis[1], rand), single(semis[2], semis[3], rand)];
            return { sf: semis, final: finalists, champ: single(finalists[0], finalists[1], rand) };
        }

        function run(n, fixed, seed) {
            fixed = fixed || {};
            var rand = makeRand(seed || 2026);
            var stat = {};
            codes.forEach(function (c) { stat[c] = { pos: [0, 0, 0, 0], qf: 0, stay: 0, po: 0, rel: 0, pts: 0, sf: 0, final: 0, champ: 0 }; });
            for (var it = 0; it < n; it++) {
                var res = outcome(allGames(fixed, rand));
                codes.forEach(function (c) {
                    var s = stat[c];
                    s.pos[res.pos[c] - 1]++;
                    s[res.fate[c]]++;
                    s.pts += res.tab[c].pts;
                });
                var ko = knockout(res, rand);
                ko.sf.forEach(function (c) { stat[c].sf++; });
                ko.final.forEach(function (c) { stat[c].final++; });
                stat[ko.champ].champ++;
            }
            codes.forEach(function (c) { stat[c].ptsAvg = stat[c].pts / n; });
            return { n: n, teams: stat };
        }

        function standings(fixed) {
            return outcome(allGames(fixed || {}, null));
        }

        return {
            teams: teams,
            codes: codes,
            groups: data.groups,
            groupIds: groupIds,
            groupOf: groupOf,
            matches: matches,
            matchProbs: function (id) { return tables[id].wdl; },
            run: run,
            standings: standings,
            _rankGroup: rankGroup // 테스트용
        };
    }

    root.NationsEngine = { create: create };
})(window);
