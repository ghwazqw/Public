<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class BdCentAPI
{
    public $_page_size="100"; //每页显示条数
    public $_page_count = ""; //统计数量
    public $_main_data = array();
    public $_dal_data=array();
    public $_jyzt=0;
    public $_userlx="";
    public $_tjr="";
    public $_gxrname="";
    public $_gxrid="";
    public $_gxrtjr="";
    public $_gxrtype="";
    public $_syrname="";
    public $_syrxm="";
    public $_Jjzt=0;

    //读取报单人员信息
    function Myinfo(){
        $Tjm=I("user_tjm");
        $UserTable=M("qx_user_tb");
        $where["user_tjm"]=array("eq",$Tjm);
        $this->_main_data=$UserTable->where($where)->limit(0,1)->select();
        foreach ($this->_main_data as $My){
            $this->_jyzt=$My["user_type"];
            $this->_tjr=$My["user_tjr"];
        }
    }
    //读取分享用户信息
    function FxUserInfo($tjm){
        $Tjm=$tjm;
        $UserTable=M("qx_user_tb");
        $where["user_tjm"]=array("eq",$Tjm);
        $this->_main_data=$UserTable->where($where)->limit(0,1)->select();
        foreach ($this->_main_data as $My){
            $this->_gxrtjr=$My["user_tjr"];
            $this->_gxrname=$My["user_name"];
            $this->_gxrid=$My["id"];
            $this->_gxrtype=$My["user_type"];
        }
    }
    //递归循环出接收人信息
    function SkrUserInfo($gxrid,$xhsl){
        $Qusertable=M("qx_user_tb");
        $userwhere["_string"]="FIND_IN_SET(id,getParLst($gxrid)) and id<$gxrid";
        $this->_main_data=$Qusertable->where($userwhere)->order("id desc")->limit($xhsl)->select();
        foreach ($this->_main_data as $My){
            $this->_gxrtjr=$My["user_tjr"];
            $this->_syrname=$My["user_name"];
            $this->_syrxm=$My["user_xm"];
            $this->_gxrid=$My["id"];
            //$this->_gxrtype=$My["user_type"];
            //echo $this->_syrname;
        }
    }
    //封装直接收款人信息
    function ZjSkrSk($gxrtype,$syusername,$syrxm,$gxrname){
        /*读取收益配置信息*/
        $jy=C("Jyconfig");
        $kszjje=$jy["KsZjSy"];  //开市直接收益
        $fxzjje=$jy["FxZjSy"];  //分享直接收益
        if ($gxrtype==1){ //分享线用户时
            echo $syrxm."受益:".$fxzjje;
            $this->_Jjzt=0;
        }else{ //开市线用户时
            echo $syrxm."受益:".$kszjje;
            $this->_Jjzt=1;
        }
        //exit();
        /*读取收益人现金帐户信息*/
        $cattable=M("usercat_tb");
        $catwhere["cat_username"]=array("eq",$syusername);
        $catwhere["cat_type"]=array("eq",1); //现金帐户类型为1
        $xjdqje=$cattable->where($catwhere)->getField("cat_dqje");
        $xjzt=$cattable->where($catwhere)->getField("cat_zt");
        if ($gxrtype==1){ //分享线用户时
            $clje=$xjdqje+$fxzjje;
            $jyje=$fxzjje;
        }else{ //开市线用户时
            $clje=$xjdqje+$kszjje;
            $jyje=$kszjje;
        }
        $cattable->cat_dqje=$clje;
        $ret=$cattable->where($catwhere)->save();
        //echo $cattable->_sql();
        if ($ret>0){
            $this->ZjXy($gxrname,$jyje); /*在保存成功的情况下减去贡献人信用帐户信息*/
            $this->sylog($syusername,$gxrname,$jyje); //受益记录保存
        }

    }
    //贡献人信用帐户变化封装
    function ZjXy($gxrusername,$jyje){
        $CatTable=M("usercat_tb");
        $where["cat_username"]=array("eq",$gxrusername);
        $where["cat_type"]=array("eq",2);
        $catzt=$CatTable->where($where)->getField("cat_zt"); //读取信用帐户状态
        $catdqje=$CatTable->where($where)->getField("cat_dqje"); //读取信用帐户当前金额
        if ($catzt==0){ //如帐户未启用
            //exit("帐户未启用");
        }
        //保存金额
        if (!$jyje){
            $jyje=0;
        }
        $dqje=$catdqje-$jyje;
        if ($dqje<500){ //金额过低的处理方式
        }

        $CatTable->cat_dqje=$dqje;
        $ret=$CatTable->where($where)->save();
        return $ret;
    }
    //收益信息封装受益记录封装
    function sylog($syr_name,$syr_gxrname,$syr_gxje){
        $sytable=M("syinfo_tb");
        $sytable->syr_name=$syr_name;
        $sytable->syr_gxje=$syr_gxje;
        $sytable->syr_gxrname=$syr_gxrname;
        $sytable->syr_sj=date('Y-m-d H:i:s',time()); //后端获取日期;
        $sytable->syr_day=date('Y-m-d',time());
        $sytable->add();
    }


}