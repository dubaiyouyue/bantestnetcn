<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
$backurl="../content/job/index.php?anyid={$anyid}&lang=$lang&class1=$class1&customerid=$customerid";
if($gz_htmpagename==2)$folder=$db->get_one("select * from $gz_column where id='$class1'");
if($action=="del"){
	$allidlist=explode(',',$allid);
	foreach($allidlist as $key=>$val){
		if($gz_webhtm!=0 or $metadmin[pagename]){
			$job_list=$db->get_one("select * from $gz_news where id='$val'");
			if($gz_htmpagename==1)$updatetime=date('Ymd',strtotime($job_list[updatetime]));
			deletepage($folder[foldername],$val,'job',$updatetime,$job_list[filename]);
		}
		$query = "delete from $gz_job where id='$val'";
		$db->query($query);
	}
	$htmjs =indexhtm().'$|$';
	$htmjs.=classhtm($class1,0,0);
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	metsave($backurl,'',$depth,$htmjs,$gent);
}elseif($action=="editor"){
	$allidlist=explode(',',$allid);
	foreach($allidlist as $key=>$val){
		$no_order = "no_order_$val";
		$no_order = $$no_order;
		$query = "update $gz_job SET
			no_order   = '$no_order',
			lang       = '$lang'
			where id='$val'";
		$db->query($query);
	}
	$htmjs =indexhtm().'$|$';
	$htmjs.=classhtm($class1,0,0);
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	metsave($backurl,'',$depth,$htmjs,$gent);
}else{
	$job_list = $db->get_one("SELECT * FROM $gz_job WHERE id='$id'");
	if(!$job_list)metsave('-1',$lang_dataerror,$depth);
	if($gz_webhtm!=0 or $metadmin[pagename]){
		if($gz_htmpagename==1)$updatetime=date('Ymd',strtotime($job_list[updatetime]));
		deletepage($folder[foldername],$id,'shownews',$updatetime,$job_list[filename]);
	}
	$query = "delete from $gz_job where id='$id'";
	$db->query($query);
	$htmjs =indexhtm().'$|$';
	$htmjs.=classhtm($class1,0,0);
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	metsave($backurl,'',$depth,$htmjs,$gent);
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>
