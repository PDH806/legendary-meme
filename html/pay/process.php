<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/db_config.html';
	include_once $_SERVER['DOCUMENT_ROOT'].'/js/juery-1.11.1.min.js';
	echo "<meta charset='utf-8' />";
// sql_escape_string 함수에서 사용될 패턴
define('G5_ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');
define('G5_ESCAPE_REPLACE',  '');


// multi-dimensional array에 사용자지정 함수적용
function array_map_deep($fn, $array)
{
    if(is_array($array)) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = array_map_deep($fn, $value);
            } else {
                $array[$key] = call_user_func($fn, $value);
            }
        }
    } else {
        $array = call_user_func($fn, $array);
    }

    return $array;
}


// SQL Injection 대응 문자열 필터링
function sql_escape_string($str)
{
    if(defined('G5_ESCAPE_PATTERN') && defined('G5_ESCAPE_REPLACE')) {
        $pattern = G5_ESCAPE_PATTERN;
        $replace = G5_ESCAPE_REPLACE;

        if($pattern)
            $str = preg_replace($pattern, $replace, $str);
    }

    $str = call_user_func('addslashes', $str);

    return $str;
}
	array_map_deep(sql_escape_string, $_POST);
	extract($_POST);

	
	$mode = $_POST['mode'];

	// 시험응시
	if($mode=='payment0'){

		$MEMBER_ID 	= $_POST["MEMBER_ID"];
		$MEMBER_NO 	= $_POST["MEMBER_NO"];
		$BuyerTel 	= $_POST["BuyerTel"];
		$LICENSE 	= $_POST["LICENSE"]; // ?? 
		$TRAN_DATE 	= $_POST["Test_Date"];
		$Test_No 	= $_POST["Test_No"];
		$Apply_date = substr($_POST["Apply_date"],0,4).'-'.substr($_POST["Apply_date"],4,2).'-'.substr($_POST["Apply_date"],6,2);
		$Skiresort_No = $_POST["Skiresort_No"];
		$VACCINE	= $_POST["VACCINE"]; // 코로나19 백신접종여부 , 2:2차접종완료, 3:3차접종완료
		$PASS		= $_POST["PASS"]; // 면제사유
		$GENDER2	= $_POST["GENDER2"]; // 성별, 1:남성, 2:여성


		$ZONE_CODE 	= $_POST["ZIP"];
		$ADDR1 		= $_POST["ADDRESS1"];
		$ADDR2 		= $_POST["ADDRESS2"];
		$ADDR3 		= $_POST["ADDRESS3"];
		$mbrRefNo 	= $_POST["REF_NO"];
		$type 		= $_POST["type"]; // T1, SBT1, T2 ... 

		if ($type == 'T1'){$Test_Name = '스키 티칭1'; $Test_Table = '7G_T1_Schedules'; $Apply_Table = '7G_T1_Apply'; $Product_Name = 'SKI-Teaching1'; $REF_NO = "TA";}
		if ($type == 'T2'){$Test_Name = '스키 티칭2'; $Test_Table = '7G_T2_Schedules'; $Apply_Table = '7G_T2_Apply'; $Product_Name = 'SKI-Teaching2'; $REF_NO = "TB";}
		if ($type == 'T3'){$Test_Name = '스키 티칭3 & 기술선수권대회'; $Test_Table = '7G_T3_Schedules'; $Apply_Table = '7G_T3_Apply'; $Product_Name = 'SKI-Teaching3'; $REF_NO = "TC";}

		if ($type == 'SBT1'){$Test_Name = '스노보드 티칭1'; $Test_Table = '7G_SBT1_Schedules'; $Apply_Table = '7G_SBT1_Apply'; $Product_Name = 'SB-Teaching1'; $REF_NO = "SA";}
		if ($type == 'SBT2'){$Test_Name = '스노보드 티칭2'; $Test_Table = '7G_SBT2_Schedules'; $Apply_Table = '7G_SBT2_Apply';  $Product_Name = 'SB-Teaching2'; $REF_NO = "SB";}
		if ($type == 'SBT3'){$Test_Name = '스노보드 티칭3 & 기술선수권대회'; $Test_Table = '7G_SBT3_Schedules'; $Apply_Table = '7G_SBT3_Apply';  $Product_Name = 'SB-Teaching3'; $REF_NO = "SC";}

		if ($type == 'PATROL'){$Test_Name = '스키구조요원'; $Test_Table = '7G_Patrol_Schedules'; $Apply_Table = '7G_Patrol_Apply';  $Product_Name = 'PATROL'; $REF_NO = "P";}

		/* 가맹점 주문번호 (가맹점 고유ID 대체가능) 6byte~20byte*/
		// $mbrRefNo = makeMbrRefNo($mbrNo);

		$table = "7G_Master_Apply_TMP";

		/* 결제수단 */
		$paymethod = $_POST["PayMethod"];

		$amount = $_POST["Amt"];
		$goodsName = $_POST["GoodsName"];
		/* 상품코드 max 8byte*/
		$goodsCode = $_POST["goodsCode"]; // ??

		$customerName = $_POST["BuyerName"];
		$customerEmail = $_POST["BuyerEmail"];
		$TRAN_TIME = str_replace(":", "", date('h:i:s'));

		$rt1 = upload('file',$MEMBER_ID);

		if(is_array($rt1)){
			if(count($rt1['error'])){
				$errorMsg = implode('\n',$rt1['error']);
				echo "<script>
						alert('".$errorMsg."');
						parent.document.getElementById('fade').style.visibility = 'hidden';
						parent.document.getElementById('light').style.visibility = 'hidden';
					</script>";
				exit;
			}
			$sql_file = $rt1['success'][0]['name']."=>".$rt1['success'][1];
		}

		$rt2 = upload('image',$MEMBER_ID);
		if(is_array($rt2)) {
			if(count($rt2['error'])){
				$errorMsg = implode('\n',$rt2['error']);
				echo "<script>
						alert('".$errorMsg."');
						parent.document.getElementById('fade').style.display = 'none';
						parent.document.getElementById('light').style.display = 'none';
					</script>";
				exit;
			}
			$sql_image = $rt2['success'][0]['name']."=>".$rt2['success'][1];
		}
		
		$sql = "INSERT INTO  $table (
						REF_NO,				Apply_date,				TEST_ID,				TRAN_DATE,
						TRAN_TIME,		Test_No,				SKIRESORT_NO,		MEMBER_NO,
						MEMBER_ID,		MEMBER_NAME,		MEMBER_PHONE,		MEMBER_EMAIL,
						T_ZIPCODE,		T_ADDR1,				T_ADDR2,				T_ADDR3,
						APPROVAL_NO,	PRODUCT_CODE,		PRODUCT_NAME,		PAY_METHOD,
						AMOUNT,			TRAN_STATUS,		GENDER2,				VACCINE,
						PASS,					AID,						RELATED_FILE,		RELATED_IMAGE
					)
					VALUES	(
						'$mbrRefNo',		'$Apply_date',			'$type',					'$Apply_date',
						'$TRAN_TIME',	'$Test_No',				'$Skiresort_No',		'$MEMBER_NO',
						'$MEMBER_ID',	'$customerName',		'$BuyerTel',				'$customerEmail',
						'$ZONE_CODE',	'$ADDR1',				'$ADDR2',				'$ADDR3',
						'',						'$goodsCode',			'$goodsName',			'$paymethod',
						$amount,			1,							'$GENDER2',			$VACCINE,
						$PASS,				'$aid',						'$sql_file',				'$sql_image'
					)
		";
		
		//echo $sql;exit;

		$db_result=mysqli_query($link, $sql);
		if($db_result){
			
			

			echo "
				<script>
				parent.tranMgr.EncryptData.value = '$EncryptData';
				parent.payment();
				</script>
			";
			exit;
		}else{
			echo "
				<script>
					alert('결제오류\\n잠시 후 다시 시도해 주세요.');
				</script>
			";
			exit;
		}

	}
	// 자격증발급
	else if($mode=='payment'){

	$Mid = "know00001m";           // 발급받은 테스트 Mid 설정(Real 전환 시 운영 Mid 설정) , !!실값으로 변경필요!!
	$MerchantKey = "nd0So1DPQJEYbLTjyvSAZI8iXf71lL1Kx3klcJZXqmgnVLs3pcpW56D+BItbg2Sxm0vu5nIbP9ShJwqD/5nF4w==";   // 발급받은 테스트 상점키 설정(Real 전환 시 운영 상점키 설정) !!실값으로 변경필요!!
	
	//mainpay
    $Mid = "112452";                                              
    $MerchantKey = "U1FVQVJFLTExMjQ1MjIwMjMwMTAyMTYwMDA0MzAxNzA5";   

	$Amt = str_replace(',','',$goodsCode); // !!실값으로 변경필요!!

	$EncryptData = base64_encode(hash('sha256', $EdiDate.$Mid.$Amt.$MerchantKey, true));

	$table = "7G_License_Renew_TMP";

$sql = "INSERT INTO $table
		(	REF_NO,					TRAN_DATE,		TRAN_TIME,			MEMBER_NO, 
			MEMBER_ID, 			MEMBER_NAME, 	MEMBER_PHONE, 	MEMBER_EMAIL, 
			ZIPCODE, 				ADDR1,				ADDR2, 					ADDR3, 
			LICENSE_NO, 			APPROVAL_NO, 	PRODUCT_CODE, 	PRODUCT_NAME, 
			PAY_METHOD, 		AMOUNT,			PAYMENT_STATUS,	DELIVERY_DATE, 
			DELIVERY_AGENCY, TRACKING_NO, 	DELIVERY_FEE, 		MEMO1, 
			TRAN_STATUS, 		AID	) 
		VALUES 
		(	'$Moid', 			'$TRAN_DATE',	'$TRAN_TIME',		'$MEMBER_NO', 
			'$MEMBER_ID', 		'$BuyerName',		'$BuyerTel',				'$BuyerEmail',
			'$ZIP',					'$ADDRESS1',		'$ADDRESS2', 			'$ADDRESS3', 
			'$LICENSE', 			'',						'$goodsCode', 			'$GoodsName',
			'$PayMethod',			$Amt,				0,							NULL,
			'미발송',					'미발송',				0,							'',
			0,							'$aid'	)
		";

		echo $sql;

		$db_result=mysqli_query($link, $sql);
		if($db_result){
			echo "
				<script>
				parent.tranMgr.EncryptData.value = '$EncryptData';
				parent.goPay();
				</script>
			";
			exit;
		}else{
			echo "
				<script>
					alert('결제오류\\n잠시 후 다시 시도해 주세요.');
				</script>
			";
			exit;
		}
	}


