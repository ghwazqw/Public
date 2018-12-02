<?php

namespace Home\API;


class ActivitiesAPI
{
    //public $_page_size = "1000"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $actionInfo = ""; //返回要执行的动作
    public $_Msg = "";
    public $_zt = 0;

    //增加报名信息
    function EditActInfo()
    {
        $user=new UserAPI();
        $userinfo=$user->getuser();
        if (!$userinfo->user_name){
            $username=0;
        }else{
            $username=$userinfo->user_name;
        }
        //增加信息
        $AddData = M("activities_tb");  //注意去除前缀
        if (!$AddData->autoCheckToken($_POST)){
            // 令牌验证错误
            return false;
        }else{
            $AddData->name = I("name"); //姓名
            $AddData->emailtel = I("email"); //郵箱/電話
            $AddData->company = I("company"); //公司名稱
            $AddData->message = I("message"); //其他信息
            $AddData->actdate = date('Y-m-d H:i:s',time()); //提交時間
            $AddData->isuser = $username; //是否會員
            $AddData->activitiesid = I("activitiesid"); //參與活動信息
            $ret=$AddData->add();
            if ($ret){
                return true;
            }else{
                return false;
            }
        }
    }
}	
