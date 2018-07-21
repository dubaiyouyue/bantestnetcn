<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once 'mobile_detect.php';
if($pcok=='deleted' || $pcok=='\de\leted')$pcok='';
if($pcok){
	if($pcok!='wap'&&$pcok!='pc'){
		header("location:404.html");die;
	}
}

if($gz_mobileok){
	$pattern='/^[1-9]?\d$/';
	if(!preg_match($pattern,$gz_mobileok)){
		header("location:404.html");die;
	}
}
$detect = new mobile_detect;
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
function mobilejump($tp){
	global $gz_wap_tpa,$gz_wap_tpb,$gz_wap_url,$gz_wap,$gz_mobileok,$lang,$index,$db;
	$gz_mobileok=$tp?$gz_mobileok:0;
	if($gz_wap&&!$gz_mobileok){
		$Loaction = $index?'wap/index.php?lang='.$lang:'../wap/index.php?lang='.$lang;
		if($gz_wap_tpa==1){
			$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
			if($_SERVER['HTTP_USER_AGENT']){
				$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile|wap|Android|ucweb)/i";
				if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap')){
					if (!empty($Loaction)){
						if($gz_wap_tpb==1&&$gz_wap_url!='')$Loaction=$gz_wap_url.$Loaction;
						$Loaction = trim($Loaction);
						header("Location: $Loaction");
						exit;
					}
				}
			}
		}
		if($gz_wap_tpb==1){
			$localurl="http://";
			$localurl.=$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"];
			$localurl=dirname($localurl);
			if(substr($localurl,-1,1)!="/")$localurl.="/";
			if(strstr($localurl,$gz_wap_url)){
				header("Location: $Loaction\n");
				exit;
			}
		}
	}
}
gz_setcookie("pcok",$pcok,0);
$isTablet=$detect->isTablet();
if($isTablet&&$pcok!='wap'){
		$pcok='pc';
		$gz_webhtm=0;
		$gz_pseudo=0;
		$gz_mobileok=0;
		$pad=1;
}
if($isTablet&&(substr($_SERVER['HTTP_REFERER'],-5)=='.html'||substr($_SERVER['HTTP_REFERER'],-4)=='.htm')){
		$pcok='pc';
		$gz_webhtm=0;
		$gz_pseudo=0;
		$gz_mobileok=0;
		$pad=1;
		gz_setcookie("pcok",'pc',0);
}
if($pcok!='pc'){
	if(!$gz_wap_url)$gz_wap_url=$gz_index_url[$lang];

	if(($gz_mobileok||!$index)&&strstr($_SERVER['HTTP_USER_AGENT'],"UCWEB/2.0")){
		$gz_mobileok='';
		mobilejump(1);
	}
	if($index=='index'&&$gz_wap&&!$gz_mobileok)mobilejump(1);
	if($index!='index'&&$gz_wap&&!$gz_mobileok){
		$gz_mobileok=0;
		if($gz_wap_tpa==1){
			$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
			if($_SERVER['HTTP_USER_AGENT']){
				$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile|wap|Android|ucweb)/i";
				if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap')){
					if (!empty($wap_skin_user)){
						if($gz_wap_tpb&&$gz_wap_url){
							$localurl="http://";
							$localurl.=$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"];
							$localurl=dirname($localurl);
							if(substr($localurl,-1,1)!="/")$localurl.="/";
							if(!strstr($localurl,$gz_wap_url)){
								$mobile_prefix=request_uri();
								$mobile_prefix=str_replace($gz_weburl,$gz_wap_url,$mobile_prefix);
								header("Location: $mobile_prefix\n");
								exit;
							}
						}
						$gz_mobileok = 1;
					}
				}
			}
		}
		if($gz_wap_tpb==1){
			$localurl="http://";
			$localurl.=$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"];
			$localurl=dirname($localurl);
			if(substr($localurl,-1,1)!="/")$localurl.="/";
			if(strstr($localurl,$gz_wap_url)){
				$gz_mobileok = 1;
			}
		}
	}
	$mobilesql='';
	if($gz_mobileok){
		$gz_skin_user = $wap_skin_user;
		$_M[config][gz_skin_user] = $_M[config][wap_skin_user];
		$gz_urlblank = 0;
		$gz_online_type=3;
		$gz_memberlogin_code=0;
		$gz_news_list = $wap_news_list;
		$gz_product_list = $wap_product_list;
		$gz_download_list = $wap_download_list;
		$gz_img_list = $wap_img_list;
		$gz_job_list = $wap_job_list;
		$gz_message_list = $wap_message_list;
		$gz_search_list = $wap_search_list;
		
		$gz_footright ='';
		$gz_footstat ='';
		$gz_footaddress ='';
		$gz_foottel ='';
		$gz_footother ='';
		$gz_foottext ='';
		
		if($metinfover){
		$wap_footertext.="
		<script src=\"../public\ui\mobile\js\ini.js\" type=\"text/javascript\"></script>\n
		<link rel=\"stylesheet\" type=\"text/css\" href=\"../public/ui/v1/js/effects/video-js/video-js.css\" />\n
		<script src=\"../public/ui/v1/js/effects/video-js/video_hack.js\" type=\"text/javascript\"></script>\n
		";
		}
		
		$gz_flasharraytd = array();
		foreach($gz_flasharray as $key=>$val){
			$val[type] = $val[wap_type];
			$val[y]    = $val[wap_y];
			$gz_flasharraytd[$key] = $val;
		}
		$gz_flasharray = $gz_flasharraytd;
		if($wap_title){
			$gz_hometitle=$wap_title;
			$gz_webname=$wap_title;
			$gz_title_type=2;
		}
		if($gz_wap_url){
			$gz_weburl=$gz_wap_url;
		}
		if($gz_wap_logo)$gz_logo=$gz_wap_logo;
		$mobilesql = $gz_wap_ok?"and wap_ok='1'":'';
		$gz_skin_css=$wap_skin_css;
		$gz_webhtm=0;
		$gz_pseudo=0;
		}
}else{
	if($pcok=='wap'){
		$gz_webhtm=0;
		$gz_pseudo=0;
	}
	$gz_mobileok=0;
}
$suffix = substr($_SERVER['REQUEST_URI'],-5);
if($suffix == '.html'){
	$gz_pseudo=$db->get_one("SELECT value FROM $gz_config WHERE name='gz_pseudo' AND lang='$lang'");
	$gz_pseudo=$gz_pseudo['value'];
}
include ROOTPATH.'public/php/waphtml.inc.php';
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>