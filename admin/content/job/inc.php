<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.  
$depth='../';
require_once $depth.'../login/login_check.php';
require_once ROOTPATH.'public/php/searchhtml.inc.php';
$backurl="../content/job/inc.php?anyid={$anyid}&lang=$lang";
if($action=="modify"){
	require_once $depth.'../include/config.php';
	$htmjs=onepagehtm('job','cv',1);
	metsave($backurl,'',$depth,$htmjs);
}else{
	$query = "SELECT * FROM $gz_parameter where module=6 and lang='$lang' order by no_order";
	$result = $db->query($query);
	while($list= $db->fetch_array($result)){
		$cv_para[$list[type]][]=$list;
	}
	$gz_cv_type1[$gz_cv_type]="checked";
	$gz_cv_emtype1[$gz_cv_emtype]="checked";
	$gz_cv_back1=($gz_cv_back)?"checked":"";
	$m_list = $db->get_one("SELECT * FROM $gz_column WHERE module='6' and lang='$lang'");
	$class1 = $m_list['id'];
	$listclass='';
	$listclass[4]='class="now"';
	$css_url=$depth."../templates/".$gz_skin."/css";
	$img_url=$depth."../templates/".$gz_skin."/images";
	include template('content/job/inc');
	footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>