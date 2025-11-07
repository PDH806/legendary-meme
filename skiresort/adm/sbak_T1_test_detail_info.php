<?php
$sub_menu = '600200';
include_once('./_common.php');



auth_check_menu($auth, $sub_menu, 'r');

if (empty($_GET['t_code'])) {
    alert("검정번호가 연동되지 않고 있습니다", $_SERVER['HTTP_REFERER']);
    exit;
} else {
    $T_CODE = $_GET['t_code'];
}



$g5['title'] = '티칭1 검정 응시자정보';
include_once('./admin.head.php');

$css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, './css/sbak_css.css');
add_stylesheet('<link rel="stylesheet" href="' . $css_file . '">', 1);



//검정 최종 확정 처리 초기화로 넘어오면
if ($_POST['RESET_score_state'] == 'yes') {  

    $sql = "update SBAK_T1_TEST set RESULT_DATE = '', RESULT_TIME ='' where T_code = '{$T_code}'";
    sql_query($sql);
    
    $sql = "update SBAK_T1_TEST_Apply set LICENSE_NO = '' where T_code = '{$T_code}'";
    sql_query($sql);
    alert('검정 최종 확정이 초기화되었습니다.!');

}    

// 검정 최종 확정 처리 초기화 끝



$sql = "select count(*) as CNT from SBAK_T1_TEST_Apply where T_code = '{$T_CODE}' and (PAYMENT_STATUS = 'Y')";
$row = sql_fetch($sql);
$CNT = $row['CNT'];

$sql = "select count(*) as CNT from SBAK_T1_TEST_Apply where T_code = '{$T_CODE}' and (PAYMENT_STATUS = 'C')";
$row = sql_fetch($sql);
$CNT2 = $row['CNT'];

$sql = "select count(*) as CNT from SBAK_T1_TEST_Apply where T_code = '{$T_CODE}' and PAYMENT_STATUS IN ('Y', 'C')";
$row = sql_fetch($sql);
$CNT3 = $row['CNT'];

$sql = " select count(*) as apply_cnt from SBAK_T1_TEST_Apply where T_code = '{$T_CODE}' ";
$row = sql_fetch($sql);
$total_count = $row['apply_cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1)
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함



$sql = "select * from SBAK_T1_TEST where T_code = '{$T_CODE}' ";
$result = sql_fetch($sql);



$SMS_T_name = $result['T_name'];
$SMS_T_date = $result['T_date'];
$SMS_T_tel = $result['T_tel'];
$SMS_T_meeting = $result['T_meeting'];
$SMS_T_time = $result['T_time'];
$SMS_T_code = $result['T_code'];
$SMS_T_where = $result['T_where'];
$SMS_T_status = $result['T_status'];



$get_mb_id = $result['T_mb_id'];

    // 회원이미지 경로
    $mb_img_path = G5_DATA_PATH . '/member_image/' . substr($get_mb_id, 0, 2) . '/' . get_mb_icon_name($get_mb_id) . '.jpg';
    $mb_img_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_img_path)) ? '?' . filemtime($mb_img_path) : '';
      $mb_img_url = G5_DATA_URL . '/member_image/' . substr($get_mb_id, 0, 2) . '/' . get_mb_icon_name($get_mb_id) . '.jpg' . $mb_img_filemtile;




      

?>


<div class="local_desc01 local_desc">
    <p>
       * 검정의 기본정보, 응시료의 입금처리 등은 검정등록현황 페이지를 이용하세요.
       <br>
       * 문자는, 관리자 및 응시자 모두에게 일괄 방송됩니다. (사전에 응시코드가 확정처리되어 있어야 확정버튼이 활성화되고, 응시코드가 확정상태가 아닐경우 (승인 또는 삭제)에만
        취소문자버튼이 활성화됩니다.)
    </p>
</div>



