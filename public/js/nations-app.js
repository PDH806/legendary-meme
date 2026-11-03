// 네이션스리그 리그 A 경우의 수 화면
// 주소 뒤 #s=3-0-2.12-1-1&t=GER&g=2 처럼 입력한 점수, 기준 팀, 보고 있는 조를 기억해서 링크로 공유해요
(function () {
    'use strict';

    var N = 10000;
    var data = window.UNL_DATA;
    var nl = NationsEngine.create(data);
    var teams = nl.teams;
    var state = { fixed: {}, focus: 'GER', group: '2', run: 0, picks: {} };
    var stat = null, table = null, timer = 0;

    var FATES = [
        { id: 'qf', name: '8강 진출', short: '8강' },
        { id: 'stay', name: '3위 잔류', short: '잔류' },
        { id: 'po', name: '승강 PO', short: 'PO' },
        { id: 'rel', name: '리그 B 강등', short: '강등' }
    ];

    var $ = function (id) { return document.getElementById(id); };

    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function name(code) { return esc(teams[code].name); }

    // 국기 + 이름 (국기 출처: flag-icons, MIT). after면 국기를 이름 뒤에 (경기 목록 홈팀)
    function label(code, after) {
        var img = '<img class="flag" src="img/flags/' + teams[code].flag + '.svg" alt="" width="20" height="15">';
        return after ? name(code) + img : img + name(code);
    }

    // 소수점 둘째 자리까지 (1만 번 중 나온 비율 그대로, > < 표시 없이)
    function pct2(count) {
        return (100 * count / stat.n).toFixed(2) + '%';
    }

    // 큰 숫자용 (맨 위): 0%·100%는 그대로, 1% 미만·99% 이상은 둘째 자리, 그 사이는 짧게
    function pct(count) {
        if (!count) return '0%';
        if (count === stat.n) return '100%';
        var p = 100 * count / stat.n;
        if (p < 1 || p >= 99) return p.toFixed(2) + '%';
        return (p >= 10 ? p.toFixed(0) : p.toFixed(1)) + '%';
    }

    function readHash() {
        location.hash.replace(/^#/, '').split('&').forEach(function (part) {
            var kv = part.split('='), v = decodeURIComponent(kv[1] || '');
            if (kv[0] === 's') {
                v.split('.').forEach(function (x) {
                    var m = /^(\d+)-(\d{1,2})-(\d{1,2})$/.exec(x);
                    if (m && nl.matches.some(function (g) { return g.id === +m[1]; }) && !data.results[m[1]]) state.fixed[m[1]] = [+m[2], +m[3]];
                });
            }
            if (kv[0] === 't' && teams[v]) { state.focus = v; state.group = nl.groupOf[v]; }
            if (kv[0] === 'g' && data.groups[v]) state.group = v;
            if (kv[0] === 'r' && /^\d{1,10}$/.test(v)) state.run = +v;
            if (kv[0] === 'k') v.split('.').forEach(function (x) {
                var m = /^(\d)-(\d)-([A-Z]{3})$/.exec(x);
                if (m && teams[m[3]]) state.picks[m[1] + '-' + m[2]] = m[3];
            });
        });
    }

    function writeHash() {
        var s = Object.keys(state.fixed).map(function (id) { return id + '-' + state.fixed[id].join('-'); }).join('.');
        var k = Object.keys(state.picks).map(function (key) { return key + '-' + state.picks[key]; }).join('.');
        history.replaceState(null, '', '#' + (s ? 's=' + s + '&' : '') + 't=' + state.focus + '&g=' + state.group +
            (state.run ? '&r=' + state.run : '') + (k ? '&k=' + k : ''));
    }

    function recalc() {
        $('big').classList.add('busy');
        clearTimeout(timer);
        timer = setTimeout(function () {
            stat = nl.run(N, state.fixed);
            table = nl.standings(state.fixed);
            render();
            $('big').classList.remove('busy');
        }, 30);
    }

    function render() {
        renderHero();
        renderChampBars();
        renderBracket();
        renderTables();
        renderCross();
        renderTabs();
        renderGames();
        writeHash();
    }

    function renderHero() {
        var c = state.focus, s = stat.teams[c];
        $('focus_name').innerHTML = label(c);
        $('big').textContent = pct(s.champ);
        var chips = [['8강 진출', s.qf], ['4강', s.sf], ['결승', s.final]].concat(FATES.slice(1).map(function (f) { return [f.name, s[f.id]]; }));
        $('stages').innerHTML = chips.map(function (x) { return '<li><span>' + x[0] + '</span><b>' + pct(x[1]) + '</b></li>'; }).join('');
        var cnt = Object.keys(state.fixed).length, left = nl.matches.filter(function (m) { return !data.results[m.id]; }).length;
        $('scenario').textContent = (cnt ? '직접 넣은 점수 ' + cnt + '경기 반영 · ' : '남은 ' + left + '경기 전부 시뮬레이션 · ') + '예상 최종 승점 ' + s.ptsAvg.toFixed(1);
    }

    function renderTables() {
        $('tables').innerHTML = nl.groupIds.map(function (g) {
            var rows = table.order[g].map(function (c, i) {
                var t = table.tab[c], s = stat.teams[c];
                var cells = s.pos.map(function (v, k) {
                    return '<td class="p pc' + (k < 2 ? ' z-acl' : k === 3 ? ' z-rpo' : '') + (v ? '' : ' nil') + '">' + pct2(v) + '</td>';
                }).join('');
                return '<tr' + (c === state.focus ? ' class="me"' : '') + '><td class="rk">' + (i + 1) + '</td>' +
                    '<th scope="row"><button type="button" class="pick-team" data-team="' + c + '">' + label(c) + '</button></th>' +
                    '<td>' + t.p + '</td><td class="strong-n">' + t.pts + '</td><td>' + (t.gd > 0 ? '+' : '') + t.gd + '</td><td>' + t.gf + '</td>' +
                    cells +
                    '<td class="p strong">' + pct2(s.qf) + '<span class="bar" style="--w:' + (s.qf ? Math.max(2, 100 * s.qf / stat.n).toFixed(1) : 0) + '%"></span></td>' +
                    [s.sf, s.final, s.champ].map(function (v) { return '<td class="p' + (v ? '' : ' nil') + '">' + pct2(v) + '</td>'; }).join('') +
                    '<td class="p' + (s.po ? '' : ' nil') + '">' + pct2(s.po) + '</td>' +
                    '<td class="p' + (s.rel ? '' : ' nil') + '">' + pct2(s.rel) + '</td></tr>';
            }).join('');
            return '<h3 class="split-title">' + g + '조</h3>' +
                '<div class="scroll"><table class="tbl lg-tbl nl-tbl"><thead><tr><th scope="col">순위</th><th scope="col">팀</th><th scope="col">경기</th><th scope="col">승점</th><th scope="col">득실</th><th scope="col">득점</th>' +
                '<th scope="col" class="pc z-acl">1위</th><th scope="col" class="pc z-acl">2위</th><th scope="col" class="pc">3위</th><th scope="col" class="pc z-rpo">4위</th>' +
                '<th scope="col">8강</th><th scope="col">4강</th><th scope="col">결승</th><th scope="col">우승</th><th scope="col">승강 PO</th><th scope="col">강등</th></tr></thead><tbody>' + rows + '</tbody></table></div>';
        }).join('') + '<p class="legend"><span class="z-acl">1·2위: 8강 진출</span><span class="z-rpo">4위: 승강 PO 또는 강등</span></p>';
    }

    // ---------- 토너먼트 ----------

    // 우승 확률 상위 8팀 막대 (기준 팀이 8위 밖이면 맨 아래에 더해요)
    function renderChampBars() {
        var list = nl.codes.slice().sort(function (a, b) { return stat.teams[b].champ - stat.teams[a].champ; });
        var top = list.slice(0, 8);
        if (top.indexOf(state.focus) < 0) top.push(state.focus);
        var max = stat.teams[list[0]].champ || 1;
        $('champ_bars').innerHTML = top.map(function (c) {
            var v = stat.teams[c].champ;
            return '<li' + (c === state.focus ? ' class="me"' : '') + '><span class="rk">' + (list.indexOf(c) + 1) + '</span><span class="t">' + label(c) + '</span><span class="v">' + pct2(v) + '</span>' +
                '<span class="track"><span class="fill" style="width:' + (v ? Math.max(1.5, 100 * v / max) : 0).toFixed(1) + '%"></span></span></li>';
        }).join('');
    }

    var ROUNDS = ['8강', '4강', '결승'];

    // 문자열 → 32비트 시드 (FNV-1a). 같은 링크면 같은 대진표가 나와요
    function hash(str) {
        var h = 2166136261;
        for (var i = 0; i < str.length; i++) { h ^= str.charCodeAt(i); h = Math.imul(h, 16777619); }
        return h >>> 0;
    }

    // 사용자가 고른 승자를 먼저 반영하고, 나머지는 시드로 치러요
    function buildBracket() {
        var res = nl.draw(state.fixed, state.run);
        var rounds = [], pairs = res.ties;
        for (var r = 0; r < ROUNDS.length; r++) {
            var games = pairs.map(function (p, i) {
                var key = r + '-' + i, pick = state.picks[key];
                if (pick && pick !== p[0] && pick !== p[1]) { delete state.picks[key]; pick = null; } // 위 라운드가 바뀌어 없는 팀이면 지워요
                var seed = hash(state.run + '|' + key + '|' + p[0] + '|' + p[1]);
                var g = pick ? { h: p[0], a: p[1], winner: pick, picked: true }
                    : r === 0 ? nl.playTie(p[0], p[1], seed) : nl.playSingle(p[0], p[1], seed);
                g.key = key;
                g.prob = r === 0 ? nl.tieProb(p[0], p[1]) : nl.singleProb(p[0], p[1]);
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

    // 8강 두 경기 점수 (1차전은 조 2위 팀 홈)
    function legs(g) {
        if (!g.legs) return '';
        return '<p class="ko-legs">1차 ' + name(g.a) + ' 홈 ' + g.legs[0][0] + ':' + g.legs[0][1] + ' · 2차 ' + name(g.h) + ' 홈 ' + g.legs[1][0] + ':' + g.legs[1][1] + '</p>';
    }

    function renderBracket() {
        $('ko_run').textContent = state.run ? '🎲 다시 돌리기' : '🎲 대회 한 번 돌려보기';
        $('ko_clear').hidden = !Object.keys(state.picks).length;
        if (!state.run) { $('ko').innerHTML = ''; return; }
        var b = buildBracket();
        var rows = nl.groupIds.map(function (g) {
            return '<tr' + (g === nl.groupOf[state.focus] ? ' class="cur"' : '') + '><th scope="row">' + g + '조</th>' + b.res.order[g].map(function (c, i) {
                var f = b.res.fate[c], badge = f === 'qf' ? '' : '<em class="' + (f === 'stay' ? 'adv' : 'drop') + '">' + (f === 'stay' ? '잔류' : f === 'po' ? 'PO' : '강등') + '</em>';
                return '<td class="' + (c === state.focus ? 'me' : '') + (i > 1 ? ' out' : '') + '">' + label(c) + badge + '</td>';
            }).join('') + '</tr>';
        }).join('');
        var html = '<p class="ko-champ">🏆 우승 <strong>' + label(b.champion) + '</strong></p>' +
            '<h3 class="ko-sep"><span>리그 단계</span></h3>' +
            '<div class="ko-box ko-wide"><h3>리그 단계 최종 순위</h3><div class="scroll"><table class="ko-rt"><thead><tr><th scope="col">조</th><th scope="col">1위</th><th scope="col">2위</th><th scope="col">3위</th><th scope="col">4위</th></tr></thead><tbody>' + rows + '</tbody></table></div></div>' +
            '<h3 class="ko-sep"><span>토너먼트</span></h3>' +
            '<div class="scroll"><div class="bracket three">' + b.rounds.map(function (games, r) {
                return '<div class="ko-col"><h3><span>' + ROUNDS[r] + '</span></h3><div class="ko-list">' + games.map(function (g) {
                    return '<div class="ko-wrap"><div class="ko-m">' + teamBtn(g, 0) + teamBtn(g, 1) + note(g) + '</div>' + legs(g) + '</div>';
                }).join('') + '</div></div>';
            }).join('') + '</div></div>' +
            '<p class="hint">8강은 두 경기 합산 점수예요(위가 조 1위 팀). 팀을 누르면 그 팀이 이긴 걸로 정하고 다음 라운드를 다시 치러요. 한 번 더 누르면 선택이 풀려요. 퍼센트는 그 대진에서 올라갈 확률이에요(연장·승부차기 포함).</p>';
        $('ko').innerHTML = html;
    }

    // 지금 순위 기준 3위끼리, 4위끼리 비교
    function crossTable(title, list, fates) {
        var rows = list.map(function (c, i) {
            var t = table.tab[c];
            return '<tr' + (c === state.focus ? ' class="me"' : '') + '><td class="rk">' + (i + 1) + '</td>' +
                '<th scope="row"><button type="button" class="pick-team" data-team="' + c + '">' + label(c) + '</button> <small class="grp">' + nl.groupOf[c] + '조</small></th>' +
                '<td>' + t.p + '</td><td class="strong-n">' + t.pts + '</td><td>' + (t.gd > 0 ? '+' : '') + t.gd + '</td><td>' + t.gf + '</td>' +
                '<td><span class="fate f-' + fates[i].id + '">' + fates[i].name + '</span></td></tr>';
        }).join('');
        return '<div class="cross-col"><h3 class="split-title">' + title + '</h3><div class="scroll"><table class="tbl lg-tbl"><thead><tr><th scope="col">순위</th><th scope="col">팀</th><th scope="col">경기</th><th scope="col">승점</th><th scope="col">득실</th><th scope="col">득점</th><th scope="col">결과</th></tr></thead><tbody>' + rows + '</tbody></table></div></div>';
    }

    function renderCross() {
        var stay = FATES[1], po = FATES[2], rel = FATES[3];
        $('cross').innerHTML = crossTable('조 3위 팀 비교', table.thirds, [stay, stay, po, po]) +
            crossTable('조 4위 팀 비교', table.fourths, [po, po, rel, rel]);
    }

    function renderTabs() {
        $('tabs').innerHTML = nl.groupIds.map(function (g) {
            var on = g === state.group;
            return '<button type="button" data-g="' + g + '"' + (on ? ' class="on" aria-current="true"' : '') + '>' + g + '조</button>';
        }).join('');
    }

    function renderGames() {
        var games = nl.matches.filter(function (m) { return m.g === state.group; });
        var html = '<ol class="games">' + games.map(function (m) {
            var real = data.results[m.id], fix = state.fixed[m.id], p = nl.matchProbs(m.id);
            var when = m.date.replace(/^\d{4}-(\d\d)-(\d\d) (\d\d:\d\d)$/, function (_, mo, d, hm) { return (+mo) + '.' + (+d) + ' ' + hm; });
            var score;
            if (real) score = '<span class="final">' + real[0] + ' : ' + real[1] + '</span>';
            else {
                var v = fix || ['', ''];
                score = '<input type="number" inputmode="numeric" min="0" max="20" data-id="' + m.id + '" data-side="0" value="' + v[0] + '" aria-label="' + name(m.h) + ' 득점">' +
                    '<span class="colon">:</span>' +
                    '<input type="number" inputmode="numeric" min="0" max="20" data-id="' + m.id + '" data-side="1" value="' + v[1] + '" aria-label="' + name(m.a) + ' 득점">';
            }
            var odds = real || fix ? '' : '<span class="odds">' + Math.round(100 * p[0]) + ' · ' + Math.round(100 * p[1]) + ' · ' + Math.round(100 * p[2]) + '</span>';
            return '<li class="' + (fix ? 'fixed' : '') + '"><span class="md"><b>' + m.md + '차전</b> <time>' + esc(when) + '</time></span>' +
                '<span class="h' + (m.h === state.focus ? ' me' : '') + '">' + label(m.h, true) + '</span><span class="score">' + score + '</span>' +
                '<span class="a' + (m.a === state.focus ? ' me' : '') + '">' + label(m.a) + '</span>' + odds + '</li>';
        }).join('') + '</ol>';
        var active = document.activeElement;
        var keep = active && active.dataset && active.dataset.id ? '[data-id="' + active.dataset.id + '"][data-side="' + active.dataset.side + '"]' : '';
        $('games').innerHTML = html;
        if (keep) { var el = $('games').querySelector('input' + keep); if (el) el.focus(); }
    }

    function setupFocus() {
        $('focus').innerHTML = nl.groupIds.map(function (g) {
            return nl.groups[g].map(function (c) {
                return '<option value="' + c + '"' + (c === state.focus ? ' selected' : '') + '>' + g + '조 · ' + name(c) + '</option>';
            }).join('');
        }).join('');
        $('focus').addEventListener('change', function () { setFocus(this.value); });
    }

    function setFocus(code) {
        state.focus = code;
        state.group = nl.groupOf[code];
        $('focus').value = code;
        render();
    }

    function onScore(e) {
        var el = e.target;
        if (!el.matches('input[data-id]')) return;
        var id = el.dataset.id, inputs = document.querySelectorAll('input[data-id="' + id + '"]');
        var a = inputs[0].value, b = inputs[1].value;
        var valid = function (v) { return /^\d{1,2}$/.test(v) && +v <= 20; };
        var before = JSON.stringify(state.fixed[id] || null);
        if (valid(a) && valid(b)) state.fixed[id] = [+a, +b]; else delete state.fixed[id];
        if (before !== JSON.stringify(state.fixed[id] || null)) recalc();
    }

    function toast(msg) {
        var t = $('toast');
        t.textContent = msg; t.hidden = false;
        clearTimeout(toast.timer);
        toast.timer = setTimeout(function () { t.hidden = true; }, 2500);
    }

    readHash();
    setupFocus();
    $('games').addEventListener('input', onScore);
    $('tabs').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-g]');
        if (!b) return;
        state.group = b.dataset.g;
        renderTabs(); renderGames(); writeHash();
    });
    [$('tables'), $('cross')].forEach(function (el) {
        el.addEventListener('click', function (e) { // 표에서 팀 이름을 누르면 기준 팀으로
            var b = e.target.closest('button[data-team]');
            if (b) setFocus(b.dataset.team);
        });
    });
    $('reset').addEventListener('click', function () { state.fixed = {}; recalc(); });
    $('ko_run').addEventListener('click', function () {
        state.run = 1 + Math.floor(Math.random() * 2147483646);
        state.picks = {};
        renderBracket(); writeHash();
    });
    $('ko_clear').addEventListener('click', function () { state.picks = {}; renderBracket(); writeHash(); });
    $('ko').addEventListener('click', function (e) { // 팀을 누르면 그 팀 승리로, 다시 누르면 풀기
        var b = e.target.closest('button[data-k]');
        if (!b) return;
        var key = b.dataset.k, code = b.dataset.c;
        if (state.picks[key] === code) delete state.picks[key]; else state.picks[key] = code;
        renderBracket(); writeHash();
    });
    $('share').addEventListener('click', function () {
        writeHash();
        if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(location.href).then(function () { toast('링크를 복사했어요'); }, function () { toast(location.href); });
        else toast(location.href);
    });
    recalc();
})();
