// 2026 K리그1 파이널 라운드 (34~38라운드)
// 경기 결과: 33라운드까지 198경기 (위키백과 2026 K League 1, K리그 공식 기록과 대조: 팀별 승무패·득실 일치, 2026.10.24 기준)
// att/def: 이번 시즌 198경기로 맞춘 공격력·수비 약점(평균 1.0). draw: 무승부 보정(K리그는 무승부가 많아요)
// results: 끝난 파이널 라운드 경기를 { 경기번호: [홈 득점, 원정 득점] } 로 넣으면 고정돼요
window.LEAGUE_DATA = {
    id: 'kleague2026',
    name: '2026 K리그1',
    updated: '2026-11-02 11:12', // 결과를 마지막으로 반영한 시각 (자동)
    model: { m: 1.2004, home: 1, draw: 1.461 },
    // 순위 기준: 승점 → 다득점 → 득실차 → 다승 → 승자승(상대 전적 승점)
    tiebreak: ['pts', 'gf', 'gd', 'w', 'h2h'],
    splits: [
        { id: 'A', name: '파이널 A', from: 1, teams: ['SEO', 'USH', 'DHC', 'JHM', 'GWN', 'ICU'] },
        { id: 'B', name: '파이널 B', from: 7, teams: ['JSK', 'AYG', 'PHS', 'GCS', 'BCN', 'GJU'] }
    ],
    // 순위 구간: 1~3위 ACL 엘리트 리그 스테이지, 4위 ACL 엘리트 플레이오프, 12위 승강 플레이오프(김천 제외)
    zones: [
        { id: 'acl', name: 'ACL 엘리트 직행', short: 'ACLE 직행', from: 1, to: 3 },
        { id: 'aclpo', name: 'ACL 엘리트 플레이오프', short: 'ACLE PO', from: 4, to: 4 },
        { id: 'rpo', name: '승강 플레이오프', short: '승강 PO', from: 12, to: 12, except: ['GCS'] }
    ],
    champion: 'SEO', // 33라운드에 우승 확정 (2위와 16점 차)
    notes: { GCS: '군 팀이라 아시아 대회에 나갈 수 없고, 순위와 상관없이 2027년 K리그2로 가요.' },
    teams: {
        SEO: { name: 'FC서울', short: '서울', att: 1.4344, def: 0.7708 },
        USH: { name: '울산 HD', short: '울산', att: 1.2768, def: 1.1757 },
        DHC: { name: '대전 하나시티즌', short: '대전', att: 1.2851, def: 1.0381 },
        JHM: { name: '전북 현대', short: '전북', att: 1.0427, def: 0.8367 },
        GWN: { name: '강원FC', short: '강원', att: 0.9705, def: 0.7644 },
        ICU: { name: '인천 유나이티드', short: '인천', att: 1.0465, def: 0.8822 },
        JSK: { name: '제주 SK', short: '제주', att: 0.9604, def: 0.921 },
        AYG: { name: 'FC안양', short: '안양', att: 1.0029, def: 1.1722 },
        PHS: { name: '포항 스틸러스', short: '포항', att: 0.7612, def: 0.9507 },
        GCS: { name: '김천 상무', short: '김천', att: 0.8317, def: 1.0005 },
        BCN: { name: '부천FC1995', short: '부천', att: 0.8179, def: 1.1327 },
        GJU: { name: '광주FC', short: '광주', att: 0.8045, def: 1.6195 }
    },
    // 33라운드까지 경기: [홈, 원정, 홈 득점, 원정 득점]
    played: [
        ['AYG','BCN',0,1], ['AYG','DHC',1,2], ['AYG','GWN',2,1], ['AYG','GCS',2,2], ['AYG','GJU',1,1], ['AYG','ICU',0,1],
        ['AYG','JSK',2,1], ['AYG','JHM',1,1], ['AYG','PHS',2,3], ['AYG','SEO',1,1], ['AYG','USH',1,1], ['BCN','AYG',2,3],
        ['BCN','DHC',1,1], ['BCN','GWN',0,0], ['BCN','GCS',0,2], ['BCN','GJU',0,0], ['BCN','ICU',2,2], ['BCN','JSK',0,1],
        ['BCN','JHM',0,0], ['BCN','PHS',2,0], ['BCN','SEO',1,3], ['BCN','USH',1,2], ['DHC','AYG',1,1], ['DHC','BCN',2,2],
        ['DHC','GWN',0,2], ['DHC','GCS',1,1], ['DHC','GJU',2,0], ['DHC','ICU',0,0], ['DHC','JSK',0,1], ['DHC','JHM',0,1],
        ['DHC','PHS',0,2], ['DHC','SEO',1,2], ['DHC','USH',2,2], ['GWN','AYG',1,1], ['GWN','BCN',0,3], ['GWN','DHC',2,0],
        ['GWN','GCS',2,0], ['GWN','GJU',3,0], ['GWN','ICU',0,0], ['GWN','JSK',1,1], ['GWN','JHM',1,1], ['GWN','PHS',1,1],
        ['GWN','SEO',1,2], ['GWN','USH',2,0], ['GCS','AYG',1,1], ['GCS','BCN',1,1], ['GCS','DHC',3,2], ['GCS','GWN',0,3],
        ['GCS','GJU',1,1], ['GCS','ICU',0,3], ['GCS','JSK',1,1], ['GCS','JHM',1,1], ['GCS','PHS',1,1], ['GCS','SEO',0,0],
        ['GCS','USH',1,2], ['GJU','AYG',2,5], ['GJU','BCN',0,1], ['GJU','DHC',0,5], ['GJU','GWN',0,0], ['GJU','GCS',1,1],
        ['GJU','ICU',3,2], ['GJU','JSK',1,2], ['GJU','JHM',0,0], ['GJU','PHS',0,3], ['GJU','SEO',0,1], ['GJU','USH',1,1],
        ['ICU','AYG',0,1], ['ICU','BCN',1,1], ['ICU','DHC',1,3], ['ICU','GWN',0,1], ['ICU','GCS',2,1], ['ICU','GJU',4,0],
        ['ICU','JSK',1,0], ['ICU','JHM',1,0], ['ICU','PHS',0,1], ['ICU','SEO',1,2], ['ICU','USH',1,2], ['JSK','AYG',1,2],
        ['JSK','BCN',1,0], ['JSK','DHC',0,0], ['JSK','GWN',1,1], ['JSK','GCS',1,1], ['JSK','GJU',0,0], ['JSK','ICU',3,3],
        ['JSK','JHM',0,2], ['JSK','PHS',2,1], ['JSK','SEO',1,2], ['JSK','USH',0,2], ['JHM','AYG',2,1], ['JHM','BCN',2,3],
        ['JHM','DHC',0,0], ['JHM','GWN',1,2], ['JHM','GCS',1,0], ['JHM','GJU',4,0], ['JHM','ICU',1,2], ['JHM','JSK',1,3],
        ['JHM','PHS',3,2], ['JHM','SEO',0,0], ['JHM','USH',2,0], ['PHS','AYG',0,1], ['PHS','BCN',0,0], ['PHS','DHC',1,0],
        ['PHS','GWN',1,0], ['PHS','GCS',0,1], ['PHS','GJU',1,0], ['PHS','ICU',1,1], ['PHS','JSK',0,2], ['PHS','JHM',0,2],
        ['PHS','SEO',0,1], ['PHS','USH',0,2], ['SEO','AYG',0,0], ['SEO','BCN',3,0], ['SEO','DHC',0,1], ['SEO','GWN',0,0],
        ['SEO','GCS',2,3], ['SEO','GJU',5,0], ['SEO','ICU',1,0], ['SEO','JSK',2,1], ['SEO','JHM',1,0], ['SEO','PHS',3,1],
        ['SEO','USH',1,3], ['USH','AYG',3,1], ['USH','BCN',1,0], ['USH','DHC',1,4], ['USH','GWN',3,1], ['USH','GCS',0,0],
        ['USH','GJU',5,1], ['USH','ICU',1,2], ['USH','JSK',2,1], ['USH','JHM',1,3], ['USH','PHS',0,1], ['USH','SEO',1,4],
        ['AYG','GWN',0,3], ['AYG','ICU',2,1], ['AYG','JHM',1,1], ['AYG','SEO',0,7], ['AYG','USH',2,1], ['BCN','AYG',1,1],
        ['BCN','DHC',0,5], ['BCN','GCS',0,2], ['BCN','GJU',0,3], ['BCN','JSK',2,2], ['BCN','JHM',3,2], ['BCN','PHS',3,0],
        ['DHC','AYG',3,2], ['DHC','GWN',3,0], ['DHC','GJU',3,2], ['DHC','JHM',2,1], ['DHC','PHS',2,2], ['DHC','USH',2,1],
        ['GWN','BCN',2,0], ['GWN','GJU',2,2], ['GWN','ICU',1,1], ['GWN','JSK',0,1], ['GWN','JHM',1,1], ['GWN','PHS',0,0],
        ['GCS','AYG',0,1], ['GCS','DHC',1,2], ['GCS','GWN',2,2], ['GCS','GJU',2,2], ['GCS','JHM',0,0], ['GJU','AYG',1,1],
        ['GJU','ICU',0,1], ['GJU','JSK',0,1], ['GJU','PHS',1,2], ['GJU','SEO',2,5], ['GJU','USH',4,3], ['ICU','BCN',2,1],
        ['ICU','DHC',1,1], ['ICU','GCS',1,1], ['ICU','JSK',3,1], ['ICU','JHM',1,1], ['ICU','PHS',3,0], ['JSK','AYG',2,0],
        ['JSK','DHC',3,1], ['JSK','GCS',0,0], ['JSK','PHS',1,2], ['JSK','SEO',2,1], ['JSK','USH',0,0], ['JHM','GJU',2,2],
        ['JHM','JSK',3,2], ['JHM','PHS',2,0], ['JHM','SEO',1,2], ['JHM','USH',1,0], ['PHS','AYG',0,0], ['PHS','GCS',0,0],
        ['PHS','SEO',2,1], ['SEO','BCN',1,0], ['SEO','DHC',4,2], ['SEO','GWN',1,1], ['SEO','GCS',2,2], ['SEO','ICU',1,0],
        ['USH','BCN',2,1], ['USH','GWN',2,3], ['USH','GCS',3,1], ['USH','ICU',2,1], ['USH','PHS',2,2], ['USH','SEO',1,0]
    ],
    // 남은 경기: [경기번호, 파이널, 라운드, 홈, 원정, 날짜]
    matches: [
        [1, 'A', 34, 'JHM', 'DHC', '2026-10-31'],
        [2, 'B', 34, 'GJU', 'GCS', '2026-10-31'],
        [3, 'A', 34, 'SEO', 'ICU', '2026-11-01'],
        [4, 'A', 34, 'USH', 'GWN', '2026-11-01'],
        [5, 'B', 34, 'AYG', 'BCN', '2026-11-01'],
        [6, 'B', 34, 'PHS', 'JSK', '2026-11-01'],
        [7, 'B', 35, 'GCS', 'AYG', '2026-11-07'],
        [8, 'B', 35, 'JSK', 'GJU', '2026-11-07'],
        [9, 'A', 35, 'DHC', 'ICU', '2026-11-08'],
        [10, 'A', 35, 'GWN', 'JHM', '2026-11-08'],
        [11, 'A', 35, 'SEO', 'USH', '2026-11-08'],
        [12, 'B', 35, 'BCN', 'PHS', '2026-11-08'],
        [13, 'A', 36, 'GWN', 'DHC', '2026-11-21'],
        [14, 'A', 36, 'ICU', 'USH', '2026-11-21'],
        [15, 'A', 36, 'JHM', 'SEO', '2026-11-21'],
        [16, 'B', 36, 'PHS', 'AYG', '2026-11-21'],
        [17, 'B', 36, 'GCS', 'JSK', '2026-11-22'],
        [18, 'B', 36, 'GJU', 'BCN', '2026-11-22'],
        [19, 'A', 37, 'SEO', 'DHC', '2026-11-28'],
        [20, 'B', 37, 'AYG', 'JSK', '2026-11-28'],
        [21, 'B', 37, 'BCN', 'GCS', '2026-11-28'],
        [22, 'B', 37, 'PHS', 'GJU', '2026-11-28'],
        [23, 'A', 37, 'ICU', 'GWN', '2026-11-29'],
        [24, 'A', 37, 'USH', 'JHM', '2026-11-29'],
        [25, 'B', 38, 'AYG', 'GJU', '2026-12-05'],
        [26, 'B', 38, 'GCS', 'PHS', '2026-12-05'],
        [27, 'B', 38, 'JSK', 'BCN', '2026-12-05'],
        [28, 'A', 38, 'DHC', 'USH', '2026-12-06'],
        [29, 'A', 38, 'GWN', 'SEO', '2026-12-06'],
        [30, 'A', 38, 'JHM', 'ICU', '2026-12-06']
    ],
    results: {1: [0, 0], 2: [1, 1], 3: [0, 1], 4: [2, 1], 5: [2, 1], 6: [1, 1]}
};
