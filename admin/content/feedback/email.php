<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.  
$depth='../';
require_once $depth.'../login/login_check.php';
require_once ROOTPATH.'public/php/searchhtml.inc.php';
if($action=='sendmail'){
	@ini_set("max_execution_time", "30000");
	require_once ROOTPATH.'include/jmail.php';
	$emailok=jmailsend($gz_fd_usename,$gz_fd_fromname,$addressee,$title,$contents,$gz_fd_usename,$gz_fd_password,$gz_fd_smtp);
	$re=$emailok?$lang_setbasicok:$lang_setbasicno;
	metsave("../content/feedback/editor.php?anyid={$anyid}&id={$id}&lang={$lang}&class1={$class1}&classall={$classall}&customerid={$customerid}",$re,$depth);
}
$css_url=$depth."../templates/".$gz_skin."/css";
$img_url=$depth."../templates/".$gz_skin."/images";
include template('content/feedback/email');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>