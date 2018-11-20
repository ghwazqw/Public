<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2017/6/24
 * Time: 下午6:14
 */
namespace Home\Behaviors;
use Home\API\ActionAPI;
use Home\API\UserAPI;
use Think\Controller;

class UserBehavior extends BaseBehavior {
    public function run(&$param){
        //echo CONTROLLER_NAME."<br>";
        //echo ACTION_NAME;

        $user=new UserAPI();
        $get_login=C("loginuser");
        //var_export($get_login);

        if (array_key_exists(CONTROLLER_NAME,$get_login) && in_array(ACTION_NAME,$get_login[CONTROLLER_NAME] )){ //判断当前操作是不是在配置列表中
            if (!$user->isLogin()){ //用户登录判断
                redirect('/login', 1, '您还没有登录，正在转入登录页面...');
            }
            else{

                $userinfo=$user->getuser();
                $this->assign("username",$userinfo->user_name);
                $this->assign("userxm",$userinfo->user_xm);
            }
        }else{

        }
        //echo "123";
    }
}