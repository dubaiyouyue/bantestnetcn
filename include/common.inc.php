<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
if(@file_exists('../app/app/shop/include/product.class.php') && @$cmodule){
	require_once '../app/app/shop/include/product.class.php';
	if($gotonew == 1){
		@define('M_NAME', 'shop');
		@define('M_MODULE', 'web');
		@define('M_CLASS', @$cmodule);
		@define('M_ACTION', 'doindex');
		require_once '../app/system/entrance.php';
		die();
	}
}
header("Content-type: text/html;charset=utf-8");
error_reporting(E_ERROR | E_PARSE);
@set_time_limit(0);
$HeaderTime=time();
define('ROOTPATH', substr(dirname(__FILE__), 0, -7));
PHP_VERSION >= '5.1' && date_default_timezone_set('Asia/Shanghai');
session_cache_limiter('private, must-revalidate'); 
@ini_set('session.auto_start',0); 
if(PHP_VERSION < '4.1.0') {
	$_GET         = &$HTTP_GET_VARS;
	$_POST        = &$HTTP_POST_VARS;
	$_COOKIE      = &$HTTP_COOKIE_VARS;
	$_SERVER      = &$HTTP_SERVER_VARS;
	$_ENV         = &$HTTP_ENV_VARS;
	$_FILES       = &$HTTP_POST_FILES;
}
require_once ROOTPATH.'include/mysql_class.php';
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
isset($_REQUEST['GLOBALS']) && exit('Access Error');
require_once ROOTPATH.'include/global.func.php';
foreach(array('_COOKIE', '_POST', '_GET') as $_request) {
	foreach($$_request as $_key => $_value) {
		$_key{0} != '_' && $$_key = daddslashes($_value,0,0,1);
		$_M['form'][$_key] = daddslashes($_value,0,0,1);
	}
}
$gz_cookie=array();
$settings=array();
$db_settings=array();
$db_settings = parse_ini_file(ROOTPATH.'config/config_db.php');
@extract($db_settings);
$db = new dbmysql();
$db->dbconn($con_db_host,$con_db_id,$con_db_pass,$con_db_name);
$query="select * from {$tablepre}config where name='gz_tablename' and lang='metinfo'";
$mettable=$db->get_one($query);
$mettables=explode('|',$mettable[value]);
foreach($mettables as $key=>$val){
	$tablename='gz_'.$val;	
	$$tablename=$tablepre.$val;
	$_M['table'][$val] = $tablepre.$val;
}
require_once ROOTPATH.'include/cache.func.php';
require_once ROOTPATH.'config/config.inc.php';
gz_cooike_start();
$metmemberforce==$gz_member_force;
if($metmemberforce==$gz_member_force){
	change_gz_cookie('metinfo_member_name',"force");
	change_gz_cookie('metinfo_member_pass',"force");
	change_gz_cookie('metinfo_member_type',"256");
	save_gz_cookie();
}
if($gz_member_use!=0){
	$metinfo_member_id     =(get_gz_cookie('metinfo_admin_id')=="")?get_gz_cookie('metinfo_member_id'):get_gz_cookie('metinfo_admin_id');
	$metinfo_member_name     =(get_gz_cookie('metinfo_admin_name')=="")?get_gz_cookie('metinfo_member_name'):get_gz_cookie('metinfo_admin_name');
	$metinfo_member_pass     =(get_gz_cookie('metinfo_admin_pass')=="")?get_gz_cookie('metinfo_member_pass'):get_gz_cookie('metinfo_admin_pass');
	$metinfo_member_type     =(get_gz_cookie('metinfo_admin_type')=="")?get_gz_cookie('metinfo_member_type'):'256';
	$metinfo_admin_name      =get_gz_cookie('metinfo_admin_name');
	if($metinfo_member_name=='' or  $metinfo_member_pass=='')$metinfo_member_type=0;
}else{
	$metinfo_member_type="256";
}
(!MAGIC_QUOTES_GPC) && $_FILES = daddslashes($_FILES);
$REQUEST_URI  = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
$t_array = explode(' ',microtime());
$P_S_T	 = $t_array[0] + $t_array[1];
$gz_obstart == 1 && function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') :ob_start();
ob_start();
$referer?$forward=$referer:$forward=$_SERVER['HTTP_REFERER'];
$m_now_time     = time();
$m_now_date     = date('Y-m-d H:i:s',$m_now_time);
$m_now_counter  = date('Ymd',$m_now_time);
$m_now_month    = date('Ym',$m_now_time);
$m_now_year     = date('Y',$m_now_time);
$m_user_agent   =  $_SERVER['HTTP_USER_AGENT'];
if($_SERVER['HTTP_X_FORWARDED_FOR']){
	$m_user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif($_SERVER['HTTP_CLIENT_IP']){
	$m_user_ip = $_SERVER['HTTP_CLIENT_IP'];
} else{
	$m_user_ip = $_SERVER['REMOTE_ADDR'];
}
$m_user_ip  = preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$m_user_ip) ? $m_user_ip : $_SERVER['REMOTE_ADDR'];
$m_user_ip  = preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$m_user_ip) ? $m_user_ip : 'Unknown';
$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$mobilesql="";
if(file_exists(ROOTPATH.'include/mobile.php')&&$gz_wap&&trim(file_get_contents(ROOTPATH.'include/mobile.php'))!='metinfo'){
require_once ROOTPATH.'include/mobile.php';
}else{
if($index=='index'&&$gz_wap)wapjump();
}
require_once ROOTPATH.'include/lang.php';
$index_url=$gz_index_url[$lang];
if($gz_mobileok&&$gz_wap_url){
$index_url=$gz_wap_url;
}
$gz_chtmtype=".".$gz_htmtype;
if($gz_webhtm != 0){//判断是否开启静态
	$gz_htmtype=($lang==$gz_index_type)?".".$gz_htmtype:"_".$lang.".".$gz_htmtype;
}else{
	$gz_htmtype = ".".$gz_htmtype;
}
$langmark='lang='.$lang;
switch($gz_title_type){
    case 0:
		$webtitle = '';
		break;
    case 1:
		$webtitle = $gz_keywords;
		break;
	case 2:
		$webtitle = $gz_webname;
		break;
	case 3:
		$webtitle = $gz_keywords.'-'.$gz_webname;
}
$gz_title=$webtitle;
if($index=='index'){
$gz_title=$gz_webname?($gz_keywords?$gz_keywords.'-'.$gz_webname:$gz_webname):$gz_keywords;
$gz_title=$gz_hometitle!=''?$gz_hometitle:$gz_title;
}

