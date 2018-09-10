<?php
namespace Home\API;
class UserLogAPI
{
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字数据
    public $_class_data=""; //类型数据
    public $_class_meta_data=""; //关键字数据
    public $actionInfo=""; //返回要执行的动作

    function loadmatedata($where){
        $TableName=M("user_log");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["log_type"]  = array('like',"%$this->_keyword%");
            $where["log_info"]  = array('like',"%$this->_keyword%");
            $where["user_id"]  = array('like',"%$this->_keyword%");
            $where["user_name"]  = array('like',"%$this->_keyword%");
            $where["user_ip"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }




}