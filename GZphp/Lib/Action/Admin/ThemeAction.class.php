<?php
/**
 * 
 * Theme(风格选择)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class ThemeAction extends AdminbaseAction
{
	 protected $filepath,$publicpath;
    function _initialize()
    {	
		parent::_initialize();
		$this->filepath = TMPL_PATH.'Home/'.$this->sysConfig['DEFAULT_THEME'].'/'; 
		$this->publicpath = TMPL_PATH.'Home/'.$this->sysConfig['DEFAULT_THEME'].'/Public/';
		$this->tplpath = TMPL_PATH.'Home/';
    }

    public function index()
    {
		$filed = glob($this->tplpath.'*');
		foreach ($filed as $key=>$v) {
			$arr[$key]['name'] =  basename($v);
			if(is_file($this->tplpath.$arr[$key]['name'].'/preview.jpg')){
				$arr[$key]['preview']=$this->tplpath.$arr[$key]['name'].'/preview.jpg';
			}else{
				$arr[$key]['preview']=__ROOT__.'/Public/Images/nopic.jpg';
			}
			if($this->sysConfig['DEFAULT_THEME']==$arr[$key]['name']) $arr[$key]['use']=1;
		}

		$this->assign ( 'themes',$arr );
        $this->display ();
    }
	public function chose()
	{
		$theme = $_GET['theme'];
		if($theme){
			$Model = M('Config');
			$r = $Model->where("varname='DEFAULT_THEME'")->setField('value',$theme);
			savecache('Config');
			$this->success(L('do_ok'));
		}else{
			$this->error(L('do_empty'));
		}
	}
	public function upload()
	{
		$this->display ();
	}
}
?>