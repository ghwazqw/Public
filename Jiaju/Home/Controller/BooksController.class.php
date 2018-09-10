<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */
namespace Home\Controller;


class BooksController extends PublicController {

    public function _initialize(){
        parent::_initialize();
        parent::_IsAuth();
    }
    public function BooksManage(){

        $this->assign("title","图书管理中心");
        $this->theme("webapps")->display();
    }

}