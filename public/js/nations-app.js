// 네이션스리그 리그 A 경우의 수 화면
// 주소 뒤 #s=3-0-2.12-1-1&t=GER&g=2 처럼 입력한 점수, 기준 팀, 보고 있는 조를 기억해서 링크로 공유해요
(function () {
    'use strict';

    var N = 10000;
    var data = window.UNL_DATA;
    var nl = NationsEngine.create(data);
    var teams = nl.teams;
    var state = { fixed: {}, focus: 'GER', group: '2' };
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
        });
    }

    function writeHash() {
        var s = Object.keys(state.fixed).map(function (id) { return id + '-' + state.fixed[id].join('-'); }).join('.');
        history.replaceState(null, '', '#' + (s ? 's=' + s + '&' : '') + 't=' + state.focus + '&g=' + state.group);
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
        renderTables();
        renderCross();
        renderTabs();
        renderGames();
        writeHash();
    }

    function renderHero() {
        var c = state.focus, s = stat.teams[c];
        $('focus_name').innerHTML = label(c);
        $('big').textContent = pct(s.qf);
        var chips = [['조 1위', s.pos[0]], ['4강', s.sf], ['우승', s.champ]].concat(FATES.slice(1).map(function (f) { return [f.name, s[f.id]]; }));
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
    $('share').addEventListener('click', function () {
        writeHash();
        if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(location.href).then(function () { toast('링크를 복사했어요'); }, function () { toast(location.href); });
        else toast(location.href);
    });
    recalc();
})();
