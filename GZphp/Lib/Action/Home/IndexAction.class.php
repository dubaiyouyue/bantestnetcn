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
class IndexAction extends BaseAction
{
    public function index()
    {   
        $cid=$_GET['cid']+0;

    	//print_r($cid);exit();
   // print_r($config_info);exit;
 		$blist=$this->bannerlist(10001);
		$alist=$this->bannerlist('314,318');
  //dump($alist);exit;
 		$pro=M('news')->where('class1=136')->order('id desc')->limit(1)->find();
 		$product=M('news')->where('class1=136')->order('id desc')->select();

        $introduce=M('column')->where('id=314')->find();
         //dump($introduce);exit();
 		//print_r($advantages);exit();
        $news=M('news')->where("class1=140")->order('id desc')->find();
        $newss=M('news')->where("class1=140")->order('addtime desc')->limit(3)->select();
		
		$newssal=M('news')->where("class1=136")->order('no_order desc,id desc')->limit(6)->select();//案例
		$newssalgg=M('news')->where("class1=140")->order('no_order desc,id desc')->limit(3)->select();//公告
		$newssalggzx=M('news')->where("class2=460")->order('no_order desc,id desc')->limit(3)->select();//咨询
			
		  $heart=M('news')->where("class1=406")->order('id asc')->select();
		  
		  $sso=M('column')->where('bigclass=445')->order('no_order asc,id asc')->select();
		  $lanmuzx=M('column')->where('bigclass=452')->order('no_order asc,id asc')->select();
		  $sso=array_merge($sso,$lanmuzx);
		  $this->sortArrByField($sso,'no_order',true);
		  foreach($sso as $ks=>$vs){
			  if($ks<3) $nsso[]=$vs;
		  }
		  //$sso=array_slice($sso,0,3);
		  //dump($nsso);exit;
 		//$advantage=$this->new_list(1,1,6,1);
        //dump($heart);exit();
		$this->assign('bcid',0);//顶级栏目 
		$this->assign('sso',$nsso);
		$this->assign('ishome','home');
		$this->assign('heart',$heart);
		$this->assign('blist',$blist);
		$this->assign('alist',$alist);
        $this->assign('news',$newss);
        $this->assign('newssalgg',$newssalgg);
        $this->assign('newssalggzx',$newssalggzx);
        $this->assign('newssal',$newssal);
		$this->assign('cid',$$cid);

		$this->assign('advantage',$advantage);
        $this->assign('product',$product);
        $this->assign('news',$news);
          
		$this->assign('introduce',$introduce);
        $this->display();
    }
 public function sortArrByField(&$array, $field, $desc = false){
  $fieldArr = array();
  foreach ($array as $k => $v) {
    $fieldArr[$k] = $v[$field];
  }
  $sort = $desc == false ? SORT_ASC : SORT_DESC;
  array_multisort($fieldArr, $sort, $array);
}
}
?>