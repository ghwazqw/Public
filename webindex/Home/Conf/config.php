<?php
return array(
    'DEFAULT_FILTER'        => 'strip_tags,htmlspecialchars', //过滤函数
    'URL_MODEL'=>2,
    'URL_HTML_SUFFIX' =>'.html', //静态HTML访问

    //数据库配置类
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'glxh', // 用户名
    'DB_PWD'    => 'glxh', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'gl_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=123.59.105.68;dbname=glxh;charset=utf8',
    /*'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'glxhfine_f', // 用户名
    'DB_PWD'    => 'CC@CO7DKy6', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'gl_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=103.60.223.6;dbname=glxhfine;charset=utf8',*/
    //'LOAD_EXT_CONFIG' => 'Huser', //用户登录配置
    'LOAD_EXT_CONFIG' => 'Redis_config', //redis服务器配置
    'LOAD_EXT_CONFIG' => 'user', //前端用户登录
    //图片上传
    "uploadfile"=>array('maxSize'=> 3145728,
        'rootPath'=> './',
        'savePath'  => 'Public/Uploads/',
        'exts'=>array('jpg', 'gif', 'png', 'jpeg','pdf'),
        'autoSub'  => true,
        'subName'    =>    array('date','Ymd'),
        'thumb' => true, //生成缩略图
        //设置需要生成缩略图的文件后缀
        'thumbPrefix' => 'm_,s_', //生成两张缩略图
        //设置缩略图最大宽度
        'thumbMaxWidth' => array('400,100'),
         //设置缩略图最大高度
         'thumbMaxHeight'=> array('400,100'),
    ),
    //文件上传
    "up_file"=>array('maxSize'=> 3145728,
        'rootPath'=> './',
        'savePath'  => 'Public/Uploads/',
        'exts'=>array('rar', 'doc', 'docx', 'ppt','pptx','pdf'),
        'autoSub'  => true,
        'subName'    =>    array('date','Ymd'),
        //'thumb' => true, //生成缩略图
        //设置需要生成缩略图的文件后缀
        //'thumbPrefix' => 'm_,s_', //生成两张缩略图
        //设置缩略图最大宽度
        //'thumbMaxWidth' => array('400,100'),
        //设置缩略图最大高度
        //'thumbMaxHeight'=> array('400,100'),
    ),
    // 配置邮件发送服务器
    'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'ghwzln@163.com',//你的邮箱名
    'MAIL_FROM' =>'ghwzln@163.com',//发件人地址
    'MAIL_FROMNAME'=>'中国公路科技成果转化平台',//发件人姓名
    'MAIL_PASSWORD' =>'ghwytr3530',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
    /*微信认证登录信息*/
    'wx_appid'=>'wxddf6d906e5dd86f8',
    'wx_appsecret'=>'ec73fc66c095fbcbe7d3405922a583c8',

         //路由开启   
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
    'login'=>'/?a=login&c=User',
),

);