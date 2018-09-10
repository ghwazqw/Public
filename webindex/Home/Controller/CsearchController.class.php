<?php
namespace Home\Controller;
use Home\API\CgxxAPI;
use Think\Controller;
class CsearchController extends Controller {
    public function Cgxx_list(){

    $ii=new CgxxAPI();
        $ii->loadmatedata();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->theme("glxh")->display(index);
    }

}
