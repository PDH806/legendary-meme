<?php
$sub_menu = '590900';
include_once('./_common.php');
add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/ksia_css.css">', 0);


auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '각종 행사 요강설정';
include_once('./admin.head.php');

$table = "SBAK_EVENT_RULE"; // 테이블명 받아오기

$_POST['is_update'] = isset($_POST['is_update']) ? $_POST['is_update'] : '';
if ($_POST['is_update'] == 'yes') {

    $UID = $_POST['UID'] ?? '';

    $Event_memo = $_POST['Event_memo'] ?? '';


    $sql = " update $table 
    set 
    
    Event_memo = '{$Event_memo}'
    where UID = {$UID}";

    sql_query($sql);
}



$colspan = 6;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)



$sql_common = " from $table order by Event_code  ";

$sql = " select * {$sql_common} ";
$result = sql_query($sql);


$sql = " select count(*) as cnt
            {$sql_common}";
$row2 = sql_fetch($sql);
$total_count = $row2['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1)
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            order by UID desc
            limit {$from_record}, {$rows} ";
$result2 = sql_query($sql);
?>



<div class="local_desc01 local_desc">
    <p>CODE 번호를 '행사접수환경설정'의 요강에 적용. 줄바꿈은 &lt;br&gt;</p>

</div>





<div class="tbl_wrap tbl_head01">
    <table>
        <thead>
            <tr>
                <th scope="col" width="5%">CODE</th>
                <th scope="col">접수요강</th>
                <th scope="col" width="5%">수정</th>

            </tr>
        </thead>
        <tbody>




            <?php


            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $uid = $row['UID'];




                $bg = 'bg' . ($i % 2);
            ?>

                <form name=frm method=post action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <input type="hidden" name="is_update" value="yes">
                    <input type="hidden" name="UID" value="<?php echo $row['UID']; ?>">

                    <tr class="<?php echo $bg; ?>" style="height: 200px;">

                          <td>
                            <span class='btn btn-primary'>
                                <?php echo $row['Event_code']; ?>
                            </span>
                        </td>

                        <td>
                            <textarea name="Event_memo" id="" cols="10" rows="1" style="width:100%; height:200px; resize:none;"
                                placeholder="기본안내사항" <?php if ($row['Event_code'] == 1) echo 'readonly'; ?>><?php echo $row['Event_memo']; ?></textarea>

                        </td>
                        <td>
                            <input type="submit" value="수정">
                        </td>
                    </tr>


                </form>


            <?php } ?>
            <?php if ($i == 0)
                echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>'; ?>


        </tbody>
    </table>
</div>

<?php
$domain = isset($domain) ? $domain : '';
$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;domain=' . $domain . '&amp;page=');
if ($pagelist) {
    echo $pagelist;
}


?>


<?php
include_once('./admin.tail.php');
