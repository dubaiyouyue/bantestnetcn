<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');
echo <<<EOT
-->
<div class="v52fmbx">
	<h3 class="v52fmbx_hr">{$_M['word']['inside_larger']}</h3>
	<dl>
		<dt>{$_M['word']['call_way']}</dt>
		<dd class="ftype_radio">
			<div class="fbox">
				<label><input name="gz_bannerpagetype" type="radio" value="1" data-checked="{$_M[config][gz_bannerpagetype]}">{$_M['word']['consistent_home_page']}</label>
				<label><input name="gz_bannerpagetype" type="radio" value="0">{$_M['word']['managertyp5']}</label>
			</div>
		</dd>
	</dl>
	<dl>
		<dd>
			<a href="{$_M[url][site_admin]}interface/flash/flash.php?anyid=18&lang={$_M[lang]}" target="_blank" class="ui-addlist" style="margin-left:70px;">更多自定义设置（原Banner设置）</a>
		</dd>
	</dl>
<!--
EOT;
require $this->template('tem/zujian');
echo <<<EOT
-->
	<h3 class="v52fmbx_hr">{$_M[word][unitytxt_42]}</h3>
	<dl>
		<dt>{$_M[word][mod3]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_product_list" value="{$_M[config][gz_product_list]}" style="width:40px;">
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod2]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_news_list" value="{$_M[config][gz_news_list]}" style="width:40px;">
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod4]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_download_list" value="{$_M[config][gz_download_list]}" style="width:40px;">
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod5]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_img_list" value="{$_M[config][gz_img_list]}" style="width:40px;">
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod6]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_job_list" value="{$_M[config][gz_job_list]}" style="width:40px;">
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod7]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_message_list" value="{$_M[config][gz_message_list]}" style="width:40px;">
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod11]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_search_list" value="{$_M[config][gz_search_list]}" style="width:40px;">
			</div>
		</dd>
	</dl>
	<h3 class="v52fmbx_hr">{$_M[word][unitytxt_76]}</h3>
	<dl>
		<dt>{$_M[word][mod3]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_productimg_x" value="{$_M[config][gz_productimg_x]}" style="width:40px;">
				×
				<input type="text" name="gz_productimg_y" value="{$_M[config][gz_productimg_y]}" style="width:40px;">
				<span class="tips">{$_M[word][setimgWidth]}×{$_M[word][setimgHeight]}({$_M[word][setimgPixel]})</span>
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod5]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_imgs_x" value="{$_M[config][gz_imgs_x]}" style="width:40px;">
				×
				<input type="text" name="gz_imgs_y" value="{$_M[config][gz_imgs_y]}" style="width:40px;">
				<span class="tips">
				{$_M[word][setimgWidth]}×{$_M[word][setimgHeight]}({$_M[word][setimgPixel]})
				</span>
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod2]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_newsimg_x" value="{$_M[config][gz_newsimg_x]}" style="width:40px;">
				×
				<input type="text" name="gz_newsimg_y" value="{$_M[config][gz_newsimg_y]}" style="width:40px;">
				<span class="tips">{$_M[word][setimgWidth]}×{$_M[word][setimgHeight]}({$_M[word][setimgPixel]})</span>
			</div>
		</dd>
	</dl>
	<h3 class="v52fmbx_hr">{$_M[word][unitytxt_43]}</h3>
	<dl>
		<dt>{$_M[word][mod3]}{$_M[word][setskinListPage]}</dt>
		<dd class="ftype_radio">
			<div class="fbox">
				<label><input name="gz_product_page" type="radio" value="0" data-checked="{$_M[config][gz_product_page]}">{$_M[word][setskinproduct1]}</label>
				<label><input name="gz_product_page" type="radio" value="1">{$_M[word][setskinproduct2]}</label>
			</div>
			<span class="tips">{$_M['word']['sys_navigation2']}</span>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][mod5]}{$_M[word][setskinListPage]}</dt>
		<dd class="ftype_radio">
			<div class="fbox">
				<label><input name="gz_img_page" type="radio" value="0" data-checked="{$_M[config][gz_img_page]}">{$_M[word][setskinproduct1]}</label>
				<label><input name="gz_img_page" type="radio" value="1">{$_M[word][setskinproduct2]}</label>
			</div>
			<span class="tips">{$_M['word']['sys_navigation2']}</span>
		</dd>
	</dl>
<!--
EOT;
$hrtitle = $_M[word][setskindatelist];
if(!$metinfover){
$hrtitle = $_M[word][unitytxt_46];
}
echo <<<EOT
-->
	<h3 class="v52fmbx_hr">{$hrtitle}</h3>
<!--
EOT;
if(!$metinfover){
echo <<<EOT
-->
	<dl>
		<dt>{$_M[word][setskinnews]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_newsdays" value="{$_M[config][gz_newsdays]}" style="width:50px;" />
				{$_M[word][setskinnews2]}
				<img src="{$_M[url][site]}templates/{$_M[form][gz_skin_user]}/images/news.gif" />
				<span class="tips">{$_M[word][setskinnews3]}</span>
			</div>
		</dd>
	</dl>
	<dl>
		<dt>{$_M[word][setskinhot]}</dt>
		<dd class="ftype_input">
			<div class="fbox">
				<input type="text" name="gz_hot" value="{$_M[config][gz_hot]}" style="width:50px;" />
				{$_M[word][setskinhot2]}
				<img src="{$_M[url][site]}templates/{$_M[form][gz_skin_user]}/images/hot.gif" />
				<span class="tips">{$_M[word][setskinhot3]}</span>
			</div>
		</dd>
	</dl>
<!--
EOT;
}
echo <<<EOT
-->
	<dl>
		<dt>{$_M[word][setskindatelist]}</dt>
		<dd class="ftype_select">
			<div class="fbox">
				<select name="gz_listtime" data-checked="{$_M[config][gz_listtime]}">
					{$selecthtml}
				</select>
			</div>
		</dd>
	</dl>
</div>
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>-->