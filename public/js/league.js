// 리그 경우의 수 엔진 (K리그 파이널 라운드처럼 남은 경기가 정해진 리그)
//   var lg = LeagueEngine.create(LEAGUE_DATA);
//   var stat = lg.run(10000, { 1: [2, 0] });   // 1번 경기를 2:0으로 고정하고 1만 번
//   var now = lg.standings({ 1: [2, 0] });     // 끝난(정한) 경기만으로 만든 순위표
(function (root) {
    'use strict';

    var MAX_GOALS = 8;

    // 같은 입력이면 같은 결과가 나오도록 시드가 있는 난수 (mulberry32)
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

    function shuffle(list, rand) {
        for (var i = list.length - 1; i > 0; i--) {
            var j = Math.floor(rand() * (i + 1)), t = list[i];
            list[i] = list[j]; list[j] = t;
        }
        return list;
    }

    function create(data) {
        var teams = data.teams, model = data.model;
        var codes = Object.keys(teams);
        var played = data.played.map(function (p) { return { h: p[0], a: p[1], hg: p[2], ag: p[3] }; });
        var matches = data.matches.map(function (m) {
            return { id: m[0], split: m[1], round: m[2], h: m[3], a: m[4], date: m[5] };
        });

        // 경기마다 점수표(0~8골) 확률을 미리 만들어 둬요. 무승부 칸은 보정 계수만큼 키워요
        function scoreTable(h, a) {
            var lh = model.m * model.home * teams[h].att * teams[a].def;
            var la = model.m * teams[a].att * teams[h].def;
            var cells = [], sum = 0;
            for (var i = 0; i <= MAX_GOALS; i++) {
                for (var j = 0; j <= MAX_GOALS; j++) {
                    var p = poissonPmf(lh, i) * poissonPmf(la, j) * (i === j ? model.draw : 1);
                    cells.push([i, j, p]);
                    sum += p;
                }
            }
            var acc = 0, w = 0, d = 0, l = 0;
            cells.forEach(function (c) {
                c[2] /= sum;
                if (c[0] > c[1]) w += c[2]; else if (c[0] === c[1]) d += c[2]; else l += c[2];
                acc += c[2];
                c.push(acc); // 누적 확률
            });
            return { cells: cells, wdl: [w, d, l] };
        }

        var tables = {};
        matches.forEach(function (m) { tables[m.id] = scoreTable(m.h, m.a); });

        function sample(tab, rand) {
            var r = rand(), cells = tab.cells, lo = 0, hi = cells.length - 1;
            while (lo < hi) { // 누적 확률에서 이진 탐색
                var mid = (lo + hi) >> 1;
                if (cells[mid][3] < r) lo = mid + 1; else hi = mid;
            }
            return [cells[lo][0], cells[lo][1]];
        }

        function tally(list) {
            var s = {};
            codes.forEach(function (c) { s[c] = { p: 0, w: 0, d: 0, l: 0, gf: 0, ga: 0, gd: 0, pts: 0 }; });
            list.forEach(function (g) {
                var h = s[g.h], a = s[g.a];
                h.p++; a.p++;
                h.gf += g.hg; h.ga += g.ag; a.gf += g.ag; a.ga += g.hg;
                if (g.hg > g.ag) { h.w++; a.l++; h.pts += 3; }
                else if (g.hg < g.ag) { a.w++; h.l++; a.pts += 3; }
                else { h.d++; a.d++; h.pts++; a.pts++; }
            });
            codes.forEach(function (c) { s[c].gd = s[c].gf - s[c].ga; });
            return s;
        }

        // 동률 팀끼리 치른 경기의 승점 (승자승)
        function h2hPoints(group, list) {
            var pts = {};
            group.forEach(function (c) { pts[c] = 0; });
            list.forEach(function (g) {
                if (!(g.h in pts) || !(g.a in pts)) return;
                if (g.hg > g.ag) pts[g.h] += 3; else if (g.hg < g.ag) pts[g.a] += 3; else { pts[g.h]++; pts[g.a]++; }
            });
            return pts;
        }

        function key(s, c, h2h) {
            return data.tiebreak.map(function (k) { return k === 'h2h' ? (h2h ? h2h[c] : 0) : s[c][k]; });
        }

        function cmp(x, y) {
            for (var i = 0; i < x.length; i++) if (x[i] !== y[i]) return y[i] - x[i];
            return 0;
        }

        // 한 파이널(6팀) 안의 순위: 승점 → 다득점 → 득실차 → 다승 → 승자승 → (그래도 같으면) 추첨
        // rand가 없으면(순위표 화면) 추첨 대신 지금 순서를 쓰고 동률을 ties에 남겨요
        function rankGroup(group, tab, list, rand, ties) {
            var base = group.slice().sort(function (a, b) { return cmp(key(tab, a), key(tab, b)); });
            var out = [], i = 0;
            while (i < base.length) {
                var j = i + 1;
                while (j < base.length && cmp(key(tab, base[i]), key(tab, base[j])) === 0) j++;
                var block = base.slice(i, j);
                if (block.length > 1) {
                    var h2h = h2hPoints(block, list);
                    block.sort(function (a, b) { return h2h[b] - h2h[a]; });
                    var k = 0;
                    while (k < block.length) { // 승자승까지 같은 팀들
                        var e = k + 1;
                        while (e < block.length && h2h[block[e]] === h2h[block[k]]) e++;
                        var same = block.slice(k, e);
                        if (same.length > 1) {
                            if (rand) same = shuffle(same, rand);
                            else if (ties) ties.push(same.slice());
                        }
                        out = out.concat(same);
                        k = e;
                    }
                } else {
                    out.push(block[0]);
                }
                i = j;
            }
            return out;
        }

        function seasonGames(fixed, rand) {
            var list = played.slice();
            matches.forEach(function (m) {
                var r = fixed[m.id] || data.results[m.id];
                if (!r && rand) r = sample(tables[m.id], rand);
                if (r) list.push({ id: m.id, h: m.h, a: m.a, hg: r[0], ag: r[1] });
            });
            return list;
        }

        function finalOrder(list, rand, ties) {
            var tab = tally(list), pos = {}, order = {};
            data.splits.forEach(function (sp) {
                order[sp.id] = rankGroup(sp.teams, tab, list, rand, ties);
                order[sp.id].forEach(function (c, i) { pos[c] = sp.from + i; });
            });
            return { tab: tab, pos: pos, order: order };
        }

        // n번 시뮬레이션. fixed = { 경기번호: [홈, 원정] } 사용자가 정한 결과
        function run(n, fixed, seed) {
            fixed = fixed || {};
            var rand = makeRand(seed || 2026);
            var stat = {};
            codes.forEach(function (c) { stat[c] = { pos: new Array(codes.length + 1).join('0').split('').map(Number), pts: 0 }; });
            for (var it = 0; it < n; it++) {
                var res = finalOrder(seasonGames(fixed, rand), rand, null);
                codes.forEach(function (c) {
                    stat[c].pos[res.pos[c] - 1]++;
                    stat[c].pts += res.tab[c].pts;
                });
            }
            codes.forEach(function (c) { stat[c].ptsAvg = stat[c].pts / n; });
            return { n: n, teams: stat };
        }

        // 끝난(정한) 경기만으로 만든 지금 순위표
        function standings(fixed) {
            var ties = [];
            var res = finalOrder(seasonGames(fixed || {}, null), null, ties);
            res.ties = ties;
            return res;
        }

        return {
            teams: teams,
            codes: codes,
            matches: matches,
            splits: data.splits,
            matchProbs: function (id) { return tables[id].wdl; },
            run: run,
            standings: standings
        };
    }

    root.LeagueEngine = { create: create };
})(window);
