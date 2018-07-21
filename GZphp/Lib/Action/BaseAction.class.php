<?php

/**
 * 
 * Base (前台公共模块)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP"))  exit("Access Denied");

class BaseAction extends Action
{
	protected   $Config ,$sysConfig,$categorys,$module,$moduleid,$mod,$dao,$Type,$Role,$_userid,$_groupid,$_email,$_username ,$forward ,$user_menu,$Lang,$member_config;
    public function _initialize() {

//print_r($_GET);exit;
			$this->sysConfig = F('sys.config');
			$this->module = F('Module');
			$this->Role = F('Role');
			$this->Type =F('Type');
			$this->mod= F('Mod');
			$this->moduleid=$this->mod[MODULE_NAME];
			if(APP_LANG){
				$this->Lang = F('Lang');
				$this->assign('Lang',$this->Lang);
				if(get_safe_replace($_GET['l'])){
					if(!$this->Lang[$_GET['l']]['status'])$this->error ( L ( 'NO_LANG' ) );
					$lang=$_GET['l'];
				}else{
					$lang=$this->sysConfig['DEFAULT_LANG'];
				}
				define('LANG_NAME', $lang);
				define('LANG_ID', $this->Lang[$lang]['id']);
				$this->categorys = F('Category_'.$lang);
				$this->Config = F('Config_'.$lang);
				$this->assign('l',$lang);
				$this->assign('langid',LANG_ID);
				$T = F('config_'.$lang,'', APP_PATH.'Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/');
				C('TMPL_CACHFILE_SUFFIX','_'.$lang.'.php');
				cookie('think_language',$lang);
			}else{
				$T = F('config_'.$this->sysConfig['DEFAULT_LANG'],'',  APP_PATH.'Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/');
				$this->categorys = F('Category');
				$this->Config = F('Config');
				cookie('think_language',$this->sysConfig['DEFAULT_LANG']);
			}
			$this->assign('T',$T);
			$this->assign($this->Config);
			$this->assign('Role',$this->Role);
			$this->assign('Type',$this->Type);
			$this->assign('Module',$this->module);
			$this->assign('Categorys',$this->categorys);
			import("@.ORG.Form");			
			$this->assign ( 'form',new Form());
 
			C('HOME_ISHTML',$this->sysConfig['HOME_ISHTML']);
			C('PAGE_LISTROWS',$this->sysConfig['PAGE_LISTROWS']);
			C('URL_M',$this->sysConfig['URL_MODEL']);
			C('URL_M_PATHINFO_DEPR',$this->sysConfig['URL_PATHINFO_DEPR']);
			C('URL_M_HTML_SUFFIX',$this->sysConfig['URL_HTML_SUFFIX']);
			C('URL_LANG',$this->sysConfig['DEFAULT_LANG']);
			C('DEFAULT_THEME_NAME',$this->sysConfig['DEFAULT_THEME']);


			import("@.ORG.Online");
			$session = new Online();
			if(cookie('auth')){
				$gzphp_auth_key = sysmd5($this->sysConfig['ADMIN_ACCESS'].$_SERVER['HTTP_USER_AGENT']);
				list($userid,$groupid, $password) = explode("-", authcode(cookie('auth'), 'DECODE', $gzphp_auth_key));
				$this->_userid = $userid;
				$this->_username =  cookie('username');
				$this->_groupid = $groupid; 
				$this->_email =  cookie('email');
			}else{
				$this->_groupid = cookie('groupid') ?  cookie('groupid') : 4;
				$this->_userid =0;
			}


			foreach((array)$this->module as $r){
				if($r['issearch'])$search_module[$r['name']] = L($r['name']);
				if($r['ispost'] && (in_array($this->_groupid,explode(',',$r['postgroup']))))$this->user_menu[$r['id']]=$r;
			}
			if(GROUP_NAME=='User'){
				$langext = $lang ? '_'.$lang : '';
				$this->member_config=F('member.config'.$langext);
				$this->assign('member_config',$this->member_config);
				$this->assign('user_menu',$this->user_menu);
				if($this->_groupid=='5' &&  MODULE_NAME!='Login'){ 
					$this->assign('jumpUrl',URL('User-Login/emailcheck'));
					$this->assign('waitSecond',3);
					$this->success(L('no_regcheckemail'));
					exit;
				}
				$this->assign('header',TMPL_PATH.'Home/'.THEME_NAME.'/Home_header.html');
			}
			if($_GET['forward'] || $_POST['forward']){	
				$this->forward = get_safe_replace($_GET['forward'].$_POST['forward']);
			}else{
				if(MODULE_NAME!='Register' || MODULE_NAME!='Login' )
				$this->forward =isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :  $this->Config['site_url'];
			}
			$this->assign('forward',$this->forward);
			$this->assign('search_module',$search_module);
			$this->assign('module_name',MODULE_NAME);
			$this->assign('action_name',ACTION_NAME);

			$lanmugywm=M('column')->where('bigclass=314')->order('no_order asc,id asc')->select();
			$lanmuffwz=M('column')->where('bigclass=445')->order('no_order asc,id asc')->select();
		  $lanmuzx=M('column')->where('bigclass=452')->order('no_order asc,id asc')->select();
		  $lanmuffwz=array_merge($lanmuffwz,$lanmuzx);
			$this->assign('getlink',$this->getlink());
			$this->assign('lanmugywm',$lanmugywm);
			$this->assign('lanmuffwz',$lanmuffwz);
			
			
			
			//new start
			//所有栏目
			global $new_column_list;
			$new_column_list_where['lang']=array('eq','cn');
			$new_column_list=M('column')->where($new_column_list_where)->field('id,name,enname,bigclass,foldername,nav,columnimg,namemark,classtype,module,out_url')->order('no_order asc,id asc')->select();
			foreach($new_column_list as $kuccc=>&$kuccv){
				$kuccv['foldername']=ucfirst($kuccv['foldername']);
			}
			//dump($new_column_list);exit;
			$this->assign('new_column_list',$new_column_list);
			//一级栏目
			$new_column_list_where['bigclass']=array('eq',0);
			$new_column_list_where['nav']=array('gt',0);
			//unset($new_column_list_where['nav']);
			$new_column_list_top=M('column')->where($new_column_list_where)->field('id,name,ctitle,enname,bigclass,foldername,nav,columnimg,namemark,classtype,module,out_url')->order('no_order asc,id asc')->select();
			foreach($new_column_list_top as $kuccct=>&$kuccvt){
				$kuccvt['foldername']=ucfirst($kuccvt['foldername']);
			}
			
			$this->assign('new_column_list_top',$new_column_list_top);
			//dump($new_column_list_top);exit;
			//print_r($d);exit;
			//当前栏目图片
			$cid=$_GET['cid']+0;
			//print_r($cid);exit$now_cid_first
			if($cid){
				foreach($new_column_list as $nc=>$nk){
					if($nk['id']==$cid){
						global $columnimg;
						$columnimg=$nk['columnimg'];
						global $namemark;
						$namemark=$nk['namemark'];
						//当前栏目一级栏目id
						global $now_cid_first;
						global $foldername;
						$foldername=$nk['foldername'];
						//当没有图片，使用一级栏目图片

							//当一级栏目没有图片的时候当前一级栏目id不存在 bug

						if(!$columnimg){
							foreach($new_column_list as $ncb=>$nkb){
								if($nkb['id']==$nk['bigclass']){
									$now_cid_first=$nkb['id'];
									$columnimg=$nkb['columnimg'];
								}
								if(!$columnimg){
									foreach($new_column_list as $ncbf=>$nkbf){
										if($nkbf['id']==$nk['bigclass']){
											$nnnwwwsid=$nkbf['bigclass'];
											$nnnwwwsidimg=$this->get_column_info($nnnwwwsid);
											$now_cid_first=$nnnwwwsid;
										$columnimg=$nnnwwwsidimg['columnimg'];
										}
									}
								}
							}
						}
						//当前位置
						//如果是三级栏目
						//echo $nk['classtype'];exit;
						$cccurld='/index.php/Home/'.$foldername.'/index/cid/';
						if($nk['classtype']==3){
							//三级栏目
							$location_fre_id=$cid;
							$location_fre_name=$nk['name'];
							//二级栏目
							$location_two_id=$nk['bigclass'];
							$location_two_cinfo=$this->get_column_info($location_two_id);
							$location_two_name=$location_two_cinfo['name'];
							//一级栏目
							$location_one_id=$location_two_cinfo['bigclass'];
							$location_one_cinfo=$this->get_column_info($location_one_id);
							$location_one_name=$location_one_cinfo['name'];
							$location_all=array(
								array($cccurld.$location_one_id.'.html',$location_one_name),
								array($cccurld.$location_two_id.'.html',$location_two_name),
								array($cccurld.$location_fre_id.'.html',$location_fre_name)
							);
						}else if($nk['classtype']==2){
							//2级栏目
							$location_two_id=$cid;
							$location_two_name=$nk['name'];
							//一级栏目
							$location_one_id=$nk['bigclass'];
							$location_one_cinfo=$this->get_column_info($location_one_id);
							$location_one_name=$location_one_cinfo['name'];
							$location_all=array(
								array($cccurld.$location_one_id.'.html',$location_one_name),
								array($cccurld.$location_two_id.'.html',$location_two_name)
							);
						}else{
							//一级栏目
							$location_one_id=$cid;
							$location_one_name=$nk['name'];
							$location_all=array(
								array($cccurld.$location_one_id.'.html',$location_one_name)
							);
						}
						$this->assign('location_all',$location_all);
						//dump($location_all);exit;
					}
				}
					//模板文件
					global $namemark_tpl;
					$namemark_tpl='index';
					/*if(!$now_cid_first && $namemark){
						$namemark_tpl=$namemark;
					};*/
					if($namemark){
						$namemark_tpl=$namemark;
					};

					
				//第一个子栏目
				global $now_cid_cfirst;
				if(!$now_cid_first) $now_cid_first=$cid;
				if($now_cid_first){
					foreach($new_column_list as $nnc=>$nnk){
						if($nnk['bigclass']==$now_cid_first){
							$now_cid_cfirst=$nnk['id'];
							//echo $now_cid_cfirst;exit;
							break;
							//return true;
						}
					}
				}/*else{
					$now_cid_cfirst=$cid;
				}*/
				
					$this->assign('foldername',$foldername);
					//不填写栏目修饰名称，跳转到下一个子栏目
					if($now_cid_cfirst && !$namemark && ($now_cid_first==$cid)){
						header('Location:/index.php/Home/'.$foldername.'/index/cid/'.$now_cid_cfirst.'.html');
						exit;
					};
					
				//当前位置
				//一级栏目名称
				//global $now_cid_first_name;
				
			}
			//echo 'fadsfads';
			//echo $now_cid_cfirst;exit;
			$this->assign('cid',$cid);
			$this->assign('now_cid_first',$now_cid_first);
			$this->assign('columnimg',$columnimg);
			//end 20170105
			$this->assign('new_column_list',$new_column_list);
			//关于莱茵
			$gylyjjjj=M('column')->where('id=136')->field('description')->limit(1)->select();
			//print_r($gylyjjjj);exit;
          
			$this->assign('gylyjjjj',$gylyjjjj['0']['description']);
			$pagenow=$_GET['p']+0;
			if(!$pagenow) $pagenow=1;
			$this->assign('pagenow',$pagenow);
			
			//获取基本信息
			global $config_info;
			$wccongff['lang']='cn';
			$config_info=M('config')->where($wccongff)->select();
			//dump($config_info);exit;
			foreach($config_info as $cck=>$ccv){
				$ccv['value']=str_ireplace('//','/',$ccv['value']);
				$ccv['value']=str_ireplace('../','/',$ccv['value']);
				$new_config_info[$ccv['name']]=$ccv['value'];
			}
			//dump($new_config_info['gz_ewm']);exit;
			$this->assign('config_info',$new_config_info);
			
			//SEO
			if(!$cid){
				//首页
				$seo_title='首页-'.$new_config_info['gz_webname'];
				$seo_keywords=$new_config_info['gz_keywords'];
				$seo_description=$new_config_info['gz_description'];
			}else{
				$wcinfo['id']=$cid;
				$cinfo=M('column')->where($wcinfo)->field('name,keywords,description,ctitle')->find();
				$seo_title=$cinfo['name'].'-'.$new_config_info['gz_webname'];
				if($cinfo['ctitle']) $seo_title=$cinfo['ctitle'].'-'.$new_config_info['gz_webname'];
				$seo_keywords=$cinfo['keywords'];
				$seo_description=$cinfo['description'];
				
				$id=$_GET['id']+0;
			//print_r($id);exit;
				if($id){
					$wnewss['id']=$id;
					$newssinfo=M('news')->where($wnewss)->field('title,ctitle,keywords,description')->find();
				//print_r($newssinfo);exit();
					$seo_title=$newssinfo['title'].'-'.$seo_title;
					if($cinfo['ctitle']) $seo_title=$newssinfo['ctitle'].'-'.$seo_title;
					$seo_keywords=$newssinfo['keywords'];
					$seo_description=$newssinfo['description'];
				}
				
			}
			$this->assign('seo_title',$seo_title);
			$this->assign('seo_keywords',$seo_keywords);
			$this->assign('seo_description',$seo_description);
			
				
	}
	//分页
	public function Pagenewinfo($classname,$cid,$img,$hyid){
		if($img) $w['imgurl']=array('neq','');
		if($hyid) $w['gz_headeryjhhyy']=$hyid;
		$w[$classname]=$cid;
		$l=M('news')->where($w)->select();
		$all=count($l);
		return $all;
	}
	
	//获取文章内容
	public function newinfo($id){
		$w['id']=$id;
		$l=M('news')->where($w)->find();
		$class1=$l['class1'];
		$class2=$l['class2'];
		$class3=$l['class3'];
		//上下篇
		$ws['id']=array('lt',$id);
		$ws['class1']=$class1;
		$ws['class2']=$class2;
		$ws['class3']=$class3;
		$ls=M('news')->where($ws)->find();
		
		$wx['id']=array('gt',$id);
		$wx['class1']=$class1;
		$wx['class2']=$class2;
		$wx['class3']=$class3;
		$lx=M('news')->where($wx)->find();

		$l['sx']=array(
			's'=>$ls,
			'x'=>$lx
		);
		return $l;
	}
	//获取文章列表
	public function new_list($classname,$cid,$p,$m,$img,$k,$hyid){
		if($img) $w['imgurl']=array('neq','');
		if($k) $w['title']=array('like','%'.$k.'%');
		if($hyid) $w['gz_headeryjhhyy']=$hyid;
		$w[$classname]=$cid;
		$p=$p+0;
		if($p<0) $p=0;
		$n=$p*$m;
		if($p>0) $n=($p-1)*$m;
		//dump($w);exit;
		$l=M('news')->where($w)->order('com_ok desc,no_order asc,id desc')->limit($n,$m)->select();
	//print_r($l);exit();
		return $l;
	}
	
	
	
	
	//获取栏目列表
	public function lanmu_list($bigclass,$cid,$p,$m,$img){
		if($img) $w['imgurl']=array('neq','');
		$w[$bigclass]=$cid;
		$p=$p+0;
		if($p<0) $p=0;
		$n=$p*$m;
		if($p>0) $n=($p-1)*$m;
		$lmm=M('column')->where($w)->order('id asc')->limit($n,$m)->select();
	//dump($lmm);exit();
		return $lmm;
	}
	
	
	
	
	
	
	
	
	public function new_page_info($cid=0){
		//单页栏目获取
		//$cid=$_GET['cid']+0;
		//global $new_column_list;
			$new_column_list_where['lang']=array('eq','cn');
			$new_column_list_where['id']=$cid;
			$cid_arr=explode(',',$cid);
			if($cid['1']) $new_column_list_where['id']=array('in',$cid);
			//dump($cid_arr);exit;
			$new_column_list=M('column')->where($new_column_list_where)->order('no_order desc,id desc')->select();
			//dump($new_column_list);exit;
			if(!$cid['1']) return $new_column_list['0'];
			return $new_column_list;
			//$this->assign('new_column_list',$new_column_list);
		/*if($cid){
			foreach($new_column_list as $nc=>$nk){
				if($nk['id']==$cid){
					return $nlist[]=$nk;
				}
			}
		}*/
	}
	public function get_column_info($cid){
		global $new_column_list;
		//获取栏目信息
		foreach($new_column_list as $k=>$v){
			if($cid==$v['id']){
				return $v;
			}
		}
	}
	//获取banner
	public function bannerlist($cid){
		$cid=','.$cid.',';
		$w['module']=$cid;
		$l=M('flash')->where($w)->select();
		return $l;
	}


	public function bannerlists($cid){
		$cid=','.$cid.',';
		$w['module']=$cid;
		$l=M('flash')->where($w)->find();
		return $l;
	}
	
	
    public function index($catid='',$module='')
    {
		

		
                $parentcount = count(explode(',', $this->categorys[$catid]['arrparentid']));
                if($this->categorys[$catid]['child'] != '0'){
                    $jump_url = M('category')->where("parentid = '$catid'")->order('listorder,id')->getfield('url');
                    //redirect("http://".$_SERVER['HTTP_HOST'].$jump_url);
                }
		$this->Urlrule =F('Urlrule');
		if(empty($catid)) $catid =  intval($_REQUEST['id']);
		$p= max(intval($_REQUEST[C('VAR_PAGE')]),1);
		if($catid){
			$cat = $this->categorys[$catid];
			$bcid = explode(",",$cat['arrparentid']); 
			$bcid = $bcid[1]; 
			if($bcid == '') $bcid=intval($catid);
			if(empty($module))$module=$cat['module'];
			$this->assign('module_name',$module);
			unset($cat['id']);
			$this->assign($cat);
			$cat['id']=$catid;
			$this->assign('catid',$catid);
			$this->assign('bcid',$bcid);
		}
		if($cat['readgroup'] && $this->_groupid!=1 && !in_array($this->_groupid,explode(',',$cat['readgroup']))){$this->assign('jumpUrl',URL('User-Login/index'));$this->error (L('NO_READ'));}
		$fields = F($this->mod[$module].'_Field');
		foreach($fields as $key=>$r){
			$fields[$key]['setup'] =string2array($fields[$key]['setup']);
		}
		$this->assign ( 'fields', $fields); 


		$seo_title = $cat['title'] ? $cat['title'] : $cat['catname'];
		$this->assign ('seo_title',$seo_title);
		$this->assign ('seo_keywords',$cat['keywords']);
		$this->assign ('seo_description',$cat['description']);
				
		

		
		
		
		
		
		
		
		
		if($module=='Guestbook'){
			$where['status']=array('eq',1);
			$this->dao= M($module);
			$count = $this->dao->where($where)->count();
			if($count){
				import ( "@.ORG.Page" );
				$listRows =  !empty($cat['pagesize']) ? $cat['pagesize'] : C('PAGE_LISTROWS');		
				$page = new Page ( $count, $listRows );
				$page->urlrule = geturl($cat,'');
				$pages = $page->show();
				$field =  $this->module[$cat['moduleid']]['listfields'];
				$field =  $field ? $field : '*';
				$list = $this->dao->field($field)->where($where)->order('listorder desc,createtime desc,id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
				
				$this->assign('pages',$pages);
				$this->assign('list',$list);
			}
			$template = $cat['module']=='Guestbook' && $cat['template_list'] ? $cat['template_list'] : 'index';
			$this->display(THEME_PATH.$module.'_'.$template.'.html');            
		}elseif($module=='Feedback'){
			$template = $cat['module']=='Feedback' && $cat['template_list'] ? $cat['template_list'] : 'index' ;

			$this->display(THEME_PATH.$module.'_'.$template.'.html');
		}elseif($module=='Page'){
			$modle=M('Page');
			$data = $modle->find($catid);
			unset($data['id']);

			//分页
			$CONTENT_POS = strpos($data['content'], '[page]');
			if($CONTENT_POS !== false) {			
				$urlrule = geturl($cat,'',$this->Urlrule);
				$urlrule[0] =  urldecode($urlrule[0]);
				$urlrule[1] =  urldecode($urlrule[1]);
				$contents = array_filter(explode('[page]',$data['content']));
				$pagenumber = count($contents);
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = str_replace('{$page}',$i,$urlrule);
				} 
				$pages = content_pages($pagenumber,$p, $pageurls);
				//判断[page]出现的位置
				if($CONTENT_POS<7) {
					$data['content'] = $contents[$p];
				} else {
					$data['content'] = $contents[$p-1];
				}
				$this->assign ('pages',$pages);	
			}

			$template = $cat['template_list'] ? $cat['template_list'] :  'index' ;
			$this->assign ($data);	
			$this->display(THEME_PATH.$module.'_'.$template.'.html');

		}else{
			
			if($catid){
				$seo_title = $cat['title'] ? $cat['title'] : $cat['catname'];
				$this->assign ('seo_title',$seo_title);
				$this->assign ('seo_keywords',$cat['keywords']);
				$this->assign ('seo_description',$cat['description']);
				

				$where = " status=1 ";
				if($cat['child']){							
					$where .= " and catid in(".$cat['arrchildid'].")";			
				}else{
					$where .=  " and catid=".$catid;			
				}
				$newcatid=$_GET['newcatid']+0;
				if(!$newcatid){
					//dump($cat['arrchildid']);
					$nnneecattid=explode(',',$cat['arrchildid']);
					$nnneecattid=$nnneecattid['1'];
					if($catid==148 || $catid==156 || $catid==167) $newcatid=$nnneecattid;
				}
				
				if($newcatid){
					$where .=  " and catid=".$newcatid;
				}
				$this->assign('newcatidnew',$newcatid);
				
				if(empty($cat['listtype'])){
					$this->dao= M($module);
					$count = $this->dao->where($where)->count();
					if($count){
						import ( "@.ORG.Page" );
						$listRows =  !empty($cat['pagesize']) ? $cat['pagesize'] : C('PAGE_LISTROWS');
						$page = new Page ( $count, $listRows );
						$page->urlrule = geturl($cat,'',$this->Urlrule);
						$pages = $page->show(1);
						$field =  $this->module[$this->mod[$module]]['listfields'];
						$field =  $field ? $field : 'id,catid,userid,url,username,title,title_style,keywords,description,thumb,createtime,hits';
						$list = $this->dao->field($field)->where($where)->order('listorder desc,createtime desc,id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
						$this->assign('pages',$pages);
						$this->assign('list',$list);
					}
					$template_r = 'list';
				}else{
					$template_r = 'index';
				}
			}else{
				$template_r = 'list';
			}
			$template = $cat['template_list'] ? $cat['template_list'] : $template_r;
			$this->display($module.':'.$template);
		}
    }

 

	public function show($id='',$module='')
    {
		$this->Urlrule =F('Urlrule');
		$p= max(intval($_REQUEST[C('VAR_PAGE')]),1);		
		$id = $id ? $id : intval($_REQUEST['id']);
		$module = $module ? $module : MODULE_NAME;
		$this->assign('module_name',$module);
		$this->dao= M($module);;
		$data = $this->dao->find($id);
		
		
		$catid = $data['catid'];
		$cat = $this->categorys[$data['catid']];
		if(empty($cat['ishtml']))$this->dao->where("id=".$id)->setInc('hits'); //添加点击次数
		$bcid = explode(",",$cat['arrparentid']); 
		$bcid = $bcid[1]; 
		if($bcid == '') $bcid=intval($catid);

		if($data['readgroup']){
			if($this->_groupid!=1 && !in_array($this->_groupid,explode(',',$data['readgroup'])) )$noread=1;
		}elseif($cat['readgroup']){
			if($this->_groupid!=1 && !in_array($this->_groupid,explode(',',$cat['readgroup'])) )$noread=1;
		}
		if($noread==1){$this->assign('jumpUrl',URL('User-Login/index'));$this->error (L('NO_READ'));}

		$chargepoint = $data['readpoint'] ? $data['readpoint'] : $cat['chargepoint']; 
		if($chargepoint && $data['userid'] !=$this->_userid){
			$user = M('User');
			$userdata =$user->find($this->_userid);
			if($cat['paytype']==1 && $userdata['point']>=$chargepoint){
				$chargepointok = $user->where("id=".$this->_userid)->setDec('point',$chargepoint);
			}elseif($cat['paytype']==2 && $userdata['amount']>=$chargepoint){
				$chargepointok = $user->where("id=".$this->_userid)->setDec('amount',$chargepoint);
			}else{
				$this->error (L('NO_READ'));
			}
		}
	/*上一篇下一篇 add by wei 2012-11-09*/
	$pre = M($module)->where("id<$id and catid=$catid and lang=".LANG_ID)->order("id DESC")->find();
    $next = M($module)->where("id>$id and catid=$catid and lang=".LANG_ID)->order("id ASC")->find();
    $this->assign('pre',$pre);
    $this->assign('next',$next);
	/*end*/

	
		$seo_title = $data['title'].'-'.$cat['catname'];
		$this->assign ('seo_title',$seo_title);
		$this->assign ('seo_keywords',$data['keywords']);
		$this->assign ('seo_description',$data['description']);
		$this->assign ( 'fields', F($cat['moduleid'].'_Field') ); 
		

		$fields = F($this->mod[$module].'_Field');
		foreach($data as $key=>$c_d){
			$setup='';
			$fields[$key]['setup'] =$setup=string2array($fields[$key]['setup']);
			if($setup['fieldtype']=='varchar' && $fields[$key]['type']!='text'){
				$data[$key.'_old_val'] =$data[$key];
				$data[$key]=fieldoption($fields[$key],$data[$key]);
			}elseif($fields[$key]['type']=='images' || $fields[$key]['type']=='files'){ 
				if(!empty($data[$key])){
					$p_data=explode(':::',$data[$key]);
					$data[$key]=array();
					foreach($p_data as $k=>$res){
						$p_data_arr=explode('|',$res);					
						$data[$key][$k]['filepath'] = $p_data_arr[0];
						$data[$key][$k]['filename'] = $p_data_arr[1];
					}
					unset($p_data);
					unset($p_data_arr);
				}
			}
			unset($setup);
		}
		$this->assign('fields',$fields); 


		//手动分页
		$CONTENT_POS = strpos($data['content'], '[page]');
		if($CONTENT_POS !== false) {
			
			$urlrule = geturl($cat,$data,$this->Urlrule);
			$urlrule =  str_replace('%7B%24page%7D','{$page}',$urlrule); 
			$contents = array_filter(explode('[page]',$data['content']));
			$pagenumber = count($contents);
			for($i=1; $i<=$pagenumber; $i++) {
				$pageurls[$i] = str_replace('{$page}',$i,$urlrule);
			} 
			$pages = content_pages($pagenumber,$p, $pageurls);
			//判断[page]出现的位置是否在文章开始
			if($CONTENT_POS<7) {
				$data['content'] = $contents[$p];
			} else {
				$data['content'] = $contents[$p-1];
			}
			$this->assign ('pages',$pages);	
		}

		if(!empty($data['template'])){
			$template = $data['template'];
		}elseif(!empty($cat['template_show'])){
			$template = $cat['template_show'];
		}else{
			$template =  'show';
		}

		$this->assign('catid',$catid);
		$this->assign ($cat);
		$this->assign('bcid',$bcid);

		$this->assign ($data);

		$this->display($module.':'.$template); 
    }

	public function down()
	{

		$module = $module ? $module : MODULE_NAME;
		$id = $id ? $id : intval($_REQUEST['id']);
		$this->dao= M($module);
		$filepath = $this->dao->where("id=".$id)->getField('file');
		$this->dao->where("id=".$id)->setInc('downs');

		if(strpos($filepath, ':/')) { 
			header("Location: $filepath");
		} else {	
			$filepath = '.'.$filepath;
			if(!$filename) $filename = basename($filepath);
			$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
			if(strpos($useragent, 'msie ') !== false) $filename = rawurlencode($filename);
			$filetype = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
			$filesize = sprintf("%u", filesize($filepath));
			if(ob_get_length() !== false) @ob_end_clean();
			header('Pragma: public');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: pre-check=0, post-check=0, max-age=0');
			header('Content-Transfer-Encoding: binary');
			header('Content-Encoding: none');
			header('Content-type: '.$filetype);
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Content-length: '.$filesize);
			readfile($filepath);
		}
		exit;
	}

	public function hits()
	{
		$module = $module ? $module : MODULE_NAME;
		$id = $id ? $id : intval($_REQUEST['id']);
		$this->dao= M($module);
		$this->dao->where("id=".$id)->setInc('hits');

		if($module=='Download'){
			$r = $this->dao->find($id);
			echo '$("#hits").html('.$r['hits'].');$("#downs").html('.$r['downs'].');';
		}else{
			$hits = $this->dao->where("id=".$id)->getField('hits');
			echo '$("#hits").html('.$hits.');';
		}
		exit;
	}
	public function verify()
    {
		header('Content-type: image/jpeg');
        $type	 =	 isset($_GET['type'])? get_safe_replace($_GET['type']):'jpeg';
        import("@.ORG.Image");
        Image::buildImageVerify(4,1,$type);
    }
	public function getSafeStr($str){
		$str=strip_tags($str);
		$s1 = iconv('utf-8','gbk',$str);
		$s0 = iconv('gbk','utf-8',$s1);
		if($s0 == $str){
			return $str;//'utf-8';
		}else{
			return iconv('gbk','utf-8',$str);//'gbk'
		}
	}
	public function getlink(){
		$w['show_ok']=1;
		//$w['show_ok']=1;
		return $list=M('link')->where($w)->order('com_ok desc,orderno desc')->select();
	}
}
?>