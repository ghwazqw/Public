<?php
namespace Home\Controller;
use Home\API\DelDataAPI;
use Home\API\MenuAPI;
use Home\API\RoleAPI;
use Think\Controller;

class MenuController extends Controller {
    //数据读取
    public function index(){
        $ii= new MenuAPI();
        $ii->LoadMenuData();
        $this->assign("class_data",$ii->_class_data); //主分类数据
        $this->assign("class_mtea_data",$ii->_class_meta_data); //二级菜单
        $this->assign("mtea_data",$ii->_dateil_data); //三级菜单
        if ($_POST)
        {
            $a = new MenuAPI();
            $a->MenuAdd();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }
        $this->theme("manage")->display();
    }
    //数据删除
    public function MenuDel(){
        $ii=new DelDataAPI();
        $ii->Deltreeinfo();
    }
    //数据编辑
    public function MenuEdit(){
        $ii=new MenuAPI();
        $ii->MenuEdit();
    }
    //读取角色菜单
    public function RoleMenu(){
        $ii=new RoleAPI();
        $ii->loadmatedata();
        //读取表单数据
        $this->assign("info_data",$ii->_main_data);
        $this->assign("count",$ii->_page_count);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("keyword",$ii->_keyword);

            $io= new MenuAPI();
            $io->LoadMenuData();
            $this->assign("class_meta_data",$io->_class_meta_data); //二级菜单
            //var_export($io->_class_meta_data);
            $this->assign("mtea_data",$io->_dateil_data); //三级菜单
            $this->assign("rolename",$io->actionInfo);

        $this->theme("manage")->display("RoleMenuEdit");
    }
    //保存角色菜单权限
    public function EditRoleMenu(){
        $ii=new MenuAPI();
        $ii->EditRoleMenu();
        $this->success('权限配置成功','/Home/Menu/RoleMenu',1);

    }
}