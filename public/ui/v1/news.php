<!--<?php
require_once template('head'); 
require_once template('sidebar');

if($class_list[$classnow]['id']==117&&$class_list[$classnow]['name']='视频点播'){
 echo <<<EOT
-->
<div class="xxnrbox7" style="margin-bottom:20px;">
         <ul class="sptplb clearfix">
           
<!--
EOT;
foreach($news_list as $k=>$v){
  if($k<4){
    if($k==3){$ksscss="style='margin-right:0px;'";}
echo <<<EOT
-->         
            <li {$ksscss}>
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
foreach($news_list as $k=>$v){
  if($k>3&&$k<8){
      if($k==7){$ksscss="style='margin-right:0px;'";}
echo <<<EOT
-->         
            <li {$ksscss}>
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
foreach($news_list as $k=>$v){
  if($k>7&&$k<12){
    if($k==11){$ksscss="style='margin-right:0px;'";}
echo <<<EOT
-->         
            <li {$ksscss}>
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
        <!--翻页start-->
      
           {$page_list}
       
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
       
          {$page_list}
        <!--翻页end-->
     
       </div>
<!--
EOT;
}else{
$get_onen=$db->get_one("select * from gz_column where id=112"); //国内标题
$get_onew=$db->get_one("select * from gz_column where id=113"); //国内标题
$get_gnn=$db->get_all("select * from gz_news where class3=112"); //国内
$get_gww=$db->get_all("select * from gz_news where class3=113"); //国外
//p 当前页码，num 显示条数,numbers，sum 总记录数， 固定页码数,url 跳转路径,
$p=$_GET['page'];
$sumn=count($get_gnn);
$sumw=count($get_gww);
//显示条数  数据库
if($get_onen['listnumber']>0){
  $numbersn=$get_onen['listnumber'];
}else{
   $numbersn=8;
}
if($get_onew['listnumber']>0){
    $numbersw=$get_onew['listnumber'];
}else{
    $numbersw=8;
}
$kgnn=list_order($get_onen['list_order']); //排序方式
$kgww=list_order($get_onew['list_order']);
$pagn=paging($p,$numbersn,5,$sumn,'news.php?lang=cn&class1=2&class2=4&class3=112');
$pagw=paging($p,$numbersw,5,$sumw,'news.php?lang=cn&class1=2&class2=4&class3=113');
$get_gn=$db->get_all("select * from gz_news where class3=112 $kgnn LIMIT $pagn[limit]"); //国内
$get_gw=$db->get_all("select * from gz_news where class3=113 $kgww LIMIT $pagw[limit]"); //国外
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
                        <div class="yema">
                          {$pagn[number]}
                        </div>
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
                          {$pagw[number]}
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
          <script type="text/javascript" src="/js/jquery.tabslet.min.js"></script>
          <script type="text/javascript" src="/js/rainbow-custom.min.js"></script>
          <script type="text/javascript" src="/js/jquery.anchor.js"></script>
          <script src="/js/initializers.js"></script>
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