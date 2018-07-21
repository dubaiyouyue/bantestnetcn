<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
$depth='../';
require_once $depth.'../login/login_check.php';
$flashrec1=$db->get_one("SELECT * FROM {$gz_flash} where id='$id'");
$mtype=$gz_flasharray[$module][type];
$flashmdtype=$flashrec1['img_path']!=''?1:2;
$mtype=$flashmdtype==2?2:1;
$flashmdtype1[$flashmdtype]='selected';
$query="select * from $gz_column where lang='$lang' and (if_in='0' or module>1000 )order by no_order";
$result= $db->query($query);
while($list = $db->fetch_array($result)){
	if(!$gz_flasharray[$list[id]]){
		$gz_flasharray[$list[id]]=$gz_flasharray[10000];
		$name='flash_'.$list[id];
		$value=$gz_flasharray[10000]['type'].'|'.$gz_flasharray[10000]['x'].'|'.$gz_flasharray[10000]['y'].'|'.$gz_flasharray[10000]['imgtype'];
		$query = "INSERT INTO $gz_config SET
				name              = '$name',
				value             = '$value',
				flashid           = '$list[id]',
				lang              = '$lang'
				";
		$db->query($query);
	}
}
if($flashrec1['module']=='metinfo'){
	$gz_clumid_all1='checked';
}else{
	$lmod = explode(',',$flashrec1['module']);
	for($i=0;$i<count($lmod);$i++){
		if($lmod[$i]!='')$feditlist[$lmod[$i]]=1;
	}
}
foreach($gz_flasharray as $key=>$val){
	if($val['type']==$flashmdtype || ($flashmdtype==1 && $val['type']==3)){
		if($key==10001){
			$modclumlist[]=array('id'=>10001,'name'=>$lang_indexhome);
		}else{
			$modclumlist[]=$gz_class[$key];
		}
	}
}
$i=1;
foreach($modclumlist as $key=>$list){
	if($list[classtype]==1 || $list['id']==10001){
		$mod1[$i]=$list;
		$i++;
	}
	if($list[classtype]==2)$mod2[$list[bigclass]][]=$list;
	if($list[classtype]==3)$mod3[$list[bigclass]][]=$list;
	$mod[$list['id']]=$list;
}
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
$listclass='';
$listclass[2]="class='now'";
include template('interface/flash/flashedit');
footer();

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>