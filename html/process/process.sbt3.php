<?php
 include_once $_SERVER['DOCUMENT_ROOT'].'/common.php';
 $_POST = array_map('trim',$_POST);

 if(!G5_IS_MOBILE){
     if(preg_match('/Chrome/i',$_SERVER['HTTP_USER_AGENT']) or preg_match('/Safari/i',$_SERVER['HTTP_USER_AGENT']) )
         ;
     else
         $_POST = array_map('iconv_utf8',$_POST);
 }
 
 /*print_r($_POST);
 print_r($_FILES);
 */
 
 
 $sql = "select  GD_SALE_ENDDT from t_goods where gd_seq = '{$_POST['seq']}' ";
 $sd_date = sql_fetch($sql);
 
 /*$date4 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_SALE_ENDDT'],0,8)." -4 days ")));// date('Y-m-d', strtotime("-4 day", strtotime(substr($sd_date['GD_SALE_ENDDT'],0,4).'-'.substr($sd_date['GD_SALE_ENDDT'],4,2).'-'.substr($sd_date['GD_SALE_ENDDT'],6,2))))); // 100% 항불
 $date3 = strtotime(date('Y-m-d', strtotime("-3 day", strtotime(substr($sd_date['GD_SALE_ENDDT'],0,4).'-'.substr($sd_date['GD_SALE_ENDDT'],4,2).'-'.substr($sd_date['GD_SALE_ENDDT'],6,2))))); // 70% 항불
 $date2 = strtotime(date('Y-m-d', strtotime("-2 day", strtotime(substr($sd_date['GD_SALE_ENDDT'],0,4).'-'.substr($sd_date['GD_SALE_ENDDT'],4,2).'-'.substr($sd_date['GD_SALE_ENDDT'],6,2))))); // 50% 항불
 $date1 = strtotime(date('Y-m-d', strtotime("-1 day", strtotime(substr($sd_date['GD_SALE_ENDDT'],0,4).'-'.substr($sd_date['GD_SALE_ENDDT'],4,2).'-'.substr($sd_date['GD_SALE_ENDDT'],6,2))))); // 환불불가
 */
 $date4 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_SALE_ENDDT'],0,8)." -4 days "))); // 100% 환불
 $date3 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_SALE_ENDDT'],0,8)." -3 days "))); // 70% 환불
 $date2 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_SALE_ENDDT'],0,8)." -2 days "))); // 50% 환불
 $date1 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_SALE_ENDDT'],0,8)." -1 days "))); // 환불불가
 
 
 $today = strtotime(date('Ymd',strtotime(date('Ymd'))));
 
 //$_POST['kind_value'] = $_POST['kind_value'] ? $_POST['kind_value'] : $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3'];
 
 if($_POST['kind']=='RS_BUYER_EMAIL') $_POST['kind_value'] = $_POST['kind_value'];
 else $_POST['kind_value'] = $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3'];
 
 $sql = "select rs_buyer_amount, rs_seq from t_reserve where idkey='{$_POST['key']}' and gd_seq='{$_POST['seq']}' and {$_POST['kind']}='{$_POST['kind_value']}' order by rs_date desc limit 1";
 //echo $sql;exit;
 $r1 = sql_fetch($sql);
 
 $sql = "select pm_pay_method, pm_trans_no, rs_seq  from t_payment where rs_seq='{$r1['rs_seq']}' /*and PM_PAYMENT_TYPE='1'*/";
 $r2 = sql_fetch($sql);
 

 /*echo '$date4 : ' . $date4 .'<br>';
 echo '$date3 : ' . $date3 .'<br>';
 echo '$date2 : ' . $date2 .'<br>';
 echo '$date1 : ' . $date1 .'<br>';
 echo '$today : ' . $today .'<br>';
 */
 if($today <= $date4) $cAmount = $r1['rs_buyer_amount'];
 else if($today <= $date3) $cAmount = $r1['rs_buyer_amount'] * 0.7;
 else if($today <= $date2) $cAmount = $r1['rs_buyer_amount'] * 0.5;
 else $cAmount = '0';
               
 //echo '<br>$cAmount : ' . $cAmount;exit;
 
 
 
 // 조회 $kind => 휴대폰/이메일, $kind_value=>휴대폰/이메일 값
 if($_POST['kind']){
     
     
   $sql = "select * , b.part_cancel_remain_amount remain from t_reserve a left join t_payment b on a.rs_seq=b.rs_seq 
where {$_POST['kind']} = '{$_POST['kind_value']}' and RS_BUYER_PWD = '{$_POST['RS_BUYER_PWD']}' and GD_SEQ='{$_POST['seq']}' order by a.rs_date desc limit 1";
   //echo $sql;exit;
   $rs = sql_query($sql);
   if(!sql_num_rows($rs)){
    echo "<script>alert('접수내역이 존재하지 않습니다');history.back();</script>";
    exit;
   }
   
   $r = sql_fetch_array($rs);
     
 // 등록
 }else{
 
 
 $sql = "select  GD_SALE_ENDDT from t_goods where gd_seq = '{$_POST['seq']}' ";
 $sd_date = sql_fetch($sql);
 $sd_date = substr($sd_date['GD_SALE_ENDDT'],0,8);
 
 if(strlen($_POST['birth1']) > 2) $bt = substr($_POST['birth1'],2);
 else $bt = $_POST['birth1'];
 $rs_buyer_idkey = $bt.sprintf('%02d',$_POST['birth2']).sprintf('%02d',$_POST['birth3']); 
 
 $tel = $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3'];
 $rs_status = $_POST['PayMethod']=='CARD' || $_POST['PayMethod']=='BANK' ? "C" : "V"; // C -> 신청완료, V -> 입금대기
 $add_birth = $_POST['birth1'].'-'.$_POST['birth2'].'-'.$_POST['birth3'];
 
 $sql = "SELECT count(*) cnt FROM t_reserve where IDKEY='{$_POST['key']}' AND  GD_SEQ='{$_POST['seq']}' AND RS_SEQ='{$_POST['OID']}'";
 //echo "<Br>$sql";exit;
 $chk = sql_fetch($sql);
 if(!$chk['cnt']){
 
 // file upload
 if (isset($_FILES)) {    
  $upload_max_filesize = ini_get('upload_max_filesize');
  $tmp_file  = $_FILES['bf_file']['tmp_name'];
  $filesize  = $_FILES['bf_file']['size'];
  $filename  = $_FILES['bf_file']['name'];
  $filename  = get_safe_filename($filename);
  // 서버에 설정된 값보다 큰파일을 업로드 한다면
  if ($filename) {
   if ($_FILES['bf_file']['error'] == 1) {
    $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
   }
   else if ($_FILES['bf_file']['error'][$i] != 0) {
    $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
   }
  }
  if($file_upload_msg){
      echo "<form name='frm1' action='' method='post'>";
      foreach($_POST as $k=>$v){
          echo "<input type='hidden' name='{$k}' value='{$v}' />";
      }
      echo "</form>";
      echo "<script>frm1.submit();</script>";
      exit;
  }
  
  if (is_uploaded_file($tmp_file)) {
    
      // 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
      mkdir(G5_DATA_PATH.'/file/'.$_POST['key'].'/'.$_POST['seq'], G5_DIR_PERMISSION,true);
      chmod(G5_DATA_PATH.'/file/'.$_POST['key'].'/'.$_POST['seq'], G5_DIR_PERMISSION);
      //echo "path : " . G5_DATA_PATH.'/file/'.$_POST['key'].'/'.$_POST['seq'] ;exit;
      
      $chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
      // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
      $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
      shuffle($chars_array);
      $shuffle = implode('', $chars_array);
      
      // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
      $upfile = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);
      
      $dest_file = G5_DATA_PATH.'/file/'.$_POST['key'].'/'.$_POST['seq'].'/'.$upfile;
      // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
      $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);
      // 올라간 파일의 퍼미션을 변경합니다.
      chmod($dest_file, G5_FILE_PERMISSION);
      $db_ins_file = '/data/file/'.$_POST['key'].'/'.$_POST['seq'].'/'.$upfile;
  }
  
  
 }
 
 
 $sql = "INSERT INTO  t_reserve SET
            IDKEY='{$_POST['key']}', GD_SEQ='{$_POST['seq']}', RS_SEQ='{$_POST['OID']}',
            RS_DATE='".G5_TIME_YMDHIS."', RS_SD_DATE='".$sd_date."', RS_BUYER_IDKEY='{$rs_buyer_idkey}', 
            RS_BUYER_NAME='{$_POST['BuyerName']}', RS_BUYER_EMAIL='{$_POST['BuyerEmail']}', RS_BUYER_TEL='{$tel}', 
            RS_BUYER_PWD = '{$_POST['passwd']}' ,  RS_BUYER_AMOUNT='{$_POST['amount']}' , RS_PERSON='1', 
            RS_STATUS = '{$rs_status}', RS_TOT_AMT = '{$_POST['amount']}', RS_BUYER_PHOTO='{$_POST['uploadPhoto']}', 
            RS_BUYER_DOC='$db_ins_file', INSERT_IDKEY='$rs_buyer_idkey'