$member_index_url="index.php?lang=".$lang;
$member_register_url="register_include.php?lang=".$lang;
//接口
if($_M['plugin']['doweb']){
	define('IN_MET', true);
	if(file_exists(ROOTPATH.'app/system/include/class/mysql.class.php')){
		require_once ROOTPATH.'app/system/include/class/mysql.class.php';
		$db_settings = array();
		$db_settings = parse_ini_file(ROOTPATH.'config/config_db.php');
		@extract($db_settings);
		DB::dbconn($con_db_host, $con_db_id, $con_db_pass, $con_db_name);
		foreach($_M['plugin']['doweb'] as $key => $val){
				$applistfile=ROOTPATH.'app/app/'.$val.'/plugin/'.'plugin_'.$val.'.class.php';
				$_M['url']['own'] = $_M['url']['site'].'app/app/'.$val.'/';
				if(file_exists($applistfile)&&!is_dir($applistfile)&&((file_get_contents($applistfile))!='metinfo')){
					require_once $applistfile;
					$app_plugin_name=str_replace('.class.php', '', 'plugin_'.$val);
					if (class_exists($app_plugin_name)) {
						$newclass=new $app_plugin_name;
						if(method_exists($newclass, 'doweb')){
							call_user_func(array($newclass,  'doweb'));
						}
					}
					
				}
		}
		$_M['url']['own'] = '';
		DB::close();
	}
}
//结束
if($gz_oline!=1){
	$file_site = explode('|',$app_file[1]);
	foreach($file_site as $keyfile=>$valflie){
		if(file_exists(ROOTPATH."$gz_adminfile".$valflie)&&!is_dir(ROOTPATH."$gz_adminfile".$valflie)&&((file_get_contents(ROOTPATH."$gz_adminfile".$valflie))!='metinfo')){require_once ROOTPATH."$gz_adminfile".$valflie;}
	}
}
include_once ROOTPATH.$gz_adminfile.'/app/wap/wapjs.php';
if (!$search && !$action){jump_pseudo();}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>