<?php
// K리그1 파이널 라운드 결과 자동 반영 (위키백과 "2026 K League 1" 원문 기준)
//
//   php update_kleague.php                 위키에서 받아 반영
//   php update_kleague.php --dry-run       바뀔 내용만 보여주고 파일은 그대로
//   php update_kleague.php --wiki=파일     받은 원문 대신 로컬 파일로 시험 (--today=날짜 와 같이)
//
// 안전장치
//   - 경기 날짜(한국 시간)가 오늘보다 뒤인 경기의 결과는 받지 않아요 (장난 편집 대비)
//   - 이미 반영한 결과가 위키에서 바뀌면 덮어쓰지 않고 로그에 남겨요 (고칠 땐 데이터 파일을 직접 수정)
//   - 33라운드까지 198경기 결과가 데이터 파일과 하나라도 다르면 아무것도 바꾸지 않아요
//   - 점수는 0~20 사이 숫자만 받아요
date_default_timezone_set('Asia/Seoul');

$ROOT = dirname(__DIR__) . '/public';                               // 사이트 원본 폴더 (Cloudflare에 올라가는 곳)
$MIRROR = 'C:/xampp/htdocs/cup';                                     // 로컬 확인용 복사본 (GitHub Actions처럼 없으면 건너뜀)
$DATA = $ROOT . '/data/kleague2026.js';
$PAGE = $ROOT . '/kleague.html';
$LOG = __DIR__ . '/logs/kleague.log';
$WIKI_URL = 'https://en.wikipedia.org/w/index.php?title=2026_K_League_1&action=raw';

$opts = getopt('', ['dry-run', 'wiki:', 'today:']); // --today=YYYY-MM-DD 는 시험용
$dry = isset($opts['dry-run']);

function logline($msg)
{
    global $LOG;
    if (!is_dir(dirname($LOG))) mkdir(dirname($LOG), 0777, true);
    $line = date('Y-m-d H:i:s') . ' ' . $msg;
    file_put_contents($LOG, $line . PHP_EOL, FILE_APPEND);
    echo $line . PHP_EOL;
}

function fail($msg)
{
    logline('중단: ' . $msg);
    exit(1);
}

// 위키 원문 받기
if (isset($opts['wiki'])) {
    $wiki = @file_get_contents($opts['wiki']);
} else {
    $ctx = stream_context_create(['http' => ['header' => "User-Agent: cup-sim/0.1 (personal fan project; contact via site)\r\n", 'timeout' => 30]]);
    $wiki = @file_get_contents($WIKI_URL, false, $ctx);
}
if (!$wiki || strlen($wiki) < 10000) fail('위키 원문을 받지 못했어요');

// 데이터 파일 읽기
$js = file_get_contents($DATA);
if (!$js) fail('데이터 파일을 읽지 못했어요');
preg_match_all("/\[(\d+), '([AB])', (\d+), '([A-Z]{3})', '([A-Z]{3})', '(\d{4}-\d\d-\d\d)'\]/", $js, $mm, PREG_SET_ORDER);
$fixtures = [];
foreach ($mm as $m) $fixtures[$m[4] . '_' . $m[5]] = ['id' => (int)$m[1], 'date' => $m[6]];
if (count($fixtures) !== 30) fail('데이터 파일의 남은 경기가 30개가 아니에요 (' . count($fixtures) . ')');
preg_match_all("/\['([A-Z]{3})','([A-Z]{3})',(\d+),(\d+)\]/", $js, $pp, PREG_SET_ORDER);
$known = [];
foreach ($pp as $p) $known[$p[1] . '_' . $p[2]][] = $p[3] . '-' . $p[4];
if (!preg_match('/results: \{([^}]*)\}/', $js, $rm)) fail('데이터 파일에서 results를 찾지 못했어요');
$results = [];
preg_match_all('/(\d+): \[(\d+), (\d+)\]/', $rm[1], $rr, PREG_SET_ORDER);
foreach ($rr as $r) $results[(int)$r[1]] = [(int)$r[2], (int)$r[3]];

