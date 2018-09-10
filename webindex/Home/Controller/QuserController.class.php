<?php
namespace Home\Controller;
use Home\API\HdxxAPI;
use Home\API\QregAPI;
use Home\API\YwzxManageAPI;
use Think\Controller;
use Home\API\UserAPI;
use Home\API\QyzxAPI;
class QuserController extends Controller {
    public function user_reg(){

        if ($_POST){
            $a=new QregAPI();
            $action=I("action");
            if ($action==1){
                $a->ch_user();
            }
            elseif ($action==2){
                $a->ch_txtcode();
            }
            elseif ($action==3){
                $a->add_quser();
                if ($a->actionInfo!="")
                {
                    eval($a->actionInfo);
                }
            }

        }
        else{
            $this->assign("title","中国公路科技成果转化平台|用户注册");
            $this->theme("glxh")->display();
        }


    }
    public function Edit_userinfo(){
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $this->assign("Duser_info",$ii->_dateil_data);
        if ($_POST){
            $ii=new UserAPI();
            $ii->EditUserInfo();
            if ($ii->actionInfo!="")
            {
                eval($ii->actionInfo);
            }

        }
        $this->assign("title","中国公路科技成果转化平台|用户信息编辑");
        $this->theme("glxh")->display();
    }
    public function Edit_userP(){
        $ii=new UserAPI();
        $ii->EditUserPassWord();
        $this->assign("Duser_info",$ii->_dateil_data);
        if ($_POST){
            $ii=new UserAPI();
            $ii->EditUserInfo();
            if ($ii->actionInfo!="")
            {
                eval($ii->actionInfo);
            }

        }
        $this->assign("title","中国公路科技成果转化平台|用户密码修改");
        $this->theme("glxh")->display();
    }
    public function Edit_userguestbook(){

        if ($_POST){
            $ii=new UserAPI();
            $ii->Editguestbook();
            if ($ii->actionInfo!="")
            {
                eval($ii->actionInfo);
            }

        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|平台反馈");
        $this->theme("glxh")->display();
    }
    public function user_login(){

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
        $this->assign("title","中国公路科技成果转化平台|用户登录");
        $this->theme("glxh")->display();
    }

    public function user_cent(){
        //读取当前COOKie信息
        $get_logincook=$_COOKIE['user_info'];
        $get_user_log=unserialize($get_logincook);
        $user_name=$get_user_log->user_name;
        $TableName=M("ywcount_vm");

        //读取全部更新
        $this->_page_count=$count=$TableName->where("gl_cjr='$user_name'")->count();
        $this->_main_data=$TableName->where("gl_cjr='$user_name'")->select(); //主表数据取值完成
        $this->assign("Ywxxdata",$this->_main_data);
        $this->assign("count",$this->_page_count);
        //更新提醒状态
        $updateTable=M("hfxx_vm");
        $where1["gl_cjr"]=array("eq",$user_name);
        $where1["hf_zt"]=array("eq",0);
        $updateTable->hf_zt=1;
        $updateTable->where($where1)->save();
        /*$uret=$updateTable->where($where1)->select();
        var_export($uret);*/


        //读取取可报名的活动信息
        $aa=new HdxxAPI();
        $aa->loadbmdata();
        $this->assign("Hdxx",$aa->_dateil_data);
        //var_export($this->_dateil_data);
        $UserTable=M("qx_user_tb");
        $User=$UserTable->where("user_name='$user_name'")->select();
        //var_export($User);
        $info=20;
        if  ($User[0]['user_zw']!=''){
            $info=$info+16;
        }
        if  ($User[0]['user_dh']!=''){
            $info=$info+16;
        }
        if  ($User[0]['user_sj']!=''){
            $info=$info+16;
        }
        if  ($User[0]['user_yx']!=''){
            $info=$info+16;
        }
        if  ($User[0]['user_lxdz']!=''){
            $info=$info+16;
        }
        $this->assign("info",$info);
        $this->assign("title","中国公路科技成果转化平台|用户中心");
        $this->theme("glxh")->display();


    }
    public function xq_list(){
    	$a= new QyzxAPI();
        $a->djzx_yw();
        
        $this->assign("info_data",$a->_main1_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心");
       
    $this->theme("glxh")->display();

    }
    public function detail(){
    	$a= new QyzxAPI();
    	$a->djxz_detail();
    	$this->assign("meta_data",$a->_meta_data);
        $this->assign("detail_data",$a->_dateil_data);
        $this->assign("main_data",$a->_main_date);
    	$this->theme("glxh")->display();
    }
    public function user_ok(){
        $this->theme("glxh")->display("reg_success");
    }
    public function hybm(){
        $a=new HdxxAPI();
        $a->loadhybmdata();
            $this->assign("Hdxx",$a->_dateil_data);
            $this->assign("Userdata",$a->_user_info);
            $this->assign("count",$a->_page_count);
            $this->assign("Bmxx",$a->_bm_info);
            $this->assign("Chrxx",$a->_chr_info);
        $this->assign("title","中国公路科技成果转化平台|用户中心|会议回执信息填写");
            $this->theme("glxh")->display("");
    }
    public function ChryAdd(){
        $a=new HdxxAPI();
        $a->AddHzxx();
    }
    public function ChrAdd(){
       $a=new HdxxAPI();
        $a->AddChr();
    }
    public function Forgot_Password(){
        if ($_POST){
            $ii=new UserAPI();
            $ii->CheckEmail();
        }
        else{
            $this->theme("glxh")->display("");
        }
    }
    public function Forgot_Pass(){
        $this->theme("glxh")->display("");
    }

   public function rePass(){
       if ($_POST){
        $a=new UserAPI();
        $a->editpass();

       }else{
       $h=I("h");
        if (!$h){
            echo "非法操作";
            exit();
        }else{
            $ii=new UserAPI();
            $ii->reSetPass();
            $this->assign("id",$ii->_keyword);
            echo $ii->pass;
        }
            /*if ($ii->pass=="ok"){*/
            	$this->theme("glxh")->display("");
            /*}
            else{
            	echo "密码重置时间已过，请<a href='/home/Quser/Forgot_Password.html'>重新操作</a>";
            	exit();
            }*/
        }
       
   }

}
