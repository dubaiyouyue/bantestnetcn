<!--<?php
require_once template('head'); 
require_once template('sidebar');
$metlinkimg=methtm_link('img','all','0','100','1');
$metlinktext=methtm_link('text','all','0','100','1');
echo <<<EOT
--> <style>#linkkimggs li{width:208px;height:70px;}#linkkimggs img{max-width:100%;}</style><div class="xxnrbox3 clearfix" style="margin-bottom:20px;">
       <ul id="linkkimggs">
          {$metlinkimg}
        </ul> 
    </div>
<!--
EOT;
  

require_once template('gap');
require_once template('foot'); 
?>