<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
function skin_desc($txt,$type){
	$metcms=$type?$txt:'';
	if(strstr($txt,'$DESC$')){
		$metcmsx=explode('$DESC$',$txt);
		$metcms=$type?$metcmsx[0]:$metcmsx[1];
	}
	return $metcms;
}
function linkrules($listc){
	global $gz_weburl,$lang;
		$modulename[1] = array(0=>'show',1=>'show');
		$modulename[2] = array(0=>'news',1=>'shownews');
		$modulename[3] = array(0=>'product',1=>'showproduct');
		$modulename[4] = array(0=>'download',1=>'showdownload');
		$modulename[5] = array(0=>'img',1=>'showimg');
		$modulename[6] = array(0=>'job',1=>'showjob');
		$modulename[7] = array(0=>'message',1=>'index');
		$modulename[8] = array(0=>'feedback',1=>'index');	
		$modulename[9] = array(0=>'link',1=>'index');	
		$modulename[10]= array(0=>'member',1=>'index');	
		$modulename[11]= array(0=>'search',1=>'search');	
		$modulename[12]= array(0=>'sitemap',1=>'sitemap');
		$modulename[100]= array(0=>'product',1=>'showproduct');
		$modulename[101]= array(0=>'img',1=>'showimg');
		$urltop = $gz_weburl.$listc['foldername'].'/';
		$langmark='lang='.$lang;
		switch($listc['module']){
			default:
				$urltop2 = $urltop.$modulename[$listc['module']][0].'.php?'.$langmark;
				if($listc['releclass']){
					$listc['url']=$urltop2."&class1=".$listc['id'];
				}else{
					$classtypenum=$cache_column[$listc['bigclass']]['releclass']?$listc['classtype']-1:$listc['classtype'];
					switch($classtypenum){
						case 1:
						$listc['url']=$urltop2."&class1=".$listc['id'];
						break;
						case 2:
						$listc['url']=$urltop2."&class2=".$listc['id'];
						break;
						case 3:
						$listc['url']=$urltop2."&class3=".$listc['id'];
						break;
					}
				}
				break;
			case 1:
				if($listc['isshow']!=0){
					$listc['url']=$urltop.'show.php?'.$langmark.'&id='.$listc['id'];
				}
				break;
			case 6:
				$listc['url']=$urltop.'index.php?'.$langmark;
				break;
			case 7:
				$listc['url']=$urltop.'index.php?'.$langmark;
				break;
			case 8:
				$listc['url']=$urltop.'index.php?'.$langmark.'&id='.$listc['id'];
				break;
			case 9:
			case 10:
			case 12:
				$listc['url']=$urltop.'index.php?'.$langmark;
				break;	
			case 11:
				$listc['url']=$urltop.'index.php?'.$langmark;
				break;
		}
	return $listc['url'];
}
/*去除空格*/
function metdetrim($str){
    $str = trim($str);
    $str = ereg_replace("\t","",$str);
    $str = ereg_replace("\r\n","",$str);
    $str = ereg_replace("\r","",$str);
    $str = ereg_replace("\n","",$str);
    $str = ereg_replace(" ","",$str);
	$str = strtolower($str);
    return trim($str);
}
/*验证邮箱地址*/
function is_email($user_email){
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false){
        if (preg_match($chars, $user_email)){
            return true;
        }
        else{
            return false;
        }
    }else{
        return false;
    }
}
/*数组输出*/
function dump($vars, $label = '', $return = false){
    if (ini_get('html_errors')){
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n</pre>\n";
    } else {
        $content = $label . " :\n" . print_r($vars, true);
    }
    if ($return) { return $content; }
    echo $content;
    return null;
}
/*编码转换*/
function is_utf8($liehuo_net){
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$liehuo_net) == true){
		return true;
	}else{
		return false;
	}
}
/*截取字符串长度*/
function utf8Substr($str, $from, $len){
	$len = preg_match("/[\x7f-\xff]/", $str)?$len:$len*2;
	if(mb_strlen($str,'utf-8')>intval($len)){
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
		'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
		'$1',$str)."..";
	}else{
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
		'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
		'$1',$str); 
	}
}
/*POST变量转换*/
function daddslashes($string, $force = 0 ,$sql_injection =0,$url =0){
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	if(is_array($string)){
		if($url){
			//$string='';
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		}else{
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		}
	}else{
		if(SQL_DETECT!=1 || $sql_injection==1){
			$string = str_ireplace("\"","/",$string);
			$string = str_ireplace("'","/",$string);
			$string = str_ireplace("*","/",$string);
			$string = str_ireplace("~","/",$string);
			$url = str_ireplace("\"","/",$url);
			$url = str_ireplace("'","/",$url);
			$url = str_ireplace("*","/",$url);
			$url = str_ireplace("~","/",$url);
			$string = str_ireplace("select", "\sel\ect", $string);
			$string = str_ireplace("insert", "\ins\ert", $string);
			$string = str_ireplace("update", "\up\date", $string);
			$string = str_ireplace("delete", "\de\lete", $string);
			$string = str_ireplace("union", "\un\ion", $string);
			$string = str_ireplace("into", "\in\to", $string);
			$string = str_ireplace("load_file", "\load\_\file", $string);
			$string = str_ireplace("outfile", "\out\file", $string);
			$string = str_ireplace("sleep", "\sle\ep", $string);
			$string = str_ireplace("where", "\where", $string);
			$string_html=$string;
			$string = strip_tags($string);
			if($string_html!=$string){
				$string='';
			}
			$string = str_replace("%", "\%", $string);     //   
		}
	}

	return $string;
}
/*模板加载*/
function template($template,$EXT="html"){
	global $gz_skin_name,$skin;
	if(empty($skin)){
	    $skin = $gz_skin_name;
	}
	unset($GLOBALS[con_db_id],$GLOBALS[con_db_pass],$GLOBALS[con_db_name]);
	$path = ROOTPATH_ADMIN."templates/$skin/$template.$EXT";
	!file_exists($path) && $path=ROOTPATH_ADMIN."templates/met/$template.$EXT";
	return  $path;
}
function template_app($template,$EXT="html"){
	unset($GLOBALS[con_db_id],$GLOBALS[con_db_pass],$GLOBALS[con_db_name]);
	$path = ROOTPATH_ADMIN."app/$template.$EXT";
	return  $path;
}

