<!--<?php
$tzgg_name=$db->get_one("select * from gz_column where id=126"); // 通知公告
$gzdt_name=$db->get_one("select * from gz_column where id=116"); // 工作动态
$ktzgg=list_order($tzgg_name['list_order']);
$kgzdt=list_order($gzdt_name['list_order']);
$tzgg_list=$db->get_all("select * from gz_news where class2 =$tzgg_name[id] $ktzgg LIMIT 7");
$gzdt_list=$db->get_all("select * from gz_news where class2 =$gzdt_name[id] $kgzdt LIMIT 7");
// banner
$all_img=$db->get_all("select * from gz_flash");
foreach($all_img as $ki=>$vi){
  if(strstr($vi['module'],$gzdt_name['id'])){
    $gzdt_img[]=$vi;
  }

}
echo <<<EOT
-->

<!---------------------------------box1 开始--------------------------------->
<div class="box1 clearfix">
   <div class="lfhezi">
      <div class="btbox">
         <span class="tzggbt">{$tzgg_name[name]}</span>
         <span class="gengduo"><a href="/news/news.php?lang=cn&class2={$tzgg_name[id]}">更多</a></span>
      </div>
      
      <div class="nrhezi">
        <div class="gonggao1">
           <ul class="list clearfix">
<!--
EOT;
foreach($tzgg_list as $ktz=>$vtz){
$vtz['updatetime']=date("Y-m-d",strtotime($vtz['updatetime']));
echo <<<EOT
-->
              <li class="clearfix">
                  <div class="bt"><a href="/news/shownews.php?lang=cn&id={$vtz[id]}">{$vtz[title]}</a></div>
                  <div class="sj">{$vtz[updatetime]}</div>
              </li>
<!--
EOT;

}
echo <<<EOT
--> 
           </ul>
        </div>
      </div>
   </div>
   <div class="rghezi">
<script src="js/jquery.Slide.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$("#taobaoSlide").KinSlideshow({
			moveStyle:"down",
			intervalTime:8,
			mouseEvent:"mouseover",
			titleFont:{TitleFont_size:14,TitleFont_color:"#ffffff"}
	});
})
</script>
      <!--工作动态图片 start-->
      <div class="gztplf">
        <div id="taobaoSlide" style="visibility:hidden;">
<!--
EOT;
foreach($gzdt_img as $km=>$vm){
echo <<<EOT
-->        
            <a href="$vm[img_link]"><img src="{$vm[img_path]}" alt="{$vm[img_title]}" width="382" height="338" /></a>
<!--
EOT;
}
echo <<<EOT
--> 
        </div>
      </div>
      <!--工作动态图片 end-->
      
      <!--工作动态 start-->
      <div class="gzdtrg">
         <div class="btbox">
            <span class="gzdtbt">{$gzdt_name[name]}</span>
            <span class="gengduo"><a href="/information/news.php?lang=cn&class2={$gzdt_name[id]}">更多</a></span>
         </div>
         
         <div class="nrhezi">
            <div class="gongzuo1">
               <ul class="list clearfix">
<!--
EOT;
foreach($gzdt_list as $kdt=>$vdt){
$vdt['updatetime']=date("Y-m-d",strtotime($vdt['updatetime']));
echo <<<EOT
-->
              <li class="clearfix">
                  <div class="bt"><a href="information/shownews.php?lang=cn&id={$vdt[id]}">{$vdt[title]}</a></div>
                  <div class="sj">{$vdt[updatetime]}</div>
              </li>
<!--
EOT;

}
echo <<<EOT
--> 
               </ul>
           </div>
        </div>
      </div>
      <!--工作动态 end-->
   </div>
</div>
<!---------------------------------box1 结束--------------------------------->
<!--
EOT;

?>