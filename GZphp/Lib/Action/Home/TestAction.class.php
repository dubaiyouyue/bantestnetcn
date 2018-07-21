<?php
/**
 * 
 * IndexAction.class.php (前台首页)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied"); 
class TestAction extends BaseAction
{
    public function index()
    {
 		$new_column_list=M('column')->select();
		dump($new_column_list);exit;
		$this->assign('bcid',0);//顶级栏目 
		$this->assign('ishome','home');
        //$this->display();
    }
 
}
?>