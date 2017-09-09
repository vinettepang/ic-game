<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('WORD_WIDTH',5);
define('WORD_HIGHT',9);
define('OFFSET_X',1);
define('OFFSET_Y',4);
define('WORD_SPACING',2);
$host = isset($_SERVER['HTTP_X_FORWARDED_HOST'])?$_SERVER['HTTP_X_FORWARDED_HOST']:(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'');
define( "WEB_URL", ($_SERVER['SERVER_PORT'] == 8080?'https://':'http://').$host.'/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
