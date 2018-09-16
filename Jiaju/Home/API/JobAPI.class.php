<?php
namespace Home\API;

class JobAPI
{
    public $_page_size="50"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字数据
    public $_class_data=""; //类型数据
    public $_class_meta_data="";
    public $_xmbh=""; //编号数据
    public $actionInfo=""; //返回要执行的动作
    public $_info="";
    public $_zt=""; //状态
    public $_comp=""; //组织机构
    public $_username="";
    public $_usercomp=""; //当前用户组织机构
    public $_userid="";
    public $_Msg="";

    //编辑职位信息
    function EditPosition($id){
        $AddData=D("position_tb");  //注意去除前缀

        $AddData->position=I("position"); //职位名称
        $AddData->department=I("department"); //部门名称
        $AddData->release_people=I("release_people"); //发布人
        $AddData->address=I("address"); //工作地址
        $AddData->year=I("Year"); //工作年限
        $AddData->position_content=I("position_content"); //职位内容
        $AddData->school=I("school"); //学历要求
        $AddData->time=I("time"); //发布时间
        $AddData->status=I("status"); //状态
        $AddData->salary=I("salary"); //薪资范围

        if (!$id){
            $ret=$AddData->add();
        }else{
            $where["id"]=array("eq",$id);
            $ret=$AddData->where($where)->save();
        }
        if (!$ret){
            $this->_Msg="编辑失败";
            return false;
        }else{
            $this->_Msg="编辑成功";
            return true;
        }
    }
    //读取职位信息
    function PositionList($id){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        $status=I("status"); //状态信息

        if (!$sort){
            $sort="id";
        }
        if (!$order){
            $order="desc";
        }
        $TableName=M("position_tb");
            $where["position"]=array("like","%$search%");
            $where["department"]=array("like","%$search%");
            $where['_logic']='OR';

        if ($status!=""){
            if ($search!=""){
                $mmmap['_complex']=$where;
            }
            $mmmap['status']=array('eq',$status);
            $mmmap['_logic']='AND';
        }else{
            $mmmap['_complex']=$where;
        }
        //echo $status;


        if (!$id){
            $this->_page_count=$count=$TableName->where($mmmap)->order($sort." ". $order)->count();
        }else{
            //$where["id"]=array("eq",$id);
            $this->_page_count=$count=$TableName->where("id= $id")->order($sort." ". $order)->count();
        }

        $Page = new \Think\Page($count,$limit);

        //$Page->parameter=$this->_keyword;
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        if (!$id){
            $this->_main_data=$TableName->where($mmmap)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        }else{
            //$where["id"]=array("eq",$id);
            $this->_main_data=$TableName->where("id= $id")->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        }
        //echo $TableName->getLastSql();
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }
}	

?>