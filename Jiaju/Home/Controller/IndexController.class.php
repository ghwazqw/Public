<?php
namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\AppdataAPI;
use Home\API\LoginAPI;
use Think\Controller;

class IndexController extends PublicController {
    public function _initialize(){
        parent::_initialize();
        //parent::_IsAuth();
    }

    public function index(){
        $ii=new AppdataAPI();
        $ii->ServerInfo();
        $this->assign("sysconfig",$ii->_server_info);
        $sysinfo=C("SysConfig");
        $this->assign("sysinfo",$sysinfo);
        //var_dump($sysinfo);
           $this->assign("title","首页");
           $this->theme("webapps")->display();
    }

    public function addToken(){
        $io=new AppdataAPI();
        $appid=$io->GetAppid(12); //生成APPID
        //$appid=$io->_sjm;
        $token=$io->GetRandStr(32); //生成token
        //exit();
        $appkey=$io->GetRandStr(32); //生成appkey
        $ii=new ActionAPI();
        if ($ii->WriteAppkey($appid,$token,$appkey)){
            echo "ok";
        }else{
            echo "error";
        }
    }
    /*public function login(){
        if (!$_POST){
            $this->assign("title","|用户登录");
            $this->theme("webapps")->display();
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
    }*/
    public function VarImg(){
        $ii=new AppdataAPI();
        $ii->Varcode();
    }
    public function rule(){
        $this->assign("title","规则管理");
        $this->theme("webapps")->display();
    }

}