/*页面输出*/
function footer(){
	global $output;
	$output = str_replace(array('<!--<!---->','<!---->','<!--fck-->','<!--fck','fck-->','',"\r",substr($admin_url,0,-1)),'',ob_get_contents());
    ob_end_clean();
	echo $output;
	mysql_close();
	exit;
}
/*删掉多余页面*/
function delnull($htm){
	$htmjs=$htm;
	$htmjs_array=explode('$|$',$htmjs);
	$htmjs='';
	foreach($htmjs_array as $key=>$val){
		if($val!=''){
			$htmjs.=$val.'$|$';
		}
	}
	$htmjs=trim($htmjs,'$|$');
	return $htmjs;
}
/*页面跳转*/
function metsave($url,$text,$depth,$htm,$gent,$prent){
global $db,$gz_config,$lang,$gz_sitemap_auto,$adminmodify,$gz_weburl,$gz_adminfile,$lang_physicaldelok;
	if(strstr($url, 'app/dlapp/')){
		header('location:'.$gz_weburl.$gz_adminfile.'/index.php?anyid=44&n=myapp&c=myapp&a=doindex&lang='.$lang.'&turnovertext='.$lang_physicaldelok);
		die();
	}
	$htm=$htm!=''?delnull($htm):'';
	$url=$url=='-1'?$url:urlencode($url);
	$text=urlencode($text);
	$gent=urlencode($gent);
	if($gz_sitemap_auto==0)$gent='';
	if($htm){
		$query = "INSERT INTO $gz_config SET name='metsave_html_list',value='{$htm}',lang='{$lang}'";
		$db->query($query);
		$htm=mysql_insert_id();
	}
	$url=$depth."../include/turnover.php?geturl={$url}&adminmodify={$adminmodify}&text={$text}&gent={$gent}&hml={$htm}&prent={$prent}";
	echo("<script type='text/javascript'>location.href='{$url}';</script>");
	exit;
}
/*alert页面跳转*/
function okinfo($url,$langinfo){
	echo("<script type='text/javascript'> alert('$langinfo'); location.href='$url'; </script>");
	exit;
}
/*主导航显示-根据导航类型返回代码*/
function navdisplay($nav){
global $lang_funNav1,$lang_funNav2,$lang_funNav3,$lang_funNav4;
	switch($nav){
		case '0':$nav=$lang_funNav1;break;
		case '1':$nav="<font class='red'>$lang_funNav2</font>";break;
		case '2':$nav="<font class='blue'>$lang_funNav3</font>";break;
		case '3':$nav="<font class='green'>$lang_funNav4</font>";break;
	}
	return $nav;
}
/*权限设置-根据权限返回代码*/
function accessdisplay($access){
global $lang_access1,$lang_access2,$lang_access3,$lang_access0;
	switch($access){
		case '1':$access=$lang_access1;break;
		case '2':$access=$lang_access2;break;
		case '3':$access=$lang_access3;break;
		default :$access=$lang_access0;break;
	}
	return $access;
}
/*模块设置-根据模块编号返回模块名*/
function module($module){
global $lang_modout,$lang_mod1,$lang_mod2,$lang_mod3,$lang_mod4,$lang_mod5,$lang_mod6,$lang_mod7,$lang_mod8,$lang_mod9,$lang_mod10,$lang_mod11,$lang_mod12,$lang_mod100,$lang_mod101;
switch($module){
case '0':
$module="<font color=red>$lang_modout</font>";
break;
case '1':
$module=$lang_mod1;
break;
case '2':
$module=$lang_mod2;
break;
case '3':
$module=$lang_mod3;
break;
case '4':
$module=$lang_mod4;
break;
case '5';
$module=$lang_mod5;
break;
case '6':
$module=$lang_mod6;
break;
case '7':
$module=$lang_mod7;
break;
case '8':
$module=$lang_mod8;
break;
case '9':
$module=$lang_mod9;
break;
case '10':
$module=$lang_mod10;
break;
case '11':
$module=$lang_mod11;
break;
case '12':
$module=$lang_mod12;
break;
case '100':
$module=$lang_mod100;
break;
case '101':
$module=$lang_mod101;
break;
}

return $module;
}
/*删除文件*/
function file_unlink($file_name) {
	if(stristr(PHP_OS,"WIN")){
		$file_name=@iconv("utf-8","gbk",$file_name);
	}
	if(file_exists($file_name)) {
		//@chmod($file_name,0777);
		$area_lord = @unlink($file_name);
	}
	return $area_lord;
}

function unescape($str){ 
    $ret = ''; 
    $len = strlen($str); 

    for ($i = 0; $i < $len; $i++) { 
        if ($str[$i] == '%' && $str[$i+1] == 'u') { 
            $val = hexdec(substr($str, $i+2, 4)); 

            if ($val < 0x7f) $ret .= chr($val); 
            else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f)); 
            else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f)); 

            $i += 5; 
        }else if ($str[$i] == '%') { 
            $ret .= urldecode(substr($str, $i, 3)); 
            $i += 2; 
        } 
        else $ret .= $str[$i]; 
    } 
    return $ret; 
}

/*删除文件夹下所有文件*/
function is_empty_dir($pathdir)
{
//判断目录是否为空，我的方法不是很好吧？只是看除了.和..之外有其他东西不是为空
$d=opendir($pathdir);
$i=0;
      while($a=readdir($d))
      {
      $i++;
      }
closedir($d);
if($i>2){return false;}
else return true;
}
function deltree($pathdir)
{

          $d=dir($pathdir);
          while($a=$d->read())
          {
          if(is_file($pathdir.'/'.$a) && ($a!='.') && ($a!='..')){unlink($pathdir.'/'.$a);}
          //如果是文件就直接删除
          if(is_dir($pathdir.'/'.$a) && ($a!='.') && ($a!='..'))
          {//如果是目录
              if(!is_empty_dir($pathdir.'/'.$a))//是否为空
              {//如果不是，调用自身，不过是原来的路径+他下级的目录名
              deltree($pathdir.'/'.$a);
              }
              if(is_empty_dir($pathdir.'/'.$a))
              {//如果是空就直接删除
              rmdir($pathdir.'/'.$a);
              }
          }
          }
          $d->close();
      }
/*静态页面生成*/
function createhtm($fromurl,$filename,$htmpack,$indexy=0){
	global $lang_funFile,$lang_funTip1,$lang_funCreate,$lang_funFail,$lang_funOK,$gz_member_force,$gz_member_use,$gz_sitemap_xml,$gz_weburl,$adminfile;
	if($gz_member_use!=0)$fromurl=(strstr($fromurl,'?'))?$fromurl."&metmemberforce=".$gz_member_force:$fromurl."?metmemberforce=".$gz_member_force;
	if($gz_sitemap_xml==1&&strstr($fromurl,'sitemap.php'))$fromurl=(strstr($fromurl,'?'))?$fromurl."&htmxml=".$gz_member_force:$fromurl."?htmxml=".$gz_member_force;
	$fromurl.="&html_filename=".$filename."&metinfonow=$gz_member_force";
	if($htmpack)$fromurl.='&htmpack='.$htmpack.'&adminfile='.$adminfile;
	if($indexy)$fromurl.='&indexy='.$indexy;
	return $fromurl;
}

/*列表页面排序*/
function list_order($listid){
	switch($listid){
		case '0':
		$list_order=" order by top_ok desc,no_order desc,updatetime desc";
		return $list_order;
		break;

		case '1':
		$list_order=" order by top_ok desc,no_order desc,updatetime desc";
		return $list_order;
		break;

		case '2':
		$list_order=" order by top_ok desc,no_order desc,addtime desc";
		return $list_order;
		break;

		case '3':
		$list_order=" order by top_ok desc,no_order desc,hits desc";
		return $list_order;
		break;

		case '4':
		$list_order=" order by top_ok desc,no_order desc,id desc";
		return $list_order;
		break;

		case '5':
		$list_order=" order by top_ok desc,no_order desc,id";
		return $list_order;
		break;
		
		default :
		$list_order=" order by top_ok desc,no_order desc,updatetime desc";
		return $list_order;
		break;
	}
}

/*删除HTML代码*/
function dhtmlchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dhtmlchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
		str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}
/*判断代码是否为空*/
function isblank($str) {
	if(eregi("[^[:space:]]",$str)) { return 0; } else { return 1; }
	return 0;
}
$php_text=$db->get_one("SELECT * FROM $gz_mysql where id=1");
/*代码加密后用URL传递*/
 function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

        $ckey_length = 4; 

        $key = md5($key ? $key : UC_KEY);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }

    }
