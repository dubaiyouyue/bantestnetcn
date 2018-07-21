<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

//表单提交
foreach($_M['form'] as $key => $val){
	$k="{$key}";
	$$k=$val;
	
}

//flash兼容
global $methtml_flash,$gz_flasharray,$classnow,$gz_flashimg,$navurl;

//设置左边和中间内容页面显示的页面
$control['content']=$_M['custom_template']['content'];
$control['left']=$_M['custom_template']['left'];
if(substr($control['content'],0,4)!='own/'){
	$control['content']='own/'.$control['content'];
}
if($control['left'] > 1){
	$is_memberleft = 1;
}
//获取当前应用栏目信息
$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$PHP_SELFs = explode('/', $PHP_SELF);
$query = "SELECT * FROM {$_M['table'][column]} where module!=0 and foldername = '{$PHP_SELFs[count($PHP_SELFs)-2]}' and lang='{$_M['lang']}'";
$column = DB::get_one($query);
$gz_module =  $column['module'];
if($gz_module > 1000){
	//设置SEO参数
	switch($_M['config']['gz_title_type']){
		case 0:
			$webtitle = '';
			break;
		case 1:
			$webtitle = $_M['config']['gz_keywords'];
			break;
		case 2:
			$webtitle = $_M['config']['gz_webname'];
			break;
		case 3:
			$webtitle = $_M['config']['gz_keywords'].'-'.$_M['config']['gz_webname'];
	}
	$gz_title = $webtitle;

	$gz_title = $gz_title?$column['name'].'-'.$gz_title:$column['name'];
	$gz_title = $column['ctitle'] ? $column['ctitle'] : $gz_title;
	$show['description']=$column['description']?$column['description']:$_M['config']['gz_description'];
	$show['keywords']=$column['keywords']?$column['keywords']:$_M['config']['gz_keywords'];
		
	$gz_module =  $column['module'];

	$classnow = $column['id'];
	$class1 = $column['id'];
	if($column['releclass']){
		$class1 = $column['bigclass'];
	}
}else{
	if(!$class1 && !$class2 && !$class3 && !$metid){
		//$classnow = $column['id'];
		$class1 = $column['id'];
		if($column['releclass']){
			$class1 = $column['bigclass'];
		}		
	}
	
}
//设置网站根
define('ROOTPATH', PATH_WEB);
function is_letf_exists($left){
	global $_M;
	//$left = array('sidebar');
	$file = PATH_TEM.$left;
	if(file_exists($file.'.php')||file_exists($file.'.html')){
		return true;
	}
	return false;
}
//把$_M数组,DB转换成旧系统变量写法
foreach($_M['config'] as $key => $val){
	$$key=$val;
}
foreach($_M['table'] as $key => $val){
	$k="gz_{$key}";
	$$k=$val;
}
foreach($_M['word'] as $key => $val){
	$k="lang_{$key}";
	$$k=$val;
}

$lang=$_M['lang'];

$db = new DB();

//global $index_url,$lang_home,$nav_list,$nav_list2,$nav_list3,$navdown,$lang;

//页面模板参数设置
$gz_chtmtype=".".$gz_htmtype;
$gz_htmtype=($lang==$gz_index_type)?".".$gz_htmtype:"_".$lang.".".$gz_htmtype;
$langmark='lang='.$_M['lang'];

$gz_langadmin=$_M['langlist']['admin'];

$gz_langok=$_M['langlist']['web'];

$index_url=$_M['langlist']['web'][$_M['lang']]['gz_weburl'];

$m_now_year = date('Y');

$member_index_url="index.php?lang=".$lang;
$member_register_url="register_include.php?lang=".$lang;

//2.0
$index_c_url=$gz_index_url[cn];
$index_e_url=$gz_index_url[en];
$index_o_url=$gz_index_url[other];

//2.0
$searchurl           =$gz_weburl."search/search.php?lang=".$lang;
$file_basicname      =PATH_WEB."lang/language_".$lang.".ini";
$file_name           =PATH_WEB."templates/".$gz_skin_user."/lang/language_".$lang.".ini";
$str="";
//
//语言数组设置
foreach($gz_langok as $key=>$val){
	$indexmark=($val[mark]==$gz_index_type)?"index.":"index_".$val[mark].".";
	$val[gz_weburl]=$val[gz_weburl]<>""?$val[gz_weburl]:$gz_weburl;
	$val[gz_htmtype]=$val[gz_htmtype]<>""?$val[gz_htmtype]:$gz_htmtype;
	if($val[useok]){
		$gz_index_url[$val[mark]]=$val[gz_webhtm]?$val[gz_weburl].$indexmark.$val[gz_htmtype]:$val[gz_weburl]."index.php?lang=".$val[mark];
		if($val[gz_webhtm]==3)$gz_index_url[$val['mark']] = $val['gz_weburl'].'index-'.$val['mark'].'.html';
		if($htmpack){
			$navurls = $index=='index'?'':'../';
			$gz_index_url[$val['mark']]=$navurls.$indexmark.$val['gz_htmtype'];
		}
		if($val[mark]==$gz_index_type)$gz_index_url[$val[mark]]=$val[gz_weburl];
		if($htmpack && $val[mark]==$gz_index_type){
			$gz_index_url[$val[mark]]=$navurls;
		}
		if($val[link]!="")$gz_index_url[$val[mark]]=$val[link];
		if(!strstr($val[flag], 'http://')){
			$navurls = $index=='index'?'':'../';
			if($index=="index"&&strstr($val[flag], '../')){
				$gz_langlogoarray=explode("../",$val[flag]);
				$val[flag]=$gz_langlogoarray[1];
			}
			if(!strstr($val[flag], 'http://')&&!strstr($val[flag], 'public/images/flag/'))$val[flag]=$navurls.'public/images/flag/'.$val[flag];
		}
		$gz_langok[$val[mark]]=$val;
	}
}

