<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once '../login/login_check.php';
$adminfile=$url_array[count($url_array)-2];
if($action=="delete"){
	$filename=$filename=='update'?$filename:'install';
	if($filename=='update')@chmod('../../update/install.lock',0777);
	function deldirs($dir){
	  $dh=opendir($dir);
	  while ($file=readdir($dh)) {
		if($file!="." && $file!="..") {
		  $fullpath=$dir."/".$file;
		  if(!is_dir($fullpath)) {
			  unlink($fullpath);
		  } else {
			  deldir($fullpath);
		  }
		}
	}

	  closedir($dh);
	  if($dir!='../../upload'){
		if(rmdir($dir)) {
		return true;
		} else {
		return false;
		}
		}
	} 
	$dir='../../'.$filename;
	deldirs($dir);
	metsave('../system/safe.php?anyid='.$anyid.'&lang='.$lang);
}
if($action=="modify"){
	if($gz_adminfile!=""&&$gz_adminfile!=$adminfile){
		$gz_adminfile_temp=$gz_adminfile;
		$newname='../../'.$gz_adminfile;
		$gz_adminfile_code=authcode($gz_adminfile,'ENCODE', $gz_webkeys);
		require_once $depth.'../include/config.php';
		if(rename("../../{$adminfile}","../../{$gz_adminfile_temp}")){
			echo "<script type='text/javascript'> alert('{$lang_authTip11}'); document.write('{$lang_authTip12}'); top.location.href='{$newname}'; </script>";
			die();
		}else{
			echo "<script type='text/javascript'> alert('{$lang_adminwenjian}'); top.location.reload(); </script>";
			die();
		}
	}else{
		require_once $depth.'../include/config.php';
		metsave('../system/safe.php?anyid='.$anyid.'&lang='.$lang);
	}
}else{
$localurl="http://";
$localurl.=$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"];
$localurl_a=explode("/",$localurl);
$localurl_count=count($localurl_a);
$localurl_admin=$localurl_a[$localurl_count-3];
$localurl_admin=$localurl_admin."/system/safe";
$localurl_real=explode($localurl_admin,$localurl);
$localurl=$localurl_real[0];
if(!is_dir('../../install'))$installstyle="display:none;";
if(!is_dir('../../update'))$updatestyle="display:none;";
$gz_login_code1[$gz_login_code]="checked='checked'";
$gz_memberlogin_code1[$gz_memberlogin_code]="checked='checked'";
$gz_automatic_upgrade1[$gz_automatic_upgrade]="checked";
if($gz_img_rename==1)$gz_img_rename1="checked='checked'";

$css_url="../templates/".$gz_skin."/css";
$img_url="../templates/".$gz_skin."/images";
include template('system/set_safe');
footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>