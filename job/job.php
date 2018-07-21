<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once '../include/common.inc.php';
$classaccess= $db->get_one("SELECT * FROM $gz_column WHERE module='6' and lang='$lang'");
$metaccess=$classaccess[access];
$class1=$classaccess[id];

require_once '../include/head.php';
	$guanlian=$class_list[$class1][releclass];
	$class1_info=$class_list[$class1][releclass]?$class_list[$class_list[$class1][releclass]]:$class_list[$class1];
	$class2_info=$class_list[$class1][releclass]?$class_list[$class1]:$class_list[$class2];
	if(!class1_info){
	okinfo('../',$lang_error);
	}
    $serch_sql=" where lang='$lang' {$mobilesql} and displaytype='1' and ((TO_DAYS(NOW())-TO_DAYS(`addtime`)< useful_life) OR useful_life=0) ";
	if($gz_member_use==2)$serch_sql .= " and access<=$metinfo_member_type";
	$order_sql="order by no_order desc,addtime desc";
    $total_count = $db->counter($gz_job, "$serch_sql", "*");
	$totaltop_count = $db->counter($gz_job, "$serch_sql and top_ok='1'", "*");
    require_once '../include/pager.class.php';
    $page = (int)$page;
	if($page_input){$page=$page_input;}
    $list_num=$gz_job_list;
    $rowset = new Pager($total_count,$list_num,$page);
    $from_record = $rowset->_offset();
	$page = $page?$page:1;
	 $query = "SELECT * FROM $gz_job $serch_sql and top_ok='1' and displaytype='1' $order_sql LIMIT $from_record, $list_num";
	 $result = $db->query($query);
	 while($list= $db->fetch_array($result)){
	 $job_listnow[]=$list;
	 }
	if(count($job_listnow)<intval($list_num)){
	 if($totaltop_count>=$list_num){
	  $from_record=$from_record-$totaltop_count;
	  if($from_record<0)$from_record=0;
	 }else{
	 $from_record=$from_record?($from_record-$totaltop_count):$from_record;
	 }
	 $list_num=intval($list_num)-count($job_listnow);
	 $query = "SELECT * FROM $gz_job $serch_sql and top_ok='0' and displaytype='1' $order_sql LIMIT $from_record, $list_num";
	 $result = $db->query($query);
	 while($list= $db->fetch_array($result)){
	 $job_listnow[]=$list;
	 }
	}
	foreach($job_listnow as $key=>$list){
	if(intval($list[useful_life])==0)$list[useful_life]=$lang_Nolimit;
	$list[top]=$list[top_ok]?"<img class='listtop' src='".$img_url."top.gif"."' />":"";
	$list[news]=$list[top_ok]?"":((((strtotime($m_now_date)-strtotime($list[addtime]))/86400)<$gz_newsdays)?"<img class='listnews' src='".$img_url."news.gif"."' />":"");
	$pagename1=$list['addtime'];
	$list[addtime] = date($gz_listtime,strtotime($list[addtime]));
	if($gz_webhtm){
	switch($gz_htmpagename){
    case 0:
	$htmname="showjob".$list[id];	
	break;
	case 1:
	$list[updatetime1] = date('Ymd',strtotime($pagename1));
	$htmname=$list[updatetime1].$list[id];	
	break;
	case 2:
	$htmname="job".$list[id];	
	break;
	}
   $htmname=($list[filename]<>"" and $metadmin[pagename])?$list[filename]:$htmname;
   }	
	$phpname="showjob.php?".$langmark."&id=".$list[id];
	$panyid = $list['filename']!=''?$list['filename']:$list['id'];
	$list[url]=$gz_pseudo?$panyid.'-'.$lang.'.html':($gz_webhtm?$htmname.$gz_htmtype:$phpname);
	$list[cv]=$gz_pseudo?'jobcv-'.$panyid.'-'.$lang.'.html':$cv['url'].$list['id'];
	$job_list[]=$list;
}
if($gz_webhtm==2){
	$gz_pagelist=(($metadmin[pagename] and $class_list[$class1][filename]<>"")?$class_list[$class1][filename]:"job")."_".$class1."_";
	$gz_pagelist=$class_list[$class1]['filename']<>''?$class_list[$class1]['filename'].'_':$gz_pagelist;
	$gz_ahtmtype = $class_list[$class1]['filename']<>''?$gz_chtmtype:$gz_htmtype;
	$page_list = $rowset->link($gz_pagelist,$gz_ahtmtype);
}else{			
	$pagemor = ($metadmin['pagename'] and $class_list[$class1]['filename']<>"")?'list-'.$class_list[$class1]['filename'].'-':'list-'.$class1.'-';
	$hz = '-'.$lang.'.html';
	$page_list = $gz_pseudo?$rowset->link($pagemor,$hz):$rowset->link("job.php?lang=$lang&page=");		
}

$class2=$class_list[$class1][releclass]?$class1:$class2;
$class1=$class_list[$class1][releclass]?$class_list[$class1][releclass]:$class1;
$class_info=$class2?$class2_info:$class1_info;
if($class2!=""){
$class_info[name]=$class2_info[name]."-".$class1_info[name];
}

     $show[description]=$class_info[description]?$class_info[description]:$gz_description;
     $show[keywords]=$class_info[keywords]?$class_info[keywords]:$gz_keywords;
	 $gz_title=$gz_title?$class_info['name'].'-'.$gz_title:$class_info['name'];
	 if($class_info['ctitle']!='')$gz_title=$class_info['ctitle'];
	 if($page>1)$gz_title.='-'.$lang_Pagenum1.$page.$lang_Pagenum2;
if(!$guanlian){
	if(count($nav_list2[$class1])){
	$k=count($nav_list2[$class1]);
	$nav_list2[$class1][$k]=array('id'=>10004,'url'=>$cv[url],'name'=>$lang_cvtitle);
	}else{
	$nav_list2[$class1][0]=$class1_info;
	$nav_list2[$class1][1]=array('id'=>10004,'url'=>$cv[url],'name'=>$lang_cvtitle);
	}
}
$csnow=$cvidnow?$cvidnow:$classnow;
$pageall=$rowset->pages;
require_once '../public/php/methtml.inc.php';
require_once '../public/php/jobhtml.inc.php';
include template('job');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>