/*首页生成*/
function indexhtm($htmway=0,$htmpack=0){
	global $lang,$gz_webhtm,$gz_htmty,$gz_htmway,$gz_index_type;
	$gz_htmway=$htmway?0:$gz_htmway;
	if($gz_webhtm!=0 && $gz_htmway==0){
		$fromurl="index.php?lang=".$lang;
		$filename="index";
		$indexy = 'index';
		return createhtm($fromurl,$filename,$htmpack,$indexy);
	}
}
/*内容页HTML代码生成*/
function contenthtm($class1,$id,$phpfilename,$htmlname,$htmway=0,$folder,$addtime,$htmpack=0){
	global $lang,$gz_webhtm,$gz_htmpagename,$m_now_time,$gz_column,$gz_htmway,$gz_class;
	$gz_htmway=$htmway?0:$gz_htmway;
	if($gz_webhtm!=0 && $gz_htmway==0){
		if($addtime!=""){
			$addtime     = date('Ymd',strtotime($addtime));
		}else{
			$addtime     = date('Ymd',$m_now_time);
		}
		if($folder!=""){
			$foldername=$folder;
		}else{
			$foldername=$gz_class[$class1][foldername];
		}
		switch($gz_htmpagename){
			case 0:
			$pagename=$phpfilename.$id;
			break;
			case 1:
			$pagename=$addtime.$id;
			break;
			case 2:
			$pagename=$foldername.$id;
			break;
		}
		$fromurl=$foldername."/".$phpfilename.".php?id=".$id."&lang=".$lang;
		if($htmlname<>''){
			$filename=$htmlname;
			$indexy = 1;
		}else{
			$filename=$pagename;
			$indexy = 0;
		}
		return createhtm($fromurl,$filename,$htmpack,$indexy);
	}
}
$php_text=explode('|',$php_text[data]);
/*模块HTML代码生成*/
function classhtm($class1,$class2,$class3,$htmway=0,$classtype=0,$htmpack=0){
	global $lang,$gz_webhtm,$gz_listhtmltype,$gz_htmlistname,$m_now_time,$db,$gz_class,$gz_module,$metadmin,$gz_index_type;
	global $gz_config,$gz_column,$gz_news,$gz_product,$gz_download,$gz_img,$gz_job,$gz_message,$gz_feedback,$gz_htmway;
	global $gz_news_list,$gz_product_list,$gz_download_list,$gz_img_list,$gz_job_list,$gz_message_list,$gz_feedback_list,$gz_product_page;
	global $gz_classindex2;
	$gz_htmway=$htmway?0:$gz_htmway;
	if($gz_webhtm==2 && $gz_htmway==0){
		$class1_info=$gz_class[$class1];
		switch($class1_info['module']){
			case 2:
				$tablename=$gz_news;
				$pagesize=$gz_news_list;
				$phpfilename="news";
				break;
			case 3:
				$tablename=$gz_product;
				$pagesize=$gz_product_list;
				$phpfilename="product";
				break;
			case 4:
				$tablename=$gz_download;
				$pagesize=$gz_download_list;
				$phpfilename="download";
				break;
			case 5:
				$tablename=$gz_img;
				$pagesize=$gz_img_list;
				$phpfilename="img";
				break;
			case 6:
				$tablename=$gz_job;
				$pagesize=$gz_job_list;
				$phpfilename="job";
				break;
			case 7:
				$tablename=$gz_message;
				$pagesize=$gz_message_list;
				$phpfilename="index";
				break;
			case 8:
				$tablename=$gz_feedback;
				$pagesize=$gz_feedback_list;
				$phpfilename="feedback";
				break;
		}
		$foldername=$class1_info['foldername'];
		switch($gz_htmlistname){
			case 0:
				$pagename=$phpfilename.$id;
				break;
			case 1:
				$pagename=$foldername.$id;
				break;
		}
		if($class1_info[module]<6){
			$class1sql=" class1='$class1' ";
			if($class1_info[module]>=2&&$class1_info[module]<=5){
				foreach($gz_classindex2[$class1_info[module]] as $key=>$val){
				if($val['releclass']==$class1_info[id]&&$val['releclass']>0){
						$class1re.=" or class1='$val[id]' ";
					}
				}
				if($class1re){
					$class1sql='('.$class1sql.$class1re.')';
				}
			}
			if($class1_info[module]==3){
				$total_count = $db->counter($tablename, " where lang='".$lang."' and (".$class1sql." or classother REGEXP '/|-{$class1}-[0-9]*-[0-9]*-|/') and (recycle='0' or recycle='-1')", "*");
			}else{
				$total_count = $db->counter($tablename, " where lang='".$lang."' and ".$class1sql." and (recycle='0' or recycle='-1')", "*");
			}
		}elseif($class1_info[module]==7){
			$query="select * from $gz_config where name='gz_fd_type' and columnid=$class1_info[id]";
			$gz_fd_type=$db->get_one($query);
			$sqls=($gz_fd_type[value]==1)?" where lang='".$lang."' and readok='1'":"";
			$total_count = $db->counter($tablename, $sqls, "*");
		}else{
			$total_count = $db->counter($tablename, "where lang='".$lang."' ", "*");
		}
		$page_count=ceil($total_count/$pagesize);
		$page_count=$page_count?$page_count:1;
		$indexname=0;
		if($class1_info['classtype']==1||$class1_info['releclass']){
			$dbtxt=$class1_info['releclass']?2:1;
			$folderone=$db->get_one("SELECT * FROM $gz_column WHERE foldername='$class1_info[foldername]' and id !='$class1_info[id]' and classtype='$dbtxt' and lang='$lang' and (module!=100 or module!=101)");
			if(!$folderone){
				$indexname='index';
				if($class1_info['lang']!=$gz_index_type)$indexname=0;
			}
		}
		if($class1_info['module']>5 && $class1_info['module']<13 && $class1_info['lang']==$gz_index_type)$indexname='index';
		if($class1_info[module]==3 and ($classtype==0 or $classtype==1)){
			$classproduct_info=$gz_module[100][0];
			if($classproduct_info[nav]){
				if($gz_product_page){
					$fromurl="product/product.php?lang=".$lang;
					if($metadmin[pagename] and $classproduct_info[filename]<>""){
						$filename=$classproduct_info[filename];
						$indexy = 1;
					}else{
						$filename="product_".$classproduct_info[id]."_1";
						$indexy = 0;
					}
					$metrn .= createhtm($fromurl,$filename,$htmpack,$indexy).'$|$';
				}else{
					$total_countproduct = $db->counter($gz_product, " where lang='".$lang."' ", "*");
					$page_countproduct=ceil($total_countproduct/$gz_product_list);
					$page_countproduct=$page_countproduct?$page_countproduct:1;
					for($i=1;$i<=$page_countproduct;$i++){
						$fromurl="product/product.php?lang=".$lang."&page=".$i;
						if($metadmin['pagename'] and $classproduct_info['filename']<>""){
							$filename=$classproduct_info['filename']."_".$i;
							$indexy =1;
						}else{
							$filename="product_".$classproduct_info[id]."_".$i;
							$indexy =0;
						}
						$metrn .= createhtm($fromurl,$filename,$htmpack,$indexy).'$|$';
					}
				 }
			}
		}
		if($class1_info[module]==5 and ($classtype==0 or $classtype==1)){
			$classimg_info=$gz_module[101][0];
			if($classimg_info[nav]){
				if($gz_img_page){
					$fromurl="img/img.php?lang=".$lang;
					if($metadmin[pagename] and $classimg_info[filename]<>""){
						$filename=$classimg_info[filename]."_1";
						$indexy =1;
					}else{
						$filename="img_".$classimg_info[id]."_1";
						$indexy =0;
					}
					$metrn .= createhtm($fromurl,$filename,$htmpack,$indexy).'$|$';
				}else{
					$total_countimg = $db->counter($gz_img, " where lang='".$lang."' ", "*");
					$page_countimg=ceil($total_countimg/$gz_img_list);
					$page_countimg=$page_countimg?$page_countimg:1;
					for($i=1;$i<=$page_countimg;$i++){
						$fromurl="img/img.php?lang=".$lang."&page=".$i;
						if($metadmin[pagename] and $classimg_info[filename]<>""){
							$filename=$classimg_info[filename]."_".$i;
							$indexy = 1;
						}else{
							$filename="img_".$classimg_info[id]."_".$i;
							$indexy =0;
						}
						$metrn .= createhtm($fromurl,$filename,$htmpack,$indexy).'$|$';
					}
				}
			}
		}
		if($class1_info[module]==3 && $gz_product_page && $class2)$page_count=1;
		if($class1_info[module]==5 && $gz_img_page && $class2)$page_count=1;
		if($classtype==0 or $classtype==1){
			for($i=1;$i<=$page_count;$i++){
				$fromurl=$foldername."/".$phpfilename.".php?class1=".$class1."&page=".$i."&lang=".$lang;
				if($metadmin['pagename'] and $gz_class[$class1]['filename']<>""){
					$filename=$gz_class[$class1]['filename']."_".$i;
					$indexy =1;
				}else{
					if($gz_class[$class1]['module']==7)$class1="list";
					$filename=$pagename."_".$class1."_".$i;
					$indexy =0;
				}
				if($indexname && $i==1)$metrn .= createhtm($fromurl,$indexname,$htmpack,$indexy).'$|$';
				$metrn .= createhtm($fromurl,$filename,$htmpack,$indexy).'$|$';
			}
		}
		if($class2!=0 and ($classtype==0 or $classtype==2)){
			if($class1_info[module]==3){
				$total_count = $db->counter($tablename, " where lang='".$lang."' and ((class1=".$class1." and class2=".$class2.") or classother REGEXP '/|-{$class1}-{$class2}-[0-9]*-|/') and (recycle='0' or recycle='-1')", "*");
			}else{
				$total_count = $db->counter($tablename, " where lang='".$lang."' and class1=".$class1." and class2=".$class2." and (recycle='0' or recycle='-1')", "*");
			}
			$page_count=ceil($total_count/$pagesize);
			$page_count=$page_count?$page_count:1;
			if($class1_info[module]==3 && $gz_product_page && $class3)$page_count=1;
			if($class1_info[module]==5 && $gz_img_page && $class3)$page_count=1;
			for($i=1;$i<=$page_count;$i++){
				$fromurl=$foldername."/".$phpfilename.".php?class1=".$class1."&class2=".$class2."&page=".$i."&lang=".$lang;
				if($metadmin[pagename] and $gz_class[$class2][filename]<>""){
					$filename=$gz_class[$class2][filename]."_".$i;
					$indexy =1;
				}else{
					$filename= ($gz_listhtmltype==0)?$pagename."_".$class1."_".$class2."_".$i:$pagename."_".$class2."_".$i;
					$indexy =0;
				}
				$metrn .= createhtm($fromurl,$filename,$htmpack,$indexy).'$|$';
			}
		}
		if($class3!=0 and ($classtype==0 or $classtype==3)){
			if($class1_info[module]==3){
				$total_count = $db->counter($tablename, " where lang='".$lang."' and ((class1=".$class1." and class2=".$class2." and class3=".$class3.") or classother REGEXP '/|-{$class1}-{$class2}-{$class3}-|/') and (recycle='0' or recycle='-1')", "*");
			}else{
				$total_count = $db->counter($tablename, " where lang='".$lang."' and class1=".$class1." and class2=".$class2." and class3=".$class3." and (recycle='0' or recycle='-1')", "*");
			}
			$page_count=ceil($total_count/$pagesize);
			$page_count=$page_count?$page_count:1;
			for($i=1;$i<=$page_count;$i++){
				$fromurl=$foldername."/".$phpfilename.".php?class1=".$class1."&class2=".$class2."&class3=".$class3."&page=".$i."&lang=".$lang;
				if($metadmin[pagename] and $gz_class[$class3][filename]<>""){
					$filename=$gz_class[$class3][filename]."_".$i;
					$indexy =1;
				}else{
					$filename= ($gz_listhtmltype==0)?$pagename."_".$class1."_".$class2."_".$class3."_".$i:$pagename."_".$class3."_".$i;
					$indexy =0;
				}
				$metrn .= createhtm($fromurl,$filename,$htmpack,$indexy).'$|$';
			}
		}
		return $metrn;
	}
}
/*删除静态页面*/
function deletepage($foldername,$id,$phpfilename,$updatetime,$htmlname){
global $lang,$gz_htmtypeadmin,$gz_htmpagename,$depth;
switch($gz_htmpagename){
case 0:
$pagename=$phpfilename.$id;
break;
case 1:
$pagename=$updatetime.$id;
break;
case 2:
$pagename=$foldername.$id;
break;
}
if($htmlname<>""){
$filename=$depth."../../".$foldername."/".$htmlname.$gz_htmtypeadmin;
}else{
$filename=$depth."../../".$foldername."/".$pagename.$gz_htmtypeadmin;
}
if(stristr(PHP_OS,"WIN")){
	$filename=@iconv("utf-8","GBK",$filename);
}
if(file_exists($filename))@unlink($filename);
}
/*简介模块静态页面*/
function showhtm($id,$htmway=0,$htmpack=0){
	global $db,$lang,$gz_webhtm,$gz_htmway,$gz_column,$gz_index_type,$gz_class,$gz_class2a,$gz_class1;
	$gz_htmway=$htmway?0:$gz_htmway;
	if($gz_webhtm!=0 && $gz_htmway==0){
		$folder=$db->get_one("select * from $gz_column where id='$id'");
		$fromurl=$folder['foldername']."/show.php?id=".$id."&lang=".$lang;
		$indexname=0;
		if($folder['classtype']==1||$folder['releclass']){
			$dbtxt=$folder['releclass']?2:1;
			$folderone=$db->get_one("SELECT * FROM $gz_column WHERE foldername='$folder[foldername]' and id !='$folder[id]' and classtype='$dbtxt' and lang='$lang'");
			if(!$folderone){
				$indexname='index';
				if($folder['lang']!=$gz_index_type)$indexname=0;
			}
		}
		if($indexname){
			$fromurl=$folder['foldername']."/index.php?id=".$id."&lang=".$lang;
			return createhtm($fromurl,$indexname,$htmpack,$indexy);
		}else{
			$filename=$folder['filename']!=''?$folder['filename']:$folder['foldername'].$id;
			$indexy = $folder['filename']!=''?1:0;
			return createhtm($fromurl,$filename,$htmpack,$indexy);
		}
	}
}
/*列表页静态页面*/
function onepagehtm($foldername,$phpfilename,$htmway=0,$htmpack=0,$filename,$class1){
	global $lang,$gz_webhtm,$gz_htmway;
	$gz_htmway=$htmway?0:$gz_htmway;
	if($gz_webhtm!=0 && $gz_htmway==0){
		if($class1)$class = '&id='.$class1;
		$fromurl=$foldername."/".$phpfilename.".php?lang=".$lang.$class;
		$indexy  = $filename!=''?1:0;
		$filename=$filename!=''?$filename:$phpfilename;
		if($phpfilename=='sitemap'){
			$metrn .= createhtm($fromurl,'index',$htmpack,$indexy).'$|$';
			$metrn .= createhtm($fromurl,$filename,$htmpack,$indexy).'$|$';
			return $metrn;
		}else{
			return createhtm($fromurl,$filename,$htmpack,$indexy);
		}
	}
}
 /*新建栏目生成文件*/
