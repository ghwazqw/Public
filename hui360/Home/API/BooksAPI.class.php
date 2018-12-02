<?php
namespace Home\API;


class BooksAPI
{
	//public $_page_size="40"; //每页显示条数
	public $_page_bar=""; //分布组件需要展示的内容
	public $_page_count=""; //统计数量
	public $_main_data=array(); //主表数据
	public $_dateil_data=array();  //子表数据
	public $_keyword=""; //
	public $_class_data="";
	public $_class_meta_data="";
	public $_xmbh="";
	public $actionInfo=""; //返回要执行的动作
	public $_oper_data=""; //读取平台操作信息

    //读取新闻分类
    function LoadBookInfo($id){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        if (!$sort){
            $sort="id";
        }
        if ($limit=="" && !$id){
            $this->_Msg='请求值过大,请指定范围后重试';
            $this->_page_count=0;
        }else{
        $TableName=M("books_tb");
        if ($search!=""){
            $where["booktitle"]=array("like","%$search%");
            $where["bookpress"]=array("like","$search%");
            $where["booksort"]=array("eq","$search");
            $where['_logic']='OR';
        }
        if(!$id){
            $this->_page_count=$count=$TableName->where($where)->order($sort." ". $order)->count();
        }else{
            $this->_page_count=$count=$TableName->where("id=$id")->order($sort." ". $order)->count();
        }

        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        if(!$id){
            $this->_main_data=$TableName->where($where)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        }
        else{ //ID不为空时读取详细信息
            $this->_main_data=$TableName->where("id=$id")->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        }
        //echo $TableName->getLastSql();
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
        }
    }
	
}	
