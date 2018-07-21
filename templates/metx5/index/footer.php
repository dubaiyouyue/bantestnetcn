<!--<?php
echo <<<EOT
-->
<!---------------------------------box5 开始--------------------------------->
<div class="box5">
   <div class="btbox">
      <div class="title">{$lang_linkstitle}</div>
      <div class="ljnr">
         <ul class="lianjie1 clearfix" style="padding-bottom:10px;">
<!--
EOT;
foreach($link_img as $key=>$val){

echo <<<EOT
-->
           <li style="margin:0px 20px 10px 20px;"><a target="_blank" href="{$val[weburl]}">{$val[webname]}</a></li>
<!--
EOT;

}
echo <<<EOT
-->
         </ul>
         
    
         
      </div>
     <div class="ljzst"><img src="images/lianjiezs.png" width="23" height="30"></div>
  </div>
</div>
<!---------------------------------box5 结束--------------------------------->
<!--
EOT;
?>