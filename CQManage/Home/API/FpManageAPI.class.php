<?php
namespace Home\API;

class FpManageAPI
{
    public $_page_size = "100"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_Dqsbinfo=array(); //机械器具
    public $_Qtsbinfo=array(); //其他资产
    public $_Ysgjinfo=array(); //运输工具
    public $_dateil_data = array();  //子表数据
    public $_keyword = ""; //关键词
    public $_class_data = "";
    public $_class_meta_data = "";
    public $_xmbh = "";
    public $actionInfo = ""; //返回要执行的动作
    public $_stId=""; //盘点单id
    public $_stTime=""; //盘点日期
    public $_handingUser=""; //盘点人
    public $_stNO=""; //盘点单编号
    public $_depName=""; //盘点部门
    //读取设备信息
    function DzsbList(){
        $TableName=M("dzsb_tb");
        $this->_keyword=I("keyword");
        $this->_depName=I("comp");
        //echo $this->_keyword;
        $where["zc_pp"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('eq',$this->_keyword);
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['zc_zt']=array('eq',1);
        //$mmmap['zc_cfwz']=array('EXP','is null');
        $mmmap['zc_cfwz']=array('eq',0);
        $mmmap["zc_ccsybm"]  = array('like',"$this->_depName%");
        $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
            //echo $TableName->getLastSql();
    }
    //读取房间内电子设备信息
    function FjDzsbList(){
        $TableName=M("dzsb_tb");
        $this->_keyword=I("id");
        $this->_depName=I("comp");
        //echo $this->_keyword;
        /*$where["zc_pp"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('eq',$this->_keyword);
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;*/
        //$mmmap['zc_zt']=array('eq',1);
        $mmmap['zc_cfwz']=array('eq',$this->_keyword);
        //$mmmap["zc_ccsybm"]  = array('like',"$this->_depName%");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //读取房间内机械器具信息
    function FjDqsbList(){
        $TableName=M("dqsb_tb");
        $this->_keyword=I("id");
        //$this->_depName=I("comp");
        //echo $this->_keyword;
        /*$where["zc_pp"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('eq',$this->_keyword);
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;*/
        //$mmmap['zc_zt']=array('eq',1);
        $mmmap['zc_cfwz']=array('eq',$this->_keyword); //所在位置
        //$mmmap["zc_ccsybm"]  = array('like',"$this->_depName%");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //读取房间内其他设备信息
    function FjQtsbList(){
        $TableName=M("qtzc_tb");
        $this->_keyword=I("id");
        //$this->_depName=I("comp");
        //echo $this->_keyword;
        /*$where["zc_pp"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('eq',$this->_keyword);
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;*/
        //$mmmap['zc_zt']=array('eq',1);
        $mmmap['zc_cfwz']=array('eq',$this->_keyword); //所在位置
        //$mmmap["zc_ccsybm"]  = array('like',"$this->_depName%");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //读取房间运输工具信息
    function FjYsgjList(){
        $TableName=M("ysgj_tb");
        $this->_keyword=I("id");
        //$this->_depName=I("comp");
        //echo $this->_keyword;
        /*$where["zc_pp"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('eq',$this->_keyword);
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;*/
        //$mmmap['zc_zt']=array('eq',1);
        $mmmap['zc_cfwz']=array('eq',$this->_keyword); //所在位置
        //$mmmap["zc_ccsybm"]  = array('like',"$this->_depName%");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //机械器具
    function DqsbList(){
        $TableName=M("dqsb_tb");
        $this->_keyword=I("keyword");
        $this->_depName=I("comp");
        //echo $this->_keyword;
        $where["zc_pp"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('eq',$this->_keyword);
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['zc_zt']=array('eq',1);
        //$mmmap['zc_cfwz']=array('EXP','is null');
        $mmmap['zc_cfwz']=array('eq',0);
        $mmmap["zc_ccsybm"]  = array('like',"$this->_depName%");
        $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_Dqsbinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
            //echo $TableName->getLastSql();

    }
    //其他设备
    function QtsbList(){

        $TableName=M("qtzc_tb");
        $this->_keyword=I("keyword");
        $this->_depName=I("comp");
        //echo $this->_keyword;
        $where["zc_pp"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('eq',$this->_keyword);
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['zc_zt']=array('eq',1);
        //$mmmap['zc_cfwz']=array('EXP','is null');
        $mmmap['zc_cfwz']=array('eq',0);
        $mmmap["zc_ccsybm"]  = array('like',"$this->_depName%");
        $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_Qtsbinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成


    }
    //运输工具
    function YsgjList(){
        $TableName=M("ysgj_tb");
        $this->_keyword=I("keyword");
        $this->_depName=I("comp");
        //echo $this->_keyword;
        $where["zc_gzcpp"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('eq',$this->_keyword);
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['zc_zt']=array('eq',1);
        //$mmmap['zc_cfwz']=array('EXP','is null');
        $mmmap['zc_cfwz']=array('eq',0);
        $mmmap["zc_ccsybm"]  = array('like',"$this->_depName%");
        $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_Ysgjinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
    }
    //增加信息
    function AddFpInfo(){
        $fj_id=I("fj_id");
        if (!$fj_id){
            echo "info error！";
            exit();
        }
        $AddData=D("zcfpzb_tb");  //注意去除前缀
        $AddData->stUser=I("stUser"); //创建人
        $AddData->stTime=date("Y-m-d h:i:s"); //操作时间
        //$AddData->depName=I("depName"); //部门名称
        $AddData->pd_dzsb=I("pd_dzsb"); //电子设备信息
        $AddData->pd_dqsb=I("pd_dqsb"); //机械器具
        $AddData->pd_ysgj=I("pd_ysgj"); //运输工具
        $AddData->pd_qtsb=I("pd_qtsb"); //其他设备
        $AddData->pd_ryxx=I("pd_rysb"); //人员信息
        $AddData->add();
        //电子设备更新
        if (I("pd_dzsb")!=''){
            $dzsb=I("pd_dzsb");
            $dztable=D("dzsb_tb");
            $dztable->zc_cfwz=$fj_id;
            $where["id"]=array('in',$dzsb);
            $ret=$dztable->where($where)->save();
        }
        //机械器具更新
        if (I("pd_dqsb")!=''){
            $dqsb=I("pd_dqsb");
            $dztable=D("dqsb_tb");
            $dztable->zc_cfwz=$fj_id;
            $where["id"]=array('in',$dqsb);
            $ret=$dztable->where($where)->save();
        }
        //其他设备更新
        if (I("pd_qtsb")!=''){
            $qtsb=I("pd_qtsb");
            $dztable=D("qtzc_tb");
            $dztable->zc_cfwz=$fj_id;
            $where["id"]=array('in',$qtsb);
            $ret=$dztable->where($where)->save();
        }
        //运输工具更新
        if (I("pd_ysgj")!=''){
            $ysgj=I("pd_ysgj");
            $dztable=D("ysgj_tb");
            $dztable->zc_cfwz=$fj_id;
            $where["id"]=array('in',$ysgj);
            $ret=$dztable->where($where)->save();
        }
        //人员信息更新
        if (I("pd_rysb")!=''){
            $ryxx=I("pd_rysb");
            $dztable=D("ryxx_tb");
            $dztable->ry_fjid=$fj_id;
            $where["id"]=array('in',$ryxx);
            $ret=$dztable->where($where)->save();
        }
        if(!$ret){
            $this->_pass="error";
        }else {
            $this->_pass="ok";
        }
    }
}