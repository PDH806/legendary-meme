<?php
if($_REQUEST['TID']){
 if($ResultCode=='3001' || $ResultCode=='4000'){
?>

document.frm1.target='';
document.frm1.amount.value='<?php echo $Amt?>';
document.frm1.OID.value='<?php echo $OID?>';
document.frm1.TID.value='<?php echo $TID?>';
document.frm1.GoodsName.value='<?php echo $GoodsName?>';
document.frm1.BankCode.value='<?php echo $BankCode?>';
document.frm1.BankName.value='<?php echo $BankName?>';
document.frm1.VbankExpDate.value='<?php echo $VbankExpDate?>';
document.frm1.AuthDate.value='<?php echo $AuthDate?>';
document.frm1.submit();

<?php }else{ ?>
history.back();

<?php 
 }
 exit;
}
?>