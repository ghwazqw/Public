<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class LoginAPI
{
    public $_info="";
    public $actionInfo="";
    public $_Msg="";
    //封装前端用户登录
    function QuserLogin($mob){
        $get_mob=$mob; //手机号
        $get_UserName = I("Username","","/^\w{3,20}$/"); //接收用户名信息
        $get_email=I("email"); //电子邮箱
        if (!$get_mob && !$get_UserName && !$get_email){
            //$this->_Msg="信息输入错误";
            return false;
        }else{
            $ip = get_client_ip(); //获取客户端IP
            $Table=M("user_tb");
            //$where["user_name"]=array("eq",$get_UserName);
            $where["user_moblie"]=array("eq",$get_mob);
            //$where["user_email"]=array("eq",$get_email);
            $where['_logic']='OR';
            $count=$Table->where($where)->count();
            $ret=$Table->where($where)->select();
            //echo $Table->_sql();
            if ($count!=1){
                //$this->_Msg="该用户存在错误，请重试";
                return false;
            }else{
                $Quse_log=new \stdClass();
                $Quse_log->user_id=$ret[0]["id"];
                $Quse_log->user_name=$ret[0]["user_name"];
                $Quse_log->user_xm=$ret[0]["user_xm"];
                $Quse_log->user_moblie=$ret[0]["user_moblie"];
                $Quse_log->user_email=$ret[0]["user_email"];
                setcookie("Quse_info",DxydEncrypt(serialize($Quse_log),C("cookkey")),time()+3600*12,"/");
                return true;
            }

        }
    }
    //封装编写用户登录
    function UserLogin(){
        $get_UserName = I("Username","","/^\w{3,20}$/"); //接收用户名信息
        $get_UserPwd = I("textPwd","","/^\w{3,20}$/");  //接收密码
        $get_sj=I("post.sj");

        $userinfo=M("qx_user_tb");

        if (!$userinfo->autoCheckToken($_POST)){
            $io=new ActionAPI();
            $io->UserLogInfoRecode(500,0,$get_UserName,1);
            //exit("您的相关信息我们已经获取，请不要试图非法操作!");
            $this->actionInfo='{$this->assign("errorInfo","认证失败非法操作");}';
            //exit();
        }else{
            $ip = get_client_ip(); //获取客户端IP
            //echo $get_UserName;
            if (!$get_UserName || !$get_UserPwd ){
                $this->_info="信息填写不完整,请检查!";
                //$this->actionInfo='{$this->assign("errorInfo","信息填写不完整,请检查");}';
                $this->LoginLog("$get_UserName","$ip","Error","Info Error");
                //exit();
            }else{
                $result=M("qx_user_tb")->where("user_name='".$get_UserName."' ")->limit(1)->select(); //取出用户信息
                if ($result && count($result)==1){ //唯一用户值
                    //对比密码
                    $user_pwd=$result[0]["user_pwd"];
                    $ph=new PasswordHash(8, FALSE);
                    $UserSfyx=$result[0]["user_sfyx"]; //读取当前用户是否有效信息
                    //echo $UserSfyx;
                    //exit();
                    if ($ph->CheckPassword($get_UserPwd,$user_pwd) && $UserSfyx==1){
                        //$this->actionInfo='{$this->assign("sussInfo","登录成功！");}';
                        $use_log=new \stdclass();
                        $use_log->user_id=$result[0]["id"];
                        $use_log->user_name=$get_UserName;
                        $use_log->user_xm=$result[0]["user_xm"];
                        $use_log->user_role=$result[0]["user_role"];
                        $use_log->role_id=$result[0]["user_roleid"];
                        $use_log->user_comp=$result[0]["user_comp"];
                        //echo "验证成功";
                        if ($get_sj!=""){
                            setcookie("user_info",DxydEncrypt(serialize($use_log),C("cookkey")),time()+3600*12*7,"/");
                        }
                        else{
                            setcookie("user_info",DxydEncrypt(serialize($use_log),C("cookkey")),time()+3600*12,"/");

                        }
                        $this->LoginLog("$get_UserName","$ip",'Success','Login Success'); //用户登录日志保存
                        //$this->_info="OK";
                        redirect('/',2, '登录成功,正在跳转...');
                    }else{
                        //$this->actionInfo='{$this->assign("errorInfo","密码错误！");}';
                        //$this->_info="密码错误或用户无效";
                        $this->actionInfo='{$this->assign("errorInfo","密码错误或用户无效");}';
                        $this->LoginLog("$get_UserName","$ip",'Error','Password Error/Invalid user'); //用户登录日志保存
                        //exit();
                    }
                }else{
                    //$this->_info="无此用户,请检查";
                    $this->actionInfo='{$this->assign("errorInfo","无此用户,请检查");}';
                    $this->LoginLog("$get_UserName","$ip",'Error','Without this user'); //用户登录日志保存
                }
            }
        }


    }
    //系统登录日志API(调用存储过程)
    function LoginLog($get_UserName,$ip,$zt,$info){
        $model = M("");
        $sql = "call sp_user_login('{$get_UserName}','$zt','$ip','$info')";
        $ref = $model -> query($sql);
    }

}

?>