";
  sql_query($sql);
  //echo $sql;exit;
 }
 
 $sql = "SELECT count(*) cnt FROM t_reserve_add_info where IDKEY='{$_POST['key']}' AND  GD_SEQ='{$_POST['seq']}' AND RS_SEQ='{$_POST['OID']}'";
 $chk = sql_fetch($sql);
 if(!$chk['cnt']){
 $sql = "INSERT INTO  t_reserve_add_info SET
            IDKEY='{$_POST['key']}', GD_SEQ='{$_POST['seq']}', RS_SEQ='{$_POST['OID']}',
            ADD_NAME_KOR='{$_POST['hname']}', ADD_NAME_ENG='{$_POST['ename']}', ADD_BIRTH='{$rs_buyer_idkey}', ADD_TEL='{$tel}',
            ADD_BELONG_TO='{$_POST['branch']}', ADD_ADDR_TYPE='{$_POST['part']}', ADD_ZIPCODE='{$_POST['zip']}',
            ADD_ADDR1 = '{$_POST['addr1']}' ,  ADD_ADDR2='{$_POST['addr2']}' , ADD_EXEMPT_TYPE='{$_POST['except']}',
            REGIST_DATE = '".G5_TIME_YMDHIS."'
";
  sql_query($sql);
 }
 
 $pm_method = $_POST['PayMethod'] == 'CARD' ? 'CARD' : 'BANK';
 $sql = "SELECT count(*) cnt FROM t_payment where IDKEY='{$_POST['key']}' AND RS_SEQ='{$_POST['OID']}' AND PM_TRANS_NO='{$_POST['TID']}'";
 $chk = sql_fetch($sql);
 if(!$chk['cnt']){
 $sql = "INSERT INTO  t_payment SET
            IDKEY='{$_POST['key']}', RS_SEQ='{$_POST['OID']}', PM_PAY_METHOD='{$pm_method}', 
            PM_TRANS_NO='{$_POST['TID']}', PM_ORDER_NO='{$_POST['OID']}', PM_PAY_AMOUNT='{$_POST['amount']}',
            PM_APPROVAL_DATE='".date('Ymd')."', PM_APPROVAL_TIME='".date('His')."', PM_BANK_CODE='' , PM_PAYMENT_TYPE='1' , 
            PM_PG_NAME='SMARTRO' , PM_CARD_ISSUE_NAME='{$_POST['BankName']}', PM_ACQUIRER_CODE='{$_POST['BankCode']}', PM_BANK_NAME='{$_POST['BankName']}', 
            PM_ACCOUNT_NO='', PM_DEPOSIT_NAME='{$_POST['BuyerName']}', PM_EXPIRE_DATE='',  PM_REGIST_DATE='".G5_TIME_YMDHIS."', PM_REGIST_ID='{$_POST['BuyerName']}' ";
 sql_query($sql);

 //echo $sql;exit;
 }
 
 // SMS 보내기
 include_once(G5_SMS5_PATH.'/sms5.lib.php');
 $SMS = new SMS5;
 $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);
 /*
  *  array([0] => array([bk_hp]=>01074118679 [bk_name]=>이석호)) 형식
  * 
  */
 $reply = '0234731275';
 $wr_message = "-(사)한국스키장경영협회- {$_POST['GoodsName']} 접수가 완료되었습니다. ";
 $list[0] = array('bk_hp'=> $_POST['hp1'].$_POST['hp2'].$_POST['hp3'] , 'bk_name'=>$_POST['BuyerName']);
 $wr_total = count($list);
 
 $rslt = $SMS->Add2($list, $reply,'','',$wr_message, $booking, $wr_total);
 
 if($rslt){
  
  // check   
  $wr_memo = "{$_POST['hp1']}{$_POST['hp2']}{$_POST['hp3']}||{$_POST['seq']}||{$_POST['TID']}";
  $sql = "SELECT count(*) cnt FROM {$g5['sms5_write_table']} WHERE wr_memo = '$wr_memo' ";
  $chk = sql_fetch($sql);
  
  if(!$chk['cnt']){
   $rslt_1 = $SMS->Send();
   if($rslt_1){
    $row = sql_fetch("select max(wr_no) as wr_no from {$g5['sms5_write_table']}");
    if ($row)  $wr_no = $row['wr_no'] + 1;
    else   $wr_no = 1;
   
    sql_query("insert into {$g5['sms5_write_table']} set 
             wr_no='$wr_no', wr_renum=0, wr_reply='$reply', wr_message='$wr_message', 
             wr_booking='$wr_booking', wr_total='$wr_total', wr_datetime='".G5_TIME_YMDHIS."', wr_memo='$wr_memo' ");
   }
  }
 }
 $SMS->Init();
 }// 결제 후 넘어온 것
 include "../include/head_common.html";
 
