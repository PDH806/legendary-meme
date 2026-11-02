// 어두운 화면 ↔ 밝은 화면 전환 버튼
// 기본은 어두운 화면이에요. ☀️를 누르면 밝은 화면으로 바뀌고, 고른 값은 이 브라우저에만 저장해요
(function () {
    'use strict';

    var root = document.documentElement;
    var btn = document.getElementById('theme_btn');
    var meta = document.querySelector('meta[name="theme-color"]');

    function isDark() {
        return root.getAttribute('data-theme') !== 'light';
    }

    function paint() {
        var dark = isDark();
        btn.textContent = dark ? '☀️' : '🌙';
        btn.setAttribute('aria-label', dark ? '밝은 화면으로 바꾸기' : '어두운 화면으로 바꾸기');
        if (meta) meta.setAttribute('content', dark ? '#0b2a20' : '#0f3d2e');
    }

    btn.addEventListener('click', function () {
        var next = isDark() ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        try { localStorage.setItem('cup-theme', next); } catch (e) {}
        paint();
    });
    paint();
})();