function Copyfile($address,$newfile){
	$oldcont  = "<?php\n# MetInfo Enterprise Content Management System \n# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. \nrequire_once '$address';\n# This program is an open source system, commercial use, please consciously to purchase commercial license.\n# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.\n?>";
	if(!file_exists($newfile)){
		$fp = fopen($newfile,w);
		fputs($fp, $oldcont);
		fclose($fp);
	}
}
 /*新建目录*/
function metnew_dir($pathf){
	global $lang_modFiledir;
	$dirs = explode('/',$pathf);
	$num  = count($dirs) - 1;
	for($i=0;$i<$num;$i++){
		$dirpath .= $i==0?$dirs[$i].'/':$dirs[$i].'/';
		if(!is_dir($dirpath)){
			mkdir($dirpath);
			//if(!chmod($dirpath,0777))die($lang_modFiledir);
		}
	}
}
/*复制首页*/
function Copyindx($newindx,$type){
	if(!file_exists($newindx)){
		$oldcont ="<?php\n# MetInfo Enterprise Content Management System \n# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. \n\$filpy = basename(dirname(__FILE__));\n\$fmodule=$type;\nrequire_once '../include/module.php'; \nrequire_once \$module; \n# This program is an open source system, commercial use, please consciously to purchase commercial license.\n# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.\n?>";
		$fp = fopen($newindx,w);
		fputs($fp, $oldcont);
		fclose($fp);
	}
}
/*生成反馈配置文件*/
function verbconfig($array,$id){
global $lang,$db,$gz_config;
	$query="where columnid='$id' and lang='$lang'";
	$db->counter($gz_config,$query,"*");
	if($db->counter($gz_config,$query,"*")==0){
		foreach($array as $key=>$val){
			$query="insert into $gz_config set name='$val[0]',value='$val[1]',columnid='$id',flashid='0',lang='$lang'";
			$db->query($query);
		}
	}
}
/*全站打包复制图片JS等*/
function xCopy($source, $destination, $child){
    if(!is_dir($source)){
    echo("Error:the $source is not a direction!");
    return 0;
    }
    if(!is_dir($destination)){
    mkdir($destination,0777);
    }
    $handle=dir($source);
    while($entry=$handle->read()){
        if(($entry!=".")&&($entry!="..")){
            if(is_dir($source.'/'.$entry)){
                if($child)xCopy($source."/".$entry,$destination."/".$entry,$child);
            }else{
                copy($source."/".$entry,$destination."/".$entry);
            }
        }
    }
    return true;
}
/*删除目录和其下所有文件*/
function deldir($dir,$dk=1) {
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
  closedir($dh);
  if($dk==0 && $dir!='../../upload')$dk=1;
  if($dk==1){
	  if(rmdir($dir)){
		return true;
	  }else{
		return false;
	  }
  }
}
/*是否是系统模块*/
function unkmodule($filename){
	$modfile = array('about','news','product','download','img','job','cache','config','feedback','include','lang','link','member','message','public','search','sitemap','templates','upload','wap');
	$ok=0;
	foreach($modfile as $key=>$val){
		if($filename==$val)$ok = 1;
	}
	return $ok;
}
/*查看用户类型*/
function metidtype($metid){
	global $db,$gz_admin_table,$lang_access1,$lang_access2,$lang_access3,$lang_feedbackAccess0;
	$feedacs=$db->get_one("select * from $gz_admin_table where admin_id='$metid'");
	$feeda=$feedacs['usertype']==1?$lang_access1:($feedacs['usertype']==2?$lang_access2:($feedacs['usertype']==3?$lang_access3:$lang_feedbackAccess0));
	return $feeda;
}
/*语言权限*/
function admin_poplang($type,$lang){
	$admin_pop=explode(',',$type);
	$popnum=count($admin_pop);
	$poplang='';
	for($i=0;$i<$popnum;$i++){
		if(strstr($admin_pop[$i],$lang.'-'))$poplang=$admin_pop[$i];
	}
	return $poplang;
}
/*模块返回表名*/
function moduledb($module){
	global $gz_column,$gz_product,$gz_img,$gz_news,$gz_download,$gz_job;
	switch($module){
		case 1:
			$moduledb=$gz_column;
			break;
		case 2:
			$moduledb=$gz_news;
			break;
		case 3:
			$moduledb=$gz_product;
		    break;
		case 4:
			$moduledb=$gz_download;
		    break;
		case 5:
			$moduledb=$gz_img;
		    break;
		case 6:
			$moduledb=$gz_job;
		    break;
		case 100:
			$moduledb=$gz_product;
		    break;
		case 101:
			$moduledb=$gz_img;
		    break;
	}
	return $moduledb;
}
/*删除栏目*/
function delcolumn($column){
global $lang,$db,$depth;
global $gz_admin_table,$gz_column,$gz_cv,$gz_download,$gz_feedback,$gz_flist,$gz_img,$gz_job,$gz_link,$gz_list,$gz_message,$gz_news,$gz_parameter,$gz_plist,$gz_product,$gz_config,$gz_mlist;
if($column['releclass']){
$classtype="class1";
}else{
$classtype="class".$column['classtype'];
}
$langcolumn = $column['lang'];
switch ($column['module']){
	default:
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
    break;
	case 2:
	 $query = "select * from $gz_news where $classtype='$column[id]'";
	 $del = $db->get_all($query);
	 delimg($del,2,2);
	 $query = "delete from $gz_news where $classtype='$column[id]'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	break;
	case 3:
	 $query = "select * from $gz_product where $classtype='$column[id]'";
     $del = $db->get_all($query);
	 delimg($del,2,3);
	 foreach($del as $key=>$val){
		$query = "delete from $gz_plist where listid='$val[id]' and module='$column[module]'";
	    $db->query($query);
	 }
	 $query = "delete from $gz_product where $classtype='$column[id]'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	break;
	case 4:
	 $query = "select * from $gz_download where $classtype='$column[id]'";
	 $del = $db->get_all($query);
	 delimg($del,2,4);
	 foreach($del as $key=>$val){
		$query = "delete from $gz_plist where listid='$val[id]' and module='$column[module]'";
	    $db->query($query);
	 }
	 $query = "delete from $gz_download where $classtype='$column[id]'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	break;
	case 5:
	 $query = "select * from $gz_img where $classtype='$column[id]'";
	 $del = $db->get_all($query);
	 delimg($del,2,5);
	 foreach($del as $key=>$val){
		$query = "delete from $gz_plist where listid='$val[id]' and module='$column[module]'";
	    $db->query($query);
	 }
	 $query = "delete from $gz_img where $classtype='$column[id]'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	break;
	case 6:
	$query = "select * from $gz_cv where lang='$langcolumn'";
	$del = $db->get_all($query);
	delimg($del,2,6);	
	 $query = "delete from $gz_plist where lang='$langcolumn' and module='$column[module]'";
	 $db->query($query);
	 $query = "delete from $gz_cv where lang='$langcolumn'";
	 $db->query($query);
	 $query = "delete from $gz_job where lang='$langcolumn'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	break;
	case 7:
	 $query = "delete from $gz_message where lang='$langcolumn'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	 $query="delete from $gz_config where columnid='$column[id]' and lang='$langcolumn'";
	 $db->query($query);
	 $query="delete from $gz_parameter where lang='$langcolumn' and module=7";
	 $db->query($query);
	 $query="delete from $gz_mlist where lang='$langcolumn' and module=7";
	 $db->query($query);
	break;
	case 8:
	 $query = "select * from $gz_feedback where class1='$column[id]'";
	 $del = $db->get_all($query);
	 delimg($del,2,8);
	 foreach($del as $key=>$val){
		$query = "delete from $gz_flist where listid='$list[id]'";
	    $db->query($query);
	 }
	 $query = "delete from $gz_parameter where module='$column[module]' and class1='$column[id]' and lang='$langcolumn'";
	 $db->query($query);
	 $query = "delete from $gz_feedback where class1='$column[id]' and lang='$langcolumn'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	 $query="delete from $gz_config where columnid='$column[id]' and lang='$langcolumn'";
	 $db->query($query);
	break;
	case 9:
	 $query = "delete from $gz_link where lang='$langcolumn'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	break;
	case 10:
	 $query = "delete from $gz_admin_table where usertype!=3 and lang='$langcolumn'";
	 $db->query($query);
	 $query = "delete from $gz_column where id='$column[id]'";
     $db->query($query);
	break;
}
/*删除文件*/
$admin_lists = $db->get_one("SELECT * FROM $gz_column WHERE foldername='$column[foldername]'");
if(!$admin_lists['id'] && ($column['classtype'] == 1 || $column['releclass'])){
	if($column['foldername']!='' && ($column['module']<6 || $column['module']==8) && $column['if_in']!=1){
		if(!unkmodule($column['foldername'])){
			$foldername=$depth."../../".$column['foldername'];
			deldir($foldername);
		}
	}
}
/*删除栏目图片*/
file_unlink($depth."../".$column[indeximg]);
file_unlink($depth."../".$column[columnimg]);

}
/*删除图片*/
/*type1 删除1行，type2 为多行删除，$para_list为空时必须指定模块*/
function delimg($del,$type,$module=0,$para_list=NULL){
global $lang,$db,$depth;
global $gz_admin_table,$gz_column,$gz_cv,$gz_download,$gz_feedback,$gz_flist,$gz_img,$gz_job,$gz_link,$gz_list,$gz_message,$gz_news,$gz_parameter,$gz_plist,$gz_product;
	$table=$module==8?$gz_feedback:$gz_plist;
	if($para_list==NULL&&$module!=2){
		$query = "select * from $gz_parameter where lang='$lang' and module='$module' and (class1='$del[class1]' or class1=0) and type='5'";
		$para_list=$db->get_all($query);
	}
	if($type==1){
		$delnow[]=$del;
	}
	else if($type==2){
		$delnow=$del;
	}
	else{
		$table=moduledb($module);
		$query="select * from $table where id='$id'";
		echo $query;
		$del=$db->get_one($query);
		$delnow[]=$del;
	}	
	foreach($delnow as $key=>$val){
		if($val['recycle']!=2||$module!=2){
			foreach($para_list as $key1=>$val1){
				if(($module==$val1['module']||$val['recycle']==$val1['module'])&&($val1['class1']==0||$val1['class1']==$val['class1'])){
					$imagelist=$db->get_one("select * from $table where lang='$lang' and  paraid='$val1[id]' and listid='$val[id]'");
					file_unlink($depth."../".$imagelist['info']);
					$imagelist['info']=str_replace('watermark/','',$imagelist['info']);
					file_unlink($depth."../".$imagelist['info']);
				}
			}
		}
		if($module==6||$module==8)continue;
		if($val['displayimg']!=NULL){
			$displayimg=explode('|',$val['displayimg']);
			foreach($displayimg as $key2=>$val2){
				$display_val=explode('*',$val2);
				file_unlink($depth."../".$display_val[1]);
				$display_val[1]=str_replace('watermark/','',$display_val[1]);
				file_unlink($depth."../".$display_val[1]);
				$imgurl_diss=explode('/',$display_val[1]);
				file_unlink($depth."../".$imgurl_diss[0].'/'.$imgurl_diss[1].'/'.$imgurl_diss[2].'/thumb_dis/'.$imgurl_diss[count($imgurl_diss)-1]);
				
			}
		}
		if($val['downloadurl']==NULL){
			file_unlink($depth."../".$val['imgurl']);
			file_unlink($depth."../".$val['imgurls']);
			$val['imgurlbig']=str_replace('watermark/','',$val['imgurl']);
			file_unlink($depth."../".$val['imgurlbig']);
			$imgurl_diss=explode('/',$val['imgurlbig']);
			file_unlink($depth."../".$imgurl_diss[0].'/'.$imgurl_diss[1].'/'.$imgurl_diss[2].'/thumb_dis/'.$imgurl_diss[count($imgurl_diss)-1]);
		}
		else{
			file_unlink($depth."../".$val['downloadurl']);
		}
		
		$content[0]=$val[content];
		$content[1]=$val[content1];
		$content[2]=$val[content2];
		$content[3]=$val[content3];
		$content[4]=$val[content4];
		foreach($content as $contentkey=>$contentval){
			if($contentval){
				$tmp1 = explode("<",$contentval);
				foreach($tmp1 as $key=>$val){
					$tmp2=explode(">",$val);
					if(strcasecmp(substr(trim($tmp2[0]),0,3),'img')==0){
						preg_match('/http:\/\/([^\"]*)/i',$tmp2[0],$out);
						$imgs[]=$out[1];
					}
				}
			}
		}
		foreach($imgs as $key=>$val){
			$vals=explode('/',$val);		
			file_unlink($depth."../../upload/images/".$vals[count($vals)-1]);
			file_unlink($depth."../../upload/images/watermark/".$vals[count($vals)-1]);
		}
	}

}

