<?php
return array(
    //上传文件配置表
    'maxSize'    =>    3145728,  //图片大小
    'rootPath' => './', //根文件目录
    'exts' => array('jpg', 'gif', 'png', 'jpeg','pdf'), //上传文件类型
    'savePath'  => 'Public/Uploads/', //保存文件子路径
    'autoSub'  =>     true,
    'subName'    =>    array('date','Ymd'), //文件名命名

);