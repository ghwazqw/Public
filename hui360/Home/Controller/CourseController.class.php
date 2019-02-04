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

class CourseController extends PublicController
{

    public function _initialize()
    {
        parent::_initialize();
        //parent::_IsAuth();
    }

    public function index(){
        $this->assign("title","課程信息管理");
        $this->theme("WebApps")->display();
    }


}