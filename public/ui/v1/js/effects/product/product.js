define(function(require, exports, module) {
	var common = require('common'); 

	if(MetpageType==2){//列表页
		var ul_1 = $('.gz_module3_list ul.list_1');
		if(ul_1.length>0){
			var minwidth = parseInt(ul_1.find('li img').attr("width"))+20;
			ul_1.find("li a").width(function(){ return $(this).find('img').attr("width");});
			common.listpun(ul_1,ul_1.find("li"),minwidth);
			common.metHeight($(".gz_module3_list ul.list_1 li h2"));
			ul_1.css("visibility","visible");
		}
		var ul_2 = $('.gz_module3_list ul.list_2');
		if(ul_2.length>0){
			ul_2.find("dt").width(function(){ return $(this).find('img').attr("width");});
			ul_2.find("dd").css('margin-left','-'+ul_2.find("dt").width()+'px');
			ul_2.find("dd .gz_listbox").css('margin-left',ul_2.find("dt").width()+'px');
			ul_2.css("visibility","visible");
		}
	}
	if(MetpageType==3){//详情页
		/*产品展示图片*/
		require.async('effects/flexslider/flexslider.css');
		require.async('effects/flexslider/jquery.flexslider',function(){
			$('#showproduct dl.pshow dt .gz_imgshowbox').flexslider({
				selector: ".slides > figure",
				directionNav: false,
				controlNav: true,
				manualControls: $("#showproduct dl.pshow dt ol li"),
				touch: true,
				slideshowSpeed:999999999,
				animationSpeed:20,
				pauseOnHover: true,
				start: function() {
					$('#showproduct dl.pshow dt .gz_box').css('visibility','visible');
				}
			});
		});
		require.async('effects/product/proshow');
		/*参数排版*/
		var productW = $("#showproduct .pshow");
		if(productW){
			productW.find("dt").width(function(){ return parseInt($(this).attr("data-product_x"))+220;});
			productW.find("dd").css('margin-left','-'+(parseInt(productW.find("dt").width())+1)+'px');
			productW.find("dd .gz_box").css('margin-left',(parseInt(productW.find("dt").width())+1)+'px');
			productW.find("dd .gz_box li").height(function(){
				if($(this).height()<$(this).find('span').height()){
					return $(this).find('span').height();
				}
			});
			productW.css("visibility","visible");
		}
		/*选项卡*/
		if($("#showproduct .gz_nav li").length>1){
			$("#showproduct .gz_nav li").hover(function(){
				$(this).addClass("gz_hover");
			},function(){
				$(this).removeClass("gz_hover");
			});
			function showproductnav(url){
				var list = url.split("#mettab");
					list = parseInt(list[1])-1;
				if($("#showproduct .gz_nav_contbox .gz_editor").length>=(list+1)){
					$("#showproduct .gz_nav li").removeClass("gz_now");
					$("#showproduct .gz_nav_contbox .gz_editor").hide();
					$("#showproduct .gz_nav_contbox .gz_editor").eq(list).show();
					$("#showproduct .gz_nav li").eq(list).addClass("gz_now");
				}
			}
			var timespnav;
			$("#showproduct .gz_nav li").click(function(){
				clearTimeout(timespnav);
				timespnav = setTimeout(function () {
					showproductnav(location.href);
				}, 200);
			});
			showproductnav(location.href);
		}
		/*相关产品*/
		var related_list = $('.gz_related_list');
		if(related_list.length>0){
			var minwidth = parseInt(related_list.find('li img').attr("width"))+20;
			related_list.find("li a").width(function(){ return $(this).find('img').attr("width");});
			common.listpun(related_list,related_list.find("li"),minwidth);
			related_list.css("visibility","visible");
		}
	}
});