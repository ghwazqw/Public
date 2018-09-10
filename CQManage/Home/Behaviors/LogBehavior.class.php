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

class LogBehavior extends BaseBehavior {
    /*public function run(&$param){
        //echo "日志记录扩展";
        $ii=new UserAPI();
        $ii->GetUserInfo();
        //echo $ii->_username;
        \Think\Log::write($ii->_username.'测试日志信息，这是信息级别，并且实时写入','INFO');
    }*/
}