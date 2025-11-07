<?php
$sub_menu = '600400';
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '스노보드 티칭1 시험 관리';





include_once('./admin.head.php');


$css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, './css/sbak_css.css');
add_stylesheet('<link rel="stylesheet" href="' . $css_file . '">', 1);

$event_code = "B04";

$sql_1 = " select Event_year from SBAK_OFFICE_CONF where Event_code like '{$event_code}' ";
$row_1 = sql_fetch($sql_1);
$default_year = $row_1['Event_year']; //환경설정의 기본년도를 가져온다.



$colspan = 8;
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '">처음</a>'; //페이지 처음으로 (초기화용도)

$sql_common = " from SBAK_T1_TEST ";

//조회년도가 없으면 기본년도로 지정
if (!$sst) {
    $sst = $default_year;
  }    

  $set_today = date("Y-m-d");
  $event_year = $sst;  


$sort_url = G5_ADMIN_URL . "/sbak_T1_test_list_sb.php?sst={$sst}&sfl=T_where&stx=";


//해당 년도에 해당하는 데이터만  
$sql_search = " where (TEST_YEAR = {$sst} and TYPE = 2) ";



if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        
        case 'T_name':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        case 'T_mb_id':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break; 
        case 'T_date':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;            
        case 'T_code':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;            
        case 'T_where':
             $sql_search .= " ({$sfl} = '{$stx}') ";
             break;           
        default:
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}


$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1)
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            order by UID desc
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);











$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';



$sql = " select * {$sql_common} {$sql_search} {$sql_order} order by UID desc limit {$from_record}, {$rows} ";
$result = sql_query($sql);


// YP 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '1' ";
$row = sql_fetch($sql);
$YP_count = $row['cnt'];

// MJ 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '4' ";
$row = sql_fetch($sql);
$MJ_count = $row['cnt'];

// VP 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '5' ";
$row = sql_fetch($sql);
$VP_count = $row['cnt'];

// PP 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '6' ";
$row = sql_fetch($sql);
$PP_count = $row['cnt'];

// WP 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '7' ";
$row = sql_fetch($sql);
$WP_count = $row['cnt'];

// JS 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '8' ";
$row = sql_fetch($sql);
$JS_count = $row['cnt'];

// EK 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '9' ";
$row = sql_fetch($sql);
$EK_count = $row['cnt'];

// OV 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '10' ";
$row = sql_fetch($sql);
$OV_count = $row['cnt'];

// HO 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '11' ";
$row = sql_fetch($sql);
$HO_count = $row['cnt'];

// KJ 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '12' ";
$row = sql_fetch($sql);
$KJ_count = $row['cnt'];

// AP 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '13' ";
$row = sql_fetch($sql);
$AP_count = $row['cnt'];

// ED 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '15' ";
$row = sql_fetch($sql);
$ED_count = $row['cnt'];

// OT 회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and T_skiresort = '16' ";
$row = sql_fetch($sql);
$OT_count = $row['cnt'];
?>

