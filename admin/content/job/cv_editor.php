<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
$depth='../';
require_once $depth.'../login/login_check.php';
require_once ROOTPATH.'public/php/searchhtml.inc.php';
$query = "update $gz_cv SET
					  readok  = '1'
					  where id='$id'";
$db->query($query);
$cv_list=$db->get_one("select * from $gz_cv where id='$id'");
if(!$cv_list)metsave('../content/job/cv.php?anyid='.$anyid.'&lang='.$lang,$lang_dataerror);
$query = "SELECT * FROM {$gz_parameter} where lang='$lang' and module=6  order by no_order";
$result = $db->query($query);
while($list= $db->fetch_array($result)){
	$value_list=$db->get_one("select * from $gz_plist where paraid=$list[id] and listid=$id ");
	if($list[type]==5){
		if($value_list[info]){  
			$src = $value_list[info];
			$value_list[info]="<a href='../../$value_list[info]'>$value_list[info]</a>";
		}
	}
	$list[content]=$value_list[info];
	if($list[type]==5 && $gz_cv_image == $value_list[paraid]){
		$jobzhaop='../../'.$src;
	}else{
		$cv_para[]=$list;
	}
}
$m_list = $db->get_one("SELECT * FROM $gz_column WHERE module='6' and lang='$lang'");
$class1 = $m_list['id'];
$listclass='';
$listclass[2]='class="now"';
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
include template('content/job/cv_editor');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>