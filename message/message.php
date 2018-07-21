<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
require_once '../include/common.inc.php';
$ip=$m_user_ip;
$message_column=$db->get_one("select * from $gz_column where module='7' and lang='$lang'");
$metaccess=$message_column[access];
$class1=$message_column[id];
foreach($settings_arr as $key=>$val){
	if($val['columnid']==$class1){
		$tingname    =$val['name'].'_'.$val['columnid'];
		$$val['name']=$$tingname;
	}
}
require_once ROOTPATH.'include/head.php';
$class1_info=$class_list[$class1][releclass]?$class_list[$class_list[$class1][releclass]]:$class_list[$class1];
$class2_info=$class_list[$class1][releclass]?$class_list[$class1]:$class_list[$class2];
$navtitle=$message_column['name'];
if($action=="get_ajax"){
	$m=2;
	$p=$_GET['p']+0;
	if($p<0) $p=0;
	$pn=$p*$m;
	$message_info_ajax=$db->get_all("select * from gz_message where readok='1' limit ".$pn.",".$m);
	//dump($message_info_ajax);
	foreach($message_info_ajax as $k=>$v){
		echo '<div class="zxzt">发表时间：<span class="lynr">'.$v['addtime'].'</span></div><div class="zxzt">意见内容：<span class="lynr">'.$v['content'].'</span></div><div class="zxzt">意见回复：<span class="lynr">'.$v['useinfo'].'</span></div><div class="xbkxx"></div> ';
	}
	if(empty($message_info_ajax)) exit('no');
	exit;
}
if($action=="add"){
	//dump($_POST);exit;
	$addtime=$m_now_date;
	$_POST['addtime']=$addtime;
	$message_columssnews=$db->insert('gz_message',$_POST);



	if(!$gz_fd_ok)okinfo('javascript:history.back();',"{$lang_Feedback5}");
	if($gz_memberlogin_code==1){
		require_once ROOTPATH.'member/captcha.class.php';
		$Captcha= new  Captcha();
		// if(!$Captcha->CheckCode($code)){
		// echo("<script type='text/javascript'> alert('$lang_membercode'); window.history.back();</script>");
		// 	exit;
		// }
	} 
	
	$ipok=$db->get_one("select * from $gz_message where ip='$ip' order by addtime desc");
	$time1 = strtotime($ipok[addtime]);
	$time2 = strtotime($m_now_date);
	$timeok= (float)($time2-$time1);
	$timeok2=(float)($time2-$_COOKIE['submit']);
	/*if($timeok<=$gz_fd_time||$timeok2<=$gz_fd_time){
		$fd_time="{$lang_Feedback1} ".$gz_fd_time." {$lang_Feedback2}";
		okinfo('javascript:history.back();',$fd_time);
		exit;
	}*/
	$pname="para".$gz_message_fd_class;
	$pname=$$pname;
	$email="para".$gz_message_fd_email;
	$email=$$email;
	$tel="para".$gz_message_fd_sms;
	$tel=$$tel;
	$info="para".$gz_message_fd_content;
	$info=$$info;
	$pname=strip_tags($pname);
	$email=strip_tags($email);
	$tel=strip_tags($tel);
	$contact=strip_tags($contact);
	$fdstr = $gz_fd_word; 
	$fdarray=explode("|",$fdstr);
	$fdarrayno=count($fdarray);
	$fdok=false;
	$content=$content."-".$pname."-".$tel."-".$email."-".$info;
	for($i=0;$i<$fdarrayno;$i++){
		if(strstr($content, $fdarray[$i])){
			$fdok=true;
			$fd_word=$fdarray[$i];
			break;
		}
	}

	$fd_word=" {$lang_Feedback3} [".$fd_word."]";

	if($fdok==true)okinfo('javascript:history.back();',$fd_word);
	setcookie('submit',$time2);
	$from=$gz_fd_usename;
	$fromname=$gz_fd_fromname;
	$to=$gz_fd_to;
	$usename=$gz_fd_usename;
	$usepassword=$gz_fd_password;
	$smtp=$gz_fd_smtp;
	require_once '../include/jmail.php';
	if($gz_fd_back==1 and $email!=""){
		jmailsend($from,$fromname,$email,$gz_fd_title,$gz_fd_content,$usename,$usepassword,$smtp);
	}
	/*短信提醒*/
	if($gz_nurse_massge){
		require_once ROOTPATH.'include/export.func.php';
		if(maxnurse()<$gz_nurse_max){
			$domain = strdomain($gz_weburl);
			$message="您网站[{$domain}]收到了新的留言[{$title}]:".utf8substr($info,0,9)."，请尽快登录网站后台查看";
			sendsms($gz_nurse_massge_tel,$message,4);
		}
	}
	/**/
	if($tel&&$gz_fd_sms_back){
		require_once ROOTPATH.'include/export.func.php';
		sendsms($tel,$gz_fd_sms_content,4);
	}
	/**/
	$customerid=$metinfo_member_name!=''?$metinfo_member_name:0;
	// $query = "INSERT INTO $gz_message SET
	// 					  ip                 = '$ip',
	// 					  addtime            = '$addtime',
	// 					  lang               = '$lang', 
	// 					  customerid 		 = '$customerid'";
	// $db->query($query);
	$news_id=$db->insert_id();
	$fname=$db->get_one("select * from $gz_column where module='7' and lang='$lang'");
	$news_type = "message-".$class1;
	$infos ="para".$gz_message_fd_content;
	$info=$$infos;
	$new_time = time();
	$titlt = $fname['name']."-".$_M['word']['messageonline'];
	$query = "INSERT INTO $gz_infoprompt SET
					  news_id           = '$news_id',
					  newstitle         = '$titlt',
					  content           = '$info',
					  member            = '$customerid',
					  type              = '$news_type',
					  time              = '$new_time',
					  lang              = '$lang'";
	$db->query($query);
	$gz_ahtmtype = $fname['filename']<>''?$gz_chtmtype:$gz_htmtype;
	$msfilename=$fname['filename']<>''?$fname['filename'].'_1':($gz_htmlistname?"message_list_1":"index_list_1");
	$returnurl=$gz_pseudo?'index-'.$lang.'.html':($gz_webhtm==2?$msfilename.$gz_ahtmtype:"index.php?lang=".$lang);
	$use_id=$db->get_one("SELECT * FROM $gz_message WHERE ip='$ip' and addtime='$addtime'");
	$query = "select * from $gz_parameter where lang='$lang' and module='7'";
	$result = $db->query($query);
	while($list = $db->fetch_array($result)){
		$paravalue[]=$list;
		$fd_para[]=$list;
	}
	for($x=0;$x<count($fd_para);$x++){
		$fd_para[$x][para]="para".$fd_para[$x][id];
	}
	require_once '../feedback/uploadfile_save.php';
	foreach($paravalue as $key=>$val){
		if($val[type]!=4){
			$infos ="para".$val[id];
			$info=$$infos;
			if($val['wr_ok'] == 1){
				if($info == ''){
					$last_page=$_SERVER[HTTP_REFERER];
					okinfo($last_page,$val['name'].$lang_Empty);
				}
			}
			if($val[type]==5){$info="../upload/file/$info";}
			$query = "INSERT INTO $gz_mlist SET
						  listid         = '$news_id',
						  info           = '$info',
						  paraid         = '$val[id]',
						  module         = '7',
						  imgname        = '$val[name]',
						  lang           = '$lang'";
			$db->query($query);
		}else{
			$query1 = "select * from $gz_list where lang='$lang' and bigid='$val[id]'";
			$result1 = $db->query($query1);
			while($list1 = $db->fetch_array($result1)){
				$paravalue1[]=$list1;
			}
			$i=1;
			$infos="";
			foreach($paravalue1 as $key=>$val1){
				$paras4_name="para".$val[id]."_".$i;
				$para_name=$$paras4_name;
				if($infos){
					if($para_name){
						$infos=$infos."-".$para_name;
					}
				}else{
					if($para_name){
						$infos=$para_name;
					}
				}
				$i=$i+1;
			}
			if($val['wr_ok'] == 1){
				if($infos == ''){
					$last_page=$_SERVER[HTTP_REFERER];
					okinfo($last_page,$val['name'].$lang_Empty);
				}
			}
			$query = "INSERT INTO $gz_mlist SET
						  listid         = '$news_id',
						  paraid         = '$val[id]',
						  info           = '$infos',
						  module         = '7',
						  imgname        = '$val[name]',
						  lang           = '$lang'";
			$db->query($query);
		}
	}
	if($gz_fd_email==1){
		$fromurl=$_SERVER['HTTP_REFERER'];
		$query1 = "select * from $gz_mlist where lang='$lang' and module='7' and listid=$use_id[id] order by id";
		$result1 = $db->query($query1);
		while($list1 = $db->fetch_array($result1)){
			$email_list[]=$list1;
		}
		$body = '';
		foreach($email_list as $val){
			$body.="<b>$val[imgname]</b>:$val[info]<br />";
		}
		$title=$pname."{$lang_MessageInfo1}";
		jmailsend($from,$fromname,$to,$title,$body,$usename,$usepassword,$smtp,$email);
	}
	okinfo($returnurl,"{$lang_MessageInfo2}");

}else{
	$class2=$class_list[$class1][releclass]?$class1:$class2;
	$class1=$class_list[$class1][releclass]?$class_list[$class1][releclass]:$class1;
	$class_info=$class2?$class2_info:$class1_info;
	if($class2!=""){
		$class_info[name]=$class2_info[name]."--".$class1_info[name];
	}
	$show[description]=$class_info[description]?$class_info[description]:$gz_description;
    $show[keywords]=$class_info[keywords]?$class_info[keywords]:$gz_keywords;
	$gz_title=$gz_title?$navtitle.'-'.$gz_title:$navtitle;
	 
	$message[listurl]=$gz_pseudo?'index-'.$lang.'.html':(($gz_webhtm==2)?($gz_htmlistname?"message_list_1":"index_list_1").$gz_htmtype:"index.php?lang=".$lang);
	if(count($nav_list2[$message_column[id]])){
		$k=count($nav_list2[$class1]);
		$nav_list2[$class1][$k]=$class1_info;
		$nav_list2[$class1][$k][name]=$lang_messageview;
		$k++;
		$nav_list2[$class1][$k]=array('url'=>$addmessage_url,'name'=>$lang_messageadd);
	}else{
		$k=count($nav_list2[$class1]);
		if(!$k){
			$nav_list2[$class1][0]=array('url'=>$addmessage_url,'name'=>$lang_messageadd);
			$nav_list2[$class1][1]=$class1_info;
			$nav_list2[$class1][1][name]=$lang_messageview;
		}
	}
	require_once '../public/php/methtml.inc.php';
	$methtml_message = metlabel_messageold();
	include template('message');
	footer();
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>