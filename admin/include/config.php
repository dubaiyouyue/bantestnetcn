<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
if($depth!=''&&$depth!='../'&&$depth!='../../'){die();}
require_once $depth.'../login/login_check.php';
$columnid=$columnid?$columnid:0;
!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
$gz_adminfile=$gz_adminfile_code;
foreach($settings_arr as $key=>$val){
	if($val['columnid']==$columnid){
		$name = $val['name'];
		$newvalue1 = stripslashes($$val['name']);
		$newvalue1 = str_replace("'","''",$newvalue1);
		$newvalue = str_replace("\\","\\\\",$newvalue1);
		if($val['value']!=$newvalue1){
			$query1 = $columnid?"and columnid='$columnid'":'';
			$query = "update $gz_config SET value = '$newvalue' where id ='$val[id]' $query1";
			$db->query($query);
		}
	}
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>