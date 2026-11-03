<?php
// UEFA 네이션스리그 2026-27 리그 A 5·6차전 결과 자동 반영 (위키백과 "2026–27 UEFA Nations League A" 원문 기준)
//
//   php update_unl.php                 위키에서 받아 반영
//   php update_unl.php --dry-run       바뀔 내용만 보여주고 파일은 그대로
//   php update_unl.php --wiki=파일     받은 원문 대신 로컬 파일로 시험 (--now="YYYY-MM-DD HH:MM" 과 같이)
//
// 안전장치
//   - 킥오프(한국 시간) 2시간 뒤부터만 결과를 받아요 (장난 편집 대비)
//   - 이미 반영한 결과가 위키에서 바뀌면 덮어쓰지 않고 로그에 남겨요 (고칠 땐 데이터 파일을 직접 수정)
//   - 4차전까지 32경기 결과가 데이터 파일과 하나라도 다르면 아무것도 바꾸지 않아요
//   - 점수는 0~20 사이 숫자만 받아요
date_default_timezone_set('Asia/Seoul');

$ROOT = dirname(__DIR__) . '/public';
$MIRROR = 'C:/xampp/htdocs/cup';
$DATA = $ROOT . '/data/unl2026a.js';
$PAGE = $ROOT . '/nations.html';
$LOG = __DIR__ . '/logs/unl.log';
$WIKI_URL = 'https://en.wikipedia.org/w/index.php?title=2026%E2%80%9327_UEFA_Nations_League_A&action=raw';
$LEFT = 16;

$opts = getopt('', ['dry-run', 'wiki:', 'now:']);
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

if (isset($opts['wiki'])) {
    $wiki = @file_get_contents($opts['wiki']);
} else {
    $ctx = stream_context_create(['http' => ['header' => "User-Agent: cup-sim/0.1 (personal fan project; contact via site)\r\n", 'timeout' => 30]]);
    $wiki = @file_get_contents($WIKI_URL, false, $ctx);
}
if (!$wiki || strlen($wiki) < 10000) fail('위키 원문을 받지 못했어요');

$js = file_get_contents($DATA);
if (!$js) fail('데이터 파일을 읽지 못했어요');
preg_match_all("/\[(\d+), (\d), ([56]), '([A-Z]{3})', '([A-Z]{3})', '(\d{4}-\d\d-\d\d \d\d:\d\d)'\]/", $js, $mm, PREG_SET_ORDER);
$fixtures = [];
foreach ($mm as $m) $fixtures[$m[4] . '_' . $m[5]] = ['id' => (int)$m[1], 'kickoff' => $m[6]];
if (count($fixtures) !== $LEFT) fail("데이터 파일의 남은 경기가 {$LEFT}개가 아니에요 (" . count($fixtures) . ')');
preg_match_all("/\[\d, '([A-Z]{3})', '([A-Z]{3})', (\d+), (\d+)\]/", $js, $pp, PREG_SET_ORDER);
$known = [];
foreach ($pp as $p) $known[$p[1] . '_' . $p[2]] = $p[3] . '-' . $p[4];
if (count($known) !== 32) fail('데이터 파일의 끝난 경기가 32개가 아니에요 (' . count($known) . ')');
if (!preg_match('/results: \{([^}]*)\}/', $js, $rm)) fail('데이터 파일에서 results를 찾지 못했어요');
$results = [];
preg_match_all('/(\d+): \[(\d+), (\d+)\]/', $rm[1], $rr, PREG_SET_ORDER);
foreach ($rr as $r) $results[(int)$r[1]] = [(int)$r[2], (int)$r[3]];

// 위키 원문의 경기 상자(Football box)에서 대진과 점수 뽑기
$wiki = str_replace(['–', '&ndash;'], '-', $wiki);
preg_match_all('/\{\{Football box(.*?)\n\}\}/s', $wiki, $bs);
$wikiScores = [];
foreach ($bs[1] as $b) {
    if (!preg_match('/\|\s*team1\s*=\s*\{\{fb-rt\|([A-Z]{3})\}\}/', $b, $h)) continue;
    if (!preg_match('/\|\s*team2\s*=\s*\{\{fb\|([A-Z]{3})\}\}/', $b, $a)) continue;
    if (!preg_match('/\|\s*score\s*=\s*([^\n|]*)/', $b, $s)) continue;
    $v = trim(preg_replace('/^\[\[[^|\]]*\|(.*)\]\]$/', '$1', trim($s[1])));
    if (preg_match('/^(\d{1,2})\s*-\s*(\d{1,2})$/', $v, $x) && $x[1] <= 20 && $x[2] <= 20) $wikiScores[$h[1] . '_' . $a[1]] = [(int)$x[1], (int)$x[2]];
}

// 4차전까지 결과가 데이터 파일과 같은지 (위키 구조가 바뀌었거나 훼손됐으면 멈춰요)
foreach ($known as $k => $v) {
    if (!isset($wikiScores[$k])) fail("위키에서 끝난 경기를 찾지 못했어요: $k");
    if (implode('-', $wikiScores[$k]) !== $v) fail("끝난 경기 결과가 데이터와 달라요: $k 위키 " . implode('-', $wikiScores[$k]) . " / 데이터 $v");
}

$now = isset($opts['now']) ? strtotime($opts['now']) : time();
$added = []; $skipped = [];
foreach ($fixtures as $k => $f) {
    if (!isset($wikiScores[$k])) continue;
    $s = $wikiScores[$k];
    if ($now < strtotime($f['kickoff']) + 2 * 3600) { $skipped[] = "$k: 경기({$f['kickoff']}) 끝나기 전이라 받지 않음"; continue; }
    if (isset($results[$f['id']])) {
        if ($results[$f['id']] !== $s) $skipped[] = "$k: 이미 반영한 결과(" . implode('-', $results[$f['id']]) . ')와 위키(' . implode('-', $s) . ')가 달라요. 직접 확인해 주세요';
        continue;
    }
    $results[$f['id']] = $s;
    $added[] = "{$f['id']}번 $k " . $s[0] . '-' . $s[1];
}
foreach ($skipped as $s) logline('건너뜀 ' . $s);
if (!$added) { logline("새 결과 없음 (반영된 결과 " . count($results) . "/$LEFT)"); exit(0); }
logline('새 결과: ' . implode(', ', $added));
if ($dry) { logline('--dry-run이라 파일은 그대로 둬요'); exit(0); }

ksort($results);
$body = implode(', ', array_map(function ($id, $s) { return "$id: [{$s[0]}, {$s[1]}]"; }, array_keys($results), $results));
$js = preg_replace('/results: \{[^}]*\}/', 'results: {' . $body . '}', $js);
$stamp = date('Y-m-d H:i', $now);
$js = preg_replace("/updated: '[^']*'/", "updated: '$stamp'", $js);
file_put_contents($DATA, $js);

$ver = date('YmdHi', $now);
$html = file_get_contents($PAGE);
$html = preg_replace('/data\/unl2026a\.js\?v=[0-9]+/', 'data/unl2026a.js?v=' . $ver, $html);
file_put_contents($PAGE, $html);

if (is_dir($MIRROR)) {
    @copy($DATA, $MIRROR . '/data/unl2026a.js');
    @copy($PAGE, $MIRROR . '/nations.html');
}
logline("반영 완료 (결과 " . count($results) . "/$LEFT, 데이터 버전 $ver)");
