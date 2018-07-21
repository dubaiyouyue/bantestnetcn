<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.  
require_once '../include/common.inc.php';
if(!$id){
	$filpy = basename(dirname(__FILE__));
	$nwid=$db->get_one("SELECT * FROM $gz_column WHERE module='8' and foldername='$filpy' and lang='$lang'");
	$id=$nwid['id'];
}
$classaccess= $db->get_one("SELECT * FROM $gz_column WHERE module='8' and lang='$lang' and id='$id'");
$metaccess=$classaccess[access];
$class1=$classaccess[id];
foreach($settings_arr as $key=>$val){
	if($val['columnid']==$class1){
		$tingname    =$val['name'].'_'.$val['columnid'];
		$$val['name']=$$tingname;
	}
}
require_once ROOTPATH.'include/head.php';
	$class1_info=$class_list[$class1][releclass]?$class_list[$class_list[$class1][releclass]]:$class_list[$class1];
	$class2_info=$class_list[$class1][releclass]?$class_list[$class1]:$class_list[$class2];
$fromurl=$_SERVER['HTTP_REFERER'];
$fromurl=daddslashes($fromurl);
$ip=$m_user_ip;
if($title==""){
$navtitle=$gz_fdtable;
$title=$navtitle;
}
else{
$navtitle="[".$title."]".$gz_fdtable;
}
if($action=="add"){
if(!$gz_fd_ok)okinfo('javascript:history.back();',"{$lang_Feedback5}");
if($gz_memberlogin_code==1){
	require_once ROOTPATH."{$gz_adminfile}/include/captcha.class.php";
	$Captcha= new  Captcha();
	// if(!$Captcha->CheckCode($code)){
	// echo("<script type='text/javascript'> alert('$lang_membercode');window.history.back();</script>");
	//    exit;
	// }
}
$sid = $id;
$addtime=$m_now_date;
$ipok=$db->get_one("select * from $gz_feedback where ip='$ip' order by addtime desc");
if($ipok)
$time1 = strtotime($ipok['addtime']);
else
$time1 = 0;
$time2 = strtotime($m_now_date);
$timeok= (float)($time2-$time1);
$timeok2=(float)($time2-$_COOKIE['submit']);
if($timeok<=$gz_fd_time||$timeok2<=$gz_fd_time){
$fd_time="{$lang_Feedback1}".$gz_fd_time."{$lang_Feedback2}";
okinfo('javascript:history.back();',$fd_time);
exit;
}
$query = "SELECT * FROM $gz_parameter where lang='$lang' and module=8 and class1='$id' order by no_order";
if($gz_member_use)$query = "SELECT * FROM $gz_parameter where lang='$lang' and  module=8 and class1='$id' and access<='$metinfo_member_type' order by no_order";
$result = $db->query($query);
while($list= $db->fetch_array($result)){
$list[para]="para".$list[id];
$fd_para[]=$list;
}
$fdstr = $gz_fd_word; 
$fdarray=explode("|",$fdstr);
$fdarrayno=count($fdarray);
$fdok=false;
foreach($fd_para as $key=>$val){
$para="para".$val[id];
$content=$content."-".$$para;
}
for($i=0;$i<$fdarrayno;$i++){ 
if(strstr($content, $fdarray[$i])){
$fdok=true;
$fd_word=$fdarray[$i];
break;
}
}
$fd_word="{$lang_Feedback3} [".$fd_word."]";
if($fdok==true)okinfo('javascript:history.back();',$fd_word);
setcookie('submit',$time2);
require_once '../include/jmail.php';
require_once 'uploadfile_save.php';
$fdto="para".$gz_fd_email;
$fdto=$$fdto;
$fdclass2="para".$gz_fd_class;
$fdclass=$$fdclass2;
$title=$fdclass." - ".$fdtitle;
$from=$gz_fd_usename;
$fromname=$gz_fd_fromname;
$to=$gz_fd_to;
$usename=$gz_fd_usename;
$usepassword=$gz_fd_password;
$smtp=$gz_fd_smtp;
if($gz_fd_type!=0){
if(!isset($metinfo_member_name) || $metinfo_member_name=='') $metinfo_member_name=0;

	$datas['addtime']=$addtime;
	$datas['class1']=$id;
	$datas['fdtitle']=$_POST['biaoti'];
	$datas['tel']=$_POST['tel'];
	$datas['youxiang']=$_POST['youxiang'];
	$datas['xingm']=$_POST['xingm'];
	$datas['content']=$_POST['content'];
	$datas['fromurl']=$fromurl;
	$datas['ip']=$ip;	
	$datas['lang']=$lang;
	$datas['customerid']=$metinfo_member_name;
	$fankuiadd=$db->insert('gz_feedback',$datas);


// $query = "INSERT INTO $gz_feedback SET
//                       class1             = '$id',
//                       fdtitle            = '$title',
// 					  fromurl            = '$fromurl',
// 					  ip                 = '$ip',
// 					  addtime            = '$addtime',
// 					  customerid         = '$metinfo_member_name',
// 					  lang               = '$lang'";					  
// $db->query($query);
$class_1 = $id;
$id=$db->insert_id();
$new_time = time();
$news_type = "feedback-".$class_1;
$query = "INSERT INTO $gz_infoprompt SET
                      news_id           = '$id',
                      newstitle         = '$title',
					  member            = '$metinfo_member_name',
					  type              = '$news_type',
					  time              = '$new_time',
					  lang              = '$lang'";					  
$db->query($query);
$query = "select * from $gz_parameter where lang='$lang' and module='8'  and class1='$class1'";
$result = $db->query($query);
while($list = $db->fetch_array($result)){
	$paravalue[]=$list;
}
foreach($paravalue  as $key=>$val){
    if($val[type]!=4){
	    $infos ="para".$val[id];
		$info=$$infos;
		if($val[type]==5){$info="../upload/file/$info";}
		$query = "INSERT INTO $gz_flist SET
                      listid         = '$id',
					  info           = '$info',
					  paraid         = '$val[id]',
					  module         = '8',
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
		$query = "INSERT INTO $gz_flist SET
                      listid         = '$id',
					  paraid         = '$val[id]',
					  info           = '$infos',
					  module         = '8',
					  lang           = '$lang'";
		$db->query($query);
	}

 }
}
/**/
$fname= $db->get_one("SELECT * FROM $gz_column WHERE module='8' and lang='$lang' and id='$sid'");
$fedfilename=$fname['filename']!=''?$fname['filename']:'index';
$gz_ahtmtype = $fname['filename']<>''?$gz_chtmtype:$gz_htmtype;
$returnurl=$gz_pseudo?'index-'.$lang.'.html':($gz_webhtm?$fedfilename.$gz_ahtmtype:'index.php?lang='.$lang.'&id='.$sid);
if($fid_url)$returnurl=$_SERVER[HTTP_REFERER];

/*短信提醒*/
if($gz_nurse_feed){
	require_once ROOTPATH.'include/export.func.php';
	if(maxnurse()<$gz_nurse_max){
		$domain = strdomain($gz_weburl);
		$message="您网站[{$domain}]收到了新的反馈信息[{$title}]，请尽快登录网站后台查看";
		sendsms($gz_nurse_feed_tel,$message,4);
	}
}
/*短信回复*/
$tell='para'.$gz_fd_sms_dell;
$tel=$$tell;
if($tel&&$gz_fd_sms_back){
		require_once ROOTPATH.'include/export.func.php';
		sendsms($tel,$gz_fd_sms_content,4);
}
/*邮件提醒*/
if($gz_fd_type==0 or $gz_fd_type==2){
foreach($fd_para as $key=>$val){
    if($val[type]!=4){
	  $para=$$val[para];
	}else{
	  $para="";
	  for($i=1;$i<=$$val[para];$i++){
	  $para1p="para".$val[id]."_".$i;
	  $para2p=$$para1p;
	  $para=($para2p<>"")?$para.$para2p."-":$para;
	  }
	  $para=substr($para, 0, -1);
	}
	$para=strip_tags($para);
if($val[type]!=5){
$body=$body."<b>".$val[name]."</b>:".$para."<br>";
}else{
$para=$para<>""?"<a href=".$gz_weburl."upload/file/".$para." >".$gz_weburl."upload/file/".$para."</a>":$para;
$body=$body."<b>".$val[name]."</b>:".$para."<br>";
}
}

$body=$body."<b>{$lang_FeedbackProduct}</b>:".$fdtitle."<br>";
$body=$body."<b>{$lang_IP}</b>:".$ip."<br>";
$body=$body."<b>{$lang_AddTime}</b>:".$addtime."<br>";
$body=$body."<b>{$lang_SourcePage}</b>:".$fromurl;
jmailsend($from,$fromname,$to,$title,$body,$usename,$usepassword,$smtp,$fdto);
}
if($gz_fd_back==1){
jmailsend($from,$fromname,$fdto,$gz_fd_title,$gz_fd_content,$usename,$usepassword,$smtp);
}

okinfo($returnurl,"{$lang_Feedback4}");
}
else{
$query = "SELECT * FROM $gz_parameter where lang='$lang' and  module=8 and class1='$id' order by no_order";
if($gz_member_use)$query = "select * from $gz_parameter where (access in(select id from $gz_admin_array where user_webpower<='$metinfo_member_type') or access=0) and lang='$lang' and module=8 and class1='$id' order by no_order;";
$result = $db->query($query);
while($list= $db->fetch_array($result)){
 if($list[type]==2 or $list[type]==4 or $list[type]==6){
    $listinfo=$db->get_one("select * from $gz_list where bigid='$list[id]' and no_order=99999");
	$listinfoid=intval(trim($listinfo[info]));
	if($listinfo){
	$listmarknow='metinfo';
	$classtype=($listinfo[info]=='metinfoall')?$listinfoid:($gz_class[$listinfoid][releclass]?'class1':'class'.$class_list[$listinfoid][classtype]);
    $query1 = "select * from $gz_product where lang='$lang' and $classtype='$listinfoid' order by updatetime desc";
   $result1 = $db->query($query1);
   $i=0;
   while($list1 = $db->fetch_array($result1)){
   	 $list1[info]=$list1[title];
	 $i++;
	 $list1[no_order]=$i;
   $paravalue[$list[id]][]=$list1;
   }
    }else{
   $query1 = "select * from $gz_list where lang='$lang' and bigid='".$list[id]."' order by no_order";
   $result1 = $db->query($query1);
   while($list1 = $db->fetch_array($result1)){
   $paravalue[$list[id]][]=$list1;
   }
   }}
if($list[wr_ok]=='1')$list[wr_must]="*";
switch($list[type]){
case 1:
$list[input]="<input name='para$list[id]' type='text' size='30' class='input-text' />";
break;
case 2:
$list[input]="<select name='para$list[id]'><option selected='selected' value=''>{$lang_Choice}</option>";
foreach($paravalue[$list[id]] as $key=>$val){
$list[input]=$list[input]."<option value='$val[info]'>$val[info]</option>";
}
$list[input]=$list[input]."</select>";
break;
case 3:
$list[input]="<textarea name='para$list[id]' class='textarea-text' cols='50' rows='5'></textarea>";
break;
case 4:
$i=0;
foreach($paravalue[$list[id]] as $key=>$val){
$i++;
$list[input]=$list[input]."<input name='para$list[id]_$i' class='checboxcss' id='para$i$list[id]' type='checkbox' value='$val[info]' /><label for='para$i$list[id]'>$val[info]</label>&nbsp;&nbsp;";
}
$list[input]=$list[input]."<input name='para$list[id]' type='hidden' value='$i' />";
$lagernum[$list[id]]=$i;
break;
case 5:
$list[input]="<input name='para$list[id]' type='file' class='input' size='20' >";
break;
case 6:
$i=0;
foreach($paravalue[$list[id]] as $key=>$val){
$checked='';
$i++;
if($i==1)$checked="checked='checked'";
$list[input]=$list[input]."<input name='para$list[id]' type='radio' id='para$i$list[id]' value='$val[info]' $checked /><label for='para$i$list[id]'>$val[info]</label>  ";
 }
break;
}
$fd_para[]=$list;
if($list[wr_ok])$fdwr_list[]=$list;
}
}
$fdjs="<script language='javascript'>";
$fdjs=$fdjs."function Checkfeedback(){ ";
foreach($fdwr_list as $key=>$val){
if($val[type]==1 or $val[type]==2 or $val[type]==3 or $val[type]==5){
$fdjs=$fdjs."if (document.myform.para$val[id].value.length == 0) {\n";
$fdjs=$fdjs."alert('$val[name] {$lang_Empty}');\n";
$fdjs=$fdjs."document.myform.para$val[id].focus();\n";
$fdjs=$fdjs."return false;}\n";
}elseif($val[type]==4){
 $lagerinput="";
 for($j=1;$j<=count($paravalue[$val[id]]);$j++){
 $lagerinput=$lagerinput."document.myform.para$val[id]_$j.checked ||";
 }
 $lagerinput=$lagerinput."false\n";
 $fdjs=$fdjs."if(!($lagerinput)){\n";
 $fdjs=$fdjs."alert('$val[name] {$lang_Empty}');\n";
 $fdjs=$fdjs."document.myform.para$val[id]_1.focus();\n";
 $fdjs=$fdjs."return false;}\n";
}
}
$fdjs=$fdjs."}";
$fdjs=$fdjs."function verification(){ ";
$fdjs=$fdjs."document.getElementById('new_code').click();}\n";
$fdjs=$fdjs."</script>";

