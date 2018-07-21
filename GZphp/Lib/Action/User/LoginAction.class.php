<?php

/**
 * 
 * User/LoginAction.class.php (前台会员登陆)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if (!defined("GZPHP"))
    exit("Access Denied");

class LoginAction extends BaseAction {

    function _initialize() {
        parent::_initialize();
        $this->dao = M('User');
        $this->assign('bcid', 0);
    }

    function index() {
        if ($this->_userid) {
            $forward = $_POST['forward'] ? $_POST['forward'] : $this->forward;
            $this->assign('jumpUrl', $forward);
            $this->success(L('login_ok'));
            exit;
        }

        $this->display();
    }
    
    /*
     * 
     * ---------------------------------------
     * 
     */
    //登录地址
	public function login($type = null){
		empty($type) && $this->error('参数错误');

		//加载ThinkOauth类并实例化一个对象
		import("@.ORG.ThinkSDK.ThinkOauth");
		$sns  = ThinkOauth::getInstance($type);
                //print_r($sns);exit;
		//跳转到授权页面
		redirect($sns->getRequestCodeURL());
	}
        
     	//授权回调地址
	public function callback($type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('参数错误');
		
		//加载ThinkOauth类并实例化一个对象
		import("@.ORG.ThinkSDK.ThinkOauth");
		$sns  = ThinkOauth::getInstance($type);

		//腾讯微博需传递的额外参数
		$extend = null;
		if($type == 'tencent'){
			$extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
		}

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend);

		//获取当前登录用户信息
		if(is_array($token)){
			$user_info = A('Type', 'Event')->$type($token);

			echo("<h1>恭喜！使用 {$type} 用户登录成功</h1><br>");
			echo("授权信息为：<br>");
			dump($token);
			echo("当前登录用户信息为：<br>");
			dump($user_info);
		}
	}
    /*
     * 
     * ---------------------------------------
     * 
     */

    function dologin() {
        $username = get_safe_replace($_POST['username']);
        $password = get_safe_replace($_POST['password']);
        $verifyCode = get_safe_replace($_POST['verifyCode']);

        if (empty($username) || empty($password)) {
            $this->error(L('empty_username_empty_password'));
        }

        if ($this->member_config['member_login_verify'] && md5($verifyCode) != $_SESSION['verify']) {
            $this->error(L('error_verify'));
        }

        $authInfo = $this->dao->getByUsername($username);
        //使用用户名、密码和状态的方式进行认证
        if (empty($authInfo)) {
            $this->error(L('empty_userid'));
        } else {
            if ($authInfo['password'] != sysmd5($_POST['password'])) {
                $this->error(L('password_error'));
            }
            if ($authInfo['status'] != 1)
                $this->error(L('ACCOUNT_DISABLE'));

            $cookietime = intval($_REQUEST['cookietime']);
            $cookietime = $cookietime ? $cookietime : 0;

            $gzphp_auth_key = sysmd5($this->sysConfig['ADMIN_ACCESS'] . $_SERVER['HTTP_USER_AGENT']);
            $gzphp_auth = authcode($authInfo['id'] . "-" . $authInfo['groupid'] . "-" . $authInfo['password'], 'ENCODE', $gzphp_auth_key);



            cookie('auth', $gzphp_auth, $cookietime);
            cookie('username', $authInfo['username'], $cookietime);
            cookie('groupid', $authInfo['groupid'], $cookietime);
            cookie('userid', $authInfo['id'], $cookietime);
            cookie('email', $authInfo['email'], $cookietime);

            //保存登录信息
            $dao = M('User');
            $data = array();
            $data['id'] = $authInfo['id'];
            $data['last_logintime'] = time();
            $data['last_ip'] = get_client_ip();
            $data['login_count'] = array('exp', 'login_count+1');
            $dao->save($data);

            $forward = $_POST['forward'] ? $_POST['forward'] : $this->forward;
            $this->assign('jumpUrl', $forward);
            $this->success(L('login_ok'));
        }
    }

    function getpass() {
        $this->display();
    }

    function repassword() {
        if ($_POST['dosubmit']) {
            $verifyCode = trim($_POST['verify']);
            if (md5($verifyCode) != $_SESSION['verify']) {
                $this->error(L('error_verify'));
            }
            if (trim($_POST['repassword']) != trim($_POST['password'])) {
                $this->error(L('password_repassword'));
            }
            list($userid, $username, $email) = explode("-", authcode($_POST['code'], 'DECODE', $this->sysConfig['ADMIN_ACCESS']));
            $user = M('User');
            //判断邮箱是用户是否正确
            $data = $user->where("id={$userid} and username='{$username}' and email='{$email}'")->find();
            if ($data) {
                $user->password = sysmd5(trim($_POST['password']));
                $user->updatetime = time();
                $user->last_ip = get_client_ip();
                $user->save();
                $this->assign('jumpUrl', U('User/login/index'));
                $this->assign('waitSecond', 3);
                $this->success(L('do_repassword_success'));
            } else {
                $this->error(L('check_url_error'));
            }
            exit;
        }
        $code = str_replace(' ', '+', $_REQUEST['code']);
        $this->assign('code', $code);
        $this->display();
    }

    function sendmail() {
        $verifyCode = trim($_POST['verifyCode']);
        $username = get_safe_replace($_POST['username']);
        $email = get_safe_replace($_POST['email']);


        if (empty($username) || empty($email)) {
            $this->error(L('empty_username_empty_password'));
        } elseif (md5($verifyCode) != $_SESSION['verify']) {
            $this->error(L('error_verify'));
        }

        $user = M('User');
        //判断邮箱是用户是否正确
        $data = $user->where("username='{$username}' and email='{$email}'")->find();
        if ($data) {
            $gzphp_auth = authcode($data['id'] . "-" . $data['username'] . "-" . $data['email'], 'ENCODE', $this->sysConfig['ADMIN_ACCESS'], 3600 * 24 * 3); //3天有效期
            $username = $data['username'];
            $url = 'http://' . $_SERVER['HTTP_HOST'] . U('User/Login/repassword?code=' . $gzphp_auth);
            $message = str_replace(array('{username}', '{url}', '{sitename}'), array($username, $url, $this->Config['site_name']), $this->member_config['member_getpwdemaitpl']);

            $r = sendmail($email, L('USER_FORGOT_PASSWORD') . '-' . $this->Config['site_name'], $message, $this->Config);
            if ($r) {
                $returndata['username'] = $data['username'];
                $returndata['email'] = $data['email'];
                $this->ajaxReturn($returndata, L('USER_EMAIL_ERROR'), 1);
            } else {
                $this->ajaxReturn(0, L('SENDMAIL_ERROR'), 0);
            }
        } else {
            $this->ajaxReturn(0, L('USER_EMAIL_ERROR'), 0);
        }
        //$this->ajaxReturn(1,L('login_ok'),1);
    }

    function emailcheck() {

        if (!$this->_userid && !$this->_username && !$this->_groupid && !$this->_email) {
            $this->assign('forward', '');
            $this->assign('jumpUrl', U('User/Login/index'));
            $this->success(L('noogin'));
            exit;
        }

        if ($_REQUEST['resend']) {
            $uid = $this->_userid;
            $username = $this->_username;
            $email = $this->_email;
            if ($this->member_config['member_emailcheck']) {
                $gzphp_auth = authcode($uid . "-" . $username . "-" . $email, 'ENCODE', $this->sysConfig['ADMIN_ACCESS'], 3600 * 24 * 3); //3天有效期
                $url = 'http://' . $_SERVER['HTTP_HOST'] . U('User/Login/regcheckemail?code=' . $gzphp_auth);
                $click = "<a href=\"$url\" target=\"_blank\">" . L('CLICK_THIS') . "</a>";
                $message = str_replace(array('{click}', '{url}', '{sitename}'), array($click, $url, $this->Config['site_name']), $this->member_config['member_emailchecktpl']);
                $r = sendmail($email, L('USER_REGISTER_CHECKEMAIL') . '-' . $this->Config['site_name'], $message, $this->Config);
                $this->assign('send_ok', 1);
                $this->assign('username', $username);
                $this->assign('email', $email);
                $this->display();
                exit;
            }
        }
        if ($this->_groupid == 5) {
            $this->display();
        } else {
            $this->error(L('do_empty'));
        }
    }

    function regcheckemail() {
        $code = str_replace(' ', '+', $_REQUEST['code']);
        list($userid, $username, $email) = explode("-", authcode($code, 'DECODE', $this->sysConfig['ADMIN_ACCESS']));
        $user = M('User');
        //判断邮箱是用户是否正确
        $data = $user->where("id={$userid} and username='{$username}' and email='{$email}'")->find();
        if ($data) {
            $user->groupid = 3;
            $user->id = $userid;
            $user->save();
            $ru['role_id'] = 3;
            $roleuser = M('RoleUser');
            $roleuser->where("user_id=" . $userid)->save($ru);
            $this->assign('jumpUrl', U('User/Login/index'));
            $this->assign('waitSecond', 10);
            $this->success(L('do_regcheckemail_success'));
        } else {
            $this->error(L('check_url_error'));
        }
    }

    function logout() {
        if ($this->_userid) {
            cookie(null, 'GZ_');
            $this->assign('jumpUrl', $this->forward);
            $this->success(L('loginouted'));
        } else {
            $this->assign('jumpUrl', $this->forward);
            $this->error(L('logined'));
        }
    }

}

?>