function upload($upfile,$mb_id){
	if(isset($_FILES[$upfile]) && $_FILES[$upfile]['name'] != ""){
		$file = $_FILES[$upfile];
		$upload_directory = $_SERVER['DOCUMENT_ROOT'].'/mypage/member_imgs/'.$mb_id.'/';
		$ext_str = "hwp,xls,doc,xlsx,docx,pdf,jpg,jpeg,gif,png,txt,ppt,pptx";
		//$allowed_extensions = explode(',',$str_str);
		$allowed_extensions = explode(',',$ext_str);
		$max_file_size = 5242880;
		$ext = substr($file['name'], strrpos($file['name'], '.') + 1);
		// 확장자 체크
		if(!in_array($ext, $allowed_extensions)) {
			$errMsg[] =  "업로드할 수 없는 확장자 입니다.";
		}
		// 파일 크기 체크
		if($file['size'] >= $max_file_size) {
			$errMsg[] = "5MB 까지만 업로드 가능합니다.";
		}
		$path = md5(microtime()) . '.' . $ext;
		@mkdir($upload_directory,0707);
		@chmod($upload_directory.$path,0707);
		/*if(!move_uploaded_file($file['tmp_name'], $upload_directory.$path)) {
			$errMsg[] = "업로드 에러.";
		}*/
		// 에러가 없을 경우에 서버에 파일 업로드
		if(count($errMsg)) return array('error'=>$errMsg);
		else {
			if(!move_uploaded_file($file['tmp_name'], $upload_directory.$path)) {
				$errMsg[] = "업로드 에러.";
			}
			if(count($errMsg)) return array('error'=>$errMsg);
			else return array('success'=>array($file,$path));
			//else return array('success'=>array($file,$upload_directory.$path));
		}
	}
	return 0;
}

?>