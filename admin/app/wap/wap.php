<?php
$depth='../';
require_once $depth.'../login/login_check.php';
//$action='dimensional';
echo str_replace(array('http',':','/'),$gz_wap_url);
if($action == 'dimensional'){
	require_once ROOTPATH.'include/export.func.php';
	$gz_file='/dimensional.php';
	//$gz_dimensional_logo=$gz_weburl.str_replace('../','',$gz_dimensional_logo);
	$gz_dimensional_logo_file=file_get_contents(ROOTPATH.str_replace('../','',$gz_dimensional_logo));
	$gz_dimensional_logo_file=urlencode($gz_dimensional_logo_file);
	$gz_weburl_mobile = $gz_weburl;
	if($gz_wap_tpb){
		if($gz_langok[$lang][link]){
			$gz_weburl_mobile = $gz_langok[$lang][link];
		}
		if($gz_wap_url)$gz_weburl_mobile=$gz_wap_url;
	}
	$post=array('text'=>$gz_weburl_mobile,'w'=>$wap_dimensional_size,'logo'=>$gz_dimensional_logo_file);
	$re=curl_post($post,30);
	if(!file_exists('../../../upload/files/'))mkdir('../../../upload/files/');
	file_put_contents('../../../upload/files/dimensional.png',$re);
	require_once $depth.'../include/config.php';
	echo '../../../upload/files/dimensional.png?'.gz_rand(4);
	die();
}
if($action == 'modify'){
	if($gz_wapshowtype==0){
		$gz_wap_ok=0;
	}else{
		$query = "update {$gz_column} SET wap_ok = '0' where lang='$lang'";
		$db->query($query);
		if($f_columnlist!=','){
			$allidlist=explode(',',$f_columnlist);
			foreach($allidlist as $key=>$val){
				if($val){
					$query = "update {$gz_column} SET wap_ok = '1' where id = '$val' and lang='$lang'";
					$db->query($query);
				}
			}
		}
		if($f_wap_nav_ok&&$f_wap_nav_ok!=','){
			$query = "update {$gz_column} SET wap_nav_ok = '0' where lang='$lang'";
			$db->query($query);
			$allidlist=explode(',',$f_wap_nav_ok);
			foreach($allidlist as $key=>$val){
				if($val){
					$query = "update {$gz_column} SET wap_nav_ok = '1' where id = '$val' and lang='$lang'";
					$db->query($query);
				}
			}
		}
	}
	if(!$gz_wap_tpa)$gz_wap_tpa=0;
	if($gz_wap_url){
		$gz_wap_tpb=1;
	}else{
		$gz_wap_tpb=0;
	}
	$gz_wap_url = ereg_replace(" ","",$gz_wap_url);
	if(substr($gz_wap_url,-1,1)!="/")$gz_wap_url.="/";
	if(!strstr($gz_wap_url,"http://"))$gz_wap_url="http://".$gz_wap_url;
	if($gz_wap_url=='http://'||$gz_wap_url=='http:///')$gz_wap_url='';
	require_once $depth.'../include/config.php';
	$reload = $_M['config']['gz_wap'] == $gz_wap ? 0 : 1;
	metsave('../app/wap/wap.php?lang='.$lang.'&anyid='.$anyid.'&reload='.$reload,'',$depth);
}else{
	if($reload == 1){
		echo "<script>parent.window.location.reload();</script>";
		exit();
	}
	$gz_wap1[$gz_wap]="checked";
	$gz_waplink1[$gz_waplink]="checked";
	$gz_wap_ok1[$gz_wap_ok]="checked";
	$gz_wap_tpa1[$gz_wap_tpa]="checked";
	$gz_wap_tpb1[$gz_wap_tpb]="checked";
	$gz_wapshowtype1[$gz_wapshowtype]="checked";
	$webmpa = $_SERVER["PHP_SELF"];
	$webmpa = dirname($webmpa);
	$webmpa = explode('/',$webmpa);
	$wnum = count($webmpa)-2;
	for($i=1;$i<$wnum;$i++){
		$webmp = $i==1?$webmpa[$i]:$webmp.'/'.$webmpa[$i];
	}
	if(substr($webmp,-1,1)!="/")$webmp.="/";
	$webml = 'http://'.$_SERVER['HTTP_HOST'].'/';
	$webwapurl = $webml.$webmp.'wap/';
	$listclass[1]='class="now"';
	$css_url=$depth."../templates/".$gz_skin."/css";
	$img_url=$depth."../templates/".$gz_skin."/images";
	include template('app/wap/wap');
	footer();
}
?>