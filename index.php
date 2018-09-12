<?php

    $system="1";

    if ($system=="update"){
        echo "System Update,Plese Wait...";
    } else{
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
        define('APP_DEBUG',true);
        define('BIND_MODULE', 'Home'); //去除访问时所需要的home
        //定义默认模块
        //define('BIND_MODULE','Home');

// 定义应用目录
//define('BIND_MODULE', 'Home');//定义默认访问模块
//define('APP_PATH','./webindex/');
//define('APP_PATH','./cqmanage/');
//define('APP_PATH','./tqdlweb/');
//define('APP_PATH','./jzpts/');
//define('APP_PATH','./Eshop/');
//define('APP_PATH','./Sosystem/');
//define('APP_PATH','./Bui/');
define('APP_PATH','./jiaju/');
        //define('APP_PATH','./Jzpnew/');

// 引入ThinkPHP入口文件
        require './DxydPHP/DxydPHP.php';
//phpinfo();
}