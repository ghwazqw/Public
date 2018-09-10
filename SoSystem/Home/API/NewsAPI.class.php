<?php
namespace Home\API;
class NewsAPI
{
    public $_info_type=1;  //获取类型为1的信息，1为新闻
    public $_page_size="50"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_meta_data=array();
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; // 关键字数据
    public $_lxdata=""; //资讯类型
    public $actionInfo=""; //返回要执行的动作
    public $_type="";
    public $_cilck="";  //新闻点击量计算值
    public $_data_data_cilck="";
    public $_data_cilck=""; //数量库中的点击量值
    public $_file_data=array();
    public $_newsret="";
    function __construct($infoType,$pageSize=10)
    {
        $this->_info_type=$infoType;
        $this->_page_size=$pageSize;
    }

    //读取资讯类型
    function NewsLx($type){
        $TableName=M("newslx_tb");
        $this->_keyword=I("keyword");
            $where["lxname"]  = array('like',"%$this->_keyword%");
            $where["lxnote"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap["lxsx"]  = array('eq',$type);
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //新增资讯类型
    function AddNewsLx(){
        $AddData=D("newslx_tb");  //注意去除前缀
        $AddData->lxname=I("lxname"); //类型名称
        $AddData->lxnote=I("lxnote"); //类型说明
        $AddData->add();
        }
    //编辑信息
    function EditNewsLx(){
        $id=I("id");
        $EditData=D("newslx_tb");  //注意去除前缀
        $EditData->lxname=I("lxname"); //类型名称
        $EditData->lxnote=I("lxnote"); //类型说明
        $EditData->where("id=$id")->save();
    }
    //读取信息主表
    function InfoMainList($type){
            $TableName=M("info_tb");
            $this->_keyword=I("keyword");
                $where["info_title"]  = array('like',"%$this->_keyword%");
                $where["info_user"]  = array('like',"%$this->_keyword%");
                $where["info_laiyuan"]  = array('like',"%$this->_keyword%");
                $where["info_des"]  = array('like',"%$this->_keyword%");
                $where["info_content"]  = array('like',"%$this->_keyword%");
                $where["info_date"]  = array('like',"%$this->_keyword%");
                $where["info_type"]  = array('like',"%$this->_keyword%");
                $where['_logic']='OR';
                $mmmap['_complex']=$where;
                $mmmap["info_type"]  = array('eq',$type);
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
            //echo $TableName->getLastSql();
    }

    //读取资讯属性表信息
    function NewsMetaList(){
        $TableName=M("info_meta_tb");
        if ($this->_keyword!=""){
            $where["info_id"]  = array('like',"%$this->_keyword%");
            $where["im_key"]  = array('like',"%$this->_keyword%");
            $where["im_value"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }
        //加载表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_dateil_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //表数据取值完成
        //echo $TableName->getLastSql();
    }

    function  LoadMeta($info_id,$MetaData){
        //echo $info_id;
        $ret=array();
        foreach ($MetaData as $info){
            if ($info['info_id']==$info_id){
                $ret[$info["im_key"]]=$info["im_value"];
            }
        }
        //var_export($MetaData);
        return $ret;
    }
    //资讯信息增加
    function NewsAdd(){
        $AddData=D("info_tb");  //注意去除前缀
        $AddData->info_title=I("info_title"); //标题
        $AddData->info_user=I("info_user"); //发布者
        $AddData->info_laiyuan=I("info_laiyuan"); //信息来源
        $AddData->info_des=I("info_des"); //简介
        $AddData->info_content=$_POST["info_content"]; //内容
        $AddData->info_date=I("info_date"); //发布日期
        $AddData->info_photo=I("info_photo"); //信息图片
        $AddData->info_type=1; //大类型
        $AddData->info_lx=I("lxname"); //子类型
        $AddData->info_datetime=date('Y-m-d H:i:s',time()); //增加时间
        $AddData->info_czr=1; //操作人
        $this->_newsret=$AddData->add();
        //echo $ret;
    }
    //资讯详细信息
    function NewsDal($where)
    {
        $this->_keyword = I("id");
        if (!I("id")){
            echo "ID Error";
            exit();
        }
            $where['info_id']  = array('eq',$this->_keyword); //id
            $where['im_key']  = array('eq',"dianji"); //点击量
            //$where['_logic']='OR';
        //点击量计量
        $key="new_".$this->_keyword; //获取新闻点击量ID
        $max="50";  //每隔多少次更新数据库
        $cilck=new RedisAPI();
        $cilck->Yw_data($key,$max);
        $this->_cilck = $cilck->_cilck;
        $this->_data_data_cilck=$ret=M("info_meta_tb")->where($where)->order("id DESC")->select(); //获取统计分析总数量
        foreach($this->_data_data_cilck as $id_info){  //获取数据库中的统计值
            $cil=$id_info["im_value"];
            $this->_data_cilck=$cil;
        }
        //echo M("info_meta_tb")->_sql();
        //echo $cil;
        $this->_meta_data=$ret=M("info_tb")->where("id=$this->_keyword")->limit(1)->order("id DESC")->select(); //详细表数据取值完成
        //$this->_page_count=$count=M("info_tb")->where($where)->limit(1)->order("info_id DESC")->count();

        //$this->_file_data=M("infofile_tb")->where($where)->order("id DESC")->select(); //附件信息查询
        //$this->_dateil_data=$ret=M("info_anal_tb")->where($where)->order("info_id DESC")->select(); //统计分析数据
        //$this->_page_count=$ret=M("info_anal_tb")->where($where)->order("info_id DESC")->count(); //获取统计分析总数量

       /* //echo ($this->_page_count);
        if ($this->_page_count<2){
            $this->_dateil_data=0;
            //echo $this->_dateil_data;
        }else{
            //echo "分析完成";
            $this->_dateil_data=$ret=M("info_anal_tb")->where($where)->order("info_count DESC")->LIMIT(2)->select(); //统计分析数据
            //更新分析结果
            $set_anal_type="";
            $set_count="";
            foreach($this->_dateil_data as $anal_info){

                $set_anal_type=$anal_info["info_type"];
                $set_count=$anal_info["info_count"];
            }
            $info_edit_table=D("info_tb")->where($where);
            $info_edit_table->info_count=$set_count;
            $info_edit_table->info_anal_type=$set_anal_type;
            $info_edit_table->save();
        }*/
        //echo M("info_anal_tb")->_sql();

    }

}