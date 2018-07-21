<?php
if($pcok=='pc'){
	if($gz_wap_tpb){
		$gz_wap_url=$gz_wap_url.'index.php?pcok=wap&gz_mobileok=1';
	}else{
		$gz_wap_url=$gz_index_type==$lang?$index_url.'wap/index.php?pcok=wap&gz_mobileok=1':$navurl.'wap/index.php?lang='.$lang.'pcok=wap&gz_mobileok=1';
	}
	$gz_wap_tpb=1;
}
$wap_footertext.="<div class='metpcmobile'>";
$wap_footertext.="<a href=\"http://".htmlentities("{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}")."?".str_replace(array('&gz_mobileok=1','&pcok=wap','&pcok=pc'),'',htmlentities($_SERVER['QUERY_STRING']))."&pcok=pc\">{$lang_foottext5}</a>";
$wap_footertext.="<span>|</span>";
$wap_footertext.="<a href=\"http://".htmlentities("{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}")."?".str_replace(array('&gz_mobileok=1','&pcok=wap','&pcok=pc'),'',htmlentities($_SERVER['QUERY_STRING']))."&pcok=wap&gz_mobileok=1\">{$lang_foottext6}</a>";
$wap_footertext.="</div>";
if($pcok=='wap'){
//$gz_foottext.="<a href=\"http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?".str_replace(array('&gz_mobileok=1','&pcok=wap','&pcok=pc'),'',$_SERVER['QUERY_STRING'])."&gz_mobileok=1&pcok=wap\">{$lang_foottext6}</a>";
	$methtml_foot.="<a href=\"http://".htmlentities("{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}")."?".str_replace(array('&gz_mobileok=1','&pcok=wap','&pcok=pc'),'',htmlentities($_SERVER['QUERY_STRING']))."&gz_mobileok=1&pcok=wap\">{$lang_foottext6}</a>";
}

if($pcok=='pc'&&$pad!=1){
$gz_foottext.="<a href=\"http://".htmlentities("{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}")."?".str_replace(array('&gz_mobileok=1','&pcok=wap','&pcok=pc'),'',htmlentities($_SERVER['QUERY_STRING']))."&gz_mobileok=1&pcok=wap\">{$lang_foottext6}</a>";
$methtml_foot.="<a href=\"http://".htmlentities("{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}")."?".str_replace(array('&gz_mobileok=1','&pcok=wap','&pcok=pc'),'',htmlentities($_SERVER['QUERY_STRING']))."&gz_mobileok=1&pcok=wap\">{$lang_foottext6}</a>";
}

if($gz_mobileok!=1){
	$wap_footertext="";
}
?>