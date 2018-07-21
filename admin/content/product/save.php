<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
if($action == 'html'){
	if($gz_htmlurl == 1)$gz_webhtm = 0;
	$later_news=$db->get_one("select * from $gz_product order by updatetime DESC limit 0,1");
	$id=$later_news[id];
	$class1=$later_news[class1];
	$class2=$later_news[class2];
	$class3=$later_news[class3];
	$filename=$later_news[filename];
	$addtime=$later_news[addtime];
	$htmjs = contenthtm($class1,$id,'showproduct',$filename,0,'',$addtime).'$|$';
	foreach($gz_classindex[3] as $key=>$val){
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
	
	$turl  ="../index.php?lang=$lang&anyid=29&n=content&c=product_admin&a=doindex&class1=$select_class1&class2=$select_class2&class3=$select_class3";
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
		$filenameok = $db->get_one("SELECT * FROM $gz_product WHERE ($sql) and filename='$filename'");
		if($filenameok)$metinfo=0;
		if(is_numeric($filename) && $filename!=$id && $gz_pseudo){
			$filenameok1 = $db->get_one("SELECT * FROM {$gz_product} WHERE id='{$filename}' and class1='$class1'");
			if($filenameok1)$metinfo=2;
		}
	}
	echo $metinfo;
	die();
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
		$filenameok = $db->get_one("SELECT * FROM $gz_product WHERE ($sql) {$sql1} and filename='$filename'");
		if($filenameok)metsave('-1',$lang_modFilenameok,$depth);
}
$module=$gz_class[$class1][module];
$query = "select * from $gz_parameter where lang='$lang' and module='".$gz_class[$class1][module]."' and (class1=$class1 or class1=0) order by no_order";
$result = $db->query($query);
while($list = $db->fetch_array($result)){
	if($list[type]==4){
		$query1 = " where lang='$lang' and bigid='".$list[id]."'";
		$total_list[$list[id]] = $db->counter($gz_list, "$query1", "*");
	}
	$para_list[]=$list;
}
if($imgnum>0){
	for($i=0;$i<$imgnum;$i++){
		$displayimg = "displayimg".$i;
		$displayname = "displayname".$i;
		$$displayname=str_replace(array('|','*'),'_',$$displayname);
		if($$displayname||$$displayimg){
			if($i==0){
				$displayimglist=$$displayname.'*'.$$displayimg;
			}else{
				$displayimglist=$displayimglist.'|'.$$displayname.'*'.$$displayimg;
			}
		}
	}
} 
$displayimg = $displayimglist;
$classother=$classothers?'|'.implode('|',$classothers).'|':'';
if($metinfover)$metadmin[productother] = $gz_productTabok-1;
if($action=="add"){
	if(!$description){
		$description=strip_tags($content);
		$description=str_replace("\n",'',$description); 
		$description=str_replace("\r",'',$description); 
		$description=str_replace("\t",'',$description);
		$description=mb_substr($description,0,200,'utf-8');
	}
	if($links){
		$links=str_replace("http://",'',$links); 
		$links="http://".$links;
	}
	$access=$access<>""?$access:0;
	$query = "INSERT INTO $gz_product SET
						  title              = '$title',
						  ctitle             = '$ctitle',
						  keywords           = '$keywords',
						  description        = '$description',
						  content            = '$content',
						  class1             = '$class1',
						  class2             = '$class2',
						  class3             = '$class3',
						  classother         = '$classother',
						  new_ok             = '$new_ok',
						  imgurl             = '$imgurl',
						  imgurls            = '$imgurls',
						  displayimg         = '$displayimg',
						  com_ok             = '$com_ok',
						  wap_ok             = '$wap_ok',
						  issue              = '$issue',
						  hits               = '$hits', 
						  addtime            = '$addtime', 
						  updatetime         = '$updatetime',
						  access          	 = '$access',
						  filename           = '$filename',
						  no_order       	 = '$no_order',
						  lang          	 = '$lang',
						  displaytype        = '$displaytype',
						  tag                = '$tag',
						  links              = '$links',";
	if($metadmin[productother])$query .="
						  contentinfo         = '$contentinfo',
						  contentinfo1        = '$contentinfo1',
						  contentinfo2        = '$contentinfo2',
						  contentinfo3        = '$contentinfo3',
						  contentinfo4        = '$contentinfo4',
						  content1            = '$content1',
						  content2            = '$content2',
						  content3            = '$content3',
						  content4            = '$content4',
						  ";
				 $query .="top_ok             = '$top_ok'";
			$db->query($query);
	$later_product=$db->get_one("select * from $gz_product where updatetime='$updatetime' and lang='$lang'");
	$id=$later_product[id];
	foreach($para_list as $key=>$val){
		if($val[type]!=4){
			$para="para".$val[id];
			$para=$$para;
			if($val[type]==5){
				$paraname="para".$val[id]."name";
				$paraname=$$paraname;
			}
		}else{
			$para="";
			for($i=1;$i<=$total_list[$val[id]];$i++){
				$paraa="para".$val[id]."_".$i;
				$parab=$$paraa;
				$para=($parab<>"")?$para.$parab."-":$para;
			}
			$para=substr($para, 0, -1);
		}
		$query = "INSERT INTO $gz_plist SET
			listid   ='$id',
			paraid   ='$val[id]',
			info     ='$para',
			imgname  ='$paraname',
			module   ='$module',
			lang     ='$lang'";
		$db->query($query);
		$paraname="";
	}
	$htmjs =contenthtm($class1,$id,'showproduct',$filename,0,'',$addtime).'$|$';
	$htmjs.=indexhtm().'$|$';
	$htmjs.=classhtm($class1,$class2,$class3);
	$turl  ="../content/product/index.php?anyid=$anyid&lang=$lang&class1=$reclass1&class2=$reclass2&class3=$reclass3";
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	metsave($turl,'',$depth,$htmjs,$gent);
}
if($description){
	$description_type=$db->get_one("select * from $gz_product where id='$id'");
	$description1=strip_tags($description_type[content]);
	$description1=str_replace("\n", '', $description1); 
	$description1=str_replace("\r", '', $description1); 
	$description1=str_replace("\t", '', $description1);
	$description1=mb_substr($description1,0,200,'utf-8');
	if($description1==$description){
		$description=strip_tags($content);
		$description=str_replace("\n", '',$description); 
		$description=str_replace("\r", '', $description); 
		$description=str_replace("\t", '', $description);
		$description=mb_substr($description,0,200,'utf-8');
	}
}
if($action=="editor"){
	if($class_other != 1){
		$classother = '';
	}
	if($links){
		$links=str_replace("http://",'',$links); 
		$links="http://".$links;
	}
	$query = "update $gz_product SET 
						  title              = '$title',
						  ctitle             = '$ctitle',
						  keywords           = '$keywords',
						  description        = '$description',
						  content            = '$content',
					      tag                = '$tag',
						  class1             = '$class1',
						  class2             = '$class2',
						  class3             = '$class3',
						  classother         = '$classother',
						  imgurl             = '$imgurl',
						  imgurls            = '$imgurls',
						  displayimg         = '$displayimg',
						  displaytype        = '$displaytype',
						  links              = '$links',";
	if($metadmin[productnew])$query .= "					  
						  new_ok             = '$new_ok',";
	if($metadmin[productcom])$query .= "	
						  com_ok             = '$com_ok',";
						  $query .= "
						  wap_ok             = '$wap_ok',
						  issue              = '$issue',
						  hits               = '$hits', 
						  addtime            = '$addtime', 
						  updatetime         = '$updatetime',";
	if($gz_member_use)  $query .= "
						  access			 = '$access',";
	if($metadmin[pagename])$query .= "
						  filename       	 = '$filename',
						  no_order       	 = '$no_order',";
	if($metadmin[productother])$query .="
						  contentinfo         = '$contentinfo',
						  contentinfo1        = '$contentinfo1',
						  contentinfo2        = '$contentinfo2',
						  contentinfo3        = '$contentinfo3',
						  contentinfo4        = '$contentinfo4',
						  content1            = '$content1',
						  content2            = '$content2',
						  content3            = '$content3',
						  content4            = '$content4',
						  ";
						  $query .= "
						  top_ok             = '$top_ok',
						  lang               = '$lang'
						  where id='$id'";
	$db->query($query);
	foreach($para_list as $key=>$val){
		if($val[type]!=4){
		  $paras="para".$val[id];
		  $para=$$paras;
		   if($val[type]==5){
			 $paraname="para".$val[id]."name";
			 $paraname=$$paraname;
			 }
		}else{
		  $para="";
		  for($i=1;$i<=$total_list[$val[id]];$i++){
		  $paraa="para".$val[id]."_".$i;
		  $parab=$$paraa;
		  $para=($parab<>"")?$para.$parab."-":$para;
		  }
		  $para=substr($para, 0, -1);
		}
		$now_list=$db->get_one("select * from $gz_plist where listid='$id' and  paraid='$val[id]'");
		if($now_list){
		$query = "update $gz_plist SET
						  info     ='$para',
						  imgname  ='$paraname',
						  lang     ='$lang'
						  where listid='$id' and  paraid='$val[id]'";
		}else{
		$query = "INSERT INTO $gz_plist SET
						  listid   ='$id',
						  paraid   ='$val[id]',
						  info     ='$para',
						  imgname  ='$paraname',
						  module   ='$module',
						  lang     ='$lang'";	
		 }
			 $db->query($query);
	   $paraname="";
	}
	$htmjs =contenthtm($class1,$id,'showproduct',$filename,0,'',$addtime).'$|$';
	$htmjs.=indexhtm().'$|$';
	$htmjs.=classhtm($class1,$class2,$class3);
	if($filenameold<>$filename and $metadmin[pagename])deletepage($gz_class[$class1][foldername],$id,'showproduct',$updatetimeold,$filenameold);
	$classnow=$class3?$class3:($class2?$class2:$class1);
	//if(($addtime != $updatetime && $gz_class[$classnow]['list_order']<2) || $top_ok==1)$page=0;
	$turl  ="../content/product/index.php?anyid=$anyid&lang=$lang&class1=$reclass1&class2=$reclass2&class3=$reclass3&modify=$id&page=$page";
	$gent='../../sitemap/index.php?lang='.$lang.'&htmsitemap='.$gz_member_force;
	metsave($turl,'',$depth,$htmjs,$gent);
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>