<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
$depth='../';
require_once $depth.'../login/login_check.php';
require_once $depth.'../include/pager.class.php';

if($action=='modify'){
	if($gz_menu_rgb==5){
		if($menu_textbg_metinfo!=null){
		$gz_menu_rgb=$menu_textbg_metinfo;
	}else{
		$gz_menu_rgb='#014C8D';
		}
	}
	if($gz_menu_rgb==6){
		$gz_menu_rgb=$gz_menu_bg;
	}
	if(!$gz_menu_textbg){
		$gz_menu_textbg='#ffffff';
	}
    $querys = "UPDATE $gz_config SET `value`='$gz_menu_ok' where name='gz_menu_ok' and lang='$lang'";
	$db->query($querys);
	$querys = "UPDATE $gz_config SET `value`='$gz_menu_oks' where name='gz_menu_oks' and lang='$lang'";
	$db->query($querys);
	$querys = "UPDATE $gz_config SET `value`='$gz_menu_rgb' where name='gz_menu_rgb' and lang='$lang'";
	$db->query($querys);
	$querys = "UPDATE $gz_config SET `value`='$gz_menu_bg' where name='gz_menu_bg' and lang='$lang'";
	$db->query($querys);
	$querys = "UPDATE $gz_config SET `value`='$gz_menu_textbg' where name='gz_menu_textbg' and lang='$lang'";
	$db->query($querys);
metsave('../app/wap/menu_set.php?anyid='.$anyid.'&cs='.$cs.'&lang='.$lang,'操作成功',$depth);
}

$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
include template('app/wap/menu_set');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>