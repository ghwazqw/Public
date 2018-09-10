<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2017/6/25
 * Time: 上午12:05
 */
namespace Home\Behaviors;
use Think\Controller;
class BaseBehavior extends Controller
{
    function __construct()
    {
        parent::__construct();
        $get_do= trim(I("get.do"));
        if ($get_do!=""){
            method_exists($this,$get_do) && $this->$get_do();
        }
    }
    function logout(){
        setcookie("user_info",null,time()-3600,"/");
        redirect('/', 2, '注销成功，正在跳转...');
        exit();
    }
}