<div class="tbl_wrap tbl_head01">
    <table>
        <thead>
            <tr>

                <th scope="col">검정코드</th>
                <th scope="col">관리자</th>
                <th scope="col">검정일자</th>
                <th scope="col">검정장소</th>
                <th scope="col">종목</th>
                <th scope="col">응시인원</th>
                <th scope="col">진행현황</th>
                <th scope="col">점수최종확정</th>

                <th scope="col" width="20%">문자발송</th>

            </tr>
        </thead>
        <tbody>
            <tr>

                <td scope="col">
                    <?php echo $result['T_code']; ?>
                </td>
                <td scope="col">
                    <?php if (file_exists($mb_img_path)) { ?>
					  <img src="<?php echo $mb_img_url ?>" width=100 alt="회원이미지">
				  	<?php } else { ?>
					<img src="<?php echo G5_THEME_IMG_URL ?>/sbak_logo.jpg" width=100 alt="회원이미지">
                   	<?php } ?>
                     <br>

                    <?php echo $result['T_name']; ?> (
                    <?php echo $result['T_mb_id']; ?>) <br>
                    <?php echo $result['T_tel']; ?>

                    <?php
                       $arr_tel = array($result['T_tel']);

                    ?>
                </td>
                <td scope="col">
                    <?php echo $result['T_date']; ?> (
                    <?php echo $result['T_time']; ?>)
                </td>
                <td scope="col">
                    <?php echo $result['T_where']; ?><br>
                    <?php echo $result['T_meeting']; ?>
                </td>
                <td scope="col">

                    <?php
                    if ($result['TYPE'] == 1) {
                        $the_sports = '스키';
                        echo "<span class='box_ksia_blue'>SKI</span>";
                    } elseif ($result['TYPE'] == 2) {
                        $the_sports = '스노보드';
                        echo "<span class='box_ksia_orange'>SB</span>";
                    }
                    ?>
                </td>

                            
            <td scope="col">
                    <span class="apply"><?php echo $CNT; ?></span>

            </td>

                <td scope="col">
                    <?php if ($result['T_status'] == '77') {
                        echo "승인";
                    } else if ($result['T_status'] == '88' or $result['T_status'] == '99') {
                        echo "삭제";
                    }
                    $T_status_ofjudge = $result['T_status'];
                    ?>

                </td>
                <td scope="col">
                    <?php echo $result['RESULT_DATE']; ?>
                </td>

                <td>
                             <?php 
                                if (!empty($result['SMS_MSG'])) {
                                   echo "<i class='fa fa-envelope' aria-hidden='true'></i>".$result['SMS_MSG']." <span style='color:red;'>[".$result['SMS_TIME']."]</span>"; 
                                }
                             ?> 
                        
                        </td>              

            </tr>


        </tbody>
    </table>
</div>


<form name="ksia_license_list" id="ksia_license_list" action="./sbak_T1_test_detail_info_update.php"
    onsubmit="return ksia_license_list_submit(this);" method="post">

    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value=""> 
    <input type="hidden" name="T_code" value="<?php echo $result['T_code']; ?>">
 


