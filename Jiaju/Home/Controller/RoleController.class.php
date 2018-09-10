<?php
namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\DelDataAPI;
use Home\API\UserAPI;

class RoleController extends PublicController {
    public function _initialize(){
        parent::_initialize();
        //parent::_IsAuth();
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
    //保存角色菜单权限
    public function EditRoleMenu(){
        $ii=new UserAPI();
        $ii->EditRoleMenu();
        $this->success('权限配置成功','/User/RoleMenu',1);

    }

}