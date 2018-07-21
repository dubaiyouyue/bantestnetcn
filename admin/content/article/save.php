<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
//action id lang 
if($action == 'html'){
	if($gz_htmlurl == 1)$gz_webhtm = 0;
	$later_news=$db->get_one("select * from $gz_news order by updatetime DESC limit 0,1");
	$id=$later_news[id];
	$class1=$later_news[class1];
	$class2=$later_news[class2];
	$class3=$later_news[class3];
	$filename=$later_news[filename];
	$addtime=$later_news[addtime];
	$htmjs = contenthtm($class1,$id,'shownews',$filename,0,'',$addtime).'$|$';
	foreach($gz_classindex[2] as $key=>$val){
		if($val['id'] == $class1){
			$htmjs.=classhtm($val[id],0,0,1,0,$htmpack).'$|$';
			if($val['releclass']){
				foreach($gz_class3[$val[id]] as $key=>$val3){
					$htmjs.=classhtm($val[id],$val3[id],0,1,2,$htmpack).'$|$';
				}
			}
			else{
				foreach($gz_class22[$val[id]] as $key=>$val2){
					$htmjs.=classhtm($val[id],$val2[id],0,1,2,$htmpack).'$|$';
					foreach($gz_class3[$val2[id]] as $key=>$val3){
						$htmjs.=classhtm($val[id],$val2[id],$val3[id],1,3,$htmpack).'$|$';
					}
				}
			}
		}
	}
	$htmjs.= indexhtm().'$|$';	
	
	$turl  ="../index.php?lang=$lang&anyid=29&n=content&c=article_admin&a=doindex&class1=$select_class1&class2=$select_class2&class3=$select_class3";
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	metsave($turl,'',$depth,$htmjs,$gent);
	die();
}
$filename=namefilter($filename);
$filenameold=namefilter($filenameold);
if($filename_okno){
	$metinfo=1;
	if($filename!=''){
		$sql="class1='$class1'";
		foreach($column_pop as $key=>$val){
			if($key!=$lang){
				foreach($val as $key1=>$val1){
					if($val1['foldername']==$gz_class[$class1]['foldername'])$sql.=" or class1='$val1[id]'";
				}
			}
		}
		$filenameok = $db->get_one("SELECT * FROM $gz_news WHERE ($sql) and filename='$filename'");
		if($filenameok)$metinfo=0;
		if(is_numeric($filename) && $filename!=$id && $gz_pseudo){
			$filenameok1 = $db->get_one("SELECT * FROM {$gz_news} WHERE id='{$filename}' and class1='$class1'");
			if($filenameok1)$metinfo=2;
		}
	}
	echo $metinfo;
	die;
}  
$save_type=$action=="add"?1:($filename!=$filenameold?2:0);
if($filename!='' && $save_type){
		$sql="class1='$class1'";
		foreach($column_pop as $key=>$val){
			if($key!=$lang){
				foreach($val as $key1=>$val1){
					if($val1['foldername']==$gz_class[$class1]['foldername'])$sql.=" or class1='$val1[id]'";
				}
			}
		}
		$sql1=$save_type==2?" and id!=$id":'';
		$filenameok = $db->get_one("SELECT * FROM $gz_news WHERE ($sql) {$sql1} and filename='$filename'");
		if($filenameok)metsave('-1',$lang_modFilenameok,$depth);
}
if(!$imgurl&&!$imgurls){
	$imgauto=preg_match('/<img.*src=\\\\"(.*?)\\\\".*?>/i',$content,$out);
	$filenameimg=explode("images/",$out[1]);
	$filenameimg=$filenameimg[count($filenameimg)-1];
	$new_big_img='../../../upload/images/'.$filenameimg;
	$new_big_img=str_ireplace("/watermark","",$new_big_img);
	$new_big_img_iconv=stristr(PHP_OS,"WIN")?@iconv("utf-8","gbk",$new_big_img):$new_big_img;
	if($filenameimg&&file_exists($new_big_img_iconv)){
		require_once ROOTPATH_ADMIN.'include/upfile.class.php';
		$f = new upfile($gz_img_type,"../../../upload/images/",$gz_img_maxsize,'',1);
		$f->savename=str_ireplace("watermark/","",$filenameimg);
		$imgurls = $f->createthumb($new_big_img,$gz_newsimg_x,$gz_newsimg_y);
		if($gz_thumb_wate==1){
			require_once ROOTPATH_ADMIN.'include/watermark.class.php';
			$img = new Watermark();
			if($gz_wate_class==2){
				$img->gz_image_pos = $gz_watermark;
				$img->gz_image_name = $depth.$gz_wate_img;
			}else {
				$img->gz_text = $gz_text_wate;
				$img->gz_text_color = $gz_text_color;
				$img->gz_text_angle = $gz_text_angle;
				$img->gz_text_pos   = $gz_watermark;
				$img->gz_text_font = $depth.$gz_text_fonts;
				$img->gz_text_size  = $gz_text_size;
			}
			$img->save_file =$imgurls;
			$img->create($imgurls);
		}
		$imgurl='../upload/images/'.$filenameimg;
		$imgurls=str_replace('../../','',$imgurls);
	}
}

