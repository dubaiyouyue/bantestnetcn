<?php
/**
 * 
 * Oauth (第三方登陆接口管理)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class OauthAction extends AdminbaseAction {

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('oauth');
    }

    public function index() {
        //获取已经安装的接口
        $list = $this->get_installed();
        //从文件夹下面读取
        $opdir = dir(LIB_PATH . 'ORG/ThinkSDK/sdk');
        while (false !== ($entry = $opdir->read())) {
            if ($entry{0} == '.') {
                continue;
            }//var_dump($entry);
            if (!isset($list[$entry])) {                
                $info = $this->get_file_info($entry);
                $info['status'] = '-1';
                $info['ordid'] = '0';
                $info['id'] = '0';
                $list[$entry] = $info;
            }
        }
        $this->assign('list', $list);
        $this->assign('list_table', true);
        $this->display();
    }

    /**
     * 编辑
     */
    public function edit() {
        if (IS_POST) {
            if (false === $data = $this->_mod->create()) {
                $this->ajaxReturns(0, $this->_mod->getError());
            }
            $info = $this->get_file_info($data['code']);
            foreach ($info['config'] as $key=>$val) {
                $config[$key] = $this->_post($key);
            }
            $this->_mod->config = serialize($config);
            if (false !== $this->_mod->save()) {
                $this->ajaxReturns(1, L('operation_success'), '', 'edit');
            } else {
                $this->ajaxReturns(0, L('operation_failure'), '', 'edit');
            }
        } else {
            $id = $this->_get('id', 'intval');
            $info = $this->_mod->find($id);
            $info['config'] = unserialize($info['config']);
            $this->assign('info', $info);
            //配置文件
            $file_info = $this->get_file_info($info['code']);
            $this->assign('file_info', $file_info);
            $response = $this->fetch();
            $this->ajaxReturns(1, '', $response);
        }
    }

    /**
     * 安装
     */
    public function install() {
        if (IS_POST) {
            if (false === $data = $this->_mod->create()) {
                $this->ajaxReturns(0, $this->_mod->getError());
            }
            $info = $this->get_file_info($data['code']);
            foreach ($info['config'] as $key=>$val) {
                $config[$key] = $this->_post($key);
            }
            $this->_mod->config = serialize($config);
            if ($this->_mod->add()) {
                $this->ajaxReturns(1, L('install_success'), '', 'install');
            } else {
                $this->ajaxReturns(0, L('install_failure'), '', 'install');
            }
        } else {
            $code = $this->_get('code', 'trim');
            $info = $this->get_file_info($code);
            $this->assign('info', $info);
            $response = $this->fetch();
            $this->ajaxReturns(1, '', $response);
        }
    }
    
    
        //获取已经安装的接口
    public function get_installed() {
        $installed_list = array();
        $installed_res = $this->_mod->order('ordid')->select();
        foreach ($installed_res as $val) {
            $installed_list[$val['code']] = $val;
        }
        return $installed_list;
    }

    //缓存有效接口
    public function oauth_cache() {
        $oauth_list = array();
        $oauth_data = $this->_mod->field('code,name,config')->where(array('status'=>'1'))->order('ordid')->select();
        foreach ($oauth_data as $val) {
            $oauth_list[$val['code']] = $val;
        }
        F('oauth_list', $oauth_list);
        return $oauth_list;
    }

    //获取未安装接口信息
    public function get_file_info($code) {
        return include(LIB_PATH . 'ORG/ThinkSDK/sdk/'.$code.'/'.$code.'_info.php');
    }
}