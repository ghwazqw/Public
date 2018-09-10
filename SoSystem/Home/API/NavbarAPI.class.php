<?php

namespace Home\API;

class NavbarAPI
{
    public $_page_size="10"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字数据
    public $_class_data=""; //类型数据
    public $_class_meta_data=""; //关键字数据
    public $actionInfo=""; //返回要执行的动作

    function LoadNavbarData($jb){
        $TableName=M("navbar_tb");
        //加载主表数据
        if ($jb!=""){
            $where["cglx_jb"]=array("eq",$jb);
        }

        $this->_page_count=$count=$TableName->where($where)->order("id")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        return json_encode($this->_main_data);
    }
    function LoaduserInfo($lx){
        $TableName=M("qx_user_tb");
        $info=I("info");
        $where["user_lx"]=array("eq",$lx);
        $where["id"]=array("eq",$info);
        $this->_main_data=$TableName->where($where)->order("id")->select(); //主表数据取值完成
    }
    function LoadJyInfo(){
        $TableName=M("jybd_tb");
        $info=I("info");
        if (!$info){
            echo "ID Error";
            exit();
    }
        $where["user_name"]=array("eq",$info);
        $this->_page_count=$count=$TableName->where($where)->order("id")->count();
        $this->_main_data=$TableName->where($where)->order("id")->select(); //主表数据取值完成
        //echo $TableName->_sql();
    }
}