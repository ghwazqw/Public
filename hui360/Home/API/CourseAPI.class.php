<?php

namespace Home\API;

class CourseAPI
{
    public $_main_data = array(); //主数据数组
    public $_dal_data = array(); //子数据数组
    public $_page_size = "50"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    //public $_main_data=array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $_keyword = ""; //关键字数据
    public $_Msg = ""; //信息输出

    function pt_course_tbmatedata($id)
    {

        $limit = I("limit"); //从前端获取每页显示的数量
        $order = I("order"); //排序方式获取
        $sort = I("sort"); //排序字段获取
        $offset = I("offset"); //排序位置获取
        $search = I("search"); //获取搜索关键字

        if (!$sort) {
            $sort = "id"; //默认排序字段
        }
        if (!$order) {
            $order = "desc"; //默认排序方式
        }
        if (!$offset) {
            $offset = 0; //默认数据读取
        }
        if (!$limit) {
            $limit = $this->_page_size; //前台未传参时，默认每页显示为50条数据
        }

        $TableName = M("course_tb"); //注意去除表头
        $this->_keyword = $search;
        if ($this->_keyword != "") {
            //$where["co_date"] = array('like', "%$this->_keyword%");
            //$where["co_date2"] = array('like', "%$this->_keyword%");
            //$where["co_date3"] = array('like', "%$this->_keyword%");
            $where["co_sktime"] = array('like', "%$this->_keyword%");
            $where["co_title"] = array('like', "%$this->_keyword%");
            $where["co_content"] = array('like', "%$this->_keyword%");
            $where["co_zmoney"] = array('like', "%$this->_keyword%");
            $where["co_money"] = array('like', "%$this->_keyword%");
            $where["co_vip"] = array('like', "%$this->_keyword%");
            //$where["co_status"] = array('like', "%$this->_keyword%");
            //$where["co_datetime"] = array('like', "%$this->_keyword%");
            $where["co_photo"] = array('like', "%$this->_keyword%");
            $where['_logic'] = 'OR';
        }

        //加载主表数据
        $this->_page_count = $count = $TableName->where($where)->count(); //加载获取到的数据量
        $Page = new \Think\Page($count, $limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar = $Page->show(); //把分布内容赋值给变量
        $this->_page_ys = $Page->totalPages;
        if (!$id) {
            $this->_main_data = $TableName->where($where)->order($sort . " " . $order)->LIMIT($offset . ',' . $limit)->select(); //据取值完成
        } else { //ID不为空时读取详细信息
            $this->_main_data = $TableName->where("id=$id")->order($sort . " " . $order)->LIMIT($offset . ',' . $limit)->select(); //据取值完成
        }
        //echo $TableName->getLastSql();
        if ($count == 0) {
            $this->_Msg = '数据结果为0';
        } else {
            $this->_Msg = '获取成功';
        }
    }

    //編輯信息
    function Edit_pt_course_tb($id)
    {
        $AddData = D("course_tb");  //注意去除前缀
        $AddData->co_date = I("co_date"); //課程日期1
        $AddData->co_date2 = I("co_date2"); //課程日期2
        $AddData->co_date3 = I("co_date3"); //課程日期3
        $AddData->co_sktime = I("co_sktime"); //上課時間
        $AddData->co_title = I("co_title"); //課程題目
        $AddData->co_content = $_POST["content"]; //課程內容
        $AddData->co_zmoney = I("co_zmoney"); //早鳥標價
        $AddData->co_money = I("co_money"); //正常價格
        $AddData->co_vip = I("co_vip"); //VIP
        $AddData->co_status = 1; //課程狀態
        $AddData->co_datetime = date('Y-m-d H:i:s',time()) ; //發布時間
        $AddData->co_photo = I("co_photo"); //課程圖片
        if (!$id){
            $ret=$AddData->add();
        }else{
            $where["id"]=array("eq",$id);
            $ret=$AddData->where($where)->save();
        }

        if ($ret){
            $this->_Msg='操作成功';
            return true;
        }else{
            $this->_Msg='操作失败';
            return false;
        }
    }

}	
