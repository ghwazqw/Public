<?php
return array(
    'DEFAULT_FILTER' => 'strip_tags,htmlspecialchars', //过滤函数
    'URL_MODEL'=>2, //增除index.php必须
    'URL_HTML_SUFFIX' =>'.html', //静态HTML访问
    'TMPL_ACTION_ERROR' => 'manage:action', //配置操作错误模板
    'TMPL_ACTION_SUCCESS' => 'manage:action', //配置执行成功模板
    'ENCRYPT_COOKIE_KEY'=>'nanbeit1024', //加密密钥配置


    //数据库配置类
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'ptsystem', // 用户名
    'DB_PWD'    => 'ptsystem', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'pt_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=150.109.51.29;dbname=ptsystem;charset=utf8',
    'LOAD_EXT_CONFIG' => 'Redis_config', //redis服务器配置
    'LOAD_EXT_CONFIG' => 'user', //前端用户登录

    /*//数据库配置类
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'ptsystem', // 用户名
    'DB_PWD'    => 'ptsystem', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'pt_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=39.107.254.210;dbname=ptsystem;charset=utf8',
    'LOAD_EXT_CONFIG' => 'Redis_config', //redis服务器配置
    'LOAD_EXT_CONFIG' => 'user', //前端用户登录*/

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
        'exts'=>array('json', 'txt'),
        'autoSub'  => true,
        'subName'    =>    array('date','Ymd'),
        'thumb' => false, //生成缩略图
        //设置需要生成缩略图的文件后缀
        'thumbPrefix' => 'm_,s_', //生成两张缩略图
        //设置缩略图最大宽度
        'thumbMaxWidth' => array('400,100'),
        //设置缩略图最大高度
        'thumbMaxHeight'=> array('400,100'),
    ),
    "SysConfig"=>array(
        'SystemName'=>'南北通',
        'isMoblie'=>'0', //是否启用手机版支持,1为支持,0为关闭
        'ICP'=>'京ICP备18033649号-1',
        'tel'=>'4001-047-588',
        'email'=>'Nanbeit@163.com',
        'wexin'=>'Test System',
        'note'=>'',
        'about'=>'南北通实业有限公司',
        'copyright'=>'copyright © 2018-2018 南北通实业有限公司 版权所有',
        'address'=>'中国.北京.朝阳',
        'addressx'=>'万达国际10号楼2层',
        'SEO标题'=>'南北通',
        'SEO关键字'=>'南北通,电子商务',
        'Logo'=>'/Public/manage/images/logo.png',
        ),
    "Jyconfig"=>array(
        'Jyje'=> 1000, //交易金额
        'FxZjSy'=> 300, //分享线直接收益
        'KsZjSy'=> 1000, //开市线直接收益
        'FxJjSy'=> 300, //分享线间接收益
        'KsJjSy'=> 500, //开市线间真收益
        'DtZgje' => 30000, //当日最高收益金额
        'XyCsJe'=> 10000, //信用帐户初始金额
        'userftd'=> 100000, //复投点
        'TxD'=>10000, //提现点
        'Sxf'=>0.15, //提现手续费
        'shop'=>0.20 //商城积分
    ),
    'JsonFilePath'=>'C:\wamp\www\php\Public\Uploads\stock.json', //盘点文件JSON配置
    //'DB_PARAMS'    =>    array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL), //保持字段大小写原样
    /*微信认证登录信息*/
    'wx_appid'=>'wx25da3e6594476ae0',
    'wx_appsecret'=>'ec73fc66c095fbcbe7d3405922a583c8',
    //路由开启
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
    'login'=>'/?a=login&c=User',
),

);