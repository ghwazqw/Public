<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */
namespace Home\Controller;

use Home\API\AppdataAPI;

class ManageController extends PublicController {

    public function _initialize(){
        parent::_initialize();
        //parent::_IsAuth();
    }
    public function index(){
        $ii = new AppdataAPI();
        $ii->ServerInfo();
        $this->assign("sysconfig", $ii->_server_info);
        $sysinfo = C("SysConfig");
        $this->assign("sysinfo", $sysinfo);
        //var_dump($sysinfo);
        $this->assign("title", "管理系統首頁");
        $this->theme("WebApps")->display();
    }
}