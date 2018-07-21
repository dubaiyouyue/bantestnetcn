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
class ContactAction extends BaseAction
{
    public function index()
    {

		$cid=$_GET['cid']+0;
		global $now_cid_first;
		global $namemark;
		global $foldername;
		global $namemark_tpl;

    if(!empty($_POST)){
    //print_r($_POST);exit();
 $post['addtime']=date("Y-m-d H:i:s");
 $post['lang']=htmlspecialchars($_POST['lang']);
 $post['type']=htmlspecialchars($_POST['type']);
 $post['tel']=htmlspecialchars($_POST['tel']);
 $post['xm']=htmlspecialchars($_POST['xm']);
  $post['email']=htmlspecialchars($_POST['email']);
 $post['content']=htmlspecialchars($_POST['content']);
    //print_r($post);exit();
    $add=M('message')->add($post);
    if($add>0){
    	$this->success('留言提交成功!');die;
    }else{
    	 $this ->error('留言提交失败!');die;
    }

     }


		$blist=$this->bannerlists(401);
		$getinfolamu=$this->get_column_info(401);$this->assign('getinfolamu',$getinfolamu);
		$lanmu=M('column')->where('bigclass=401')->order('id asc')->select();
		   foreach($lanmu as $kuccc=>&$kuccv){
				$kuccv['foldername']=ucfirst($kuccv['foldername']);
			}
		  $lan=M('column')->where("id=$cid")->find();
		//dump($lan);exit();
       //print_r($now_cid_first);exit();

		$p=$_GET['p']+0;
		$m=3;

		$list=$this->new_list('class2',$cid,$p,$m,0);
		$this->assign('list',$list);
		
		$now_lanmu=$this->get_column_info($cid);
		$this->assign('now_lanmu',$now_lanmu);

		$allpage=$this->Pagenewinfo('class2',$cid,0);
		$allpage=ceil($allpage/$m);
		if($allpage==1) $allpage=0;


		$this->assign('allpage',$allpage);
		$this->assign('p',$p);
		$this->assign('blist',$blist);
		$this->assign('lan',$lan);
		$this->assign('lanmu',$lanmu);
		//dump($list);exit;

		//$this->assign('ishome','home');namemark_tpl
        $this->display('./GZphp/Tpl/Home/Default/'.$foldername.'_'.$namemark_tpl.'.html');
    }
    
}
?>