<div class="tbl_wrap tbl_head01">
    <table>
        <thead>
               <tr>
                  <th scope="col" id="mb_list_chk" rowspan="2">
                        <label for="chkall" class="sound_only">회원 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                <th scope="col">응시자</th>
                <th scope="col">생년월일</th>
                <th scope="col">결제여부</th>
                <th scope="col">결제내역</th>
                <th scope="col">전화</th>
                <th scope="col">진행현황</th>
                <th scope="col">삭제</th>


            </tr>
        </thead>
        <tbody>

            <?php
            $sql = "select * from SBAK_T1_TEST_Apply where T_code = '{$T_CODE}' order by UID desc limit {$from_record}, {$rows}";
            $result = sql_query($sql);

            for ($i = 0; $row = sql_fetch_array($result); $i++) {


                $member_payment_status = $row['PAYMENT_STATUS'];
                if ($member_payment_status == 'Y') {
                    $member_payment_status = "<span class='box_sbak_label'>결제완료</span>";
                }  elseif ($member_payment_status == 'C') {
                    $member_payment_status = "<span class='box_sbak_red_label'>취소완료</span>";
                }



                ?>

                <tr>
                <td class="td_chk">
                        <input type="hidden" name="UID[<?php echo $i ?>]" value="<?php echo $row['UID'] ?>">
                            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['MEMBER_ID']); ?>
                                회원</label>
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                        </td>

                  <td><?php echo $row['MEMBER_NAME'] ?> (<?php echo $row['MEMBER_ID'] ?>)</td>
                  <td>
                    <?php 
                    $MB_ID =  $row['MEMBER_ID'];
                    $query = "select mb_2 from g5_member where mb_id = '{$MB_ID}'";
                    $result1 =  sql_fetch($query);
                    $birth = $result1['mb_2'];
                    echo $birth;
                    ?>
                  </td>
                  <td>
                    
                    <?php 
                        echo $member_payment_status; 
                   ?>
                
                 </td>

                 <td>
                        <?php
                        echo $row['PAYMETHOD'];
                        ?>
    
                 </td>

                  <td>
                    <?php echo $row['PHONE'] ?>
                    <?php

                         if ($row['PAYMENT_STATUS'] = 'Y') {  // 확정 검정은, 삭제가 아닐 경우에만 문자발송목록에 추가
                            array_push($arr_tel,$row['PHONE']);
                         }
 
                    ?>
                </td>
                  <td>
                  <?php echo "<h1 class='pageSubTitle'>".$row['LICENSE_NO']."</h1>"; ?> <br>
                    <?php echo "<span class='btnOrange'>".$row['SCORE1_1']." ".$row['SCORE1_2']." ".$row['SCORE1_3']."</span>"; ?> | 
                    <?php echo "<span class='btnOrange'>".$row['SCORE2_1']." ".$row['SCORE2_2']." ".$row['SCORE2_3']."</span>"; ?> | 
                    <?php echo "<span class='btnOrange'>".$row['SCORE3_1']." ".$row['SCORE3_2']." ".$row['SCORE3_3']."</span>"; ?> | 
                    <?php echo "<span class='btnOrange'>".$row['SCORE4_1']." ".$row['SCORE4_2']." ".$row['SCORE4_3']."</span>"; ?> | 
                    <?php echo "<a href='#' class='button btnRadius'>".$row['AVERAGE']."</a>"; ?>

                  <?php if ($row['AVERAGE'] >= 70) {
                    echo "<a href='#' class='button btnFade btnBlueGreen'>합격</a>";
                  } else {
                    echo "<a href='#' class='button btnLightBlue'>불합격</a>";

                  } ?>
                  </td>

                  <td>

                  </td>

                </tr>


            <?php } ?>

        </tbody>
    </table>
</div>



<div class="btn_fixed_top">


        <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">




 </div>

 </form>
<?php
$confirm_msg = $SMS_T_date . "일 " . $the_sports . " 티칭1 검정 확정안내. &#10;[관리자] " . $SMS_T_name . " (" . $SMS_T_tel . ")". "&#10;[스키장] ". $SMS_T_where ."&#10;[미팅시간] ". $SMS_T_time . "&#10;[장소] " . $SMS_T_meeting . "&#10;&#10; 안전하고, 보람있는 검정시간이 되길 바랍니다. &#10;&#10;-한국스키장경영협회-";
$cancel_msg = $SMS_T_date . "일 " . $the_sports . " 티칭1 검정  취소안내. &#10;[관리자] " . $SMS_T_name . "&#10;[검정코드] ". $SMS_T_code . "&#10;[스키장] ". $SMS_T_where . "&#10;&#10; 본 검정은 응시자미달로 취소되었습니다. 입금한 응시자의 경우 환불게시판에 환불신청바랍니다. &#10;&#10; -한국스키장경영협회-";

?>


<form name="ksia_sms" id="ksia_sms" action="./SBAK_SMS.php" method="post">

<?php $tel_list = implode("|", $arr_tel); ?>

