<?php
namespace Home\Controller;
use Home\Lib\PasswordHash;
use Think\Controller;
use Home\API\UserAPI;
class UserController extends Controller {
    public function adduser(){
        //增加用户
        if($_POST){
            $a=new UserAPI();
            $a->add_user();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }
        //数组写法
        // $data=array();  //定义数组
       // $data["user_name"]="test";
       // $data["user_pwd"]="123";
       // $data["user_regdate"]=date('Y-m-d h:i:s');
       // $data["user_sfyx"]=1;
       // $ret=$user->add($data);
       // echo $ret;
        $this->theme("50")->display();
    }
    public function U_manage(){
        $ii=new UserAPI();
        $ii->loadmatedata();
        $this->assign("info_data",$ii->_main_data);

        $this->theme("50")->display("User_Manage");
    }
    public function login(){
        /*//加载hash加密密码类
        $ph=new PasswordHash(8, FALSE);
        //需要加密的值
        $correct = '123';
        //加密
        $hash = $ph->HashPassword($correct);
        //输出加密的值
        print 'Hash: ' . $hash . "\n";
        //判断两个值是否一致
        if($ph->CheckPassword("123",$hash))
            echo "正确";*/

       if ($_POST)
       {
       	$a = new UserAPI();
       	$a -> login();
       	if ($a->actionInfo!="")
       	{
       		eval($a->actionInfo);
       	}
       }
       else
       {
       }
       $this->theme("50")->display();

    }
   
}