<?php
/**
 * 
 * SearchAction.class.php (前台搜索功能)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class SearchAction extends BaseAction
{

	function _initialize()
    {	
		parent::_initialize();
    }

    public function index()
    {
		//搜索
		$_REQUEST['id'] = $catid =  intval($_REQUEST['id']);
		$p= max(intval($_REQUEST[C('VAR_PAGE')]),1);
		$_REQUEST['keyword'] = $keyword = get_safe_replace($_REQUEST['keyword']);
		$_REQUEST['module'] = $module =  get_safe_replace($_REQUEST['module']);
		$module =  $module ? $module  : 'Article' ;
		$this->assign($_REQUEST);
		$this->assign('bcid',0);
		$where = " status=1 ";

		
		
		if(APP_LANG){
			$lang = LANG_NAME;
			$langid= LANG_ID;
			$where .=" and lang= $langid";
			$this->assign('lang',$lang);
			$this->assign('langid',$langid);
		}

		if($catid){
			$cat = $this->categorys[$catid];		
			$bcid = explode(",",$cat['arrparentid']); 
			$bcid = $bcid[1]; 
			if($bcid == '') $bcid=intval($catid);
			if(empty($module))$module=$cat['module'];	
			unset($cat['id']);
			$this->assign($cat);
			$cat['id']=$catid;
			$this->assign('catid',$catid);
			$this->assign('bcid',$bcid);


			if($cat['child']){							
				$where .= " and catid in(".$cat['arrchildid'].")";			
			}else{
				$where .=  " and catid=".$catid;			
			}
		}
		$seo_title = $cat['title'] ? $cat['title'] : $cat['catname'];
		$this->assign ('seo_title',$keyword.' '.$seo_title);
		$this->assign ('seo_keywords',$keyword.$cat['keywords']);
		$this->assign ('seo_description',$keyword.$cat['description']);
		

		
		if($keyword){ 
			
			if(strstr($keyword,'or')){
				$keydo = ' or ';
				$keyword_arr= explode('or',$keyword);
			}elseif(strstr($keyword,' ')){
				$keydo = ' AND ';
				$keyword_arr= explode(' ',$keyword);
			}
			
			if(count($keyword_arr)>1){
				foreach($keyword_arr as $key =>$keywordz){
					$keyword_arr[$key] = ' title like "%'.trim($keywordz).'%" ';
				}
				$where .= ' AND ('.implode($keydo,$keyword_arr).')';
			}else{
				$where .= ' AND title like "%'.$keyword.'%" ';
			}
		}
		$this->dao= M($module);
		//数据库表明区分大小写？
		$modulearr = array('Article');//遍历数据库
				$mcount = count($modulearr);
				$sql = '';
                foreach($modulearr as $k=>$v){
                    $sql .= "select id,catid,userid,url,username,title,title_style,keywords,description,thumb,createtime,hits from gz_$v where $where";
					if($k < ($mcount - 1))$sql .= " union all ";
                }
		//echo $sql;
				$select = M()->query($sql);
				//dump($select);
				$count = count($select);
		//$count=12321;
		$this->assign('count',$count);
		
		if($count){
			import ( "@.ORG.Page" );
			$listRows = 99999;//  !empty($cat['pagesize']) ? $cat['pagesize'] : C('PAGE_LISTROWS');
			$page = new Page ( $count, $listRows );
			$_REQUEST['p'] = '{$page}';
			$page->urlrule =  URL('Home-Search/index',$_REQUEST);
			$pages = $page->show();
			$field =  $this->module[$cat['moduleid']]['listfields'];
			$field =  $field ? $field : 'id,catid,userid,url,username,title,title_style,keywords,description,thumb,createtime,hits';
                        
				$mcount = count($modulearr);
				$sql = '';
                foreach($modulearr as $k=>$v){
                    $sql .= "select title,createtime,url from gz_$v where $where";
					if($k < ($mcount - 1))$sql .= " union all ";
                }
				$sql .= "order by createtime desc limit ".$page->firstRow . ',' . $page->listRows;
				$list = M()->query($sql);
			//dump($list);
			//echo $sql;
			$this->assign('pages',$pages);
			$this->assign('list',$list);
		}
                
                

		$this->display();

    } 
}
?>