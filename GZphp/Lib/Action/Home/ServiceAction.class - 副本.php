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
class ServiceAction extends BaseAction
{
    public function index()
    {
		$cid=$_GET['cid']+0;
		global $now_cid_first;
		global $namemark;
		global $foldername;
		global $namemark_tpl;
		
		$p=$_GET['p']+0;
		$m=10;
        
        $blist=$this->bannerlists(171);
         $tu=$this->bannerlist(200);
         $lanmu=M('column')->where('bigclass=171')->select();
            foreach($lanmu as $kuccc=>&$kuccv){
				$kuccv['foldername']=ucfirst($kuccv['foldername']);
			}
         $lan=M('column')->where("id=$cid")->find();
         $la=M('column')->where("bigclass=0")->find();
         $news=M('news')->where("class2=$cid")->order('id desc')->select();
         $new=M('news')->where("class2=$cid")->find();
      
		$list=$this->new_list('class2',$cid,$p,$m,0);
		$this->assign('list',$list);
		//print_r($lan);exit;
		$now_lanmu=$this->get_column_info($cid);
		$this->assign('now_lanmu',$now_lanmu);

		$allpage=$this->Pagenewinfo('class2',$cid,0);
		$allpage=ceil($allpage/$m);
		if($allpage==1) $allpage=0;
		$this->assign('allpage',$allpage);
		$this->assign('blist',$blist);
		$this->assign('lanmu',$lanmu);
		$this->assign('lan',$lan);
	    $this->assign('news',$news);
	    $this->assign('new',$new);
	     $this->assign('la',$la);
	     $this->assign('tu',$tu);
		
		
		//dump($list);exit;
		//$this->assign('ishome','home');namemark_tpl
        $this->display('./GZphp/Tpl/Home/Default/'.$foldername.'_'.$namemark_tpl.'.html');
    }
}
?>