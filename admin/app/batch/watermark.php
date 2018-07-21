<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
@set_time_limit(0);
function concentwatermark($str,$field){
global $gz_wate_class,$gz_wate_bigimg,$gz_text_wate,$gz_text_bigsize,$gz_text_color,$gz_text_angle,$gz_watermark,$gz_text_fonts;
global $img,$depth;
$tmp1 = explode("<",$str);
$concentflag=0;
$i=0;
foreach($tmp1 as $key=>$val){
	$tmp2=explode(">",$val);
	if(strcasecmp(substr(trim($tmp2[0]),0,3),'img')==0){
		preg_match("/http:\/\/[^\"]*/i",$tmp2[0],$url);
		if($url[0]){
			$urls=explode('/',$url[0]);
			$filename=$urls[count($urls)-1];
			if(stristr(PHP_OS,"WIN"))$filename=@iconv("utf-8","gbk",$filename);
			if(file_exists($depth."../../upload/images/".$filename)){
				$filename=$urls[count($urls)-1];
				$img->src_image_name = $depth."../../upload/images/".$filename;
				$img->save_file = $depth."../../upload/images/watermark/".$filename;
				$img->create();
				if(!stristr($tmp2[0],'/watermark/')){
					$concentflag=1;
					$tmp2[0]=str_ireplace("/images/","/images/watermark/",$tmp2[0]);
					$tmp1[$i]=implode(">",$tmp2);
				}
			}
		}
	}
	$i++;
}
if($concentflag==1){
	$str=implode("<",$tmp1);
	return "$field='$str'";
}
else{
	return false;
}
}
if($action=="class"){
	$class=$class3?$class3:($class2?$class2:$class1);
	$remark=$db->get_one("select * from $gz_column where id='$class'");
	$table=moduledb($remark['module']);
	$resql="class1='$class1'";
	$resql.=$class2?" and class2='$class2'":"";
	$resql.=$class3?" and class3='$class3'":"";
	$renow=$db->get_all("select * from $table where $resql and (recycle='0' or recycle='-1')");
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
$module=$table;
$table=moduledb($table);
$para_list=$db->get_all("select * from $gz_parameter where lang='$lang' and module='$module' and (class1='$class1' or class1=0) and type='5'");
$img = new Watermark();
if($gz_wate_class==2){
	$img->gz_image_pos  = $gz_watermark;
}else {
	$img->gz_text       = $gz_text_wate;
	$img->gz_text_color = $gz_text_color;
	$img->gz_text_angle = $gz_text_angle;
	$img->gz_text_pos   = $gz_watermark;
	$img->gz_text_font  = $depth.$gz_text_fonts;
}
$query="select * from $table where id='$id'";
$renow[0]=$db->get_one($query);
foreach($renow as $key=>$val){
	if($gz_wate_class==2){
		$img->gz_image_name = $depth.$gz_wate_bigimg;
	}else {
		$img->gz_text_size  = $gz_text_bigsize;
	}
	/*原图水印*/
	$gz_big_img='';
	
	if($gz_big_wate==1&&$val['imgurl']!=''){
		$imgurl=$val['imgurl'];
		$imgurlsql='';
		if(!stristr($val['imgurl'],'watermark')){
			$setimgurl   = explode("/",$imgurl);
			$imgurl=$setimgurl[0]."/".$setimgurl[1]."/".$setimgurl[2]."/watermark/".$setimgurl[3];
			$imgurlsql="imgurl='$imgurl'";
		}
		$gz_big_img = str_ireplace("/watermark","",$val['imgurl']);
		$img->src_image_name = $depth."../".$gz_big_img;
		$img->save_file = $depth."../".$imgurl;
		$img->create();
		$gz_bigthumb_img=$depth."../".$gz_big_img;
		//内容页缩略图
		$gz_img_x='';
		$gz_img_y='';
		if($module==3){$gz_img_x=$gz_productdetail_x;$gz_img_y=$gz_productdetail_y;}
		if($module==5){$gz_img_x=$gz_imgdetail_x;$gz_img_y=$gz_imgdetail_y;}
		$setthumb   = explode("/",$gz_big_img);
		$f = new upfile($gz_img_type,"../../../upload/$setthumb[2]/",$gz_img_maxsize,'',1);
		$f->savename=$setthumb[3];
		$imgurls = $f->createthumb($gz_bigthumb_img,$gz_img_x,$gz_img_y,'thumb_dis/');
		$img->src_image_name = $imgurls;
		$img->save_file =$imgurls;
		$img->create();
	}
	
	/*展示图片*/
	if($gz_big_wate==1&&$val['displayimg']!=''){
		$displayurl=explode("|",$val['displayimg']);
		foreach($displayurl as $key1=>$val1){
			$displayurls[]=explode("*",$val1);
		}
		$displayflag=0;
		$displaysql='';
		foreach($displayurls as $key2=>$val2){
			$imgurl=$val2[1];
			if(!stristr($val2[1],'watermark')){
				$setimgurl   = explode("/",$imgurl);
				$imgurl=$setimgurl[0]."/".$setimgurl[1]."/".$setimgurl[2]."/watermark/".$setimgurl[3];
				$displayflag=1;
			}
			$setdisplayimg.="$val2[0]*$imgurl|";
			$gz_bigdisplay_img = str_ireplace("/watermark","",$val2[1]);
			if($gz_big_wate==1){
				$img->src_image_name = $depth."../".$gz_bigdisplay_img;
				$img->save_file = $depth."../".$imgurl;
				$img->create();
			}
			//内容页缩略图
			$setthumb   = explode("/",$gz_bigdisplay_img);
			$f = new upfile($gz_img_type,"../../../upload/$setthumb[2]/",$gz_img_maxsize,'',1);
			$f->savename=$setthumb[3];
			$gz_dis_img=$depth."../".$gz_bigdisplay_img;
			$gz_bigdisplay_img_iconv=stristr(PHP_OS,"WIN")?@iconv("utf-8","gbk",$gz_dis_img):$gz_dis_img;
			if(file_exists($gz_bigdisplay_img_iconv)){
				$gz_img_x='';
				$gz_img_y='';
				if($module==3){$gz_img_x=$gz_productdetail_x;$gz_img_y=$gz_productdetail_y;}
				if($module==5){$gz_img_x=$gz_imgdetail_x;$gz_img_y=$gz_imgdetail_y;}
				$imgurls = $f->createthumb($gz_dis_img,$gz_img_x,$gz_img_y,'thumb_dis/');
				$img->src_image_name = $imgurls;
				$img->save_file =$imgurls;
				$img->create();
			}
		}
		if($displayflag==1){
			$setdisplayimg=trim($setdisplayimg,'|');
			$displaysql="displayimg='$setdisplayimg'";
		}
	}
	/*产品内容图片*/
	if($gz_big_wate==1&&$val['content']!=''){
		$contentsql='';
		$contentsql=concentwatermark($val['content'],'content');
	}
	if($gz_big_wate==1&&$val['content1']!=''){
		$contentsql1='';
		$contentsql1=concentwatermark($val['content1'],'content1');
	}
	if($gz_big_wate==1&&$val['content2']!=''){
		$contentsql2='';
		$contentsql2=concentwatermark($val['content2'],'content2');
	}
	if($gz_big_wate==1&&$val['content3']!=''){
		$contentsql3='';
		$contentsql3=concentwatermark($val['content3'],'content3');
	}
	if($gz_big_wate==1&&$val['content4']!=''){
		$contentsql4='';
		$contentsql4=concentwatermark($val['content4'],'content4');
	}
	$sql='';
	if($imgurlsql)$sql.="$imgurlsql,";
	if($displaysql)$sql.="$displaysql,";
	if($contentsql)$sql.="$contentsql,";
	if($contentsql1)$sql.="$contentsql1,";
	if($contentsql2)$sql.="$contentsql2,";
	if($contentsql3)$sql.="$contentsql3,";
	if($contentsql4)$sql.="$contentsql4,";
	$sql=substr($sql,0,-1);
	$query="update $table set $sql where id='$val[id]'";
	$db->query($query);
	/*字段图片*/
	if($gz_big_wate==1&&$para_list){
			foreach($para_list as $key3=>$val3){
				$imagelist=$db->get_one("select * from $gz_plist where lang='$lang' and  paraid='$val3[id]' and listid='$val[id]'");
				$imgurl=$imagelist['info'];
				if(!stristr($imagelist['info'],'watermark')){
					$setimgurl   = explode("/",$imgurl);
					$imgurl=$setimgurl[0]."/".$setimgurl[1]."/".$setimgurl[2]."/watermark/".$setimgurl[3];
					$query="update $gz_plist set info='$imgurl' where id='$imagelist[id]'";
					$db->query($query);					
				}
				$gz_bigpara_img = str_ireplace("/watermark","",$imagelist['info']);
				if($gz_big_wate==1){
					$img->src_image_name = $depth."../".$gz_bigpara_img;
					$img->save_file = $depth."../".$imgurl;
					$img->create();
				}
			}
	}	
	/*缩略图*/
	if($gz_thumb_wate==1&&$val['imgurls']!=''){
		$imgurls=$depth.'../'.$val['imgurls'];
		if($gz_big_img==''){
			$imgurl=$val['imgurl'];
			if(!stristr($val['imgurl'],'watermark')){
				$setimgurl   = explode("/",$imgurl);
				$imgurl=$setimgurl[0]."/".$setimgurl[1]."/".$setimgurl[2]."/watermark/".$setimgurl[3];
			}
			$gz_big_img = str_ireplace("/watermark","",$val['imgurl']);
		}
		
		$setthumb   = explode("/",$gz_big_img);
		$f = new upfile($gz_img_type,"../../../upload/$setthumb[2]/",$gz_img_maxsize,'',1);
		$f->savename=$setthumb[3];
		$gz_bigthumb_img=$depth."../".$gz_big_img;
		$gz_big_img_iconv=stristr(PHP_OS,"WIN")?@iconv("utf-8","gbk",$gz_bigthumb_img):$gz_bigthumb_img;
		if(file_exists($gz_big_img_iconv)){
			//列表和首页缩略图
			if($gz_big_img==str_ireplace("/thumb","",$val['imgurls'])){
				$gz_img_x='';
				$gz_img_y='';
				if($gz_img_style==1)imgstyle($module);
				$gz_thumb_img=$depth."../".$gz_big_img;
				$imgurls = $f->createthumb($gz_thumb_img,$gz_img_x,$gz_img_y);
				if($gz_wate_class==2){
					$img->gz_image_name = $depth.$gz_wate_img;
				}else {
					$img->gz_text_size  = $gz_text_size;
				}
				$img->src_image_name = $imgurls;
				$img->save_file =$imgurls;
				$img->create();
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