/*文件权限检测*/
function filetest($dir){
	@clearstatcache();
	if(file_exists($dir)){
		//@chmod($dir,0777);
		$str=file_get_contents($dir);
		if(strlen($str)==0)return 0;
		$return=file_put_contents($dir,$str);
	}
	else{
		$filedir='';
		$filedir=explode('/',dirname($dir));
		$flag=0;
		foreach($filedir as $key=>$val){
			if($val=='..'){
				$fileexist.="../";
			}
			else{
				if($flag){
					$fileexist.='/'.$val;
				}
				else{
					$fileexist.=$val;
					$flag=1;
				}
				if(!file_exists($fileexist)){
						@mkdir ($fileexist, 0777);
				}	
			}
		}
		$filename=$fileexist.'/'.basename($dir);
		if(strstr(basename($dir),'.')){
			$fp=@fopen($filename, "w+");
			@fclose($fp);
			//@chmod($filename,0777);
		}
		else{
			@mkdir ($filename, 0777);
		}
		$return=file_put_contents($dir,'metinfo');
	}
	return $return;
}
/*上传图片缩略图尺寸*/
function imgstyle($module){
       global $gz_img_x,$gz_img_y,$gz_productimg_x,$gz_productimg_y,$gz_imgs_x,$gz_imgs_y,$gz_newsimg_x,$gz_newsimg_y,$gz_img_style;
	   if($gz_img_style==1){
			switch($module){
				case '3': 
					$gz_img_x=$gz_productimg_x; 
					$gz_img_y=$gz_productimg_y; 
				break;
				case '5': 
					$gz_img_x=$gz_imgs_x; 
					$gz_img_y=$gz_imgs_y; 
				break;
				case '2': 
					$gz_img_x=$gz_newsimg_x; 
					$gz_img_y=$gz_newsimg_y; 
				break;
			}
		}
}
/*版本比较*/
function metver($verold,$vernow,$sysver){
	$oldnum=strripos($sysver,'|'.$verold.'|');
	$nownum=strripos($sysver,'|'.$vernow.'|');
	if($oldnum<$nownum)return 1;
	if($oldnum==$nownum)return 2;
	if($oldnum>$nownum)return 3;
}
/*替换admin文件*/
function readmin($dir,$adminfile,$type){
	if($adminfile!="admin"){
		$dirs=explode('/',$dir);
		if($type==1){
			if($dirs[0]==$adminfile){
				$dirs[0]='admin';
			}
		}
		else{
			if($dirs[0]=='admin'){
				$dirs[0]=$adminfile;
			}
		}

		$dir=implode('/',$dirs);	
	}
	return $dir;
}
/*管理员用户组*/
function admin_grouptp($type){
	global $lang_managertyp1,$lang_managertyp2,$lang_managertyp3,$lang_managertyp4,$lang_managertyp5;
	switch($type){
		case 10000:
			$metinfo=$lang_managertyp1;
		break;
		case 3:
			$metinfo=$lang_managertyp2;
		break;
		case 2:
			$metinfo=$lang_managertyp3;
		break;
		case 1:
			$metinfo=$lang_managertyp4;
		break;
		case 0:
			$metinfo=$lang_managertyp5;
		break;
	}
	return $metinfo;
}
function morenfod($foldername,$module){
	$metinfo=1;
	switch($foldername){
		case 'about':
			$metinfo = $module==1?0:1;
		break;
		case 'news':
			$metinfo = $module==2?0:1;
		break;
		case 'product':
			$metinfo = $module==3?0:1;
		break;
		case 'download':
			$metinfo = $module==4?0:1;
		break;
		case 'img':
			$metinfo = $module==5?0:1;
		break;
		case 'feedback':
			$metinfo = $module==8?0:1;
		break;
	}
	return $metinfo;
}
/*文件浏览*/
function gz_scandir($directory, $sorting_order = 0) {   
 $dh  = opendir($directory);   
 while( false !== ($filename = readdir($dh)) ) {   
	 $files[] = $filename;   
 }   
 if( $sorting_order == 0 ) {   
	 sort($files);   
 } else {   
	 rsort($files);   
 }   
 return($files);   
}  
/*robots修改*/
function sitemap_robots(){
global $db,$gz_config,$gz_index_type,$gz_sitemap_xml,$gz_sitemap_html,$gz_sitemap_txt;
	$gz_weburl_de=$db->get_one("select * from $gz_config where name='gz_weburl' and lang='$gz_index_type'");
	$gz_weburl_de=$gz_weburl_de[value];
	$robots=file_get_contents(ROOTPATH.'robots.txt');
	$suffix=$gz_sitemap_xml?'xml':($gz_sitemap_html?'html':($gz_sitemap_txt?'txt':0));
	if($suffix){
		if(stripos($robots,'Sitemap: ')===false){
			$robots.="\nSitemap: {$gz_weburl_de}sitemap.xml";
		}else{
			$robots=preg_replace('/Sitemap:.*/',"Sitemap: {$gz_weburl_de}sitemap.{$suffix}",$robots);
		}
	}else{
		$robots=preg_replace("/Sitemap:.*/","",$robots);
	}
	$robots=str_replace("\n\n","\n",$robots);
	file_put_contents(ROOTPATH.'robots.txt',$robots);
}
/*随机函数*/
function gz_rand($length){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$password = '';
	for ( $i = 0; $i < $length; $i++ ) {
		$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
	}
	return $password;
}
/*COOKIE*/
function gz_cooike_start(){
	global $gz_cookie,$db,$gz_webkeys,$gz_admin_table;
	$gz_cookie=array();
	list($username,$password)=explode("\t",authcode($_COOKIE[gz_auth],'DECODE', $gz_webkeys.$_COOKIE[gz_key]));
	$username=daddslashes($username,0,1);
	$query="select * from $gz_admin_table where admin_id='$username'";
	$user=$db->get_one($query);
	$usercooike=json_decode($user['cookie']);
	if(md5($user['admin_pass'])==$password&&time()-$usercooike->time<3600){
		foreach($usercooike as $key=>$val){
			$gz_cookie[$key]=$val;
		}
		$gz_cookie['time']=time();
		$json=json_encode($gz_cookie);
		$query="update $gz_admin_table set cookie='$json' where admin_id='$username'";
		$user=$db->get_one($query);
	}
}
function login_gz_cookie($userid){
	global $gz_cookie,$metinfo_admin_name,$metinfo_admin_pass,$gz_webkeys,$db,$gz_admin_table;
	$gz_cookie=array();
	$gz_cookie['time']=time();
	$json=json_encode($gz_cookie);
	$userid=daddslashes($userid,0,1);
	$db->query("update $gz_admin_table set cookie='$json' WHERE admin_id='$userid' and usertype='3'");
	$query="select * from $gz_admin_table WHERE admin_id='$userid' and usertype='3'";
	$user=$db->get_one($query);
	$gz_key=gz_rand(7);
	$user[admin_pass]=md5($user[admin_pass]);
	$auth=authcode("$user[admin_id]\t$user[admin_pass]",'ENCODE', $gz_webkeys.$gz_key,86400);
	gz_setcookie("gz_auth",$auth,0);
	gz_setcookie("gz_key",$gz_key,0);
}
function gz_cooike_unset($userid){
	global $gz_cookie,$db,$gz_admin_table;
	$userid=daddslashes($userid,0,1);
	$db->query("update $gz_admin_table set cookie='' WHERE admin_id='$userid' and usertype='3'");
	gz_setcookie("gz_auth",'',time()-3600);
	gz_setcookie("gz_key",'',time()-3600);
	gz_setcookie("appsynchronous",0,time()-3600,'');
	
	gz_setcookie("upgraderemind",'',time()-3600);
	gz_setcookie("langset",'',time()-3600);
	gz_setcookie("appupdate",'',time()-3600);
	unset($gz_cookie);
}
function change_gz_cookie($key,$val){
	global $gz_cookie;
	if($key=='metinfo_admin_name'){
		$val=daddslashes($val,0,1);
		$val=urlencode($val);
	}
	$gz_cookie[$key]=$val;
}
function get_gz_cookie($key){
	global $gz_cookie;
	if($key=='metinfo_admin_name'){
		$val=urldecode($gz_cookie[$key]);
		$val=daddslashes($val,0,1);
		return $val;
	}
	return $gz_cookie[$key];
}
function save_gz_cookie(){
	global $gz_cookie,$db,$gz_admin_table;
	$gz_cookie['time']=time();
	$json=json_encode($gz_cookie);
	$username=$gz_cookie[metinfo_admin_id]?$gz_cookie[metinfo_admin_id]:$gz_cookie[metinfo_member_id];
	$username=daddslashes($username,0,1);
	$query="update $gz_admin_table set cookie='$json' where id='$username'";
	$user=$db->query($query);
}
if(!function_exists('json_encode')){
    include ROOTPATH.'include/JSON.php';
    function json_encode($val){
        $json = new Services_JSON();
		$json=$json->encode($val);
        return $json;
    }
    function json_decode($val){
        $json = new Services_JSON();
        return $json->decode($val);
    }
}
function gz_setcookie($var,$value='',$life=0,$path= '/',$httponly=true) {
	$path = $httponly && PHP_VERSION < '5.2.0' ? $path.'; HttpOnly' : $path;
	$secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	if(PHP_VERSION < '5.2.0') {
		setcookie($var, $value, $life, $path, '', $secure);
	} else {
		setcookie($var, $value, $life, $path, '', $secure, $httponly);
	}
}
/*静态页面文件名称验证*/
function namefilter($filename){
	$filename=str_replace('/','_',$filename);
	$filename=str_replace('\\','_',$filename);
	$filename=preg_replace("/\s/","_",trim($filename));
	$filename=unescape($filename);
	return $filename;
}

