<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once '../include/common.inc.php';
$fmodule=7;
if($list==1){
require_once '../include/module.php';
$metid='';
}
if(!$metid)$metid='index';
if($metid!='index'){
require_once 'message.php';
}else{
$message_column=$db->get_one("select * from $gz_column where module='7' and lang='$lang'");
$metaccess=$message_column[access];
$class1=$message_column[id];
foreach($settings_arr as $key=>$val){
	if($val['columnid']==$class1){
		$tingname    =$val['name'].'_'.$val['columnid'];
		$$val['name']=$$tingname;
	}
}
require_once '../include/head.php';
	$class1_info=$class_list[$class1][releclass]?$class_list[$class_list[$class1][releclass]]:$class_list[$class1];
	$class2_info=$class_list[$class1][releclass]?$class_list[$class1]:$class_list[$class2];
	$navtitle=$message_column[name];
    $serch_sql=" where lang='$lang' ";
	if($gz_fd_type==1) $serch_sql.=" and readok='1' ";
	if($gz_member_use==2)$serch_sql .= " and access<='$metinfo_member_type'";
	$order_sql=" order by id desc ";
    $total_count = $db->counter($gz_message, "$serch_sql", "*");
    require_once '../include/pager.class.php';
    $page = (int)$page;
	if($page_input){$page=$page_input;}
    $list_num = $gz_message_list;
    $rowset = new Pager($total_count,$list_num,$page);
    $from_record = $rowset->_offset();
	$page = $page?$page:1;
    $query = "SELECT * FROM $gz_message $serch_sql $order_sql LIMIT $from_record, $list_num";
    $result = $db->query($query);
	while($list= $db->fetch_array($result)){
	if($gz_member_use){
	if(intval($list[access])>0){ 
	$list[info]="<script language='javascript' src='access.php?metaccess=".$list[access]."&lang=".$lang."&listinfo=info&id=".$list[id]."'></script>";
	$list[useinfo]="<script language='javascript' src='access.php?metaccess=".$list[access]."&lang=".$lang."&listinfo=useinfo&id=".$list[id]."'></script>";
	  }}
    $message_list[]=$list;
    }
if($gz_webhtm==2){
$gz_pagelist=$gz_htmlistname?"message_list_":"index_list_";
$gz_pagelist=$message_column['filename']<>''?$message_column['filename'].'_':$gz_pagelist;
$gz_ahtmtype = $message_column['filename']<>''?$gz_chtmtype:$gz_htmtype;
$page_list = $rowset->link($gz_pagelist,$gz_ahtmtype);
}else{
	if($gz_pseudo){
		$page_list = $rowset->link('list-'.$class1.'-','-'.$lang.'.html');
	}else{
		$page_list = $rowset->link("index.php?lang=".$lang."&page=");	
	}
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
if(count($nav_list2[$message_column[id]])){
$k=count($nav_list2[$class1]);
$nav_list2[$class1][$k]=$class1_info;
$nav_list2[$class1][$k][name]=$lang_messageview;
$k++;
$nav_list2[$class1][$k]=array('url'=>$addmessage_url,'name'=>$lang_messageadd);
}else{
$k=count($nav_list2[$class1]);
  if(!$k){
   $nav_list2[$class1][0]=array('url'=>$addmessage_url,'name'=>$lang_messageadd);
   $nav_list2[$class1][1]=$class1_info;
   $nav_list2[$class1][1][name]=$lang_messageview;
   }
}
require_once '../public/php/methtml.inc.php';

$methtml_messagelist.="<ul>\n";
foreach($message_list as $key=>$val){
	$messagesName1=$db->get_one("select value from $gz_config where name='gz_message_fd_class' and lang='$lang'");
	$messagesNames1=$db->get_one("select info from $gz_mlist where listid='$val[id]' and paraid='$messagesName1[value]' and lang='$lang'");
	$messagesName2=$db->get_one("select value from $gz_config where name='gz_message_fd_content' and lang='$lang'");
	$messagesNames2=$db->get_one("select info from $gz_mlist where listid='$val[id]' and paraid='$messagesName2[value]' and lang='$lang'");
	$methtml_messagelist.="<li class='message_list_line'><span >[NO".$val[id]."]：<b>".$messagesNames1[info]."</b> ".$lang_Publish." ".$val[addtime]."</span></li>\n";
	$methtml_messagelist.="<li class='message_list_info'><span ><b>".$lang_SubmitContent."</b>:".$messagesNames2[info]."</span></li>\n";
	$methtml_messagelist.="<li class='message_list_reinfo'><span ><b>".$lang_Reply."</b>:".$val[useinfo]."</span></li>\n";
	}
$methtml_messagelist.="</ul>\n";
$pageall=$rowset->pages;
include template('message_index');
footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>