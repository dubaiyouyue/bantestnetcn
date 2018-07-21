<!--<?php
$gz_foot_nav = methtml_footnav();//底部导航标签（次导航）
$gz_foot_txt = metlabel_foot();//底部信息标签
echo <<<EOT
-->
<!---------------------------------footerbox 开始--------------------------------->
<script>	/*异步加载 - 在线交流 - 站长统计 */
	var gz_weburl='/';
	var lang='cn';
	var classnow='$classnow';
	var id='$id';
	var url=gz_weburl+'include/interface/uidata.php?lang='+lang,h = window.location.href;
	if(h.indexOf("preview=1")!=-1)url = url + '&theme_preview=1';
	$.ajax({
		type: "POST",
		url: url,
		dataType:"json",
		success: function(msg){
			var c = msg.config;
			if(c.gz_stat==1){			  //站长统计
				var navurl=classnow==10001?'':'../';
				var	stat_d=classnow+'-'+id+'-'+lang;
				var	url = gz_weburl+'include/stat/stat.php?type=para&u='+navurl+'&d='+stat_d;
				$.getScript(url);
			}
		}
	});
		//var metClicks = $(".metClicks");//点击次数
		var ClicksListnow='$id';
		var weburl='/';
		if(ClicksListnow){
			//var DataClicks = metClicks.data("metclicks");
			//ClicksStr=DataClicks.split("|"); 
			var ClicksModule = 'news';//ClicksStr[0],ClicksListnow = ClicksStr[1];
			var urlw = weburl+'include/hits.php?type='+ClicksModule+'&id='+ClicksListnow;
			$.ajax({
				type: "POST",
				url: urlw,
				dataType:"text",
				success: function(msg){
					//var t = msg.split('"');
					//metClicks.html(t[1]);
				}
			});
		}
</script>
<div class="footerbox">
   <div class="footer">
      <ul class="ftdh clearfix">

         <li class="line"><a href="#">首页</a></li>
<!--
EOT;
$navxia ='class="line"';
$countxia=count($nav_list);
foreach($nav_list as $k=>$v){
	if($k+1 == $countxia){
        unset($navxia);
    }
echo <<<EOT
-->
         <li $navxia><a href="{$v[url]}">{$v[name]}</a></li>
<!--
EOT;
}
echo <<<EOT
-->
      </ul>
      <P> {$gz_footright}</P>
      <P>{$gz_footerbeianhao}</P>
      <P>技术支持：<span class="gongzhen"><a href="http://www.resonance.com.cn/" target="_blank">广西共振广告</a></span></P>
   </div>
</div>
<!---------------------------------footerbox 结束--------------------------------->
</body>
</html>
<!--
EOT;
?>-->