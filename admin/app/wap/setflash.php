<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
$serch_sql=$gz_wap_ok?"and wap_ok='1'":'';
$query="select * from $gz_column where lang='$lang' {$serch_sql} and if_in='0' order by no_order";
$result= $db->query($query);
$mod1[0]=$mod[10000]=array(
			id=>10000,
			name=>"$lang_flashGlobal",
			url=>$gz_weburl."index.php?lang=".$lang,
			bigclass=>0
		);
$mod1[1]=$mod[10001]=array(
			id=>10001,
			name=>"$lang_flashHome",
			url=>$gz_weburl."index.php?lang=".$lang,
			bigclass=>0
		);
$i=2;
while($list = $db->fetch_array($result)){
	if(!isset($gz_flasharray[$list[id]][type]))$gz_flasharray[$list[id]]=$gz_flasharray[10000];
	$list['url']=linkrules($list);
	if($list[classtype]==1){
		$mod1[$i]=$list;
		$i++;
	}
	if($list[classtype]==2)$mod2[$list[bigclass]][]=$list;
	if($list[classtype]==3)$mod3[$list[bigclass]][]=$list;
	$mod[$list['id']]=$list;
}
if($action=="modify"){
	$gz_array=Array();
	$gz_flash_wap_yall=$wap_flash_10000_y;
	$gz_flash_wap_typeall=$wap_flash_10000_type;
	foreach($mod as $key=>$val){
		$gz_flash_all="gz_flash_".$val[id]."_all";
		$gz_flash_all=$$gz_flash_all;
		if($gz_flash_all==1){
			$gz_array[$val['id']]['wap_y']=$gz_flash_wap_yall;
			$gz_array[$val['id']]['wap_type']=$gz_flash_wap_typeall;
		}else{
			$gz_flash_wap_y="wap_flash_".$val[id]."_y";
			$gz_flash_wap_y=$$gz_flash_wap_y;
			$gz_flash_wap_type="wap_flash_".$val[id]."_type";
			$gz_flash_wap_type=$$gz_flash_wap_type;
			$gz_flash_wap_y=intval($gz_flash_wap_y)?$gz_flash_wap_y:$gz_flash_wap_yall;
			$gz_array[$val['id']]['wap_y']=intval($gz_flash_wap_y);
			$gz_array[$val['id']]['wap_type']=$gz_flash_wap_type;
		}
	}
	foreach($gz_flasharray as $key=>$val){
		if(!$gz_array[$key]){
			$query = "delete from $gz_config where flashid='$key' and lang='$lang'";
			$db->query($query);
		}
	}
	$gz_flasharray=$gz_array;
	foreach($gz_flasharray as $key=>$val){
		$name='flash_'.$key;
		$value="{$val[wap_type]}|{$val[wap_y]}";
		$configok = $db->get_one("SELECT * FROM $gz_config WHERE flashid ='$key' and lang='$lang'");
		if(!$configok){
			$query = "INSERT INTO $gz_config SET
					name              = '$name',
					mobile_value      = '$value',
					flashid           = '$key',
					lang              = '$lang'
					";
			$db->query($query);
		}elseif($configok['value']!=$value){
			$query = "update $gz_config SET mobile_value = '$value' where flashid ='$key' and lang='$lang'";
			$db->query($query);
		}
	}
	$rurl="../app/wap/setflash.php?anyid={$anyid}&lang={$lang}&cs={$cs}";
	metsave($rurl,'',$depth);
}else{
$motop[1]='now';
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
include template('app/wap/setflash');footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>