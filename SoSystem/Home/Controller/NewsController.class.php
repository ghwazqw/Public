<?php
namespace Home\Controller;
use Home\API\DelDataAPI;
use Home\API\FromAPI;
use Home\API\NewsAPI;
use Think\Controller;
use Think\Model;

class NewsController extends Controller {

    public  $_Meta_info=array(); //属性数据
    public function NewsLxManage(){
        $ii=new NewsAPI();
        $ii->NewsLx(1);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        //var_export($ii->_main_data);
        $this->theme("manage")->display();
    }
    //JSON格式输出资讯类型
    public function NewsLxJson(){
        $ii=new NewsAPI();
        $ii->NewsLx(1);
        //$this->assign("InfoData",$ii->_main_data); //主表数据
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //增加类型信息
    public function AddNewsLx(){
        $ii=new NewsAPI();
        $ii->AddNewsLx();
        $this->success('类型信息增加成功，正在跳转','/home/news/NewsLxManage',1);
    }
    //编辑类型信息
    public function EditNewsLx(){
        $ii=new NewsAPI();
        $ii->EditNewsLx();
        $this->success('类型信息编辑成功，正在跳转','/home/news/NewsLxManage',1);
    }
    //删除分类信息
    public function delinfo(){
        /*$clear=new UserAPI();
        $clear->ClearUser();*/
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/home/news/NewsLxManage',0);
        }else{
            $this->error('信息删除失败','/home/news/NewsLxManage',0);
        }
    }
    public function NewsManage(){
        /*$m=new Model();
        $ret=$m->table("pt_info_tb a")->join("pt_info_meta_tb b on a.id=b.info_id","left")->
        where("a.info_type=1")->field("a.*,b.im_key,b.im_value")->order("a.id desc")->select();
        //echo $m->_sql();
        var_export($ret);*/
        $ii=new NewsAPI();
        $ii->InfoMainList(1); //读取新闻信息
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("action",1); //操作菜单开关
        //echo ACTION_NAME;
        $ii->NewsMetaList();
        $this->assign("MetaData",$ii->_dateil_data); //属性数据
        //var_export($ii->_dateil_data);
        $this->theme("manage")->display();
    }
    //删除资讯信息
    public function delNewsinfo(){
        /*$clear=new UserAPI();
        $clear->ClearUser();*/
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/home/news/NewsManage',0);
        }else{
            $this->error('信息删除失败','/home/news/NewsManage',0);
        }
    }
    //增加资讯信息
    public function NewsAdd(){
        $ii=new NewsAPI();
        $ii->NewsLx(1);
        $this->assign("lxinfo",$ii->_main_data);
        $now_time = date('Y-m-d ',time());
        $this->assign("day",$now_time);
        if ($_POST){
            $a=new NewsAPI();
            $a->NewsAdd();
            if (!$a->_newsret){
                $this->error('信息增加失败，请检查后重试','/home/news/NewsManage',0);
            }else{
                $this->success('资讯信息增加成功，正在跳转...','/home/news/newsmanage',1);
            }

        }else{
            $this->theme("manage")->display();
        }

    }
    public function NewsDal(){
        $ii=new NewsAPI();
        $ii->NewsDal();
        $this->assign("meta_data",$ii->_meta_data); //详细信息
        $this->assign("web_manage_title","信息管理系统 | 资讯信息管理 | 详细资讯信息");
        /*$this->assign("dateil_data",$ii->_dateil_data); //idf-tf分析数据
        $this->assign("file_data",$ii->_file_data); //附件信息上传*/
        $this->assign("info_cilck",$ii->_cilck+$ii->_data_cilck); //输出redis点击量值
        $this->assign("data_cilck",$ii->_data_cilck); //输出数据库中点击量值
        $this->theme("manage")->display();

        //var_export($ii->_meta_data);
    }


}
