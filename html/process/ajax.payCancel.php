<?php 
 include_once "../../common.php";
 //print_r($_POST);
 
 // 취소내역이 있나 확인하기
 $r = sql_fetch("select rs_seq from t_payment where pm_trans_no='{$TID}' ");
 $r1 = sql_fetch("select rs_status from t_reserve where rs_seq='{$r['rs_seq']}' ");
 if($r1['rs_status']=='D'){
     echo json_encode(array("status"=>"2","msg"=>"이미 취소 및 환불된 내역이 있습니다."));
     exit;
 }
 
 
 
 /* 상점서명키 - 테스트(꼭 해당 상점키로 바꿔주세요)
 $MERCHANT_KEY = "0/4GFsSd7ERVRGX9WHOzJ96GyeMTwvIaKSWUCKmN3fDklNRGw3CualCFoMPZaS99YiFGOuwtzTkrLo4bR4V+Ow==";
 $MID = "SMTPAY001m";		// MID
 */
 
 // 상점서명키 - 실결제(꼭 해당 상점키로 바꿔주세요)
  $MERCHANT_KEY = "nd0So1DPQJEYbLTjyvSAZI8iXf71lL1Kx3klcJZXqmgnVLs3pcpW56D+BItbg2Sxm0vu5nIbP9ShJwqD/5nF4w==";
  $MID = "know00001m";		// MID
 
 
 // 취소비밀번호
 $_REQUEST['Cancelpw'] = '934091'; // 실제비번으로 변경해야 함
 $_REQUEST['CancelMSG'] = '결제취소';
 
 $_REQUEST['CancelAmt'] = $_POST['cAmount'];
 if($_POST['oAmount'] == $_POST['cAmount']) $_REQUEST['PartialCancelCode'] = 0; // 전체취소
 else $_REQUEST['PartialCancelCode'] = 1; // 부분취소
 
 $DEV_CANCEL_ACTION_URL = "https://tpay.smilepay.co.kr/cancel/payCancelNVProcess.jsp";//개발
 $PRD_CANCEL_ACTION_URL = "https://pay.smilepay.co.kr/cancel/payCancelNVProcess.jsp";//운영
 
 $SUCCESS_CANCEL = "2001";//취소 성공 코드
 $SUCCESS_REFUND = "2211";//환불 성공 코드(계좌이체, 가상계좌)
 $CHAR_SET = "EUC-KR";
 
 $result = "";
 $rTemp = "";
 
 //TID + 상점키 + 취소 금액 + 취소타입
 $hashData = $_REQUEST['TID'].$MERCHANT_KEY.$_REQUEST['CancelAmt'].$_REQUEST['PartialCancelCode'];
 $DivideInfo = $_REQUEST['DivideInfo']; //7.서브몰 정보
 
 if(!empty($DivideInfo)) // Base64 인코딩(utf-8 인코딩)
 {
     $temp = str_replace("&#39;", "\"", $DivideInfo);
     $euckrString = iconv("euc-kr", "utf-8", $temp);
     $b64Enc = base64_encode($euckrString);
     
     $DivideInfo = $b64Enc;
 }
 
 //취소 요청 데이터 설정
 $cancelRequest = array(
     'TID'=>$_REQUEST['TID'], 													//1.취소할 거래 TID [필수]
     'CancelAmt'=>$_REQUEST['CancelAmt'], 										//2.취소 금액	[필수]
     'Cancelpw'=>$_REQUEST['Cancelpw'], 											//3.취소 패스워드	[필수]
     'CancelMSG'=>urlencode(iconv("utf-8", "euc-kr", $_REQUEST['CancelMSG'])), 	//4.취소 사유 메세지 (euc-kr urlencoding)
     'PartialCancelCode'=>$_REQUEST['PartialCancelCode'], 						//5.전체취소 0, 부분취소 1 [전체취소 Default]
     'DivideInfo'=>$DivideInfo,													//6.서브몰 정보
     'hashData'=>base64_encode(md5($hashData)) 									//7.HASH 설정 [필수]
 );
 
 //print_r($cancelRequest);exit;
 
 
 //http 통신
 $rTemp = sendByPost($cancelRequest, $PRD_CANCEL_ACTION_URL);
 $rTemp = trim($rTemp); // 공백 제거
 
 $result = parseMessage($rTemp, '&', '=');
 
 $PayMethod = $result['PayMethod'];
 $PayName = urldecode($result['PayName']);
 $MID = $result['MID'];
 $TID = $result['TID'];
 $CancelAmt = (int)$result['CancelAmt'];
 $CancelMSG = urldecode($result['CancelMSG']);
 $ResultCode = $result['ResultCode'];
 $ResultMsg = urldecode($result['ResultMsg']);
 $CancelDate = $result['CancelDate'];
 $CancelTime = $result['CancelTime'];
 $CancelNum = $result['CancelNum'];
 $Moid = $result['Moid'];
 
 
 $partCancelRemainAmt = (int)($_POST['oAmount'] - $CancelAmt);
 
 if($SUCCESS_CANCEL == $ResultCode || $SUCCESS_REFUND == $ResultCode) {
     // 취소 및 환불 성공에 따른 가맹점 비지니스 로직 구현 필요
     if($TID){
    
      $sql = "update t_payment
              set pm_cancel_appr_no='{$TID}', pm_cancel_date='".date('Ymd',G5_SERVER_TIME)."',
                  pm_cancel_time='".date('His', G5_SERVER_TIME)."', pm_payment_type='2' , pm_update_date='".G5_TIME_YMDHIS."',
                  part_cancel_remain_amount = '{$partCancelRemainAmt}'
              where pm_trans_no='{$TID}'";
      $rs1 = sql_query($sql);
      $r = sql_fetch("select rs_seq from t_payment where pm_trans_no='{$TID}' ");
         
      $sql = "update t_reserve set rs_status='D', update_dt='".G5_TIME_YMDHIS."' where rs_seq='{$r['rs_seq']}' ";
      $rs0 = sql_query($sql);
      
      if($rs0 && $rs1){
       echo json_encode(array("status"=>"1","msg"=>"결제내역이 취소 및 환불 되었습니다."));
       
      }else{
       echo json_encode(array("status"=>"0","msg"=>"결제내역의 취소 및 환불이 정상적으로 되지 않았습니다.\n관리자에게 문의하시기 바랍니다."));
       
      }   
      
     }
 } else {
         echo json_encode(array("status"=>"0","msg"=>"결제내역의 취소 및 환불이 정상적으로 되지 않았습니다.\n관리자에게 문의하시기 바랍니다.."));exit;
         //echo json_encode(array("status"=>"0","msg"=>"결제내역의 취소 및 환불이 정상적으로 되지 않았습니다.({$ResultMsg})관리자에게 문의하시기 바랍니다."));
   }
 

/**
* 응답메세지 파싱
* @param plainText
* @param delim
* @param delim2
* @return
*/
function parseMessage($plainText, $delim, $delim2)
{
    $tokened_array = explode($delim, $plainText);
	$temp = "";
	$retData = [];

	for ($i = 0; $i < count($tokened_array); $i++) {
		$temp = $tokened_array[$i];
		if ('' != $temp) {
			$temp_array = explode($delim2, $temp);
			$key = trim($temp_array[0]);
			$value = trim($temp_array[1]);
			$retData[$key] = $value;
		}
	}
    return $retData;
}

/**
 * @description Make HTTP-GET call
 * @param       $url
 * @param       array $params
 * @return      HTTP-Response body or an empty string if the request fails or is empty
 */
function sendByGet(array $params, $url) {
	$query = http_build_query($params); 
	$ch    = curl_init($url.'?'.$query);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
/**
 * @description Make HTTP-POST call
 * @param       $url
 * @param       array $params
 * @return      HTTP-Response body or an empty string if the request fails or is empty
 */
function sendByPost(array $params, $url) {
	$query = http_build_query($params);

	$ch    = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
?>