<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');

class webset extends admin {
	public $iniclass;
	function __construct() {
		global $_M;
		parent::__construct();
		nav::set_nav(1, $_M['word']['website_information'], $_M['url']['own_form'].'&a=doindex');
		//nav::set_nav(2, $_M['word']['email_Settings'], $_M['url']['own_form'].'&a=doemailset');
		//隐藏邮件发送设置
		nav::set_nav(3, $_M['word']['third_party_ode'], $_M['url']['own_form'].'&a=dothirdparty');
	}
	
	function doindex() {
		global $_M;
		nav::select_nav(1);	
		$record = '';
		if($_M['form']['turnovertext']){
			$adrry = admin_information();
			$email = $adrry['admin_email'];
			$tel   = $adrry['admin_mobile'];
			$record = "http://api.resonance.com.cn/record_install.php?url={$_M['config']['gz_weburl']}&email={$email}&webname={$_M['config']['gz_webname']}&webkeywords={$_M['config']['gz_keywords']}&tel={$tel}&version={$_M['config']['metcms_v']}&softtype=1";
		}
		require $this->template('tem/index');
	}
	
	function doseteditor(){
		global $_M;

		if($_M['form']['gz_ico'] != '../favicon.ico'){
			copy($_M['form']['gz_ico'], '../favicon.ico');
		}
		$gz_weburl = $_M['form']['gz_weburl'];
		if(substr($gz_weburl,-1,1)!="/")$gz_weburl.="/";
		if(!strstr($gz_weburl,"http://"))$gz_weburl="http://".$gz_weburl;
		$_M['form']['gz_weburl'] = $gz_weburl;
		
		$configlist = array();
		$configlist[] = 'gz_webname';
		$configlist[] = 'gz_logo';
		$configlist[] = 'gz_weburl';
		$configlist[] = 'gz_keywords';
		$configlist[] = 'gz_description';
		$configlist[] = 'gz_footright';
		$configlist[] = 'gz_footaddress';
		$configlist[] = 'gz_foottel';
		$configlist[] = 'gz_footother';
		$configlist[] = 'gz_footteldianhua';//电话 2016.12.05
		$configlist[] = 'gz_headTeless';
		$configlist[] = 'gz_foottelqq';
		$configlist[] = 'gz_footteldianhua2lyy';
		$configlist[] = 'gz_ewm';
		$configlist[] = 'gz_ewmdh';
		$configlist[] = 'gz_ewmdhzbtp';
		$configlist[] = 'gz_headFaxess';
		$configlist[] = 'gz_headquartersaddress';
		$configlist[] = 'gz_footteldianhua2';
		$configlist[] = 'gz_headeryj';     // 头部语句
		$configlist[] = 'gz_footerbeianhao';     // 备案号
		$configlist[] = 'gz_headeryjhhyy'; 

		configsave($configlist);/*保存系统配置*/
		
		if($_M['form']['gz_weburl']!=$_M['config']['gz_weburl']){//当首页网址变更时
			/*重新验证授权*/
			$query = "UPDATE {$_M['table']['otherinfo']} SET info1='',info2='' where id=1";
			DB::query($query);
			/*语言网址修改*/
			$query = "UPDATE {$_M['table']['lang']} SET gz_weburl = '{$_M['form']['gz_weburl']}' where lang='{$_M['lang']}'";
			DB::query($query);
			/*重新生成404*/
			$gent = "{$_M['url']['site']}include/404.php?lang={$_M[config][gz_index_type]}&metinfonow={$_M['config']['gz_member_force']}";
			$gent = urlencode($gent);
			/*重新生成robots.txt*/
			$sitemaptype = $_M['config']['gz_sitemap_xml']?'xml':($_M['config']['gz_sitemap_txt']?'txt':0);
			sitemap_robots($sitemaptype);
		}
		
		turnover("{$_M[url][own_form]}a=doindex&gent={$gent}", $_M['word']['jsok']);
		
	}
	
	function doemailset() {
		global $_M;
		nav::select_nav(2);
		require $this->template('tem/email');
	}
	
	function doemaileditor(){
		global $_M;
		$configlist = array();
		$configlist[] = 'gz_fd_usename';
		$configlist[] = 'gz_fd_fromname';
		if($_M['form']['gz_fd_password']!='passwordhidden'){
		$configlist[] = 'gz_fd_password';
		}
		$configlist[] = 'gz_fd_smtp';
		$configlist[] = 'gz_fd_port';
		$configlist[] = 'gz_fd_way';
		configsave($configlist);/*保存系统配置*/
		turnover("{$_M[url][own_form]}a=doemailset", $_M['word']['jsok']);
	}
	
	function doemail(){
		global $_M;
		if(!get_extension_funcs('openssl')&&stripos($_M['form']['gz_fd_smtp'],'.gmail.com')!==false){
			$metinfo="<span style=\"color:#f00;\">{$_M['word']['setbasicTip14']}</span>";
			echo $metinfo;
			die();
		}
		if(!get_extension_funcs('openssl')&&$_M['form']['gz_fd_way']=='ssl'){
			$metinfo="<span style=\"color:#f00;\">{$_M['word']['setbasicTip15']}</span>";
			echo $metinfo;
			die();
		}
		if(!function_exists('fsockopen')&&!function_exists('pfsockopen')&&!function_exists('stream_socket_client')){
			$metinfo ="<span style=\"color:#f00;\">{$_M['word']['basictips1']}</span>";
			$metinfo.="<span style=\"color:#090;\">{$_M['word']['basictips2']}</span>";
		}else{
			$usename  = $_M['form']['gz_fd_usename'];
			$fromname = $_M['form']['gz_fd_fromname'];
			$password = $_M['form']['gz_fd_password'];
			$password = $password=='passwordhidden'?$_M['config']['gz_fd_password']:$password;
			$smtp     = $_M['form']['gz_fd_smtp'];
			$port     = $_M['form']['gz_fd_port'];
			$way      = $_M['form']['gz_fd_way'];
			
			$jmail = load::sys_class('jmail', 'new');
			$jmail->set_send_mailbox($usename, $fromname, $usename, $password, $smtp , $port, $way);
			
			$ret = $jmail->send_email($usename, $_M['word']['basictips3'], $_M['word']['basictips4']);
			
			if ($ret) {
				$metinfo ="<span style=\"color:#090;\">{$_M['word']['basictips7']}</span>";
			}else{
				$metinfo ="<span style=\"color:#f00;\">{$_M['word']['basictips5']}</span>";
				$metinfo.="<span style=\"color:#f00;\">{$_M['word']['basictips6']}</span>";
			}			
		}
		echo $metinfo;
	}

	function dothirdparty(){
		global $_M;
		nav::select_nav(3);
		require $this->template('tem/thirdparty');
	}
	
	function dotpeditor(){
		global $_M;
		$configlist = array();
		$configlist[] = 'gz_headstat';
		$configlist[] = 'gz_footstat';
		$configlist[] = 'gz_footstat_new';
		$configlist[] = 'weibo_sina_metinfo_new';
		$configlist[] = 'lang_weibo_tqq_new';
		$configlist[] = 'lang_weibo_qq_new';
		//基本信息 第三方代码表单 记得数据库新增语言cn
		configsave($configlist);/*保存系统配置*/
		turnover("{$_M[url][own_form]}a=dothirdparty", $_M['word']['jsok']);
	}
	
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>