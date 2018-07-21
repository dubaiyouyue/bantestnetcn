<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
$cs=isset($cs)?$cs:1;
$listclass[$cs]='class="now"';
$query="select * from $gz_column where lang='$lang' and (if_in='0' or module>1000) order by no_order";
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
	$gz_flash_typeall=$gz_flash_10000_type;
	$gz_flash_xall=$gz_flash_10000_x;
	$gz_flash_yall=$gz_flash_10000_y;
	$gz_flash_imgtypeall=$gz_flash_10000_imgtype;
	foreach($mod as $key=>$val){
		$gz_flash_all="gz_flash_".$val[id]."_all";
		$gz_flash_all=$$gz_flash_all;
		if($gz_flash_all==1){
			$gz_array[$val['id']]['type']=$gz_flash_typeall;
			$gz_array[$val['id']]['x']=intval($gz_flash_xall);
			$gz_array[$val['id']]['y']=intval($gz_flash_yall);
			$gz_array[$val['id']]['imgtype']=$gz_flash_imgtypeall;
			$query = "update $gz_flash SET
					width	= '$gz_flash_xall',
					height	= '$gz_flash_yall'
					where module='$val[id]'";
			$db->query($query);
		}else{
			$gz_flash_type="gz_flash_".$val[id]."_type";
			$gz_flash_type=$$gz_flash_type;
			$gz_flash_x="gz_flash_".$val[id]."_x";
			$gz_flash_x=$$gz_flash_x;
			$gz_flash_y="gz_flash_".$val[id]."_y";
			$gz_flash_y=$$gz_flash_y;
			$gz_flash_imgtype="gz_flash_".$val[id]."_imgtype";
			$gz_flash_imgtype=$$gz_flash_imgtype;
			$gz_flash_x=intval($gz_flash_x)?$gz_flash_x:$gz_flash_xall;
			$gz_flash_y=intval($gz_flash_y)?$gz_flash_y:$gz_flash_yall;
			$gz_array[$val['id']]['type']=$gz_flash_type;
			$gz_array[$val['id']]['x']=intval($gz_flash_x);
			$gz_array[$val['id']]['y']=intval($gz_flash_y);
			$gz_array[$val['id']]['imgtype']=$gz_flash_imgtype;
			$query = "update $gz_flash SET
					width	= '$gz_flash_x',
					height	= '$gz_flash_y'
					where module='$val[id]'";
			$db->query($query);
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
		$val['imgtype'] = $val['imgtype'] ? $val['imgtype'] : 1;
		$value=$val['type'].'|'.$val['x'].'|'.$val['y'].'|'.$val['imgtype'];
		$configok = $db->get_one("SELECT * FROM $gz_config WHERE flashid ='$key' and lang='$lang'");
		if(!$configok){
			$query = "INSERT INTO $gz_config SET
					name              = '$name',
					value             = '$value',
					flashid           = '$key',
					lang              = '$lang'
					";
			$db->query($query);
		}elseif($configok['value']!=$value){
			$query = "update $gz_config SET value = '$value' where flashid ='$key' and lang='$lang'";
			$db->query($query);
		}
	}
	$rurl='../interface/flash/setflash.php?anyid='.$anyid.'&lang='.$lang."&kuaijieskin={$kuaijieskin}";
	metsave($rurl,'',$depth);
}else{
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
if(file_exists("../../../templates/{$gz_skin_user}/metinfo.inc.php")){
	require_once "../../../templates/{$gz_skin_user}/metinfo.inc.php";
}
if($metinfover == 'v1'){
	$v1dispaly = "style='display:none'";
}
include template('interface/flash/setflash');footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>