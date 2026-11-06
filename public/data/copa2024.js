// 코파 아메리카 2024 (미국) 다시 돌려보기 데이터
// 전력 점수: martj42/international_results (CC0) 경기 기록으로 계산한 Elo, 개막 전날(2024-06-19)까지
// 모델: 2016년 이후 이 16팀이 낀 경기 1109개로 맞춘 값 (mu 1.00, c 0.0023)
// 조 순서는 실제 최종 순위, actual은 실제 대회에서 간 단계 (출처: 위키백과 2024 Copa América)
window.WC_DATA = {
    model: { mu: 1.00, c: 0.0023, home: 100 },
    hosts: ['USA'],
    hostKO: true,
    actualLabel: '실제 코파 아메리카 2024',
    rounds: ['8강', '4강', '결승'],
    focus: 'ARG',
    bestThirds: 0,
    tiebreak: 'overall',
    etFinalOnly: true,
    teams: {
        ARG: { name: '아르헨티나', flag: 'ar', elo: 2210, actual: 'W' },
        CAN: { name: '캐나다', flag: 'ca', elo: 1834, actual: 'SF' },
        CHI: { name: '칠레', flag: 'cl', elo: 1800, actual: 'G' },
        PER: { name: '페루', flag: 'pe', elo: 1820, actual: 'G' },
        VEN: { name: '베네수엘라', flag: 've', elo: 1827, actual: 'QF' },
        ECU: { name: '에콰도르', flag: 'ec', elo: 1956, actual: 'QF' },
        MEX: { name: '멕시코', flag: 'mx', elo: 1897, actual: 'G' },
        JAM: { name: '자메이카', flag: 'jm', elo: 1773, actual: 'G' },
        URU: { name: '우루과이', flag: 'uy', elo: 2065, actual: 'SF' },
        PAN: { name: '파나마', flag: 'pa', elo: 1827, actual: 'QF' },
        USA: { name: '미국', flag: 'us', elo: 1890, actual: 'G' },
        BOL: { name: '볼리비아', flag: 'bo', elo: 1664, actual: 'G' },
        COL: { name: '콜롬비아', flag: 'co', elo: 2084, actual: 'F' },
        BRA: { name: '브라질', flag: 'br', elo: 2096, actual: 'QF' },
        CRC: { name: '코스타리카', flag: 'cr', elo: 1734, actual: 'G' },
        PAR: { name: '파라과이', flag: 'py', elo: 1784, actual: 'G' }
    },
    groups: {
        A: ['ARG', 'CAN', 'CHI', 'PER'],
        B: ['VEN', 'ECU', 'MEX', 'JAM'],
        C: ['URU', 'PAN', 'USA', 'BOL'],
        D: ['COL', 'BRA', 'CRC', 'PAR']
    },
    // 8강 대진 (위에서부터): 1·2경기 승자끼리, 3·4경기 승자끼리 4강
    bracket: [['1A', '2B'], ['1B', '2A'], ['1C', '2D'], ['1D', '2C']]
};
