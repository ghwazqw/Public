<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */
namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\LoginAPI;

class LoginController extends PublicController {
    //登录
    public function login(){
        if (!$_POST){
            exit("非法操作");
        }else{
            $get_UserName = I("Username");
            $a = new LoginAPI();
            $a -> UserLogin();
            $io=new ActionAPI();
            //exit();
            //$info=$a->_info;
            if ($a->actionInfo!="")
            {
                $io->UserLogInfoRecode(99,0,$get_UserName,1); //记录日志
                eval($a->actionInfo);
            }
        }
    }
}