/*应用的添加*/
function increase_app($no,$filename,$attribute,$type){
	global $db,$lang,$gz_ifcolumn,$gz_ifcolumn_addfile,$gz_ifmember_left;
	if($type==1){
		if(!$db->get_one("select * from $gz_ifcolumn where no='$no'")){
			$allidlist=explode('|',$attribute);
			$query="INSERT INTO $gz_ifcolumn SET no='$no', name='$allidlist[0]',appname='$allidlist[1]',addfile='$allidlist[2]',memberleft='$allidlist[3]'";
			$db->query($query);
		}
	}else{
		if($type==2){
			$allidlist=explode('|',$attribute);
			$query="INSERT INTO $gz_ifcolumn_addfile SET no='$no', filename='$filename',m_name='$allidlist[0]',m_module='$allidlist[1]',m_class='$allidlist[2]',m_action='$allidlist[3]'";
			$db->query($query);
		}else{
			$allidlist=explode('|',$attribute);
			$query="INSERT INTO $gz_ifmember_left SET no='$no', columnid='$allidlist[0]',title='$allidlist[1]',foldername='$allidlist[2]',filename='$allidlist[3]'";
			$db->query($query);
		
		}
	}

}

/*应用模块创建时生成相应文件*/
function establish_appmodule($foldername,$no){
	global $db,$lang,$gz_appmodule,$gz_ifcolumn,$gz_ifcolumn_addfile;
	$addfile_type=$db->get_one("select * from $gz_ifcolumn where no='$no'");
	if($addfile_type[addfile]==1){
		$path='../../'.$foldername;
		mkdir($path, 0777);
		$structure=$db->get_all("select distinct filename from $gz_ifcolumn_addfile where no='$no'");
		foreach($structure as $key=>$val){
			$path='../../'.$foldername.'/'.$val[filename];
			$fp=fopen($path,"w+");
		$str="<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
"."\n";
			fputs($fp,$str);
			fclose($fp);
		}
		$structure1=$db->get_all("select * from $gz_ifcolumn_addfile where no='$no'");
		foreach($structure1 as $key=>$val){
			$straction[$val[filename]].="define('M_NAME', '".$val['m_name']."');\ndefine('M_MODULE', '".$val['m_module']."');\ndefine('M_CLASS', '".$val['m_class']."');\n";
			if(substr($val['m_action'], 0, 1) == '$' || substr($val['m_action'], 0, 1) == '@'){
				$straction[$val[filename]].="define('M_ACTION', ".$val['m_action'].");\n";
			}else{
				$straction[$val[filename]].="define('M_ACTION', '".$val['m_action']."');\n";
			}
			$straction[$val[filename]].="require_once '../app/app/entrance.php';\n";
		}
		foreach($structure as $key=>$val){
			$path='../../'.$foldername.'/'.$val[filename];
			$fp = fopen($path, "r");
			$read = fread($fp, filesize($path));
			fclose($fp);
			$fp=fopen($path,"w");
			$str=$read.$straction[$val[filename]]."# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>";
			fputs($fp,$str);
			fclose($fp);
		}
	}
}

