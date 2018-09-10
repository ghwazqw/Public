<?php
namespace Home\API;
class MenuAPI
{
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //
    public $_class_data="";
    public $_class_meta_data="";
    public $_xmbh="";
    public $_act="";
    public $_info_id="";


    function loadmatedata($where){
        $this->_act=I("act");
        $this->_info_id=I("id");
        if ($this->_act=="delete"){
        $del_data= M("navbar_tb");
        $del_data->where("id=$this->_info_id")->delete();
        }
        //加载主表数据
        $this->_page_count=$count=M("navbar_tb")->where("nav_jb=1 and nav_lx=1")->order("nav_show ")->count();
        $Page = new \Think\Page($count,"40");

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("navbar_tb")->where("nav_jb=1 and nav_lx=1")->order("nav_show ")->LIMIT($Page->firstRow.','.$Page->listRows)->select();
        //主表数据取值完成
        //echo $ret->getLastSql();
        //取出子菜单
        $this->_dateil_data=$ret=M("navbar_tb")->where("nav_jb=2 and nav_lx=1")->order("nav_show ")->select();
    }


}