<div class="local_sch local_sch01">
    


        <div class="local_ov01 local_ov">
            <?php echo $listall ?>
            <span class="btn_ov01"><span class="ov_txt">총 등록건수 </span><span class="ov_num">
                    <?php echo number_format($total_count) ?>건 
                    
                </span></span>

            <a href="<?php echo $sort_url . "모나파크용평";?>" class="btn_ov01"><span class="ov_txt">모나파크용평 </span><span class="ov_num">
                    <?php echo number_format($YP_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "무주덕유산";?>" class="btn_ov01"><span class="ov_txt">무주덕유산 </span><span class="ov_num">
                    <?php echo number_format($MJ_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "비발디파크";?>" class="btn_ov01"><span class="ov_txt">비발디파크 </span><span class="ov_num">
                    <?php echo number_format($VP_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "휘닉스평창";?>" class="btn_ov01"><span class="ov_txt">휘닉스평창 </span><span class="ov_num">
                    <?php echo number_format($PP_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "웰리힐리파크";?>" class="btn_ov01"><span class="ov_txt">웰리힐리파크 </span><span class="ov_num">
                    <?php echo number_format($WP_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "지산포레스트";?>" class="btn_ov01"><span class="ov_txt">지산포레스트 </span><span class="ov_num">
                    <?php echo number_format($JS_count) ?>건 
                </span></a>                
            <a href="<?php echo $sort_url . "오크밸리";?>" class="btn_ov01"><span class="ov_txt">오크밸리 </span><span class="ov_num">
                    <?php echo number_format($OV_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "하이원리조트";?>" class="btn_ov01"><span class="ov_txt">하이원리조트 </span><span class="ov_num">
                    <?php echo number_format($HO_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "곤지암리조트";?>" class="btn_ov01"><span class="ov_txt">곤지암리조트 </span><span class="ov_num">
                    <?php echo number_format($KJ_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "알펜시아";?>" class="btn_ov01"><span class="ov_txt">알펜시아 </span><span class="ov_num">
                    <?php echo number_format($AP_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "베어스타운";?>" class="btn_ov01"><span class="ov_txt">베어스타운 </span><span class="ov_num">
                    <?php echo number_format($BT_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "에덴벨리";?>" class="btn_ov01"><span class="ov_txt">에덴벨리 </span><span class="ov_num">
                    <?php echo number_format($ED_count) ?>건 
                </span></a>
            <a href="<?php echo $sort_url . "오투리조트";?>" class="btn_ov01"><span class="ov_txt">오투리조트 </span><span class="ov_num">
                    <?php echo number_format($OT_count) ?>건 
                </span></a> 
           
        </div>

         <div>
            <table width="100%">
                <tr>
                    <td>
                      <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">
                            <label for="sch_sort" class="sound_only">검색분류</label>
                            <select name="sst" id="sch_sort" class="search_sort">
                                <?php
                                    //년도별 검색을 위해
                                    $sql_123 = "select TEST_YEAR from SBAK_T1_TEST group by TEST_YEAR order by TEST_YEAR desc ";
                                    $result123 = sql_query($sql_123);


                                    for($i = 0; $row = sql_fetch_array($result123); $i++){  //년도 카테고리를 갖고와서 갯수만큼 옵션 형성                   
                                        $THE_YEAR = $row['TEST_YEAR'];                  
                                        echo "<option value='".$THE_YEAR."' ". get_selected($sst, $THE_YEAR)." >".$THE_YEAR."년</option>" ;
                                    }
                                ?>

                            </select> 
                            <select name="sfl" id="sch_sort" class="search_sort">
                                <option value="T_name" <?php echo get_selected($sfl, 'T_name'); ?>>등록자</option>
                                <option value="T_mb_id" <?php echo get_selected($sfl, 'T_mb_id'); ?>>ID</option>
                                <option value="T_code" <?php echo get_selected($sfl, 'T_code'); ?>>코드</option>
                                <option value="T_where" <?php echo get_selected($sfl, 'T_where'); ?>>스키장</option>
                            </select>
                            <label for="sch_word" class="sound_only">검색어</label>
                            <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word"
                                class="frm_input">
                            <input type="submit" value="검색" class="btn_submit">
                        </form>
                    </td>
                    <td align="right">
                      <form name="frm_toexcel" method="post" action="./sbak_T1_test_list_xls.php">
                        시험일 : <input type="date" name="from_date" size="20" value="<?php echo stripslashes($stx); ?>"  class="frm_input">  ~      
                         <input type="date" name="to_date" size="20" value="<?php echo stripslashes($stx); ?>"  class="frm_input">   
                         <input type="hidden" name="to_sport" value="sb">      
                         <input type="submit" value="EXCEL">
                      </form>               
                    </td>

            </tr>
        </table>
        </div>  
   
</div>


<form name="ksia_license_list" id="ksia_license_list" action="./sbak_T1_list_update.php"
    onsubmit="return ksia_license_list_submit(this);" method="post">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">





    <div class="tbl_wrap tbl_head01">
        <table>
            <thead>
                <tr>
                    <th scope="col">
                        <label for="chkall" class="sound_only">그룹 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col" width="20%">심사위원</th>
                    <th scope="col" width="15%">일정/장소</th>
                    
                    <th scope="col" width="10%">응시인원</th>
                    <th scope="col" width="5%">응시료</th>
                    <th scope="col" width="5%">신청시작일</th>
                    <th scope="col" width="5%">신청마감일</th>
                    <th scope="col" width="5%">결과등록일</th>
                    <th scope="col" width="5%">SMS</th>
                    <th scope="col" width="15%">메모</th>
                    <th scope="col" width="10%">관리</th>


                </tr>
            </thead>
            <tbody>
                <?php


                for ($i = 0; $row = sql_fetch_array($result); $i++) {



                    $link = "";
                    $referer = "";
                    $title = "";



                    $bg = 'bg' . ($i % 2);
                    ?>
                    <tr class="<?php echo $bg; ?>">

                        <td class="td_chk">
                            <input type="hidden" name="UID[<?php echo $i ?>]" value="<?php echo $row['UID'] ?>">
                            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['T_mb_id']); ?>
                                지도자</label>
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">

                        </td>
                        <td class="td_left">
                              <h1 class="pageSubTitle"> <i class="fa fa-user" aria-hidden="true"></i> <?php echo $row['T_name']; ?> ( <?php echo $row['T_mb_id']; ?> ) </h1>
                              <i class="fa fa-dot-circle-o" aria-hidden="true"></i> 코드 : <?php echo $row['T_code']; ?> 
                              <a href="#" class="button btnRadius">
                                <?php
                                if ($row['TYPE'] == 1) {
                                    echo "<span class='box_ksia_blue'>SKI</span>";
                                }elseif ($row['TYPE'] == 2) {
                                    echo "<span class='box_ksia_orange'>SB</span>";
                                }
                                ?>
                              </a>
                              
                              <br>       
                              <i class="fa fa-dot-circle-o" aria-hidden="true"></i> 등록일 :<?php echo $row['T_regis_date']; ?>
                            <input type="text" name="T_tel[<?php echo $i ?>]" value="<?php echo $row['T_tel']; ?>" 
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>
                          
                        </td>
                        <td>
                     
                            
                            <input type="date" name="T_date[<?php echo $i ?>]" value="<?php echo $row['T_date']; ?>" 
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>
                            <input type="text" name="T_time[<?php echo $i ?>]" value="<?php echo $row['T_time']; ?>" 
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>
                       
 
                            
                            <input type="text" name="T_where[<?php echo $i ?>]" readonly  value="<?php echo $row['T_where']; ?>" 
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>

                            <input type="text" name="T_meeting[<?php echo $i ?>]" value="<?php echo $row['T_meeting']; ?>" 
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>


                       
                        </td>


                        <td>
                           <input type="text" name="limit_member[<?php echo $i ?>]" value="<?php echo $row['limit_member']; ?>" 
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>

                            <?php
                             $query = "select count(*) as CNT from SBAK_T1_TEST_Apply where T_code = '{$row['T_code']}'";
                             $get_result = sql_fetch($query);
                             $student_cnt1 = $get_result['CNT'];

                             $query = "select count(*) as CNT from SBAK_T1_TEST_Apply where T_code = '{$row['T_code']}' and (T_status != '88' and T_status != '99') and PAYMENT_STATUS < 3";
                             $get_result = sql_fetch($query);
                             $student_cnt2 = $get_result['CNT'];
                             $valid_cnt = $student_cnt2;

                             $query = "select count(*) as CNT from SBAK_T1_TEST_Apply where T_code = '{$row['T_code']}' and (T_status = '88' or T_status = '99')";
                             $get_result = sql_fetch($query);
                             $student_cnt3 = $get_result['CNT'];

                             $valid_cnt = $student_cnt1 - $student_cnt3;
                             

                                $student_cnt2 = $student_cnt2."(입금)";
                             
                            ?>
                            <a href="./sbak_T1_test_detail_info.php?t_code=<?php echo $row['T_code']; ?>" class="button btnFade btnBlueGreen">응시자정보</a>
                        </td>
                        <td>


                          
                            <input type="number" name="PAYMENT_AMOUNT[<?php echo $i ?>]" readonly value="<?php echo $row['PAYMENT_AMOUNT']; ?>" placeholder="응시료"  
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>

                        </td>
 
                         <td>
                            <input type="date" name="Application_Day[<?php echo $i ?>]" value="<?php echo $row['Application_Day']; ?>" 
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>
                        </td>
                        
                        <td>
                            <input type="date" name="Expired_Day[<?php echo $i ?>]" value="<?php echo $row['Expired_Day']; ?>" 
                            <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='tbl_input'"; } ?>>

                        </td>
                        
                        <td>
                            <?php echo $row['RESULT_DATE']; ?>

                        </td>
                        <td>
                             <?php 
                                if (!empty($row['SMS_MSG'])) {
                                   echo "<i class='fa fa-envelope' aria-hidden='true'></i>".$row['SMS_MSG']." <span style='color:red;'>[".$row['SMS_TIME']."]</span>"; 
                                }
                             ?> 
                        
                        </td>

                        <td>
                            <?php
                             if (date("Y-m-d") > $row['T_date']) {
                                echo "<span class='btnOrange'><i class='fa fa-info-circle' aria-hidden='true'></i>시험일 경과</span>";
                             }



                               if (date("Y-m-d") > $row['Expired_Day']){
                                  echo "<br><span class='btnPurple'><i class='fa fa-info-circle' aria-hidden='true'></i>응시자등록마감일 경과</span>";
                               }

        
                            ?>

                            <textarea name="T_memo[<?php echo $i ?>]" placeholder="메모사항" 
                          <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>
                          style="resize: none ; display: block ; width: 100%; height: 20px; border: solid 2px #1E90FF;border-radius: 5px;"><?php echo $row['T_memo']; ?>
                           </textarea>
                       
                        </td>
                        
                        <td>



                            <input type="radio" name="T_status[<?php echo $i; ?>]" value="77" id="T_status_<?php echo $i; ?>" <?php if ($row['T_status'] == '77') { echo 'checked';} ?>>
                            <label for="t_status_<?php echo $i; ?>">승인</label><br>
                            <input type="radio" name="T_status[<?php echo $i; ?>]" value="<?php echo $row['T_status'] == "88" ? "88": "99";  ?>" id="T_status_<?php echo $i; ?>" <?php if ($row['T_status'] == '88' or $row['T_status'] == '99') { echo 'checked';} ?>>
                            <label for="t_status_<?php echo $i; ?>">삭제</label>
                            <?php if ($row['T_status'] == '88') {
                               echo "<br>(사무국)";  
                            } elseif ($row['T_status'] == '99') {
                                   echo "<br>(본인)"; } ?>

                            <br><span class="btnOrange"><i class="fa fa-info-circle" aria-hidden="true"></i> 변경 : <?php echo $row['T_status_date']; ?> </span>
                        </td>

                    </tr>
                <?php } ?>
                <?php if ($i == 0)
                    echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>'; ?>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">



    </div>


</form>

<?php
$domain = isset($domain) ? $domain : '';
$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;domain=' . $domain . '&amp;page=');
if ($pagelist) {
    echo $pagelist;
}
?>

<script>
    $(function () {
        $("#sch_sort").change(function () { // select #sch_sort의 옵션이 바뀔때
            if ($(this).val() == "vi_date") { // 해당 value 값이 vi_date이면
                $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
            } else { // 아니라면
                $("#sch_word").datepicker("destroy"); // datepicker 미실행
            }
        });

        if ($("#sch_sort option:selected").val() == "vi_date") { // select #sch_sort 의 옵션중 selected 된것의 값이 vi_date라면
            $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
        }
    });

    function fvisit_submit(f) {
        return true;
    }
</script>

<script>
    function ksia_license_list_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                return false;
            }
        }

        return true;
    }
</script>

<?php
include_once('./admin.tail.php');