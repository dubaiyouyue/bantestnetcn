<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
     require_once '../include/common.inc.php';
if($gz_webhtm==0){
$member_login_url="login.php?lang=".$lang;
$member_register_url="register.php?lang=".$lang;
}else{
$member_login_url="login".$gz_htmtype;
$member_register_url="register".$gz_htmtype;
}
$message_list=$db->get_one("SELECT * FROM $gz_message where id='$id' and lang='$lang'");
switch($listinfo){
case 'info':
   if(intval($metinfo_member_type)<intval($metaccess)){
       $gz_js_ac=$lang_access;
    }else{
       $gz_js_ac=$message_list[info];
    }
break;
case 'useinfo':
   if(intval($metinfo_member_type)<intval($metaccess)){
     $gz_js_ac="【<a href='../member/$member_login_url'>$lang_login</a>】【<a href='../member/$member_register_url'>$lang_register</a>】";
	 }else{
       $gz_js_ac=$message_list[useinfo];
    }
break;
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>
$gz_js="<?php echo $gz_js_ac; ?>";
document.write($gz_js) 