if($action=="add"){
$access=$access<>""?$access:"0";
if(!$description){
	$description=strip_tags($content);
	$description=str_replace("\n", '', $description); 
	$description=str_replace("\r", '', $description); 
	$description=str_replace("\t", '', $description);
	$description=mb_substr($description,0,200,'utf-8');
}
if($links){
	$links=str_replace("http://",'',$links); 
	$links="http://".$links;
}
$query = "INSERT INTO $gz_news SET
                      title              = '$title',
                      ctitle             = '$ctitle',
					  keywords           = '$keywords',
					  description        = '$description',
					  content            = '$content',
					  class1             = '$class1',
					  class2             = '$class2',
					  class3             = '$class3',
					  img_ok             = '$img_ok',
					  imgurl             = '$imgurl',
					  imgurls            = '$imgurls',
				      com_ok             = '$com_ok',
				      wap_ok             = '$wap_ok',
					  issue              = '$issue',
					  hits               = '$hits', 
					  addtime            = '$addtime', 
					  updatetime         = '$updatetime',
					  access          	 = '$access',
					  filename       	 = '$filename',
					  no_order       	 = '$no_order',
					  lang          	 = '$lang',
					  top_ok             = '$top_ok',
					  displaytype        = '$displaytype',
					  links              = '$links',
					  tag                = '$tag'";
         $db->query($query);
$later_news=$db->get_one("select * from $gz_news where updatetime='$updatetime' and lang='$lang'");
$id=$later_news[id];
$htmjs = contenthtm($class1,$id,'shownews',$filename,0,'',$addtime).'$|$';
$htmjs.= indexhtm().'$|$';
$htmjs.= classhtm($class1,$class2,$class3);
$turl  ="../content/article/index.php?anyid=$anyid&lang=$lang&class1=$reclass1&class2=$reclass2&class3=$reclass3";
$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
metsave($turl,'',$depth,$htmjs,$gent);
}
if($description){
	$description_type=$db->get_one("select * from $gz_news where id='$id'");
	$description1=strip_tags($description_type[content]);
	$description1=str_replace("\n", '', $description1); 
	$description1=str_replace("\r", '', $description1); 
	$description1=str_replace("\t", '', $description1);
	$description1=mb_substr($description1,0,200,'utf-8');
	if($description1==$description){
		$description=strip_tags($content);
		$description=str_replace("\n", '', $description); 
		$description=str_replace("\r", '', $description); 
		$description=str_replace("\t", '', $description);
		$description=mb_substr($description,0,200,'utf-8');
	}
}
if($action=="editor"){
if($links){
	$links=str_replace("http://",'',$links); 
	$links="http://".$links;
}
$query = "update $gz_news SET 
                      title              = '$title',
                      ctitle             = '$ctitle',
					  keywords           = '$keywords',
					  description        = '$description',
					  content            = '$content',
					  tag                = '$tag',
                      class1             = '$class1',
					  class2             = '$class2',
					  class3             = '$class3',
					  displaytype        = '$displaytype',
					  img_ok             = '$img_ok',
					  imgurl             = '$imgurl',
					  imgurls            = '$imgurls',";
					  
					  
if($metadmin[newscom])$query .= "	
				      com_ok             = '$com_ok',";
					  $query .= "
					  wap_ok             = '$wap_ok',
					  issue              = '$issue',
					  hits               = '$hits', 
					  addtime            = '$addtime', 
					  updatetime         = '$updatetime',";
if($gz_member_use)  $query .= "
					  access			 = '$access',";
if($metadmin[pagename])  $query .= "
					  filename       	 = '$filename',";
					  $query .= "
					  top_ok             = '$top_ok',
					  no_order       	 = '$no_order',
					  links              = '$links',
					  lang               = '$lang'
					  where id='$id'";
$db->query($query);
$htmjs = contenthtm($class1,$id,'shownews',$filename,0,'',$addtime).'$|$';
$htmjs.= indexhtm().'$|$';
$htmjs.= classhtm($class1,$class2,$class3);
if($filenameold<>$filename and $metadmin[pagename])deletepage($gz_class[$class1][foldername],$id,'shownews',$updatetimeold,$filenameold);
$classnow=$class3?$class3:($class2?$class2:$class1);
$turl  ="../content/article/index.php?anyid=$anyid&lang=$lang&class1=$reclass1&class2=$reclass2&class3=$reclass3&modify=$id&page=$page";
$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
metsave($turl,'',$depth,$htmjs,$gent);
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>
