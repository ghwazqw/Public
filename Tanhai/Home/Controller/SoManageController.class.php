<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */

namespace Home\Controller;


use Home\API\ActionAPI;
use Home\API\DelDataAPI;
use Home\API\ProductAPI;
use Home\API\TreeAPI;
use Home\API\UserAPI;

class SoManageController extends PublicController
{

    public function _initialize()
    {
        parent::_initialize();
        parent::_IsAuth();
    }

    //分类信息管理
    public function orderManage()
    {
        $io = new ProductAPI();
        $io->LoadSortInfo(1);
        $this->assign("MenuInfo", $io->_main_data);
        $this->assign("title", "订单管理");
        $this->theme("webapps")->display();
    }

}