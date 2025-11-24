<?php
$sub_menu = '590900';
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '각종 행사/행정사무 접수환경설정';
include_once('./admin.head.php');

$table = "SBAK_OFFICE_CONF"; // 테이블명 받아오기

$_POST['is_update'] = $_POST['is_update'] ?? '';


if ($_POST['is_update'] == 'yes') {

    $UID = $_POST['UID'] ?? '';

    $Event_title_1 = $_POST['Event_title_1'] ?? '';
    $Event_title = $_POST['Event_title'] ?? '';
    $Entry_fee = $_POST['Entry_fee'] ?? 0;
    $Event_date = $_POST['Event_date'] ?? '';
    $Event_year = $_POST['Event_year'] ?? '0000';
    $Event_where = $_POST['Event_where'] ?? '';
    $Event_whom = $_POST['Event_whom'] ?? '';
    $Event_begin_date = $_POST['Event_begin_date'] ?? '0000-00-00';
    $Event_begin_time = $_POST['Event_begin_time'] ?? '00:00:00';
    $Event_end_date = $_POST['Event_end_date'] ?? '0000-00-00';
    $Event_end_time = $_POST['Event_end_time'] ?? '00:00:00';

    $Pay_begin_date = $_POST['Pay_begin_date'] ?? '0000-00-00';
    $Pay_begin_time = $_POST['Pay_begin_time'] ?? '00:00:00';
    $Pay_end_date = $_POST['Pay_end_date'] ?? '0000-00-00';
    $Pay_end_time = $_POST['Pay_end_time'] ?? '00:00:00';
    $T1_before_days = $_POST['T1_before_days'] ?? 0;
    $Event_birthdate = $_POST['Event_birthdate'] ?? '0000';
    $Event_total_limit = $_POST['Event_total_limit'] ?? 0;
    $Event_extra_cnt = $_POST['Event_extra_cnt'] ?? 0;
    $Event_memo = $_POST['Event_memo'] ?? '';
    $Event_rule = $_POST['Event_rule'] ?? '';
    $Event_notice = $_POST['Event_notice'] ?? '';
    $Event_status = $_POST['Event_status'] ?? '';
    $Event_control = $_POST['Event_control'] ?? '';




    $sql = " update $table 
    set 
    
    Event_title_1 = '{$Event_title_1}',
    Event_title = '{$Event_title}',
    Entry_fee = {$Entry_fee},
    Event_date = '{$Event_date}',
    Event_year = '{$Event_year}',
    Event_where = '{$Event_where}',
    Event_whom = '{$Event_whom}',
    Event_begin_date = '{$Event_begin_date}',
    Event_begin_time = '{$Event_begin_time}',
    Event_end_date = '{$Event_end_date}',
    Event_end_time = '{$Event_end_time}',
    Pay_begin_date = '{$Pay_begin_date}',
    Pay_begin_time = '{$Pay_begin_time}',
    Pay_end_date = '{$Pay_end_date}',
    Pay_end_time = '{$Pay_end_time}',
    T1_before_days = {$T1_before_days},
    Event_birthdate = '{$Event_birthdate}',
    Event_memo = '{$Event_memo}',
    Event_total_limit = '{$Event_total_limit}',
    Event_extra_cnt = '{$Event_extra_cnt}',
    Event_rule = '{$Event_rule}',
    Event_notice = '{$Event_notice}',
    Event_status = '{$Event_status}',
    Event_control = '{$Event_control}'
    where UID = {$UID}";

    sql_query($sql);
}



$colspan = 11;


$sql_common = " from $table order by Event_code  ";

$sql = " select * {$sql_common} ";
$result = sql_query($sql);



?>

<style>
    .frm_input_num_yellow_num5 {
        background-color: #f1c40e;
        font-size: 14px;
        color: blue;
        font-weight: 500;
        width: 60px;
        border-radius: 5px;
        text-align: right;
        padding: 5px;
    }

    .frm_input_num_yellow_num2 {
        background-color: #f1c40e;
        font-size: 14px;
        color: blue;
        font-weight: 500;
        width: 30px;
        border-radius: 5px;
        text-align: right;
        padding: 5px;
    }
