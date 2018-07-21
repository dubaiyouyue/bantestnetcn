<?
require_once 'common.inc.php';
$query='';
$query = "select * from $gz_otherinfo where lang='gz_sms'";
$site=$db->get_one($query);
if($site['authpass']==$smsmd5){
//获得数据和号码
sendsms($phone,$message,1);
}
?>