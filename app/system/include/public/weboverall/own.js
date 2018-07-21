define(function(require, exports, module) {

	var $ = jQuery = require('jquery');
	
	var metcst=document.querySelector('meta[name="generator"]').getAttribute('data-variable'),
		DataStr=metcst.split("|"),
		gz_weburl=DataStr[0],
		lang=DataStr[1],
		classnow=parseInt(DataStr[2]),
		id=parseInt(DataStr[3]),
		gz_module=parseInt(DataStr[4]),
		gz_skin_user=DataStr[5];
		
		window.gz_weburl 		= gz_weburl;	//网址
		window.lang 			= lang;	 		//语言
		window.classnow		    = classnow;		//当前栏目ID
		window.id 				= id;			//当前页面ID
		window.gz_module 		= gz_module;	//所属模块
		window.gz_skin_user 	= gz_skin_user;//所用模板
	
	/*繁体中文*/
	var StranBody = $(".StranBody");        	
	if(StranBody.length>0){
		require.async('pub/weboverall/ch/ch');
	}
	
	/*在线交流 - 站长统计 */
	var url=gz_weburl+'include/interface/uidata.php?lang='+lang,h = window.location.href;
	if(h.indexOf("preview=1")!=-1)url = url + '&theme_preview=1';
	$.ajax({
		type: "POST",
		url: url,
		dataType:"json",
		success: function(msg){
			var c = msg.config;
			if(c.gz_online_type!=3){	  //在线交流
				require.async('pub/weboverall/online/online');
			}
			if(c.gz_stat==1){			  //站长统计
				var navurl=classnow==10001?'':'../';
				var	stat_d=classnow+'-'+id+'-'+lang;
				var	url = gz_weburl+'include/stat/stat.php?type=para&u='+navurl+'&d='+stat_d;
				$.getScript(url);
			}
		}
	});
	
});