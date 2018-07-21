<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$gz_oline=1;
require_once 'common.inc.php';
if($gz_online_type<>3){
	$gz_url   = $gz_weburl.'public/';
	$cache_online = gz_cache('online_'.$lang.'.inc.php');
	if(!$cache_online){$cache_online=cache_online();}
	foreach($cache_online as $key=>$list){
		$online_list[]=$list;
		if($list['qq']!="")$qq_list[]=$list;
		if($list['msn']!="")$msn_list[]=$list;
		if($list['taobao']!="")$taobao_list[]=$list;
		if($list['alibaba']!="")$alibaba_list[]=$list;
		if($list['skype']!="")$skype_list[]=$list;
	}
	$metinfo='<div id="onlinebox" class="onlinebox onlinebox_'.$gz_online_skin.' onlinebox_'.$gz_online_skin.'_'.$gz_online_color.'" style="display:none;">';
	if($gz_online_skin<3){
	$metinfo.='<div class="onlinebox-showbox">';
	$metinfo.='<span>'.$lang_Online.'</span>';
	$metinfo.='</div>';
	$metinfo.='<div class="onlinebox-conbox" style="display:none;">';
	}
	$stit=$gz_online_skin<3?"title='{$lang_Online_tips}'":'';
	$metinfo.='		<div class="onlinebox-top" '.$stit.'>';
	$metinfo.='<a href="javascript:;" onclick="return onlineclose();" class="onlinebox-close" title="'.$lang_Close.'"></a><span>'.$lang_Online.'</span>';
	$metinfo.='		</div>';
	$metinfo.='		<div class="onlinebox-center">';
	$metinfo.='			<div class="onlinebox-center-box">';
	//online content
	foreach($online_list as $key=>$val){
		$metinfo.="<dl>";
		if(!$gz_onlinenameok)$metinfo.="<dt>".$val[name]."</dt>";
		$metinfo.="<dd>";
		if($val[qq]!=""){
			$metinfo.='<a href="http://wpa.qq.com/msgrd?v=3&uin='.$val[qq].'&site=qq&menu=yes" target="_blank"><img alt="QQ'.$val[name].'" border="0" src="http://wpa.qq.com/pa?p=2:'.$val[qq].':'.$gz_qq_type.'" title="QQ'.$val[name].'" /></a>';
		}
		if($val[msn]!="")$metinfo.='<span class="gz_msn"><a href="msnim:chat?contact='.$val[msn].'"><img border="0" alt="MSN'.$val[name].'" src="'.$gz_url.'images/msn/msn_'.$gz_msn_type.'.gif"/></a></span>';
		if($val[taobao]!="")$metinfo.='<span class="gz_taobao"><a target="_blank" href="http://www.taobao.com/webww/ww.php?ver=3&touid='.$val[taobao].'&siteid=cntaobao&status='.$gz_taobao_type.'&charset=utf-8"><img border="0" src="http://amos.alicdn.com/online.aw?v=2&uid='.$val[taobao].'&site=cntaobao&s='.$gz_taobao_type.'&charset=utf-8" alt="'.$val[name].'" /></a></span>';
		if($val[alibaba]!=""){
			$span="";
			if($gz_alibaba_type==11){
				$span="<span class='gz_alibaba'>$val[alibaba]</span>";
			}
			$metinfo.='<div><a target="_blank" href="http://amos.alicdn.com/msg.aw?v=2&uid='.$val[alibaba].'&site=cnalichn&s='.$gz_alibaba_type.'&charset=UTF-8"><img border="0" src="http://amos.alicdn.com/online.aw?v=2&uid='.$val[alibaba].'&site=cnalichn&s='.$gz_alibaba_type.'&charset=UTF-8" alt="'.$val[name].'" />'.$span.'</a></div>';
		}
		if($val[skype]!="")$metinfo.='<span><a href="callto://'.$val[skype].'"><img src="'.$gz_url.'images/skype/skype_'.$gz_skype_type.'.gif" border="0"></a></span>';
		$metinfo.="</dd>"; 
		$metinfo.="</dl>"; 
		$metinfo.='<div class="clear"></div>'; 
	}	 
	//online over
	$metinfo.='			</div>';
	$metinfo.='		</div>';
	if($gz_onlinetel!=""){
	$metinfo.='		<div class="onlinebox-bottom">';
	$metinfo.='			<div class="onlinebox-bottom-box"><div class="online-tbox">';
	$metinfo.=$gz_onlinetel;
	$metinfo.='			</div></div>';
	$metinfo.='		</div>';
	}
	$metinfo.='<div class="onlinebox-bottom-bg"></div>';
	if($gz_online_skin<3)$metinfo.='</div>';
	$metinfo.='</div>';

	$tmpincfile=ROOTPATH."templates/{$_M[config][gz_skin_user]}/metinfo.inc.php";
	if(file_exists($tmpincfile)){
		require_once $tmpincfile;
	}
	$metinfover = $metinfover_url ? $metinfover_url : $metinfover;
	if($metinfover == 'v1'){
		//处理回传数据(sea.js处理方式)
		$onlinex=$gz_online_type<2?$gz_onlineleft_left:$gz_onlineright_right;
		$onliney=$gz_online_type<2?$gz_onlineleft_top:$gz_onlineright_top;
		$data['html']=$metinfo;
		$data['t']=$gz_online_type;
		$data['x']=$onlinex;
		$data['y']=$onliney;
		echo json_encode($data);
	}else{
		//处理回传数据(老模板处理方式)
		$_REQUEST['jsoncallback'] = strip_tags($_REQUEST['jsoncallback']);
		if($_REQUEST['jsoncallback']){
			$metinfo=str_replace("'","\'",$metinfo);
			$metinfo=str_replace('"','\"',$metinfo);
			$metinfo=preg_replace("'([\r\n])[\s]+'", "", $metinfo);
			echo $_REQUEST['jsoncallback'].'({"metcms":"'.$metinfo.'"})';
		}else{
			echo $metinfo;
		}
		die();
	}

}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>