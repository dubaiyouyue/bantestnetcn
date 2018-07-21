<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');

class help extends admin {
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
	
	
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>