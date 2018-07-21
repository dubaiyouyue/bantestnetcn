<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once '../login/login_check.php';
$infofile="../../templates/".$gz_skin_user."/info.html";
if(!file_exists($infofile)){
	if($skin_file_s)$gz_skin_user=$skin_file_s;
	if($gz_skin_user=='default')$gz_skin_user='metv5';
	header("location:http://www.resonance.com.cn/course/peizhi/{$gz_skin_user}-cn.html");exit;
}
$content = file_get_contents($infofile);
$content = str_replace('{$gz_skin_user}',$gz_skin_user,$content);
$content = str_replace('$gz_skin_user',$gz_skin_user,$content);
echo $content.'<br/>';
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>