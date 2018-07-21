<!--<?php
$wsfw_name=$db->get_one("select * from gz_column where id=106");   // 网上服务
$gzhd_name=$db->get_one("select * from gz_column where id=1");     // 公众互动
$xxgk_name=$db->get_one("select * from gz_column where id=103");   // 信息公开
$wsfw_list=$db->get_all("select * from gz_column where bigclass=$wsfw_name[id] and display=0 and is_inindex=0 ORDER by no_order LIMIT 6"); // 网上服务列表
$gzhd_list=$db->get_all("select * from gz_column where bigclass=$gzhd_name[id] and display=0 and is_inindex=0 ORDER by no_order LIMIT 6"); // 公众互动列表
$xxgk_list=$db->get_all("select * from gz_column where bigclass=$xxgk_name[id] and display=0 and is_inindex=0 ORDER by no_order LIMIT 4"); // 信息公开列表
echo <<<EOT
-->
<!---------------------------------box2 开始--------------------------------->
<div class="box2 clearfix">
   <div class="lfbox">
     <div class="wsfwbox">
       <div class="btbox"><span class="bt">{$wsfw_name[name]}</span></div>
        <div class="sknrbox">
           <ul class="list1 clearfix">
<!--
EOT;

foreach($wsfw_list as $kfw=>$vfw){
	if(!$vfw['out_url']){
    if($vfw['foldername']==$wsfw_name['foldername']){
        $vfw['url']="/service/news.php?lang=cn&class2={$vfw[id]}";
    }else{
        $vfw['url']="/$vfw[foldername]";
    }
  }else{
      $vfw['url']=$vfw['out_url'];
  }
	if($kfw<3){
		$fwsty="style='margin-right:14px;'";
		if($kfw==2){
			$fwsty="";
		}
echo <<<EOT
-->
    <li {$fwsty}><div class="btwz1 icon{$vfw[index_num]}"><a href="{$vfw[url]}" {$vfw[new_windows]}>{$vfw[name]}</a></div></li>
<!--
EOT;
}
}
echo <<<EOT
-->
           </ul>
           <ul class="list1 clearfix" style="margin-top:20px;">
<!--
EOT;

foreach($wsfw_list as $kfw=>$vfw){
	 if(!$vfw['out_url']){
    if($vfw['foldername']==$wsfw_name['foldername']){
        $vfw['url']="/service/news.php?lang=cn&class2={$vfw[id]}";
    }else{
        $vfw['url']="/$vfw[foldername]";
    }
  }else{
      $vfw['url']=$vfw['out_url'];
  }
	if($kfw>2&&$kfw<6){
    $fwsty="style='margin-right:14px;'";
    if($kfw==5){
      $fwsty="";
    }
echo <<<EOT
-->
             <li {$fwsty}><div class="btwz1 icon{$vfw[index_num]}"><a href="{$vfw[url]}" {$vfw[new_windows]}>{$vfw[name]}</a></div></li>
<!--
EOT;
}
} 

// 公众互动
echo <<<EOT
-->         
           </ul>
        </div>
     </div>
     <div class="gzhdbox">
        <div class="btbox"><span class="bt">{$gzhd_name[name]}</span></div>
        <div class="sknrbox">
           <ul class="list1 clearfix">
<!--
EOT;
foreach($gzhd_list as $kgz=>$vgz){
 if(!$vgz['out_url']){
    if($vgz['foldername']==$gzhd_name['foldername']){
        $vgz['url']="/about/show.php?lang=cn&id={$vgz[id]}";
    }else{
        $vgz['url']="/$vgz[foldername]";
    }
  }else{
      $vgz['url']=$vgz['out_url'];
  }
	if($kgz<3){
		$gzsty="style='margin-right:14px;'";
		if($kgz==2){
			$gzsty="";
		}
echo <<<EOT
-->
    <li {$gzsty}><div class="btwz1 icon{$vgz[index_num]}"><a {$vgz[new_windows]} href="{$vgz[url]}">{$vgz[name]}</a></div></li>
<!--
EOT;
}
}
echo <<<EOT
-->

           </ul>
           
           <ul class="list1 clearfix" style="margin-top:20px;">
 <!--
EOT;

foreach($gzhd_list as $kgz=>$vgz){
   if(!$vgz['out_url']){
    if($vgz['foldername']==$gzhd_name['foldername']){
        $vgz['url']="/about/show.php?lang=cn&id={$vgz[id]}";
    }else{
        $vgz['url']="/$vgz[foldername]";
    }
  }else{
      $vgz['url']=$vgz['out_url'];
  }
	if($kgz>2&&$kgz<6){
   $gzsty="style='margin-right:14px;'";
    if($kgz==5){
      $gzsty="";
    }
echo <<<EOT
-->
             <li {$gzsty}><div class="btwz1 icon{$vgz[index_num]}"><a href="{$vgz[url]}" {$vgz[new_windows]}>{$vgz[name]}</a></div></li>
<!--
EOT;
}
}
echo <<<EOT
--> 
           </ul>
        </div>
     </div>
   </div>
   <div class="rgbox">
      <div class="xxgkbtbox">
          <span class="xxgkbt">{$xxgk_name[name]}</span>
          <span class="gengduo"><a href="/information/">更多</a></span>
      </div>
    <div class="xxgknrbox clearfix">
<!--
EOT;
if($xxgk_list[0]['name']){
echo <<<EOT
-->
         <a href="/information/news.php?lang=cn&class2={$xxgk_list[0][id]}"><div class="lfk">{$xxgk_list[0][name]}</div></a>
<!--
EOT;
}
if($xxgk_list[1]['name']){
echo <<<EOT
-->       
         <a href="/information/news.php?lang=cn&class2={$xxgk_list[1][id]}"><div class="rgk">{$xxgk_list[1][name]}</div></a>
<!--
EOT;
}
if($xxgk_list[2]['name']){
echo <<<EOT
-->
         <a href="/information/news.php?lang=cn&class2={$xxgk_list[2][id]}"><div class="lfk" style="margin-top:22px;">{$xxgk_list[2][name]}</div></a>
<!--
EOT;
}
if($xxgk_list[3]['name']){
echo <<<EOT
-->       
         <a href="/information/news.php?lang=cn&class2={$xxgk_list[3][id]}"><div class="rgk" style="margin-top:22px;">{$xxgk_list[3][name]}</div></a>
<!--
EOT;
}
echo <<<EOT
-->

      </div>
   </div>
</div>
<!---------------------------------box2 结束--------------------------------->
<!--
EOT;
?>