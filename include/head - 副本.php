<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
	if(!defined('IN_MET'))require_once 'common.inc.php';//应用修改带代码
	require_once ROOTPATH.'include/global/pseudo.php';
	$class1    = $index=='index'?10001:($class1==''?0:$class1);
	$class2    = $index=='index'?0:($class2==''?0:$class2);
	$class3    = $index=='index'?0:($class3==''?0:$class3);
	$classnow  = $classnow==''?($class3?$class3:($class2?$class2:$class1)):$classnow;
	$class_list[10001]['module'] = 10001;
    $tempfie=ROOTPATH."templates/".$gz_skin_user."/database.inc.php";
    $conffie=ROOTPATH.'config/database.inc.php';
	require_once file_exists($tempfie)?$tempfie:$conffie;
	$pagemark=$class_list[$classnow]['module'];
/*Standby field */
	if(!isset($dataoptimize[$pagemark]['otherinfo']))$dataoptimize[$pagemark]['otherinfo']=$dataoptimize[10000]['otherinfo'];
	if($dataoptimize[$pagemark]['otherinfo']){
	    $otherinfo=gz_cache('otherinfo_'.$lang.'.inc.php');
		if(!$otherinfo){
			$otherinfo=cache_otherinfo();
		}
		if($index=="index"){
			$otherinfo['imgurl1']=explode("../",$otherinfo['imgurl1']);
			$otherinfo['imgurl1']=$otherinfo['imgurl1'][1];
			$otherinfo['imgurl2']=explode("../",$otherinfo['imgurl2']);
			$otherinfo['imgurl2']=$otherinfo['imgurl2'][1];
		}
	}

