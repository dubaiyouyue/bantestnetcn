<!--<?php
/*四个文章列表*/
$gnw_name=$db->get_all("select * from gz_column where bigclass=4 LIMIT 2"); //国内外标题
$nid=$gnw_name[0]['id'];
$wid=$gnw_name[1]['id'];
$kgnnnn=list_order($gnw_name[0]['list_order']);
$kgwwww=list_order($gnw_name[0]['list_order']);
$queryn="select * from gz_news where class3=$nid $kgnnnn LIMIT 7";
$app_gn=$db->get_all($queryn); //国内
$queryw="select * from gz_news where class3=$wid $kgnnnn LIMIT 7";
$app_gw=$db->get_all($queryw); //国外
$cqdt=$db->get_one("select * from gz_column where id=114"); //城区动态
$cqdt_id=$cqdt['id'];
$kgcqdt=list_order($cqdt['list_order']);
$cqdt_list=$db->get_all("select * from gz_news where class2=$cqdt_id $kgcqdt LIMIT 15");
// banner
$all_img=$db->get_all("select * from gz_flash");
foreach($all_img as $ki=>$vi){
  if(strstr($vi['module'],$nid)){
    $gn_img[]=$vi;
  }
  if(strstr($vi['module'],$wid)){
    $gw_img[]=$vi;
  }
  
}

if($lang_news_list1_open){
$tem_news[1]           = tmpcentarr($lang_news_list1_id);

$tem_news[1]['list']   = methtml_getarray($lang_news_list1_id,$lang_news_list1_type,'','',$lang_news_num);
}
if($lang_news_list2_open){
$tem_news[2]           = tmpcentarr($lang_news_list2_id);

$tem_news[2]['list']   = methtml_getarray($lang_news_list2_id,$lang_news_list2_type,'','',7);
}
if($lang_news_list3_open){
$tem_news[3]           = tmpcentarr($lang_news_list3_id);

$tem_news[3]['list']   = methtml_getarray($lang_news_list3_id,$lang_news_list3_type,'','',$lang_news_num);
}
if($lang_news_list4_open){
$tem_news[4]           = tmpcentarr($lang_news_list4_id);
$tem_news[4]['list']   = methtml_getarray($lang_news_list4_id,$lang_news_list4_type,'','',$lang_news_num);
}


echo <<<EOT
--> 
<!---------------------------------box3 开始--------------------------------->
<div class="box3 clearfix">
   <div class="gxdtbox">
      <div class="btbox">
         <span class="gxdtbt">{$tem_news[2]['name']}</span>
         <span class="gengduo"><a href="{$tem_news[2]['url']}">更多</a></span>
      </div>
      
      <div class="gxnrbox">
        <div class="gxidt1">
           <ul class="list clearfix">
