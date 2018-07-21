<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');
echo <<<EOT
-->
<!DOCTYPE HTML>
<html>
<head>
<title>{$_M[word][metinfo]}</title>
<meta name="renderer" content="webkit">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link rel="stylesheet" href="/app/system/include/public/ui/admin/css/box.css" />
<link rel="stylesheet" href="/app/system/include/public/font-awesome/css/font-awesome.min.css" />
<style>/*后台左边左侧边栏菜单隐藏显示*/
#zbllll-4,#zbllll-69,#metinfo_metnav_75,#metinfo_metnav_77,#zbllll-74,#metinfo_metnav_10
,#yuyanxuanze-6-q,#yuyanxuanze-6,#yuyanxuanze-4,#metinfo_metnav_34,#metinfo_metnav_71,#zbllll-3,#zbllll-5,#zbllll-2,#zbllll-72
{display:none;display:none!important;}
#metcms_cont_leidden-xs::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

#metcms_cont_leidden-xs::-webkit-scrollbar
{
    width: 6px;
    background-color: #F5F5F5;
}

#metcms_cont_leidden-xs::-webkit-scrollbar-thumb
{
    background-color: #000000;
}
</style>
<script>
var langtxt = {
	"checkupdatetips":"{$_M[word][checkupdatetips]}",
	"detection":"{$_M[word][detection]}",
	"try_again":"{$_M[word][try_again]}"
},
anyid="{$_M[form][anyid]}",
own_form="{$_M[url][own_form]}",
own_name="{$_M[url][own_name]}",
tem="{$_M[url][own_tem]}",
adminurl="{$_M[url][adminurl]}",
renewable="{$_M[form][renewable]}",
apppath="{$_M[url][api]}",
jsrand="{$jsrand}"
;
</script>
<!--[if IE]><script src="{$_M[url][site]}public/js/html5.js" type="text/javascript"></script><![endif]-->
</head>
<body>
<input id="gz_automatic_upgrade" type="hidden" value="{$_M['config']['gz_automatic_upgrade']}" />
<div class="metcms_cont v52fmbx" id="metcmsbox" data-metcms_v="{$_M[config][metcms_v]}" data-patch="{$_M[config][gz_patch]}">
	<div class="metcms_cont_left hidden-xs" id="metcms_cont_leidden-xs">
		<div class="metlogo">
			<a href="{$_M[url][site_admin]}index.php?lang={$_M[lang]}" hidefocus="true">
				<img 
					src="{$gz_admin_logo}"
					alt="{$_M[word][metinfo]}"
					title="{$_M[word][metinfo]}" style="    padding: 10px 0px;"
				/>
			</a>
		</div>
		<dl class="jslist" id="zbllll-{$_M[word][id]}">
			<dt><a target="_blank" href="{$_M['config']['gz_weburl']}index.php?lang={$_M['lang']}" title="{$_M[word][indexhome]}"><i class="fa fa-home"></i>{$_M[word][indexhome]}</a></dt>
		</dl>
<!--
EOT;
$i=0;
?>
-->
<dl id="zbllll-2-1-1">
	<dt><i class="fa fa-align-justify" style="color: #4bce4b;"></i>&nbsp;&nbsp;栏目</dt>
	<dd>
	<a href="/admin/interface/flash/flash.php?anyid=18&lang=cn&cs=2" title="幻灯片图片"><i class="fa fa-bullhorn"></i>banner</a>
	<a href="/admin/column/index.php?anyid=25&lang=cn" title="栏目"><i class="fa fa-sitemap"></i>栏目管理</a>
	<a href="/admin/index.php?n=webset&c=webset&a=doindex&anyid=57&lang=cn" title="基本信息"><i class="fa fa-newspaper-o"></i>基本信息</a>
	<a href="http://newtest.test2.resonance.net.cn/resonancehelpview.php?n=comcnm" title="在线帮助"><i class="fa fa-book"></i>在线帮助</a>

	</dd>
</dl>


<dl id="zbllll-2-2">
	<dt><i class="fa fa-plus"></i>&nbsp;&nbsp;发布</dt>
	<dd>
		<a href="/admin/content/about/index.php?module=1&lang=cn&anyid=29" title="简介"><i class="fa fa-info"></i>简介</a>
		<a href="/admin/index.php?n=content&c=article_admin&a=doindex&module=2&lang=cn&anyid=29" title="文章"><i class="fa fa-pencil"></i>文章</a>
		<!-- <a href="/admin/index.php?n=content&c=product_admin&a=doindex&class1=3&lang=cn&anyid=29" title="产品"><i class="fa fa-cubes"></i>产品</a> -->
		<!-- <a href="/admin/content/download/index.php?class1=32&lang=cn&anyid=29" title="下载"><i class="fa fa-download"></i>下载</a> -->
		<!-- <a href="/admin/content/img/index.php?class1=33&lang=cn&anyid=29" title="案例"><i class="fa fa-camera"></i>案例</a> -->
		<!-- <a href="/admin/content/job/index.php?class1=36&lang=cn&anyid=29" title="招聘"><i class="fa fa-child"></i>招聘</a> -->
		<a href="/admin/seo/link/index.php?anyid=39&lang=cn" title="友情链接"><i class="fa fa-link"></i>友情链接</a>
		
		
	</dd>