$class2=$class_list[$class1][releclass]?$class1:$class2;
$class1=$class_list[$class1][releclass]?$class_list[$class1][releclass]:$class1;
$class_info=$class2?$class2_info:$class1_info;
if($class2!=""){
$class_info[name]=$class2_info[name]."--".$class1_info[name];
}

     $show[description]=$class_info[description]?$class_info[description]:$gz_description;
     $show[keywords]=$class_info[keywords]?$class_info[keywords]:$gz_keywords;
	 $gz_title=$gz_title?$navtitle.'-'.$gz_title:$navtitle;
	 if($class_info['ctitle']!='')$gz_title=$class_info['ctitle'];
if(count($nav_list2[$classaccess[id]])){
$k=count($nav_list2[$class1]);
$nav_list2[$class1][$k]=$class1_info;
}
require_once '../public/php/methtml.inc.php';

     $methtml_feedback.=$fdjs;
     $methtml_feedback.="<form enctype='multipart/form-data' method='POST' name='myform' onSubmit='return Checkfeedback();' action='index.php?action=add&lang=".$lang."' target='_self'>\n";
     $methtml_feedback.="<table cellpadding='2' cellspacing='1'  bgcolor='#F2F2F2' align='center' class='feedback_table' >\n";
    foreach($fd_para as $key=>$val){
     $methtml_feedback.="<tr class=feedback_tr bgcolor='#FFFFFF'    height='25'  >\n";
     $methtml_feedback.="<td class=feedback_td1 align='right' width='20%'>".$val[name]."&nbsp;</td>\n";
     $methtml_feedback.="<td class=feedback_input width='70%'>".$val[input]."<span>{$val[description]}</span></td>\n";
     $methtml_feedback.="<td class=feedback_info><span style='color:#990000'>".$val[wr_must]."</span></td>\n";
     $methtml_feedback.="</tr>\n";
    }
