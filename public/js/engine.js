// 경우의 수 시뮬레이션 엔진
// 남은 경기를 전력 점수로 수만 번 무작위로 치러 보고, 순위와 진출 확률을 세요.
//   var cup = CupEngine.create(CUP_DATA);
//   var stat = cup.run(10000, { 8: [2, 0] });   // 8번 경기를 2:0으로 고정하고 1만 번
//   var table = cup.standings({ 8: [2, 0] });  // 지금까지 결과만으로 만든 순위표
(function (root) {
    'use strict';

    // 같은 입력이면 같은 결과가 나오도록 시드가 있는 난수를 써요 (mulberry32)
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

    function poisson(lambda, rand) {
        var limit = Math.exp(-lambda), k = 0, p = 1;
        do { k++; p *= rand(); } while (p > limit);
        return k - 1;
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

    function flat(lists) {
        return [].concat.apply([], lists);
    }

    // 키 배열(큰 값이 위)로 정렬한 뒤, 키가 같은 팀끼리 묶어요
    function splitBy(codes, keyOf) {
        var rows = codes.map(function (c) { return { c: c, k: keyOf(c) }; });
        rows.sort(function (x, y) {
            for (var i = 0; i < x.k.length; i++) if (x.k[i] !== y.k[i]) return y.k[i] - x.k[i];
            return 0;
        });
        var parts = [];
        rows.forEach(function (r, i) {
            var prev = rows[i - 1];
            if (prev && prev.k.join() === r.k.join()) parts[parts.length - 1].push(r.c);
            else parts.push([r.c]);
        });
        return parts;
    }

    // 주어진 팀들 사이의 경기만으로 승점, 득실차, 득점을 세요
    function tally(codes, games) {
        var s = {};
        codes.forEach(function (c) { s[c] = { p: 0, w: 0, d: 0, l: 0, gf: 0, ga: 0, gd: 0, pts: 0 }; });
        games.forEach(function (g) {
            var h = s[g.h], a = s[g.a];
            if (!h || !a) return;
            h.p++; a.p++;
            h.gf += g.hg; h.ga += g.ag; a.gf += g.ag; a.ga += g.hg;
            if (g.hg > g.ag) { h.w++; a.l++; h.pts += 3; }
            else if (g.hg < g.ag) { a.w++; h.l++; a.pts += 3; }
            else { h.d++; a.d++; h.pts++; a.pts++; }
        });
        codes.forEach(function (c) { s[c].gd = s[c].gf - s[c].ga; });
        return s;
    }

    function create(data) {
        var model = data.model || {};
        var MU = model.mu || 1.25;      // 한 팀의 평균 득점
        var C = model.c || 0.0022;      // 전력 점수 1점 차이가 득점에 주는 영향
        var teams = data.teams;
        var groups = {};
        Object.keys(teams).forEach(function (code) {
            var g = teams[code].group;
            (groups[g] = groups[g] || []).push(code);
        });
        Object.keys(groups).forEach(function (g) {
            groups[g].sort(function (a, b) { return teams[a].slot - teams[b].slot; });
        });
        var groupNames = Object.keys(groups).sort();
        var matches = data.matches.map(function (m) {
            return { id: m[0], group: m[1], md: m[2], h: m[3], a: m[4], kst: m[5] };
        });

        function rating(code) {
            return teams[code].elo + (code === data.host ? (data.homeBonus || 0) : 0);
        }

        function lambdas(h, a) {
            var dr = rating(h) - rating(a);
            return [MU * Math.exp(C * dr), MU * Math.exp(-C * dr)];
        }

        // 한 경기의 승/무/패 확률 (화면에 보여주는 용도)
        function matchProbs(h, a) {
            var l = lambdas(h, a), win = 0, draw = 0, lose = 0;
            for (var i = 0; i <= 12; i++) {
                for (var j = 0; j <= 12; j++) {
                    var p = poissonPmf(l[0], i) * poissonPmf(l[1], j);
                    if (i > j) win += p; else if (i === j) draw += p; else lose += p;
                }
            }
            var sum = win + draw + lose;
            return [win / sum, draw / sum, lose / sum];
        }

        // 조 순위 (규정 7.3조)
        //   승점 → 동률 팀끼리 맞대결 승점·득실차·득점 → 아직 동률이면 그 팀들끼리만 맞대결 다시 적용
        //   → 전체 득실차·득점 → 승부차기(두 팀이 마지막 경기에서 맞붙었을 때) → 페어플레이 → 추첨
        // ctx.rand가 없으면(순위표 화면) 추첨 대신 조 추첨 순서를 쓰고, 동률을 ctx.ties에 남겨요
        function rankGroup(codes, games, ctx) {
            var all = tally(codes, games);
            var blocks = splitBy(codes, function (c) { return [all[c].pts]; });
            return flat(blocks.map(function (b) {
                return b.length > 1 ? headToHead(b, games, all, ctx) : b;
            }));
        }

        function headToHead(block, games, all, ctx) {
            var inner = games.filter(function (g) { return block.indexOf(g.h) >= 0 && block.indexOf(g.a) >= 0; });
            var t = tally(block, inner);
            var parts = splitBy(block, function (c) { return [t[c].pts, t[c].gd, t[c].gf]; });
            if (parts.length === 1) return byOverall(block, games, all, ctx);
            return flat(parts.map(function (p) {
                return p.length > 1 ? headToHead(p, games, all, ctx) : p;
            }));
        }

        function byOverall(block, games, all, ctx) {
            var parts = splitBy(block, function (c) { return [all[c].gd, all[c].gf]; });
            return flat(parts.map(function (p) {
                return p.length > 1 ? drawLots(p, games, ctx) : p;
            }));
        }

        function drawLots(p, games, ctx) {
            if (ctx.rand) return shuffle(p.slice(), ctx.rand); // 승부차기·페어플레이·추첨은 반반으로 봐요
            var shootout = p.length === 2 && games.some(function (g) {
                return g.md === 3 && ((g.h === p[0] && g.a === p[1]) || (g.h === p[1] && g.a === p[0]));
            });
            ctx.ties.push({ teams: p.slice(), shootout: shootout });
            return p.slice().sort(function (a, b) { return teams[a].slot - teams[b].slot; });
        }

        // 3위 팀 비교: 승점 → 득실차 → 득점 → (페어플레이) → 추첨
        // 규정집 매뉴얼 부록 2 기준이라 확인 후 바뀔 수 있어요
        function rankThirds(thirds, tallies, ctx) {
            var parts = splitBy(thirds, function (c) {
                var s = tallies[teams[c].group][c];
                return [s.pts, s.gd, s.gf];
            });
            return flat(parts.map(function (p) {
                if (p.length === 1) return p;
                if (ctx.rand) return shuffle(p.slice(), ctx.rand);
                ctx.ties.push({ teams: p.slice(), shootout: false });
                return p;
            }));
        }

        // 토너먼트 한 경기: 90분 → 비기면 연장전 → 그래도 비기면 승부차기
        function knockoutGame(h, a, rand) {
            var l = lambdas(h, a);
            var g = { h: h, a: a, hg: poisson(l[0], rand), ag: poisson(l[1], rand), et: false, pens: false };
            if (g.hg === g.ag) { // 연장전 30분은 90분의 1/3로 봐요
                g.et = true;
                g.hg += poisson(l[0] / 3, rand);
                g.ag += poisson(l[1] / 3, rand);
            }
            if (g.hg === g.ag) { g.pens = true; g.winner = rand() < 0.5 ? h : a; } // 승부차기는 반반
            else g.winner = g.hg > g.ag ? h : a;
            return g;
        }

        function knockout(h, a, rand) {
            return knockoutGame(h, a, rand).winner;
        }

        // 토너먼트에서 h가 다음 라운드에 갈 확률 (연장·승부차기 포함)
        function advanceProb(h, a) {
            var l = lambdas(h, a);
            function wdl(x, y) {
                var w = 0, d = 0;
                for (var i = 0; i <= 12; i++) for (var j = 0; j <= 12; j++) {
                    var p = poissonPmf(x, i) * poissonPmf(y, j);
                    if (i > j) w += p; else if (i === j) d += p;
                }
                return [w, d];
            }
            var ft = wdl(l[0], l[1]), et = wdl(l[0] / 3, l[1] / 3);
            return ft[0] + ft[1] * (et[0] + et[1] * 0.5);
        }

        function gamesWith(fixed, rand) {
            return matches.map(function (m) {
                var r = fixed[m.id] || data.results[m.id];
                var g = { id: m.id, group: m.group, md: m.md, h: m.h, a: m.a, played: !!r };
                if (r) { g.hg = r[0]; g.ag = r[1]; }
                else if (rand) {
                    var l = lambdas(m.h, m.a);
                    g.hg = poisson(l[0], rand); g.ag = poisson(l[1], rand);
                    g.played = true;
                }
                return g;
            });
        }

        // 조별리그 결과 → 조 순위, 3위 비교, 16강 대진
        function resolveGroups(games, ctx) {
            var ranks = {}, tallies = {};
            groupNames.forEach(function (g) {
                var gg = games.filter(function (x) { return x.group === g && x.played; });
                tallies[g] = tally(groups[g], gg);
                ranks[g] = rankGroup(groups[g], gg, ctx);
            });
            var thirds = rankThirds(groupNames.map(function (g) { return ranks[g][2]; }), tallies, ctx);
            var best = thirds.slice(0, 4);
            var key = best.map(function (c) { return teams[c].group; }).sort().join('');
            var opp = data.thirdTable[key]; // [1A, 1B, 1C, 1D 상대 3위의 조]
            function slot(s) {
                if (s.charAt(0) === 'T') return ranks[opp['ABCD'.indexOf(s.charAt(2))]][2];
                return ranks[s.charAt(1)][Number(s.charAt(0)) - 1];
            }
            var r16 = data.r16.map(function (pair) { return [slot(pair[0]), slot(pair[1])]; });
            return { ranks: ranks, tallies: tallies, thirds: thirds, best: best, r16: r16 };
        }

        function emptyStat() {
            var s = {};
            Object.keys(teams).forEach(function (c) {
                s[c] = { pos: [0, 0, 0, 0], r16: 0, qf: 0, sf: 0, final: 0, champ: 0, opp: {}, oppByPos: [{}, {}, {}] };
            });
            return s;
        }

        function add(map, key) { map[key] = (map[key] || 0) + 1; }

        // n번 시뮬레이션. fixed = { 경기번호: [홈, 원정] } 사용자가 정한 결과
        function run(n, fixed, seed) {
            fixed = fixed || {};
            var rand = makeRand(seed || 2027);
            var stat = emptyStat();
            for (var it = 0; it < n; it++) {
                var games = gamesWith(fixed, rand);
                var res = resolveGroups(games, { rand: rand });
                groupNames.forEach(function (g) {
                    res.ranks[g].forEach(function (c, i) { stat[c].pos[i]++; });
                });
                var round = res.r16;
                round.forEach(function (pair) {
                    pair.forEach(function (c, i) {
                        var s = stat[c], o = pair[1 - i];
                        var pos = res.ranks[teams[c].group].indexOf(c);
                        s.r16++;
                        add(s.opp, o);
                        add(s.oppByPos[pos], o);
                    });
                });
                var stages = ['qf', 'sf', 'final', 'champ'];
                for (var st = 0; st < stages.length; st++) {
                    var winners = round.map(function (pair) { return knockout(pair[0], pair[1], rand); });
                    winners.forEach(function (c) { stat[c][stages[st]]++; });
                    if (winners.length === 1) break;
                    round = [];
                    for (var k = 0; k < winners.length; k += 2) round.push([winners[k], winners[k + 1]]);
                }
            }
            return { n: n, teams: stat };
        }

        // 지금까지 끝난(또는 사용자가 정한) 경기만으로 만든 순위표
        function standings(fixed) {
            var ctx = { ties: [] };
            var res = resolveGroups(gamesWith(fixed || {}, null), ctx);
            res.ties = ctx.ties;
            return res;
        }

        // 조별리그를 한 번만 치러 본 결과 (토너먼트 대진표 화면용). 같은 시드면 같은 결과
        function single(fixed, seed) {
            var rand = makeRand(seed);
            var games = gamesWith(fixed || {}, rand);
            var res = resolveGroups(games, { rand: rand });
            res.games = games;
            return res;
        }

        // 토너먼트 한 경기를 시드로 치러요. 시드가 같으면 같은 점수가 나와요
        function playKnockout(h, a, seed) {
            return knockoutGame(h, a, makeRand(seed));
        }

        return {
            teams: teams,
            groups: groups,
            groupNames: groupNames,
            matches: matches,
            matchProbs: matchProbs,
            advanceProb: advanceProb,
            rankGroup: function (codes, games) { var ctx = { ties: [] }; var r = rankGroup(codes, games, ctx); return { order: r, ties: ctx.ties }; },
            run: run,
            single: single,
            playKnockout: playKnockout,
            standings: standings
        };
    }

    root.CupEngine = { create: create, tally: tally };
})(window);
