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
class FristshowAction extends BaseAction
{
    public function index()
    {
		$cid=$_GET['cid']+0;
		global $now_cid_first;
		global $namemark;
		global $foldername;
		global $namemark_tpl;
		
		$p=0;$_GET['p']+0;
		$m=1;
		$list=$this->new_list('class3',$cid,$p,$m);
		$this->assign('list',$list['0']);
		
		$now_lanmu=$this->get_column_info($cid);
		$this->assign('now_lanmu',$now_lanmu);

		//dump($list);exit;
		//$this->assign('ishome','home');namemark_tpl
        $this->display('./GZphp/Tpl/Home/Default/Fristshow_index.html');
    }
}
?>