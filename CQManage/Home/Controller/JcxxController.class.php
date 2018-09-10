<?php
namespace Home\Controller;
use Home\API\ActionAPI;
use Home\API\JcxxAPI;
use Home\API\UserAPI;
use Think\Controller;
class JcxxController extends Controller {

    public function  zclx_list(){
        $ii= new JcxxAPI();
        $ii->loadclassdata();
        $this->assign("class_data",$ii->_class_data); //一级分类数据
        $this->assign("class_mtea_data",$ii->_class_meta_data); //二级分类数据
        $this->assign("mtea_data",$ii->_class_three_data); //三级分类信息
        if ($_POST)
        {
            $a = new JcxxAPI();
            $a->zclx_add();
            if ($a->actionInfo!="")
            {
                //$this->success('', '/Home/Jcxx/zclx_list');
                redirect('/Home/Jcxx/zclx_list', 0, '页面跳转中...');
                eval($a->actionInfo);
            }
        }
        $this->theme("manage")->display();
    }
    //用户登录日志信息查询
    public function UserLoginInfo(){
        $ii=new ActionAPI();
        $ii->loadUserLoginData();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("Manage")->display("");
    }
    //个人用户信息查询
    public function UserInfo(){
        $ii=new ActionAPI();
        $get_logincook=$_COOKIE['user_info']; //读取当前用户cookie信息
        $get_user_log=unserialize($get_logincook);  //反序列化
        if ($get_user_log->user_id==''){ //如果无法读取信息，返回错误
            echo "error";
        }else{
            $ii->loadInfoLoginData("$get_user_log->user_name");
        }
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("Manage")->display("");
    }
}
