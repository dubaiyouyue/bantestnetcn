<!--<?php
require_once template('head');
echo <<<EOT
-->
<script type="text/javascript">
var dragBln ='';
$(document).ready(function () {
	$(".main_visual").hover(function(){
		$("#btn_prev,#btn_next").fadeIn()
		},function(){
		$("#btn_prev,#btn_next").fadeIn()
		})
	 dragBln = false;
	$(".main_image").touchSlider({
		flexible : true,
		speed : 200,
		btn_prev : $("#btn_prev"),
		btn_next : $("#btn_next"),
		paging : $(".flicking_con a"),
		counter : function (e) {
			$(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
		}
	});
	$(".main_image").bind("mousedown", function() {
	 	dragBln = false;
	})
	$(".main_image").bind("dragstart", function() {
	 	dragBln = true;
	})
	$(".main_image a").click(function() {
		if(dragBln) {
			return false;
		}
	})
	timer = setInterval(function() { $("#btn_next").click();}, 5000);
	$(".main_visual").hover(function() {
		clearInterval(timer);
	}, function() {
		timer = setInterval(function() { $("#btn_next").click();}, 5000);
	})
	$(".main_image").bind("touchstart", function() {
		clearInterval(timer);
	}).bind("touchend", function() {
		timer = setInterval(function() { $("#btn_next").click();}, 5000);
	})
});
</script>
<!-- 轮播图end -->
<div class="main_visual">
  <div class="main_image">
	<ul>	
<!--
EOT;
foreach($gz_flashimg as $ke=>$v){
	$ke=$ke+1;
echo <<<EOT
-->				
	  <li><span class="img_{$ke}" style="background: url({$v[img_path]}) center top no-repeat;"></span></li>
<!--
EOT;
}
echo <<<EOT
-->	
	</ul>
	<a href="javascript:;" id="btn_prev"></a>
	<a href="javascript:;" id="btn_next"></a>
  </div>
     <div class="flicking_con">
       <div class="flicking_inner">
<!--
EOT;
foreach($gz_flashimg as $ke=>$v){

echo <<<EOT
-->       
           <a href="#"></a>
<!--
EOT;
}
echo <<<EOT
--> 
        </div>
  </div>
</div>
<!---------------------------------main_visual 结束--------------------------------->
<!--
EOT;
echo <<<EOT
-->
<!--
EOT;
$w = 0;
if($lang_about_open){
$w++;
require_once template('index/above');
}
if($lang_product_open){
$w++;
$into = $w%2==0?'tem_index_to':'';
require_once template('index/middle');
}
if($lang_news_open){
$w++;
$into = $w%2==0?'tem_index_to':'';
require_once template('index/news');
}
if($lang_footer_open){
require_once template('index/footer');
}
echo <<<EOT
-->
<!--
EOT;
require_once template('gap');
require_once template('foot');
?>