</style>



<div class="local_desc01 local_desc">
    <p>인원제한 없이 접수할 경우, 마감인원을 0 또는 공백으로 두면 됨. 요강 및 약관의 경우, 해당 코너에 게시한 후, 게시글 번호만 입력 / 행사년도는 4자리 숫자로만 입력
    </p>
</div>





<div class="tbl_wrap tbl_head01">
    <table>
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">CODE</th>
                <th scope="col" width="20%">카테고리 <br>세부명칭</th>
                <th scope="col" width="10%">접수시작<br>접수마감<br>나이제한</th>
                <th scope="col" width="10%">결제(취소)기간</th>
                <th scope="col">티칭1 취소마감</th>

                <th scope="col" width="10%">장소<br>참가대상<br>년도<br>날짜</th>

                <th scope="col" width="7%">가격<br>수량(인원)</th>


                <th scope="col" width="5%">약관</th>
                <th scope="col" width="5%">요강</th>
                <th scope="col" width="3%">접수금지</th>
                <th scope="col" width="3%">인원마감</th>
                <th scope="col">메모</th>
                <th scope="col" width="3%">수정</th>

            </tr>
        </thead>
        <tbody>




            <?php


            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $uid = $row['UID'];




                //행정사무,티칭1인지 체크하여 이 경우, 인원추가 비활성화
                $event_code = $row['Event_code'] ?? '';
                $arr = array('A01', 'A02', 'A03', 'B01', 'B04');
                $able_extra_cnt = 'Y';
                if (in_array($event_code, $arr)) {
                    $able_extra_cnt = 'N';
                }

                $bg = 'bg' . ($i % 2);
            ?>

                <form name=frm method=post action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <input type="hidden" name="is_update" value="yes">
                    <input type="hidden" name="UID" value="<?php echo $row['UID']; ?>">

                    <tr class="<?php echo $bg; ?>">
                        <td>
                            <?php echo $i + 1; ?>
                        </td>
                        <td>
                            <?php echo $row['Event_code']; ?>
                        </td>
                        <td><input type="text" name="Event_title_1" value="<?php echo $row['Event_title_1']; ?>"
                                class="tbl_input" size="15" required>
                            <input type="text" name="Event_title" value="<?php echo $row['Event_title']; ?>"
                                class="tbl_input" placeholder="정식행사타이틀 입력" required>
                        </td>

                        <td width="150px">
                            <p style='float:left;background-color:#efefef;padding:5px'><i class="fa fa-bars"></i> 접수시작</p>
                            <input type="date" name="Event_begin_date" value="<?php echo $row['Event_begin_date']; ?>"
                                class="tbl_input" required>
                            <input type="time" name="Event_begin_time" value="<?php echo $row['Event_begin_time']; ?>"
                                class="tbl_input" required>

                            <p style='float:left;background-color:#efefef;padding:5px;'><i class="fa fa-bars"></i> 접수마감</p>
                            <input type="date" name="Event_end_date" value="<?php echo $row['Event_end_date']; ?>"
                                class="tbl_input" required>
                            <input type="time" name="Event_end_time" value="<?php echo $row['Event_end_time']; ?>"
                                class="tbl_input" required>
                            <p style='float:left;background-color:#efefef;padding:5px;'><i class="fa fa-bars"></i> 나이제한</p>
                            <input type="date" name="Event_birthdate" value="<?php echo $row['Event_birthdate']; ?>"
                                class="tbl_input">
                        </td>

                        <td width="150px">
                            <p style='float:left;background-color:#efefef;padding:5px'><i class="fa fa-bars"></i> 결제시작</p>
                            <input type="date" name="Pay_begin_date" value="<?php echo $row['Pay_begin_date']; ?>"
                                class="tbl_input" required>
                            <input type="time" name="Pay_begin_time" value="<?php echo $row['Pay_begin_time']; ?>"
                                class="tbl_input" required>

                            <p style='float:left;background-color:#efefef;padding:5px'><i class="fa fa-bars"></i> 결제(취소)마감</p>

                            <input type="date" name="Pay_end_date" value="<?php echo $row['Pay_end_date']; ?>"
                                class="tbl_input" required>
                            <input type="time" name="Pay_end_time" value="<?php echo $row['Pay_end_time']; ?>"
                                class="tbl_input" required>

                        </td>
                        <td width="50px">

                            <?php if ($row['Event_code'] == 'B01' || $row['Event_code'] == 'B04') { ?>
                                <input type="text" name="T1_before_days" value="<?php echo $row['T1_before_days']; ?>"
                                    class='frm_input_num_yellow_num2' max-length='2' required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" "/>일전
                           <p><i class=" fa fa-info-circle"></i> 숫자만 </p>

                            <?php } else { ?>
                                <input type="hidden" name="T1_before_days" value="0">

                            <?php }  ?>

                        </td>
                        <td width=" 200px">
                            <input type="text" name="Event_where" value="<?php echo $row['Event_where']; ?>"
                                placeholder="행사장소" style="text-align:center;" class="tbl_input">
                            <input type="text" name="Event_whom" value="<?php echo $row['Event_whom']; ?>"
                                placeholder="참가대상" style="text-align:center;" class="tbl_input">
                            <input type="year" name="Event_year" value="<?php echo $row['Event_year']; ?>" style="text-align:center;"
                                placeholder="행사년도" maxlength='4' class="tbl_input" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <input type="text" name="Event_date" value="<?php echo $row['Event_date']; ?>"
                                placeholder="행사날짜(기간)" class="tbl_input">

                        </td>
                        <td width="100px">

                            <p style='float:left;background-color:#efefef;padding:5px'><i class="fa fa-bars"></i> 가격</p>
                            <input type="text" class='frm_input_num_yellow_num5' max-length='5' name="Entry_fee" value="<?php echo $row['Entry_fee']; ?>"
                                required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <p style='float:left;background-color:#efefef;padding:5px'><i class="fa fa-bars"></i> 수량(인원)</p>
                            <input type="text" class='frm_input_num_yellow_num5' max-length='4' name="Event_total_limit" value="<?php echo $row['Event_total_limit']; ?>"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />

                            <?php if ($able_extra_cnt == 'N') {
                                echo "<input type='hidden' name='Event_extra_cnt' value='0'> ";
                            } else { ?>
                                <p style='float:left;background-color:#efefef;padding:5px'><i class="fa fa-bars"></i> 추가인원</p>
                                <input type="text" class='frm_input_num_yellow_num5' max-length='3' required name="Event_extra_cnt" value="<?php echo $row['Event_extra_cnt']; ?>"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <?php } ?>

                            <p style="font-size:0.8em;color:#666;"><em><i class="fa fa-info-circle"></i> 숫자만</em> </p>
                        </td>
                        <td width="40px"><input type="text" name="Event_rule" value="<?php echo $row['Event_rule']; ?>"
                                class='frm_input_num_yellow_num5' max-length='4' oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <p style="font-size:0.8em;color:#666;"><em><i class="fa fa-info-circle"></i> 숫자만</em> </p> <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=sbak_event_rule" class="btn btn_03">이동</a>
                        </td>
                        <td width="40px"><input type="text" name="Event_notice" value="<?php echo $row['Event_notice']; ?>"
                                class='frm_input_num_yellow_num5' max-length='4' oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <p style="font-size:0.8em;color:#666;"><em><i class="fa fa-info-circle"></i> 숫자만 </em></p> <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=sbak_event_notice" class="btn btn_03">이동</a>
                        </td>
                        <td><input type="checkbox" name="Event_status" value="Y"
                                class="tbl_input" <?php if ($row['Event_status'] == 'Y') {
                                                        echo "checked";
                                                    }; ?>>
                        </td>
                        <td><input type="checkbox" name="Event_control" value="Y"
                                class="tbl_input" <?php if ($row['Event_control'] == 'Y') {
                                                        echo "checked";
                                                    }; ?>>
                        </td>
                        <td>
                            <textarea name="Event_memo" id="" cols="10" rows="1"
                                placeholder="기본안내사항"><?php echo $row['Event_memo']; ?></textarea>

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
include_once('./admin.tail.php');
