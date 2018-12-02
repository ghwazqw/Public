<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/10/15
 * Time: 10:37 PM
 */

namespace Home\API;

class AdAPI
{
    public $_page_size = "50"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $_keyword = ""; //关键字数据
    public $_Msg = ""; //信息输出

    //加载广告类型信息
    function pt_ad_tbmatedata($id)
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

        $TableName = M("ad_tb"); //注意去除表头
        $this->_keyword = $search;
        if ($this->_keyword != "") {
            $where["name"] = array('like', "%$this->_keyword%");
            $where["note"] = array('like', "%$this->_keyword%");
            /*$where["deletetime"] = array('like', "%$this->_keyword%");
            $where["updatetime"] = array('like', "%$this->_keyword%");*/
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

    //编辑广告类型信息
    function EditAdSort($id)
    {
        $AddData = M("ad_tb");  //注意去除前缀
        $AddData->name = I("name"); //名称
        $AddData->note = I("note"); //说明
        $AddData->deletetime = I("deletetime"); //删除时间
        $AddData->updatetime = date('Y-m-d H:i:s', time()); //更新时间
        if (!$id) {
            $ret = $AddData->add();
        } else {
            $where["id"] = array("eq", $id);
            $count = $AddData->where($where)->count();
            if ($count == 0) {
                $this->_Msg = "信息获取失败";
                return false;
            } else {
                $ret = $AddData->where($where)->save();
            }
        }
        if ($ret) {
            $this->_Msg = "信息更新成功";
            return true;
        } else {
            $this->_Msg = "信息更新失败";
            return false;
        }

    }

    //删除广告类型信息
    public function AdSortDel($id)
    {
        $io = new DelDataAPI();
        $table = "ad_tb";
        if ($io->DelInfo($table, $id)) {
            $this->_Msg = '删除成功';
            return true;
        } else {
            $this->_Msg = '删除失败';
            return false;
        }
    }

    //加载广告信息
    function pt_aditem_tbmatedata($id)
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
        $TableName = M("aditem_tb"); //注意去除表头
        $this->_keyword = $search;
        if ($this->_keyword != "") {
            $where["imgurl"] = array('like', "%$this->_keyword%");
            $where["keyword"] = array('like', "%$this->_keyword%");
            //$where["type"] = array('like', "%$this->_keyword%");
            //$where["ad_id"] = array('like', "%$this->_keyword%");
            //$where["updatetime"] = array('like', "%$this->_keyword%");
            //$where["px"] = array('like', "%$this->_keyword%");
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
    //编辑广告信息
    function EditAdItem($UserName,$type,$keyword){
        $AdTable=M("aditem_tb");
        $TmpTable=M("imgtmp_tb");
        //读取临时表信息
        $TmpWhere["username"]=array("eq",$UserName);
        $Tmp=$TmpTable->where($TmpWhere)->select();
        foreach ($Tmp as $item){
            $AdTable->imgurl=$item["imageurl"];
            $AdTable->keyword=$keyword;
            $AdTable->ad_id=$type;
            $AdTable->updatetime=$item["updatetime"];
            $AdTable->add();
        }
        return true;
    }
    //清空临时表
    function ClearTmp($username){
        $ii=new DelDataAPI();
        $where["username"]=array("eq",$username);
        if ($ii->DelSortInfo('imgtmp_tb',$where)){
            return true;
        }else{
            return false;
        }
    }
}