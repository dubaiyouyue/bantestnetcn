<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
if($action=="modify"){
$gz_onlinenameok=$gz_onlinenameok2;
require_once $depth.'../include/config.php';
$rurl='../interface/online/online.php?anyid='.$anyid.'&lang='.$lang.'&cs='.$cs;
metsave($rurl,'',$depth);
}else{
$cs=2;
$listclass[$cs]='class="now"';
$gz_online_skinarray[]=array(1,$lang_onlineblue,1);
$gz_online_skinarray[]=array(1,$lang_onlinered,2);
$gz_online_skinarray[]=array(1,$lang_onlinepurple,3);
$gz_online_skinarray[]=array(1,$lang_onlinegreen,4);
$gz_online_skinarray[]=array(1,$lang_onlinegray,5);
$gz_online_skinarray[]=array(2,$lang_onlineblue,1);
$gz_online_skinarray[]=array(2,$lang_onlinered,2);
$gz_online_skinarray[]=array(2,$lang_onlinepurple,3);
$gz_online_skinarray[]=array(2,$lang_onlinegreen,4);
$gz_online_skinarray[]=array(2,$lang_onlinegray,5);
$gz_online_skinarray[]=array(3,$lang_onlineblue,1);
$gz_online_skinarray[]=array(3,$lang_onlinered,2);
$gz_online_skinarray[]=array(3,$lang_onlinepurple,3);
$gz_online_skinarray[]=array(3,$lang_onlinegreen,4);
$gz_online_skinarray[]=array(3,$lang_onlinegray,5);
$gz_online_skinarray[]=array(4,$lang_onlineblue,1);
$gz_online_skinarray[]=array(4,$lang_onlinered,2);
$gz_online_skinarray[]=array(4,$lang_onlinepurple,3);
$gz_online_skinarray[]=array(4,$lang_onlinegreen,4);
$gz_online_skinarray[]=array(4,$lang_onlinegray,5);
$jslist = "<script language = 'JavaScript'>\n";
$jslist .= "var onecount;\n";
$jslist .= "subcat = new Array();\n";
$i=0;
foreach($gz_online_skinarray as $key=>$val){
$jslist .= "subcat[".$i."] = new Array('".$val[0]."','".$val[1]."','".$val[2]."');\n";
if($val[0]==$gz_online_skin)$gz_online_skinarray1[]=$val;
$gz_online_count[$val[0]]=$val[0];
$i++;
}
$jslist .= "onecount=".$i.";\n";
$jslist .= "</script>";
$gz_online_type1[$gz_online_type]="checked='checked'";
$gz_online_skin1[$gz_online_skin]="selected='selected'";
$gz_online_color1[$gz_online_color]="selected='selected'";
$gz_qq_type1[$gz_qq_type]="checked='checked'";
$gz_msn_type1[$gz_msn_type]="checked='checked'";
$gz_taobao_type1[$gz_taobao_type]="checked='checked'";
$gz_alibaba_type1[$gz_alibaba_type]="checked='checked'";
$gz_skype_type1[$gz_skype_type]="checked='checked'";
if($gz_onlinenameok)$gz_onlinenameok1="checked='checked'";
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
include template('interface/online/set_online');footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>