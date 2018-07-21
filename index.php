<?php
/*
$the_host = $_SERVER['HTTP_HOST'];//取得当前域名
$the_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面部分
//$the_url = strtolower($the_url);//将英文字母转成小写
if($the_url=="/index.php")//判断是不是首页
{
$the_url="";//如果是首页，赋值为空
}
if($the_host !== 'www.hkshenghang.com')//如果域名不是带www的网址那么进行下面的301跳转
{
header('HTTP/1.1 301 Moved Permanently');//发出301头部
header('Location:http://www.hkshenghang.com'.$the_url);//跳转到带www的网址
 //header后的PHP代码还会被执行 .确保重定向后，后续代码不会被执行 
exit;

}
*/


/**
 *
 * index(入口文件)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <wei2l99@qq.com>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!is_file('./Cache/config.php'))header("location: ./Install");
header("Content-type: text/html;charset=utf-8");
ini_set('memory_limit','32M');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('GZPHP', 'GzPHP');
define('RESONANCEHELPVIEW', 'shenghang');
define('UPLOAD_PATH', './Uploads/');
define('VERSION','v3.7 Released');
define('UPDATETIME','20140525');
define('APP_NAME', 'GZphp');
define('APP_PATH', './GZphp/');
define('APP_LANG',true);
define('APP_DEBUG',false);
define('THINK_PATH','./Core/');
require(THINK_PATH.'/Core.php');
?>