</dl>

<dl id="zbllll-2-2111">
	<dt><i class="fa fa-check-square-o" style="color: green;"></i>&nbsp;&nbsp;留言</dt>
		<!-- <dd><a href="/admin/content/feedback/index.php?anyid=31&lang=cn&module=8&class1=31&cs=3" title="在线投诉"><i class="fa fa-child"></i>在线投诉</a>-->
	<dd><a href="/admin/content/message/index.php?anyid=31&lang=cn&module=8&class1=118&cs=3" title="留言管理"><i class="fa fa-child"></i>留言管理</a>	
	</dd>
</dl>

<dl id="zbllll-2-1">
	<dt><i class="fa fa-cube"></i>&nbsp;&nbsp;设置</dt>
	<dd>
		
		<!-- <a href="/admin/index.php?n=seo&c=seo&a=doindex&anyid=37&lang=cn" title="SEO"><i class="fa fa-paw"></i>SEO</a> -->
		
		<!-- <a href="/admin/system/img.php?anyid=11&lang=cn" title="缩略图/水印"><i class="fa fa-picture-o"></i>缩略图/水印</a>-->
		<a href="/admin/system/database/index.php?anyid=13&lang=cn" title="备份/恢复"><i class="fa fa-database"></i>备份/恢复</a>
		<a href="/admin/content/recycle/index.php?anyid=33&lang=cn" title="回收站"><i class="fa fa-trash-o"></i>回收站</a>
		<!-- <a href="/admin/app/batch/contentup.php?anyid=32" title="批量操作"><i class="fa fa-magic"></i>批量操作</a>-->
		
		<a href="/admin/app/stat/details.php?lang=cn&anyid=34&cs=1" title="访问明细"><i class="fa fa-line-chart"></i>访问明细</a>
	</dd>
</dl>

<dl id="zbllll-2-3">
	<dt><i class="fa fa-eye" style="color: #0082d6;"></i>&nbsp;&nbsp;用户</dt>
	<dd>
		<!-- <a href="/admin/index.php?n=user&c=admin_user&a=doindex&anyid=73&lang=cn" title="会员"><i class="fa fa-users"></i>会员</a>-->
		<a href="/admin/admin/index.php?anyid=47&lang=cn" title="管理员"><i class="fa fa-users"></i>管理员</a>
		<a href="/admin/app/stat/index.php?anyid=34&lang=cn" title="返回后台首页"><i class="fa fa-cogs"></i>后台首页</a>
	</dd>
</dl>
<!--
<?php
foreach($toparr as $key=>$val){
if($val['type']==1){
$cnm='';
$dt="{$val[name]}";
if($val[icon]!=''){
$cnm = 'class="jslist"';
$dt="{$val[icon]}{$val[name]}<i class=\"fa fa-angle-right\"></i>";
}
echo <<<EOT
-->
		<dl {$cnm} id="zbllll-{$val[id]}">
			<dt>{$dt}</dt>
			<dd>
<!--
EOT;
foreach($toparr as $key=>$val2){
if($val2['type']==2&&$val2['bigclass']==$val['id']){
$target = $val2[id]==70||$val2[id]==18?'target="_blank"':'';
echo <<<EOT
-->
					<a href="{$val2[url]}" {$val2[property]} title="{$val2[name]}" {$target} id="metinfo_metnav_{$val2[id]}">{$val2[icon]}{$val2[name]}</a>
<!--
EOT;
}}
echo <<<EOT
-->	
			</dd>
		</dl>
<!--
EOT;
$i++;
}}
echo <<<EOT
-->
	</div>
	<div class="metcms_cont_right">
		<div class="metcms_cont_right_box">
<!--
EOT;
$ifurl = "{$_M[url][own_form]}a=dohome";
echo <<<EOT
-->
			<iframe src="/admin/app/stat/index.php?anyid=34&lang=cn" frameborder="0"></iframe><!--后台默认首页 链接 <iframe src="{$ifurl}" frameborder="0"></iframe>-->
		</div>
	</div>
	<div class="clear"></div>
</div>
<script>
var indexbox = 1;
</script>
<script src="{$_M[url][pub]}js/sea.js?{$jsrand}"></script>
<style>.metcms_cont_left{overflow: auto;}</style>
</body>
</html>
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>-->