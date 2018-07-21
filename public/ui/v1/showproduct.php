<!--<?php
require_once template('head'); 
require_once template('sidebar');
$gz_productnext=methtml_prenextinfo(1);
echo <<<EOT
-->
        <div id="showproduct">
            <dl class='pshow'>
                <dt data-product_x="{$gz_productdetail_x}">
					<div class="gz_box">
						<div class="gz_imgshowbox">
							<div class="my-simple-gallery slides">
							<figure>
							  <a href="{$product[imgurl]}">
								  <img src="{$thumb_src}dir={$product[imgurl]}&x={$gz_productdetail_x}&y={$gz_productdetail_y}" alt="{$product[title]}" width="{$gz_productdetail_x}" height="{$gz_productdetail_y}" />
							  </a>
							  <figcaption>{$product[title]}</figcaption>
							</figure>
<!--
EOT;
if(count($displaylist)>0){
$dlist = "<li><img src=\"{$thumb_src}dir={$product[imgurl]}&x=70&y=70\" alt=\"{$product[title]}\" /></li>";
foreach($displaylist as $key=>$val){
$dlist.= "<li><img src=\"{$thumb_src}dir={$val[imgurl]}&x=70&y=70\" alt=\"{$val[title]}\" /></li>";
echo <<<EOT
-->
							<figure>
							    <a href="{$val[imgurl]}">
									<img src="{$thumb_src}dir={$val[imgurl]}&x={$gz_productdetail_x}&y={$gz_productdetail_y}" alt="{$val[title]}" width="{$gz_productdetail_x}" height="{$gz_productdetail_y}" />
							    </a>
							  <figcaption>{$val[title]}</figcaption>
							</figure>
<!--
EOT;
}
}
echo <<<EOT
-->
							</div>
						</div>
						<ol>{$dlist}</ol>
					</div>
				</dt>
		        <dd>
					<div class="gz_box">
					<h1 class='gz_title'>{$product[title]}</h1>
		            <ul>
<!--
EOT;
foreach($product_paralist as $key=>$val){
echo <<<EOT
-->
                        <li><span>{$val[name]}</span>{$product[$val[para]]}</li>
<!--
EOT;
}
$product[descriptionhtml] = $product[description]?"<p class=\"desc\">{$product[description]}</p>":'';
echo <<<EOT
-->
			        </ul>
					{$product[descriptionhtml]}
					</div>
		        </dd>
	        </dl>
			<div class="gz_clear"></div>
<!--
EOT;
$productTablist[0]['title'] = $gz_productTabname;
$productTablist[0]['content'] = $product[content];
for($i=1;$i<=($gz_productTabok-1);$i++){
	$gz_productTabname = 'gz_productTabname_'.$i;
	$productTablist[$i]['title']   = $$gz_productTabname;
	$productTablist[$i]['content'] = $product['content'.$i];
}
echo <<<EOT
-->
			<ol class="gz_nav">
<!--
EOT;
$i=0;
foreach($productTablist as $key=>$val){
$i++;
$gz_now = $i==1?'class="gz_now"':'';
echo <<<EOT
-->
				<li {$gz_now}><a href="#mettab{$i}">{$val['title']}</a></li>
<!--
EOT;
}
echo <<<EOT
-->
			</ol>
			<div class="gz_nav_contbox">
<!--
EOT;
$i=0;
foreach($productTablist as $key=>$val){
$i++;
$gz_none = $i==1?'':'gz_none';
echo <<<EOT
-->
				<div class="gz_editor {$gz_none}">{$val[content]}<div class="gz_clear"></div></div>
<!--
EOT;
}
echo <<<EOT
-->
			</div>
			<div class="gz_tools">
				{$gz_tools_code}
				<span class="gz_Clicks gz_none"><!--累计浏览次数--></span>
				<ul class="gz_page">
					<li class="gz_page_preinfo"><span>{$lang_Previous}</span><a href='{$preinfo[url]}'>{$preinfo[title]}</a></li>
					<li class="gz_page_next"><span>{$lang_Next}</span><a href='{$nextinfo[url]}'>{$nextinfo[title]}</a></li>
				</ul>
			</div>
<!--
EOT;
if(count($product_list)>1){
echo <<<EOT
-->
			<h3 class="gz_related">{$lang_product_related_title}</h3>
			<ul class="gz_related_list">
<!--
EOT;
$i=0;
foreach($product_list as $key=>$val){
if($val[id]!=$product[id]){
$i++;
echo <<<EOT
-->
				<li>
					<a href="{$val[url]}" title="{$val[title]}" {$metblank}>
						<img src="{$thumb_src}dir={$val[imgurl]}&x={$gz_productimg_x}&y={$gz_productimg_y}"
							width ="{$gz_productimg_x}" height="{$gz_productimg_y}"
						/>
						<h2>{$val['title']}</h2>
					</a>
				</li>
<!--
EOT;
if($i>=$lang_product_related_num)break;
}}
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
require_once template('gap');
require_once template('foot'); 
?>