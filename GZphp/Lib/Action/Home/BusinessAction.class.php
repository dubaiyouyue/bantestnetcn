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
class BusinessAction extends BaseAction
{
    public function index()
    {
		$cid=$_GET['cid']+0;
		global $now_cid_first;
		global $namemark;
		global $foldername;
		global $namemark_tpl;

		$blist=$this->bannerlists(148);
		$lanmu=M('column')->where('bigclass=148')->select();
		$lan=M('column')->where("id=$cid")->find();
		$news=M('news')->where("class2=$cid")->order('id desc')->limit(5)->select();
		//print_r($blist);exit();

		$p=$_GET['p']+0;
		//echo $p;exit;
		$m=1;
		if($namemark=='new') $m=5;
		$list=$this->new_list('class2',$cid,$p,$m);
		$this->assign('list',$list);
		
		$now_lanmu=$this->get_column_info($cid);
		$this->assign('now_lanmu',$now_lanmu);
		$allpage=$this->Pagenewinfo('class2',$cid,0);
		$allpage=ceil($allpage/$m);
		
		$this->assign('blist',$blist);
		$this->assign('allpage',$allpage);
		$this->assign('lanmu',$lanmu);
		$this->assign('lan',$lan);
		$this->assign('news',$news);
	    $this->assign('p',$p);

		//dump($list);exit;
		//$this->assign('ishome','home');namemark_tpl
        $this->display('./GZphp/Tpl/Home/Default/'.$foldername.'_'.$namemark_tpl.'.html');
    }
}
?>