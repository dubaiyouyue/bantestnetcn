<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

require $this->template('ui/head');
echo <<<EOT
-->
<form method="POST" class="ui-from" name="myform" action="{$_M[url][own_form]}a=dotpeditor" target="_self">
<div class="v52fmbx">
	<dl>
		<dd class="ftype_description">
		{$_M[word][unitytxt_36]}
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][setheadstat]}</dt>
		<dd class="ftype_textarea">
			<div class="fbox">
				<textarea name="gz_headstat" style="width:80%;">{$_M[config][gz_headstat]}</textarea>
			</div>
			<span class="tips">{$_M[word][unitytxt_37]}</span>
			
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][setfootstat]}</dt>
		<dd class="ftype_textarea">
			<div class="fbox">
				<textarea name="gz_footstat" style="width:80%;">{$_M[config][gz_footstat]}</textarea><br />
				腾讯微博：<input name="lang_weibo_tqq_new" value="{$_M[config][lang_weibo_tqq_new]}" /><br />
				新浪微博：<input name="weibo_sina_metinfo_new" value="{$_M[config][weibo_sina_metinfo_new]}" /><br />
				QQ：<input name="lang_weibo_qq_new" value="{$_M[config][lang_weibo_qq_new]}" /><br />
				
				
				
				<!--第三方代码前台自定义字段-->
			</div>
			<span class="tips">{$_M[word][unitytxt_38]}</span>
			
		</dd>
	</dl>
	<dl class="noborder">
		<dt> </dt>
		<dd>
			<input type="submit" name="submit" value="{$_M['word']['Submit']}" class="submit">
		</dd>
	</dl>
</div>
</form>
<!--
EOT;
require $this->template('ui/foot');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>