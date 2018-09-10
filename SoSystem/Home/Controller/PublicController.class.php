<?php
namespace Home\Controller;
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
        $this->assign("date",date('Y-m-d H:i:s',time()));

        //echo json_encode($sysconfig);

        if ($Mobblie==1){  //为1时启动对手机端的支持
            if (ismobile()) {
                //设置默认默认主题为 Mobile
                C('DEFAULT_V_LAYER','Mobile');
            }
        }
    }

}