?>
 <body>
 <form name='f2' method='post'>
  <input type='hidden' name='key' value='<?php echo $_POST['key']?>' />
  <input type='hidden' name='seq' value='<?php echo $_POST['seq']?>' />
 </form>
        <div id="scroll_top">
            <button type="button"><img src="/ski/images/scr_top.jpg"></button>
        </div>
        <div id="wrap">
            <? 
                include"../include/sb_header.html" 
            ?>
                <!-- ㅡㅡㅡㅡㅡㅡㅡㅡ/SB_HEADERㅡㅡㅡㅡㅡㅡㅡㅡ -->
                <div id="sbcenter" class="accept">
                    <div class="sbcenter teach_data">
                        <div class="sb_content">
                            <!--/sb_top_text-->
                            <div class="tab_wrap">
                                <div class="accept_wrap menu">
                                    <div class="tab_menu_area inner_menu">
                                        <ul class="tab_menu sbclear">
                                            <!-- <li ><a href="../snow_data_3.html ">접수하기</a></li>-->
                                            <li><a href="javascript:f2.action='../snow_accept_t3_ck.html';f2.submit();">접수내역</a></li> 
                                            <li class='on'><a href='javascript:void(0)'>결제확인 / 취소</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--/tab_menu_area-->
                                <div class="tab_list_area tab_click_list">
                                    <div class="tab1">
                                        <div class="patrol_list">
                                            <div class="content_box">
                                                <div class="txt_box">
                                                    <div class="tit_box"><span class="sb_tit">스노보드 지도요원(티칭3) 신청 결제내역</span></div>
                                 

                                                        <fieldset>
                                                            <table class="accept_table">
                                                                <caption>접수하기</caption>
                                                                <colgroup></colgroup>
                                                                <tbody>
                                                                <tr>
                                                                        <th>접수번호 &nbsp;</th>
                                                                        <td class="date">
                                                                        <?php 
                                                                        echo $_POST['OID'] ? $_POST['OID'] : $r['RS_SEQ'];
                                                                        if($r['RS_STATUS']=='D') echo "<span style='color:red;font-weight:bold'> [결제취소]</span>";
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>결제일 &nbsp;</th>
                                                                        <td class="date">
                                                                        <?php 
                                                                        if($_POST['kind']):
                                                                         echo $r['RS_DATE'];
                                                                        else:
                                                                         echo '20'.substr($_POST['AuthDate'],0,2).'-'.substr($_POST['AuthDate'],2,2).'-'.substr($_POST['AuthDate'],4,2);
                                                                         echo ' ';
                                                                         echo substr($_POST['AuthDate'],6,2).':'.substr($_POST['AuthDate'],8,2).':'.substr($_POST['AuthDate'],10,2);
                                                                        endif;
                                                                         ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>신청자명 &nbsp;</th>
                                                                        <td><?php echo $_POST['BuyerName'] ? $_POST['BuyerName'] : $r['RS_BUYER_NAME']?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>이메일 &nbsp;</th>
                                                                        <td><?php echo $_POST['BuyerEmail'] ? $_POST['BuyerEmail'] : $r['RS_BUYER_EMAIL']?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>결제수단 &nbsp;</th>
                                                                        <td>
                                                                         <?php 
                                                                         if($_POST['kind']):
                                                                          echo $r['PM_PAY_METHOD']=='CARD' ? "신용카드" : "계좌이체";
                                                                         else:
                                                                          if($_POST['PayMethod']=='CARD') echo "신용카드";
                                                                          else echo "계좌이체";
                                                                         endif;
                                                                         ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                       <th>결제금액&nbsp;</th>
                                                                        <td>
                                                               <span class="color_1 date">
                                                               <?php 
                                                                echo number_format($_POST['amount'] ? $_POST['amount'] : $r['RS_BUYER_AMOUNT'] )."원";
                                                                if($r['remain']){ echo " <span style='color:red'> [취소금액:  ".number_format($r['PM_PAY_AMOUNT']-$r[remain])."원] </span>"; }
                                                                ?></span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php if($_POST['kind']){ ?>
                                                                    <tr>
                                                                       <th>결제취소&nbsp;</th>
                                                                        <td>
                                                               				<div>
                                                               				 <form name='f1' action='post' onsubmit='return chkF1(this)'>
                                                               				  <input type='hidden' name='oAmount' value='<?php echo $r['RS_BUYER_AMOUNT']?>' />
                                                               				  <input type='hidden' name='TID' value='<?php echo $r2['pm_trans_no']?>' />
                                                               				  
                                                               				  <input type='text' name='cancel_amount' maxlength="10" value='<?php if($cAmount > 0) echo $cAmount; else echo "환불불가";?>' 
                                                               				   <?php if($cAmount == '0') echo "disabled style='background:#efefef;'";?> readOnly/>
                                                               				  <input type='submit' value='취소' />
                                                               				 </form>
                                                               				 <script>
																				function chkF1(f){
																				 if(f.cancel_amount.value=='환불불가'){
																				  alert('환불불가입니다.\n환불규정을 확인해 주세요');
																				  return false;
																				 }
																				 $.ajax({
																			      url : './ajax.payCancel.php',
																			      type : 'post',
																			      async : true,
																			      dataType :'json',
																			      data : {
																					oAmount : f.oAmount.value,
																					TID : f.TID.value,
																					cAmount : f.cancel_amount.value
																			      },
																			      success : function(data){
																				   alert(data.msg);
																				  },
																				  beforeSend : function(){
																				   $('.wrap-loading').removeClass('display-none');
																				  },
																				  complete : function(){
																				   $('.wrap-loading').addClass('display-none');
																				  }
																				 });
																				 return false;
																				}
                                                               				 </script>
                                                               				 <?php include_once G5_SKI_PATH.'/process/loading.php'?>
                                                               				</div>
                                                               				<div>
                                                               					<p>환불규정</p>
                                                               					<p>
                                                               					참가비 환불은 아래기간의 경우에만 가능하며 이 후에는 취소 및 환불이 일체 불가능합니다. <br>또한, 환불 시 이체 수수료는 참가자 본인이 부담해야 합니다.
                                                    <br>
                                                    <br>시험 4일전 취소 100% 환불
                                                    <br>시험 3일전 취소 70% 환불
                                                    <br>시험 2일전 취소 50% 환불
                                                    <br>시험 1일전 취소 환불 불가
                                                               					</p>
                                                               					
                                                               				</div>
                                                                        </td>
                                                                    </tr>
                                        							<?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </fieldset>
                                                </div>
                                                <!--txt_box-->
                                            
                                            </div>
                                            <!--/content_box-->
                                        </div>
                                        <!--/partrol_list-->
                                    </div>
                                    <!--/tab1-->
                                </div>
                                <!--/tab_list_area-->
                            </div>
                            <!--/tab_wrap-->

   
   
   
   
                        </div>
                        <!--/sb_content-->
                    </div>
                    <!-- //sbcenter -->
                </div>
                <!-- //sbcenter -->

        <!-- ㅡㅡㅡㅡㅡㅡㅡㅡFOOTERㅡㅡㅡㅡㅡㅡㅡㅡ -->
        <!--footer-->
        <div class="footer">
            <footer class="sb_footer">
                <div class="footer_wrap">
                    <div class="inwrap">
                        <div class="ft_info">
                            <div class="ft_link">
                                <ul>
                                    <li style="display:block">(주)노스타일 대표자 : 황덕삼</li>
                                    <li>경기도 성남시 분당구 정자일로 177 인텔리지2 3층 309호</li>
                                    <li>대표전화 <a href="tel:1899-5833">1899-5833</a></li>
                                    <li>문의&nbsp;&nbsp;<a href="mailto:web_master@knowstyle.co.kr">web_master@knowstyle.co.kr</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- //ft_info -->

                    </div>
                    <!-- //inwrap -->
                </div>
                <!-- //footer_wrap -->
            </footer>
            <!-- //sb_footer -->
        </div>
        <!--//footer-->
    </div>
    <!-- //wrap -->
</body>

</html>
<style>
 .accept_table .date{padding:0px}
</style>