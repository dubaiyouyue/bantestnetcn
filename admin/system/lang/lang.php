<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
require_once 'lang.func.php';
if($addlang==1){
	header("location:lang.php?anyid=10&langaction=add&lang=cn&cs=1");
	gz_setcookie("addlang",0,time()-3600,'/');
	die();
}
if($action=="modify"){
	$lancount=count($gz_langok);
	$thisurl = 'lang.php?lang='.$lang;
	if($langmark=='metinfo')metsave('-1',$lang_langadderr1,$depth);
	$langmark=trim($langmark);
	$langorder=trim($langorder);
	$langoname=trim($langname);
	$langoflag=trim($langflag);
	$langolink=trim($langlink);
	$langlink = ereg_replace(" ","",$langlink);
	if($langlink!=''){
	if(!strstr($langlink,"http://"))$langlink="http://".$langlink;
	}
	switch($langsetaction){
		case 'set':  
			require_once $depth.'../include/config.php';
		break;
		case 'add':
			if($langname=='')metsave('-1',$lang_langnamenull,$depth);
			if($langautor!='')$langmark=$langautor;
			if($langautor!='')$synchronous=$langautor;
			if(!$langdlok)$synchronous='';
			$lancount=count($gz_langok);
			$isaddlang=1;
			$gz_langok[0]=array(
							'name'		=>$langname,
							'useok'		=>$languseok,
							'order'		=>$langorder,
							'mark'		=>$langmark,
							'flag'		=>$langflag,
							'link'		=>$langlink,
							'newwindows'=>$langnewwindows);
			foreach($gz_langok as $key=>$val){
				if($key){
					if($langmark==$val['mark'])metsave('-1',$lang_langnamerepeat,$depth);
					if($val['order'] == $langorder)metsave('-1',$lang_langnameorder,$depth);
				}
			}
			$gz_webhtm =$gz_langok[$langfile]['gz_webhtm'];
			$gz_htmtype=$gz_langok[$langfile]['gz_htmtype'];
			$gz_weburl =$gz_langok[$langfile]['gz_weburl'];
			$re=copyconfig();
			if($re!=1){
				$langdlok=0;
				$langfile=$gz_index_type;
				copyconfig();
				$retxt=$lang_jsok.'<br/>'.$lang_langadderr6;
			}
			$query = "INSERT INTO $gz_lang SET
				name          = '$langname',
				useok         = '$languseok',
				no_order      = '$langorder',
				mark          = '$langmark',
				synchronous   = '$synchronous',
				flag          = '$langflag',
				link          = '$langlink',
				newwindows    = '$langnewwindows',
				gz_webhtm    = '$gz_webhtm',
				gz_htmtype   = '$gz_htmtype',
				gz_weburl    = '$gz_weburl',
				lang          = '$langmark'
			";
			$db->query($query);
			$query="INSERT INTO $gz_admin_array set array_name='$lang_access1',admin_type='',admin_ok='0',admin_op='',admin_issueok='0',admin_group='0',user_webpower='1',array_type='1',lang='$langmark',langok=''";
			$db->query($query);
			$query="INSERT INTO $gz_admin_array set array_name='$lang_access2',admin_type='',admin_ok='0',admin_op='',admin_issueok='0',admin_group='0',user_webpower='2',array_type='1',lang='$langmark',langok=''";
			$db->query($query);
			if($gz_index_type1){
				if($languseok){
					$gz_index_type=$langmark;
					require_once $depth.'../include/config.php';
				}else{
					$retxt=$retxt?$retxt.'<br/>'.$lang_langexplain12:$lang_jsok.$lang_langexplain12;
				}
			}
			unlink(ROOTPATH.'cache/lang_json_'.$lang.'.php');
		break;
		case 'edit':
			if($langname=='')metsave('-1',$lang_langnamenull,$depth);
			$gz_langok[$langmark]=array(
									'name'	=>$langname,
									'useok'	=>$languseok,
									'order'	=>$langorder,
									'mark'	=>$langmark,
									'flag'	=>$langflag,
									'link'	=>$langlink,
									'newwindows'=>$langnewwindows);
			$i=0;
			$useoknow=0;
			foreach($gz_langok as $key=>$val){
				$i++;
				if($val['mark']!=$langmark && $val['order'] == $langorder)metsave('-1',$lang_langnameorder,$depth);
				if($val['useok']==1)$useoknow++;
			}
			if($useoknow==0&&$languseok==0)metsave('-1',$lang_langclose1,$depth);
			if($gz_index_type==$langmark&&$languseok==0)metsave('-1',$lang_langclose2,$depth);
			$query = "update $gz_lang SET
				name          = '$langname',
				useok         = '$languseok',
				no_order      = '$langorder',
				mark          = '$langmark',
				synchronous   = '$synchronous',
				flag          = '$langflag',
				link          = '$langlink',
				newwindows    = '$langnewwindows'
			    where lang='$langmark'";
			$db->query($query);
			if($gz_index_type1){
				if($languseok){
					$gz_index_type=$langmark;
					require_once $depth.'../include/config.php';
				}else{
					$retxt=$lang_jsok.$lang_langexplain12;
				}
			}
			unlink(ROOTPATH.'cache/lang_json_'.$lang.'.php');
		break;
		case 'delete':
			if(count($gz_langok)==1)metsave('-1',$lang_langone,$depth);
			if($langeditor==$lang)metsave('-1',$lang_langadderr2,$depth);
			if($langeditor==$gz_index_type)metsave('-1',$lang_langadderr5,$depth);
			$query = "delete from $gz_language where site='0' and app='0' and lang='$langeditor'";
			$db->query($query);
			$query = "delete from $gz_config where lang='$langeditor'";
			$db->query($query);
			$query = "delete from $gz_templates where lang='$langeditor' and no='$gz_skin_user'";
			$db->query($query);
			//if(file_exists($depth."../../templates/".$gz_skin_user."/lang/language_".$langeditor.".ini"))@unlink($depth."../../templates/".$gz_skin_user."/lang/language_".$langeditor.".ini");
			
			
			$query = "select * from $gz_column where lang='$langeditor'";
			$result = $db->query($query);
			while($list = $db->fetch_array($result)){
				delcolumn($list);
			}
			$query = "delete from $gz_lang where lang='$langeditor'";
			$result = $db->query($query);
			$query = "delete from $gz_admin_array where lang='$langeditor'";
			$db->query($query);
			$query = "delete from $gz_admin_table where lang='$langeditor'";
			$db->query($query);
		break;
		case 'addadmin':
			if($langname=="")metsave('-1',$lang_langnamenull,$depth);
			$gz_langadmin[0]=array(
							'name'	=>$langname,
							'useok'	=>$languseok,
							'order'	=>$langorder,
							'mark'	=>$langmark);
			foreach($gz_langadmin as $key=>$val){
				if($key){
					if($langmark==$val['mark'])metsave('-1',$lang_langnamerepeat,$depth);
					if($val['order'] == $langorder)metsave('-1',$lang_langnameorder,$depth);
				}
			}
			$query = "INSERT INTO $gz_lang SET
				name          = '$langname',
				useok         = '$languseok',
				no_order      = '$langorder',
				mark          = '$langmark',
				synchronous   = '$synchronous',
				lang          = 'metinfo'
			";
			$db->query($query);
			$query="select * from $gz_language where site='1' and app='0' and lang='$langfile'";
			$languages=$db->get_all($query);
			foreach($languages as $key=>$val){
				$val[value] = str_replace("'","''",$val[value]);
				$val[value] = str_replace("\\","\\\\",$val[value]);
				$query = "insert into $gz_language set name='$val[name]',value='$val[value]',site='1',no_order='$val[no_order]',array='$val[array]',lang='$langmark'";
				$db->query($query);
			}
			if($synchronous){
				$post=array('newlangmark'=>$synchronous,'metcms_v'=>$metcms_v,'newlangtype'=>'admin');
				$file_basicname=$depth.'../update/lang/lang_'.$synchronous.'.ini';
				$re=syn_lang($post,$file_basicname,$langmark,1,0);
				unlink('../../../cache/langadmin_'.$langmark.'.php');
			}
			if($gz_admin_type1){
				if($languseok){
					$gz_admin_type=$langmark;
					require_once $depth.'../include/config.php';
				}else{
					$retxt=$lang_jsok.$lang_langexplain12;
				}
			}
		break;
		case 'editadmin':
			if($langname=="")metsave('-1',$lang_langnamenull,$depth);
			$gz_langadmin[$langmark]=array('name'=>$langname,'useok'=>$languseok,'order'=>$langorder,'mark'=>$langmark);
			$i=0;
			foreach($gz_langadmin as $key=>$val){
			$i++;
				if($val['mark']!=$langmark && $val['order'] == $langorder)metsave('-1',$lang_langnameorder,$depth);
			}
			$query = "update $gz_lang SET
				name          = '$langname',
				useok         = '$languseok',
				no_order      = '$langorder',
				mark          = '$langmark',
				synchronous   = '$synchronous'
			    where lang='metinfo' and mark='$langmark'";
			$db->query($query);
			if($gz_admin_type1){
				if($languseok){
					$gz_admin_type=$langmark;
					require_once $depth.'../include/config.php';
				}else{
					$retxt=$lang_jsok.$lang_langexplain12;
				}
			}
		break;
		case 'deleteadmin':
			if(count($gz_langadmin)==1)metsave('-1',$lang_langone,$depth);
			$query = "delete from $gz_language where site='1' and lang='$langeditor'";
			$result = $db->query($query);
			$query = "delete from $gz_lang where lang='metinfo' and mark='$langeditor'";
			$result = $db->query($query);	
		break;
	}
	unlink('../../../cache/lang_'.$langeditor.'.php');
	unlink('../../../cache/lang_'.$langmark.'.php');
	$prent=$langsetaction=='add'&&$lancount==1?2:'';
	$txt=$isaddlang?$lang_langadderr3:'';
	if($retxt)$txt=$retxt;
	if($langsetaction == 'delete' || $langsetaction == 'add'){
	echo "<script language=JavaScript>
			window.location.href='../lang/lang.php?anyid={$anyid}&lang={$lang}&cs=1&turnovertext={$lang_jsok}'; 
		 </script> ";	
	}else{
		metsave('../system/lang/lang.php?anyid='.$anyid.'&lang='.$lang.'&cs='.$cs,$txt,$depth,'','',$prent);
	}
}elseif($action=='flag'){
    $dir = $depth.'../../public/images/flag';
    $handle = opendir($dir);
    while(false !== $file=(readdir($handle))){
        if($file !== '.' && $file != '..'){
		    $flags[] = $file;
		}
	}
    closedir($handle);
	$k=count($flags);
	for($i=0;$i<$k;$i++){
	    $data.='<img src="'.$dir.'/'.$flags[$i].'" />';
	}
    echo $data;
}elseif($action=='syn'){
	$post=array('newlangmark'=>$syn,'metcms_v'=>$metcms_v,'newlangtype'=>$newlangtype);
	$site=$newlangtype=='admin'?1:0;
	$file_basicname=$depth.'../update/lang/lang_'.$syn.'.ini';
	$re=syn_lang($post,$file_basicname,$nowmark,$site,0);
	if($site==0)unlink('../../../cache/lang_'.$nowmark.'.php');
	if($site==1)unlink('../../../cache/langadmin_'.$nowmark.'.php');
	if($re==1){
		metsave('../system/lang/lang.php?anyid='.$anyid.'&lang='.$lang.'&cs='.$cs,$lang_success,$depth);
	}else{
		metsave('../system/lang/lang.php?anyid='.$anyid.'&lang='.$lang.'&cs='.$cs,$lang_langadderr4.dlerror($re),$depth);
	}
}else{
	$cs=isset($cs)?$cs:3;
	$listclass[$cs]='class="now"';
	if($cs==3&&$langadminok!="metinfo"){
		header('location:lang.php?lang='.$lang.'&anyid='.$anyid.'&cs=1');
	}
	
	if($gz_admin_type_ok==1)$gz_admin_type_yes="checked";
	if($gz_admin_type_ok==0)$gz_admin_type_no="checked";
	if($gz_lang_mark==1)$gz_lang_mark_yes="checked";
	if($gz_lang_mark==0)$gz_lang_mark_no="checked";
	if($gz_ch_lang==1)$gz_ch_lang1="checked";
	if($gz_ch_lang==0)$gz_ch_lang2="checked";
	$css_url=$depth."../templates/".$gz_skin."/css";
	$img_url=$depth."../templates/".$gz_skin."/images";
	include template('system/lang/lang');
	footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>