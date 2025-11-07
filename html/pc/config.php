<?
    $version = "V001";	

    //TEST 결제
    $API_BASE = "https://test-api-std.mainpay.co.kr";
    $mbrNo = "100011";
    $apiKey = "U1FVQVJFLTEwMDAxMTIwMTgwNDA2MDkyNTMyMTA1MjM0";   


    //결제
    $API_BASE = "https://api-std.mainpay.co.kr";            
    $mbrNo = "112452";                                              
    $apiKey = "U1FVQVJFLTExMjQ1MjIwMjMwMTAyMTYwMDA0MzAxNzA5";            

    $mbrNo = "114415";                                              
    $apiKey = "7oqHUU5uiQ0JdnvRiglfaPDUu6VsBpXzlfBoibrIpvGe";            


 

    if($_SERVER["SERVER_NAME"] =="www.skiresort.or.kr" || $_SERVER["SERVER_NAME"] =="skiresort.or.kr"){
        $payServerDomain = "https://www.skiresort.or.kr";
  
    }
    else{
        $payServerDomain = "http://3.35.80.43";
    }
  

    

    
?>