// 네이션스리그(조별 홈·원정 리그 + 조 3·4위 팀끼리 비교) 경우의 수 엔진
//   var nl = NationsEngine.create(UNL_DATA);
//   var stat = nl.run(10000, { 3: [0, 2] });  // 3번 경기를 0:2로 고정하고 1만 번
//   var now = nl.standings({});               // 끝난(정한) 경기만으로 만든 지금 순위
// 순위 규정(UEFA 네이션스리그 2026/27 규정):
//   조 순위: 승점 → 동률 팀끼리 승점·득실차·다득점(남은 동률 팀끼리 다시 적용) → 전체 득실차 → 다득점
//            → 원정 다득점 → 다승 → 원정 다승 → (징계 점수) → access list 순위
//   3위·4위 비교: 승점 → 득실차 → 다득점 → 원정 다득점 → 다승 → 원정 다승 → (징계 점수) → access list 순위
//   징계 점수(경고·퇴장)는 미리 알 수 없어서 건너뛰어요
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
        function lambdas(h, a) {
            var dr = teams[h].elo + model.home - teams[a].elo;
            return [model.mu * Math.exp(model.c * dr), model.mu * Math.exp(-model.c * dr)];
        }

        function scoreTable(h, a) {
            var l = lambdas(h, a), cells = [], sum = 0;
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

        function run(n, fixed, seed) {
            fixed = fixed || {};
            var rand = makeRand(seed || 2026);
            var stat = {};
            codes.forEach(function (c) { stat[c] = { pos: [0, 0, 0, 0], qf: 0, stay: 0, po: 0, rel: 0, pts: 0 }; });
            for (var it = 0; it < n; it++) {
                var res = outcome(allGames(fixed, rand));
                codes.forEach(function (c) {
                    var s = stat[c];
                    s.pos[res.pos[c] - 1]++;
                    s[res.fate[c]]++;
                    s.pts += res.tab[c].pts;
                });
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
