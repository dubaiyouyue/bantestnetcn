<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
/*if($pcok){
	if(strlen($pcok)>3){
		header("location:404.html");die;
	}
}
if($gz_mobileok){
	$pattern='/^[1-9]?\d$/';
	if(!preg_match($pattern,$gz_mobileok)){
		header("location:404.html");die;
	}
}*/
if($uid!=null){
	$pattern='/^[1-9]?\d$/';
	if(preg_match($pattern,$uid)){
		$query = "SELECT * FROM $gz_wapmenu where lang='$lang' and id=$uid";
		$result = $db->query($query);
		while($list = $db->fetch_array($result)) {
			$list_array2[]=$list;
			$is=$list;
		}
		if(!$is||$is[type]!=3){
			header("location:404.html");die();
		}
	}else{
		header("location:404.html");die();
	}	
	
	foreach($list_array2 as $key=>$val){
		if($val[type]==3){
			$mapcan=explode("[!]",$val['value']);
			$gz_maplng=$mapcan[1];
			$gz_maplat=$mapcan[2];
			$gz_mapzoom=$mapcan[3];
			$gz_maptitle=$mapcan[4];
			$gz_mapcontents=$mapcan[5];
		}
	}
}else if($map==1&&!$uid){
	header("location:404.html");die();
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>