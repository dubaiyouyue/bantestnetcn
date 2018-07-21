<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 
require_once '../common.inc.php';
require_once ROOTPATH.'include/export.func.php';

// dump($_M['config']);

//$data['config']=$_M['config'];

$data['config']['gz_online_type'] = $_M['config']['gz_online_type'];
$data['config']['gz_stat'] = $_M['config']['gz_stat'];

echo json_encode($data);



# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>