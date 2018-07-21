<?php
/**
 * 
 * User/IndexAction.class.php (前台会员中心模块)
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

	function _initialize()
    {	
		parent::_initialize();
		if(!$this->_userid){
			$this->assign('jumpUrl',U('User/Login/index'));
			$this->error(L('nologin'));
			exit;
		}
		$this->dao = M('User');
		$this->assign('bcid',0);
		$user = $this->dao->find($this->_userid);
		$this->assign('vo',$user);
		unset($_POST['status']);
		unset($_POST['groupid']);
		unset($_POST['amount']);
		unset($_POST['point']);
		$_GET =get_safe_replace($_GET);
    }

    public function index()
    {
        $this->display();
    }
	
	public function profile()
    {	 
		if($_POST['dosubmit']){
			
			$_POST['id']=$this->_userid;
			if(!$this->dao->create($_POST)) {
				$this->error($this->dao->getError());
			}
			$this->dao->update_time = time();
			$this->dao->last_ip = get_client_ip();
			$result	=	$this->dao->save();
			if(false !== $result) {
				$this->success(L('do_success'));
			}else{
				$this->error(L('do_error'));
			}
			exit;
		}
        $this->display();
    }

	public function avatar()
    {	
		
		if($_POST['dosubmit']){
		
			$_POST['id']=$this->_userid;
			if(!$this->dao->create($_POST)) {
				$this->error($this->dao->getError());
			}
			$this->dao->update_time = time();
			$this->dao->last_ip = get_client_ip();
			$result	=	$this->dao->save();
			if(false !== $result) {
				if($_POST['aid']){
				$Attachment =M('Attachment');		
				$aids =  implode(',',$_POST['aid']);
				$data['userid']= $this->_userid;
				$data['catid']= 0;
				$data['status']= '1';
				$Attachment->where("aid in (".$aids.")")->save($data);
				}

				$this->success(L('do_success'));
			}else{
				$this->error(L('do_error'));
			}
			exit;
		}

		$gzphp_auth_key = sysmd5(C('ADMIN_ACCESS').$_SERVER['HTTP_USER_AGENT']);
		$gzphp_auth = authcode('0-1-0-1-jpeg,jpg,png,gif-3-0', 'ENCODE',$gzphp_auth_key);
		$this->assign('gzphp_auth',$gzphp_auth);
        $this->display();
    }

	public function password()
    {
		if($_POST['dosubmit']){

			if(md5($_POST['verify']) != $_SESSION['verify']) {
				$this->error(L('error_verify'));
			}
			if($_POST['password'] != $_POST['repassword']){
				$this->error(L('password_repassword'));
			}
			$map	=	array();
			$map['password']= array('eq',sysmd5($_POST['oldpassword']));
			$map['id']		=	$this->_userid;
			//检查用户
			if(!$this->dao->where($map)->field('id')->find()) {
				$this->error(L('error_oldpassword'));
			}else {
				$this->dao->email = $_POST['email'];
				$this->dao->id = $this->_userid;
				$this->dao->update_time = time();
				$this->dao->password	=	sysmd5($_POST['password']);
				$r = $this->dao->save();
				$this->assign('jumpUrl',U('User/Index/password'));
				if($r){
					$this->success(L('do_success'));
				}else{
					$this->error(L('do_error'));
				}
			 }
			 exit;
		}
		$this->display();
    }
	
}
?>