<?php
namespace Home\Controller;
use Home\API\ActionAPI;
use Home\API\DelDataAPI;
use Home\API\ExcelAPI;
use Home\API\PinyinAPI;
use Home\API\RoleAPI;
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
        $this->theme("manage")->display();
    }
    /*public function U_manage(){
        $ii=new UserAPI();
        $ii->loadmatedata();
        $this->assign("info_data",$ii->_main_data);
        //读取角色信息
        $io=new RoleAPI();
        $io->loadmatedata();
        $this->assign("RoleData",$io->_main_data);

        $this->theme("manage")->display("User_Manage");
    }*/
    public function U_manage(){
        //增加信息
        if ($_POST){
            $a=new UserAPI();
            $a->AddRyxxData(); //调用增加信息实体类
        }
        //读取主表信息
        $ii=new UserAPI();
        $ii->loadRyuandata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("comp",$ii->_comp) ;
        $this->assign("zt",$ii->_zt);
        $this->assign("yh",$ii->_yh);
        //读取角色信息
        $io=new RoleAPI();
        $io->loadmatedata();
        $this->assign("RoleData",$io->_main_data);
        //var_export($io->_main_data);
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);

        //读取组织机构信息
        $id=I("id");
        if ($id!=""){
            $io=new UserAPI();
            $io->loadmetaclass();
            $this->ajaxReturn($io->_class_meta_data,'JSON');
        }
        else{
            $ii->loadcompdata();
            $this->assign("class_info",$ii->_class_data);
            $this->theme("manage")->display("Ryuser_Manage");
        }
    }
    //系统登录
    public function login(){
        if ($_POST){
            $get_UserName = I("Username");
            $a = new UserAPI();
            $a -> UserLogin();
            //exit();
            $info=$a->_info;
            $io=new ActionAPI();
            if ($info!="OK"){
                $io->UserLogInfoRecode(99,0,$get_UserName,1);
                $this->error("$info",'/?a=login&c=User',2);
            }else{
                $io->UserLogInfoRecode(99,1,$get_UserName,1);
                $this->success('系统登录成功,正在跳转...','/',1);
            }
        }else{
            $ic=new UserAPI();
            $ic->loadcompdata();
            $this->assign("CompInfo",$ic->_class_data);
            if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE")){
                $this->theme("manage")->display();
            }else{
                $this->theme("manage")->display("login_new");
            }

        }
    }
    //验证验证码
    public function ChVer(){
        $ii=new UserAPI();
        $ii->VerCh();
    }
    public function role_manage(){
        /*$ii=new RoleAPI();
        $ii->loadmatedata();
        //读取表单数据
        $this->assign("info_data",$ii->_main_data);
        $this->assign("count",$ii->_page_count);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("keyword",$ii->_keyword);*/
        $io=new RoleAPI();
        $io->operation();
        //读取操作数据
        $this->assign("oper_data",$io->_oper_data);
        $aa=new RoleAPI();
        $aa->D_oper();
        $this->assign("d_oper_data",$aa->_oper_data);
        //提交数据
        if ($_POST)
        {
            $a = new RoleAPI();
            $a->AddRole();
            $this->success('角色增加成功','/Home/User/role_manage',1);
        }else{
            $this->theme("manage")->display("RoleNewManage");
        }
    }
    public function Delrole(){
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/Home/User/role_manage',1);
        }else{
            $this->error('信息删除失败','/Home/User/role_manage',1);
        }
    }
    public function EditRole(){
        $ii=new RoleAPI();
        $ii->EditRole();
        if ($ii->_info=="OK"){
            $this->success('信息编辑成功','/Home/User/role_manage',1);
        }else{
            $this->error('信息编辑失败','/Home/User/role_manage',1);
        }
    }
    public function expRole(){
        $ii=new RoleAPI();
        $ii->expExcel();
    }
    public function Ryuan_manage(){
        //增加信息
        if ($_POST){
            $a=new UserAPI();
            $a->AddRyxxData(); //调用增加信息实体类
        }
        //读取主表信息
        $ii=new UserAPI();
        $ii->loadRyuandata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("comp",$ii->_comp) ;
        $this->assign("zt",$ii->_zt);
        //读取角色信息
        $io=new RoleAPI();
        $io->loadmatedata();
        $this->assign("RoleData",$io->_main_data);
        //var_export($io->_main_data);
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);

        //读取组织机构信息
        $id=I("id");
        if ($id!=""){
            $io=new UserAPI();
            $io->loadmetaclass();
            $this->ajaxReturn($io->_class_meta_data,'JSON');
        }
        else{
            $ii->loadcompdata();
            $this->assign("class_info",$ii->_class_data);
            $this->theme("manage")->display();
        }

    }
    function EditRyinfo(){
        $ii=new UserAPI();
        $ii->EditRyxxData();
        $this->success('人员信息更新成功','/home/user/ryuan_manage',1);
    }
    /*调用拼音类转换用户名信息*/
    public function RyPy(){
        $pystr=I("xm");
        $pinyin=new PinyinAPI(); //调用 拼音转换类
        $username=$pinyin->getPinyin($pystr);
        if ($username==""){
            $username=$pinyin->getFirstChar($pystr);
        }
        //echo $username;
        $ii=new UserAPI();
        $ii->UserDal($username);
        if ($ii->_page_count==0){
            echo $username;
        }else{
            echo $username."01";
        }
    }
    //增加用户
    public function UserAdd(){
        $ii=new ActionAPI();
       $Add=new UserAPI();
        $user_name=I("user_name");
       $Add->add_user();
       if ($Add->_zt){
           $ii->UserLogInfoRecode(90,1,$user_name);
           $this->success('用户增加成功','/Home/user/u_manage',1);
       }else{
           $ii->UserLogInfoRecode(90,0,$user_name);
           $this->error('用户增加失败');
       }
    }
    //增加用户用户
    public function Useredit(){
        $edit=new UserAPI();
        $edit->Useredit();
    }
    //以json的形式获取用户信息
    public function UserInfo(){
        $ii=new UserAPI();
        $ii->loadmatedata();
        //$this->assign("info_data",$ii->_main_data);
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //删除用户信息
    function delinfo(){
        $clear=new UserAPI();
        $clear->ClearUser();
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/Home/user/u_manage',0);
        }else{
            $this->error('信息删除失败','/Home/user/u_manage',0);
        }
    }
    //重置密码
    function repass(){
        $re=new UserAPI();
        $re->RePass();
        if ($re->_info=="OK"){
            $this->success('密码重置成功，当前密码为：123456，请记录。','/Home/user/u_manage',3);
        }else{
            $this->error('信息删除失败','/Home/user/u_manage',0);
        }
    }
    //无效/有效操作
    function sfyx(){
        $act=new UserAPI();
        $act->UserSfyx();
    }
    //修改密码
    function Repassword(){
        if ($_POST){
            $a=new UserAPI();
            $a->EditUserPassWord();
            if ($a->_info==0){
                $this->error('原密码输入错误。','',1);
                exit();
            }elseif ($a->_info=1){
                $this->success('密码修改成功。','/Home/user/Repassword',1);
            }
        }else{
            $this->theme("manage")->display();
        }

    }
    //读取人员日志信息
    public function RyLog(){
        $ii=new UserAPI();
        $ii->RyLog();
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //获取角色下属菜单信息
    public function RoleMenu(){
        $ii=new RoleAPI();
        $ii->RoleMenu();
        $count=$ii->_page_count;
        if ($count>0){
            $this->ajaxReturn($ii->_main_data,'JSON');
        }
    }
    //读取当前用户信息
    public function getuserinfo(){
        $ii=new UserAPI();
        $ii->GetUserInfo();
    }
    public function SelUser(){
        $ii=new UserAPI();
        $ii->getUsername();
        $this->ajaxReturn($ii->_main_data,'json');
    }

    //用户状态改变
    public function actuser(){
        $id=I("id");
        $io=new ActionAPI();
        $io->ChId($id);

        //读取当前操作用户信息
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $get_UserName=$ii->_username;

        $sfyx=I("sfyx");
        $act=new UserAPI();
        $act->UserZt($id,$sfyx);
        $log=new ActionAPI(); //日志记录类读取
        if ($act->_zt>0){
            if ($sfyx==0){ //写入日志
                $log->UserLogInfoRecode(89,1,$get_UserName,1);
            }else{
                $log->UserLogInfoRecode(88,1,$get_UserName,1);
            }
            $this->success('操作成功。','/Home/user/U_manage',1);
        }else{
            if ($sfyx==0){ //写入失败日志
                $log->UserLogInfoRecode(89,0,$get_UserName,1);
            }else{
                $log->UserLogInfoRecode(88,0,$get_UserName,1);
            }
            $this->error('操作失败，请重试。','/Home/user/U_manage',3);
        }
    }
}
