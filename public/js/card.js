// 결과 카드: 지금 계산 결과를 1080×1080 이미지로 그려서 저장하거나 공유해요
// 서버 없이 브라우저 캔버스에서 만들어요
(function () {
    'use strict';

    var SIZE = 1080;
    var FONT = 'Pretendard, "Apple SD Gothic Neo", "Malgun Gothic", sans-serif';
    var $ = function (id) { return document.getElementById(id); };
    var blobUrl = '';

    function font(weight, px) { return weight + ' ' + px + 'px ' + FONT; }

    function roundRect(ctx, x, y, w, h, r) {
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.arcTo(x + w, y, x + w, y + h, r);
        ctx.arcTo(x + w, y + h, x, y + h, r);
        ctx.arcTo(x, y + h, x, y, r);
        ctx.arcTo(x, y, x + w, y, r);
        ctx.closePath();
    }

    // 가장 유력한 16강 상대 (진출했을 때 기준)
    function topOpponent(s) {
        var best = '', n = 0;
        Object.keys(s.opp).forEach(function (c) { if (s.opp[c] > n) { best = c; n = s.opp[c]; } });
        return best ? [best, n] : null;
    }

    // 사용자가 넣은 점수 중 기준 팀 경기를 먼저, 최대 3줄
    function scenarioLines(app) {
        var focus = app.state.focus, teams = app.data.teams;
        var ids = Object.keys(app.state.fixed);
        var games = app.cup.matches.filter(function (m) { return ids.indexOf(String(m.id)) >= 0; });
        games.sort(function (a, b) {
            var fa = a.h === focus || a.a === focus ? 0 : 1, fb = b.h === focus || b.a === focus ? 0 : 1;
            return fa - fb || a.id - b.id;
        });
        var lines = games.slice(0, 3).map(function (m) {
            var r = app.state.fixed[m.id];
            return teams[m.h].name + ' ' + r[0] + ' : ' + r[1] + ' ' + teams[m.a].name;
        });
        if (games.length > 3) lines.push('외 ' + (games.length - 3) + '경기');
        return lines;
    }

    // 국기 그리기 (이미지가 아직 없으면 건너뛰어요). 4:3 비율, 글자 기준선에 맞춰요
    function drawFlag(ctx, img, x, baseline, h) {
        if (!img || !img.complete || !img.naturalWidth) return 0;
        var w = Math.round(h * 4 / 3), top = baseline - h + Math.round(h * 0.08);
        ctx.save();
        roundRect(ctx, x, top, w, h, 6);
        ctx.clip();
        ctx.drawImage(img, x, top, w, h);
        ctx.restore();
        return w + Math.round(h * 0.4);
    }

    function loadFlag(code) {
        var f = window.CUP_DATA.teams[code].flag;
        return new Promise(function (resolve) {
            if (!f) return resolve(null);
            var img = new Image();
            img.onload = function () { resolve(img); };
            img.onerror = function () { resolve(null); };
            img.src = 'img/flags/' + f + '.svg';
        });
    }

    function draw(app, flags) {
        flags = flags || {};
        var cv = document.createElement('canvas');
        cv.width = SIZE; cv.height = SIZE;
        var ctx = cv.getContext('2d');
        var data = app.data, s = app.stat.teams[app.state.focus], team = data.teams[app.state.focus];
        var pct = app.pct;

        paintBackground(ctx, SIZE, SIZE);

        var x = 80;
        ctx.textBaseline = 'alphabetic';
        ctx.fillStyle = 'rgba(255,255,255,0.75)';
        ctx.font = font(600, 34);
        ctx.fillText(data.name + ' · 경우의 수', x, 130);

        ctx.fillStyle = '#ffffff';
        ctx.font = font(800, 64);
        var fx = drawFlag(ctx, flags[app.state.focus], x, 230, 52);
        ctx.fillText(team.name + ' 16강 진출 확률', x + fx, 230);

        ctx.font = font(800, 230);
        ctx.fillText(pct(s.r16), x - 8, 470);

        // 단계별 확률 4칸
        var boxes = [['조 1위', s.pos[0]], ['8강', s.qf], ['4강', s.sf], ['우승', s.champ]];
        var bw = 213, gap = 16, by = 530, bh = 150;
        boxes.forEach(function (b, i) {
            var bx = x + i * (bw + gap);
            ctx.fillStyle = 'rgba(255,255,255,0.12)';
            roundRect(ctx, bx, by, bw, bh, 24);
            ctx.fill();
            ctx.fillStyle = 'rgba(255,255,255,0.75)';
            ctx.font = font(600, 30);
            ctx.fillText(b[0], bx + 26, by + 52);
            ctx.fillStyle = '#ffffff';
            ctx.font = font(800, 56);
            ctx.fillText(pct(b[1]), bx + 26, by + 120);
        });

        // 유력한 16강 상대
        var opp = topOpponent(s);
        var y = 760;
        if (opp) {
            ctx.fillStyle = 'rgba(255,255,255,0.75)';
            ctx.font = font(600, 32);
            ctx.fillText('가장 유력한 16강 상대', x, y);
            ctx.fillStyle = '#ffffff';
            ctx.font = font(800, 46);
            var ox = drawFlag(ctx, flags[opp[0]], x, y + 60, 40);
            ctx.fillText(data.teams[opp[0]].name + '  ' + pct(opp[1], s.r16), x + ox, y + 60);
            y += 120;
        }

        // 직접 넣은 점수
        var lines = scenarioLines(app);
        ctx.font = font(600, 28);
        ctx.fillStyle = '#9ff0b8';
        if (lines.length) {
            ctx.fillText('가정: ' + lines.join(' / '), x, y, SIZE - x * 2);
        } else {
            ctx.fillText('남은 경기 전부 시뮬레이션', x, y);
        }

        paintFooter(ctx, SIZE, SIZE, '1만 회 시뮬레이션 · 참고용');
        return cv;
    }

    // 초록 배경 (카드 공통)
    function paintBackground(ctx, w, h) {
        var bg = ctx.createLinearGradient(0, 0, w, h);
        bg.addColorStop(0, '#0f3d2e'); bg.addColorStop(0.6, '#14532d'); bg.addColorStop(1, '#0b2a20');
        ctx.fillStyle = bg;
        ctx.fillRect(0, 0, w, h);
        var glow = ctx.createRadialGradient(w - 180, 160, 0, w - 180, 160, 520);
        glow.addColorStop(0, 'rgba(52,209,107,0.38)'); glow.addColorStop(1, 'rgba(52,209,107,0)');
        ctx.fillStyle = glow;
        ctx.fillRect(0, 0, w, h);
    }

    // 맨 아래 줄: 왼쪽은 날짜와 설명, 오른쪽은 사이트 주소 (로컬이면 "경우의 수")
    function paintFooter(ctx, w, h, text) {
        var now = new Date(), x = 80;
        ctx.textAlign = 'left';
        ctx.fillStyle = 'rgba(255,255,255,0.6)';
        ctx.font = font(500, 26);
        ctx.fillText((now.getMonth() + 1) + '.' + now.getDate() + ' 기준 · ' + text, x, h - 70);
        ctx.textAlign = 'right';
        ctx.fillStyle = '#ffffff';
        ctx.font = font(800, 34);
        var host = /^https?:$/.test(location.protocol) && !/^(localhost|127\.0\.0\.1)$/.test(location.hostname) ? location.hostname : '경우의 수';
        ctx.fillText('⚽ ' + host, w - x, h - 70);
        ctx.textAlign = 'left';
    }

    // 글꼴과 국기 이미지를 미리 불러와요 → { 팀코드: 이미지 }
    function prepare(codes) {
        var fonts = document.fonts && document.fonts.load
            ? Promise.all([document.fonts.load(font(800, 64)), document.fonts.load(font(600, 32))]).catch(function () {})
            : Promise.resolve();
        return Promise.all([fonts].concat(codes.map(loadFlag))).then(function (res) {
            var flags = {};
            codes.forEach(function (c, i) { flags[c] = res[i + 1]; });
            return flags;
        });
    }

    // 캔버스를 이미지로 바꿔 미리보기 창에 띄우고 저장·공유 버튼을 연결해요
    // paint(flags) → 캔버스. 국기 때문에 저장할 수 없는 캔버스면(파일로 직접 연 경우 등) 국기 없이 다시 그려요
    function show(paint, flags, fileName, alt) {
        var cv = paint(flags);
        try { cv.toDataURL(); } catch (e) { cv = paint({}); }
        cv.toBlob(function (blob) {
            if (blobUrl) URL.revokeObjectURL(blobUrl);
            blobUrl = URL.createObjectURL(blob);
            $('card_img').src = blobUrl;
            $('card_img').alt = alt;
            $('card_save').href = blobUrl;
            $('card_save').download = fileName;
            var file = window.File ? new File([blob], fileName, { type: 'image/png' }) : null;
            var canShare = file && navigator.canShare && navigator.canShare({ files: [file] });
            $('card_share').hidden = !canShare;
            $('card_share').onclick = function () {
                navigator.share({ files: [file], text: alt, url: window.CupApp.shareUrl() }).catch(function () {});
            };
            var dlg = $('card_dialog');
            if (dlg.showModal) dlg.showModal(); else dlg.setAttribute('open', '');
        }, 'image/png');
    }

    function open() {
        var app = window.CupApp && window.CupApp.current();
        if (!app || !app.stat) return;
        var focus = app.state.focus, opp = topOpponent(app.stat.teams[focus]);
        prepare(opp ? [focus, opp[0]] : [focus]).then(function (flags) {
            show(function (f) { return draw(app, f); }, flags,
                'asiancup-' + focus.toLowerCase() + '.png',
                app.data.teams[focus].name + ' 16강 진출 확률 ' + app.pct(app.stat.teams[focus].r16));
        });
    }

    function close() {
        var dlg = $('card_dialog');
        if (dlg.close) dlg.close(); else dlg.removeAttribute('open');
    }

    $('card_open').addEventListener('click', open);
    $('card_close').addEventListener('click', close);
    $('card_dialog').addEventListener('click', function (e) { if (e.target === this) close(); }); // 바깥을 누르면 닫기

    // 대진표 카드(bracket.js)도 같은 도구로 그려요
    window.CupCard = {
        draw: draw,
        prepare: prepare,
        show: show,
        util: { font: font, roundRect: roundRect, drawFlag: drawFlag, paintBackground: paintBackground, paintFooter: paintFooter }
    };
})();
