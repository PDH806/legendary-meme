<?php

include_once('./_common.php');


$sub_menu = '700700'; 

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '결제내역 관리';

include_once('./admin.head.php');


add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/adm/css/sbak_css.css">', 0);




$colspan = 9;
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'">처음</a>'; //페이지 처음으로 (초기화용도)



$sql_search = '';
$sql_common = " from sbak_mainpay ";


$sql_search = " where (1) ";




if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {       
        case 'MEMBER_ID':
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
    <span class="btn_ov01"> <span class="ov_txt">자격증 (A4) </span><span class="ov_num">A01</span></span>
    <span class="btn_ov01"> <span class="ov_txt">자격증 (ID카드) </span><span class="ov_num">A02</span></span>
    <span class="btn_ov01"> <span class="ov_txt">자격증 (A4 + ID카드) </span><span class="ov_num">A03</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스키티칭1 </span><span class="ov_num">B01</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스키티칭2 </span><span class="ov_num">B02</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스노보드티칭1</span><span class="ov_num">B04</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스노보드티칭2</span><span class="ov_num">B05</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스노보드티칭3</span><span class="ov_num">B06</span></span>
    <span class="btn_ov01"> <span class="ov_txt">스키구조요원</span><span class="ov_num">B07</span></span>
    <span class="btn_ov01"> <span class="ov_txt">전국스키기술선수권</span><A01 class="ov_num">C01</span></span>
</div>

<div>
<table width="100%">
    <tr>
        <td>
    <label for="sch_sort" class="sound_only">검색분류</label>
    <select name="sfl" id="sch_sort" class="search_sort">
        <option value="MEMBER_ID"<?php echo get_selected($sfl, 'MEMBER_ID'); ?>>거래자ID</option>
        <option value="MEMBER_NAME"<?php echo get_selected($sfl, 'MEMBER_NAME'); ?>>성명</option>
        <option value="PHONE"<?php echo get_selected($sfl, 'PHONE'); ?>>연락처</option>
        <option value="EMAIL"<?php echo get_selected($sfl, 'EMAIL'); ?>>이메일</option>
        <option value="PRODUCT_CODE"<?php echo get_selected($sfl, 'PRODUCT_CODE'); ?>>상품코드</option>
       
    </select>



    <label for="sch_word" class="sound_only">검색어</label>
    <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word" class="frm_input">
    <input type="submit" value="검색" class="btn_submit">



    </form>
</td>

</tr>
</table>
</div>



<form name="ksia_license_list" id="ksia_license_list">
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
                        UID
                    </th>
                    <th scope="col">상품코드</th>
                    <th scope="col" rowspan="2">거래자</th>
                    <th scope="col" >전화번호</th>
                    <th scope="col" rowspan="2">주문번호</th>
                    
                    <th scope="col" rowspan=2>거래번호</th>
                    <th scope="col" rowspan=2>금액</th>
                    <th scope="col" rowspan="2">결제수단</th>
                    <th scope="col" rowspan="2">카드번호</th>
                    <th scope="col">은행코드</th>
                    
                    <th scope="col" rowspan="2">상태</th>
                    <th scope="col" rowspan="2">등록일시</th>
                    <th scope="col" rowspan="2">취소일시</th>
                    

                </tr>
                <tr>
                    <th scope="col">상품명</th>
                    
                    
                    <th scope="col">이메일</th>
                   
                   
                    <th scope="col">은행명</th>
                               
                    
                </tr>
            </thead>




    <tbody>


    <?php

    for ($i=0; $row=sql_fetch_array($result); $i++) {

        $uid = $row['UID'];
        $product_code = $row['PRODUCT_CODE'];
        $product_name = $row['PRODUCT_NAME'];
        $mbrRefNo = $row['mbrRefNo'];
        $MEMBER_ID = $row['MEMBER_ID'];
        $MEMBER_NAME = $row['MEMBER_NAME'];
        $email = $row['EMAIL'];
        $phone = $row['PHONE'];
        $refNo = $row['refNo'];
        $amount = $row['amount'];
        
        $bankCode = $row['bankCode'];
        $bankName = $row['bankName'];
        $cardNo = $row['cardNo'];
        $PAY_METHOD = $row['PAY_METHOD'];
        $STATUS = $row['STATUS'];
        $AID = $row['AID'];
        $INSERT_DATE = $row['INSERT_DATE'];
        $CANCELED_DATE = $row['CANCELED_DATE'];
        
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
                                <?php echo $row['UID']?>
                        </td>

                        <td><?php echo $product_code; ?></td>

                        <td rowspan="2"><?php echo $MEMBER_NAME; ?> <br>(<?php echo $MEMBER_ID; ?>)  </td>

                        
                        <td>
                            <?php echo $phone;?>
                        </td>
                   
                        <td rowspan="2"> <?php echo $mbrRefNo; ?> </td>


                        
                        <td rowspan="2">
                           <?php echo $refNo; ?>
                    </td>
                        <td rowspan=2>
                            <?php echo $amount;?>
                        </td>
                      
                        <td rowspan="2">
                            <?php echo $PAY_METHOD;?>
                        </td>

                        <td rowspan="2">
                            <?php echo $cardNo;?>
                        </td>

                        <td>
                            <?php echo $bankCode;?>
                        </td>


                        <td rowspan="2">
                            <?php echo $STATUS;?>
                        </td>

                        <td rowspan="2">
                            <?php echo $INSERT_DATE;?>
                        </td>

                        <td rowspan="2">
                            <?php echo $CANCELED_DATE;?>
                        </td>                        
                    </tr>

                    <tr class="<?php echo $bg; ?>">

                        <td>
                            <?php echo $product_name; ?>
                        </td>

                        <td>
                            <?php echo $email; ?>
                        </td>


                        <td>
                            <?php echo $bankName;?>
                        </td>


                    </tr>



   
    <?php } ?>
    <?php if ($i == 0) echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>'; ?>
    </tbody>
    </table>
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



<?php
include_once('./admin.tail.php');
