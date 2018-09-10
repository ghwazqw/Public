<?php
return array(
    'DEFAULT_FILTER' => 'strip_tags,htmlspecialchars', //过滤函数
    'URL_MODEL'=>2, //增除index.php必须
    'URL_HTML_SUFFIX' =>'.html', //静态HTML访问
    'TMPL_ACTION_ERROR' => 'manage:action', //配置操作错误模板
    'TMPL_ACTION_SUCCESS' => 'manage:action', //配置执行成功模板
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL' =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误
    'LOG_TYPE' =>  'File', // 日志记录类型 默认为文件方式

    //数据库配置类
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'cqzq', // 用户名
    'DB_PWD'    => '123456', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'zc_cq_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=47.93.18.121;dbname=cqzq;charset=utf8',
    /*'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'glxhfine_f', // 用户名
    'DB_PWD'    => 'CC@CO7DKy6', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'gl_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=103.60.223.6;dbname=glxhfine;charset=utf8',*/
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
    "uploaddoc"=>array('maxSize'=> 100000000,
        'rootPath'=> './',
        'savePath'  => 'Public/Uploads/',
        'exts'=>array('doc', 'pdf', 'rar', 'zip','7z','json'),
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
    //json文件上传
    "uploadjson"=>array('maxSize'=> 100000000,
        'rootPath'=> './',
        'savePath'  => 'Public/Uploads/',
        'exts'=>array('json', 'txt','xls','xlsx'),
        'autoSub'  => true,
        'subName'    =>    array('date','Ymd'),
    ),
    'JsonFilePath'=>'C:\wamp\www\php\Public\Uploads\stock.json', //盘点文件JSON配置
    'DB_PARAMS'    =>    array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL), //保持字段大小写原样
    'ExcelPath'=>'C:\wamp\www\php\Public\Uploads', //excel导入文件路径
    //路由开启
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
    'login'=>'/?a=login&c=User',  //系统登录
        'dzsbmanage/'=>'/home/restful/YsgjInfoList',

    /*'/Home/restful/NavbarInfo/:id'          => '/Home/restful/NavbarInfo/:1',*/
    ''=>'',
),

);