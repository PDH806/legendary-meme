// UEFA 네이션스리그 2026-27 리그 A 리그 단계 데이터
// 경기 결과: 위키백과 2026–27 UEFA Nations League A (4차전까지, 2026.10.6 기준)
// 전력(elo): martj42/international_results(CC0) 2026.10.6까지 경기로 직접 계산한 World Football Elo 방식 점수
// seed: 2026-27 네이션스리그 access list 순위 (모든 기준이 같을 때 마지막 순위 결정 기준)
// matches: [번호, 조, 차전, 홈, 원정, 한국 시간]  (11월은 중부유럽 표준시 + 8시간)
window.UNL_DATA = {
    updated: '2026-11-14 07:32',
    model: { mu: 1.00, c: 0.0020, home: 100 },
    teams: {
        POR: { name: '포르투갈', flag: 'pt', elo: 2120, seed: 1 },
        ESP: { name: '스페인', flag: 'es', elo: 2355, seed: 2 },
        FRA: { name: '프랑스', flag: 'fr', elo: 2175, seed: 3 },
        GER: { name: '독일', flag: 'de', elo: 1973, seed: 4 },
        ITA: { name: '이탈리아', flag: 'it', elo: 1972, seed: 5 },
        NED: { name: '네덜란드', flag: 'nl', elo: 2047, seed: 6 },
        DEN: { name: '덴마크', flag: 'dk', elo: 1920, seed: 7 },
        CRO: { name: '크로아티아', flag: 'hr', elo: 1923, seed: 8 },
        SRB: { name: '세르비아', flag: 'rs', elo: 1751, seed: 9 },
        BEL: { name: '벨기에', flag: 'be', elo: 2032, seed: 10 },
        ENG: { name: '잉글랜드', flag: 'gb-eng', elo: 2218, seed: 11 },
        NOR: { name: '노르웨이', flag: 'no', elo: 1969, seed: 12 },
        WAL: { name: '웨일스', flag: 'gb-wls', elo: 1741, seed: 13 },
        CZE: { name: '체코', flag: 'cz', elo: 1729, seed: 14 },
        GRE: { name: '그리스', flag: 'gr', elo: 1866, seed: 15 },
        TUR: { name: '튀르키예', flag: 'tr', elo: 1837, seed: 16 }
    },
    groups: {
        1: ['FRA', 'ITA', 'BEL', 'TUR'],
        2: ['NED', 'GRE', 'GER', 'SRB'],
        3: ['ESP', 'ENG', 'CRO', 'CZE'],
        4: ['POR', 'DEN', 'NOR', 'WAL']
    },
    // [조, 홈, 원정, 홈 득점, 원정 득점]
    played: [
        [1, 'ITA', 'BEL', 0, 2], [1, 'TUR', 'FRA', 0, 1], [1, 'BEL', 'FRA', 0, 1], [1, 'TUR', 'ITA', 1, 4],
        [1, 'BEL', 'TUR', 3, 0], [1, 'FRA', 'ITA', 1, 1], [1, 'FRA', 'BEL', 4, 1], [1, 'ITA', 'TUR', 3, 1],
        [2, 'NED', 'GER', 1, 1], [2, 'SRB', 'GRE', 1, 2], [2, 'SRB', 'NED', 1, 2], [2, 'GER', 'GRE', 0, 1],
        [2, 'GER', 'SRB', 2, 0], [2, 'GRE', 'NED', 2, 2], [2, 'GRE', 'GER', 0, 0], [2, 'NED', 'SRB', 2, 1],
        [3, 'CZE', 'CRO', 1, 2], [3, 'ENG', 'ESP', 2, 3], [3, 'CZE', 'ENG', 0, 2], [3, 'ESP', 'CRO', 4, 1],
        [3, 'CRO', 'ENG', 0, 7], [3, 'ESP', 'CZE', 3, 1], [3, 'CRO', 'ESP', 1, 2], [3, 'ENG', 'CZE', 3, 0],
        [4, 'NOR', 'DEN', 3, 2], [4, 'POR', 'WAL', 1, 0], [4, 'DEN', 'WAL', 2, 0], [4, 'NOR', 'POR', 1, 2],
        [4, 'DEN', 'POR', 2, 4], [4, 'WAL', 'NOR', 2, 1], [4, 'POR', 'NOR', 2, 1], [4, 'WAL', 'DEN', 0, 1]
    ],
    matches: [
        [1, 1, 5, 'TUR', 'BEL', '2026-11-13 02:00'],
        [2, 1, 5, 'ITA', 'FRA', '2026-11-13 04:45'],
        [3, 3, 5, 'CZE', 'ESP', '2026-11-13 04:45'],
        [4, 3, 5, 'ENG', 'CRO', '2026-11-13 04:45'],
        [5, 2, 5, 'NED', 'GRE', '2026-11-14 04:45'],
        [6, 2, 5, 'SRB', 'GER', '2026-11-14 04:45'],
        [7, 4, 5, 'NOR', 'WAL', '2026-11-15 02:00'],
        [8, 4, 5, 'POR', 'DEN', '2026-11-15 04:45'],
        [9, 1, 6, 'BEL', 'ITA', '2026-11-16 04:45'],
        [10, 1, 6, 'FRA', 'TUR', '2026-11-16 04:45'],
        [11, 3, 6, 'CRO', 'CZE', '2026-11-16 04:45'],
        [12, 3, 6, 'ESP', 'ENG', '2026-11-16 04:45'],
        [13, 2, 6, 'GER', 'NED', '2026-11-17 04:45'],
        [14, 2, 6, 'GRE', 'SRB', '2026-11-17 04:45'],
        [15, 4, 6, 'DEN', 'NOR', '2026-11-18 04:45'],
        [16, 4, 6, 'WAL', 'POR', '2026-11-18 04:45']
    ],
    // 끝난 경기 결과 { 번호: [홈, 원정] }
    results: {1: [1, 2], 2: [3, 1], 3: [0, 2], 4: [2, 1], 5: [7, 0], 6: [1, 3]}
};
