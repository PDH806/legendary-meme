// 토너먼트 시뮬레이션: 대회를 한 번 치러 본 대진표
//   - "대회 한 번 돌려보기"를 누르면 시드를 하나 뽑아 조별리그 남은 경기와 토너먼트를 치러요
//   - 팀을 누르면 그 팀이 이긴 걸로 정하고, 다음 라운드는 바뀐 대진으로 다시 치러요
//   - 경기마다 (시드, 라운드, 순서, 두 팀)으로 점수를 정해서, 같은 링크면 같은 대진표가 나와요
(function () {
    'use strict';

    var $ = function (id) { return document.getElementById(id); };
    var ROUND_NAMES = ['16강', '8강', '4강', '결승'];

    // 문자열 → 32비트 시드 (FNV-1a)
    function hash(str) {
        var h = 2166136261;
        for (var i = 0; i < str.length; i++) {
            h ^= str.charCodeAt(i);
            h = Math.imul(h, 16777619);
        }
        return h >>> 0;
    }

    // 대진표 계산: 사용자가 고른 승자를 먼저 반영하고, 나머지는 시드로 치러요
    function build(app) {
        var st = app.state, cup = app.cup;
        var res = cup.single(st.fixed, st.run);
        var rounds = [], pairs = res.r16;
        for (var r = 0; r < ROUND_NAMES.length; r++) {
            var games = pairs.map(function (p, i) {
                var key = r + '-' + i, pick = st.picks[key];
                if (pick && pick !== p[0] && pick !== p[1]) { delete st.picks[key]; pick = null; } // 위 라운드가 바뀌어 없는 팀이면 지워요
                var g = pick
                    ? { h: p[0], a: p[1], winner: pick, picked: true }
                    : cup.playKnockout(p[0], p[1], hash(st.run + '|' + key + '|' + p[0] + '|' + p[1]));
                g.key = key;
                g.prob = cup.advanceProb(p[0], p[1]);
                return g;
            });
            rounds.push(games);
            pairs = [];
            for (var k = 0; k + 1 < games.length; k += 2) pairs.push([games[k].winner, games[k + 1].winner]);
        }
        return { res: res, rounds: rounds, champion: rounds[rounds.length - 1][0].winner };
    }

    function teamBtn(app, g, side) {
        var code = side ? g.a : g.h, win = g.winner === code;
        var prob = side ? 1 - g.prob : g.prob;
        var score = g.picked ? '' : '<b class="sc">' + (side ? g.ag : g.hg) + '</b>';
        var cls = 'ko-t' + (win ? ' win' : ' lose') + (code === app.state.focus ? ' me' : '');
        return '<button type="button" class="' + cls + '" data-k="' + g.key + '" data-c="' + code + '" aria-pressed="' + (g.picked && win) + '"' +
            ' title="' + app.esc(app.data.teams[code].name) + ' 승리로 정하기">' +
            '<span class="nm">' + app.label(code, false, true) + '</span><span class="pr">' + Math.round(prob * 100) + '%</span>' + score + '</button>';
    }

    function note(g) {
        if (g.picked) return '<span class="ko-note pick">내 선택</span>';
        if (g.pens) return '<span class="ko-note">승부차기</span>';
        if (g.et) return '<span class="ko-note">연장</span>';
        return '';
    }

    // 이번 대회의 조별리그 결과 요약: 기준 팀 조는 경기 점수까지, 나머지 조는 진출 팀만
    function groupSummary(app, res) {
        var cup = app.cup, focusGroup = app.data.teams[app.state.focus].group;
        var advanced = {};
        res.r16.forEach(function (p) { advanced[p[0]] = advanced[p[1]] = true; });
        var focus = app.state.focus;
        var games = res.games.filter(function (g) { return g.group === focusGroup; });
        function side(code, cls) {
            return '<span class="' + cls + (code === focus ? ' me' : '') + '">' + app.label(code, cls === 'h') + '</span>';
        }
        var left = '<div class="ko-box"><h3>' + focusGroup + '조 경기 결과</h3><ul class="ko-res">' + games.map(function (g) {
            var tag = app.state.fixed[g.id] ? '<small>입력</small>' : '';
            return '<li>' + side(g.h, 'h') + '<span class="s">' + g.hg + ' : ' + g.ag + tag + '</span>' + side(g.a, 'a') + '</li>';
        }).join('') + '</ul></div>';
        var rows = cup.groupNames.map(function (gn) {
            return '<tr' + (gn === focusGroup ? ' class="cur"' : '') + '><th scope="row">' + gn + '조</th>' + res.ranks[gn].slice(0, 3).map(function (c, i) {
                var cls = (c === focus ? 'me' : '') + (advanced[c] ? '' : ' out');
                var badge = i === 2 ? (advanced[c] ? '<em class="adv">진출</em>' : '<em class="drop">탈락</em>') : '';
                return '<td class="' + cls + '">' + app.label(c) + badge + '</td>';
            }).join('') + '</tr>';
        }).join('');
        var right = '<div class="ko-box"><h3>조별 순위</h3><div class="scroll"><table class="ko-rt"><thead><tr>' +
            '<th scope="col">조</th><th scope="col">1위</th><th scope="col">2위</th><th scope="col">3위</th></tr></thead><tbody>' +
            rows + '</tbody></table></div></div>';
        return '<div class="ko-groups">' + left + right + '</div>';
    }

    function render() {
        var app = window.CupApp && window.CupApp.current();
        if (!app || !app.stat) return;
        var st = app.state;
        $('ko_run').textContent = st.run ? '🎲 다시 돌리기' : '🎲 대회 한 번 돌려보기';
        $('ko_clear').hidden = !Object.keys(st.picks).length;
        $('ko_card').hidden = !st.run;
        if (!st.run) { $('ko').innerHTML = ''; return; }
        var b = build(app);
        var champ = b.champion;
        var html = '<p class="ko-champ">🏆 우승 <strong>' + app.label(champ) + '</strong></p>';
        html += '<h3 class="ko-sep"><span>조별리그</span></h3>';
        html += groupSummary(app, b.res);
        html += '<h3 class="ko-sep"><span>토너먼트</span></h3>';
        html += '<div class="scroll"><div class="bracket">' + b.rounds.map(function (games, r) {
            return '<div class="ko-col"><h3><span>' + ROUND_NAMES[r] + '</span></h3><div class="ko-list">' + games.map(function (g) {
                return '<div class="ko-m">' + teamBtn(app, g, 0) + teamBtn(app, g, 1) + note(g) + '</div>';
            }).join('') + '</div></div>';
        }).join('') + '</div></div>';
        html += '<p class="hint">팀을 누르면 그 팀이 이긴 걸로 정하고 다음 라운드를 다시 치러요. 한 번 더 누르면 선택이 풀려요. 퍼센트는 그 경기에서 이길 확률이에요(연장·승부차기 포함).</p>';
        $('ko').innerHTML = html;
    }

    // ---------- 대진표 카드 (1080×1350) ----------
    var CARD_W = 1080, CARD_H = 1350, ROUND_FULL = ['16강', '8강', '4강', '결승'];

    // 기준 팀이 이번 대회에서 간 길: "대한민국 · 16강 승 → 8강 승 → 4강 패 (일본, 승부차기)"
    function focusPath(app, b) {
        var focus = app.state.focus, t = app.data.teams, steps = [];
        if (!b.res.r16.some(function (p) { return p[0] === focus || p[1] === focus; })) {
            var pos = b.res.ranks[t[focus].group].indexOf(focus) + 1;
            return t[focus].name + ' · 조별리그 탈락 (' + t[focus].group + '조 ' + pos + '위)';
        }
        for (var r = 0; r < b.rounds.length; r++) {
            var g = b.rounds[r].filter(function (x) { return x.h === focus || x.a === focus; })[0];
            if (!g) break;
            if (g.winner === focus) { steps.push(r === 3 ? '결승 승 🏆' : ROUND_FULL[r] + ' 승'); continue; }
            var opp = g.h === focus ? g.a : g.h;
            var how = g.picked ? '' : g.pens ? ', 승부차기' : g.et ? ', 연장' : '';
            steps.push(ROUND_FULL[r] + ' 패 (' + t[opp].name + how + ')');
            break;
        }
        return t[focus].name + ' · ' + steps.join(' → ');
    }

    // 한 경기 줄: [국기 홈] 점수 [원정 국기]. 이긴 팀은 흰색, 진 팀은 흐리게
    function paintGame(ctx, U, flags, app, g, x, y, w, fs) {
        var t = app.data.teams, h = Math.round(fs * 1.9), mid = x + w / 2;
        var flagH = Math.round(fs * 0.78), nameMax = w / 2 - fs * 2.4 - flagH * 1.4;
        ctx.fillStyle = 'rgba(255,255,255,0.08)';
        U.roundRect(ctx, x, y, w, h, 14);
        ctx.fill();
        var base = y + h / 2 + fs * 0.36;
        [g.h, g.a].forEach(function (code, side) {
            var win = g.winner === code;
            ctx.globalAlpha = win ? 1 : 0.5;
            ctx.fillStyle = code === app.state.focus ? '#9ff0b8' : '#ffffff';
            ctx.font = U.font(win ? 800 : 600, fs);
            if (side === 0) {
                var fx = U.drawFlag(ctx, flags[code], x + 16, base, flagH);
                ctx.textAlign = 'left';
                ctx.fillText(t[code].short || t[code].name, x + 16 + fx, base, nameMax);
            } else {
                var fw = Math.round(flagH * 4 / 3);
                U.drawFlag(ctx, flags[code], x + w - 16 - fw, base, flagH);
                ctx.textAlign = 'right';
                ctx.fillText(t[code].short || t[code].name, x + w - 16 - fw - Math.round(flagH * 0.4), base, nameMax);
            }
        });
        ctx.globalAlpha = 1;
        ctx.textAlign = 'center';
        ctx.fillStyle = '#ffffff';
        var tag = g.picked ? '내 선택' : g.pens ? '승부차기' : g.et ? '연장' : '';
        if (g.picked) {
            ctx.font = U.font(700, Math.round(fs * 0.62));
            ctx.fillStyle = '#9ff0b8';
            ctx.fillText(tag, mid, base - fs * 0.1);
        } else {
            ctx.font = U.font(800, fs);
            ctx.fillText(g.hg + ' : ' + g.ag, mid, base - (tag ? fs * 0.22 : 0));
            if (tag) {
                ctx.font = U.font(700, Math.round(fs * 0.5));
                ctx.fillStyle = '#f0c56a';
                ctx.fillText(tag, mid, base + fs * 0.5);
            }
        }
        ctx.textAlign = 'left';
        return h;
    }

    function paintCard(app, b, flags) {
        var U = window.CupCard.util;
        var cv = document.createElement('canvas');
        cv.width = CARD_W; cv.height = CARD_H;
        var ctx = cv.getContext('2d'), x = 80, w = CARD_W - x * 2, col = (w - 20) / 2;
        U.paintBackground(ctx, CARD_W, CARD_H);
        ctx.textBaseline = 'alphabetic';

        ctx.fillStyle = 'rgba(255,255,255,0.75)';
        ctx.font = U.font(600, 32);
        ctx.fillText(app.data.name + ' · 내 예상 대진표', x, 120);

        ctx.fillStyle = '#ffffff';
        ctx.font = U.font(800, 48);
        ctx.fillText('🏆 우승', x, 210);
        var cx = x + ctx.measureText('🏆 우승').width + 24;
        cx += U.drawFlag(ctx, flags[b.champion], cx, 214, 58);
        ctx.font = U.font(800, 84);
        ctx.fillText(app.data.teams[b.champion].name, cx, 214);

        ctx.fillStyle = '#9ff0b8';
        ctx.font = U.font(700, 30);
        ctx.fillText(focusPath(app, b), x, 280, w);

        function label(text, y) {
            ctx.fillStyle = 'rgba(255,255,255,0.7)';
            ctx.font = U.font(700, 26);
            ctx.fillText(text, x, y);
        }
        var y = 350;
        label('결승', y);
        y += 16 + paintGame(ctx, U, flags, app, b.rounds[3][0], x, y + 16, w, 44);

        y += 56; label('4강', y);
        y += 16;
        var hh = 0;
        b.rounds[2].forEach(function (g, i) { hh = paintGame(ctx, U, flags, app, g, x + i * (col + 20), y, col, 32); });
        y += hh;

        y += 56; label('8강', y);
        y += 16;
        for (var i = 0; i < 4; i++) {
            hh = paintGame(ctx, U, flags, app, b.rounds[1][i], x + (i % 2) * (col + 20), y + Math.floor(i / 2) * (hh + 12), col, 30);
        }
        y += hh * 2 + 12;

        y += 56; label('16강', y);
        y += 16;
        for (i = 0; i < 8; i++) {
            hh = paintGame(ctx, U, flags, app, b.rounds[0][i], x + (i % 2) * (col + 20), y + Math.floor(i / 2) * (hh + 10), col, 28);
        }

        U.paintFooter(ctx, CARD_W, CARD_H, '대회 시뮬레이션 1회 결과 · 참고용');
        return cv;
    }

    function openCard() {
        var app = window.CupApp.current();
        if (!app.state.run) return;
        var b = build(app);
        var codes = {};
        b.rounds[0].forEach(function (g) { codes[g.h] = codes[g.a] = true; });
        window.CupCard.prepare(Object.keys(codes)).then(function (flags) {
            window.CupCard.show(function (f) { return paintCard(app, b, f); }, flags,
                'asiancup-bracket.png', '내 예상 아시안컵 우승: ' + app.data.teams[b.champion].name);
        });
    }

    $('ko_card').addEventListener('click', openCard);
    $('ko_run').addEventListener('click', function () {
        var st = window.CupApp.current().state;
        st.run = 1 + Math.floor(Math.random() * 999999999);
        st.picks = {};
        window.CupApp.save();
        render();
    });
    $('ko_clear').addEventListener('click', function () {
        window.CupApp.current().state.picks = {};
        window.CupApp.save();
        render();
    });
    $('ko').addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-k]');
        if (!btn) return;
        var picks = window.CupApp.current().state.picks;
        var key = btn.dataset.k, code = btn.dataset.c;
        if (picks[key] === code) delete picks[key];
        else picks[key] = code;
        window.CupApp.save();
        render();
    });

    window.CupBracket = { render: render, openCard: openCard };
})();
