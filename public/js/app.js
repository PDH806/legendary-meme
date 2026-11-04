// 경우의 수 화면
// 주소 뒤 #s=8-2-0.21-1-1&t=KOR&g=E 처럼 입력한 점수, 기준 팀, 보고 있는 조를 기억해서 링크로 공유해요
// 토너먼트 시뮬레이션은 &r=시드&k=0-3-KOR.1-0-JPN (라운드-순서-고른 팀)으로 기억해요
(function () {
    'use strict';

    var N = 10000;
    var data = window.CUP_DATA;
    var cup = CupEngine.create(data);
    var teams = cup.teams;
    var state = { fixed: {}, focus: data.focus, group: data.teams[data.focus].group, run: 0, picks: {} };
    var stat = null, table = null, timer = 0;

    var $ = function (id) { return document.getElementById(id); };

    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function name(code) { return esc(teams[code].name); }

    // 국기 + 이름 (국기 출처: flag-icons, MIT). after면 국기를 이름 뒤에 (경기 목록 홈팀), short면 짧은 이름 (대진표)
    function label(code, after, short) {
        var f = teams[code].flag;
        var img = f ? '<img class="flag" src="img/flags/' + f + '.svg" alt="" width="20" height="15">' : '';
        var nm = short && teams[code].short ? esc(teams[code].short) : name(code);
        return after ? nm + img : img + nm;
    }

    // 조별리그 경기가 모두 끝났거나 점수가 정해졌는지
    function groupDecided() {
        return cup.matches.every(function (m) { return state.fixed[m.id] || data.results[m.id]; });
    }

    // 확률 글자: 기호 없이 숫자만. 1% 미만·99% 이상은 소수점 둘째 자리까지
    function pct(count, total) {
        total = total || stat.n;
        if (!count) return '0%';
        if (count === total) return '100%';
        var p = 100 * count / total;
        if (p < 1 || p >= 99) return p.toFixed(2) + '%';
        return (p >= 10 ? p.toFixed(0) : p.toFixed(1)) + '%';
    }

    // 전체 팀 확률 표용: 소수점 둘째 자리까지 (1만 회라 0.01%가 한 번)
    function pct2(count) {
        return (100 * count / stat.n).toFixed(2) + '%';
    }

    function bar(count, total) {
        var p = count ? Math.max(2, 100 * count / (total || stat.n)) : 0;
        return '<span class="bar" style="--w:' + p.toFixed(1) + '%"></span>';
    }

    // 주소 ↔ 상태
    function readHash() {
        var h = location.hash.replace(/^#/, '');
        h.split('&').forEach(function (part) {
            var kv = part.split('='), v = decodeURIComponent(kv[1] || '');
            if (kv[0] === 's') {
                v.split('.').forEach(function (x) {
                    var m = /^(\d+)-(\d{1,2})-(\d{1,2})$/.exec(x);
                    if (m && cup.matches.some(function (g) { return g.id === +m[1]; }) && !data.results[m[1]]) {
                        state.fixed[m[1]] = [+m[2], +m[3]];
                    }
                });
            }
            if (kv[0] === 't' && teams[v]) state.focus = v;
            if (kv[0] === 'g' && cup.groups[v]) state.group = v;
            if (kv[0] === 'r' && /^\d{1,10}$/.test(v)) state.run = +v;
            if (kv[0] === 'k') {
                v.split('.').forEach(function (x) {
                    var m = /^([0-3])-([0-7])-([A-Z]{3})$/.exec(x);
                    if (m && teams[m[3]]) state.picks[m[1] + '-' + m[2]] = m[3];
                });
            }
        });
    }

    function writeHash() {
        var s = Object.keys(state.fixed).map(function (id) { return id + '-' + state.fixed[id].join('-'); }).join('.');
        var h = (s ? 's=' + s + '&' : '') + 't=' + state.focus + '&g=' + state.group;
        if (state.run) {
            var k = Object.keys(state.picks).map(function (key) { return key + '-' + state.picks[key]; }).join('.');
            h += '&r=' + state.run + (k ? '&k=' + k : '');
        }
        history.replaceState(null, '', '#' + h);
    }

    function recalc() {
        $('big_r16').classList.add('busy');
        clearTimeout(timer);
        timer = setTimeout(function () { // 화면을 먼저 그리고 계산해요
            stat = cup.run(N, state.fixed);
            table = cup.standings(state.fixed);
            render();
            $('big_r16').classList.remove('busy');
        }, 30);
    }

    function render() {
        renderHero();
        renderChampBars();
        renderOpp();
        renderTabs();
        renderGroup();
        renderAll();
        if (window.CupBracket) window.CupBracket.render(); // 점수나 기준 팀이 바뀌면 대진표도 다시 그려요
        writeHash();
    }

    function renderHero() {
        var s = stat.teams[state.focus];
        $('focus_name').textContent = teams[state.focus].name;
        $('big_r16').textContent = pct(s.champ);
        var stages = [['조 1위', s.pos[0]], ['16강', s.r16], ['8강', s.qf], ['4강', s.sf], ['결승', s.final]];
        $('stages').innerHTML = stages.map(function (x) {
            return '<li><span>' + x[0] + '</span><b>' + pct(x[1]) + '</b></li>';
        }).join('');
        var cnt = Object.keys(state.fixed).length;
        $('scenario').textContent = cnt
            ? '직접 넣은 점수 ' + cnt + '경기를 반영했어요 · 1만 회 시뮬레이션'
            : '남은 경기 전부 시뮬레이션 · 1만 회';
    }

    // 우승 확률 상위 8팀 막대 (기준 팀이 8위 밖이면 맨 아래에 더해요)
    function renderChampBars() {
        var list = Object.keys(teams).sort(function (a, b) { return stat.teams[b].champ - stat.teams[a].champ; });
        var top = list.slice(0, 8);
        if (top.indexOf(state.focus) < 0) top.push(state.focus);
        var max = stat.teams[list[0]].champ || 1;
        $('champ_bars').innerHTML = top.map(function (c) {
            var v = stat.teams[c].champ;
            return '<li' + (c === state.focus ? ' class="me"' : '') + '><span class="rk">' + (list.indexOf(c) + 1) + '</span><span class="t">' + label(c) + '</span><span class="v">' + pct2(v) + '</span>' +
                '<span class="track"><span class="fill" style="width:' + (v ? Math.max(1.5, 100 * v / max) : 0).toFixed(1) + '%"></span></span></li>';
        }).join('');
    }

    function renderOpp() {
        var s = stat.teams[state.focus];
        var labels = ['조 1위', '조 2위', '조 3위'];
        $('opp').innerHTML = labels.map(function (title, pos) {
            var map = s.oppByPos[pos];
            var advance = Object.keys(map).reduce(function (a, c) { return a + map[c]; }, 0);
            var head = '<div class="opp-head"><h3>' + title + '</h3><span class="chance">' + pct(s.pos[pos]) + '</span></div>';
            if (!advance) {
                return '<div class="opp-col">' + head + '<p class="none">' + (pos === 2 ? '3위로는 16강에 못 가요' : '이 순위가 될 가능성이 거의 없어요') + '</p></div>';
            }
            var list = Object.keys(map).sort(function (a, b) { return map[b] - map[a]; }).slice(0, 4);
            var sub = pos === 2 ? '<p class="sub">3위 중 상위 4팀에 들 확률 ' + pct(advance, s.pos[pos]) + '</p>' : '<p class="sub">이 순위일 때 16강 상대</p>';
            // 이름·확률 줄 아래에 얇은 막대. 1순위 상대는 진하게, 나머지는 점점 옅게
            return '<div class="opp-col">' + head + sub + '<ol class="opp-list">' + list.map(function (c, i) {
                var w = Math.max(2, 100 * map[c] / advance).toFixed(1);
                return '<li class="r' + i + '"><span class="t">' + label(c) + '</span><span class="v">' + pct(map[c], advance) + '</span>' +
                    '<span class="track"><span class="fill" style="width:' + w + '%"></span></span></li>';
            }).join('') + '</ol></div>';
        }).join('');
    }

    function renderTabs() {
        $('tabs').innerHTML = cup.groupNames.map(function (g) {
            var on = g === state.group;
            return '<button type="button" data-g="' + g + '"' + (on ? ' class="on" aria-current="true"' : '') + '>' + g + '조</button>';
        }).join('');
    }

    function renderGroup() {
        var g = state.group;
        var order = table.ranks[g];
        var tl = table.tallies[g];
        var tie = table.ties.filter(function (t) {
            return teams[t.teams[0]].group === g && tl[t.teams[0]].p > 0;
        });
        var started = order.some(function (c) { return tl[c].p > 0; });
        var rows = order.map(function (c, i) {
            var t = tl[c], s = stat.teams[c];
            var cls = c === state.focus ? ' class="me"' : '';
            return '<tr' + cls + '><td class="rk">' + (started ? i + 1 : '-') + '</td>' +
                '<th scope="row">' + label(c) + '</th>' +
                '<td>' + t.p + '</td><td>' + t.pts + '</td><td>' + (t.gd > 0 ? '+' : '') + t.gd + '</td>' +
                '<td class="p">' + pct2(s.pos[0]) + '</td><td class="p">' + pct2(s.pos[1]) + '</td><td class="p">' + pct2(s.pos[2]) + '</td>' +
                '<td class="p strong">' + pct2(s.r16) + bar(s.r16) + '</td></tr>';
        }).join('');
        var html = '<div class="scroll"><table class="tbl"><thead><tr><th scope="col">순위</th><th scope="col">팀</th><th scope="col">경기</th><th scope="col">승점</th><th scope="col">득실</th>' +
            '<th scope="col">1위</th><th scope="col">2위</th><th scope="col">3위</th><th scope="col">16강</th></tr></thead><tbody>' + rows + '</tbody></table></div>';
        if (tie.length) {
            html += '<p class="tie">' + tie.map(function (t) {
                return t.teams.map(name).join(', ') + '이(가) 모든 기준에서 동률이에요 (' + (t.shootout ? '승부차기로 결정' : '페어플레이·추첨으로 결정') + ')';
            }).join('<br>') + '</p>';
        }
        var games = cup.matches.filter(function (m) { return m.group === g; });
        html += '<ol class="games">' + games.map(gameRow).join('') + '</ol>';
        // 다시 그려도 입력하던 칸에 커서를 돌려놔요
        var active = document.activeElement;
        var keep = active && active.dataset && active.dataset.id ? '[data-id="' + active.dataset.id + '"][data-side="' + active.dataset.side + '"]' : '';
        $('group').innerHTML = html;
        if (keep) {
            var el = $('group').querySelector('input' + keep);
            if (el) el.focus();
        }
    }

    function gameRow(m) {
        var real = data.results[m.id], fix = state.fixed[m.id];
        var p = cup.matchProbs(m.h, m.a);
        var when = m.kst ? m.kst.replace(/^\d{4}-(\d\d)-(\d\d)/, function (_, mo, d) { return (+mo) + '.' + (+d); }) : '';
        var score;
        if (real) {
            score = '<span class="final">' + real[0] + ' : ' + real[1] + '</span>';
        } else {
            var v = fix || ['', ''];
            score = '<input type="number" inputmode="numeric" min="0" max="20" data-id="' + m.id + '" data-side="0" value="' + v[0] + '" aria-label="' + name(m.h) + ' 득점">' +
                '<span class="colon">:</span>' +
                '<input type="number" inputmode="numeric" min="0" max="20" data-id="' + m.id + '" data-side="1" value="' + v[1] + '" aria-label="' + name(m.a) + ' 득점">';
        }
        var odds = real || fix ? '' : '<span class="odds" title="전력 점수로 본 승·무·패 확률">' +
            Math.round(100 * p[0]) + ' · ' + Math.round(100 * p[1]) + ' · ' + Math.round(100 * p[2]) + '</span>';
        return '<li class="' + (fix ? 'fixed' : '') + '">' +
            '<span class="md"><b>' + m.md + '차전</b>' + (when ? ' <time>' + esc(when) + '</time>' : '') + '</span>' +
            '<span class="h' + (m.h === state.focus ? ' me' : '') + '">' + label(m.h, true) + '</span>' +
            '<span class="score">' + score + '</span>' +
            '<span class="a' + (m.a === state.focus ? ' me' : '') + '">' + label(m.a) + '</span>' + odds + '</li>';
    }

    function renderAll() {
        var codes = Object.keys(teams).sort(function (a, b) {
            var x = stat.teams[a], y = stat.teams[b];
            return y.champ - x.champ || y.final - x.final || y.r16 - x.r16;
        });
        var rows = codes.map(function (c) {
            var s = stat.teams[c];
            return '<tr' + (c === state.focus ? ' class="me"' : '') + '><th scope="row">' + label(c) + '</th><td>' + teams[c].group + '</td>' +
                '<td class="p">' + pct2(s.r16) + '</td><td class="p">' + pct2(s.qf) + '</td><td class="p">' + pct2(s.sf) + '</td>' +
                '<td class="p">' + pct2(s.final) + '</td><td class="p strong">' + pct2(s.champ) + bar(s.champ) + '</td></tr>';
        }).join('');
        $('all').innerHTML = '<table class="tbl"><thead><tr><th scope="col">팀</th><th scope="col">조</th><th scope="col">16강</th><th scope="col">8강</th><th scope="col">4강</th><th scope="col">결승</th><th scope="col">우승</th></tr></thead><tbody>' + rows + '</tbody></table>';
    }

    function setupFocus() {
        var codes = Object.keys(teams).sort(function (a, b) {
            return teams[a].group.localeCompare(teams[b].group) || teams[a].slot - teams[b].slot;
        });
        $('focus').innerHTML = codes.map(function (c) {
            return '<option value="' + c + '"' + (c === state.focus ? ' selected' : '') + '>' + teams[c].group + '조 · ' + name(c) + '</option>';
        }).join('');
        $('focus').addEventListener('change', function () {
            state.focus = this.value;
            state.group = teams[this.value].group;
            render();
        });
    }

    function onScore(e) {
        var el = e.target;
        if (!el.matches('input[data-id]')) return;
        var id = el.dataset.id;
        var inputs = document.querySelectorAll('input[data-id="' + id + '"]');
        var a = inputs[0].value, b = inputs[1].value;
        var valid = function (v) { return /^\d{1,2}$/.test(v) && +v <= 20; };
        var before = JSON.stringify(state.fixed[id] || null);
        if (valid(a) && valid(b)) state.fixed[id] = [+a, +b];
        else delete state.fixed[id];
        if (before !== JSON.stringify(state.fixed[id] || null)) recalc();
    }

    function toast(msg) {
        var t = $('toast');
        t.textContent = msg;
        t.hidden = false;
        clearTimeout(toast.timer);
        toast.timer = setTimeout(function () { t.hidden = true; }, 2500);
    }

    function share() {
        writeHash();
        var url = location.href;
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(function () { toast('링크를 복사했어요'); }, function () { toast(url); });
        } else {
            toast(url);
        }
    }

    function dday() {
        var days = Math.ceil((new Date(data.kickoff) - new Date()) / 86400000);
        $('dday').textContent = days > 0 ? '개막 D-' + days : '대회 진행 중';
    }

    readHash();
    setupFocus();
    dday();
    $('group').addEventListener('input', onScore);
    $('tabs').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-g]');
        if (!b) return;
        state.group = b.dataset.g;
        renderTabs();
        renderGroup();
        writeHash();
    });
    $('reset').addEventListener('click', function () {
        state.fixed = {};
        recalc();
    });
    $('share').addEventListener('click', share);
    recalc();

    // 결과 카드(card.js)가 지금 계산 결과를 읽어 가요
    window.CupApp = {
        current: function () { return { cup: cup, data: data, state: state, stat: stat, pct: pct, label: label, esc: esc }; },
        save: writeHash,
        shareUrl: function () { writeHash(); return location.href; }
    };
})();