/*Flash*/
	$bannernid = $gz_bannerpagetype?10001:$classnow;
	if($gz_bannerpagetype&&$classnow!=10001)$gz_flasharray[$classnow] = $gz_flasharray[10001];
	if($metview_flash==$gz_member_force){
		$gz_flasharray[$classnow]['type']=$metview_flash_type;
		$gz_flasharray[$classnow]['imgtype']=$metview_flash_imgtype;
		$gz_flasharray[$classnow]['x']=$metview_flash_x;
		$gz_flasharray[$classnow]['y']=$metview_flash_y;
	}
	if(!isset($gz_flasharray[$classnow]['type']))$gz_flasharray[$classnow]=$gz_flasharray[10000];
	if($gz_flasharray[$classnow]['type']){
		$query_x=$gz_flasharray[$classnow]['type']==2?"and flash_path!=''":"and img_path!=''";
		$qsql=$gz_mobileok?"and wap_ok='1'":"and wap_ok='0'";//mobile
		$query="select * from $gz_flash where lang='$lang' {$qsql} and (module like '%,{$bannernid},%' or module='metinfo') {$query_x} order by no_order";
		$result= $db->query($query);
		if($db->affected_rows()==0){
			$superior=$class_list[$classnow]['bigclass'];
			$query_x=$gz_flasharray[$superior]['type']==2?"and flash_path!=''":"and img_path!=''";
			$query="select * from $gz_flash where lang='$lang' {$qsql} and (module like '%,{$superior},%' or module='metinfo') {$query_x} order by no_order";
			$result= $db->query($query);			
		}
		if($db->affected_rows()==0){
			$superior=$class_list[$superior]['bigclass'];
			$query_x=$gz_flasharray[$superior]['type']==2?"and flash_path!=''":"and img_path!=''";
			$query="select * from $gz_flash where lang='$lang' {$qsql} and (module like '%,{$superior},%' or module='metinfo') {$query_x} order by no_order";
			$result= $db->query($query);			
		}
		while($list = $db->fetch_array($result)){
			if($index=="index"){
				$list['img_path_array']=explode("../",$list['img_path']);
				$list['img_path']=$list['img_path_array'][1];
				$list['flash_path_array']=explode("../",$list['flash_path']);
				$list['flash_path']=$list['flash_path_array'][1];
				$list['flash_back_array']=explode("../",$list['flash_back']);
				$list['flash_back']=$list['flash_back_array'][1];
			}
			$gz_flashall[]=$list;
			$listmodule_x=explode(",",$list['module']);
			$flash_mx = count($listmodule_x);
			if($list['flash_path']!=""){
				$gz_flashflashall[]=$list; 
				if($list['module']=='metinfo'){
					if(!$flash_flash_module[$classnow])$flash_flash_module[$classnow]=$list;
				}else{
					for($i=0;$i<$flash_mx;$i++){
						if(!$flash_flash_module[$listmodule_x[$i]] && $listmodule_x[$i]!='')$flash_flash_module[$listmodule_x[$i]]=$list;
					}
				}
			}else{
				$gz_flashimgall[]=$list;
				if($list['module']=='metinfo'){
					if(!$flash_img_module[$classnow])$flash_img_module[$classnow]=$list;
				}else{
					for($i=0;$i<$flash_mx;$i++){
						if((!$flash_img_module[$listmodule_x[$i]]) && $listmodule_x[$i]!='')$flash_img_module[$listmodule_x[$i]]=$list;
					}
				}
			}
		}
		if($gz_flasharray[$classnow]['type']==3){
			foreach($gz_flashall as $key=>$val){
				$val['nowmod']=','.$classnow.',';
				if($val['module']==$val['nowmod'])$flash_img_module[$classnow]=$val;
				$val['nowmod']=','.$superior.',';
				if($val['module']==$val['nowmod'])$flash_img_module[$classnow]=$val;
			}
		}
		if($gz_flasharray[$classnow]['type']==2){
			if(count($flash_flash_module[$classnow])==0){
				if($class3<>0){
					if($class2<>0&&count($flash_flash_module[$class2])<>0){
						$flash_nowarray=$flash_flash_module[$class2];
						$gz_flash_x=$gz_flasharray[$class2]['x'];
						$gz_flash_y=$gz_flasharray[$class2]['y'];
					}elseif($class1<>0&&count($flash_flash_module[$class1])<>0){
						$flash_nowarray=$flash_flash_module[$class1];
						$gz_flash_x=$gz_flasharray[$class1]['x'];
						$gz_flash_y=$gz_flasharray[$class1]['y'];
					}else{
						$flash_nowarray=$flash_flash_module[10000];
						$gz_flash_x=$gz_flasharray[10000]['x'];
						$gz_flash_y=$gz_flasharray[10000]['y'];
					}
				}elseif($class2<>0){
					if($class1<>0&&count($flash_flash_module[$class1])<>0){
						$flash_nowarray=$flash_flash_module[$class1];
						$gz_flash_x=$gz_flasharray[$class1]['x'];
						$gz_flash_y=$gz_flasharray[$class1]['y'];
					}else{
						$flash_nowarray=$flash_flash_module[10000];
						$gz_flash_x=$gz_flasharray[10000]['x'];
						$gz_flash_y=$gz_flasharray[10000]['y'];
					}
				}else{
					$flash_nowarray=$flash_flash_module[10000];
					$gz_flash_x=$gz_flasharray[10000]['x'];
					$gz_flash_y=$gz_flasharray[10000]['y'];
				}
			}else{
				$flash_nowarray=$flash_flash_module[$classnow];
				$gz_flash_x=$gz_flasharray[$classnow]['x'];
				$gz_flash_y=$gz_flasharray[$classnow]['y'];
			}

			if(count($flash_nowarray)<>0){
				$gz_flash_ok=1;
				$gz_flash_type=1;
				$gz_flash_url=$flash_nowarray['flash_path'];
				$gz_e_flash_url=$flash_nowarray['e_flash_path'];
				$gz_flash_back=$flash_nowarray['flash_back'];
				$gz_e_flash_back=$flash_nowarray['e_flash_back'];
			}
		}elseif($gz_flasharray[$classnow][type]==1){
			$gz_flash_ok=1;
			$gz_flash_type=0;
			foreach($gz_flashimgall as $key=>$val){
				if($val['img_path']!=""){
						$gz_flash_img=$gz_flash_img.$val['img_path']."|";
						$gz_flash_imglink=$gz_flash_imglink.$val['img_link']."|";
						$gz_flash_imgtitle=$gz_flash_imgtitle.$val['img_title']."|";
						$gz_flashimg[]=$val;
				}
			}
			$gz_flash_x=$gz_flasharray[$classnow]['x'];
			$gz_flash_y=$gz_flasharray[$classnow]['y'];
		}elseif($gz_flasharray[$classnow]['type']==3){
			if(count($flash_img_module[$classnow])){
				$flash_imgone_img=$flash_img_module[$classnow]['img_path'];
				$flash_imgone_url=$flash_img_module[$classnow]['img_link'];
				$flash_imgone_title=$flash_img_module[$classnow]['img_title'];
			}else{
				if($flash_imgone_img==""){
					$flash_imgone_img=$flash_img_module[$class2]['img_path'];
					$flash_imgone_url=$flash_img_module[$class2]['img_link'];
					$flash_imgone_title=$flash_img_module[$class2]['img_title'];
				}
				if($flash_imgone_img==""){
					$flash_imgone_img=$flash_img_module[$class1]['img_path'];
					$flash_imgone_url=$flash_img_module[$class1]['img_link'];
					$flash_imgone_title=$flash_img_module[$class1]['img_title'];
				}
				if($flash_imgone_img==""){
					$flash_imgone_img=$flash_img_module[10000]['img_path'];
					$flash_imgone_url=$flash_img_module[10000]['img_link'];
					$flash_imgone_title=$flash_img_module[10000]['img_title'];
				}
			}
		}elseif($gz_flasharray[$classnow]['type']==0){
			$gz_flash_ok=0;
		}
		$gz_flash_img=substr($gz_flash_img, 0, -1);
		$gz_flash_imglink=substr($gz_flash_imglink, 0, -1);
		$gz_flash_imgtitle=substr($gz_flash_imgtitle, 0, -1);
		$gz_flashurl=$gz_flash_imglink;
		$gz_flash_xpx=$gz_flash_x."px";
		$gz_flash_ypx=$gz_flash_y."px";
	}