<!--
EOT;
$counts=count($tem_news[2]['list'])-1;
foreach($tem_news[2]['list'] as $key=>$val){
if($key==$counts){$sty="style=margin-bottom:0px;";}
echo <<<EOT
-->
              <li class="clearfix" {$sty}>
                  <div class="bt"><a href="{$val[url]}">{$val[title]}</a></div>
                  <div class="sj">{$val[updatetime]}</div>
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


   <!--gnwdtbox 开始-->
   <div class="gnwdtbox">
        <!--i_zxmelc 开始-->
        <div class="i_zxmelc">
            <div class="i_zxmelc1">
                <ul>
                    <li id="two1" onMouseOver="setContentTab('two',1,9)" class="hover"><a href="news/news.php?lang=cn&class3={$gnw_name[0][id]}">{$gnw_name[0][name]}</a></li>
                    <li id="two2" onMouseOver="setContentTab('two',2,9)"><a href="news/news.php?lang=cn&class3={$gnw_name[1][id]}">{$gnw_name[1][name]}</a></li>
                </ul>
            </div>
            <!--i_zxmelc1-->
        
            <div class="i_zxmelc3">
                <!--选项卡-国内动态 start-->
                <div id="con_two_1" style="display:block;">
                    <div class="i_zxmelc3d clearfix">
                       <div class="lfimg">
                          <!--轮播图1 start-->
                          <div class="slider">
                            <ul>
<!--
EOT;
foreach($gn_img as $key=>$val){
echo <<<EOT
-->
                              <li><a href="$val[img_link]"><img src="{$val[img_path]}" alt=""></a></li>
<!--
EOT;
}
echo <<<EOT
-->
                            </ul>
                          </div>
                          <!--轮播图1 end-->
                          <script type="text/javascript" src="js/yxMobileSlider.js"></script>
                          <script>
                             $(".slider").yxMobileSlider({width:300,height:296,during:3000})
                          </script>
                       </div>
                       
                       <div class="rglist clearfix">
                          <ul>
<!--
EOT;
foreach($app_gn as $kn=>$vn){
  $vn['updatetime']=date("Y-m-d",strtotime($vn['updatetime']));
echo <<<EOT
-->
                             <li class="clearfix">
                                <div class="bt"><a href="news/shownews.php?lang=cn&id={$vn[id]}">{$vn[title]}</a></div>
                                <div class="sj">{$vn[updatetime]}</div>
                             </li>
<!--
EOT;
}
echo <<<EOT
-->
                          </ul>
                       </div>
                    </div> 
                    <!--i_zxmelc3d-->
                </div>
                <!--选项卡-国内动态 end-->
                
                <!--选项卡-国外动态 start-->
                <div id="con_two_2" style="display: none;">
                    <div class="i_zxmelc3d clearfix">
                       <div class="lfimg2">
                          <!--轮播图2 start-->
                          <div class="example2">
                              <ul>
<!--
EOT;
foreach($gw_img as $key=>$val){
echo <<<EOT
-->
                                  <li><a href="$val[img_link]"><img src="{$val[img_path]}" alt=""/></a></li>
<!--
EOT;
}
echo <<<EOT
-->
                              </ul>
                              <ol>
<!--
EOT;
foreach($gw_img as $key=>$val){
echo <<<EOT
-->
                                  <li></li>
<!--
EOT;
}
echo <<<EOT
-->
                              </ol>
                          </div>
                          <!--轮播图2 end-->
						  <script>
                              $(function(){
                                  <!--调用luara示例-->
                                  $(".example2").luara({width:"300",height:"296",interval:4500,selected:"seleted",deriction:"left"});
                      
                              });
                          </script>
                       </div>
                  
                       <div class="rglist clearfix">
                          <ul>
<!--
EOT;
foreach($app_gw as $kw=>$vw){
  $vw['updatetime']=date("Y-m-d",strtotime($vw['updatetime']));
echo <<<EOT
-->
                             <li class="clearfix">
                                <div class="bt"><a href="news/shownews.php?lang=cn&id={$vw[id]}">{$vw[title]}</a></div>
                                <div class="sj">{$vw[updatetime]}</div>
                             </li>
<!--
EOT;
}
echo <<<EOT
-->
                          </ul>
                       </div>
                       
                    </div> 
                    <!--i_zxmelc3d-->
                </div>
               <!--选项卡-国外动态end-->
            </div>
      </div>
      <!--i_zxmelc 结束-->
   </div>
<script type="text/javascript">
function setContentTab(name, curr, n) {
    for (i = 1; i <= n; i++) {
        var menu = document.getElementById(name + i);
        var cont = document.getElementById("con_" + name + "_" + i);
        menu.className = i == curr ? "hover" : "";
        if (i == curr) {
            cont.style.display = "block";
        } else {
            cont.style.display = "none";
        }
    }
}
</script>
   <!--gnwdtbox 结束-->
</div>
<!---------------------------------box3 结束--------------------------------->





<!---------------------------------box4 开始--------------------------------->
<div class="box4">
  <div class="chengquzs"><a href="news/news.php?lang=cn&class2=114"><img src="images/cqdtzs.png" width="44" height="158"></a></div>
  <div class="cqnr clearfix">
    <ul>
      <li class="dttoutiao">
          <div class="dtttbox">
             <div class="bt"><a href="news/shownews.php?lang=cn&id={$cqdt_list[0][id]}">{$cqdt_list[0][title]}</a></div>
             <P><a href="news/shownews.php?lang=cn&id={$cqdt_list[0][id]}">{$cqdt_list[0][description]}</a></p>
             <div class="xqdj"><a href="news/shownews.php?lang=cn&id={$cqdt_list[0][id]}">详情点击>></a></div>
          </div>
      </li>
      <li class="dtlist1" style=" margin-right:20px;">
<!--
EOT;
foreach($cqdt_list as $kl=>$vl){
  if($kl>0&&$kl<8){
  $vl['updatetime']=date("Y-m-d",strtotime($vl['updatetime']));
echo <<<EOT
-->
         <div class="dt1 clearfix" style="margin-bottom:12px;">
             <div class="xbt"><span style="color:#E77817; padding-right:5px; display:inline-block;">◆</span><a href="news/shownews.php?lang=cn&id={$vl[id]}">{$vl[title]}</a></div>
             <div class="sj">{$vl[updatetime]}</div>
         </div>
<!--
EOT;
}
}
echo <<<EOT
--> 
      </li>
      
      <li class="dtlist1">
<!--
EOT;
foreach($cqdt_list as $kr=>$vr){
  if($kr>7&&$kr<15){
  $vr['updatetime']=date("Y-m-d",strtotime($vr['updatetime']));
echo <<<EOT
-->
         <div class="dt1 clearfix" style="margin-bottom:12px;">
             <div class="xbt"><span style="color:#E77817; padding-right:5px; display:inline-block;">◆</span><a href="href="news/shownews.php?lang=cn&id={$vr[id]}">{$vr[title]}</a></div>
             <div class="sj">$vr[updatetime]</div>
         </div>
<!--
EOT;
}
}
echo <<<EOT
--> 
      </li>
    </ul>
  </div>
</div>
<!---------------------------------box4 结束--------------------------------->
<!--
EOT;

?>