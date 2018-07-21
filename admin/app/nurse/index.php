<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
$depth='../';
require_once $depth.'../login/login_check.php';
$cs=isset($cs)?$cs:1;
$listclass[$cs]='class="now"';
if($action=='modify'){
	switch($cs){
		case 1:
			$gz_nurse_stat_tel = str_replace(chr(13).chr(10),",",$gz_nurse_stat_tel);
			$type               = 2;
			$gz_nurse_tel      = $gz_nurse_stat_tel;
			$gz_nurse_ok       = $gz_nurse_stat;
		break;
		case 2:
			$gz_nurse_monitor_tel = str_replace(chr(13).chr(10),",",$gz_nurse_monitor_tel);
			$type = 3;
			$gz_nurse_ok = $gz_nurse_monitor;
			$gz_nurse_tel= $gz_nurse_monitor_tel;
			$noun=$gz_nurse_monitor_fre;
		break;
		case 3:
			$gz_nurse_member_tel = str_replace(chr(13).chr(10),",",$gz_nurse_member_tel);
			$gz_nurse_feed_tel   = str_replace(chr(13).chr(10),",",$gz_nurse_feed_tel);
			$gz_nurse_massge_tel = str_replace(chr(13).chr(10),",",$gz_nurse_massge_tel);
			$gz_nurse_job_tel    = str_replace(chr(13).chr(10),",",$gz_nurse_job_tel);
			$gz_nurse_link_tel   = str_replace(chr(13).chr(10),",",$gz_nurse_link_tel);
		break;
	}
	if($cs==1||$cs==2){
		require_once ROOTPATH.'include/export.func.php';
		$total_passok = $db->get_one("SELECT * FROM $gz_otherinfo WHERE lang='gz_sms'");
		$gz_file='/timing/record.php';
		$post=array(
			'total_pass'=>$total_passok['authpass'],
			'gz_nurse_ok'=>$gz_nurse_ok,
			'gz_nurse_tel'=>$gz_nurse_tel,
			'gz_weburl'=>$gz_weburl,
			'noun'=>$noun,
			'weeka'=>$gz_nurse_monitor_weeka,
			'weekb'=>$gz_nurse_monitor_weekb,
			'timea'=>$gz_nurse_monitor_timea,
			'timeb'=>$gz_nurse_monitor_timeb,
			'sendtime'=>$gz_nurse_sendtime,
			'type'=>$type);
		$metinfo = curl_post($post,30);
		if(trim($metinfo)=='OK'){
			require_once $depth.'../include/config.php';
			metsave('../app/nurse/index.php?lang='.$lang.'&anyid='.$anyid.'&cs='.$cs,'',$depth);
		}else{
			require_once $depth.'../include/config.php';
			metsave('-1',$lang_nursenomoney,$depth);
		}
	}else{
		require_once $depth.'../include/config.php';
		metsave('../app/nurse/index.php?lang='.$lang.'&anyid='.$anyid.'&cs='.$cs,'',$depth);
	}
}else{
	switch($cs){
		case 1:
			$gz_nurse_statx[$gz_nurse_stat]='checked';
			$gz_nurse_stat_tel = str_replace(",",chr(13).chr(10),$gz_nurse_stat_tel);
			$gz_nurse_statfreax[$gz_nurse_statfrea]='checked';
			$gz_nurse_statfrebx[$gz_nurse_statfreb]='checked';
			$gz_nurse_statfrecx[$gz_nurse_statfrec]='checked';
		break;
		case 2:
			$gz_nurse_monitorx[$gz_nurse_monitor]='checked';
			$gz_nurse_monitor_frex[$gz_nurse_monitor_fre]='checked';
			$gz_nurse_monitor_peax[$gz_nurse_monitor_pea]='checked';
			$gz_nurse_monitor_pebx[$gz_nurse_monitor_peb]='checked';
			$gz_nurse_monitor_pecx[$gz_nurse_monitor_pec]='checked';
			$gz_nurse_monitor_pedx[$gz_nurse_monitor_ped]='checked';
			$gz_nurse_monitor_tel = str_replace(",",chr(13).chr(10),$gz_nurse_monitor_tel);
			$weeka[$gz_nurse_monitor_weeka]='selected';
			$weekb[$gz_nurse_monitor_weekb]='selected';
			switch($gz_nurse_monitor_fre){
				case 1:
				$monitor[3]='none';
				$monitor[4]='none';
				break;
				case 2:
				$monitor[3]='none';
				$monitor[4]='none';
				break;
				case 3:
				$monitor[1]='none';
				$monitor[4]='none';
				break;
				case 4:
				$monitor[1]='none';
				$monitor[3]='none';
				break;
			}
		break;
		case 3:
			$gz_nurse_memberx[$gz_nurse_member]='checked';
			$gz_nurse_feedx[$gz_nurse_feed]='checked';
			$gz_nurse_massgex[$gz_nurse_massge]='checked';
			$gz_nurse_jobx[$gz_nurse_job]='checked';
			$gz_nurse_linkx[$gz_nurse_link]='checked';
			$gz_nurse_member_tel = str_replace(",",chr(13).chr(10),$gz_nurse_member_tel);
			$gz_nurse_feed_tel   = str_replace(",",chr(13).chr(10),$gz_nurse_feed_tel);
			$gz_nurse_massge_tel = str_replace(",",chr(13).chr(10),$gz_nurse_massge_tel);
			$gz_nurse_job_tel    = str_replace(",",chr(13).chr(10),$gz_nurse_job_tel);
			$gz_nurse_link_tel   = str_replace(",",chr(13).chr(10),$gz_nurse_link_tel);
		break;
	}

	$css_url=$depth."../templates/".$gz_skin."/css";
	$img_url=$depth."../templates/".$gz_skin."/images";
	include template('app/nurse/index');footer();
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>