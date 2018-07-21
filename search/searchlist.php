<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
	$htmname=($list[filename]<>"" and $metadmin[pagename])?$filename."/".$list[filename]:$filename."/".$filenamenow.$list[id];
	$phpname=$filename."/show".$pagename.".php?id=".$list[id];	
	$pseudoname=($list[filename]<>"" and $metadmin[pagename])?$filename."/".$list[filename]:$filename."/".$list[id];
	$list[url]=$gz_pseudo?$pseudoname.'-'.$lang.$gz_htmtype:($gz_webhtm?$htmname.$gz_htmtype:$phpname."&lang=".$lang);
	$list[url]=$list['links']?$list['links']:$list[url];
if($gz_member_use==2){
 if(intval($metinfo_member_type)>=intval($nowaccess))$search_list[]=$list;
}else{
$search_list[]=$list;	
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>