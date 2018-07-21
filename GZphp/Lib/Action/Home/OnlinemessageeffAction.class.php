<?php

/**
 * 
 * AreaAction.class.php (ajax 获取地址)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if (!defined("GZPHP"))
    exit("Access Denied");

class OnlinemessageeffAction extends BaseAction {

    public function index() {
        //echo 'fdasfads';
		$aid=$_GET['aid']+0;
		$p=5;
		$min=$aid*$p;
		$list=M('article')->where('catid=173')->order('listorder desc,id desc')->limit($min,$p)->select();
		//dump($l);
		$this->assign('list',$list);
		$this->display();
    }

    
}

?>