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
use Home\API\NewsAPI;
use Home\API\TreeAPI;


class NewsController extends PublicController {

    public function _initialize(){
        parent::_initialize();
        //parent::_IsAuth();
    }
    //资讯分类管理
    public function NewsSortManage(){
        if($_POST){
            $name=I("name");
            $id=0;
            $ii=new NewsAPI();
            if ($ii->NewsSortEdit($id,$name)){
                $this->success('信息增加成功!','/news/newssortmanage',1);
            }else{
                $this->error("信息编辑失败!");
            }
        }else{

            $this->assign("title","资讯分类管理");
            $this->theme("WebApps")->display();
        }


    }
    //加载菜单树
    public function NewSotrtree(){
        $Menu=new NewsAPI();
        $Menu->LoadNewsSortTree();
        $data=$Menu->_main_data;
        $tree=new TreeAPI("id","sjid","children");
        $tree->load($data);
        $treelist=$tree->DeepTree();//所有分类树结构
        echo json_encode($treelist);//查看结果

        //$result = json_decode($treelist, true);
        //echo $result;
    }
    //资讯信息管理
    public function NewsManage(){
        $id="";
        $ii=new NewsAPI();
        $ii->NewsInfo($id);
        $this->assign("InfoData",$ii->_main_data);
        $ii->NewSort();
        $this->assign("SortData",$ii->_main_data);
        //var_dump($ii->_main_data);
        $this->assign("title","资讯管理");
        $this->theme("WebApps")->display("NewsManageNew");
    }
    //资讯详细信息
    public function NewsDal(){
        $id=I("id");
        //检查传入参数是否完整
        $ii=new ActionAPI();
        $ii->ChId($id);
        $io=new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData",$io->_main_data);
        //var_dump($io->_main_data);
        $this->theme("WebApps")->display();
    }
    //资讯信息编辑
    public function NewsEdit(){
        $id=I("id");
        if ($_POST){
            $ii=new NewsAPI();
            $ii->NewsEdit($id);
            if ($ii->_zt!=0){
                if (!$id){
                    $this->success('信息增加成功!','/news/newsedit',1);
                }else{
                    $this->success('信息编辑成功!','/news/NewsManage',1);
                }

            }else{
                $this->error("信息编辑失败!");
            }
        }else{
            $ii=new NewsAPI();
            $ii->NewSort();
            $this->assign("SortInfo",$ii->_main_data);
            $ii->NewsEdit($id);
            $this->assign("id",$id);
            $this->assign("InfoData",$ii->_dateil_data);
            //var_dump($ii->_dateil_data);
            $this->theme("WebApps")->display("NewsEdit");
        }
        //var_export($ii->_main_data);

    }
    //信息删除
    public function NewsDel(){
       $sort=I("sort");
       $id=I("id");
       //检查传入参数是否完整
        $ii=new ActionAPI();
        $ii->ChId($id);
        $ii->ChId($sort);
        $io=new DelDataAPI();
        if($sort==1){ //删除资讯类型
            $table="infolx_tb";
            if ($io->DelInfo($table,$id)){
               echo "分类删除成功!";
            }else{
               echo "分类删除失败!";
                //$this->error("信息删除失败!");
            }
        }else{ //删除资讯信息
            $table="info_tb";
            if ($io->DelInfo($table,$id)){
                echo "资讯信息删除成功!";
            }else{
                echo "资讯信息删除失败!";
                //$this->error("信息删除失败!");
            }
        }
    }
    //分类信息维护
    public function NewsSortEdit(){
        $id=I("id");
        $name=I("name");
        //echo $id;
        if (!$id){
            $id=0;
        }
        $ii=new NewsAPI();
        if ($ii->NewsSortEdit($id,$name)){
            echo "1";
        }else{
            echo "0";
        }
    }

}