/*添加后台侧导航*/
function lateral_navigation($name,$value,$bigclass,$order,$url){
	global $db,$gz_language,$gz_admin_column;
	$allidlist=explode('|',$value);
	if(!$db->get_one("select * from $gz_language where name='$name' and lang='cn'")){
		$query="INSERT INTO $gz_language SET name='$name',value='$allidlist[0]',site='1',no_order='0',array='8',app='0',lang='cn'";
		$db->query($query);
	}
	if(!$db->get_one("select * from $gz_language where name='$name' and lang='en'")){
		$query="INSERT INTO $gz_language SET name='$name',value='$allidlist[1]',site='1',no_order='0',array='8',app='0',lang='en'";
		$db->query($query);
	}
	if(!$db->get_one("select * from $gz_language where name='$name' and lang='tc'")){
		$query="INSERT INTO $gz_language SET name='$name',value='$allidlist[2]',site='1',no_order='0',array='8',app='0',lang='tc'";
		$db->query($query);
	}
	$name1='lang_'.$name;
	if(!$db->get_one("select * from $gz_admin_column where name='$name1' and type='2'")){
		$query="INSERT INTO $gz_admin_column SET name='$name1',url='$url',bigclass='$bigclass',type='2',list_order='$order'";
		$db->query($query);
	}
}
//接口
function get_word($word){
	global $_M;
	if(strstr($word,'$_M[')){
		$word=str_replace(array('$_M','\'','"','[',']','word'),'',$word);
		return $_M['word'][$word];	
	}else{
		return $word;
	}
	
}
//结束
function waterbigimg_compatible($filePath){
	global $gz_wate_class,$gz_watermark,$gz_text_wate,$gz_text_color,$gz_text_angle,$gz_text_fonts,$depth,$gz_wate_bigimg,$gz_text_bigsize;
	require_once ROOTPATH_ADMIN.'include/watermark.class.php';
	$img = new Watermark();
	if($gz_wate_class==2){
		$img->gz_image_pos  = $gz_watermark;
	}else {
		$img->gz_text       = $gz_text_wate;
		$img->gz_text_color = $gz_text_color;
		$img->gz_text_angle = $gz_text_angle;
		$img->gz_text_pos   = $gz_watermark;
		$img->gz_text_font  = $depth.$gz_text_fonts;
	}
	
	if($gz_wate_class==2){
		$img->gz_image_name = $depth.$gz_wate_bigimg;
	}else {
		$img->gz_text_size  = $gz_text_bigsize;
	}
	
	if(stristr(PHP_OS,"WIN"))$filePath=@iconv("utf-8","gbk",$filePath);
	
	$imgurl_original = $depth.'../../'.$filePath;
	
	if(file_exists($imgurl_original)){
		$filename=$urls[count($urls)-1];
		$img->src_image_name = $imgurl_original;
		$imgurl_originals = explode('/', $imgurl_original);
		$imgurl_originals[count($imgurl_originals)-1] = 'watermark/'.$imgurl_originals[count($imgurl_originals)-1];
		$img->save_file = implode('/', $imgurl_originals);
		$mkdir = $imgurl_originals;
		unset($mkdir[count($mkdir)-1]);
		$mkdir[] = 'watermark';
		mkdir(implode('/', $mkdir));
		$img->save_file = implode('/', $imgurl_originals);
		$img->create();
		return $img->save_file;
	}

}
	
function concentwatermark_compatible($str){
	global $gz_big_wate;
	if($gz_big_wate == 1){
		if(preg_match_all('/<img.*?src=\\\\"(.*?)\\\\".*?>/i', $str, $out)){
			foreach($out[1] as $key=>$val){
				$imgurl             = explode("upload/", $val);
				if($imgurl[1]){
					$list['imgurl_now'] = 'upload/'.$imgurl[1];
					$list['imgurl_original'] = 'upload/'.str_replace('watermark/', '',$imgurl[1]);
					if(file_exists(ROOTPATH.$list['imgurl_original']))$imgurls[] = $list;
				}
			}
			foreach($imgurls as $key=>$val){
				$watermarkurl = str_replace('../', '', waterbigimg_compatible($val['imgurl_original']));
				$str = str_replace($val['imgurl_now'], $watermarkurl, $str);
			}
		}
	}
	return $str;
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>