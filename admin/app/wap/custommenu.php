<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
$depth='../';
require_once $depth.'../login/login_check.php';
require_once $depth.'../include/pager.class.php';
if($action){
    $sign=explode(",",$allid);
	if($action=='editor'){
		foreach($sign as $key=>$val){
			$vals='name_'.$val;
			$valsmun=$$vals;
			$valsmun = mb_convert_encoding($valsmun, "GBK","UTF-8");
			$valsmun=strlen($valsmun);
			$sequence='sequence_'.$val;
			$sequences=$$sequence;
			$name='name_'.$val;
			$names=$$name;
			if($valsmun>8){
				metsave('../app/wap/custommenu.php?anyid='.$anyid.'&cs='.$cs.'&lang='.$lang,'名称最多支持4个汉字字符（英文字符算半个汉字字符）',$depth);
			}
			$query = "UPDATE $gz_wapmenu SET sequence='$sequences', name='$names'  where id='$val'";
			$menus=$db->query($query);
		
		}
		metsave('../app/wap/custommenu.php?anyid='.$anyid.'&cs='.$cs.'&lang='.$lang,'操作成功',$depth);
	}
	if($action=='del'){
		foreach($sign as $key=>$val){
			$querys = "DELETE FROM $gz_wapmenu where id='$val'";
			$menus=$db->query($querys);	
		}	
		metsave('../app/wap/custommenu.php?anyid='.$anyid.'&cs='.$cs.'&lang='.$lang,'操作成功',$depth);
	}

}
$query = "SELECT * FROM $gz_wapmenu where lang='$lang' ORDER BY sequence asc";
$result = $db->query($query);
while($list = $db->fetch_array($result)) {
	$list_array2[]=$list;	
}
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
include template('app/wap/custommenu');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>