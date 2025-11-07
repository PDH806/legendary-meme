<?php
 include_once $_SERVER['DOCUMENT_ROOT'].'/common.php';
 $_POST = array_map('trim',$_POST);

 //print_r($_POST);
 
 
 if(!is_mobile()){
     if(preg_match('/Chrome/i',$_SERVER['HTTP_USER_AGENT']) or preg_match('/Safari/i',$_SERVER['HTTP_USER_AGENT']) )
         ;
     else
         $_POST = array_map('iconv_utf8',$_POST);
 }
 //print_r($_POST);
 //  print_r($_FILES);
 //  exit;
 
 //$_POST['seq'] = 'GD4493';
 
 $sql = "select  gd_name, GD_OPEN_DT from t_goods where gd_seq = '{$_POST['seq']}' ";
 //echo $sql;exit;
 $sd_date = sql_fetch($sql);
 
 //echo $sd_date['GD_SALE_ENDDT'];exit;
 $date4 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_OPEN_DT'],0,8)." -4 days "))); // 100% 환불
 $date3 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_OPEN_DT'],0,8)." -3 days "))); // 70% 환불
 $date2 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_OPEN_DT'],0,8)." -2 days "))); // 50% 환불
 $date1 = strtotime(date('Ymd',strtotime(substr($sd_date['GD_OPEN_DT'],0,8)." -1 days "))); // 환불불가
 
 $today = strtotime(date('Ymd',strtotime(date('Ymd'))));
 
 //$_POST['kind_value'] = $_POST['kind_value'] ? $_POST['kind_value'] : $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3'];
 if($_POST['kind']=='RS_BUYER_EMAIL') $_POST['kind_value'] = $_POST['kind_value'];
 else $_POST['kind_value'] = $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3'];
 
 $sql = "select rs_buyer_amount, rs_seq from t_reserve where gd_seq='{$_POST['seq']}' and {$_POST['kind']}='{$_POST['kind_value']}' 
