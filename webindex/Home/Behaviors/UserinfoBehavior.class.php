<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2017/6/24
 * Time: 下午6:14
 */
namespace Home\Behaviors;
use Home\API\UserAPI;
use Think\Controller;

class UserinfoBehavior extends BaseBehavior {
    public function run(&$param){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $get_login=c("login_info");
        //echo $globar_user->user_lx."<br />";
        //var_export($get_login) ;
        if (array_key_exists(CONTROLLER_NAME,$get_login) && in_array(ACTION_NAME,$get_login[CONTROLLER_NAME] )){//判断当前操作是不是在配置列表中
            if ($globar_user->user_xm=="" || $globar_user->user_lx!="q"){
                redirect('/', 2, '无此权限，无法操作即将返回首页');
            }
        }/*else{
            echo $globar_user->user_lx;
        }*/

}

}