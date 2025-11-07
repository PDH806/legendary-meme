<?php

$this_title = "연회비, 인증료 납부정보"; //커스텀페이지의 타이틀을 입력합니다.

include_once('./header_console.php'); //공통 상단을 연결합니다.

?>

<?php

$refer = $_SERVER['HTTP_REFERER'];


if (empty($the_sports) || ($the_sports <> 'ski' && $the_sports <> 'sb')) {
    alert('비정상적인 접근입니다.', $refer);
    exit;
}

$sql = "select K_LICENSE from {$the_license_pay_table} where MEMBER_ID = trim('{$mb_id}')";
$result = sql_query($sql);
$result1 = sql_fetch($sql);
if (empty($result1['K_LICENSE'])) { // 자격증이 없다면 연동하도록 안내
    alert('티칭2, 티칭3 지도자가 아닙니다.', $refer);
    exit;
}



if ($the_sports === 'ski') {
    $sports_title = '[스키지도자]';
} elseif ($the_sports === 'sb') {
    $sports_title = '[스노보드지도자]';
}

?>



<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><?php echo $this_title; ?> <span class="text-muted fw-light">/ MEMBERSHIP FEE</span></h4>
    <div class="alert  alert-dark mb-0" role="alert">
        <?php echo $mb_name; ?> 님의 <?php echo $sports_title; ?> 연회비, 인증료 납부내역입니다. 연회비는 매년 1회, 인증료는 티칭2와 티칭3 각각 자격취득 후 최초 1회씩 부과됩니다.

    </div> <br>



    <!-- 컨텐츠1 시작 -->


    <div class="card">

        <h5 class="card-header">연회비 납부내역</h5>


        <?php
        $sql = "select * from {$the_license_pay_table} where MEMBER_ID = trim('{$mb_id}')";
        $row = sql_fetch($sql);

        function display_year() //연도별 연회비 처리 함수
        {
            global $get_row;
            $the_row = $get_row;

            if (empty($the_row)) {
                echo "<td>&nbsp;</td>";
            } else {
                echo "<td><span class='badge bg-label-primary me-1'>Y</span></td>";
            }
        }
        ?>


        <div class="table-responsive text-nowrap">

            <table class="table table-striped table table-bordered text-center">

                <tr>
                    <td>1999</td>
                    <td>2000</td>
                    <td>2001</td>
                    <td>2002</td>
                    <td>2003</td>
                </tr>

                <tr>
                    <?php
                    $get_row = $row['the_1999'];
                    display_year();
                    $get_row = $row['the_2000'];
                    display_year();
                    $get_row = $row['the_2001'];
                    display_year();
                    $get_row = $row['the_2002'];
                    display_year();
                    $get_row = $row['the_2003'];
                    display_year();
                    ?>

                </tr>

                <tr>
                    <td>2004</td>
                    <td>2005</td>
                    <td>2006</td>
                    <td>2007</td>
                    <td>2008</td>
                </tr>

                <tr>
                    <?php
                    $get_row = $row['the_2004'];
                    display_year();
                    $get_row = $row['the_2005'];
                    display_year();
                    $get_row = $row['the_2006'];
                    display_year();
                    $get_row = $row['the_2007'];
                    display_year();
                    $get_row = $row['the_2008'];
                    display_year();
                    ?>
                </tr>
                <tr>
                    <td>2009</td>
                    <td>2010</td>
                    <td>2011</td>
                    <td>2012</td>
                    <td>2013</td>
                </tr>

                <tr>
                    <?php
                    $get_row = $row['the_2009'];
                    display_year();
                    $get_row = $row['the_2010'];
                    display_year();
                    $get_row = $row['the_2011'];
                    display_year();
                    $get_row = $row['the_2012'];
                    display_year();
                    $get_row = $row['the_2013'];
                    display_year();
                    ?>
                </tr>

                <tr>
                    <td>2014</td>
                    <td>2015</td>
                    <td>2016</td>
                    <td>2017</td>
                    <td>2018</td>
                </tr>

                <tr>
                    <?php
                    $get_row = $row['the_2014'];
                    display_year();
                    $get_row = $row['the_2015'];
                    display_year();
                    $get_row = $row['the_2016'];
                    display_year();
                    $get_row = $row['the_2017'];
                    display_year();
                    $get_row = $row['the_2018'];
                    display_year();
                    ?>
                </tr>

                <tr>
                    <td>2019</td>
                    <td>2020</td>
                    <td>2021</td>
                    <td>2022</td>
                    <td>2023</td>
                </tr>

                <tr>
                    <?php
                    $get_row = $row['the_2019'];
                    display_year();
                    $get_row = $row['the_2020'];
                    display_year();
                    $get_row = $row['the_2021'];
                    display_year();
                    $get_row = $row['the_2022'];
                    display_year();
                    $get_row = $row['the_2023'];
                    display_year();
                    ?>
                </tr>

                <tr>
                    <td>2024</td>
                    <td>2025</td>
                    <td>2026</td>
                    <td>2027</td>
                    <td>2028</td>
                </tr>

                <tr>
                    <?php
                    $get_row = $row['the_2024'];
                    display_year();
                    $get_row = $row['the_2025'];
                    display_year();
                    $get_row = $row['the_2026'];
                    display_year();
                    $get_row = $row['the_2027'];
                    display_year();
                    $get_row = $row['the_2028'];
                    display_year();
                    ?>
                </tr>


            </table>

        </div>

    </div>

    <!-- 컨텐츠1 종료 -->
    <div class="row">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary  m-2" onclick="location.href='../event_cgi/console_service.php?category_sort=D01&sports=<?php echo $the_sports; ?>'">
                <i class='fa fa-universal-access' aria-hidden='true'> </i> 연회비 납부 </button>
            <button type="button" class="btn btn-secondary  m-2" onclick="location.href='../event_cgi/console_service.php?category_sort=D02&sports=<?php echo $the_sports; ?>'">
                <i class='fa fa-universal-access' aria-hidden='true'> </i> 인증료 납부 </button>
        </div>
    </div>

    <hr class="my-5" />

    <!-- 컨텐츠2 시작 -->


    <div class="card">
        <h5 class="card-header">인증료 납부내역</h5>

        <div class="table-responsive text-nowrap">

            <table class="table table-striped table table-bordered text-center">
                <tr>
                    <td>티칭2</td>
                    <td>티칭3</td>
                </tr>

                <tr>
                    <?php
                    $get_row = $row['the_fee'];
                    display_year();
                    $get_row = $row['the_fee_L3'];
                    display_year();
                    ?>
                </tr>
            </table>

        </div>
    </div>

    <!-- 컨텐츠2 종료 -->



</div>
</div>

<?php


include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.

?>