<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
$backurl ="../content/article/index.php?anyid={$anyid}&lang=$lang&class1=$class1";
$backurl.=$cengci==1?'':($cengci==2?'&class2='.$class2:'&class2='.$class2.'&class3='.$class3);
if($gz_htmpagename==2)$folder=$db->get_one("select * from $gz_column where id='$class1'");
if($action=="del"){
	$allidlist=explode(',',$allid);	
	foreach($allidlist as $key=>$val){
		if($gz_webhtm!=0 or $metadmin[pagename]){
			$news_list=$db->get_one("select * from $gz_news where id='$val'");
			if($gz_htmpagename==1)$updatetime=date('Ymd',strtotime($news_list[updatetime]));
			deletepage($folder[foldername],$val,'shownews',$updatetime,$news_list[filename]);
			$declass[$news_list['class2']][$news_list['class3']]=1;
		}
		$query = $gz_recycle?"update {$gz_news} set recycle='2',updatetime='".date('Y-m-d H:i:s')."' where id='$val'":"delete from {$gz_news} where id='$val'";
		$db->query($query);
		if(!$gz_recycle){if($news_list){delimg($news_list,1,2);}else{delimg($val,3,2);}}
	}
	$htmjs = indexhtm().'$|$';
	if($gz_webhtm==2 or $metadmin[pagename]){
		$htmjs.= classhtm($class1,0,0,0,1,0).'$|$';
		foreach($declass as $key1=>$val1){
			$htmjs.= classhtm($class1,$key1,0,0,2,0).'$|$';
			foreach($val1 as $key2=>$val2){
				$htmjs.= classhtm($class1,$key1,$key2,0,3,0);
			}
		}
	}
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	if($gz_webhtm==2){
		metsave($backurl,'',$depth,$htmjs,$gent);
	}else{
		metsave($backurl,'',$depth,'',$gent);
	}
}elseif($action=="editor"){
	$allidlist=explode(',',$allid);
	foreach($allidlist as $key=>$val){
		$no_order = "no_order_$val";
		$no_order = $$no_order;
		$query = "update $gz_news SET
			no_order       	 = '$no_order',
			lang               = '$lang'
			where id='$val'";
		$db->query($query);
	}
	$htmjs =indexhtm().'$|$';
	$htmjs.=classhtm($class1,$class2,$class3);
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	metsave($backurl,'',$depth,$htmjs,$gent);
}else{
	$news_list = $db->get_one("SELECT * FROM $gz_news WHERE id='$id'");
	if(!$news_list)metsave('-1',$lang_dataerror,$depth);
	if($gz_webhtm!=0 or $metadmin[pagename]){
		if($gz_htmpagename==1)$updatetime=date('Ymd',strtotime($news_list[updatetime]));
		deletepage($folder[foldername],$id,'shownews',$updatetime,$news_list[filename]);
	}
	$query = $gz_recycle?"update $gz_news set recycle='2',updatetime='".date('Y-m-d H:i:s')."' where id='$id'":"delete from $gz_news where id='$id'";
	$db->query($query);
	if(!$gz_recycle){if($news_list){delimg($news_list,1,2);}else{delimg($id,3,2);}}
	$htmjs =indexhtm().'$|$';
	$class1=$news_list['class1'];
	$class2=$news_list['class2'];
	$class3=$news_list['class3'];
	$htmjs.=classhtm($class1,$class2,$class3);
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	metsave($backurl,'',$depth,$htmjs,$gent);
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>
