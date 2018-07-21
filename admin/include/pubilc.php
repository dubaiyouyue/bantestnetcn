<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved.
$query="select * from $gz_column where lang='$lang' order by no_order";
$result= $db->query($query);
while($list = $db->fetch_array($result)){
$admin_column_power="admin_popc".$list[id];
if(!($metinfo_admin_pop=='metinfo'||$$admin_column_power=='metinfo')&&($list[classtype]==1||$list[releclass]!=0))continue;
if($list[classtype]==1){
    $gz_class1[$list['id']]=$list;
}
if(($list[classtype]==1 or ($list[releclass]>0 and ($list[module]<=7 || $list[module]==8))) and $list[if_in]==0)$gz_classindex[$list[module]][]=$list;
if(($list[classtype]==2 or ($list[releclass]>0 and $list[module]<=7)) and $list[if_in]==0)$gz_classindex2[$list[module]][]=$list;
if($list[releclass])$gz_classrele[$list['id']]=$list;
if($list[classtype]==2)$gz_class2[$list[bigclass]][]=$list;
if($list[classtype]==2)$gz_class2a[$list['id']]=$list;
if($list[classtype]==2 and $list[releclass]==0  and $list[if_in]==0 )$gz_class22[$list[bigclass]][]=$list;
if($list[classtype]==3)$gz_class3[$list[bigclass]][]=$list;
$gz_class[$list['id']]=$list;
$gz_module[$list['module']][]=$list;
}
$query="select * from $gz_column order by no_order";
$result= $db->query($query);
while($list = $db->fetch_array($result)){
if($list[classtype]==1 || $list[releclass])$column_pop[$list[lang]][]=$list;
if(($list[classtype]>=1 or ($list[releclass]>0 and $list[module]<=7)) and $list[if_in]==0)$column_lang[$list[module]][]=$list;
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>