<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

class skinc{
	public $iniclass;//旧方法类
	public $metinfover;//获取模板引擎版本
	public $configlist;//配置数据
	public $mobile_configlist;//手机版配置数据
	public $metadmin;//模板后台功能
	public $no;//模板编号
	public $lang;//模板语言
	
	function __construct($no, $lang) {
		global $_M;
		$this->no = $no;
		$this->lang = $lang;
		$tmpincfile=PATH_WEB."templates/{$no}/metinfo.inc.php";
		if(file_exists($tmpincfile)){
			require_once $tmpincfile;
		}
		$metinfover = "v1";
		$this->metinfover = $metinfover;
		$this->metadmin = $metadmin;
		//$this->iniclass = load::mod_class('theme/class/oldskinc.class.php','new');
		load::mod_class('theme/class/skininc.class.php');
		$this->iniclass = new skininc($this->no, $this->lang);
		$configlist = array();
		$configlist[] = 'gz_skin_user';
		$configlist[] = 'gz_logo';
		/*首页*/
		$configlist[] = 'gz_skin_css';
		$configlist[] = 'gz_index_content';
		$configlist[] = 'flash_10001';
		$configlist[] = 'index_hadd_ok';
		$configlist[] = 'index_news_no';
		$configlist[] = 'index_product_no';
		$configlist[] = 'index_img_no';
		$configlist[] = 'index_download_no';
		$configlist[] = 'index_job_no';
		$configlist[] = 'index_link_ok';
		$configlist[] = 'index_link_img';
		$configlist[] = 'index_link_text';
		/*列表页*/
		$configlist[] = 'gz_bannerpagetype';
		$configlist[] = 'gz_product_list';
		$configlist[] = 'gz_news_list';
		$configlist[] = 'gz_download_list';
		$configlist[] = 'gz_img_list';
		$configlist[] = 'gz_job_list';
		$configlist[] = 'gz_message_list';
		$configlist[] = 'gz_search_list';
		$configlist[] = 'gz_productimg_x';
		$configlist[] = 'gz_productimg_y';
		$configlist[] = 'gz_imgs_x';
		$configlist[] = 'gz_imgs_y';
		$configlist[] = 'gz_newsimg_x';
		$configlist[] = 'gz_newsimg_y';
		$configlist[] = 'gz_product_page';
		$configlist[] = 'gz_img_page';
		$configlist[] = 'gz_urlblank';
		$configlist[] = 'gz_newsdays';
		$configlist[] = 'gz_hot';
		$configlist[] = 'gz_listtime';
		/*详情页*/
		$configlist[] = 'gz_tools_ok';
		$configlist[] = 'gz_contenttime';
		$configlist[] = 'gz_productdetail_x';
		$configlist[] = 'gz_productdetail_y';
		$configlist[] = 'gz_imgdetail_x';
		$configlist[] = 'gz_imgdetail_y';
		$configlist[] = 'gz_pageclick';
		$configlist[] = 'gz_pagetime';
		$configlist[] = 'gz_pageprint';
		$configlist[] = 'gz_pageclose';
		$configlist[] = 'gz_pnorder';
		$this->configlist = $configlist;
		$mobile_configlist = array();
		$mobile_configlist[] = 'wap_skin_user';
		$mobile_configlist[] = 'wap_skin_css';
		$mobile_configlist[] = 'gz_wap_logo';
		$mobile_configlist[] = 'flash_10001';
		$mobile_configlist[] = 'gz_bannerpagetype';
		$mobile_configlist[] = 'wap_news_list';
		$mobile_configlist[] = 'wap_product_list';
		$mobile_configlist[] = 'wap_download_list';
		$mobile_configlist[] = 'wap_img_list';
		$mobile_configlist[] = 'wap_job_list';
		$mobile_configlist[] = 'wap_message_list';
		$mobile_configlist[] = 'wap_search_list';
		$this->mobile_configlist = $mobile_configlist;
	}

	/*整理ini配置数据*/
	function tminiment($pos){
		global $_M;
		$langtextx = $this->iniclass -> tminiment($pos);
		return $langtextx;
	}
	