// 위키 원문에서 점수 뽑기
function score($v)
{
    $v = trim(str_replace('–', '-', $v));
    $v = preg_replace('/^\[\[[^|\]]*\|(.*)\]\]$/', '$1', $v); // [[#링크|2-1]] → 2-1
    if (preg_match('/^(\d{1,2})\s*-\s*(\d{1,2})$/', $v, $s) && $s[1] <= 20 && $s[2] <= 20) return [(int)$s[1], (int)$s[2]];
    return null;
}
$sec = ''; $regular = []; $final = [];
foreach (preg_split('/\r?\n/', $wiki) as $line) {
    if (preg_match('/^===+\s*(.+?)\s*===+$/', $line, $m)) { $sec = $m[1]; continue; }
    if (!preg_match('/^\|\s*match_([A-Z]{3})_([A-Z]{3})\s*=\s*(.*)$/', $line, $m)) continue;
    $s = score($m[3]);
    if (in_array($sec, ['Matches 1–22', 'Matches 23–33'], true)) {
        if ($s) $regular[$m[1] . '_' . $m[2]][] = $s[0] . '-' . $s[1];
    } elseif (in_array($sec, ['Final A', 'Final B'], true)) {
        if ($s) $final[$m[1] . '_' . $m[2]] = $s;
    }
}

// 33라운드까지 결과가 데이터 파일과 같은지 (위키 구조가 바뀌었거나 훼손됐으면 멈춰요)
$count = 0;
foreach ($regular as $k => $list) $count += count($list);
if ($count !== 198) fail('위키의 정규 라운드 경기 수가 198이 아니에요 (' . $count . ')');
foreach ($regular as $k => $list) {
    $a = $list; $b = $known[$k] ?? []; sort($a); sort($b);
    if ($a !== $b) fail("정규 라운드 결과가 데이터와 달라요: $k 위키 " . implode(',', $list) . ' / 데이터 ' . implode(',', $known[$k] ?? []));
}

// 파이널 라운드 결과 반영
$today = isset($opts['today']) ? $opts['today'] : date('Y-m-d');
$added = []; $skipped = [];
foreach ($final as $k => $s) {
    if (!isset($fixtures[$k])) { $skipped[] = "$k: 남은 경기 목록에 없는 대진"; continue; }
    $f = $fixtures[$k];
    if ($f['date'] > $today) { $skipped[] = "$k: 경기 날짜({$f['date']}) 전이라 받지 않음"; continue; }
    if (isset($results[$f['id']])) {
        if ($results[$f['id']] !== $s) $skipped[] = "$k: 이미 반영한 결과(" . implode('-', $results[$f['id']]) . ')와 위키(' . implode('-', $s) . ')가 달라요. 직접 확인해 주세요';
        continue;
    }
    $results[$f['id']] = $s;
    $added[] = "{$f['id']}번 $k " . $s[0] . '-' . $s[1];
}
foreach ($skipped as $s) logline('건너뜀 ' . $s);
if (!$added) { logline('새 결과 없음 (반영된 결과 ' . count($results) . '/30)'); exit(0); }
logline('새 결과: ' . implode(', ', $added));
if ($dry) { logline('--dry-run이라 파일은 그대로 둬요'); exit(0); }

// 데이터 파일 쓰기: results와 반영 시각
ksort($results);
$body = implode(', ', array_map(function ($id, $s) { return "$id: [{$s[0]}, {$s[1]}]"; }, array_keys($results), $results));
$js = preg_replace('/results: \{[^}]*\}/', 'results: {' . $body . '}', $js);
$stamp = date('Y-m-d H:i');
if (preg_match("/updated: '[^']*'/", $js)) $js = preg_replace("/updated: '[^']*'/", "updated: '$stamp'", $js);
else $js = str_replace("    name: '2026 K리그1',", "    name: '2026 K리그1',\n    updated: '$stamp', // 결과를 마지막으로 반영한 시각 (자동)", $js);
file_put_contents($DATA, $js);

// 브라우저가 옛 데이터를 쓰지 않게 페이지의 데이터 주소 버전을 바꿔요
$ver = date('YmdHi');
$html = file_get_contents($PAGE);
$html = preg_replace('/data\/kleague2026\.js\?v=[0-9]+/', 'data/kleague2026.js?v=' . $ver, $html);
file_put_contents($PAGE, $html);

if (is_dir($MIRROR)) {
    copy($DATA, $MIRROR . '/data/kleague2026.js');
    copy($PAGE, $MIRROR . '/kleague.html');
}
logline('반영 완료 (결과 ' . count($results) . '/30, 데이터 버전 ' . $ver . ')');
