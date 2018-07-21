<?php
$query="select * from {$tablepre}config where name='gz_tablename' and lang='metinfo'";
$mettable=$db->get_one($query);
$mettables=explode('|',$mettable[value]);
foreach($mettables as $key=>$val){
	$tablename='gz_'.$val;	
	$$tablename=$tablepre.$val;
}
?>