/*模板设置预览*/
if($theme_preview&&$gz_theme_preview){
	$gz_flashimg = $classnow == 10001 ?$php_json['banner']['index']:($gz_bannerpagetype?$php_json['banner']['index']:$gz_flashimg);
	
	if($classnow != 10001 && $gz_bannerpagetype){
		$gz_flashimg_theme_preview = array();
		foreach($gz_flashimg as $key=>$val){
			$val['img_path']='../'.$val['img_path'];
			$gz_flashimg_theme_preview[$key] = $val;
		}
		$gz_flashimg = $gz_flashimg_theme_preview;
	}
	$gz_flash_img='';
	$gz_flash_imglink='';
	$gz_flash_imgtitle='';
	foreach($gz_flashimg as $key=>$val){
		if($val['img_path']!=""){
			$gz_flash_img=$gz_flash_img.$val['img_path']."|";
			$gz_flash_imglink=$gz_flash_imglink.$val['img_link']."|";
			$gz_flash_imgtitle=$gz_flash_imgtitle.$val['img_title']."|";
		}
	}
	$gz_flashall = $gz_flashimg;
	$gz_flash_img=substr($gz_flash_img, 0, -1);
	$gz_flash_imglink=substr($gz_flash_imglink, 0, -1);
	$gz_flash_imgtitle=substr($gz_flash_imgtitle, 0, -1);
	//wap_y
	$otherinfo = $php_json['otherinfo'];
}
	//$gz_flashimg
