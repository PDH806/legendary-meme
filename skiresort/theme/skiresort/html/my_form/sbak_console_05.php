<?php

include_once('./header_console.php'); //공통 상단을 연결합니다.
$this_title = "자격증 재발급 관리";
header('Content-Type: text/html; charset=utf-8');
$READY_API_URL = G5_THEME_URL . "/html/my_form/mainpay_api/pc/_9_cancel.php";
?>

<head>

  <script type='text/javascript'>
    function payment_cancel(form) {
      form.action = "<?php echo $READY_API_URL; ?>";
      form.method = "POST";
      const result = confirm("취소처리시 자동 결제취소됩니다. 취소된 건은 복구할 수 없습니다. 정말 취소하시겠습니까? ");
      if (result) {
        form.submit();
      } else {
        return false;
      }
    }
  </script>


  <style>
    .table thead th {
      color: #fff !important;
      /* 글자 흰색 */
    }
  </style>
</head>


<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-4"><?php echo $this_title; ?><span class="text-muted fw-light"> / MY SERVICES</span></h4>

  <!-- 기본정보 -->
  <div class="card">



    <?php

    $query = " select count(*) as CNT from {$Table_Service_List} where MEMBER_ID = '{$mb_id}' and (PAYMENT_STATUS = 'Y' or PAYMENT_STATUS = 'C')";
    $row_cnt = sql_fetch($query);
    $total_cnt = $row_cnt['CNT'];

    echo "<h5 class='card-header'> 자격증 재발급 신청내역 [ 총 <font color=red>" . $total_cnt . "</font> 건]</h5>";


    /* paging : 한 페이지 당 데이터 개수 */
    $list_num = 5;

    /* paging : 한 블럭 당 페이지 수 */
    $page_num = 5;

    /* paging : 현재 페이지 */
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;

    /* paging : 전체 페이지 수 = 전체 데이터 / 페이지당 데이터 개수 */
    $total_page = ceil($total_cnt / $list_num);
    // echo "전체 페이지 수 : ".$total_page;

    /* paging : 전체 블럭 수 = 전체 페이지 수 / 블럭 당 페이지 수 */
    $total_block = ceil($total_page / $page_num);

    /* paging : 현재 블럭 번호 = 현재 페이지 번호 / 블럭 당 페이지 수 */
    $now_block = ceil($page / $page_num);

    /* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
    $s_pageNum = ($now_block - 1) * $page_num + 1;
    // 데이터가 0개인 경우
    if ($s_pageNum <= 0) {
      $s_pageNum = 1;
    };

    /* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
    $e_pageNum = $now_block * $page_num;
    // 마지막 번호가 전체 페이지 수를 넘지 않도록
    if ($e_pageNum > $total_page) {
      $e_pageNum = $total_page;
    };

    /* paging : 시작 번호 = (현재 페이지 번호 - 1) * 페이지 당 보여질 데이터 수 */
    $start = ($page - 1) * $list_num;


    $rec_num = 1 + (($page - 1) * $list_num);


    $query = "select * from {$Table_Service_List} where MEMBER_ID = '{$mb_id}' and (PAYMENT_STATUS = 'Y' or PAYMENT_STATUS = 'C') order by UID desc 
  limit {$start}, {$list_num};"; //페이징구현할것

    $result = sql_query($query);


    ?>



    <table class="table mb-0">
      <thead class="table table-dark">
        <tr>

          <th>신청코드/신청명</th>
          <th>신청일/상태</th>
          <th>관리</th>
        </tr>
      </thead>
      <tbody>

        <?php
        for ($i = 0; $row = sql_fetch_array($result); $i++) {
          $uid = $row['UID'];
          $event_code = $row['PRODUCT_CODE'];
          $regis_date = $row['REGIS_DATE'];
          $regis_time = $row['REGIS_TIME'];
          $service_mb_tel = $row['MEMBER_PHONE'];
          $addr1 = $row['ADDR1'];

          get_office_conf($event_code); //사무국 환경설정


          /* paging : 글번호 */
          $cnt = $start + 1;


          $detail_info_Modal = "detail_info_Modal" . $i;
          $data_target = "#" . $detail_info_Modal;



        ?>

  <!-- Modal -->
  <div class="modal fade" id="<?php echo $detail_info_Modal; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog <?php if (preg_match("/" . G5_MOBILE_AGENT . "/i", $_SERVER['HTTP_USER_AGENT'])) {
          echo 'modal-fullscreen';
        } else {
          echo 'modal-dialog-scrollable';
        } ?>" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">
            '<?php echo $mb_name; ?>' 회원님의 <font color=blue> <?php echo $event_title; ?> </font> 신청 상세내역
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

      <div class="modal-body">
        <div class="container-fluid">
          <div class="row border-bottom">
            <div class="col-4 my-2"><span class='h6'>[접수코드]</span></div>
            <div class="col-8 my-2">
              <?php echo $event_code; ?> -
              <?php echo $uid; ?>
            </div>
          </div>

          <div class="row border-bottom">
            <div class="col-4 my-2"><span class='h6'>[접수내용]</span></div>
            <div class="col-8 my-2">
              <font color=red> <?php echo $row['CATE_1']; ?> </font>
              <?php echo $event_title; ?>


            </div>
          </div>



          <div class="row border-bottom">
            <div class="col-4 my-2">
              <?php
              echo "  <span class='h6'>[자격번호]</span>";
              ?>
            </div>
            <div class="col-8 my-2">
              <?php echo $row['LICENSE_NO']; ?>
            </div>
          </div>



          <div class="row border-bottom">
            <div class="col-4 my-2"><span class='h6'>[등 록 일]</span></div>
            <div class="col-8 my-2">
              <?php echo $regis_date; ?>
              <?php echo $regis_time; ?>
            </div>
          </div>

          <div class="row border-bottom">
            <div class="col-4 my-2"><span class='h6'>[연 락 처]</span></div>
            <div class="col-8 my-2">
              <?php echo $row['MEMBER_PHONE']; ?> |
              <?php echo $row['MEMBER_EMAIL']; ?>

            </div>
          </div>

          <div class="row border-bottom">
            <div class="col-4 my-2"><span class='h6'>[배 송 지]</span></div>
            <div class="col-8 my-2">
              <?php echo $row['ZIP']; ?> | <?php echo $row['ADDR1'] . " "; ?> <?php echo $row['ADDR2'] . " "; ?> <?php echo $row['ADDR3']; ?> </div>
          </div>


          <div class="row border-bottom">
            <div class="col-4 my-2"><span class='h6'>[처리상태]</span></div>
            <div class="col-8 my-2">
              <?php

              $query = "select INSERT_DATE,CANCELED_DATE from {$Table_Mainpay} where AID = '{$row['AID']}'";
              $row_date = sql_fetch($query);

              if ($row['PAYMENT_STATUS'] == "Y") {
                $pay_date = $row_date['INSERT_DATE'];
                echo "<h6><span class=\"badge rounded-pill bg-label-primary border border-primary text-primary\">결제완료</span></h6>";
                echo "<small>[결제일] " . $pay_date . "</small><br>";
              } elseif ($row['PAYMENT_STATUS'] == "C") {
                $canceled_date = $row_date['CANCELED_DATE'];
                echo "<h6><span class=\"badge bg-label-dark\">취소완료</span></h6>";
                echo "<small>[취소일] " . $canceled_date . "</small><br>";
              } else {
                echo "<h6><span class=\"badge bg-label-dark\">미결제</span></h6>";
              }


              if ($row['PAY_METHOD'] == "CARD") {
                $pay_method = "[결제방법] 신용카드";
              } else {
                $pay_method = "[결제방법] 타행이체";
              }

              echo "<small style='color:blue;'>" . $pay_method . " / " . $row['AMOUNT'] . "원</small>";

              ?>

            </div>
          </div>

          <div class="row border-bottom">
            <div class="col-4 my-2"><span class='h6'>[배송정보]</span></div>
            <div class="col-8 my-2">
              <?php
              if ($row['TRAN_STATUS'] !== "Y") {
                echo "미배송";
              } else {
                echo $row['DELIVERY_DATE'] . " | " . $row['DELIVERY_AGENCY'] . " | " . $row['TRACKING_NO'];
                echo "<h6><span class=\"badge rounded-pill bg-success\">배송완료</span>";
              }

              ?>


            </div>
          </div>

          <div class="row border-bottom">
            <div class="col-4 my-2"><span class='h6'>[메 &nbsp;&nbsp;&nbsp; &nbsp; 모]</span></div>
            <div class="col-8 my-2">
              <?php
              if ($row['MEMO1'] == "") {
                echo "없음";
              } else {
                echo $row['MEMO1'];
              }

              ?>
            </div>

          </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            </div>
          </div>
        </div>
      </div>


  <tr>
    <td>
      <?php

        echo "<small>" . $event_code . "-" . $uid . "</small> &nbsp;&nbsp;&nbsp;";


          if ($row['THE_STATUS'] == "66" || $row['PAYMENT_STATUS'] == "C") {
            if ($row['PAYMENT_STATUS'] == "C") {
              echo "[<span class='text-info' style='text-decoration: line-through;'>" . $event_title . "</span>]";
            } else {
              echo "<i class='bx  bx-x'>[<span class='text-dark' style='text-decoration: line-through;'>" . $event_title . "</span>]";
            }
          } else {
            echo "[<span class='text-dark'>" . $event_title . "</span>]";
          }


          echo "<small class='badge border border-info text-info'>" . $row['CATE_1'] . "</small>";

          ?>

          <span class="badge border border-secondary text-secondary"><?php echo $row['LICENSE_NO']; ?></span>

          <button type='button' class='btn btn-secondary btn-sm' data-bs-toggle='modal'
            data-bs-target='<?php echo $data_target; ?>'> 상세조회</button>

        </td>

        <td>
          <?php echo "<small>" . $regis_date . "</small>"; ?><br>

          <?php
          if ($row['PAYMENT_STATUS'] == "Y") {

            echo "<h6><span class=\"badge rounded-pill bg-label-primary border border-primary text-primary\">결제완료</span></h6>";
          } elseif ($row['PAYMENT_STATUS'] == "C") {
            echo "<h6><span class=\"badge rounded-pill bg-label-dark\">취소완료</span></h6>";
          } else {
            echo "<h6><span class=\"badge rounded-pill bg-label-dark\">미결제</span></h6>";
          }

          if ($row['TRAN_STATUS'] == "" or empty($row['TRAN_STATUS'])) {
            echo "";
          } else {
            echo "<h6><span class=\"badge rounded-pill bg-label-dark\">배송완료</span></h6>";
          }
          ?>

        </td>
        <td>

          <?php
          // 민원 신청 서비스 취소 정책 설정하여 삽입해야 함. 예를 들어 사무국에서 승인하면 취소 불가능 ==> 순진 메모


          if ($row['PAYMENT_STATUS'] == "Y") {
            echo "<form id='MAINPAY_FORM' method='post'>";
            echo "<input type='hidden' name='is_del' value='yes'>";
            echo "<input type='hidden' name='AID' value='" . $row['AID'] . "'>";
            echo "<input type='hidden' name='product_code' value='" . $event_code . "'>";
            echo "<input type='hidden' name='payment_category' value='service'>";
            echo "<input type='hidden' name='the_status' value='99'>";
            echo "<button type='button' class=\"btn  btn-danger btn-sm\" onclick='payment_cancel(this.form)'>취소하기</button></h6>";

            echo "</form>";
          }

          if ($row['PAYMENT_STATUS'] == "C") {
            $canceled_date = $row_date['CANCELED_DATE'];
            echo "<small>[취소처리일]<i> " . $canceled_date . "</i></small><br>";
          }
          ?>

        </td>
      </tr>

    <?php } ?>

          <?php if ($i == 0)
            echo '<tr><td colspan="4" class="empty_table">자료가 없습니다.</td></tr>'; ?>

      </tbody>

    </table>



    <!-- 줄 띠우고 -->
    <hr class="my-2" />

    <!-- 페이징 시작 -->

    <div class="d-flex justify-content-center mx-auto gap-3">
      <nav aria-label="Page navigation example">
        <div style="text-align:center;">
          <ul class="pagination">

            <?php $basename = basename($_SERVER["PHP_SELF"]); ?>
            <li class='page-item'><a class='page-link' href="<?php echo $basename; ?>" aria-label='전체'>
                <span aria-hidden='true'>처음</span></a></li>

            <?php

            /* paging : 이전 페이지 */
            if ($page <= 1) {
            ?>
              <li class='page-item'><a class='page-link' href="<?php echo $basename; ?>?page=1" aria-label='Previous'>
                  <span aria-hidden='true'>&laquo;</span></a></li>
            <?php } else { ?>
              <li class='page-item'><a class='page-link' href="<?php echo $basename; ?>?page=<?php echo ($page - 1); ?>"
                  aria-label='Previous'>
                  <span aria-hidden='true'>&laquo;</span></a></li>
            <?php }; ?>

            <?php
            /* pager : 페이지 번호 출력 */
            for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {

              if ($page == $print_page) {
            ?>
                <li class='page-item active' aria-current="page"><a class='page-link' href="#">
                    <?php echo $print_page; ?>
                  </a>
                </li>
              <?php } else { ?>

                <li class='page-item'><a class='page-link'
                    href="<?php echo $basename; ?>?page=<?php echo $print_page; ?>"><?php echo $print_page; ?></a></li>

            <?php }
            } ?>

            <?php
            /* paging : 다음 페이지 */
            if ($page >= $total_page) {
            ?>
              <li class='page-item'><a class='page-link' href="<?php echo $basename; ?>?page=<?php echo $total_page; ?>"
                  aria-label='Next'>
                  <span aria-hidden='true'>&raquo;</span></a></li>
            <?php } else { ?>
              <li class='page-item'><a class='page-link' href="<?php echo $basename; ?>?page=<?php echo ($page + 1); ?>"
                  aria-label='Next'>
                  <span aria-hidden='true'>&raquo;</span></a></li>
            <?php }; ?>


            <li class='page-item'><a class='page-link' href="<?php echo $basename; ?>?page=<?php echo $total_page; ?>" aria-label='마지막'>
                <span aria-hidden='true'>마지막</span></a></li>


          </ul>

        </div>
      </nav>
    </div>


    <!-- 페이징 끝 -->
  </div>
</div>


<?php
include_once(G5_THEME_PATH . '/html/my_form/footer_console.php'); //공통 하단을 연결합니다.
?>