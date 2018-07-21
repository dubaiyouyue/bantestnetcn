<!--<?php
$methtml_head  = metlabel_html5();//基于Html5
$topgu = $lang_mobiletopnavtype?'data-am-sticky':'';
echo <<<EOT
-->
{$methtml_head}
<body>
    <header {$topgu}>
		<section>
			<div class="tem_top">
<!--
EOT;
$h=$classnow==10001?'1':'2';
$navnow = $classnow==10001?'class="navdown"':'';
echo <<<EOT
-->
				<h{$h}>
					<a href="{$index_url}" title="{$gz_webname}">
						<img src="{$gz_logo}" alt="{$gz_webname}" title="{$gz_webname}" />
					</a>
				</h{$h}>
<!--
EOT;
if(count($gz_langok)>1){
echo <<<EOT
-->
				<i class="am-icon-globe"></i>
<!--
EOT;
}
echo <<<EOT
-->
				<i class="am-icon-bars"></i>
			</div>
		</section>
		<div class="tem_head">
			<div class="tem_langlist am-collapse">
				<ul>
						
<!--
EOT;
foreach($gz_langok as $val){
if($val[useok]){
$gz_now = $val[mark]==$lang?'class="gz_now"':'';
echo <<<EOT
-->
					<li><a href="{$val[gz_weburl]}" title="{$val[name]}" {$gz_now}>{$val[name]}</a></li>
<!--
EOT;
}
}
echo <<<EOT
-->
						
				</ul>
			</div>
			<nav class="am-collapse">
<ul>
	<li><a href="{$index_url}" title="{$lang_home}" {$navnow}>{$lang_home}</a></li>
<!--
EOT;
foreach($nav_list as $key=>$val){
$navnow = $val[id]==$navdown?'class="navdown"':'';
echo <<<EOT
-->
	<li>
		<a href="{$val[url]}" {$val[new_windows]} title="{$val[name]}" {$navnow}>{$val[name]}</a>
	</li>
<!--
EOT;
}
echo <<<EOT
-->
</ul>
			</nav>
		</div>
	</header>
	<div class="am-slider tem_banner">
<!--
EOT;
if($gz_flasharray[$classnow][type]==1&&$classnow==10001){
echo <<<EOT
-->
		<ul class="am-slides">
<!--
EOT;
foreach($gz_flashimg as $key=>$val){
$val[img_link] = $val[img_link]==''?"#":$val[img_link];
echo <<<EOT
-->
			<li>
				<a href="{$val[img_link]}" title="{$val[img_title]}"><img src="{$val[img_path]}" alt="{$val[img_title]}" /></a>
			</li>
<!--
EOT;
}
echo <<<EOT
-->
		</ul>
<!--
EOT;
}
echo <<<EOT
-->	
	</div>
<!--
EOT;
?>