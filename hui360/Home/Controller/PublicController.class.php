<?php
namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\MenuAPI;
use Home\API\UserAPI;
use Think\Controller;
class PublicController extends Controller {
    public function _initialize(){
        //基础信息配置
        $sysconfig = C('SysConfig'); //读取基础配置类
        $SystemName=$sysconfig["SystemName"]; //系统名称
        $Mobblie=$sysconfig["isMoblie"]; //手机端支持启动，
        $logo=$sysconfig["Logo"]; //系统Logo
        $this->assign("sys_title",$SystemName); //系统配置
        $this->assign("logo",$logo); //LOGO输出到模板
        $this->assign("address",$sysconfig["address"]); //地址
        $this->assign("addressx",$sysconfig["addressx"]); //地址
        $this->assign("email",$sysconfig["email"]); //邮箱
        $this->assign("tel",$sysconfig["tel"]); //邮箱
        $this->assign("ICP",$sysconfig["ICP"]); //ICP
        $this->assign("about",$sysconfig["about"]); //关于我们
        $this->assign("copyright",$sysconfig["copyright"]); //版权声明
        $this->assign("Tech",$sysconfig["Tech"]); //技术支持
        $this->assign("date",date('Y-m-d H:i:s',time()));
        $this->assign("SEO_Title",$sysconfig["SEO_Title"]);
        $this->assign("SEO_Keyword",$sysconfig["SEO_Keyword"]);

        //echo json_encode($sysconfig);

        if ($Mobblie==1){  //为1时启动对手机端的支持
            if (ismobile()) {
                //设置默认默认主题为 Mobile
                C('DEFAULT_V_LAYER','Mobile');
            }
        }
        //读取相应的菜单信息
        $Menu=new MenuAPI();
        $Menu->LoadAuthMenuInfo(1);
        $this->assign("MenuInfo",$Menu->_main_data);
        //var_export($Menu->_main_data);
        $Menu->LoadAuthMenuInfo(2);
        $this->assign("MetaInfo",$Menu->_main_data);
        //var_export($Menu->_main_data);
        //读取登录后用户信息
        $user=new UserAPI();
        $user->GetUserInfo();
        $this->assign("username",$user->_username);
        $this->assign("userxm",$user->_userinfo);
        $this->assign("userid",$user->_userid);
        //var_dump();
    }
    //必须权限控制
    public function _IsAuth(){
        //Auth权限控制
        $ii=new ActionAPI();
        if ($ii->ChAuth()){
            //echo "ok";
        }else{
            exit($ii->actionInfo.'权限不足,您可以<a href="javascript:history.go(-1)">后退</a> ，或者返回<a href="#">首页</a>');
            //$this->error($ii->actionInfo."权限不足！","/index/login",3);
        }
    }

}