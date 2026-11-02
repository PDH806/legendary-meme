// K리그 경우의 수 화면
// 주소 뒤 #s=1-2-0.3-1-1&t=USH&g=A 처럼 입력한 점수, 기준 팀, 보고 있는 파이널을 기억해서 링크로 공유해요
(function () {
    'use strict';

    var N = 10000;
    var data = window.LEAGUE_DATA;
    var lg = LeagueEngine.create(data);
    var teams = lg.teams;
    var state = { fixed: {}, focus: 'USH', split: 'A' };
    var stat = null, table = null, timer = 0;

    var $ = function (id) { return document.getElementById(id); };

    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function name(code) { return esc(teams[code].name); }
    function splitOf(code) { return data.splits.filter(function (s) { return s.teams.indexOf(code) >= 0; })[0]; }

    function decided() {
        return lg.matches.every(function (m) { return state.fixed[m.id] || data.results[m.id]; });
    }

    // 우승이 이미 확정됐으면 1위(와 우승 팀의 1~3위)는 남은 경기와 상관없이 확정이에요
    function settled(code, from) {
        return !!data.champion && (from === 1 || code === data.champion);
    }

    // 소수점 둘째 자리까지. 남은 경기가 있는데 1만 번 모두 그랬으면 확정이 아니라서 >99.99%
    function pct2(count, sure) {
        if (count === stat.n && !decided() && !sure) return '>99.99%';
        return (100 * count / stat.n).toFixed(2) + '%';
    }

    // 큰 숫자용 (맨 위)
    function pct(count, certain) {
        var sure = certain || decided();
        if (!count) return sure ? '0%' : '<0.1%';
        if (count === stat.n) return sure ? '100%' : '>99.9%';
        var p = 100 * count / stat.n;
        if (p < 0.1) return '<0.1%';
        if (p > 99.9) return '>99.9%';
        return (p >= 10 && p < 99.5 ? p.toFixed(0) : p.toFixed(1)) + '%';
    }

    // 순위 구간(예: 1~3위)에 든 횟수
    function zoneCount(code, zone) {
        if (zone.except && zone.except.indexOf(code) >= 0) return 0;
        var s = stat.teams[code], n = 0;
        for (var p = zone.from; p <= zone.to; p++) n += s.pos[p - 1];
        return n;
    }

    function zone(id) { return data.zones.filter(function (z) { return z.id === id; })[0]; }

    // 기준 팀에 가장 중요한 목표: 파이널 A는 ACL 엘리트 직행, 파이널 B는 승강 PO(12위)
    function goalOf(code) {
        if (code === data.champion) return null;
        return splitOf(code).id === 'A' ? zone('acl') : zone('rpo');
    }

    // 주소 ↔ 상태
    function readHash() {
        location.hash.replace(/^#/, '').split('&').forEach(function (part) {
            var kv = part.split('='), v = decodeURIComponent(kv[1] || '');
            if (kv[0] === 's') {
                v.split('.').forEach(function (x) {
                    var m = /^(\d+)-(\d{1,2})-(\d{1,2})$/.exec(x);
                    if (m && lg.matches.some(function (g) { return g.id === +m[1]; }) && !data.results[m[1]]) state.fixed[m[1]] = [+m[2], +m[3]];
                });
            }
            if (kv[0] === 't' && teams[v]) { state.focus = v; state.split = splitOf(v).id; }
            if (kv[0] === 'g' && (v === 'A' || v === 'B')) state.split = v;
        });
    }

    function writeHash() {
        var s = Object.keys(state.fixed).map(function (id) { return id + '-' + state.fixed[id].join('-'); }).join('.');
        history.replaceState(null, '', '#' + (s ? 's=' + s + '&' : '') + 't=' + state.focus + '&g=' + state.split);
    }

    function recalc() {
        $('big').classList.add('busy');
        clearTimeout(timer);
        timer = setTimeout(function () {
            stat = lg.run(N, state.fixed);
            table = lg.standings(state.fixed);
            render();
            $('big').classList.remove('busy');
        }, 30);
    }

    function render() {
        renderHero();
        renderTables();
        renderTabs();
        renderGames();
        writeHash();
    }

    function renderHero() {
        var c = state.focus, s = stat.teams[c], sp = splitOf(c), goal = goalOf(c);
        $('focus_name').textContent = teams[c].name;
        if (!goal) {
            $('focus_goal').textContent = '우승 확정 🏆';
            $('big').textContent = '1위';
        } else if (c === 'GCS') {
            $('focus_goal').textContent = '최하위(12위) 확률';
            $('big').textContent = pct(s.pos[11]);
        } else {
            $('focus_goal').textContent = goal.name + (goal.from === goal.to ? '(' + goal.from + '위)' : '(' + goal.from + '~' + goal.to + '위)') + ' 확률';
            $('big').textContent = pct(zoneCount(c, goal));
        }
        var chips = [];
        for (var p = sp.from; p < sp.from + sp.teams.length; p++) chips.push('<li><span>' + p + '위</span><b>' + pct(s.pos[p - 1], p === 1 && settled(c, 1)) + '</b></li>');
        $('stages').innerHTML = chips.join('');
        var note = data.notes && data.notes[c];
        $('focus_note').hidden = !note;
        $('focus_note').textContent = note || '';
        var cnt = Object.keys(state.fixed).length;
        $('scenario').textContent = (cnt ? '직접 넣은 점수 ' + cnt + '경기 반영 · ' : '남은 30경기 전부 시뮬레이션 · ') + '예상 최종 승점 ' + s.ptsAvg.toFixed(1);
    }

    function renderTables() {
        $('tables').innerHTML = data.splits.map(function (sp) {
            var order = table.order[sp.id];
            var started = order.some(function (c) { return table.tab[c].p > 33; });
            var posHead = sp.teams.map(function (_, i) {
                var p = sp.from + i, z = data.zones.filter(function (x) { return p >= x.from && p <= x.to; })[0];
                return '<th scope="col" class="pc' + (z ? ' z-' + z.id : '') + '"' + (z ? ' title="' + esc(z.name) + '"' : '') + '>' + p + '위</th>';
            }).join('');
            var goal = sp.id === 'A' ? zone('acl') : zone('rpo');
            var rows = order.map(function (c, i) {
                var t = table.tab[c], s = stat.teams[c];
                var cells = sp.teams.map(function (_, k) {
                    var p = sp.from + k, z = data.zones.filter(function (x) { return p >= x.from && p <= x.to && !(x.except && x.except.indexOf(c) >= 0); })[0];
                    var v = s.pos[p - 1];
                    return '<td class="p pc' + (z ? ' z-' + z.id : '') + (v ? '' : ' nil') + '">' + pct2(v, p === 1 && settled(c, 1)) + '</td>';
                }).join('');
                var g = zoneCount(c, goal);
                return '<tr' + (c === state.focus ? ' class="me"' : '') + '><td class="rk">' + (sp.from + i) + '</td>' +
                    '<th scope="row"><button type="button" class="pick-team" data-team="' + c + '">' + name(c) + '</button></th>' +
                    '<td>' + t.p + '</td><td class="strong-n">' + t.pts + '</td><td>' + t.gf + '</td><td>' + (t.gd > 0 ? '+' : '') + t.gd + '</td>' +
                    '<td>' + s.ptsAvg.toFixed(1) + '</td>' + cells +
                    '<td class="p strong">' + pct2(g, settled(c, goal.from)) + '<span class="bar" style="--w:' + (g ? Math.max(2, 100 * g / stat.n).toFixed(1) : 0) + '%"></span></td></tr>';
            }).join('');
            return '<h3 class="split-title">' + esc(sp.name) + ' <small>' + sp.from + '~' + (sp.from + sp.teams.length - 1) + '위' + (data.updated ? ' · 결과 반영 ' + esc(data.updated.replace(/^\d{4}-0?(\d+)-0?(\d+)/, '$1.$2')) : (started ? '' : ' · 33라운드 기준')) + '</small></h3>' +
                '<div class="scroll"><table class="tbl lg-tbl"><thead><tr><th scope="col">순위</th><th scope="col">팀</th><th scope="col">경기</th><th scope="col">승점</th><th scope="col">득점</th><th scope="col">득실</th><th scope="col" title="1만 번 시뮬레이션의 평균 최종 승점">예상 승점</th>' +
                posHead + '<th scope="col">' + esc(goal.short) + '</th></tr></thead><tbody>' + rows + '</tbody></table></div>';
        }).join('') + (table.ties.length ? '<p class="tie">' + table.ties.map(function (t) { return t.map(name).join(', '); }).join(' / ') + ' 은(는) 지금 모든 기준에서 동률이에요.</p>' : '') +
            '<p class="legend"><span class="z-acl">ACL 엘리트 직행</span><span class="z-aclpo">ACL 엘리트 PO</span><span class="z-rpo">승강 PO</span></p>';
    }

    function renderTabs() {
        $('tabs').innerHTML = data.splits.map(function (sp) {
            var on = sp.id === state.split;
            return '<button type="button" data-g="' + sp.id + '"' + (on ? ' class="on" aria-current="true"' : '') + '>' + esc(sp.name) + '</button>';
        }).join('');
    }

    function renderGames() {
        var games = lg.matches.filter(function (m) { return m.split === state.split; });
        var html = '<ol class="games">' + games.map(function (m) {
            var real = data.results[m.id], fix = state.fixed[m.id], p = lg.matchProbs(m.id);
            var when = m.date.replace(/^\d{4}-(\d\d)-(\d\d)$/, function (_, mo, d) { return (+mo) + '.' + (+d); });
            var score;
            if (real) score = '<span class="final">' + real[0] + ' : ' + real[1] + '</span>';
            else {
                var v = fix || ['', ''];
                score = '<input type="number" inputmode="numeric" min="0" max="20" data-id="' + m.id + '" data-side="0" value="' + v[0] + '" aria-label="' + name(m.h) + ' 득점">' +
                    '<span class="colon">:</span>' +
                    '<input type="number" inputmode="numeric" min="0" max="20" data-id="' + m.id + '" data-side="1" value="' + v[1] + '" aria-label="' + name(m.a) + ' 득점">';
            }
            var odds = real || fix ? '' : '<span class="odds">' + Math.round(100 * p[0]) + ' · ' + Math.round(100 * p[1]) + ' · ' + Math.round(100 * p[2]) + '</span>';
            return '<li class="' + (fix ? 'fixed' : '') + '"><span class="md"><b>' + m.round + 'R</b> <time>' + esc(when) + '</time></span>' +
                '<span class="h' + (m.h === state.focus ? ' me' : '') + '">' + name(m.h) + '</span><span class="score">' + score + '</span>' +
                '<span class="a' + (m.a === state.focus ? ' me' : '') + '">' + name(m.a) + '</span>' + odds + '</li>';
        }).join('') + '</ol>';
        var active = document.activeElement;
        var keep = active && active.dataset && active.dataset.id ? '[data-id="' + active.dataset.id + '"][data-side="' + active.dataset.side + '"]' : '';
        $('games').innerHTML = html;
        if (keep) { var el = $('games').querySelector('input' + keep); if (el) el.focus(); }
    }

    function setupFocus() {
        $('focus').innerHTML = data.splits.map(function (sp) {
            return sp.teams.map(function (c) {
                return '<option value="' + c + '"' + (c === state.focus ? ' selected' : '') + '>' + esc(sp.name) + ' · ' + name(c) + '</option>';
            }).join('');
        }).join('');
        $('focus').addEventListener('change', function () { setFocus(this.value); });
    }

    function setFocus(code) {
        state.focus = code;
        state.split = splitOf(code).id;
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
        state.split = b.dataset.g;
        renderTabs(); renderGames(); writeHash();
    });
    $('tables').addEventListener('click', function (e) { // 표에서 팀 이름을 누르면 기준 팀으로
        var b = e.target.closest('button[data-team]');
        if (b) setFocus(b.dataset.team);
    });
    $('reset').addEventListener('click', function () { state.fixed = {}; recalc(); });
    $('share').addEventListener('click', function () {
        writeHash();
        if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(location.href).then(function () { toast('링크를 복사했어요'); }, function () { toast(location.href); });
        else toast(location.href);
    });
    recalc();
})();
