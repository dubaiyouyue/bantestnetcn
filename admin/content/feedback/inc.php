<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.  
$depth='../';
require_once $depth.'../login/login_check.php';
require_once ROOTPATH.'public/php/searchhtml.inc.php';
$fnam=$db->get_one("SELECT * FROM $gz_column WHERE id='$class1' and lang='$lang'");
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
	$htmjs = onepagehtm($foldename,'index',1,$htmpack,$fnam['filename'],$class1);
	metsave('../content/feedback/inc.php?lang='.$lang.'&class1='.$class1.'&anyid='.$anyid.'&classall='.$classall,'',$depth,$htmjs );
}else{
	foreach($settings_arr as $key=>$val){
		if($val['columnid']==$fnam['id'])$$val['name']=$val['value'];
	}
	$query = "SELECT * FROM $gz_parameter where module=8 and lang='$lang' and class1='$class1' order by no_order";
	$result = $db->query($query);
	while($list= $db->fetch_array($result)){
	$fd_para[$list[type]][]=$list;
	if($list[type]==2||$list[type]==6)$fd_paraall[]=$list;
	}
	$cs=isset($cs)?$cs:1;
	$listclass[$cs]='class="now"';
	
	$gz_fd_ok1[$gz_fd_ok]="checked='checked'";
	$gz_fd_type1[$gz_fd_type]="checked='checked'";
	$gz_fd_back1=($gz_fd_back)?"checked='checked'":"";
	$gz_fd_sms_back1=($gz_fd_sms_back)?"checked='checked'":"";
	$css_url=$depth."../templates/".$gz_skin."/css";
	$img_url=$depth."../templates/".$gz_skin."/images";
	include template('content/feedback/fd_inc');
	footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>