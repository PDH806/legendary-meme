// 맨 위 "대회 한 번 돌려보기" 버튼: 대회를 한 번 돌리고 대진표 자리로 내려가요
(function () {
    'use strict';
    var hero = document.getElementById('hero_run'), run = document.getElementById('ko_run'), box = document.getElementById('run_box');
    if (!hero || !run) return;
    hero.addEventListener('click', function () {
        run.click();
        if (box) box.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
})();
