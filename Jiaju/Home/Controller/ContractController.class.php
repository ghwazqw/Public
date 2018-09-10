<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */
namespace Home\Controller;


use Home\API\ContractAPI;

class ContractController extends PublicController {

    public function _initialize(){
        parent::_initialize();
        parent::_IsAuth();
    }

    //合同信息管理
    public function index(){
        $this->assign("title","合同信息管理");
        $this->theme("webapps")->display();
    }

}