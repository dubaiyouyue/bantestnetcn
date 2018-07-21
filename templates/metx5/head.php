<!--<?php
$methtml_head  = metlabel_html5();//基于Html5
$topnav        = metlable_lang('<li class="line">|</li>',1,0);//右上角功能导航（间隔代码,文字链接或图标链接,是否获取语言列表）

echo <<<EOT
-->
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>{$gz_title}</title>
<!--css start-->
<link rel="stylesheet" href="/css/style.css" />
<!--css end-->

<!--js start-->
<script src="/js/jquery-1.7.2.min.js"></script>
<script src="/js/jquery.movebg.js"></script>
<!--轮播图2 js-->
<script src="/js/jquery.luara.0.0.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.event.drag-1.5.min.js"></script>
<script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
<!--轮播图2 js-->
<!--js end-->
</head>
<!--
EOT;

echo <<<EOT
-->
<body>
<!----topbox start---->
<div class="topbox">
  <div class="top clearfix">
    <div class="lfwz">{$gz_headeryj}</div>
    <div class="rgwz"><a href="javascript:AddFavorite('{$index_url}', '{$gz_title}')">收藏本站</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{$index_url}">返回首页</a></div>
  </div>
</div>
<!----topbox end---->

<!---------------------------------header开始--------------------------------->
<!--
EOT;
$navnow = $classnow==10001?'class="cur"':'';
if($gz_footteldianhua2&&$gz_footteldianhua){
  $imgs="<img src='/images/shuxian2.jpg' width='1' height='18'>";
}
echo <<<EOT
-->
<div class="header">
   <div class="logobox clearfix">
      <div class="logo"><a href="/"><img src="{$gz_logo}" width="668" height="79"></a></div>
<!--
EOT;
if($gz_footteldianhua||$gz_footteldianhua2){

echo <<<EOT
-->
      <div class="rexian"><span class="zxrxlf">咨询热线：</span><span class="dhszrg">{$gz_footteldianhua}&nbsp;{$imgs}&nbsp;{$gz_footteldianhua2}</span></div>
<!--
EOT;
}
echo <<<EOT
-->
   </div>
   <div class="navigation">
      <div class="nav">
        <ul>
            <li $navnow><a href="{$index_url}" >{$lang_home} Home</a></li>
<!--
EOT;
$count=count($nav_list);
foreach($nav_list as $key=>$val){
  $navnow = $val[id]==$navdown?'class="cur"':'';
	if($key+1 == $count){
        $css_style="style='background:none;'";
    }
echo <<<EOT
-->
            <li $css_style $navnow><a href="{$val[url]}">{$val[name]} {$val[enname]}</a></li>
          
<!--
EOT;
}
echo <<<EOT
-->
        </ul> 
        <!--移动的滑动-->
       <div class="move-bg"></div>
        <!--移动的滑动 end-->
      </div>
   </div>
</div>
<script>
$(function(){
	$(".nav").movebg({width:200/*滑块的大小*/,extra:40/*额外反弹的距离*/,speed:300/*滑块移动的速度*/,rebound_speed:400/*滑块反弹的速度*/});
})
</script>
<script> 
function AddFavorite(sURL, sTitle)
{
    try
    {
        window.external.addFavorite(sURL, sTitle);
    }
    catch (e)
    {
        try
        {
            window.sidebar.addPanel(sTitle, sURL, "");
        }
        catch (e)
        {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}
</script>
<!---------------------------------header结束--------------------------------->
<!--
EOT;
?>