$tmpincfile=PATH_WEB."templates/{$_M[config][gz_skin_user]}/metinfo.inc.php";
require $tmpincfile;
//flash设置数组
$gz_flasharray = $_M['flashset'];
$m_now_time     = time();
$m_now_date     = date('Y-m-d H:i:s',$m_now_time);
$m_now_counter  = date('Ymd',$m_now_time);
$m_now_month    = date('Ym',$m_now_time);
$m_now_year     = date('Y',$m_now_time);
//公用数据处理文件与模板标签文件处理
if($gz_module && $gz_module > 1000){
	require_once PATH_WEB.'include/head.php';
}

//把上面赋值的变量与数组转成全局数组
$vars2=array_keys(get_defined_vars());
$a2=get_defined_vars();
foreach($vars2 as $key => $val){
	global $$val;
	$$val=$a2[$val];
}
//dump($_M['form']);
//echo $metid;
if($gz_module && $gz_module < 1000){
	if(isset($murlid)){
		require_once PATH_WEB.'include/htmlurl.php';
	}
	if($metid){
		global $filpy,$fmodule,$cmodule;
		require PATH_WEB."include/module.php";
	}
	if($gz_module == 3){
		if(M_CLASS == 'product_show'){
			$mdname = 'product';
			$showname = 'showproduct';
			$dbname = $gz_product;
			$listnum = $gz_product_list;
			$imgproduct = 'product';
			require_once PATH_WEB.'/include/global/showmod.php';
			$product = $news;
			$product_list_new  = $md_list_new;
			$product_class_new = $md_class_new;
			$product_list_com  = $md_list_com;
			$product_class_com = $md_class_com;
			$product_class     = $md_class;
			$product_list      = $md_list;
			require_once PATH_WEB.'public/php/producthtml.inc.php';
		}else{
			$mdname = 'product';
			$showname = 'showproduct';
			$dbname = $gz_product;
			$dbname_list = $gz_product_list;
			$mdmendy = 1;
			$imgproduct = 'product';
			$class1re = '';
			require_once PATH_WEB."include/global/listmod.php";
			$product_listnow = $modlistnow;
			$product_list_new  = $md_list_new;
			$product_class_new = $md_class_new;
			$product_list_com  = $md_list_com;
			$product_class_com = $md_class_com;
			$product_class     = $md_class;
			$product_list      = $md_list;
			require_once PATH_WEB.'public/php/producthtml.inc.php';
		}

	}
}
require_once PATH_WEB."public/php/methtml.inc.php";
if(!function_exists('rgb2hex')){
	require_once PATH_WEB."public/php/waphtml.inc.php";
	function toHex($N) {
		if ($N==NULL) return "00";
		if ($N==0) return "00";
		$N=max(0,$N);
		$N=min($N,255);
		$N=round($N);
		$string = "0123456789ABCDEF";
		$val = (($N-$N%16)/16);
		$s1 = $string{$val};
		$val = ($N%16);
		$s2 = $string{$val};
		return $s1.$s2;
	}

	function rgb2hex($r,$g,$b){
		return toHex($r).toHex($g).toHex($b);
	}

	function hex2rgb($N){
		$dou = str_split($N,2);
		return array(
			"R" => hexdec($dou[0]),
			"G" => hexdec($dou[1]),
			"B" => hexdec($dou[2])
		);
	}
}
//页面内容区块顶部导航处理，左侧导航调用系统时候生效，自定义无效。
if($gz_module && $gz_module > 1000){
	if($class_list[$classnow]['releclass']){
		$pre_class = $class_list[$classnow]['bigclass'];
		//dump($class_list[$classnow]);
		if($class_list[$pre_class][new_windows] == 0)$class_list[$pre_class][new_windows] = '_self';
		$nav_x[name]="<a href=\"{$class_list[$pre_class][url]}\" target=\"{$class_list[$pre_class][new_windows]}\">{$class_list[$pre_class][name]}</a> > ";
	}

	$nav_x[name].="<a href=\"{$class_list[$classnow][url]}\" target=\"{$class_list[$classnow][new_windows]}\">{$class_list[$classnow][name]}</a>";
}

//把上面赋值的变量与数组转成全局数组
$vars3=array_keys(get_defined_vars());
$a3=get_defined_vars();
foreach($vars3 as $key => $val){
	if(!isset($a2[$val])){
		global $$val;
		$$val=$a3[$val];
	}
}
$gz_title = $_M['plugin']['para']['gz_title'] ? $_M['plugin']['para']['gz_title'] : $gz_title;
$show['description'] = $_M['plugin']['para']['gz_description'] ? $_M['plugin']['para']['gz_description'] : $show['description'];
$show['keywords'] = $_M['plugin']['para']['gz_keywords'] ? $_M['plugin']['para']['gz_keywords'] : $show['keywords'];
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>