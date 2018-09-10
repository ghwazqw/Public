<?php
namespace Home\Controller;

use Home\API\InfostatAPI;
use Think\Controller;
class ConfigController extends Controller {

    public function Config(){
        $ii=new InfostatAPI();
        $ii->ServerInfo();
        $sysconfig = C('SysConfig'); //读取基础配置类
        $this->assign("serverinfo",$ii->_ServerInfo); //读取服务器信息

        $ii->MaxLoginInfo();
        $this->assign("LoginInfo",$ii->_dateil_data); //读取最后一次登录信息
        //var_export($ii->_dateil_data);
        $this->assign("sysconfig",$sysconfig);
        $this->theme("manage")->display();
    }
}
