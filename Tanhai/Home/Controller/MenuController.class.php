<?php
namespace Home\Controller;
use Home\API\ActionAPI;
use Home\API\DelDataAPI;
use Home\API\MenuAPI;
use Home\API\RoleAPI;
use Home\API\TreeAPI;

class MenuController extends PublicController {
    public function _initialize(){
        parent::_initialize();
        parent::_IsAuth();
    }
    //数据读取
    public function index(){

        if ($_POST){
            $id=I("id");
            $ii=new MenuAPI();
            if ($ii->MenuEdit($id)){
                $this->success("菜单信息编辑成功","/menu",1);
            }else{
                $this->error("编辑失败，请检查信息");
            }
        }else{
            $io=new MenuAPI();
            $io->LoadMenuInfo(1);
            $this->assign("MenuInfo",$io->_main_data);
            $this->assign("title","菜单信息管理");
            $this->theme("webapps")->display();
        }

    }
    //加载菜单树
    public function menutree(){
        $Menu=new MenuAPI();
        $Menu->LoadMenuTree();
        $data=$Menu->_main_data;
        $tree=new TreeAPI("id","menu_sjid","children");
        $tree->load($data);
        $treelist=$tree->DeepTree();//所有分类树结构
        echo json_encode($treelist);//查看结果

        //$result = json_decode($treelist, true);
        //echo $result;
    }
    //数据删除
    public function MenuDel(){
        $id=I("id");
        $ii=new ActionAPI();
        $ii->ChId($id);

        $table=I("table");
        $ii=new DelDataAPI();
        $ii->Deltreeinfo($table,$id);
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
        $this->success('权限配置成功','/Menu/RoleMenu',1);
    }

}