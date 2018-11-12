<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */

namespace Home\Controller;


use Home\API\ActionAPI;
use Home\API\DelDataAPI;
use Home\API\ProductAPI;
use Home\API\TreeAPI;
use Home\API\UserAPI;

class ProductController extends PublicController
{

    public function _initialize()
    {
        parent::_initialize();
        //parent::_IsAuth();
    }

    //分类信息管理
    public function SortManage()
    {
        $io = new ProductAPI();
        $io->LoadSortInfo(1);
        $this->assign("MenuInfo", $io->_main_data);
        $this->assign("title", "产品分类信息管理");
        $this->theme("webapps")->display();
    }

    //加载分类树
    public function sorttree()
    {
        $Menu = new ProductAPI();
        $Menu->LoadSortTree();
        $data = $Menu->_main_data;
        $tree = new TreeAPI("id", "sort_sjid", "children");
        $tree->load($data);
        $treelist = $tree->DeepTree();//所有分类树结构
        echo json_encode($treelist);//查看结果
    }

    //数据删除
    public function SortDel()
    {
        $id = I("id");
        $ii = new ActionAPI();
        $ii->ChId($id);

        $table = I("table");
        $ii = new DelDataAPI();
        $where["sort_sjid"] = array("eq", $id);
        $ii->DelTreeNewInfo($table, $id, $where);
    }

    //分级规格模板
    public function TplManage()
    {
        $jb=1;
        $ii=new ProductAPI(); //自行修改API接口
        $ii->LoadSortInfo($jb);
        $this->assign("InfoData",$ii->_main_data);
        $this->theme("webapps")->display();
    }
    //商品信息管理
    public function ProductManage(){
        $jb=1;
        $ii=new ProductAPI(); //自行修改API接口
        $ii->LoadSortInfo($jb);
        $this->assign("InfoData",$ii->_main_data);

        $this->assign("title", "产品信息管理");
        $this->theme("webapps")->display();
    }
    //上传商品图片
    public function UpImg(){
        //获取当前登录名
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $get_UserName=$ii->_username;

        $sort=I("sort");
        $io=new ActionAPI();
        if ($io->ImgUpload($sort)){
            $ImgUrl="/".$io->_ImgUrl;
            if ($io->UpTmppImg($ImgUrl,'sp',$get_UserName)){
                $Msg="记录成功";
            }else{
                $Msg="记录失败";
            }
            echo json_encode(array('code' => 200, 'src' => $ImgUrl,'Msg' => '上传成功'.$Msg));
        }else{
            echo json_encode(array('code' => 500,'Msg' => $ii->_Msg));
        }
    }

}