<?php

include_once('./_common.php');


$sub_menu = '700800'; 

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '환불 관리';

include_once('./admin.head.php');


add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/ksia_css.css">', 0);




$colspan = 9;
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'">처음</a>'; //페이지 처음으로 (초기화용도)



$sql_search = '';
$sql_common = " from SBAK_REFUND_LIST ";


$sql_search = " where (1) ";




if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'PAYMENT_STATUS':
           
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;     
        case 'TRAN_STATUS':
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;         
        case 'MEMBER_ID':
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'RF_CATETORY':
                $sql_search .= " ({$sfl} = '{$stx}') ";
                break;       
        case 'MEMBER_NAME':
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;    
        default:
            $sql_search .= " ({$sfl} = '{$stx}') ";
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
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            order by UID desc
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);







// 등급별 회원수





$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';



$sql = " select * {$sql_common} {$sql_search} {$sql_order} order by UID desc limit {$from_record}, {$rows} ";
$result = sql_query($sql);


?>

<div class="local_sch local_sch01">
    <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">

    <div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">전체 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
    <span class="btn_ov01"> <span class="ov_txt">스키티칭1 검정 </span><span class="ov_num">B01</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스키티칭2 검정 </span><span class="ov_num">B02</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스키티칭3 검정 </span><span class="ov_num">B03</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스노보드티칭1 검정</span><span class="ov_num">B04</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스노보드티칭2 검정</span><span class="ov_num">B05</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스노보드티칭3 검정</span><span class="ov_num">B06</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스키구조요원</span><span class="ov_num">B07</span></span>
    <!-- <span class="btn_ov01"> <span class="ov_txt">교재</span><span class="ov_num">A03</span></span>
    <span class="btn_ov01"> <span class="ov_txt">명찰</span><span class="ov_num">A02</span></span>
    <span class="btn_ov01"> <span class="ov_txt">자격증</span><A01 class="ov_num">A01</span></span> -->
    <span class="btn_ov01"> <span class="ov_txt">전국스키기술선수권</span><A01 class="ov_num">C01</span></span>
    <span class="btn_ov01"> <span class="ov_txt">엑셀다운</span><span class="ov_num">
                <a href="<?php echo 'ksia_refund_list_xls.php'; ?>"> <i class="fa fa-file-excel-o"></i> </a>               
                </span></span>    
</div>

<div>
<table width="100%">
    <tr>
        <td>
    <label for="sch_sort" class="sound_only">검색분류</label>
    <select name="sfl" id="sch_sort" class="search_sort">
        <option value="MB_ID"<?php echo get_selected($sfl, 'MEMBER_ID'); ?>>신청자ID</option>
        <option value="MB_NAME"<?php echo get_selected($sfl, 'MEMBER_NAME'); ?>>성명</option>
        <option value="MB_TEL"<?php echo get_selected($sfl, 'MEMBER_TEL'); ?>>연락처</option>
        <option value="REGIS_DATE"<?php echo get_selected($sfl, 'OD_DATE'); ?>>신청일</option>
       <option value="RF_CATEGORY"<?php echo get_selected($sfl, 'RF_CATEGORY'); ?>>카테고리</option>
       <option value="RF_STATUS"<?php echo get_selected($sfl, 'RF_STATUS'); ?>>환불완료</option>
       <!-- <option value="IS_DEL"<?php echo get_selected($sfl, 'IS_DEL'); ?>>삭제건</option> -->
       
    </select>



    <label for="sch_word" class="sound_only">검색어</label>
    <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word" class="frm_input">
    <input type="submit" value="검색" class="btn_submit">



    </form>
</td>
    <td align="right">
                      <form name="frm_toexcel" method="post" action="./ksia_refund_list_xls.php">
                         <input type='hidden' name="sort_by" value="only_confirmed">
                        기간 : <input type="date" name="from_date" size="20" value="<?php echo stripslashes($stx); ?>"  class="frm_input">  ~      
                         <input type="date" name="to_date" size="20" value="<?php echo stripslashes($stx); ?>"  class="frm_input">    
                         <input type="submit" value="EXCEL">
                      </form>               
                    </td>
</tr>
</table>
</div>



<form name="ksia_license_list" id="ksia_license_list" action="./ksia_refund_list_update.php"
    onsubmit="return ksia_license_list_submit(this);" method="post">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">
   


<div class="local_desc01 local_desc">
    <p>

    </p>
</div>

