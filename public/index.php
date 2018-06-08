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

require_once('waf.php');

//网站根域名
 define('SITE_URL',     'http://'.$_SERVER['HTTP_HOST']);
//入口文件 根目录
 define('SITE_DIR',     __DIR__);

// 定义应用目录
define('APP_PATH', SITE_DIR . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
