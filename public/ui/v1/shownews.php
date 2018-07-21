<!--<?php
require_once template('head'); 
require_once template('sidebar');
$is_tv=$db->get_one("select * from gz_news where id=$id");
if($is_tv['class1']==117){
  $tvlianjie=$news['tvlinks'];
  $swwwww=preg_replace('/width:(\d+)px;/','width:700px;',$tvlianjie);
  $shhhhh=preg_replace('/height:(\d+)px;/','height:408px;',$swwwww);
  $swwwww=preg_replace('/width=(\d+)/','width=700',$tvlianjie);
  $shhhhh=preg_replace('/height=(\d+)/','height=408',$swwwww);
echo <<<EOT
-->
    <div class="xxnrbox1" >
      <div style="margin:auto;text-align:center;">
        {$shhhhh}
      </div>
   </div>
<!--
EOT;
}else{
  if($gz_webname){$fabuzhe='发布者：';}
  if($news['updatetime']){
     $news_timess=date("Y-m-d",strtotime($news['updatetime']));
  }
  
// <iframe src="http://www.tudou.com/programs/view/html5embed.action?type=1&code=jbA002V2_kg&lcode=LCfgBuCR0UU&resourceId=0_06_05_99" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0" style="width:480px;height:400px;"></iframe>
  echo <<<EOT
-->
<div class="xxnrbox1">
      <div class="bt">{$news[title]}</div>
      <div class="miaoshu">
        <span class="fbz" style="display:inline-block; padding-right:10px;">{$fabuzhe}{$gz_webname}</span>
        <span class="sj" style="display:inline-block;">时间：{$news_timess}</span>
      </div>
      <p>{$news[content]}</p>
      
      <div class="nrzy1">
        <!--上一篇、下一篇 start-->
        <div class="nrlf1 clearfix">
           <div class="shangyp"><a  href="{$preinfo[url]}">上一篇：{$preinfo[title]}</a></div>
           <div class="xiayp"><a href="{$nextinfo[url]}">下一篇：{$nextinfo[title]}</a></div>
        </div>
        <!--上一篇、下一篇 end-->
        <!--返回按钮-->
        <div class="nrrg1">
           <div class="fanhui"><a onclick="javascript:history.back(-1);" class="hvr-sweep-to-top">返回上一页</a></div>
        </div>
        <!---->
      </div>
   </div>
<!--
EOT;
}

require_once template('gap');
require_once template('foot'); 
?>