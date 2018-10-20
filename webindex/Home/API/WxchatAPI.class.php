<?php
namespace Home\API;
class WxchatAPI
{
    public $_wxapp_id="";
    public $_wxapp_secret="";
    public $_zt="";
    public $_username="";
    public $_uid="";
    public $_userinfo="";

    //选择微信信息
    function select_appid(){
        //获取appid和appsecret
        $this->_wxapp_id=C("wx_appid");
        $this->_wxapp_secret=C("wx_appsecret");
    }
    function QqRestinfo($tocken,$appid){
        $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$tocken;
        $str = file_get_contents($graph_url);
        if (strpos($str, "callback") !== false) {
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str = substr($str, $lpos + 1, $rpos - $lpos -1);
        }
        $user = json_decode($str);//存放返回的数据 client_id ，openid
        if (isset($user->error)) {
            echo "<h3>error:</h3>".$user->error;
            echo "<h3>msg :</h3>".$user->error_description;
        }else{
            $user_data_url = "https://graph.qq.com/user/get_user_info?access_token={$tocken}&oauth_consumer_key=$appid&openid={$user->openid}&format=json";
            $user_data = file_get_contents($user_data_url);//获取到的用户信息
            //$this->_userinfo=$user_data;
            $uinfo_arr=json_decode($user_data,true);
            if ($uinfo_arr["gender"]=='男'){
                $sex=1;
            }else{
                $sex=0;
            }
            $sort="QQ";
            $this->TockenUserAdd($user->openid,$uinfo_arr["nickname"],$sex,$uinfo_arr["province"],$uinfo_arr["city"],$uinfo_arr["figureurl"],$user->openid,$sort);

        }
    }
    //封装第三方用户信息增加APP
    function TockenUserAdd($openid,$nickname,$sex,$province,$city,$headimgurl,$unionid,$sort){
        //保存用户信息
        $Addtable=M("wxlogin_tb");
        $Addtable->openid=$openid;
        $Addtable->nickname=$nickname;
        $Addtable->sex=$sex;
        $Addtable->province=$province;
        $Addtable->city=$city;
        $Addtable->headimgurl=$headimgurl;
        $Addtable->unionid=$unionid;
        $Addtable->sort=$sort;
        $uid=$openid;
        $where['openid']=array('eq',"$uid");
        $count=$Addtable->where($where)->count();
        if ($count>0){
            $username=$Addtable->where($where)->getField("user_name");
            if (!$username){
                $this->_uid=$uid;
                $this->_zt=2; //需要绑定用户
            }else{
                $this->_username=$username;
                $this->_zt=100; //绑定成功
            }
        }else{
            $ret=$Addtable->add();
            $this->_uid=$uid;
            $this->_zt=1;
        }
    }
    //获取用户信息
    function reauest_info($sort){
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
        $Addtable->sort=$sort;
        //$Addtable->openid=$uinfo_arr['openid'];
        $uid=$uinfo_arr['openid'];
        if (!$uid){
            exit('信息读取失败，请<a href="/?a=user_login&c=Quser">点击重试</a>');
        }
            $where['openid']=array('eq',"$uid");
            $count=$Addtable->where($where)->count();
            //echo $Addtable->_sql();
            if ($count>0){

                $username=$Addtable->where($where)->getField("user_name");
                if (!$username){
                    $this->_uid=$uid;
                    $this->_zt=2;
                }else{
                    $this->_username=$username;
                    $this->_zt=100;
                }
            }else{
                $ret=$Addtable->add();
                $this->_uid=$uid;
                $this->_zt=1;
            }

        //初始化用户状态
    }

}