<?php
return array(
    'DEFAULT_FILTER' => 'strip_tags,htmlspecialchars', //过滤函数
    'URL_MODEL'=>2, //增除index.php必须
    'URL_HTML_SUFFIX' =>'.html', //静态HTML访问
    'TMPL_ACTION_ERROR' => 'manage:action', //配置操作错误模板
    'TMPL_ACTION_SUCCESS' => 'manage:action', //配置执行成功模板
    'ENCRYPT_COOKIE_KEY'=>'nanbeit1024', //加密密钥配置
    //'DB_PARAMS'    =>    array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL), //保持字段大小写原样
    'TAGLIB_BUILD_IN'       =>  'Cx,Common\Tag\My',   //加载自定义标签

    //***********************************SESSION设置**********************************
    'SESSION_OPTIONS'         =>  array(
        'name'                =>  'Code',                    //设置session名
        'expire'              =>  3600,                         //SESSION保存3600秒
        'use_trans_sid'       =>  1,                               //跨页传递
        'use_only_cookies'    =>  0,                               //是否只开启基于cookies的session的会话方式
    ),

    //数据库配置类
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'hui360', // 用户名
    'DB_PWD'    => 'hui360', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'pt_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=47.93.18.121;dbname=hui360;charset=utf8',
    /*//数据库配置类
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'kxb', // 用户名
    'DB_PWD'    => 'kxb123456', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'Shang_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=47.93.18.121;dbname=kxb;charset=utf8',*/

    /*//数据库配置类
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_USER'   => 'nanbt', // 用户名
    'DB_PWD'    => 'nanbt', // 密码
    'DB_PORT'   => 3306,   //端口号
    'DB_PREFIX' => 'pt_', // 数据库表前缀
    'DB_DSN'    => 'mysql:host=39.107.254.210;dbname=nanbt;charset=utf8',
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
    'LOAD_EXT_CONFIG' => 'user', //用户登录扩展
    "SysConfig"=>array(
        'SystemName'=>'網天下',
        'isMoblie'=>'0', //是否启用手机版支持,1为支持,0为关闭
        'ICP'=>'',
        'tel'=>'+886（2）2608-2656',
        'email'=>'Service@net2cc.com',
        'wexin'=>'none',
        'note'=>'',
        'about'=>'網天下',
        'copyright'=>'copyright © 2010-2019 <a href="/">Net2cc.Com</a> 版权所有',
        'Tech'=>'網天下',
        'address'=>'台灣.台北',
        'addressx'=>'承德路4段327號11樓',
        'SEO_Title'=>'網天下',
        'SEO_Keyword'=>'網天下,你我流通平台,指尖上的流水,產業互聯網化+IP社群經濟+易物變現,鄭玖鏮,供應鏈管理,節稅,牧者,作者,同工,基督,國度,號角雲,李正一,鄭玖鏮,橄欖基金會,華宣出版社,基督生命,基督論壇報,,基督教今日報,以琳書坊,校園,香港天道,
        華宣,OMO,google',
        'Logo'=>'/Public/hui360/images/logo.png',
        ),



    /*微信认证登录信息*/
    'wx_appid'=>'wxddf6d906e5dd86f8',
    'wx_appsecret'=>'ec73fc66c095fbcbe7d3405922a583c8',

    /*腾讯短信信息配置*/
    "Tx_sms"=>array(
        'Sms_appid'=>'1400097559', //appid
        'Sms_appkey'=>'9bd9cfe28446a10771fa48c9e907e98e', //appkey
        'random'=>54322, //五位随机数
        'tpl_id'=>138099, //短信内容模板(非签名)ID
        'sign'=>'中路汇' //短信签名

    ),
    /*apptoken开关*/
    "token_switch"=>"0", //0为关闭,1为开启

    /*cooker 加密KEY配置*/
    "cookkey"=>"ghwazqw",

    //路由开启
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
    'login'=>'/user/login',
        //资讯处理
        //'newslist'=>'/restful/newslist', //资讯列表
        //'newssortlist'=>'/restful/newssortlist', //资讯分类列表

    ),
    //表单token验证
    'TOKEN_ON'      =>    true,  // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true
    //AUTH权限认证
    'AUTH_CONFIG'=>array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'pt_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'pt_auth_group_access', //用户组明细表
        'AUTH_RULE' => 'pt_auth_rule', //权限规则表
        'AUTH_USER' => 'pt_qx_user_tb',//用户信息表
    ),
    );