	/*预览*/
	function tminipreview($have){
		global $_M;
		//新方法
		$langtext = $this->iniclass -> tminiget('all');
		
		$cglist = $this->configlist;
		if($have['mobile']=='1'){
			$have['wap_skin_user'] = $have['gz_skin_user'];
			$have['wap_skin_css'] = $have['gz_skin_css'];
			$cglist = $this->mobile_configlist;
			$have['gz_flash_10001_y'] = $have['gz_flash_10001_y']?$have['gz_flash_10001_y']:'400';
			$have['flash_10001'] = '1|'.$have['gz_flash_10001_y'];
		}else{
			/*备用字段*/
			for($i=1;$i<=10;$i++){
				$preview['otherinfo']['info'.$i] = str_replace("\\","",$have['info'.$i]);
			}
			$preview['otherinfo']['imgurl1'] = $have['imgurl1'];
			$preview['otherinfo']['imgurl2'] = $have['imgurl2'];
			
			
			$have['flash_10001'] = '3|'.$have['gz_flash_10001_x'].'|'.$have['gz_flash_10001_y'].'|'.$have['gz_flash_10001_imgtype'];
		}
		/*系统配置数据*/
		$cglist[] = 'gz_productTabok';
		$cglist[] = 'gz_productTabname';
		$cglist[] = 'gz_productTabname_1';
		$cglist[] = 'gz_productTabname_2';
		$cglist[] = 'gz_productTabname_3';
		$cglist[] = 'gz_productTabname_4';
		foreach($cglist as $key=>$val){
			global $_M;
			$have[$val] = str_replace("\\","",$have[$val]);
			$preview['config'][$val]=$have[$val];
		}
		
		/*模板自定义参数*/
		foreach($langtext as $key=>$val){
			global $_M;
			//if($key!='linetop'){
				$namelist=$val['name']."_metinfo";
				$preview['langini'][$val['name']] = str_replace("\\","",$have[$namelist]);
			//}
		}
		
		/*大图轮播*/
		$have['indexbannerlist'] = str_replace("\\","",$have['indexbannerlist']);
		$preview['banner']['index'] = json_decode($have['indexbannerlist'],true);
		
		/*写入数据表*/
		$value = json_encode($preview);
		$value = str_replace("'","''",$value);
		$value = str_replace("\\","\\\\",$value);
		DB::query("UPDATE {$_M[table][config]} SET value = '{$value}' WHERE name = 'gz_theme_preview' AND lang='{$this->lang}'");
		//echo "UPDATE {$_M[table][config]} SET value = '{$value}' WHERE name = 'gz_theme_preview' AND lang='{$lang}'";
		//die();
	}
	
	/*保存配置*/
	function tminisave($have){
		global $_M;
		
		//新方法
		$this->iniclass->tminisave($have);
		
		$wap_ok = 0;
		$cglist = $this->configlist;
		if($have['mobile']=='1'){
			$have['wap_skin_user'] = $have['gz_skin_user'];
			$have['wap_skin_css'] = $have['gz_skin_css'];
			$cglist = $this->mobile_configlist;
			//$have['flash_10001'] = $_M['config']['flash_10001'];
			$have['flash_10001'] = '1|'.$have['gz_flash_10001_y'];
			$wap_ok = 1;
		}else{
			/*备用字段*/
			$preview['otherinfo']['imgurl1'] = $have['imgurl1'];
			$preview['otherinfo']['imgurl2'] = $have['imgurl2'];
			$query = "update {$_M[table][otherinfo]} SET ";
			for($i=1;$i<=10;$i++){
				$infoval = $have['info'.$i];
				if(isset($have['info'.$i]))$query.="info{$i} = '{$infoval}',";
			}
			$query.="
				imgurl1 = '{$have['imgurl1']}',
				imgurl2 = '{$have['imgurl2']}'
				where id='{$have['otherinfoid']}'
			";
			DB::query($query);
			load::sys_func('file');
			delfile(PATH_WEB."cache/otherinfo_{$this->lang}.inc.php");
			
			$have['flash_10001'] = '1|'.$have['gz_flash_10001_x'].'|'.$have['gz_flash_10001_y'].'|'.$have['gz_flash_10001_imgtype'];
		}
		$cglist[] = 'gz_productTabok';
		$cglist[] = 'gz_productTabname';
		$cglist[] = 'gz_productTabname_1';
		$cglist[] = 'gz_productTabname_2';
		$cglist[] = 'gz_productTabname_3';
		$cglist[] = 'gz_productTabname_4';
		configsave($cglist, $have, $this->lang);/*保存系统配置*/
		/*保存banner设置*/
		$nowidold = array();
		$bannerid = DB::get_all("select * from {$_M[table][flash]} where wap_ok='{$wap_ok}' and (module like '%,10001,%' or module = 'metinfo') and lang='{$this->lang}' and img_path!='' order by no_order ");
		foreach($bannerid as $key=>$val){
			$nowidold[] = $val['id'];
		}
		$nowidnew = array();
		$have['indexbannerlist'] = str_replace("\\","",$have['indexbannerlist']);
		$bannerlist = json_decode($have['indexbannerlist'],true);
		foreach($bannerlist as $key=>$val){
			if($val['img_path']!=''){
				if(!strstr($val['img_path'],"../"))$val['img_path'] = '../'.$val['img_path'];
				if($val['id']){
					$query = "update {$_M[table][flash]} SET 
					img_title = '{$val['img_title']}',
					img_path  = '{$val['img_path']}',
					img_link  = '{$val['img_link']}',
					no_order  = '{$key}'
					WHERE id  = '{$val['id']}'";
					$nowidnew[] = $val['id'];
				}else{
					$query = "INSERT INTO {$_M[table][flash]} SET 
					img_title = '{$val['img_title']}',
					img_path  = '{$val['img_path']}',
					img_link  = '{$val['img_link']}',
					no_order  = '{$key}',
					module    = ',10001,',
					wap_ok    = '{$wap_ok}',
					lang      = '{$this->lang}'";
				}
				DB::query($query);
			}
		}
		$nowid = array_diff($nowidold,$nowidnew);
		if($nowid){
			foreach($nowid as $key=>$val){
				$query = "delete from {$_M[table][flash]} where id='{$val}'";
				DB::query($query);
			}
		}
	}
	/*模板验证*/
	public function check($no) {
		global $_M;
		if($re != 'ok'){
			
		}
	}
	
	/*获取设置*/
	function setlidb(){
		global $_M;

	}

}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>