// 대진표 연결선: 각 라운드 두 경기 → 다음 라운드 한 경기로 이어지는 선을 그려요
// 대진표(#ko 안의 .bracket)가 다시 그려질 때마다, 창 크기가 바뀔 때마다 새로 그려요
(function () {
    'use strict';
    var ko = document.getElementById('ko');
    if (!ko || !window.MutationObserver) return;
    var NS = 'http://www.w3.org/2000/svg', raf = 0;
    var observer = new MutationObserver(schedule);

    function schedule() {
        if (!raf) raf = requestAnimationFrame(draw);
    }

    // 한 칸의 경기 카드들 (네이션스리그는 카드 아래 1·2차전 점수가 붙어 있어서 카드만 골라요)
    function cards(col) {
        return Array.prototype.map.call(col.querySelectorAll('.ko-list > *'), function (el) {
            return el.classList.contains('ko-m') ? el : el.querySelector('.ko-m');
        });
    }

    function draw() {
        raf = 0;
        observer.disconnect();
        var br = ko.querySelector('.bracket');
        if (br) {
            var old = br.querySelector('svg.ko-lines');
            if (old) br.removeChild(old);
            var base = br.getBoundingClientRect();
            var cols = br.querySelectorAll('.ko-col');
            var svg = document.createElementNS(NS, 'svg');
            svg.setAttribute('class', 'ko-lines');
            svg.setAttribute('aria-hidden', 'true');
            svg.setAttribute('width', br.scrollWidth);
            svg.setAttribute('height', br.scrollHeight);
            for (var c = 0; c + 1 < cols.length; c++) {
                var src = cards(cols[c]), dst = cards(cols[c + 1]);
                dst.forEach(function (d, j) {
                    if (!d) return;
                    var r2 = d.getBoundingClientRect();
                    [src[2 * j], src[2 * j + 1]].forEach(function (s) {
                        if (!s) return;
                        var r1 = s.getBoundingClientRect();
                        var x1 = r1.right - base.left, y1 = r1.top + r1.height / 2 - base.top;
                        var x2 = r2.left - base.left, y2 = r2.top + r2.height / 2 - base.top;
                        var xm = (x1 + x2) / 2;
                        var p = document.createElementNS(NS, 'path');
                        p.setAttribute('d', 'M' + x1 + ' ' + y1 + 'H' + xm + 'V' + y2 + 'H' + x2);
                        // 기준 팀이 이기고 올라간 길은 강조색으로
                        if (s.querySelector('.ko-t.win.me')) p.setAttribute('class', 'on');
                        svg.appendChild(p);
                    });
                });
            }
            br.insertBefore(svg, br.firstChild);
        }
        observer.observe(ko, { childList: true, subtree: true });
    }

    observer.observe(ko, { childList: true, subtree: true });
    window.addEventListener('resize', schedule);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(schedule);
    schedule();
})();
