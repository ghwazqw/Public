<?php
namespace Home\API;

class ContractAPI
{
    //public $_page_size = "1000"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $actionInfo = ""; //返回要执行的动作
    public $_Msg="";
    public $_zt=0;


    function ContractInfo($id){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字

        if (!$sort){
            $sort="id"; //默认排序字段
        }
        if (!$order){
            $order="desc"; //默认排序方式
        }
        if (!$offset){
            $offset=0; //默认数据读取
        }

        $TableName=M("contract_tb");

        if ($search!=""){
            $where["cont_name"]=array("like","%$search%"); //标题搜索
            $where['_logic']='OR';
        }

        $this->_page_count=$count=$TableName->where($where)->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        if (!$id){
            $this->_main_data=$TableName->where($where)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        }else{ //ID不为空时读取详细信息
            $this->_main_data=$TableName->where("id=$id")->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        }
        //exit($TableName->getLastSql()) ;
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }
    //编辑信息
    function EditContract(){
        $AddData=D("contract_tb");  //注意去除前缀
        $AddData->cont_name=I("cont_name"); //合同名称
        $AddData->cont_first=I("cont_first"); //甲方(第一方)
        $AddData->cont_partyb=I("cont_partyb"); //乙方
        $AddData->cont_date=I("cont_date"); //签署时间
        $AddData->cont_method=I("cont_method"); //付款方式
        $AddData->cont_state=I("cont_state"); //合同状态(1签署;2执行中;7冻结;100完成;10结束)
        $AddData->cont_no=I("cont_no"); //合同编号
        //$AddData->cont_file=I("cont_file"); //合同附件
        $AddData->cont_money=I("cont_money"); //合同金额


        $config = C('uploaddoc'); //读取上传文件配置
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload(); //上传文件
        if(!$info) { //上传错误提示错误信息
            $this->_Msg=$upload->getError();
            return false;
            //$this->error($upload->getError());
        }else{
            foreach ($info as $file) {
                $AddData->cont_file=$file['savepath'] . $file['savename'];
                $ret=$AddData->add();
                if ($ret){
                    $this->_Msg='信息增加成功';
                    return true;
                }else{
                    $this->_Msg='信息增加失败';
                    return false;
                }
            }
        }


    }

}