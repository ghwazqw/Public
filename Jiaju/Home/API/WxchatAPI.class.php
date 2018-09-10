<?php
namespace Home\API;
class WxchatAPI
{
    public $_wxapp_id="";
    public $_wxapp_secret="";
    public $_zt="";

    //选择微信信息
    function select_appid(){
        //获取appid和appsecret
        $this->_wxapp_id=C("wx_appid");
        $this->_wxapp_secret=C("wx_appsecret");
    }
    //获取用户信息
    function reauest_info(){
        $appid=C("wx_appid");
        $AppSecret=C("wx_appsecret");
        //获取CODE
        $code=I("code");
        //根据CODE换取access_token
        $get_ac_url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$AppSecret&code=$code&grant_type=authorization_code";
        $ret=file_get_contents($get_ac_url);
        $ret_arr=json_decode($ret,true);
        //根据access_token获取用户信息
        $get_user_url="https://api.weixin.qq.com/sns/userinfo?access_token={$ret_arr['access_token']}&openid=$appid";
        $uinfo=file_get_contents($get_user_url);
        /*session("userdata",$uinfo);
        $userinfo=session("userdata");*/
        $uinfo_arr=json_decode($uinfo,true);
        //提醒用户注册账户 或者绑定用户信息

        //保存用户信息
        $Addtable=M("wxlogin_tb");
        $Addtable->openid=$uinfo_arr['openid'];
        $Addtable->nickname=$uinfo_arr['nickname'];
        $Addtable->sex=$uinfo_arr['sex'];
        $Addtable->province=$uinfo_arr['province'];
        $Addtable->city=$uinfo_arr['city'];
        $Addtable->headimgurl=$uinfo_arr['headimgurl'];
        $Addtable->unionid=$uinfo_arr['unionid'];
        //$Addtable->openid=$uinfo_arr['openid'];
        $uid=$uinfo_arr['unionid'];
        if (!$uid){
            $this->_zt=0;
        }
        else{
            $where['unionid']=array('eq',"$uid");
            $count=$Addtable->where($where)->count();
            //echo $Addtable->_sql();
            if ($count>0){
                echo "该用户已经存在。";
                $this->_zt=0;
            }else{
                $Addtable->add();
                echo "亲爱的".$uinfo_arr['nickname'].",微信信息记录成功";
                $this->_zt=1;
            }
        }
        //初始化用户状态
    }


}