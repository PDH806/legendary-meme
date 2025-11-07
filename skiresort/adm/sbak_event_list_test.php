<?php
include_once('./_common.php');


$raw_ids = isset($_POST['message']) ? trim($_POST['message']) : '';


// // 값이 비었는지 확인
// if (empty($raw_ids)) {
//     echo "<script>
//         alert('입력값이 비어있습니다.');
//         history.back();
//     </script>";
//     exit;
// }

$member_ids = preg_split('/[\s,]+/', $raw_ids, -1, PREG_SPLIT_NO_EMPTY);

$event_code = isset($_POST['list_code']) ? trim($_POST['list_code']) : ''; // 스키,보드
$event_sort = isset($_POST['list_sort']) ? trim($_POST['list_sort']) : ''; // 실기.필기

// 값 유효성 검사
if (empty($event_code) || empty($event_sort)) {
    echo "<script>
        alert('오류가 발생했습니다.');
        history.back();
    </script>";
    exit;
}



// 1️⃣ 존재하지 않는 회원 확인
if (!empty($member_ids)) {

$invalid_ids = [];

foreach ($member_ids as $mb_id) {
    $mb_id = trim($mb_id);
    $row = sql_fetch("SELECT COUNT(*) AS cnt FROM g5_member WHERE mb_id = '{$mb_id}'");

    if ($row['cnt'] == 0) {
        $invalid_ids[] = $mb_id; // 존재하지 않음
    }
}

// 2️⃣ 누락된 회원이 있으면 전체 중단
if (count($invalid_ids) > 0) {
    echo "<script>
        alert('다음 회원은 존재하지 않아 작업이 중단되었습니다:\\n" . implode("\\n", $invalid_ids) . "');
        history.back();
    </script>";
    exit;
}

}

// 3️⃣ 모든 회원 존재 → 일괄 UPDATE 실행


    if($event_sort == 'A'){ // 필기면제
    $sql = "UPDATE SBAK_OFFICE_CONF
            SET EXEMPT_MEMBER_A = '{$raw_ids}' WHERE Event_code = '{$event_code}'";
    } else { // 실기면제
    $sql = "UPDATE SBAK_OFFICE_CONF
            SET EXEMPT_MEMBER_B = '{$raw_ids}' WHERE Event_code = '{$event_code}'";
    }
    
    sql_query($sql);
    // echo $sql;



$goto_url = G5_ADMIN_URL . "/sbak_event_list_" . $event_code . ".php";

echo "<script>
    alert('모든 회원(" . count($member_ids) . "명)의 데이터가 성공적으로 업데이트되었습니다.');
    location.href = '{$goto_url}';
</script>";
exit;
?>
