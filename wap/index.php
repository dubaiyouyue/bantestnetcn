<?php 
$index="wap";
require_once '../include/common.inc.php';
if(!$gz_wap)okinfo('../index.php?lang='.$lang,$lang_metwapok);
require_once 'wap.php';
if(!$gz_wap_logo)$gz_wap_logo=$gz_logo;
if(!$wap_description)$wap_description=$gz_description;
include waptemplate($temp);
wapfooter();
?> 