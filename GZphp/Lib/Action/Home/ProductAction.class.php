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
class ProductAction extends BaseAction
{
    public function index(){
		$ajax=$_GET['ajax'];
		$hyid=$_GET['hyid']+0;
		$cid=$_GET['cid']+0;
		//$pid=$_GET['pid']+0;
         //print_r($pid);exit;
		global $now_cid_first;
		global $namemark;
		global $foldername;
		global $namemark_tpl;
		$blist=$this->bannerlists(136);
		$getinfolamu=$this->get_column_info(136);$this->assign('getinfolamu',$getinfolamu);
			//print_r($blist);exit();
        $lanmu=M('column')->where('bigclass=136')->order('id asc')->select();
		  $news=M('news')->where("class1=136")->order('id asc')->select();
		  
           
			//dump($news);exit;
			
			
			
        $lan=M('column')->where("id=$cid")->find();
        
		   //dump($lan);exit; 

         $p=$_GET['p']+0;
		//echo $p;exit;
		$m=5;
		$m=$lan['listnumber']?$lan['listnumber']:6;
		if($namemark=='new') $m=5;
		
		$cclslss='class2';
		if($cid==136) $cclslss='class1';
		
		$list=$this->new_list($cclslss,$cid,$p,$m,'','',$hyid);
		if(empty($list)) exit('no data');
		$lanmumm=$this->lanmu_list('bigclass',136,$p,$m);
		$this->assign('list',$list);
		$this->assign('lanmumm',$lanmumm);
		//dump($lanmumm);exit;
		$now_lanmu=$this->get_column_info($cid);
		$this->assign('now_lanmu',$now_lanmu);
		$allpage=$this->Pagenewinfo($cclslss,$cid,0,$k,$hyid);
		$allpage=ceil($allpage/$m);

		//上一页
		$sp=$p-1;
		if($sp<1) $sp=1;
		//下一页
		$np=$p+1;
		if($np<2) $np=2;
		if($np>$allpage) $np=$allpage;
		
		$this->assign('sp',$sp);
		$this->assign('np',$np);
		
		if($now_cid_first==$cid){
			//一级栏目
			$newlist=$this->new_page_info('131,132,133,134');
			foreach($newlist as $k=>$v){
				$new_list[$v['id']]=$v;
			}
			$this->assign('newlist',$new_list);
		}else{
			$newlist=$this->new_page_info($cid);
			$this->assign('newlist',$newlist);
		}
		//底部流程图

		//dump($now_lanmu);exit;
		
        $this->assign('p',$p);
		$this->assign('allpage',$allpage);
		$limg=$this->bannerlist($cid);
		$this->assign('blist',$blist);
		$this->assign('news',$news);
		$this->assign('lanmu',$lanmu);
		$this->assign('lan',$lan);
		$this->assign('limg',$limg);
			$this->assign('advantage',$advantage);
			
		//dump($new_list);exit;
		//$this->assign('ishome','home');namemark_tpl
		if($ajax=='ok') $this->display('./GZphp/Tpl/Home/Default/Product_ajax.html');
        else $this->display('./GZphp/Tpl/Home/Default/'.$foldername.'_'.$namemark_tpl.'.html');
    }
}
?>