<?
    require('config.php');                                            
    
    $mbrRefNo = makeMbrRefNo($mbrNo);                                   
    $amount = "1004";                                       
    $timestamp = makeTimestamp();                                                
    $signature = makeSignature($mbrNo,$mbrRefNo,$amount,$apiKey,
                 $timestamp);     
        
    $parameters = array(
        'mbrNo' => $mbrNo,    
    );
    
    $apiUrl = $API_BASE."/호출할 API URL";                    
    
    $result = "";
    pintLog("PAY-API: ".$apiUrl, $logPath);
    pintLog("PARAM: ".print_r($parameters, TRUE), $logPath);
    $result = httpPost($apiUrl, $parameters);
    $obj = json_decode($result);                
    $resultCode = $obj->{'resultCode'};
    $resultMessage = $obj->{'resultMessage'};
 
    if($resultCode != "200"){   // API 호출 실패    
        echo $result;
        return;
    }
    $data = $obj->{'data'};
    echo("<br>## API 호출 결과 ##<br>" .$result);
    pintLog("RESPONSE: ".$result, $logPath);
    
?>