<!--<?php
require_once template('head'); 
require_once template('sidebar');
$messagelist=metlabel_messagelist();
$fromarray=metlabel_message();
echo <<<EOT
-->
 <div class="xxnrbox8">
         <div class="wzms"> 本栏目是南宁市青秀区知识产权公共信息服务平台向广大网民求计问策的窗口，欢迎您在此发表意见。未署真名的信访事项，不予受理、回复。凡与建言献策主旨不符的言论我们有权删除，敬请谅解。<span class="hz" style="color:#D80000;">（注：带"*"号为必填项）</span></div>
         
         <form onsubmit="return checkedform();" enctype='multipart/form-data' method='POST' class="ui-from" name='myform' action='message.php?action=add'>
                        <div id="content_form">
                            <table cellpadding=0 cellspacing=0 class="table_form"  >
                                <input type="hidden"  name="lang" value="{$lang}" />
                                <input type="hidden"  name="ip" value="{$m_user_ip}" />
                                <tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</td>
                                    <td id="table" class="box_telephone">
                                        <input class="input-text"  name="xm" type='text' maxlength="6" id="xm" value="" onFocus="if(this.value == this.defaultValue) this.value = ''" onBlur="if(this.value == '') this.value = this.defaultValue">
                                    </td>
                                </tr> 
                                <tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font> 联系方式：</td>
                                    <td id="table" class="box_title">
                                    	<input type="text"   class="input-text "name='lxfs'  placeholder="如QQ、MSN等" id="biaoti" value="" size="40"  validate=" minlength:2, maxlength:50, required:true" />
                                    </td>
                                </tr>
 							    <tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font> 电子邮箱：</td>
                                    <td id="table" class="box_email">
                                    	<input type="email"   class="input-text " name='email'  id="email" value="" size="20"  validate=" maxlength:40, required:true, email:true" /> 
                                    </td>
                                </tr> 
                                <tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font>联系电话：</td>
                                    <td id="table" class="box_telephone">
                                     	<input type="text"   class="input-text "  name='tel'  id="tel" value="" size="20"  validate=" mobile:true" /> 
                                    </td>
                                </tr>      
                                </tr><tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font>内&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;容：</td>
                                    <td id="table" class="box_content"><input type="hidden" name="type" value="1" />
                                        <textarea placeholder="（不超过300字）"   name='content' maxlength="600"  rows="10" cols="60"  id="content" style="border:1px solid #ccc; color:#999; font-family:'Microsoft YaHei'; padding:5px 10px 5px 10px;"   validate=" minlength:2, maxlength:200, required:true" /></textarea>   
                                    </td>
                              	</tr>
                            <!--</tr><tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font>验证码&nbsp;&nbsp; ：</td>
                                    <td id="table" class="box_content">
                                        <input type="text" name='code' data-required='1' style="width:100px; height:30px;">
                                        <img align="absbottom" style="width:100px; height:30px;" src="..//member/ajax.php?action=code" onclick="this.src='../member/ajax.php?action=code&amp;'+Math.random()" alt="看不清？点击更换验证码'/">
                                    </td>
                              	</tr>  -->                   
                                <tr>
                                    <td width="100">&nbsp;</td>
                                    <td>&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100"></td>
                                    <td>
                                        <input TYPE="submit" value="提 交" class="button_submit" />
                                        <input TYPE="reset"  value="取 消" class="button_reset" />
                                    </td>
                                </tr>
                            </table>
        
                        </div>
                    </form>
      </div>
<!--留言js start-->
<script>
function checkedform(){
	var tel=$('#tel').val();
	var xm=$('#xm').val();
	var email=$('#email').val();
	var content=$('#content').val();
	if(!xm || (xm.length>6)){

		alert('请输入6个字符之内的姓名');
		return false;
	}
	if(!email ){

		alert('请输入邮箱');
		return false;
	}

	if(!tel || (tel.length!=7 && tel.length!=11) || isNaN(tel)){
		alert('请填写正确的手机号');
		return false;
	}
	
	if(!content || (content.length<20)){

		alert('请输入20个字符以上内容');
		return false;
	}
}
</script>
<div style="margin:20px 20px 20px 20px;"></div>

<!--
EOT;
echo <<<EOT
-->
<style>
.fbly{
    font-size:16px;
    font-weight:bold;
    margin-top:30px;
    margin-bottom:10px;
    color:#1C60B3;
}
.zxzt{
    color:#000;
    font-size:14px;
    line-height:1.8;
}
.zxzt .lynr{
    font-size:14px;
    color:#666;
}
.xbkxx{
    border-bottom:1px dashed #888;
    padding-top:5px;
    margin-bottom:10px;
}
</style>
   <div class="fbly">访客意见</div>
   <div style="
    text-align: center;
    background: #438ADA;
    padding: 8px 0;
    cursor: pointer;
    width: 180px;
    margin: auto;
    border: 1px solid #1C60B3;
    color: #fff;
    margin-top: 28px;
" class="jiazai" onclick="sslyss();" id="sfsdfssss">加载更多...</div>
<!--
EOT;
echo <<<EOT
-->
<script type="text/javascript">
    nyyyyn=0;
    sslyss();

    function sslyss(){
    $("#sfsdfssss").text('加载中...');
    $.ajax( {
            url: '/message/message.php?action=get_ajax&p='+nyyyyn, //这里是静态页的地址
            type: "GET", //静态页用get方法，否则服务器会抛出405错误
            success: function(data){
                if(data=='no'){
                    $("#sfsdfssss").text('没有了');
                    return false;
                }
                //var result = $(data).find("另一个html页面的指定的一部分").html();
                $("#sfsdfssss").before(data);
                $("#sfsdfssss").text('查看更多...');
                nyyyyn=nyyyyn+1;
            }
    });}

</script>
<!--
EOT;
require_once template('gap');
require_once template('foot'); 
?>