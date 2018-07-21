<!--<?php
require_once template('head'); 
require_once template('sidebar');
if($job[useful_life_a]==0)$lang_Job2='';
echo <<<EOT
-->
        <div id="showjob">
            <h1 class="title">{$job[position]}</h1>
			<ul class="paralist">
				<li><span>{$lang_PersonNumber}</span>{$job[count]}</li>
				<li><span>{$lang_WorkPlace}</span>{$job[place]}</li>
				<li><span>{$lang_Deal}</span>{$job[deal]}</li>
				<li><span>{$lang_AddDate}</span>{$job[addtime]}</li>
				<li><span>{$lang_Validity}</span>{$job[useful_life]} {$lang_Job2}</li>
			</ul>
<!--
EOT;
if($job[content]!=''){
echo <<<EOT
-->
			<h3 class="ctitle"><span>{$lang_JobDescription}</span></h3>
<!--
EOT;
}
echo <<<EOT
-->
            <div class="gz_editor">{$job[content]}<div class="gz_clear"></div></div>
			<div class="info_cv"><a href="{$job[cv]}" {$metblank} title="$lang_cvtitle" class="button orange">{$lang_cvtitle}</a></div>
			<div class="gz_tools">
				{$gz_tools_code}
				<span class="gz_Clicks gz_none"><!--累计浏览次数--></span>
				<ul class="gz_page">
					<li class="gz_page_preinfo"><span>{$lang_Previous}</span><a href='{$preinfo[url]}'>{$preinfo[title]}</a></li>
					<li class="gz_page_next"><span>{$lang_Next}</span><a href='{$nextinfo[url]}'>{$nextinfo[title]}</a></li>
				</ul>
			</div>
        </div>
<!--
EOT;
require_once template('gap');
require_once template('foot'); 
?>