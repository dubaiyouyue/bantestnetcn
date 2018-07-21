<?php
require_once '../common.inc.php';
require_once ROOTPATH.'include/export.func.php';
if($action=='patch'){
	$gz_file='/dl/patch.php';
	$post_data = array('ver'=>$metcms_v,'patch'=>$gz_patch);
	$difilelist=curl_post($post_data,10);
	if($difilelist!='nohost'){
		$difilelists=explode('*',$difilelist);
		$gz_file='/dl/olupdate_curl.php';	
		foreach($difilelists as $key=>$val){
			$difilelistss=explode('|',$val);
			$gz_patch=$difilelistss[0];
			unset($difilelistss[0]);
			foreach($difilelistss as $key1=>$val1){
				$val2=readmin($val1,$gz_adminfile,2);
				filetest("../../$val2");
				$re=dlfile("v$metcms_v/$val1","../../$val2");
				if($re!=1){
					echo $re;
					die();
				}
			}
			if(file_exists("../../$gz_adminfile/update/v{$metcms_v}_{$gz_patch}.php")){
				require_once "../../$gz_adminfile/update/v{$metcms_v}_{$gz_patch}.php";
			}
			@unlink("../../$gz_adminfile/update/v{$metcms_v}_{$gz_patch}.php");
			$query="update $gz_config set value='$gz_patch' where name='gz_patch'";
			$db->query($query);
		}
		echo 1;
	}
	else{
		echo 2;
	}
	die();
}
?>