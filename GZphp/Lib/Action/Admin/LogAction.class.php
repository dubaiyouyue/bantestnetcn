<?php
/**
 *
 * Login(后台登陆记录)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <wei2l99@qq.com>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class LogAction extends  AdminbaseAction {
    function _initialize()
    {	
		parent::_initialize();
    }
	function delete(){
		$day=intval($_GET['day']);
		if($day==1){
			$time = time()-60*60*24*30;
		}elseif($day==2){
			$time =  time()-60*60*24*90;
		}else{
			$this->error (L('do_empty'));
		}

		M(MODULE_NAME)->where("time < $time")->delete();
		$this->success(L('delete_ok'));

	}
 
}