if($gz_memberlogin_code==1){  
     $methtml_feedback.="<tr><td class='text'>".$lang_memberImgCode."</td>\n";
     $methtml_feedback.="<td class='input'><input name='code' onKeyUp='pressCaptcha(this)' type='text' class='code' id='code' size='6' maxlength='8' style='width:50px' onclick=verification() >";
     $methtml_feedback.="<img align='absbottom' id='new_code' src='../member/ajax.php?action=code'  onclick=this.src='../member/ajax.php?action=code&'+Math.random() style='cursor: pointer;' title='".$lang_memberTip1."'/>";
     $methtml_feedback.="</td>\n";
     $methtml_feedback.="</tr>\n";
}
     $methtml_feedback.="<tr><td colspan='3' bgcolor='#FFFFFF' class=feedback_submit align='center'>\n";
     $methtml_feedback.="<input type='hidden' name='fdtitle' value='".$title."' />\n";
     $methtml_feedback.="<input type='hidden' name='fromurl' value='".$fromurl."' />\n";
     $methtml_feedback.="<input type='hidden' name='lang' value='".$lang."' />\n";
     $methtml_feedback.="<input type='hidden' name='ip' value='".$ip."' />\n";
	 $methtml_feedback.="<input type='hidden' name='totnum' value='".count($fd_para)."' />\n";
	 $methtml_feedback.="<input type='hidden' name='id' value='".$id."' />\n";
     $methtml_feedback.="<input type='submit' name='Submit' value='".$lang_Submit."' class='tj'>\n";
     $methtml_feedback.="<input type='reset' name='Submit' value='".$lang_Reset."' class='tj'></td></tr>\n";
     $methtml_feedback.="</table>\n";
     $methtml_feedback.="</form>\n";
	if(!$title){
		foreach($settings_arr as $key=>$val){
			if($val['columnid']==$id && $val['name']=='gz_fdtable'){
				$title=$val['value'];
			}
		}
	}
include template('feedback');
footer();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>