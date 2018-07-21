<?php
/**
 * PayAction.class.php (支付模块)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class PayAction extends BaseAction
{

	function _initialize()
    {	
		parent::_initialize();
		if(!$this->_userid){
			//$this->assign('jumpUrl',U('User/Login/index'));
			//$this->error(L('nologin'));
		}
		$this->dao = M('User');
		$this->assign('bcid',0);
		$user = $this->dao->find($this->_userid);
		$this->assign('vo',$user);
    }

    public function index()
    {
        $this->display();
    }


	public function Recharge()
    {
        $this->display();
    }
	

	public function pay()
    {
        $this->display();
    }
	public function respond()
	{
		$pay_code = !empty($_REQUEST['code']) ? get_safe_replace($_REQUEST['code']) : '';	
		$pay_code = ucfirst($pay_code);
		$Payment = M('Payment')->getByPayCode($pay_code);
		if(empty($Payment))$this->error(L('PAY CODE EROOR!'));
		$aliapy_config = unserialize($Payment['pay_config']);		 
		import("@.Pay.".$pay_code);
		$pay=new $pay_code($aliapy_config);
		$r = $pay->respond();	
		$this->assign('jumpUrl',URL('User-Order/index'));
		if($r){
			$this->error(L('PAY_OK'));
		}else{
			$this->error(L('PAY_FAIL'));
		}
	}
 
}
?>