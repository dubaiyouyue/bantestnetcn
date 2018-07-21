<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
require_once 'common.inc.php';
$packurl = 'http://'.$_SERVER['HTTP_HOST'].'/';
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
	$gz_langok[$key][gz_weburl]=$gz_index_url[$val[mark]];
}
//2.0
$index_c_url=$gz_index_url[cn];
$index_e_url=$gz_index_url[en];
$index_o_url=$gz_index_url[other];

//2.0
$searchurl           =$gz_weburl."search/search.php?lang=".$lang;
$file_basicname      =ROOTPATH."lang/language_".$lang.".ini";
$file_name           =ROOTPATH."templates/".$gz_skin_user."/lang/language_".$lang.".ini";
$str="";
//

if(!file_get_contents(ROOTPATH.'cache/lang_'.$lang.'.php')||!file_get_contents(ROOTPATH.'cache/lang_json_'.$lang.'.php')){
	$query="select * from $gz_language where lang='$lang' and site='0' and array!='0'";
	$result= $db->query($query);
	while($listlang= $db->fetch_array($result)){
		$name = 'lang_'.$listlang['name'];
		$$name= trim($listlang['value']);
		$str.='$'."{$name}='".str_replace(array('\\',"'"),array("\\\\","\\'"),trim($listlang['value']))."';";
		$lang_json[$listlang['name']]=$listlang['value'];
	}
	$lang_json['gz_weburl'] = $gz_langok[$lang][gz_weburl];
	$str="<?php\n".$str."\n?>";
	file_put_contents(ROOTPATH.'cache/lang_'.$lang.'.php',$str);
	file_put_contents(ROOTPATH.'cache/lang_json_'.$lang.'.php',json_encode($lang_json));
}else{
	require_once ROOTPATH.'cache/lang_'.$lang.'.php';
}
$query="select * from $gz_language where site='0' and lang='$lang'";
$languages=$db->get_all($query);
foreach($languages as $key=>$val){
	$_M[word][$val[name]]=$val[value];
}
$query = "SELECT * FROM {$gz_templates} WHERE no='{$gz_skin_user}' AND lang='{$lang}' order by no_order ";
$inc = $db->get_all($query);
$tmpincfile=ROOTPATH."templates/{$_M[config][gz_skin_user]}/metinfo.inc.php";
if(file_exists($tmpincfile)){	
	$metinfover_content = file_get_contents($tmpincfile);
	if(strstr($metinfover_content, "metinfover")) {
		require $tmpincfile;
	}
}
foreach($inc as $key=>$val){
	$name = 'lang_'.$val['name'];
	if($val[type]==7&&strstr($val['value'],"../upload/")&&$index=='index'&&$metinfover=='v1'){
		$val['value']=explode("../",$val['value']);
		$val['value']=$val['value'][1];
	}
	$$name = trim($val['value']);
}
/*模板设置预览*/
if($theme_preview&&$gz_theme_preview){
	foreach($php_json['langini'] as $key=>$val){
		if(strstr($val,"../upload/")&&$index=='index'){
			$val=explode("../",$val);
			$val=$val[1];
		}
		$name = 'lang_'.$key;
		$$name= trim($val);
	}
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>