<input type="hidden" name="T_status" value="<?php echo $SMS_T_status; ?>">
<input type="hidden" name="T_date" value="<?php echo $SMS_T_date; ?>">
<input type="hidden" name="the_sports" value="<?php echo $the_sports; ?>">
<input type="hidden" name="T_name" value="<?php echo $SMS_T_name; ?>">
<input type="hidden" name="T_tel" value="<?php echo $SMS_T_tel; ?>">
<input type="hidden" name="T_code" value="<?php echo $SMS_T_code; ?>">
<input type="hidden" name="T_where" value="<?php echo $SMS_T_where; ?>">
<input type="hidden" name="T_time" value="<?php echo $SMS_T_time; ?>">
<input type="hidden" name="T_meeting" value="<?php echo $SMS_T_meeting; ?>">
<input type="hidden" name="T_tel_list" value="<?php echo $tel_list; ?>">




 <div class="tbl_wrap tbl_head01">
    <table>

        <tbody>
            <tr>


                 

                <td scope="col">
                <textarea name="cancel_msg" placeholder="취소문자" readonly
                         style="resize: none ; display: block ; width: 80%; height: 180px; "><?php echo $cancel_msg; ?>
                  </textarea>           
                </td>
                <td scope="col">
                 
                   <input type="button" name="act_button" value="취소문자일괄발송" onclick="do_cancel()" class="btn btn_02"  
                   <?php if ($SMS_T_status == '77') { echo " disabled"; } ?>>
                 
                </td>
              
   
                <td scope="col">
                <textarea name="confirm_msg" placeholder="확정문자" readonly
                         style="resize: none ; display: block ; width: 80%; height: 180px; "><?php echo $confirm_msg; ?>
                  </textarea>             
                </td>

                <td scope="col">
               
                  <input type="button" name="act_button" value="확정문자일괄발송" onclick="do_confirm()" class="btn btn_02" 
                  <?php if ($SMS_T_status !== '77') { echo " disabled";}?>>
                
                </td>
                
           </tr>
       </tbody>
     </table>
  </div>         


  </form>




  <form name="ksia_reset_final" id="ksia_reset_final" action="<?php basename( $_SERVER[ "PHP_SELF" ] ); ?>?t_code=<?php echo $T_CODE; ?>" method="post">

<input type="hidden" name="T_code" value="<?php echo $SMS_T_code; ?>">
<input type="hidden" name="RESET_score_state" value="yes">



 <div class="tbl_wrap tbl_head01">
    <table>

        <tbody>
            <!-- <tr>

                <td scope="col">
               
                  <input type="button" name="reset_button" value="검정최종확정상태 초기화" onclick="do_reset_confirm()" class="btn btn_02" >
           
                
                </td>
                
           </tr> -->
       </tbody>
     </table>
  </div>         


  </form>

 <?php
$domain = isset($domain) ? $domain : '';
$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?t_code='.$T_CODE.'&amp;domain='.$domain.'&amp;page=');
if ($pagelist) {
    echo $pagelist;
}

?>

<script>
$(function(){
    $("#sch_sort").change(function(){ // select #sch_sort의 옵션이 바뀔때
        if($(this).val()=="vi_date"){ // 해당 value 값이 vi_date이면
            $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
        }else{ // 아니라면
            $("#sch_word").datepicker("destroy"); // datepicker 미실행
        }
    });

    if($("#sch_sort option:selected").val()=="vi_date"){ // select #sch_sort 의 옵션중 selected 된것의 값이 vi_date라면
        $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
    }
});

function fvisit_submit(f)
{
    return true;
}
</script>


<script>
    function ksia_license_list_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택수정") {
            if (!confirm("응시자별 결제금액/응시자삭제를 일괄 업데이트합니다. 신중히 확인해주세요. 선택한 자료를 정말 수정하시겠습니까?")) {
                return false;
            }
        }

        return true;
    }

    function do_cancel(){
        if (!confirm("단체 취소문자를 발송하시겠습니까? 진행시, 이 검정코드에 연결된 모든 응시자가 삭제처리됩니다.")) {
                return false;
        }   
        document.getElementById('ksia_sms').submit();
        return true;    
        
    }

    function do_confirm(){
        if (!confirm("단체 확정문자를 발송하시겠습니까?")) {
                return false;
        }   
        document.getElementById('ksia_sms').submit();
        return true;    
    }

    function do_reset_confirm(){
        if (!confirm("검정최종확정 상태를 초기화할 경우, 이미 발급된 자격번호가 있을 경우 반드시 따로 삭제조치해야합니다. 정말로 진행하시겠습니까?")) {
                return false;
        }   
        document.getElementById('ksia_reset_final').submit();
        return true;    
    }   
</script>

<?php
include_once('./admin.tail.php');
?>
