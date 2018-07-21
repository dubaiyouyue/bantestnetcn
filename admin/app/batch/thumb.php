<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
@set_time_limit(0);
if($action=="class"){
	$class=$class3?$class3:($class2?$class2:$class1);
	$remark=$db->get_one("select * from $gz_column where id='$class'");
	$table=moduledb($remark['module']);
	$resql="class1='$class1'";
	$resql.=$class2?" and class2='$class2'":"";
	$resql.=$class3?" and class3='$class3'":"";
	$renow=$db->get_all("select * from $table where $resql  and (recycle='0' or recycle='-1')");
	echo $remark['module'].'|';
	foreach($renow as $key=>$val){
		echo $val['id'].'-';
	}
die();
}
if($action=="do"){
require_once $depth.'../include/watermark.class.php';
require_once $depth.'../include/upfile.class.php';
$gz_img_maxsize=$gz_img_maxsize*1024*1024;
$img = new Watermark();
if($gz_wate_class==2){
	$img->gz_image_pos = $gz_watermark;
}else {
	$img->gz_text = $gz_text_wate;
	$img->gz_text_color = $gz_text_color;
	$img->gz_text_angle = $gz_text_angle;
	$img->gz_text_pos   = $gz_watermark;
	$img->gz_text_font = $depth.$gz_text_fonts;
}
$mou=$table;
$table=moduledb($table);
$query="select * from $table where id='$id'";
$renow[0]=$db->get_one($query);
foreach($renow as $key=>$val){
	if($mou==2&&!$val['imgurl']){
		$imgauto=preg_match('/<img.*src="(.*?)".*?>/i',$val['content'],$out);
		$filename=explode("images/",$out[1]);
		$filename=$filename[count($filename)-1];
		if($filename){
			$val['imgurl']='../upload/images/'.$filename;
			$val['imgurls']='../upload/images/thumb/'.str_ireplace("watermark/","",$filename);
			$query="UPDATE $gz_news SET imgurl='$val[imgurl]',imgurls='$val[imgurls]' WHERE id='$val[id]'";
			echo $query;
			$db->query($query);
			echo $db->error($query);
		}
	}
	if($val['imgurls']){
		$gz_big_img = str_ireplace("/watermark","",$val['imgurl']);
		$imgurls=$depth.'../'.$val['imgurls'];
		if($gz_img_style==1)imgstyle($mou);
		$setthumb   = explode("/",$gz_big_img);
		$f = new upfile($gz_img_type,"../../../upload/$setthumb[2]/",$gz_img_maxsize,'',1);
		$f->savename=$setthumb[3];
		$gz_thumb_img=$depth."../".$gz_big_img;
		$gz_big_img_iconv=stristr(PHP_OS,"WIN")?@iconv("utf-8","gbk",$gz_thumb_img):$gz_thumb_img;
		if(file_exists($gz_big_img_iconv)){
			$imgurls = $f->createthumb($gz_thumb_img,$gz_img_x,$gz_img_y);
			if($f->get_error()==0){
				if($gz_thumb_wate==1){
					if($gz_wate_class==2){
						$img->gz_image_name = $depth.$gz_wate_img;
					}else {
						$img->gz_text_size  = $gz_text_size;
					}
					$img->save_file =$imgurls;
					$img->create($imgurls);
					$imgurls_a=explode("../",$imgurls);
					$imgurls="../".$imgurls_a[3];
				}
				if($gz_thumb_img!=$depth."../".str_ireplace("/thumb","",$val['imgurls'])){
					$imgurls='../'.str_ireplace("../","",$imgurls);
					$query="update $table set imgurls='$imgurls' where id='$val[id]'";
					if($db->query($query)){@file_unlink("../../$val[imgurls]");}
				}
			}
			$gz_img_x='';
			$gz_img_y='';
			if($mou==3){$gz_img_x=$gz_productdetail_x;$gz_img_y=$gz_productdetail_y;}
			if($mou==5){$gz_img_x=$gz_imgdetail_x;$gz_img_y=$gz_imgdetail_y;}
			$gz_bigthumb_img=$depth."../".$gz_big_img;
			$imgurls = $f->createthumb($gz_bigthumb_img,$gz_img_x,$gz_img_y,'thumb_dis/');
			if($gz_big_wate&&$mou!=2){
				if($gz_wate_class==2){
					$img->gz_image_name = $depth.$gz_wate_bigimg;
				}else {
					$img->gz_text_size  = $gz_text_bigsize;
				}
				$img->src_image_name = $imgurls;
				$img->save_file =$imgurls;
				$img->create();
			}
		}
	}	
	/*Õ¹Ê¾Í¼Æ¬*/
	if($val['displayimg']){
		$displayurl=explode("|",$val['displayimg']);
		foreach($displayurl as $key1=>$val1){
			$displayurls[]=explode("*",$val1);
		}
		foreach($displayurls as $key2=>$val2){
			$gz_bigdisplay_img = str_ireplace("/watermark","",$val2[1]);
			//ÄÚÈÝÒ³ËõÂÔÍ¼
			$setthumb   = explode("/",$gz_bigdisplay_img);
			$f = new upfile($gz_img_type,"../../../upload/$setthumb[2]/",$gz_img_maxsize,'',1);
			$f->savename=$setthumb[3];
			$gz_dis_img=$depth."../".$gz_bigdisplay_img;
			$gz_bigdisplay_img_iconv=stristr(PHP_OS,"WIN")?@iconv("utf-8","gbk",$gz_dis_img):$gz_dis_img;
			if(file_exists($gz_bigdisplay_img_iconv)){
				$gz_img_x='';
				$gz_img_y='';
				if($mou==3){$gz_img_x=$gz_productdetail_x;$gz_img_y=$gz_productdetail_y;}
				if($mou==5){$gz_img_x=$gz_imgdetail_x;$gz_img_y=$gz_imgdetail_y;}
				$imgurls = $f->createthumb($gz_dis_img,$gz_img_x,$gz_img_y,'thumb_dis/');
				if($gz_big_wate){
					if($gz_wate_class==2){
						$img->gz_image_name = $depth.$gz_wate_bigimg;
					}else {
						$img->gz_text_size  = $gz_text_bigsize;
					}
					$img->src_image_name = $imgurls;
					$img->save_file =$imgurls;
					$img->create();
				}
			}
		}
	}
}
echo 'ok';
die();
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>