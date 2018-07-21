<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
require_once ROOTPATH.'public/php/searchhtml.inc.php';
$fnam=$db->get_one("SELECT * FROM $gz_column WHERE id='$class1' and lang='$lang'");
$query = "select * from $gz_parameter where lang='$lang' and module='7' and type='1'";
$menus=$db->query($query);
while($list = $db->fetch_array($menus)) {
	$fd_paraall[]=$list;
}
$query = "select * from $gz_parameter where lang='$lang' and module='7' and type='3'";
$menus=$db->query($query);
while($list = $db->fetch_array($menus)) {
	$fd_paraalls[]=$list;
}
if($action=="modify"){
	$columnid=$fnam['id'];
	if($gz_fd_ok){
		$query = "update $gz_column SET display = '0' where id ='$columnid' ";
		$db->query($query);
	}else{
		$query = "update $gz_column SET display = '1' where id ='$columnid' ";
		$db->query($query);
	}
	require_once $depth.'../include/config.php';
	$htmjs = onepagehtm('message','message').'$|$';
	$htmjs.= classhtm($class1,0,0);
	metsave('../content/message/inc.php?lang='.$lang.'&class1='.$class1.'&anyid='.$anyid,'',$depth,$htmjs);
}else{
	foreach($settings_arr as $key=>$val){
		if($val['columnid']==$fnam['id'])$$val['name']=$val['value'];
	}
	$gz_fd_ok1[$gz_fd_ok]="checked='checked'";
	$gz_fd_email1=($gz_fd_email)?"checked":"";
	$gz_fd_back1=($gz_fd_back)?"checked":"";
	$gz_fd_type1=($gz_fd_type)?"checked":"";
	$gz_fd_sms_back1=($gz_fd_sms_back)?"checked":"";
	$gz_sms_back1=($gz_sms_back)?"checked='checked'":"";
	$m_list = $db->get_one("SELECT * FROM $gz_column WHERE module='7' and lang='$lang'");
	$class1 = $m_list['id'];
	$listclass='';
	$listclass[3]='class="now"';
	$css_url=$depth."../templates/".$gz_skin."/css";
	$img_url=$depth."../templates/".$gz_skin."/images";
	include template('content/message/inc');
	footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>