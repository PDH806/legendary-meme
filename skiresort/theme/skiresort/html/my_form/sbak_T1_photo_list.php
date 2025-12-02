<?php

include "../../../../common.php";
add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/sbak_css.css">', 0);

$sports = $_GET['sports'] ?? '';
$t_code = $_GET['t_code'] ?? '';

 if ($sports == 'ski') {

$event_code = 'B01';

 }else{ 

$event_code = 'B04';

 }



$sql_1 = " select Event_title_1, Event_year from SBAK_OFFICE_CONF where Event_code like '{$event_code}' ";

$row_1 = sql_fetch($sql_1);
$event_title_1 = $row_1['Event_title_1'] ?? '';

$event_year = $row_1['Event_year'] ?? '';


$g5['title'] = $event_title_1;


$sql_common = " from SBAK_T1_TEST_Apply ";
$sql_search = " where T_code like '{$t_code}' and PAYMENT_STATUS = 'Y' and (T_status != '88' and T_status != '99')";



$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 20;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1)
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            order by BIB_NO asc
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);




$sql_order_part = $sql_order ?? '';
$sql = " select * {$sql_common} {$sql_search} {$sql_order_part} order by BIB_NO asc limit {$from_record}, {$rows} ";
$result = sql_query($sql);


?>

<table width=100%>

    <tr>
        <td width=50% align=left>
            (총 엔트리 : <?php echo number_format($total_count)?>)

        </td>
        <td width=50% align=right>

    </tr>

</table>



<div class="tbl_wrap tbl_head01">
    <table>
        <tr>
            <td>

                <table width=650 cellspacing=0 cellpadding=0 bgcolor='#ffffff'>

                    <tr>

                        <?php
for ($i=0; $row=sql_fetch_array($result); $i++) {
    // 접근가능한 그룹수

    $group = "";
    $wr_id = $row['MEMBER_ID'] ?? '';
    $the_bib = $row['BIB_NO'] ?? '';  
        //$the_start = $row['the_start'];  
    $wr_name = $row['MEMBER_NAME']; 
        $icon_file2 = "../data/member_image/".$row['MEMBER_ID'].".jpg";
        $mb_img_path = G5_DATA_PATH.'/member_image/'.substr($row['MEMBER_ID'],0,2).'/'.get_mb_icon_name($row['MEMBER_ID']).'.jpg';   
        $icon_file2  = G5_DATA_URL.'/member_image/'.substr($row['MEMBER_ID'],0,2).'/'.get_mb_icon_name($row['MEMBER_ID']).'.jpg'; 
        if (file_exists($mb_img_path)) {
            $icon_file2 = $icon_file2;
        }else{  
           $icon_file2  = G5_SKIN_URL.'/board/basic/img/member_no_img.jpg'; 
        }
        $is_photo="<td><table width=150 border=1 height=200><tr><td><img src='". $icon_file2 ."' width=140></td></tr><tr><td height=20><b>[" . $the_bib . "] </b>&nbsp;&nbsp;" . $wr_name . "</td></tr></table>";





    $list = $i%2;
    $the_column = ($the_column ?? 0) + 1;

        echo $is_photo;
       if ($the_column == 5) {
          echo "</td></tr><table>";
          $the_column = 0;
       } else {
          echo "</td>";
          }

}
?>



            </td>
        </tr>
    </table>



    <?php
$domain = isset($domain) ? $domain : '';
$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;t_code=' . $t_code . '&amp;domain=' . $domain . '&amp;page=');
if ($pagelist) {
    echo $pagelist;
}


?>