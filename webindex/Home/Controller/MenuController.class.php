<?php
namespace Home\Controller;
use Home\API\MenuAPI;
use Think\Controller;
class MenuController extends Controller {
    public function index(){
        $ii=new MenuAPI();
        $ii->loadmatedata();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("meta_data",$ii->_dateil_data);
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);

        $this->theme("50")->display("Menu_Manage");
    }


   
}