and  RS_BUYER_PWD='{$_POST['RS_BUYER_PWD']}' order by INSERT_DT desc limit 1";
 //echo $sql;exit;
 $r1 = sql_fetch($sql);
 
 $sql = "select pm_pay_method, pm_trans_no, rs_seq  from t_payment where rs_seq='{$r1['rs_seq']}' and PM_PAYMENT_TYPE='1' ";
 $r2 = sql_fetch($sql);
 
 
 //스키구조요원 마감일
 //$date4 = strtotime(date("20200219"));
 //$date3 = strtotime(date("20200220"));
 //$date2 = strtotime(date("20200221"));
 //$today = strtotime(date("20190226"));
 
 
 if($today <= $date4) $cAmount = $r1['rs_buyer_amount'];
 else if($today <= $date3 ) $cAmount = $r1['rs_buyer_amount'] * 0.7;
 else if($today <= $date2 ) $cAmount = $r1['rs_buyer_amount'] * 0.5;
 else $cAmount = '0';
 
 
 
 
 //echo '<br>$cAmount : ' . $cAmount;exit;
 
 /*if($today >= $date4 && $today < $date3)
  $cAmount = $r1['rs_buyer_amount'];
 else if($today >= $date3 && $today < $date2)
  $cAmount = (int)$r1['rs_buyer_amount'] * 0.7 ;
 else if($today >= $date2 && $today < $date1)
  $cAmount = (int)$r1['rs_buyer_amount'] * 0.5 ;
 else
  $cAmount = '0';
 */              
 //echo '<br>$cAmount : ' . $cAmount;exit;
 
 
 
 
 if($_POST['kind']){
   if($_POST['kind']=='RS_BUYER_EMAIL')
    $sql = "select a.* , b.part_cancel_remain_amount remain, b.pm_pay_method from t_reserve a left join t_payment b on a.rs_seq=b.rs_seq 
where {$_POST['kind']} = '{$_POST['kind_value']}' and RS_BUYER_PWD = '{$_POST['RS_BUYER_PWD']}' and GD_SEQ='{$_POST['seq']}' order by rs_date desc limit 1 ";
   else 
    $sql = "select a.* , b.part_cancel_remain_amount remain, b.pm_pay_method from t_reserve a left join t_payment b on a.rs_seq=b.rs_seq
where {$_POST['kind']} = '{$_POST['hp1']}-{$_POST['hp2']}-{$_POST['hp3']}' and RS_BUYER_PWD = '{$_POST['RS_BUYER_PWD']}' and GD_SEQ='{$_POST['seq']}' order by rs_date desc limit 1 ";
    
   //echo $sql;exit;
   
   $rs = sql_query($sql);
   if(!sql_num_rows($rs)){
    echo "<script>alert(\"접수내역이 존재하지 않습니다\");history.back();</script>";
    exit;
   }
   
   $r = sql_fetch_array($rs);
 }else{
      $sql = "select a.* , b.part_cancel_remain_amount remain, b.pm_pay_method from t_reserve a left join t_payment b on a.rs_seq=b.rs_seq
where ( rs_buyer_tel = '{$_POST['hp1']}-{$_POST['hp2']}-{$_POST['hp3']}' or rs_buyer_tel = '{$_POST['hp1']}{$_POST['hp2']}{$_POST['hp3']}') and RS_BUYER_PWD = '{$_POST['passwd']}' and GD_SEQ='{$_POST['seq']}' order by rs_date desc limit 1 ";
     $r = sql_fetch($sql);
     
 }
 //print_r($r);
 
 
 include $DOCUMENT_ROOT."/ski/include/head_common.html";
 
 // 신청기간 확인
 $sql = "select gd_name, idkey , gd_seq, (select pl_web_price from t_price_level where gd_seq='{$_POST[seq]}' ) price,
						(select gd_sale_startdt from t_goods where gd_seq='{$_POST[seq]}' ) date1,
						(select gd_sale_enddt from t_goods where gd_seq='{$_POST[seq]}' ) date2
						from t_goods where gd_seq='{$_POST[seq]}' ";
 $r1 = sql_fetch($sql);
 
 $now = strtotime(date("Y-m-d"));
 $st_date = strtotime(substr($r1['date1'],0,4).'-'.substr($r1['date1'],4,2).'-'.substr($r1['date1'],6,2));
 $end_date = strtotime(substr($r1['date2'],0,4).'-'.substr($r1['date2'],4,2).'-'.substr($r1['date2'],6,2));
 if($now >= $st_date && $now <= $end_date) $expiry = true;
 else $expiry = false;
 // 신청기간 확인
 
 //$expiry = 1;
?>
 <body>
        <div id="scroll_top">
            <button type="button"><img src="/ski/images/scr_top.jpg"></button>
        </div>
        <div id="wrap">
            <? 
            include $DOCUMENT_ROOT."/ski/include/sb_header.html" 
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
                                        <form name='frm2' action=''  method='post'>
                                         <input type='hidden' name='rs_seq' value='<?=$r['RS_SEQ']?>' />
                                         <input type='hidden' name='gd_seq' value='<?=$_POST['seq']?>' />
                                        </form>
                                        <!-- 
                                        <? if($expiry && $r['RS_STATUS'] != 'D'){?>
                                            <li ><a href="javascript:frm2.action='../patrol_accept_update.html';frm2.submit();">접수수정</a></li>
                                            <li><a href="javascript:frm2.action='../patrol_accept_ck.html';frm2.submit();">접수내역</a></li>
                                            <li class='on'><a href='javascript:void(0)'>결제확인 / 취소</a></li>
                                        <?php }else{?>
                                        	<li><a href="javascript:alert('신청기간이 아닙니다.')">접수수정</a></li>
                                        	<li><a href="javascript:alert('신청기간이 아닙니다.')">접수내역</a></li>
                                        	<li><a href="javascript:alert('신청기간이 아닙니다.')">결제확인 / 취소</a></li>
                                        <?php }?>
                                         
                                            <li ><a href="javascript:frm2.action='/ski/patrol_accept_update.html';frm2.submit();">접수수정</a></li>
                                            -->
                                            <li><a href="javascript:frm2.action='/ski/patrol_accept_ck.html';frm2.submit();">접수내역</a></li>
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
                                                    <div class="tit_box">
                                                    <span class="sb_tit"><?php echo get_text($sd_date['gd_name'])?>&nbsp;신청 결제내역</span>
                                                    </div>
                                 <!-- 
                                 <div>
                                 <?php echo "select a.* , b.part_cancel_remain_amount remain, b.pm_pay_method from t_reserve a left join t_payment b on a.rs_seq=b.rs_seq
