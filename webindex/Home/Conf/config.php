<?php
return array(
    'DEFAULT_FILTER'        => 'strip_tags,htmlspecialchars', //���˺���
    'URL_MODEL'=>2,
    'URL_HTML_SUFFIX' =>'.html', //��̬HTML����

    //���ݿ�������
    'DB_TYPE'   => 'mysql', // ���ݿ�����
    'DB_USER'   => 'glxh', // �û���
    'DB_PWD'    => 'glxh', // ����
    'DB_PORT'   => 3306,   //�˿ں�
    'DB_PREFIX' => 'gl_', // ���ݿ��ǰ׺
    'DB_DSN'    => 'mysql:host=123.59.105.68;dbname=glxh;charset=utf8',
    /*'DB_TYPE'   => 'mysql', // ���ݿ�����
    'DB_USER'   => 'glxhfine_f', // �û���
    'DB_PWD'    => 'CC@CO7DKy6', // ����
    'DB_PORT'   => 3306,   //�˿ں�
    'DB_PREFIX' => 'gl_', // ���ݿ��ǰ׺
    'DB_DSN'    => 'mysql:host=103.60.223.6;dbname=glxhfine;charset=utf8',*/
    //'LOAD_EXT_CONFIG' => 'Huser', //�û���¼����
    'LOAD_EXT_CONFIG' => 'Redis_config', //redis����������
    'LOAD_EXT_CONFIG' => 'user', //ǰ���û���¼
    //ͼƬ�ϴ�
    "uploadfile"=>array('maxSize'=> 3145728,
        'rootPath'=> './',
        'savePath'  => 'Public/Uploads/',
        'exts'=>array('jpg', 'gif', 'png', 'jpeg','pdf'),
        'autoSub'  => true,
        'subName'    =>    array('date','Ymd'),
        'thumb' => true, //��������ͼ
        //������Ҫ��������ͼ���ļ���׺
        'thumbPrefix' => 'm_,s_', //������������ͼ
        //��������ͼ�����
        'thumbMaxWidth' => array('400,100'),
         //��������ͼ���߶�
         'thumbMaxHeight'=> array('400,100'),
    ),
    //�ļ��ϴ�
    "up_file"=>array('maxSize'=> 3145728,
        'rootPath'=> './',
        'savePath'  => 'Public/Uploads/',
        'exts'=>array('rar', 'doc', 'docx', 'ppt','pptx','pdf'),
        'autoSub'  => true,
        'subName'    =>    array('date','Ymd'),
        //'thumb' => true, //��������ͼ
        //������Ҫ��������ͼ���ļ���׺
        //'thumbPrefix' => 'm_,s_', //������������ͼ
        //��������ͼ�����
        //'thumbMaxWidth' => array('400,100'),
        //��������ͼ���߶�
        //'thumbMaxHeight'=> array('400,100'),
    ),
    // �����ʼ����ͷ�����
    'MAIL_HOST' =>'smtp.163.com',//smtp������������
    'MAIL_SMTPAUTH' =>TRUE, //����smtp��֤
    'MAIL_USERNAME' =>'ghwzln@163.com',//���������
    'MAIL_FROM' =>'ghwzln@163.com',//�����˵�ַ
    'MAIL_FROMNAME'=>'�й���·�Ƽ��ɹ�ת��ƽ̨',//����������
    'MAIL_PASSWORD' =>'ghwytr3530',//��������
    'MAIL_CHARSET' =>'utf-8',//�����ʼ�����
    'MAIL_ISHTML' =>TRUE, // �Ƿ�HTML��ʽ�ʼ�
    /*΢����֤��¼��Ϣ*/
    'wx_appid'=>'wxddf6d906e5dd86f8',
    'wx_appsecret'=>'ec73fc66c095fbcbe7d3405922a583c8',

         //·�ɿ���   
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
    'login'=>'/?a=login&c=User',
),

);