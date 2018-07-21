<!--<?php
require_once template('head'); 
require_once template('sidebar');
if($class_list[$classnow]['id']==117&&$class_list[$classnow]['name']='视频点播'){
$cctv_list=$db->get_all("select * from gz_news where class1=117 ORDER by id desc LIMIT 15");

 echo <<<EOT
-->
<div class="xxnrbox7" style="margin-bottom:20px;">
         <ul class="sptplb clearfix">
           
<!--
EOT;
foreach($cctv_list as $k=>$v){
  if($k<4){
echo <<<EOT
-->         
            <li>
               <a href="shownews.php?lang=cn&id={$v[id]}"><div class="tp1"><img src="{$v[imgurls]}" width="213" height="142"></div>
               <div class="spbtn"><img src="/images/bfbtn.png" width="56" height="56"></div></a>
               <div class="wzbt"><a href="shownews.php?lang=cn&id={$v[id]}">{$v[title]}</a></div>
            </li>
<!--
EOT;
}
}
echo <<<EOT
-->  
         </ul>
      </div>
    
      <div class="xxnrbox7" style="margin-bottom:20px;">
         <ul class="sptplb clearfix">
           <!--
EOT;
foreach($cctv_list as $k=>$v){
  if($k>3&&$k<8){
echo <<<EOT
-->         
            <li>
               <a href="shownews.php?lang=cn&id={$v[id]}"><div class="tp1"><img src="{$v[imgurls]}" width="213" height="142"></div>
               <div class="spbtn"><img src="/images/bfbtn.png" width="56" height="56"></div></a>
               <div class="wzbt"><a href="shownews.php?lang=cn&id={$v[id]}">{$v[title]}</a></div>
            </li>
<!--
EOT;
}
}
echo <<<EOT
-->  
         </ul>
      </div>
 
      <div class="xxnrbox7" style="margin-bottom:0px;">
         <ul class="sptplb clearfix">
            <!--
EOT;
foreach($cctv_list as $k=>$v){
  if($k>7&&$k<12){
echo <<<EOT
-->         
            <li>
               <a href="shownews.php?lang=cn&id={$v[id]}"><div class="tp1"><img src="{$v[imgurls]}" width="213" height="142"></div>
               <div class="spbtn"><img src="../images/bfbtn.png" width="56" height="56"></div></a>
               <div class="wzbt"><a href="#">{$v[title]}</a></div>
            </li>
<!--
EOT;
}
}
echo <<<EOT
-->  
         </ul>
      </div>
        <!--翻页start-->
        <div class="yema">
           {$page_list}
        </div>
        <!--翻页end-->
<!--
EOT;
}else{
if(!$listsv){
echo <<<EOT
-->
 <div class="xxnrbox4">
        <ul class="zy1 clearfix">
<!--
EOT;

foreach($news_list as $k=>$v){
echo <<<EOT
-->
           <li class="clearfix">
              <div class="bt"><a href="{$v[url]}">{$v[title]}</a></div>
              <div class="sj">{$v[updatetime]}</div>
           </li>
<!--
EOT;
}
echo <<<EOT
-->
        </ul>
        
        <!--翻页start-->
        <div class="yema">
          {$page_list}
        <!--翻页end-->
      </div>
       </div>
<!--
EOT;
}else{
$queryn="select * from gz_news where class3=112 ORDER by id desc LIMIT 7";
$get_gn=$db->get_all($queryn); //国内
$queryw="select * from gz_news where class3=113 ORDER by id desc LIMIT 7";
$get_gw=$db->get_all($queryw); //国外
echo <<<EOT
-->
  <div class="xxnrbox2">
     <section>
            <div class="xxkhezi">
              <div class="row">
                <div class="twelve columns">
                  <article>
                    <div class='tabs tabs_default'>
                      <ul class='horizontal clearfix'>
<!--
EOT;
foreach($listsv as $kvv=>$vv){
  $kvv=$kvv+1;
  if($vv['id']==$class3){
    $therecs="class='active'";
  }
  
echo <<<EOT
-->
                        <li {$therecs}><a  href="#tab-{$kvv}">{$vv[name]}</a></li>
<!--
EOT;
}
//href='../news/news.php?lang=cn&class3=113'
echo <<<EOT
-->
                      </ul>
 <div id='tab-1'>
                        <ul class="zy1 clearfix">
<!--
EOT;
foreach($get_gn as $kgn=>$vgn){
  $vgn['updatetime']=date("Y-m-d",strtotime($vgn['updatetime']));
  $vgn['url']="shownews.php?lang=cn&id=$vgn[id]";
echo <<<EOT
-->     
                           <li class="clearfix">
                              <div class="bt"><a href="{$vgn[url]}">{$vgn[title]}</a></div>
                              <div class="sj">{$vgn[updatetime]}</div>
                           </li>
<!--
EOT;
} 
echo <<<EOT
-->                          
                        </ul>
                        
                        <!--翻页start-->
                        
                          {$page_list}
                        
                        <!--翻页end-->
                      </div>
                      
                      <div id='tab-2'>
                        <ul class="zy1 clearfix">
<!--
EOT;
foreach($get_gw as $kgw=>$vgw){
  $vgw['updatetime']=date("Y-m-d",strtotime($vgw['updatetime']));
  $vgw['url']="shownews.php?lang=cn&id=$vgw[id]";
echo <<<EOT
-->     
                           <li class="clearfix">
                              <div class="bt"><a href="{$vgw[url]}">{$vgw[title]}</a></div>
                              <div class="sj">{$vgw[updatetime]}</div>
                           </li>
<!--
EOT;
}  
echo <<<EOT
-->  
                        </ul>
                        <!--翻页start-->
                        <div class="yema">
                           {$page_list}
                        </div>
                        <!--翻页end-->
                      </div>
                      
                    </div>
                  </article>
                </div>
              </div>
             </div>
           </section>
          <!-- JS -->
          <script type="text/javascript" src="../js/jquery.tabslet.min.js"></script>
          <script type="text/javascript" src="../js/rainbow-custom.min.js"></script>
          <script type="text/javascript" src="../js/jquery.anchor.js"></script>
          <script src="../js/initializers.js"></script>
          <!-- JS ends -->
          <!--国内外动态内容列表选项卡end-->
      </div>
<!--
EOT;
}
}
require_once template('gap');
require_once template('foot'); 
?>