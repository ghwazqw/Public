<?php
return array(
    'DEFAULT_FILTER'        => 'strip_tags,htmlspecialchars', //过滤函数

	//'配置项'=>'配置值'
    /*'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'glxh', // 用户名
    'DB_PWD'    => '1234', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'gl_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=127.0.0.1;dbname=gl_glxh;charset=utf8',*/
    'DB_TYPE'   => 'mysql', // Êý¾Ý¿âÀàÐÍ
    'DB_USER'   => 'glxhfine_f', // ÓÃ»§Ãû
    'DB_PWD'    => 'CC@CO7DKy6', // ÃÜÂë
    'DB_PORT'   => 3306,   //¶Ë¿ÚºÅ
    'DB_PREFIX' => 'gl_', // Êý¾Ý¿â±íÇ°×º
    'DB_DSN'    => 'mysql:host=103.60.223.6;dbname=glxhfine;charset=utf8',
    'LOAD_EXT_CONFIG' => 'Huser',
         //路由开启   
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
    'login'=>'/user/login'


),
);