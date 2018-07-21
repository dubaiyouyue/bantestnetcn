<?php
//管理模块显示隐藏
define('IN_ADMIN_feedback', false);//反馈系统
define('IN_ADMIN_job', false);//招聘模块
define('IN_ADMIN_img', false);//图片模块
define('IN_ADMIN_download', false);//下载模块
define('IN_ADMIN_product', false);//产品模块


# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if($depth!=''&&$depth!='../'&&$depth!='../../'){die();}
if(!isset($depth))$depth='';
$commonpath=$depth.'include/common.inc.php';
$commonpath=$admin_index?$commonpath:'../'.$commonpath;
define('SQL_DETECT',1);
require_once $commonpath;
$turefile=$url_array[count($url_array)-2];
if($gz_adminfile!=$turefile&&$adminmodify!=1){
	$gz_adminfile=$turefile;
	$turefile=authcode($turefile,'ENCODE',$gz_webkeys);
	$query="update $gz_config set value='$turefile' where name='gz_adminfile' and lang='metinfo'";
	$db->query($query);
}
$login_name=daddslashes($login_name,0,1);
$metinfo_admin_name=daddslashes($metinfo_admin_name,0,1);
if($action=="login"){
	$metinfo_admin_name     = $login_name;
	$metinfo_admin_pass     = $login_pass;
	$metinfo_admin_pass=md5($metinfo_admin_pass);
	/*code*/
	if($gz_login_code==1){
		require_once $depth.'../include/captcha.class.php';
		$Captcha= new  Captcha();
		if(!$Captcha->CheckCode($code)){
			echo("<script type='text/javascript'>alert('$lang_logincodeerror');location.href='login.php?langset=$langset';</script>");
			exit;
		}
	}	
	$admincp_list = $db->get_one("SELECT * FROM $gz_admin_table WHERE admin_id='$metinfo_admin_name' and usertype='3' ");	
	if (!$admincp_list){
	    echo("<script type='text/javascript'> alert('{$lang_loginname}');location.href='login.php';</script>");
	    exit;
	}else if($admincp_list['admin_pass']!=$metinfo_admin_pass){
		echo("<script type='text/javascript'> alert('$lang_loginpass');location.href='login.php';</script>");
		exit;
	}else{
		login_gz_cookie($metinfo_admin_name);
		gz_cooike_start();		
		change_gz_cookie('metinfo_admin_name',$metinfo_admin_name);
		change_gz_cookie('metinfo_admin_pass',$metinfo_admin_pass);
		change_gz_cookie('metinfo_admin_id',$admincp_list['id']);
		change_gz_cookie('metinfo_admin_type',$admincp_list['usertype']);
		change_gz_cookie('metinfo_admin_pop',$admincp_list['admin_type']);
		change_gz_cookie('metinfo_admin_time',$m_now_time);
		change_gz_cookie('metinfo_admin_lang',$admincp_list['langok']);
		change_gz_cookie('metinfo_admin_shortcut',json_decode($admincp_list['admin_shortcut']));
		if($_GET[langset]!=''){
			$_GET[langset]=daddslashes($_GET[langset],0,1);
			change_gz_cookie('languser',$_GET[langset]);
			gz_setcookie("langset", $_GET[langset], 0, '/', false);
			save_gz_cookie();
		}
		save_gz_cookie();
		$query="update $gz_admin_table set 
		admin_modify_date='$m_now_date',
		admin_login=admin_login+1,
		admin_modify_ip='$m_user_ip'
		WHERE admin_id = '$metinfo_admin_name'";
		$db->query($query);
	}
	$adminlang=explode('-',$admincp_list[langok]);
	if($admincp_list[langok]<>'metinfo' and (!strstr($admincp_list[langok],"-".$gz_index_type."-")))$lang=$adminlang[1];
	$filejs = ROOTPATH_ADMIN.'include/metvar.js';
	$strlen = file_put_contents($filejs, $js);
	$metinfo_mobile=false;
	if($metinfo_mobile){
		Header("Location: ../index.php");
	}else{
		$flag=0;
		$re_urls=explode('?',$re_url);
		$re_urlss=explode('/',$re_urls[0]);
		foreach($re_urlss as $key=>$val){
			if($val==$gz_adminfile){
				$flag=1;
			}
			if($flag==1&&$val){
				$filedir.='/'.$val;
			}
		}
		if($re_url&&file_exists('../..'.$filedir)&&$filedir){
			if(!strstr($re_url, ".php")){
				$re_url .= "index.php?lang=".$lang;
			}
			Header("Location: {$re_url}");
			gz_setcookie("re_url",$re_url,time()-21600);
			exit;
		}else{
			if($re_url)gz_setcookie("re_url",$re_url,time()-21600);
			echo "<script type='text/javascript'> var nowurl=parent.location.href; var metlogin=(nowurl.split('login')).length-1; if(metlogin==0)window.parent.frames.location.href='../index.php?lang=$lang'; if(metlogin!=0)location.href='../index.php?lang=$lang';</script>";
		}	
	}
}else{
	if(!$metinfo_admin_name||!$metinfo_admin_pass){
		if($admin_index){
			gz_cooike_unset();
			gz_setcookie("re_url",$re_url,time()-21600);
			Header("Location: login/login.php");
		}else{
			if(!$re_url){
				$re_url=$_SERVER[HTTP_REFERER];
				$HTTP_REFERERs=explode('?',$_SERVER[HTTP_REFERER]);
				$admin_file_len1=strlen("/$gz_adminfile/");
				$admin_file_len2=strlen("/$gz_adminfile/index.php");
				if(strrev(substr(strrev($HTTP_REFERERs[0]),0,$admin_file_len1))=="/$gz_adminfile/"||strrev(substr(strrev($HTTP_REFERERs[0]),0,$admin_file_len2))=="/$gz_adminfile/index.php"||!$HTTP_REFERERs[0]){
					$re_url="http://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";
				}
			}
			if(!$_COOKIE[re_url]&&!strstr($re_url, "return.php"))gz_setcookie("re_url",$re_url,time()+21600);
			gz_cooike_unset();
			Header("Location: ".$depth."../login/login.php");
		}
		exit;
	}else{
		$admincp_ok = $db->get_one("SELECT * FROM $gz_admin_table WHERE admin_id='$metinfo_admin_name' and admin_pass='$metinfo_admin_pass' and usertype='3'");
		if(!$admincp_ok){
			if($admin_index){
				gz_cooike_unset();
				gz_setcookie("re_url",$re_url,time()-21600);
				Header("Location: login/login.php");
			}else{
				if(!$re_url){
					$re_url=$_SERVER[HTTP_REFERER];
					$HTTP_REFERERs=explode('?',$_SERVER[HTTP_REFERER]);
					$admin_file_len1=strlen("/$gz_adminfile/");
					$admin_file_len2=strlen("/$gz_adminfile/index.php");
					if(strrev(substr(strrev($HTTP_REFERERs[0]),0,$admin_file_len1))=="/$gz_adminfile/"||strrev(substr(strrev($HTTP_REFERERs[0]),0,$admin_file_len2))=="/$gz_adminfile/index.php"||!$HTTP_REFERERs[0]){
						$re_url="http://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";
					}
				}
				if(!strstr($re_url, "return.php")){
				if(!$_COOKIE[re_url])gz_setcookie("re_url",$re_url,time()+21600);
				}
				gz_cooike_unset();
				Header("Location: ".$depth."../login/login.php");
			}
			exit;
		}
		/*power start*/
		if(ADMIN_POWER!="metinfo"){
			if(!strstr($admincp_ok[admin_op], "metinfo")){
				if(strstr($_SERVER['REQUEST_URI'], "delete.php")){
					if(!strstr($admincp_ok[admin_op], "del"))okinfo('javascript:window.history.back();',$lang_logindelete);
				}
				if(strstr($_SERVER['REQUEST_URI'], "changeState.php")){
					if(!strstr($admincp_ok[admin_op], "editor"))okinfo('javascript:window.history.back();',$lang_loginedit);
				}
				if(strstr($_SERVER['REQUEST_URI'], "/htm.php")){
					if(!strstr($admincp_ok[admin_op], "editor"))okinfo('javascript:window.history.back();',$lang_loginedit);
				}
				switch($action){
					case "add";
						if(!strstr($_SERVER['REQUEST_URI'], "/content.php")){
						if(!strstr($admincp_ok[admin_op], "add"))okinfo('javascript:window.history.back();',$lang_loginadd);
						}
						break;
					case "editor";
						if(!strstr($_SERVER['REQUEST_URI'], "/content.php")){
						if(!strstr($admincp_ok[admin_op], "editor"))okinfo('javascript:window.history.back();',$lang_loginedit);
						}
						break;
					case "modify";
						if(!strstr($admincp_ok[admin_op], "editor"))okinfo('javascript:window.history.back();',$lang_loginedit);
						break;
					case "Modify";
						if(!strstr($admincp_ok[admin_op], "editor"))okinfo('javascript:window.history.back();',$lang_loginedit);
						break;
					case "del";
						if(!strstr($admincp_ok[admin_op], "del"))okinfo('javascript:window.history.back();',$lang_logindelete);
						break;
					case "delete";
						if(!strstr($admincp_ok[admin_op], "del"))okinfo('javascript:window.history.back();',$lang_logindelete);
						break;
				}
				if(!strstr($_SERVER['REQUEST_URI'], "olupdate.php")){					
					if(($admincp_ok[admin_op]=='---' or $admincp_ok[admin_op]=='') and $action<>'' and $action<>'list' and !$action_ajax and (!strstr($_SERVER['REQUEST_URI'], "/content.php")) )okinfo('javascript:window.history.back();',$lang_loginall);
			    	}			    	
			}
			if(strstr($_SERVER['REQUEST_URI'], "olupdate.php")&&strpos($gz_host, 'api.resonance.com.cn')){
				$first=strpos($gz_host, '/');
				$first=$first?$first+1:0;
				$gz_host=substr($gz_host,$first);
			}
		}
		$adminlang=explode('-',$admincp_ok[langok]);
		if($depth){
			$depth1='../'.$depth;
		}
		$jurisdiction_url = $depth1.'index.php?lang='.$adminlang[1];
		if(!strstr($_SERVER['REQUEST_URI'], "include/turnover.php")){
			if(!strstr($_SERVER['REQUEST_URI'], "login_out.php")){
				if($admincp_ok[langok]<>'metinfo' and (!strstr($admincp_ok[langok],$lang)))okinfo($jurisdiction_url,$lang_loginalllang);
			}
		}		/*power end*/
	}
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>
