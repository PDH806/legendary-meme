// UEFA 유로 2024 (독일) "다시 돌려보기" 데이터
// 조 편성·실제 결과·16강 조합표: 위키백과 UEFA Euro 2024 / knockout stage (UEFA 대회 규정)
// 전력(elo): martj42/international_results(CC0)로 개막 전(2024.6.12)까지 계산한 World Football Elo 방식 점수
// actual: 실제 대회에서 간 단계 (G 조별리그 탈락, R16 16강, QF 8강, SF 4강, F 준우승, W 우승)
window.WC_DATA = {
    model: { mu: 1.05, c: 0.0018, home: 100 },
    hosts: ['GER'],
    hostKO: true, // 독일은 토너먼트도 모두 홈 경기
    actualLabel: '실제 유로 2024',
    rounds: ['16강', '8강', '4강', '결승'],
    focus: 'ENG',
    bestThirds: 4,
    teams: {
        GER: { name: '독일', flag: 'de', elo: 1985, actual: 'QF' },
        SUI: { name: '스위스', flag: 'ch', elo: 1865, actual: 'QF' },
        HUN: { name: '헝가리', flag: 'hu', elo: 1885, actual: 'G' },
        SCO: { name: '스코틀랜드', flag: 'gb-sct', elo: 1820, actual: 'G' },
        ESP: { name: '스페인', flag: 'es', elo: 2076, actual: 'W' },
        ITA: { name: '이탈리아', flag: 'it', elo: 2009, actual: 'R16' },
        CRO: { name: '크로아티아', flag: 'hr', elo: 2028, actual: 'G' },
        ALB: { name: '알바니아', flag: 'al', elo: 1674, actual: 'G' },
        ENG: { name: '잉글랜드', flag: 'gb-eng', elo: 2045, actual: 'F' },
        DEN: { name: '덴마크', flag: 'dk', elo: 1889, actual: 'R16' },
        SVN: { name: '슬로베니아', flag: 'si', elo: 1785, actual: 'R16' },
        SRB: { name: '세르비아', flag: 'rs', elo: 1872, actual: 'G' },
        AUT: { name: '오스트리아', flag: 'at', elo: 1913, actual: 'R16' },
        FRA: { name: '프랑스', flag: 'fr', elo: 2138, actual: 'SF' },
        NED: { name: '네덜란드', flag: 'nl', elo: 2048, actual: 'SF' },
        POL: { name: '폴란드', flag: 'pl', elo: 1802, actual: 'G' },
        ROU: { name: '루마니아', flag: 'ro', elo: 1707, actual: 'R16' },
        BEL: { name: '벨기에', flag: 'be', elo: 2050, actual: 'R16' },
        SVK: { name: '슬로바키아', flag: 'sk', elo: 1721, actual: 'R16' },
        UKR: { name: '우크라이나', flag: 'ua', elo: 1902, actual: 'G' },
        POR: { name: '포르투갈', flag: 'pt', elo: 2061, actual: 'QF' },
        TUR: { name: '튀르키예', flag: 'tr', elo: 1802, actual: 'QF' },
        GEO: { name: '조지아', flag: 'ge', elo: 1724, actual: 'R16' },
        CZE: { name: '체코', flag: 'cz', elo: 1828, actual: 'G' }
    },
    // 실제 조 순위 순서
    groups: {
        A: ['GER', 'SUI', 'HUN', 'SCO'], B: ['ESP', 'ITA', 'CRO', 'ALB'], C: ['ENG', 'DEN', 'SVN', 'SRB'],
        D: ['AUT', 'FRA', 'NED', 'POL'], E: ['ROU', 'BEL', 'SVK', 'UKR'], F: ['POR', 'TUR', 'GEO', 'CZE']
    },
    // 16강 대진 (대진표 위에서부터, 이웃한 두 경기 승자가 8강에서 만나요). 'T'는 3위 팀 자리
    bracket: [['1B', 'T'], ['1A', '2C'], ['2D', '2E'], ['1F', 'T'], ['1C', 'T'], ['2A', '2B'], ['1E', 'T'], ['1D', '2F']],
    thirdSlots: 'BCEF',
    // 16강에 오른 3위 4팀의 조 조합(15가지) → 1B, 1C, 1E, 1F와 붙는 3위 조
    thirds: 'ABCD:ADBC ABCE:AEBC ABCF:AFBC ABDE:DEAB ABDF:DFAB ABEF:EFBA ACDE:EDCA ACDF:FDCA ACEF:EFCA ADEF:EFDA BCDE:EDBC BCDF:FDCB BCEF:FECB BDEF:FEDB CDEF:FEDC'
};