where rs_buyer_tel = '{$_POST['hp1']}-{$_POST['hp2']}-{$_POST['hp3']}' and RS_BUYER_PWD = '{$_POST['passwd']}' and GD_SEQ='{$_POST['seq']}' order by rs_date desc limit 1 ";?>
                                 </div>
                                 -->

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
                                                                        else if($r['RS_STATUS']=='V') echo "<span style='color:red;font-weight:bold'> [입금대기]</span>";
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
                                                                        if($_POST['AuthDate']){
                                                                         echo '20'.substr($_POST['AuthDate'],0,2).'-'.substr($_POST['AuthDate'],2,2).'-'.substr($_POST['AuthDate'],4,2);
                                                                         echo ' ';
                                                                         echo substr($_POST['AuthDate'],6,2).':'.substr($_POST['AuthDate'],8,2).':'.substr($_POST['AuthDate'],10,2);
                                                                        }else{
                                                                         echo $r['RS_DATE'];         
                                                                        }
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
                                                                         if($_POST['kind']){
                                                                          if($r['pm_pay_method']=='CARD') echo  "신용카드" ;
                                                                          else if($r['pm_pay_method']=='BANK') echo "계좌이체";
                                                                          else if($r['pm_pay_method']=='DIRECTBANK') echo "무통장입금";
                                                                         }else{
                                                                          if($_POST['PayMethod']=='CARD') echo "신용카드";
                                                                          else if($_POST['PayMethod']=='BANK') echo "계좌이체";
                                                                          else if($_POST['PayMethod']=='DIRECTBANK') echo "무통장입금";
                                                                         }
                                                                         ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                       <th>결제금액&nbsp;</th>
                                                                        <td>
                                                               <span class="color_1 date">
                                                               <?php 
                                                               if($_POST['PayMethod']=='CARD' || $_POST['PayMethod']=='BANK' ){
                                                                   echo number_format($_POST['amount'] ? $_POST['amount'] : $r['RS_BUYER_AMOUNT'] )."원";
                                                               }else if($_POST['PayMethod']=='DIRECTBANK'){
                                                                   echo "<div>입금대기</div>";
                                                                   echo "<div>입금은행 : 기업은행 411-084265-04-010, 예금주 : 노스타일(주)</div>";
                                                               }else{
                                                                   echo number_format($r['RS_BUYER_AMOUNT'] )."원";
                                                               }
                                                               
                                                               if($r['remain'] && ($r['pm_pay_method']=='CARD' or $r['pm_pay_method']=='BANK' ) ){ echo " <span style='color:red'> [취소금액:  ".number_format($r['PM_PAY_AMOUNT']-$r[remain])."원] </span>"; }
                                                               else if($r['pm_pay_method']=='DIRECTBANK' && $r['RS_STATUS']=='V') { 
                                                                   echo "<div>입금대기</div>";
                                                                   echo "<div>입금은행 : 기업은행 411-084265-04-010, 예금주 : 노스타일(주)</div>";
                                                               }
                                                               else if($r['pm_pay_method']=='DIRECTBANK' && $r['RS_STATUS']=='C') { echo number_format($r['RS_BUYER_AMOUNT'])."원"; }
                                                                ?>
                                                                </span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php if($_POST['kind']){ ?>
                                                                    <tr>
                                                                       <th>결제취소&nbsp;</th>
                                                                        <td>
                                                               				<div>
                                                               				<?php if($r['pm_pay_method']=='CARD' or $r['pm_pay_method']=='BANK' ) { ?>
                                                               				
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
																			      url : '/ski/process/ajax.payCancel.php',
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
																				   //alert(data);
																				  },
																				  /*error : function(){
																				   alert("결제내역의 취소 및 환불이 정상적으로 되지 않았습니다.\n관리자에게 문의하시기 바랍니다.");
																				  },
																				  */
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
                                                               				 <?php  } else { // 무통장입금 ?>
                                                               				 <?php echo "관리자에게 문의부탁드립니다."; ?>
                                                               				 <?php  } ?>
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