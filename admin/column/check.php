<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

$columntxt=array(
				2=>"$gz_news",
				3=>"$gz_product",
				4=>"$gz_download",
				5=>"$gz_img",
				6=>"$gz_job",
				7=>"$gz_message"
		);

$column_list = $db->get_one("SELECT * FROM $gz_column WHERE id='$id'");
$module=$column_list['module'];
$currentAccess= $column_list['access'];
$accesssql=$module==4?" access='$access',downloadaccess='$access' ":" access='$access' ";
if(intval($currentAccess)<intval($access)) $cond="access < $access";
if(intval($currentAccess)>intval($access)) $cond="access <= $currentAccess";
if(intval($currentAccess)!=intval($access))
{
if($column_list[releclass]||$gz_class[$column_list[bigclass]][releclass]){
	if($column_list[releclass]){
		$table=$gz_column;
		$query ="update $table SET ".
					"access='$access' ".
					" where bigclass=$id".
					" and $cond";
		$db->query($query);		
		if (array_key_exists($module, $columntxt))
		{		
			$table=$columntxt[$module];
			$query ="update $table SET ".
						$accesssql.
						" where $cond";
			if(intval($module)<6) $query = $query." and class1=$id";
			$db->query($query);		
		}
	}else{
		if (array_key_exists($module, $columntxt))
		{		
			$table=$columntxt[$module];
			$query ="update $table SET ".
						$accesssql.
						" where $cond";
			if(intval($module)<6) $query = $query." and class2=$id";
			$db->query($query);		
		}
	}
}else{
	if($classtype==1)
	{
		$table=$gz_column;
		$query ="update $table SET ".
					" access='$access' ".
					" where bigclass=$id".
					" and $cond";
		$db->query($query);
		foreach($gz_class2[$id] as $key=>$vallist){
			$query ="update $table SET ".
						" access='$access' ".
						" where bigclass=$vallist[id] and $cond";	
			$db->query($query);
			if($vallist[releclass]&&array_key_exists($module, $columntxt)){
				$table=$columntxt[$vallist[module]];
				$query ="update $table SET ".
							$accesssql.
							" where $cond";
				if(intval($module)<6) $query = $query." and class1=$vallist[id]";
				$db->query($query);	
			}
		}
		
		if (array_key_exists($module, $columntxt))
		{		
			$table=$columntxt[$module];
			$query ="update $table SET ".
						$accesssql.
						" where $cond";
			if(intval($module)<6) $query = $query." and class1=$id";
			$db->query($query);		
		}
	}

	if($classtype==2){
		$table=$gz_column;
		$query ="update $table SET ".
					" access='$access' ".
					" where bigclass=$id".
					" and $cond";
		$db->query($query);
		if (array_key_exists($module, $columntxt))
		{		
			$table=$columntxt[$module];
			$query ="update $table SET ".
						$accesssql.
						" where $cond";
			if(intval($module)<6) $query = $query." and class2=$id";
			$db->query($query);		
		}
	}

	if($classtype==3)
	{
		if (array_key_exists($module, $columntxt))
		{		
			$table=$columntxt[$module];
			$query ="update $table SET ".
						$accesssql.
						" where $cond";
			if(intval($module)<6) $query = $query." and class3=$id";
			$db->query($query);		
		}
	}
}
}
file_unlink("../../cache/column_$lang.inc.php");
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>