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
class JoinAction extends BaseAction
{
    public function index()
    {
    	//print_r($new_column_list_top);exit();
		$cid=$_GET['cid']+0;
		$id=$_GET['id']+0;
		//print_r($id);exit;
		global $now_cid_first;
		global $namemark;
		global $foldername;
		global $namemark_tpl;

		$blist=$this->bannerlists(408);
	    $lanmu=M('column')->where('bigclass=408')->select();
	       foreach($lanmu as $kuccc=>&$kuccv){
				$kuccv['foldername']=ucfirst($kuccv['foldername']);
			}
	    
	    //$folder=M('column')->where("id=$cid")->field('foldername')->select();
        
	    $lan=M('column')->where("id=$cid")->find();
		//print_r($lan);exit();
		
		 $news=M('news')->where("class1=$cid")->order('id desc')->limit(4)->select();
         $new=M('news')->where("id=$id")->find();
      //dump($news);exit();



        $p=$_GET['p']+0;
		//echo $p;exit;
		$m=4;
		if($namemark=='new') $m=5;
		$list=$this->new_list('class1',$cid,$p,$m);
		$this->assign('list',$list);
		//dump($list);exit;
		$now_lanmu=$this->get_column_info($cid);
		$this->assign('now_lanmu',$now_lanmu);
		$allpage=$this->Pagenewinfo('class1',$cid,0);
		$allpage=ceil($allpage/$m);


		 $this->assign('p',$p);
		$this->assign('allpage',$allpage);
		//dump($new_list);exit;
		//$this->assign('ishome','home');namemark_tpl
		$this->assign('cid',$cid);
		$this->assign('id',$id);
		$this->assign('blist',$blist);
		$this->assign('news',$news);
		$this->assign('new',$new);
		$this->assign('lanmu',$lanmu);
		$this->assign('lan',$lan);
		$foldername=Join;
        $this->display('./GZphp/Tpl/Home/Default/'.$foldername.'_'.$namemark_tpl.'.html');
    }
}
?>