// 2026 월드컵 다시 돌려보기 화면
// 주소 뒤 #t=KOR&r=12345&k=0-3-KOR 처럼 기준 팀, 돌린 대회(시드), 직접 고른 승자를 기억해서 링크로 공유해요
(function () {
    'use strict';

    var N = 10000;
    var data = window.WC_DATA;
    var wc = WorldCupEngine.create(data);
    var teams = wc.teams;
    var state = { focus: data.focus && data.teams[data.focus] ? data.focus : 'KOR', run: 0, picks: {} };
    var stat = null;
    var ROUNDS = data.rounds || ['32강', '16강', '8강', '4강', '결승'];
    var KEYS = ['r32', 'r16', 'qf', 'sf', 'final'].slice(5 - ROUNDS.length); // 라운드별 통계 이름
    var ACTUAL = { G: '조별리그 탈락', R32: '32강', R16: '16강', QF: '8강', SF: '4강', F: '준우승', W: '우승' };

    var $ = function (id) { return document.getElementById(id); };

    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function name(code) { return esc(teams[code].name); }

    // 국기 + 이름 (국기 출처: flag-icons, MIT)
    function label(code) {
        return '<img class="flag" src="img/flags/' + teams[code].flag + '.svg" alt="" width="20" height="15">' + name(code);
    }

    function pct2(count) { return (100 * count / stat.n).toFixed(2) + '%'; }

    function pct(count) {
        if (!count) return '0%';
        if (count === stat.n) return '100%';
        var p = 100 * count / stat.n;
        if (p < 1 || p >= 99) return p.toFixed(2) + '%';
        return (p >= 10 ? p.toFixed(0) : p.toFixed(1)) + '%';
    }

    function actualText(code) {
        var a = teams[code].actual;
        if (a === 'G') return ACTUAL.G + ' (' + wc.groupOf[code] + '조 ' + (data.groups[wc.groupOf[code]].indexOf(code) + 1) + '위)';
        return ACTUAL[a];
    }

    function readHash() {
        location.hash.replace(/^#/, '').split('&').forEach(function (part) {
            var kv = part.split('='), v = decodeURIComponent(kv[1] || '');
            if (kv[0] === 't' && teams[v]) state.focus = v;
            if (kv[0] === 'r' && /^\d{1,10}$/.test(v)) state.run = +v;
            if (kv[0] === 'k') v.split('.').forEach(function (x) {
                var m = /^(\d)-(\d{1,2})-([A-Z]{3})$/.exec(x);
                if (m && teams[m[3]]) state.picks[m[1] + '-' + m[2]] = m[3];
            });
        });
    }

    function writeHash() {
        var k = Object.keys(state.picks).map(function (key) { return key + '-' + state.picks[key]; }).join('.');
        history.replaceState(null, '', '#t=' + state.focus + (state.run ? '&r=' + state.run : '') + (k ? '&k=' + k : ''));
    }

    function render() {
        renderHero();
        renderChampBars();
        renderBracket();
        renderAll();
        writeHash();
    }

    function renderHero() {
        var c = state.focus, s = stat.teams[c];
        $('focus_name').innerHTML = label(c);
        $('big').textContent = pct(s.champ);
        var chips = ROUNDS.map(function (r, i) { return [r, s[KEYS[i]]]; });
        $('stages').innerHTML = chips.map(function (x) { return '<li><span>' + x[0] + '</span><b>' + pct(x[1]) + '</b></li>'; }).join('');
        $('scenario').textContent = (data.actualLabel || '실제 대회') + ': ' + actualText(c);
    }

    function renderChampBars() {
        var list = wc.codes.slice().sort(function (a, b) { return stat.teams[b].champ - stat.teams[a].champ; });
        var top = list.slice(0, 8);
        if (top.indexOf(state.focus) < 0) top.push(state.focus);
        var max = stat.teams[list[0]].champ || 1;
        $('champ_bars').innerHTML = top.map(function (c) {
            var v = stat.teams[c].champ;
            return '<li' + (c === state.focus ? ' class="me"' : '') + '><span class="rk">' + (list.indexOf(c) + 1) + '</span><span class="t">' + label(c) + '</span><span class="v">' + pct2(v) + '</span>' +
                '<span class="track"><span class="fill" style="width:' + (v ? Math.max(1.5, 100 * v / max) : 0).toFixed(1) + '%"></span></span></li>';
        }).join('');
    }

    // ---------- 대회 한 번 돌려보기 ----------

    function hash(str) {
        var h = 2166136261;
        for (var i = 0; i < str.length; i++) { h ^= str.charCodeAt(i); h = Math.imul(h, 16777619); }
        return h >>> 0;
    }

    function buildBracket() {
        var res = wc.single(state.run);
        var rounds = [], pairs = res.r32;
        for (var r = 0; r < ROUNDS.length; r++) {
            var games = pairs.map(function (p, i) {
                var key = r + '-' + i, pick = state.picks[key];
                if (pick && pick !== p[0] && pick !== p[1]) { delete state.picks[key]; pick = null; }
                var g = pick ? { h: p[0], a: p[1], winner: pick, picked: true }
                    : wc.playKnockout(p[0], p[1], hash(state.run + '|' + key + '|' + p[0] + '|' + p[1]));
                g.key = key;
                g.prob = wc.advanceProb(p[0], p[1]);
                return g;
            });
            rounds.push(games);
            pairs = [];
            for (var k = 0; k + 1 < games.length; k += 2) pairs.push([games[k].winner, games[k + 1].winner]);
        }
        return { res: res, rounds: rounds, champion: rounds[rounds.length - 1][0].winner };
    }

    function teamBtn(g, side) {
        var code = side ? g.a : g.h, win = g.winner === code;
        var prob = side ? 1 - g.prob : g.prob;
        var score = g.picked ? '' : '<b class="sc">' + (side ? g.ag : g.hg) + '</b>';
        var cls = 'ko-t' + (win ? ' win' : ' lose') + (code === state.focus ? ' me' : '');
        return '<button type="button" class="' + cls + '" data-k="' + g.key + '" data-c="' + code + '" aria-pressed="' + (!!g.picked && win) + '"' +
            ' title="' + name(code) + ' 승리로 정하기"><span class="nm">' + label(code) + '</span><span class="pr">' + Math.round(prob * 100) + '%</span>' + score + '</button>';
    }

    function note(g) {
        if (g.picked) return '<span class="ko-note pick">내 선택</span>';
        if (g.pens) return '<span class="ko-note">승부차기</span>';
        if (g.et) return '<span class="ko-note">연장</span>';
        return '';
    }

    function renderBracket() {
        $('ko_run').textContent = state.run ? '🎲 다시 돌리기' : '🎲 대회 한 번 돌려보기';
        $('ko_clear').hidden = !Object.keys(state.picks).length;
        if (!state.run) { $('ko').innerHTML = ''; return; }
        var b = buildBracket(), res = b.res, inR32 = {};
        res.r32.forEach(function (p) { inR32[p[0]] = inR32[p[1]] = true; });
        var rows = wc.groupNames.map(function (g) {
            return '<tr' + (g === wc.groupOf[state.focus] ? ' class="cur"' : '') + '><th scope="row">' + g + '조</th>' + res.ranks[g].map(function (c, i) {
                var badge = i === 2 ? (inR32[c] ? '<em class="adv">진출</em>' : '<em class="drop">탈락</em>') : '';
                return '<td class="' + (c === state.focus ? 'me' : '') + (inR32[c] ? '' : ' out') + '">' + label(c) + badge + '</td>';
            }).join('') + '</tr>';
        }).join('');
        $('ko').innerHTML = '<p class="ko-champ">🏆 우승 <strong>' + label(b.champion) + '</strong></p>' +
            '<h3 class="ko-sep"><span>토너먼트</span></h3>' +
            '<div class="scroll"><div class="bracket' + (ROUNDS.length === 5 ? ' five' : '') + '">' + b.rounds.map(function (games, r) {
                return '<div class="ko-col"><h3><span>' + ROUNDS[r] + '</span></h3><div class="ko-list">' + games.map(function (g) {
                    return '<div class="ko-m">' + teamBtn(g, 0) + teamBtn(g, 1) + note(g) + '</div>';
                }).join('') + '</div></div>';
            }).join('') + '</div></div>' +
            '<p class="hint">팀을 누르면 그 팀이 이긴 걸로 정하고 다음 라운드를 다시 치러요. 한 번 더 누르면 선택이 풀려요. 퍼센트는 그 경기에서 이길 확률이에요(연장·승부차기 포함).</p>' +
            '<h3 class="ko-sep"><span>조별리그</span></h3>' +
            '<div class="ko-box ko-wide"><h3>조별 순위 (3위는 상위 ' + (data.bestThirds || 8) + '팀만 ' + ROUNDS[0] + ')</h3><div class="scroll"><table class="ko-rt"><thead><tr><th scope="col">조</th><th scope="col">1위</th><th scope="col">2위</th><th scope="col">3위</th><th scope="col">4위</th></tr></thead><tbody>' + rows + '</tbody></table></div></div>';
    }

    // ---------- 전체 팀 확률과 실제 결과 ----------
    function renderAll() {
        var list = wc.codes.slice().sort(function (a, b) {
            var x = stat.teams[a], y = stat.teams[b];
            return y.champ - x.champ || y.final - x.final || y.sf - x.sf || y.qf - x.qf || y.r16 - x.r16 || y.r32 - x.r32 || y.pos[0] - x.pos[0];
        });
        $('all').innerHTML = '<table class="tbl lg-tbl nl-tbl"><thead><tr><th scope="col">순위</th><th scope="col">팀</th><th scope="col">조</th>' +
            ROUNDS.map(function (r) { return '<th scope="col">' + r + '</th>'; }).join('') + '<th scope="col">우승</th><th scope="col">실제 결과</th></tr></thead><tbody>' +
            list.map(function (c, i) {
                var s = stat.teams[c], a = teams[c].actual;
                return '<tr' + (c === state.focus ? ' class="me"' : '') + '><td class="rk">' + (i + 1) + '</td>' +
                    '<th scope="row"><button type="button" class="pick-team" data-team="' + c + '">' + label(c) + '</button></th><td>' + wc.groupOf[c] + '</td>' +
                    KEYS.map(function (k) { return s[k]; }).map(function (v) { return '<td class="p' + (v ? '' : ' nil') + '">' + pct2(v) + '</td>'; }).join('') +
                    '<td class="p strong">' + pct2(s.champ) + '</td>' +
                    '<td><span class="fate ' + (a === 'W' ? 'f-stay' : a === 'G' ? 'f-rel' : 'f-po') + '">' + ACTUAL[a] + '</span></td></tr>';
            }).join('') + '</tbody></table>';
    }

    function setupFocus() {
        $('focus').innerHTML = wc.groupNames.map(function (g) {
            return data.groups[g].slice().sort(function (a, b) { return teams[a].name < teams[b].name ? -1 : 1; }).map(function (c) {
                return '<option value="' + c + '"' + (c === state.focus ? ' selected' : '') + '>' + g + '조 · ' + name(c) + '</option>';
            }).join('');
        }).join('');
        $('focus').addEventListener('change', function () { setFocus(this.value); });
    }

    function setFocus(code) {
        state.focus = code;
        $('focus').value = code;
        render();
    }

    readHash();
    setupFocus();
    $('ko_run').addEventListener('click', function () {
        state.run = 1 + Math.floor(Math.random() * 2147483646);
        state.picks = {};
        renderBracket(); writeHash();
    });
    $('ko_clear').addEventListener('click', function () { state.picks = {}; renderBracket(); writeHash(); });
    $('ko').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-k]');
        if (!b) return;
        var key = b.dataset.k, code = b.dataset.c;
        if (state.picks[key] === code) delete state.picks[key]; else state.picks[key] = code;
        renderBracket(); writeHash();
    });
    $('all').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-team]');
        if (b) { setFocus(b.dataset.team); window.scrollTo({ top: 0, behavior: 'smooth' }); }
    });
    // 1만 번 계산(1초 안팎)은 화면을 먼저 그린 뒤에 해요
    $('big').classList.add('busy');
    setTimeout(function () {
        stat = wc.run(N);
        $('big').classList.remove('busy');
        render();
    }, 30);
})();
