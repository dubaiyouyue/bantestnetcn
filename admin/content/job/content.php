<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
$depth='../';
require_once $depth.'../login/login_check.php';
require_once $depth.'global.func.php';
require_once ROOTPATH.'public/php/searchhtml.inc.php';
$settingse = parse_ini_file($depth.'../../config/job_'.$lang.'.inc.php');
@extract($settingse);
$job_list=$db->get_one("select * from $gz_job where id='$id'");
$job_list['position']=str_replace('"', '&#34;', str_replace("'", '&#39;',$job_list['position']));
$job_list1=$db->get_one("SELECT * FROM $gz_column where id=$class1 order by no_order");
if($gz_member_use){
	$lev=$job_list1[access];
}
if($job_list[top_ok]==1)$top_ok="checked";
if($job_list[wap_ok]==1)$wap_ok="checked";
if($job_list[displaytype]==1){
		$displaytypes[0]='checked';
		$displaytypes[1]="";
	}else{
		$displaytypes[0]="";
		$displaytypes[1]='checked';
	}
$list_access['access']=$job_list['access'];
require '../access.php';
$term=0;
foreach($column_lang[6] as $key=>$val){
    if($val[lang]!=$lang)$term++;
}
if($action=="add"){
$displaytypes[0]='checked';
$displaytypes[1]='';
$lang_editinfo=$lang_addinfo;
$job_list[addtime]=$m_now_counter;
$job_list[no_order]=0;
}
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
include template('content/job/content');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>