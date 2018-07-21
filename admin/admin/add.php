<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once '../login/login_check.php';
if($admin_list[admin_group]==3){
	$admin_groupx[0]='checked="checked"';
}
if($admin_list[langok]!='metinfo'){
	foreach($gz_langok as $key=>$val){
		$langoka=explode('-',$admin_list[langok]);
		for($i=0;$i<count($langoka);$i++){
			if($langoka[$i]==$val[mark])$gz_langoka[]=$val;
		}
	}
}else{
	$gz_langoka=$gz_langok;
}
$css_url="../templates/".$gz_skin."/css";
$img_url="../templates/".$gz_skin."/images";
$query="select * from $gz_app where download=1";
$app=$db->get_all($query);
include template('admin/admin_add');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>