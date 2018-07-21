<?php

//定义回调URL通用的URL
define('URL_CALLBACK', '/index.php?g=User&m=Login&a=callback&type=');
$database = require (RUNTIME_PATH . 'config.php');
$sys_config = include DATA_PATH . 'sys.config.php';
if (empty($sys_config)) {
    $sys_config = array();
    $sys_config['LAYOUT_ON'] = 1;
}
if ($sys_config['URL_MODEL'])
    $RULES = include DATA_PATH . 'Routes.php';
$config = array(
    'DEFAULT_THEME' => 'Default',
    'DEFAULT_CHARSET' => 'utf-8',
    'APP_GROUP_LIST' => 'Home,Admin,User',
    'DEFAULT_GROUP' => 'Home',
    'TMPL_FILE_DEPR' => '_',
    'DB_FIELDS_CACHE' => false,
    'DB_FIELDTYPE_CHECK' => true,
    'URL_ROUTER_ON' => true,
    'DEFAULT_LANG' => 'cn',
    'LANG_SWITCH_ON' => true,
    'TAGLIB_LOAD' => true,
    'TAGLIB_PRE_LOAD' => 'Gz',
    'TMPL_ACTION_ERROR' => APP_PATH . '/Tpl/Home/Default/Public/success.html',
    'TMPL_ACTION_SUCCESS' => APP_PATH . '/Tpl/Home/Default/Public/success.html',
    'COOKIE_PREFIX' => 'GZ_',
    'COOKIE_EXPIRE' => '',
    'VAR_PAGE' => 'p',
    'LAYOUT_HOME_ON' => $sys_config['LAYOUT_ON'],
    'URL_ROUTE_RULES' => $RULES,
    'TMPL_EXCEPTION_FILE' => APP_PATH . '/Tpl/Home/Default/Public/exception.html',	 
    'ERROR_PAGE' => '', // 错误定向页面
    
    //腾讯QQ登录配置
    'THINK_SDK_QQ' => array(
        'APP_KEY' => '100337853', //应用注册成功后分配的 APP ID
        'APP_SECRET' => 'd2bad4d598c85cdfe13a62303485bb6b', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'qq',
    ),
    //腾讯微博配置
    'THINK_SDK_TENCENT' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'tencent',
    ),
    //新浪微博配置
    'THINK_SDK_SINA' => array(
        'APP_KEY' => '2651187187', //应用注册成功后分配的 APP ID
        'APP_SECRET' => 'd224366c8dc439eb587cdf1d6c5961a2', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'sina',
    ),
    //网易微博配置
    'THINK_SDK_T163' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 't163',
    ),
    //人人网配置
    'THINK_SDK_RENREN' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'renren',
    ),
    //360配置
    'THINK_SDK_X360' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'x360',
    ),
    //豆瓣配置
    'THINK_SDK_DOUBAN' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'douban',
    ),
    //Github配置
    'THINK_SDK_GITHUB' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'github',
    ),
    //Google配置
    'THINK_SDK_GOOGLE' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'google',
    ),
    //MSN配置
    'THINK_SDK_MSN' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'msn',
    ),
    //点点配置
    'THINK_SDK_DIANDIAN' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'diandian',
    ),
    //淘宝网配置
    'THINK_SDK_TAOBAO' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'taobao',
    ),
    //百度配置
    'THINK_SDK_BAIDU' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'baidu',
    ),
    //开心网配置
    'THINK_SDK_KAIXIN' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'kaixin',
    ),
    //搜狐微博配置
    'THINK_SDK_SOHU' => array(
        'APP_KEY' => '', //应用注册成功后分配的 APP ID
        'APP_SECRET' => '', //应用注册成功后分配的KEY
        'CALLBACK' => URL_CALLBACK . 'sohu',
    ),
);
return array_merge($database, $config, $sys_config);

?>
