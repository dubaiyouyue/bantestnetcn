<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once '../login/login_check.php';
if($action=="modify"){
	if($Submit){
		if($cs==2){
			$dltimg=explode('../',$gz_wate_img);
			if(count($dltimg)==2){
					$gz_wate_img   = "../".$gz_wate_img;
			}
			$dltimg1=explode('../',$gz_wate_bigimg);
			if(count($dltimg1)==2){
				$gz_wate_bigimg   = "../".$gz_wate_bigimg;
			}
		}
		require_once $depth.'../include/config.php';
		$txt='';
		if($cs==1){
			if($gz_productimg_x!=$moren_productimg_x || $gz_productimg_y!=$moren_productimg_y){
				$txt=$lang_metadmintext1;
			}
			if($gz_imgs_x!=$moren_imgs_x || $gz_imgs_y!=$moren_imgs_y){
				$txt=$lang_metadmintext1;
			}
			if($gz_newsimg_x!=$moren_newsimg_x || $gz_newsimg_y!=$moren_newsimg_y){
				$txt=$lang_metadmintext1;
			}
		}
		metsave('../system/img.php?anyid='.$anyid.'&lang='.$lang.'&cs='.$cs,$lang_jsok.$txt);
	}else if($delsubmit){
		if(file_exists('../../upload/thumb_src/')){
			$resource = opendir('../../upload/thumb_src/');
			@clearstatcache();
			while(($file = readdir($resource))!== false){
				if($file == '.' || $file == '..'){
					continue;
				}
				if(!is_dir('../../upload/thumb_src/'.$file)){
					@clearstatcache();
					if(file_exists('../../upload/thumb_src/'.$file)){
						unlink('../../upload/thumb_src/'.$file);
					}
					@clearstatcache();
				}else if(file_exists('../../upload/thumb_src/'.$file.'/')){			
					$resource1 = opendir('../../upload/thumb_src/'.$file.'/');
					@clearstatcache();
					while(($file1 = readdir($resource1))!== false){
						if($file1 == '.' || $file1 == '..'){
							continue;
						}
						if(!is_dir('../../upload/thumb_src/'.$file.'/'.$file1)){
							@clearstatcache();
							if(file_exists('../../upload/thumb_src/'.$file.'/'.$file1)){
								unlink('../../upload/thumb_src/'.$file.'/'.$file1);
							}
							@clearstatcache();
						}
					}
					rmdir('../../upload/thumb_src/'.$file.'/');
				}
			}
			closedir($resource1);
			closedir($resource);
			@clearstatcache();
		}
		metsave('../system/img.php?anyid='.$anyid.'&lang='.$lang.'&cs='.$cs,$lang_jsok.$txt);
	}
}else{
if($gz_img_style==0)$gz_img_style0="checked='checked'";
if($gz_img_style==1)$gz_img_style1="checked='checked'";
if($gz_big_wate==1)$gz_big_wate1="checked='checked'";
if($gz_thumb_wate==1)$gz_thumb_wate1="checked='checked'";
if($gz_autothumb_ok==1)$gz_autothumb_ok1="checked='checked'";

if($gz_wate_class==1)$gz_wate_class1="checked='checked'";
if($gz_wate_class==2)$gz_wate_class2="checked='checked'";

$metthumbkind[$gz_thumb_kind]='checked';
switch($gz_watermark){
case 0:
$gz_watermark0="checked='checked'";
break;
case 1:
$gz_watermark1="checked='checked'";
break;
case 2:
$gz_watermark2="checked='checked'";
break;
case 3:
$gz_watermark3="checked='checked'";
break;
case 4:
$gz_watermark4="checked='checked'";
break;
case 5:
$gz_watermark5="checked='checked'";
break;
case 6:
$gz_watermark6="checked='checked'";
break;
case 7:
$gz_watermark7="checked='checked'";
break;
case 8:
$gz_watermark8="checked='checked'";
break;
}
$cs=isset($cs)?$cs:1;
$listclass[$cs]='class="now"';
$displaytr[$gz_img_style]=' style="display: none; "';
$css_url="../templates/".$gz_skin."/css";
$img_url="../templates/".$gz_skin."/images";
include template('system/set_img');
footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>