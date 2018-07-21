<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.  
$depth='../';
require_once $depth.'../login/login_check.php';
require_once ROOTPATH.'public/php/searchhtml.inc.php';
if($class1){
	foreach($settings_arr as $key=>$val){
		if($val['columnid']==$class1){
			$tingname    =$val['name'].'_'.$val['columnid'];
			$$val['name']=$$tingname;
		}
	}
}
$query = "SELECT * FROM $gz_list where bigid='$gz_fd_class' order by no_order";
$result = $db->query($query);
while($list= $db->fetch_array($result)){
	$selectlist[]=$list;
}
$serch_sql=" where lang='$lang' ";
if(!$customerid)$serch_sql.=" and class1='$class1' ";
if($readok!="") $serch_sql.=" and readok='$readok' ";
if($gz_fd_classname!="")$serch_sql.=" and exists(select info from $gz_flist where listid=$gz_feedback.id and paraid=$gz_fd_class and info='$gz_fd_classname')";
$order_sql=" order by id desc ";
if($customerid) { $serch_sql .= " and customerid='$customerid' "; }
if($search == "detail_search") {
	if($useinfo) { $serch_sql .= " and useinfo like '%$useinfo%' "; }
	$total_count = $db->counter($gz_feedback, "$serch_sql", "*");
}else{
	$total_count = $db->counter($gz_feedback, "$serch_sql", "*");
}
require_once 'include/pager.class.php';
$page = (int)$page;
if($page_input){$page=$page_input;}
$list_num = 20;
$rowset = new Pager($total_count,$list_num,$page);
$from_record = $rowset->_offset();
$query = "SELECT * FROM $gz_feedback $serch_sql $order_sql LIMIT $from_record, $list_num";
$result = $db->query($query);
while($list= $db->fetch_array($result)){
	$list['customerid']=$list['customerid']=='0'?$lang_feedbackAccess0:$list['customerid'];
	$list[readok] = $list[readok] ? $lang_yes : $lang_no;
	$feedback_list[]=$list;
}
$page_list = $rowset->link("index.php?anyid=$anyid&lang=$lang&class1=$class1&search=$search&readok=$readok&useinfo=$useinfo&gz_fd_classname=$gz_fd_classname&customerid={$customerid}&page=");
	$cs=3;
	$listclass='';
	$listclass[$cs]='class="now"';
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
include template('content/feedback/feedback');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>