<?php
require_once '../common.inc.php';
$query = "UPDATE {$gz_config} set value='{$apppass}' where name = 'gz_apppass'";
$db->get_one($query);
header("{$serverurl}");
?>