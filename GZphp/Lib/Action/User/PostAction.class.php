<?php

/**
 *
 * PostAction.class.php (前台内容管理)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <wei2l99@qq.com>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if (!defined("GZPHP"))
    exit("Access Denied");

class PostAction extends BaseAction {

    protected $dao, $fields;

    public function _initialize() {
        parent::_initialize();
        //$this->assign('jumpUrl', U('User/Login/index'));
        if (empty($this->Role[$this->_groupid]['allowpost'])) {
            $this->error(L('nologin'));
        }
        $this->assign('bcid', 0);
        $this->moduleid = intval($_REQUEST['moduleid']);

        if (!in_array($this->_groupid, explode(',', $this->module[$this->moduleid]['postgroup'])) && $this->moduleid != 0)
            $this->error(L('add_no_postgroup'));
        if ($this->moduleid) {
            $this->assign('moduleid', $this->moduleid);
            $module = $this->module[$this->moduleid]['name'];
            $this->dao = D($module);
            $fields = F($this->moduleid . '_Field');
            foreach ($fields as $key => $res) {
                if ($res['unpostgroup'])
                    $res['unpostgroup'] = explode(',', $res['unpostgroup']);
                if (!in_array($this->_groupid, $res['unpostgroup']) && $res['status']) {
                    $res['setup'] = string2array($res['setup']);
                    $this->fields[$key] = $res;
                }
            }
            unset($fields);
            unset($res);
            $this->assign('fields', $this->fields);
        }
    }

    /**
     * 列表
     *
     */
    public function index() {
        if (!$this->_userid) {
            $this->error(L('nologin'));
        }
        if ($this->module[$this->moduleid]['type'] == 1) {

            if ($this->categorys) {
                foreach ($this->categorys as $r) {
                    if ($r['type'] == 1 || !in_array($this->_groupid, explode(',', $r['postgroup'])))
                        continue;
                    if ($r['moduleid'] != $this->moduleid || $r['child']) {
                        $arr = explode(",", $r['arrchildid']);
                        $show = 0;
                        foreach ((array) $arr as $rr) {
                            if ($this->categorys[$rr]['moduleid'] == $this->moduleid)
                                $show = 1;
                        }
                        if (empty($show))
                            continue;
                        $r['disabled'] = $r['child'] ? ' disabled' : '';
                    }else {
                        $r['disabled'] = '';
                    }
                    $array[] = $r;
                }
                import('@.ORG.Tree');
                $str = "<option value='\$id' \$disabled \$selected>\$spacer \$catname</option>";
                $tree = new Tree($array);
                $select_categorys = $tree->get_tree(0, $str);
                $this->assign('select_categorys', $select_categorys);
                $this->assign('categorys', $this->categorys);
            }
            $this->assign('posids', F('Posid'));
        }

        import('@.Action.Adminbase');
        $c = new AdminbaseAction();
        $module = $this->module[$this->moduleid]['name'];
        $map['userid'] = array('eq', $this->_userid);
        if (APP_LANG)
            $map['lang'] = array('eq', $this->Lang[LANG_NAME][id]);
        $c->_list($module, $map);
        $this->display();
    }

    public function add() {
        $form = new Form();
        $form->isadmin = 0;
        $form->doThumb = $this->Role[$this->_groupid]['allowattachment'] ? 1 : 0;
        $form->doAttach = $this->Role[$this->_groupid]['allowattachment'] ? 1 : 0;
        ;
        $this->assign('form', $form);
        $module = $this->module[$this->moduleid]['name'];
        $template = file_exists(TMPL_PATH . 'User/' . $this->sysConfig['DEFAULT_THEME'] . '/' . $module . '_edit.html') ? $module . ':edit' : 'Post:edit';
        $this->display($template);
    }

    public function edit() {
        if (!$this->_userid) {
            $this->error(L('nologin'));
        }
        $id = intval($_REQUEST ['id']);
        $vo = $this->dao->getById($id);
        $form = new Form($vo);
        $form->isadmin = 0;
        $form->doAttach = $this->Role[$this->_groupid]['allowattachment'] ? 1 : 0;
        ;
        $form->doThumb = $this->Role[$this->_groupid]['allowattachment'] ? 1 : 0;
        $this->assign('vo', $vo);
        $this->assign('form', $form);
        $module = $this->module[$this->moduleid]['name'];
        $template = file_exists(TMPL_PATH . 'User/' . $this->sysConfig['DEFAULT_THEME'] . '/' . $module . '_edit.html') ? $module . ':edit' : 'Post:edit';
        $this->display($template);
    }
	public function Message() {
        /*dump($_POST);exit;
        if ($this->moduleid != 6 && $this->moduleid != 0 && !in_array($this->_groupid, explode(',', $this->categorys[$_POST['catid']]['postgroup'])))
           $this->error(L('add_no_postgroup'));*/
        $c = A('Admin/Content');
        //$_POST['ip'] = get_client_ip();


        if(empty($_POST['name']) || empty($_POST['tel']) || empty($_POST['email']) || empty($_POST['company']) || empty($_POST['message'])) {
            $this->error(L('信息填写不完整!'));
            exit;
        }
		$_POST['ctime']=time();
 $this->fields['name'] = htmlspecialchars(trim($this->fields['name']));
  $this->fields['tel'] = htmlspecialchars(trim($this->fields['tel']));
   $this->fields['email'] = htmlspecialchars(trim($this->fields['email']));
    $this->fields['company'] = htmlspecialchars(trim($this->fields['company']));
    $this->fields['message'] = htmlspecialchars(trim($this->fields['message']));

			//ajax
			if($_GET['ajax']=='ajax'){
				$ajax_date['ctime']=time();
				$ajax_date['name']=htmlspecialchars(trim($_POST['name']));
				$ajax_date['tel'] = htmlspecialchars(trim($_POST['tel']));
				$ajax_date['email'] = htmlspecialchars(trim($_POST['email']));
				$ajax_date['company'] = htmlspecialchars(trim($_POST['company']));
				$ajax_date['message'] = htmlspecialchars(trim($_POST['message']));
				echo M('message')->add($ajax_date);
				return false;
			}
        if ($this->moduleid == 0) {
            //$this->fields['content'] = $_POST['content'];
            //$this->fields['lang'] = $_POST['lang'];
            $this->fields['tableid'] = $_POST['tid'];
            $this->fields['tablemodule'] = $_POST['mid'];
        }
        $userid = $this->_userid;
        $username = $this->_username ? $this->_username : get_safe_replace($_POST['username']);
        if (!isset($this->module[$this->moduleid]['name'])) {
            if (!empty($this->fields['name']))
                $this->fields['name'] = htmlspecialchars(trim($this->fields['name']));
            if (!empty($this->fields['content']))
                $this->fields['content'] = htmlspecialchars(trim($this->fields['content']));

            $c->insert('Message', $this->fields, $userid, $username, $this->_groupid);
        } else {
			$c->insert('Message', $this->fields, $userid, $username, $this->_groupid);
            //$c->insert($this->module[$this->moduleid]['name'], $this->fields, $userid, $username, $this->_groupid);
        }
    }
    /**
     * 录入
     *
     */
    public function insert() {
        if ($this->moduleid != 6 && $this->moduleid != 0 && !in_array($this->_groupid, explode(',', $this->categorys[$_POST['catid']]['postgroup'])))
            $this->error(L('add_no_postgroup'));
        $c = A('Admin/Content');
        $_POST['ip'] = get_client_ip();
        if (empty($_POST['content']) && $this->moduleid == 0) {
            $this->error(L('留言内容不能为空!'));
        }
        if ($this->moduleid == 0) {
            $this->fields['content'] = $_POST['content'];
            $this->fields['lang'] = $_POST['lang'];
            $this->fields['tableid'] = $_POST['tid'];
            $this->fields['tablemodule'] = $_POST['mid'];
        }
        $userid = $this->_userid;
        $username = $this->_username ? $this->_username : get_safe_replace($_POST['username']);
        if (!isset($this->module[$this->moduleid]['name'])) {
            if (!empty($this->fields['title']))
                $this->fields['title'] = htmlspecialchars(trim($this->fields['title']));
            if (!empty($this->fields['content']))
                $this->fields['content'] = htmlspecialchars(trim($this->fields['content']));

            $c->insert('guestbook', $this->fields, $userid, $username, $this->_groupid);
        } else {
            $c->insert($this->module[$this->moduleid]['name'], $this->fields, $userid, $username, $this->_groupid);
        }
    }

    function update() {
        if (!$this->_userid) {
            $this->error(L('nologin'));
        }
        if ($this->moduleid != 6 && !in_array($this->_groupid, explode(',', $this->categorys[$_POST['catid']]['postgroup'])))
            $this->error(L('add_no_postgroup'));

        $c = A('Admin/Content');
        $c->update($this->module[$this->moduleid]['name'], $this->fields);
    }

}

?>