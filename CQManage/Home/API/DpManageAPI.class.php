<?php
namespace Home\API;
use Home\Lib\PasswordHash;
use Think\Controller;

class DpManageAPI
{
    public $_page_size = "40"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $_keyword = ""; //
    public $_class_data = "";
    public $_class_meta_data = "";
    public $_xmbh = "";
    public $actionInfo = ""; //返回要执行的动作

    //读取人员信息
    function loadRyuandata(){
        $TableName=M("ryxx_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["ry_xm"]  = array('like',"%$this->_keyword%");
            $where["ry_zw"]  = array('like',"%$this->_keyword%");
            $where["ry_bm"]  = array('like',"%$this->_keyword%");
            $where["ry_ks"]  = array('like',"%$this->_keyword%");
            $where["ry_fjh"]  = array('like',"%$this->_keyword%");
            $where["ry_bgdh"]  = array('like',"%$this->_keyword%");
            $where["ry_sjhm"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';

        }
        $this->_main_data=$TableName->where($where)->order("ry_px")->LIMIT(0,5)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    function loadRyZcsbData(){
        $ryid=I("id");
        if (!$ryid){
            echo "id Error";
        }
        else{
            $TableName=M("ryzcsb_tb");
            $count=$TableName->where("ry_id=$ryid")->count();
            if($count==0){
                $this->_page_count=0;
                exit();
            }else{
                $this->_main_data=$TableName->where("ry_id=$ryid")->order("id desc")->select();
                //var_export($this->_main_data);
            }
        }
    }
    function loadZcSbData(){
        $lx=I("lx");
        $TableName=M("$lx");
        if (!$lx){
            echo "Class Error!";
        }else{
            $where["zc_zrr"]=array('eq',"");
            $this->_main_data=$TableName->where($where)->order("id desc")->select();
            //echo $TableName->_sql();
            $this->_keyword=$lx;
        }
    }
    function DpxxAddInfo(){
        $AddTable=D("ryzcsb_tb");
        $AddTable->ry_id=I("ryid");
        $AddTable->zcsb_id=serialize(I("sbid"));
        $AddTable->zcsb_lx=I("sblx");
        $AddTable->zcsb_lxid=I("sblxid");
        $AddTable->add();
        echo "调配成功" ;
    }
    function loadmatedata(){
        $TableName=M("sbxx_log_tb");
        $this->_keyword=I("keyword");
            $where["sblx"]  = array('like',"%$this->_keyword%");
            $where["sbid"]  = array('like',"%$this->_keyword%");
            $where["sbbh"]  = array('like',"%$this->_keyword%");
            $where["sbmc"]  = array('like',"%$this->_keyword%");
            //$where["ywlx"]  = array('like',"%$this->_keyword%");
            $where["czr"]  = array('like',"%$this->_keyword%");
            //$where["czsj"]  = array('like',"%$this->_keyword%");
            //$where["cznr"]  = array('like',"%$this->_keyword%");
            $where["ycomp"]  = array('like',"$this->_keyword%");
            $where["yzrr"]  = array('like',"%$this->_keyword%");
            $where["xcomp"]  = array('like',"$this->_keyword%");
            $where["xzrr"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
            $mmmap['ywlx']=array('EQ','调配管理');
            $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    function LoadZrrInfo(){
        $TableName=M("ryxx_tb");
        $Compid=I("id");
        if (!$Compid){
            echo "组织机构错误";
        }else{
            $where["ry_bmid"]  = array('eq',$Compid);
            $this->_main_data=$TableName->where($where)->order("id")->select(); //主表数据取值完成
        }
    }
    function SubmitDpinfo(){
        $TableName=D("sbxx_log_tb");
        $content="该业务发生于：".date("Y-m-d H:i:s")."，由".I("czr")."对".I("sbmc").", 编号：".I("sbbh")."的资产设备进行了调配。由".I("ycomp").I("yzrr")."调配至".I("xcomp").I("zc_rjlx");
        $TableName->sblx=I("sblx");
        $TableName->sbid=I("sbid");
        $TableName->sbbh=I("sbbh");
        $TableName->sbmc=I("sbmc");
        $TableName->ywlx=I("ywlx");
        $TableName->czr=I("czr");
        $TableName->czsj=date("Y-m-d H:i:s");
        $TableName->ycomp=I("ycomp");
        $TableName->yzrr=I("yzrr");
        $TableName->cznr=$content;
        $TableName->xcomp=I("xcomp");
        $TableName->xzrr=I("zc_rjlx");
        $TableName->add();
        //实际表插入数据
        $lxtable=I("sblx");
        $id=I("sbid");
        $act_table=D("$lxtable");
        $act_table->zc_ccsybm=I("xcomp");
        $act_table->zc_zrr=I("zc_rjlx");
        $result=$act_table->where("id=$id")->save();

        if($result===false)
            //$this->error('保存失败，请检查网络或与系统管理员联系！','javascript:history.back(-1);',1);
            redirect('javascript:history.back(-1);', 1, '调配失败，请检查网络或与系统管理员联系！');
        else
            redirect('/Home/DpManage', 1, '调配成功，正在转入调配页面...');
    }
}