<div class="tbl_wrap tbl_head01">
    <table>


    <thead>
                <tr>
                    <th scope="col" id="mb_list_chk" rowspan="2">
                        <label for="chkall" class="sound_only">회원 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col" width="120px">환불코드</th>
                    <th scope="col" width="80px" rowspan="2">신청자</th>
                    <th scope="col"  width="120px">전화번호</th>
                    <th scope="col" rowspan="2" width="100px">참조</th>
                    <th scope="col" width="110px">신청일</th>
                    
                    <th scope="col">환불액</th>
                    <th scope="col" rowspan=2>환불일</th>
                    <th scope="col" width="70px" owspan="2">환불처리</th>
                    <th scope="col" rowspan="2" width="160px">메모</th>
                    
                    <th scope="col" rowspan="2" width="60px">삭제</th>
                    <th scope="col" rowspan="2" width="60px">승인/반려</th>
                    <th scope="col" rowspan="2" width="120px">사유</th>
                    

                </tr>
                <tr>
                    <th scope="col">환불건명</th>
                    
                    
                    <th scope="col">이메일</th>
                    <th scope="col">신청시간</th>
                    <th scope="col">환불계좌</th>
                   
                   
                    <th scope="col">환불확인</th>
                               
                    
                </tr>
            </thead>




    <tbody>


    <?php

    for ($i=0; $row=sql_fetch_array($result); $i++) {

        $uid = $row['UID'];
        $refund_category = $row['RF_CATEGORY'];
        $refund_od_title = $row['OD_TITLE'];

        $refund_od_ref = $row['OD_REF'];
        $refund_mb_id = $row['MB_ID'];
        $refund_mb_name = $row['MB_NAME'];
    
        $refund_mb_tel = $row['MB_TEL'];
        $refund_mb_email = $row['MB_EMAIL'];
        $refund_rf_account = $row['RF_ACCOUNT'];

        $refund_od_date = $row['REGIS_DATE'];
        $refund_od_time = $row['REGIS_TIME'];

        $refund_memo = $row['RF_MEMO'];
        $refund_rf_date = $row['RF_DATE'];
    
        $refund_state = $row['RF_STATUS'];
        $refund_rf_amount = $row['RF_AMOUNT'];
        $check_del = $row['IS_DEL'];
        
        $link = "";
        $referer = "";
        $title = "";



        $bg = 'bg'.($i%2);
    ?>


                <tr class="<?php echo $bg; ?>">
                        <td class="td_chk" rowspan="2">
                        <input type="hidden" name="UID[<?php echo $i ?>]" value="<?php echo $row['UID'] ?>">
                            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['MEMBER_ID']); ?>
                                회원</label>
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                        </td>

                        <td><?php echo $row['RF_CATEGORY']; ?></td>

                        <td rowspan="2"><?php echo $row['MB_NAME']; ?> <br>(<?php echo $row['MB_ID']; ?>)  </td>

                        
                        <td>
                           
                            <input type="text" name="MB_TEL[<?php echo $i ?>]" value="<?php echo $row['MB_TEL']; ?>" <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>
                               >
                        
                        </td>
                   
                        <td rowspan="2"> <?php echo $row['OD_REF']; ?> </td>

                        <td>
                          <?php echo $row['REGIS_DATE'];; ?>
                        
                        </td>
                        
                        <td>
                            
                            <input type="text" name="RF_AMOUNT[<?php echo $i ?>]" value="<?php echo $row['RF_AMOUNT']; ?>"
                        <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>>
                        </td>
                        <td rowspan=2>
                        <input type="date" name="RF_DATE[<?php echo $i ?>]" value="<?php echo $row['RF_DATE'];; ?>"
                        <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>>
                    </td>
                        <td rowspan=2>
                           <label for="RF_STATUS<?php echo $i; ?>" >Y</label>
                          
                          <input type=checkbox name="RF_STATUS[<?php echo $i ?>]" value="Y" <?php if ($row['RF_STATUS'] == 'Y') { echo "checked"; } ?> 
                           <?php if ($row['IS_DEL'] == 'Y') { echo " disabled"; }?>>
                        </td>
                      
                        <td rowspan="2" class="td_left">
                          <textarea name="RF_MEMO[<?php echo $i ?>]" placeholder="메모사항" 
                          <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>
                          style="resize: none ; display: block ; width: 100%; height: 20px; border: solid 2px #1E90FF;border-radius: 5px;"><?php echo $row['RF_MEMO'];?>
                        </textarea>
                        </td>
                        <td rowspan="2">
                        <input type=checkbox name="IS_DEL[<?php echo $i ?>]" value="Y" <?php if ($row['IS_DEL'] == 'Y') { echo "checked"; } ?>>

                        </td>

                        <td rowspan="2">
                        <input type=radio name="APPROVE_REJECT[<?php echo $i ?>]" value="A" <?php if ($row['APPROVE_REJECT'] == 'A') { echo "checked"; } ?> >승인
                        <input type=radio name="APPROVE_REJECT[<?php echo $i ?>]" value="R" <?php if ($row['APPROVE_REJECT'] == 'R') { echo "checked"; } ?> >반려

                        </td>
                        <td rowspan="2" class="td_left">
                          <textarea name="REASON[<?php echo $i ?>]" placeholder="승인/반려 사유" 
                          <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>
                          style="resize: none ; display: block ; width: 100%; height: 20px; border: solid 2px #1E90FF;border-radius: 5px;"><?php echo $row['REASON'];?>
                        </textarea>
                        </td>
                    </tr>
                    <tr class="<?php echo $bg; ?>">
                        <td><?php echo $refund_od_title; ?></td>
                        <td>
                            
                            <input type="text" name="MB_EMAIL[<?php echo $i ?>]" value="<?php echo $row['MB_EMAIL'];; ?>"
                        <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>>

                        </td>
                        <td>
                        <?php echo $row['REGIS_TIME'];; ?>
                        </td>
                        <td>
                            
                            <input type="text" name="RF_ACCOUNT[<?php echo $i ?>]" value="<?php echo $row['RF_ACCOUNT'];; ?>"
                        <?php if ($row['IS_DEL'] == 'Y') { echo "class='ksia_input_deleted' readonly"; }else{ echo "class='ksia_input'"; } ?>>
                        </td>

                       




                    </tr>



   
    <?php } ?>
    <?php if ($i == 0) echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>'; ?>
    </tbody>
    </table>
</div>


<div class="btn_fixed_top">
        <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">
    </div>

    </form>

<?php
$domain = isset($domain) ? $domain : '';
$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;domain='.$domain.'&amp;page=');
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
//     //라디오 버튼 해제 기능
//     function toggleRadio(radio) {
//     if (radio.previousState === undefined) {
//         radio.previousState = radio.checked;
//     }
    
//     radio.checked = !radio.previousState;
//     radio.previousState = !radio.previousState;
// }
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
