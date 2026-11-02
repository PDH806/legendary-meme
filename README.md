# 경우의 수

축구 대회 경우의 수 시뮬레이터. 서버 없는 정적 사이트예요.

- `public/` : Cloudflare Workers(정적 자산)로 올라가는 사이트. 설정은 `wrangler.jsonc` (404 페이지 포함)
  - `index.html` 2027 AFC 아시안컵 / `kleague.html` 2026 K리그1 파이널 라운드
  - `data/` 대회 데이터, `js/engine.js` 대회(조별+토너먼트) 엔진, `js/league.js` 리그 엔진
- `tools/update_kleague.php` : 위키백과에서 K리그 결과를 받아 `public/data/kleague2026.js`에 반영
  - `.github/workflows/kleague.yml` 이 1시간마다 실행하고, 바뀌면 저장소에 저장해요
  - 로컬 시험: `php tools/update_kleague.php --dry-run`

출처: 국가대표 경기 기록 martj42/international_results (CC0), 국기 flag-icons (MIT),
대회 규정 AFC Competition Regulations, K리그 결과 K리그 공식 기록 · 위키백과.