/*parameter*/
	if(!isset($dataoptimize[$pagemark]['parameter']))$dataoptimize[$pagemark]['parameter']=$dataoptimize[10000]['parameter'];
	if($dataoptimize[$pagemark]['parameter']||$search=='search'){
		$query = "SELECT * FROM $gz_parameter where module<6  and lang='$lang' order by no_order";
		$result = $db->query($query);
		while($list= $db->fetch_array($result)){
			$list['para']="para".$list['id'];
			$list['paraname']="para".$list['id']."name";
			$metpara[$list['id']]=$list;
			if(($list['class1']==0) or ($list['class1']==$class1 and $list['class2']==0 and $list['class3']==0) or ($list['class1']==$class1 and $list['class2']==$class2 and $list['class3']==0) or ($list['class1']==$class1 and $list['class2']==$class2 and $list['class3']==$class3) or $index=='index'){	
				switch($list['module']){
					case 3:
						$product_para[]=$list;
						$productpara[$list['type']][]=$list;
						$product_paralist[]=$list;
						/*2.0*/
						if($list[type]==1 or $list[type]==2)$product_para200[]=$list;
						if($list[type]==5)$product_paraimg[]=$list;
						if($list[type]==2)$product_paraselect[]=$list;
						/*2.0*/
						break;
					case 4:
						$download_para[]=$list;
						$downloadpara[$list['type']][]=$list;
						$download_paralist[]=$list;
						/*2.0*/
						if($list[type]==1)$download_para200[]=$list;
						/*2.0*/
						break;
					case 5:
						$img_para[]=$list;
						$imgpara[$list['type']][]=$list;
						$img_paralist[]=$list;
						/*2.0*/
						if($list[type]==1)$img_para200[]=$list;
						if($list[type]==5)$img_paraimg[]=$list;
						if($list[type]==2)$img_paraselect[]=$list;
						/*2.0.*/
						break;
				}
			}
		}
		$query = "SELECT * FROM $gz_list where lang='$lang' order by no_order";
		$result = $db->query($query);
		while($list= $db->fetch_array($result)){
			$para_select[$list['bigid']][]=$list;
		}
	}
	/*friendly link	*/
	if(!isset($dataoptimize[$pagemark]['link']))$dataoptimize[$pagemark]['link']=$dataoptimize[10000]['link'];
	if($dataoptimize[$pagemark]['link']){	
		$query = "SELECT * FROM $gz_link where show_ok='1' and lang='$lang' order by orderno desc";
		$result = $db->query($query);
		while($list= $db->fetch_array($result)){
		if($index=='index' && strstr($list['weblogo'],"../")){
		$linkweblogo=explode('../',$list['weblogo']);
		$list['weblogo']=$linkweblogo[1];
		}
		if($list['link_type']=="0"){
		if($list['com_ok']=="1")$link_text_com[]=$list;
		$link_text[]=$list;
		}
		if($list['link_type']=="1"){
		if($list['com_ok']=="1")$link_img_com[]=$list;
		$link_img[]=$list;
		}
		if($list['com_ok']=="1")$link_com[]=$list;
		$link[]=$list;
	}
	}
	if($gz_member_use and $metaccess){
		if($index!="index"){
$gz_js_access="<script type='text/javascript' id='metccde'>
var jsFile = document.createElement('script');
jsFile.setAttribute('type','text/javascript');
jsFile.setAttribute('src','../include/access.php?&metmemberforce={$metmemberforce}&metuser={$metuser}&lang={$lang}&metaccess={$metaccess}&random='+Math.random());
document.getElementsByTagName('head').item(0).appendChild(jsFile);
</script>";
			$query="select * from $gz_admin_array where id='$metaccess'";
			$metaccess=$db->get_one($query);
			if(intval($metinfo_member_type)<intval($metaccess)){
				gz_cooike_unset();
				change_gz_cookie('metinfo_member_name',$metinfo_member_name);
				change_gz_cookie('metinfo_member_pass',$metinfo_member_pass);
				change_gz_cookie('metinfo_member_type',$metinfo_member_type);
				change_gz_cookie('metinfo_admin_name',$metinfo_admin_name);
				save_gz_cookie();
				okinfo('../member/'.$member_index_url.'&referer='.urlencode(request_uri()),$lang_access);
			}
		}
	}
	$listimg['news']=$listnew['news'];
	$hitslistimg['news']=$hitslistnew['news'];
	$classlistimg['news']=$classlistnew['news'];
	$hitsclasslistimg['news']=$hitsclasslistnew['news'];

	if($class_list[$class_list[$classnow]['releclass']]['module']>5 and count($nav_list2[$class_list[$classnow]['releclass']])){
		$nav_list2[$class_list[$classnow]['releclass']][count($nav_list2[$class_list[$classnow]['releclass']])]=$class_list[$class_list[$classnow]['releclass']];
	}
	if($gz_img_style){
		switch($class_list[$classnow]['module']){
			case 2:
				$gz_img_x=$gz_newsimg_x?$gz_newsimg_x:$gz_img_x; 
				$gz_img_y=$gz_newsimg_y?$gz_newsimg_y:$gz_img_y;
				break;
			case 3:
				$gz_img_x=$gz_productimg_x?$gz_productimg_x:$gz_img_x; 
				$gz_img_y=$gz_productimg_y?$gz_productimg_y:$gz_img_y;
				break;
			case 5:
				$gz_img_x=$gz_imgs_x?$gz_imgs_x:$gz_img_x; 
				$gz_img_y=$gz_imgs_y?$gz_imgs_y:$gz_img_y;
				break;
		}
	}
	$navdown=$class1;
	echo $sidedwon2=$class2;
	echo 'dfsfasdfasd';exit;
	$sidedwon3=$class3;
	if($class_list[$classnow]['nav'] == 1 || $class_list[$classnow]['nav'] == 2)$sidedwon2=$classnow;
	if($class1 == 0 || $class_list[$class1]['na'] == 2 || $class_list[$class1][nav] == 0)$navdown="10001";
	if($class_list[$classnow]['nav'] == 1 || $class_list[$classnow]['nav'] == 3)$navdown=$classnow;
	if($class_list[$classnow]['nav'] == 0 || $class_list[$classnow]['nav'] == 2){
		if($class_list[$classnow]['releclass'])$navdown=$class_list[$classnow]['releclass'];
		$higher=$class_list[$classnow]['bigclass'];
		if($class_list[$higher]['releclass'])$navdown=$class_list[$higher]['releclass'];
		if($class_list[$higher]['nav']==1||$class_list[$higher]['nav']==3)$navdown=$higher;
	}
	if(!$navdown)$navdown=10001;
	if(!$sidedwon2)$sidedwon2=10001;
	if(!$sidedwon3)$sidedwon3=10001;
	$metblank=$gz_urlblank?"target='_blank'":"target='_self'";
	$onlinex=$gz_online_type<2?$gz_onlineleft_left:$gz_onlineright_right;
	$onliney=$gz_online_type<2?$gz_onlineleft_top:$gz_onlineright_top;
	/*站长统计*/
	$settings = parse_ini_file(ROOTPATH."config/webstat.inc.php");
	@extract($settings);
	if($gz_stat){
		$stat_d=$classnow.'-'.$id.'-'.$lang;
		$gz_stat_js='<script src="'.$navurl.'include/stat/stat.php?type=para&u='.$navurl.'&d='.$stat_d.'" type="text/javascript"></script>';
	}
	$class_index=imgxytype($class_index,'index_num');
	
	$product_para=$db->get_all("select * from $gz_parameter where module='3' and type!='3' and type!='5' and lang='$lang'");
	$navigation = $db->get_all("SELECT * FROM $gz_ifmember_left ");
	$thumb_src = $navurl.'include/thumb.php?';
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>