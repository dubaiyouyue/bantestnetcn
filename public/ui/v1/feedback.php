<!--<?php
require_once template('head'); 
require_once template('sidebar');
$fromarray=metlabel_feedback();
$fid_url=$fid?1:0;
$show = $db->get_one("select * from gz_column where id=98");
// if($tsid){
// 	$tjtitle="本栏目是在线投诉平台，为保证信息的有效性。未署真名的信访事项，不予受理、回复。凡与建言献策主旨不符的言论我们有权删除，敬请谅解。";
// }else{
// 	$tjtitle="本栏目是南宁市青秀区知识产权公共信息服务平台向广大网民求计问策的窗口，欢迎您在此发表意见。未署真名的信访事项，不予受理、回复。凡与建言献策主旨不符的言论我们有权删除，敬请谅解。";
// }


echo <<<EOT
-->
<div class="xxnrbox9" id="zsyc">
         <div class="xzbt">{$show[name]}</div>
                   {$show[content]}
         <div class="yiyuedu"><a onclick='wyts()' >已阅读须知，我要投诉</a></div>
      </div>
 <div class="xxnrbox8" id='zsxs' style="display :none">
         <div class="wzms">本栏目是在线投诉平台，为保证信息的有效性。未署真名的信访事项，不予受理、回复。凡与建言献策主旨不符的言论我们有权删除，敬请谅解。<span class="hz" style="color:#D80000;">（注：带"*"号为必填项）"</span></div>
         
        <form onsubmit="return checkedformf();" name="myform" enctype='multipart/form-data' id="myform" method="POST" action="index.php?action=add">
                        <div id="content_form">
                            <table cellpadding=0 cellspacing=0 class="table_form"  >
                                <input type="hidden"  name="lang" value="{$lang}" />
                                <input type="hidden"  name="fdtitle" value="{$title}" />
                                <input type="hidden"  name="ip" value="{$m_user_ip}" />
                                <input type='hidden' name='id' value='{$id}' />
								<input type='hidden' name='fid_url' value='{$fid_url}' />
                                <tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</td>
                                    <td id="table" class="box_telephone">
                                        <input class="input-text"  name='xingm' type='text' maxlength="5" id="xm" value="" onFocus="if(this.value == this.defaultValue) this.value = ''" onBlur="if(this.value == '') this.value = this.defaultValue">
                                    </td>
                                </tr> 
                                <tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font> 标&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题：</td>
                                    <td id="table" class="box_title">
                                    	<input type="text"   class="input-text "name='biaoti'  id="biaoti" value="" size="40"  validate=" minlength:2, maxlength:50, required:true" />
                                    </td>
                                </tr>
 							    <tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font> 电子邮箱：</td>
                                    <td id="table" class="box_email">
                                    	<input type="email"   class="input-text " name='youxiang'  id="email" value="" size="20"  validate=" maxlength:40, required:true, email:true" /> 
                                    </td>
                                </tr> 
                                <tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font>联系电话：</td>
                                    <td id="table" class="box_telephone">
                                     	<input type="text"   class="input-text "  name='tel'  id="tel" value="" size="20"  validate=" mobile:true" /> 
                                    </td>
                                </tr>      
                                </tr><tr id="liuyan" height="45px">
                                    <td width="100" align="right" id="liuyan_wz" style="font-size:14px;color:#444;"><font color="red">*</font>意见内容：</td>
                                    <td id="table" class="box_content">
                                        <textarea placeholder="（不超过300字）" class="" name='content' maxlength="600"  rows="10" cols="60"  id="content" style="border:1px solid #ccc; color:#999; font-family:'Microsoft YaHei'; padding:5px 10px 5px 10px;"   validate=" minlength:2, maxlength:200, required:true" /></textarea>   
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
                                        <input TYPE="submit"  onclick="xxpd();"  value="提 交" class="button_submit" />
                                        <input TYPE="reset"  value="取 消" class="button_reset" />
                                    </td>
                                </tr>
                            </table>
        
                        </div>
                    </form>
      </div>
<!--留言js start-->
<script>
function checkedformf(){
	var tel=$('#tel').val();
	var biaoti=$('#biaoti').val();
	var xm=$('#xm').val();
	var email=$('#email').val();
	var content=$('#content').val();
	if(!xm || (xm.length>6)){

		alert('请输入6个字符之内的姓名');
		return false;
	}
	if(!biaoti){

		alert('请输入标题');
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
function wyts(){
    $('#zsyc').hide();
    $('#zsxs').show();
}
</script>
<!--
EOT;
require_once template('gap');
require_once template('foot'); 
?>