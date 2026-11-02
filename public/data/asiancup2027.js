// 2027 AFC 아시안컵 (사우디아라비아, 2027.1.7 ~ 2.5)
// 조편성: 2026.5.9 추첨 결과
// 규정: AFC Asian Cup Saudi Arabia 2027 Competition Regulations (10.16 수정본) 7.3, 9.5, 9.8조
//
// elo: 팀 전력 점수. 국가대표 경기 기록 약 5만 건(1872 ~ 2026.10.6, martj42/international_results, CC0)을
//      World Football Elo 방식(대회별 가중치, 점수 차 보정, 홈 이점 100)으로 직접 계산했어요.
// model: 2016년 이후 이 24팀이 치른 경기 약 2천 건의 승·무·패에 맞춰 정한 득점 모델 계수
// results: 끝난 경기 결과를 { 경기번호: [홈 득점, 원정 득점] } 로 넣으면 그 경기는 고정돼요.
window.CUP_DATA = {
    id: 'asiancup2027',
    name: '2027 AFC 아시안컵',
    host: 'KSA', // 개최국은 모든 경기에서 홈 이점을 받아요
    homeBonus: 100,
    model: { mu: 1.10, c: 0.0022 },
    kickoff: '2027-01-07T00:00:00+09:00',
    focus: 'KOR',
    teams: {
        KSA: { name: '사우디아라비아', short: '사우디', group: 'A', slot: 1, elo: 1738, flag: 'sa' },
        KUW: { name: '쿠웨이트',       group: 'A', slot: 2, elo: 1448, flag: 'kw' },
        OMA: { name: '오만',           group: 'A', slot: 3, elo: 1571, flag: 'om' },
        PLE: { name: '팔레스타인',     group: 'A', slot: 4, elo: 1622, flag: 'ps' },
        UZB: { name: '우즈베키스탄', short: '우즈벡', group: 'B', slot: 1, elo: 1749, flag: 'uz' },
        BHR: { name: '바레인',         group: 'B', slot: 2, elo: 1461, flag: 'bh' },
        PRK: { name: '북한',           group: 'B', slot: 3, elo: 1493, flag: 'kp' },
        JOR: { name: '요르단',         group: 'B', slot: 4, elo: 1713, flag: 'jo' },
        IRN: { name: '이란',           group: 'C', slot: 1, elo: 1863, flag: 'ir' },
        SYR: { name: '시리아',         group: 'C', slot: 2, elo: 1598, flag: 'sy' },
        KGZ: { name: '키르기스스탄', short: '키르기스', group: 'C', slot: 3, elo: 1464, flag: 'kg' },
        CHN: { name: '중국',           group: 'C', slot: 4, elo: 1495, flag: 'cn' },
        AUS: { name: '호주',           group: 'D', slot: 1, elo: 1896, flag: 'au' },
        TJK: { name: '타지키스탄', short: '타지크', group: 'D', slot: 2, elo: 1433, flag: 'tj' },
        IRQ: { name: '이라크',         group: 'D', slot: 3, elo: 1663, flag: 'iq' },
        SGP: { name: '싱가포르',       group: 'D', slot: 4, elo: 1309, flag: 'sg' },
        KOR: { name: '대한민국',       group: 'E', slot: 1, elo: 1844, flag: 'kr' },
        UAE: { name: 'UAE',            group: 'E', slot: 2, elo: 1678, flag: 'ae' },
        VIE: { name: '베트남',         group: 'E', slot: 3, elo: 1530, flag: 'vn' },
        YEM: { name: '예멘',           group: 'E', slot: 4, elo: 1334, flag: 'ye' },
        JPN: { name: '일본',           group: 'F', slot: 1, elo: 1974, flag: 'jp' },
        QAT: { name: '카타르',         group: 'F', slot: 2, elo: 1584, flag: 'qa' },
        THA: { name: '태국',           group: 'F', slot: 3, elo: 1533, flag: 'th' },
        IDN: { name: '인도네시아',     group: 'F', slot: 4, elo: 1474, flag: 'id' }
    },
    // 조별리그 경기: [경기번호, 조, 차전, 홈, 원정, 한국시간]
    // 경기번호와 일정은 대회 공식 일정 기준이에요. 한국시간 = 사우디 현지시간 + 6시간
    // 같은 조 3차전 두 경기는 동시에 열려요. 25~28번은 두 경기 중 어느 쪽이 앞 번호인지 확인이 필요해요.
    matches: [
        [1,  'A', 1, 'KSA', 'PLE', '2027-01-08 02:00'],
        [2,  'B', 1, 'BHR', 'PRK', '2027-01-08 19:30'],
        [3,  'A', 1, 'KUW', 'OMA', '2027-01-08 22:30'],
        [4,  'B', 1, 'UZB', 'JOR', '2027-01-09 01:30'],
        [5,  'D', 1, 'AUS', 'SGP', '2027-01-09 19:30'],
        [6,  'C', 1, 'IRN', 'CHN', '2027-01-09 22:30'],
        [7,  'C', 1, 'SYR', 'KGZ', '2027-01-10 01:30'],
        [8,  'E', 1, 'KOR', 'YEM', '2027-01-10 19:30'],
        [9,  'D', 1, 'TJK', 'IRQ', '2027-01-10 22:30'],
        [10, 'F', 1, 'JPN', 'IDN', '2027-01-11 19:30'],
        [11, 'E', 1, 'UAE', 'VIE', '2027-01-11 22:30'],
        [12, 'F', 1, 'QAT', 'THA', '2027-01-12 01:30'],
        [13, 'A', 2, 'PLE', 'KUW', '2027-01-12 19:30'],
        [14, 'B', 2, 'PRK', 'UZB', '2027-01-12 22:30'],
        [15, 'A', 2, 'OMA', 'KSA', '2027-01-13 01:30'],
        [16, 'B', 2, 'JOR', 'BHR', '2027-01-13 22:30'],
        [17, 'C', 2, 'KGZ', 'IRN', '2027-01-14 01:30'],
        [18, 'D', 2, 'IRQ', 'AUS', '2027-01-14 19:30'],
        [19, 'C', 2, 'CHN', 'SYR', '2027-01-14 22:30'],
        [20, 'D', 2, 'SGP', 'TJK', '2027-01-15 01:30'],
        [21, 'E', 2, 'VIE', 'KOR', '2027-01-15 19:30'],
        [22, 'E', 2, 'YEM', 'UAE', '2027-01-16 01:30'],
        [23, 'F', 2, 'THA', 'JPN', '2027-01-16 19:30'],
        [24, 'F', 2, 'IDN', 'QAT', '2027-01-17 01:30'],
        [25, 'B', 3, 'PRK', 'JOR', '2027-01-17 22:30'],
        [26, 'B', 3, 'UZB', 'BHR', '2027-01-17 22:30'],
        [27, 'A', 3, 'KSA', 'KUW', '2027-01-18 02:00'],
        [28, 'A', 3, 'OMA', 'PLE', '2027-01-18 02:00'],
        [29, 'C', 3, 'IRN', 'SYR', '2027-01-18 22:30'],
        [30, 'C', 3, 'KGZ', 'CHN', '2027-01-18 22:30'],
        [31, 'D', 3, 'AUS', 'TJK', '2027-01-19 19:30'],
        [32, 'D', 3, 'IRQ', 'SGP', '2027-01-19 19:30'],
        [33, 'F', 3, 'JPN', 'QAT', '2027-01-20 19:30'],
        [34, 'F', 3, 'THA', 'IDN', '2027-01-20 19:30'],
        [35, 'E', 3, 'KOR', 'UAE', '2027-01-20 22:30'],
        [36, 'E', 3, 'VIE', 'YEM', '2027-01-20 22:30']
    ],
    results: {},
    // 3위 4팀이 어느 조에서 나오느냐에 따른 16강 상대 (규정 9.8조 조합표)
    // 키: 진출한 3위 팀의 조 4개, 값: [1A 상대, 1B 상대, 1C 상대, 1D 상대]
    thirdTable: {
        ABCD: ['C', 'D', 'A', 'B'], ABCE: ['C', 'A', 'B', 'E'], ABCF: ['C', 'A', 'B', 'F'],
        ABDE: ['D', 'A', 'B', 'E'], ABDF: ['D', 'A', 'B', 'F'], ABEF: ['E', 'A', 'B', 'F'],
        ACDE: ['C', 'D', 'A', 'E'], ACDF: ['C', 'D', 'A', 'F'], ACEF: ['C', 'A', 'F', 'E'],
        ADEF: ['D', 'A', 'F', 'E'], BCDE: ['C', 'D', 'B', 'E'], BCDF: ['C', 'D', 'B', 'F'],
        BCEF: ['E', 'C', 'B', 'F'], BDEF: ['E', 'D', 'B', 'F'], CDEF: ['C', 'D', 'F', 'E']
    },
    // 16강 대진 (규정 9.8조). T1A = 조합표에서 정해지는 1A의 상대 3위 팀
    // 8강은 1-2, 3-4, 5-6, 7-8번 승자끼리, 4강은 8강 1-2, 3-4번 승자끼리 붙어요
    r16: [
        ['2A', '2C'], ['1D', 'T1D'], ['1B', 'T1B'], ['1F', '2E'],
        ['1C', 'T1C'], ['1E', '2D'], ['1A', 'T1A'], ['2B', '2F']
    ]
};
