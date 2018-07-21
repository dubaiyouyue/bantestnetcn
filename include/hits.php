<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once 'common.inc.php';
switch($type){
case 'product':
$gz_hits=$gz_product;
break;
case 'news':
$gz_hits=$gz_news;
break;
case 'download':
$gz_hits=$gz_download;
break;
case 'img':
$gz_hits=$gz_img;
break;
default :
$gz_hits='';
break;
}
$query="select * from $gz_hits where id='$id'";
$hits_list=$db->get_one($query);
$hits_list[hits]=$hits_list[hits]+1;
$query = "update $gz_hits SET hits='$hits_list[hits]' where id='$id'";
$db->query($query); 
$query="select * from $gz_hits where id='$id'";
$hits_list=$db->get_one($query);
$hits=$hits_list[hits];
if($metinfover=='v1'){
	echo $hits;
}else{
	echo " document.write({$hits}); ";
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>