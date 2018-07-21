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
class HeartshowAction extends BaseAction
{
    public function index()
    {
		$cid=$_GET['cid']+0;
		$id=$_GET['id']+0;
		global $now_cid_first;
		global $namemark;
		global $foldername;
		global $namemark_tpl;
		$namemark_tpl='index';
		if($_GET['new']){
			$namemark_tpl=$_GET['new'];
		}
		$list=$this->newinfo($id);
		$this->assign('list',$list);

	$prev= M('news')->where(array('id'=>array('GT',$id),'class2'=>$cid))->order('id asc')->find();
    $next= M('news')->where(array('id'=>array('LT',$id),'class2'=>$cid))->order('id desc')->find();
		//dump($list);exit;

		$now_lanmu=$this->get_column_info($cid);
		$lanmu=M('column')->where('bigclass=140')->select();
		   foreach($lanmu as $kuccc=>&$kuccv){
				$kuccv['foldername']=ucfirst($kuccv['foldername']);
			}
		$lan=M('column')->where("id=$cid")->find();
		//print_r($lan);exit;
		$blist=$this->bannerlists(406);
		$this->assign('blist',$blist);
		$this->assign('now_lanmu',$now_lanmu);
          $this->assign('lanmu',$lanmu);
            $this->assign('prev',$prev);
              $this->assign('next',$next);
              $this->assign('lan',$lan);
		//dump($list);exit;
		//$this->assign('ishome','home');namemark_tpl
        $this->display('./GZphp/Tpl/Home/Default/Heartshow_'.$namemark_tpl.'.html');
    }
}
?>