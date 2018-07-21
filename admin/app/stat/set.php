<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
/*初始变量*/
$dtime=statime("Y-m-d");
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
if($action=='modify'){
	if($gz_stat_cr1)delet_estat_cr(1,$gz_stat_cr1);
	if($gz_stat_cr2)delet_estat_cr(2,$gz_stat_cr2);
	if($gz_stat_cr3)delet_estat_cr(3,$gz_stat_cr3);
	if($gz_stat_cr4)delet_estat_cr(4,$gz_stat_cr4);
	if($gz_stat_cr5)delet_estat_cr(5,$gz_stat_cr5);
	if($gz_stat_max<0)$gz_stat_max=10000;
	require_once $depth.'../include/config.php';
	metsave('../app/stat/set.php?lang='.$lang.'&anyid='.$anyid,'',$depth);
}elseif($action=='empty'){
	delet_estat_cr(1,1);
	delet_estat_cr(2,1);
	delet_estat_cr(3,1);
	delet_estat_cr(4,1);
	delet_estat_cr(5,1);
	metsave('../app/stat/set.php?lang='.$lang.'&anyid='.$anyid,'',$depth);
}else{
	$stat[$gz_stat]='checked';
	$stat_clear[$gz_stat_clear]='checked';
	$stat_cr1[$gz_stat_cr1]='selected';
	$stat_cr2[$gz_stat_cr2]='selected';
	$stat_cr3[$gz_stat_cr3]='selected';
	$stat_cr4[$gz_stat_cr4]='selected';
	$stat_cr5[$gz_stat_cr5]='selected';
	include template('app/stat/set');footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>