<!--<?php
$sidebar=metlabel_sidebar(0);//内页侧栏标签
$sidebar_title=metlabel_sidebar(1);//内页侧栏标题
//侧栏显示条件：存在子栏目||文章详情页&&不是产品详情页
$asideok = ($sidebar||($class_list[$classnow][module]==2&&$id))&&!($class_list[$classnow][module]==3&&$id)?1:0;
$section = $asideok?'':'gz_section_asidenone';
$sehed   = $id&&$class_list[$classnow][module]!=1?'gz_section_sehed':'';
echo <<<EOT
-->
<section class="gz_section {$section} {$sehed}">
<!--
EOT;
if($id&&$class_list[$classnow][module]!=1){
echo <<<EOT
-->
		<section class="gz_section_head">
			<a href="{$index_url}" title="{$lang_home}">{$lang_home}</a> &gt; {$nav_x[name]}
		</section>
<!--
EOT;
}
echo <<<EOT
-->
<!--
EOT;
if($asideok){
echo <<<EOT
-->
    <aside>
<!--
EOT;
if($sidebar){
echo <<<EOT
-->
		<section class="gz_aside">
			<h2>{$sidebar_title}</h2>
			<div class="gz_aside_list">
				{$sidebar}
				<div class="gz_clear"></div>
			</div>
		</section>
<!--
EOT;
}
echo <<<EOT
-->
<!--
EOT;
if($class_list[$classnow][module]==2&&$id){
echo <<<EOT
-->
		<section class="gz_related">
			<h2>{$lang_gz_module2_related}</h2>
			<ul>
<!--
EOT;
$i=0;
foreach($news_list as $key=>$val){
if($val[id]!=$news[id]){
$i++;
echo <<<EOT
-->
				<li><a href="{$val[url]}" title="{$val[title]}">{$i}. {$val[title]}</a></li>
<!--
EOT;
if($i>=$lang_gz_module2_relatednum)break;
}
}
echo <<<EOT
-->
			</ul>
		</section>
<!--
EOT;
}
echo <<<EOT
-->
    </aside>
<!--
EOT;
}
echo <<<EOT
-->
    <article>
		<div class="gz_article">
<!--
EOT;
if(!$id||$class_list[$classnow][module]==1){
echo <<<EOT
-->
		<section class="gz_article_head">
			<h1>{$class_list[$classnow][name]}</h1>
			<div class="gz_position">
				<a href="{$index_url}" title="{$lang_home}">{$lang_home}</a> &gt; {$nav_x[name]}
			</div>
		</section>
<!--
EOT;
}
echo <<<EOT
-->
		<div class="gz_clear"></div>
<!--
EOT;
?>