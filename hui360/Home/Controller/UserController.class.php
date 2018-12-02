<?php
namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\DelDataAPI;
use Home\API\LoginAPI;
use Home\API\UserAPI;

class UserController extends PublicController {
    public function _initialize(){
        parent::_initialize();
        //parent::_IsAuth();
    }
    public function index(){
           $this->theme("web")->display("");
    }
    //角色管理
    public function RoleManage(){
        $this->assign("title","角色信息管理");
        $this->theme("webapps")->display("");
    }
    //删除角色
    public function RoleDel($id){
        $io=new DelDataAPI();
        $table="auth_group";
        $subtable="auth_group_access";
        $lx="group_id";
        if ($io->DelSubInfo($table,$subtable,$id,$lx)){
            return true;
        }else{
            return false;
        }
    }
    //无效.有效操作
    public function RoleStatus(){
        $id=I("id");
        $status=I("status");
        //exit($status);
        $ii=new ActionAPI();
        $ii->ChId($id);
        //$ii->ChId($status);
        $io=new DelDataAPI();
        if ($io->Status($id,$status,"auth_group")){
            echo "200";
            return true;
        }else{
            echo "500";
            return false;
        }
    }
    //角色解析菜单权限列表
    public function RoleMenu(){
        $ii=new UserAPI();
        $ii->LoadStatusRole();
        $this->assign("RoleData",$ii->_main_data);

        $ii->LoadRoleMenuData();
        $this->assign("class_meta_data",$ii->_class_data); //二级菜单
        //var_export($ii->_class_meta_data);
        $this->assign("mtea_data",$ii->_class_meta_data); //三级菜单

        $this->assign("title","角色权限管理");
        $this->theme("webapps")->display("");
    }
    //获取角色下属菜单信息
    public function RoleAuthMenu(){
        $ii=new UserAPI();
        $ii->RoleAuthMenu();
        $count=$ii->_page_count;
        if ($count>0){
            $this->ajaxReturn($ii->_main_data,'JSON');
        }
    }
    //用户信息列表
    public function UserManage(){
        $this->assign("title","管理员信息管理");
        $this->theme("webapps")->display("");
    }
    //用户登录信息列表
    public function UserLogList(){
        $this->assign("title","管理员登录日志查询");
        $this->theme("webapps")->display("");
    }
    //检测手机号是否存在
    public function chmob(){
        $mob=I("mobile");
        $ii=new UserAPI();
        if ($ii->chmob($mob)){
            echo 1;
        }else{
            echo 0;
        }
    }
    //用户注册
    public function register(){
        if ($_POST){
            $ii=new UserAPI();
            if ($ii->reg()){
                echo $ii->_Msg;
            }else{
                echo $ii->_Msg;
            }
        }else{
            session("mobcode",null);
            $this->assign("title","用户注册");
            $this->theme("webapps")->display("");
        }
    }
    //前端用户登录
    public function Qlogin(){
        $this->assign("title","用户登录");
        $this->theme("webapps")->display("");
    }
    //后端用户登录
    public function login(){
        if (!$_POST){
            $this->assign("title","|用户登录");
            $this->theme("webapps")->display();
        }else {
            $get_UserName = I("Username");
            $a = new LoginAPI();
            $a -> UserLogin();
            $io=new ActionAPI();
            //exit();
            //$info=$a->_info;
            if ($a->actionInfo!="")
            {
                $io->UserLogInfoRecode(99,0,$get_UserName,1); //记录日志
                eval($a->actionInfo);
            }
        }
    }
}