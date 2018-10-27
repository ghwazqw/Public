<?php
namespace Home\API;

class ZcxxAPI
{
    public $_page_size = "40"; //每页显示条数
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
    public $_zcsybm="";
    public $_zcusername="";
    public $_sbwhere=array();
    public $_dzsbcount=0;
    public $_dqsbcount=0;
    public $_qtsbcount=0;
    public $_yssbcount=0;
    public $_dzpage="";
    public $_dqpage="";
    public $_qtpage="";
    public $_clpage="";
    public $_zt="";

    function getuser(){
        $get_logincook=$_COOKIE['user_info'];
        if (!$get_logincook) return false; //
        $get_user_log=unserialize($get_logincook);
        if (!$get_user_log) return false;
        if ($get_user_log->user_id && intval($get_user_log->user_id)>0){
            return $get_user_log;
        }
        return false;
    }
    //读取设备信息
    function DzsbList(){

            $TableName=M("dzsb_tb");
            $this->_keyword=I("comp");
                //echo $this->_keyword;
                $where["zc_ccsybm"]  = array('like',"$this->_keyword%");
                $where['_logic']='OR';
                $mmmap['_complex']=$where;
                $mmmap['zc_zt']=array('eq',1);
                $mmmap['_logic']='AND';
                //加载主表数据
                $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
                $Page = new \Think\Page($count,$this->_page_size);
                //$Page->parameter=$this->_keyword;

                $this->_page_bar=$Page->show(); //把分布内容赋值给变量
                $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
                //echo $TableName->getLastSql();

    }
    /*封装电子设备、机械器具、其它设备搜索条件*/
    function sbwhere(){
        $where["zc_pp"]  = array('like',"%$this->_keyword%");
        $where["zc_xh"]  = array('like',"%$this->_keyword%");
        //$where["zc_scrq"]  = array('like',"%$this->_keyword%");
        $where["zc_sccj"]  = array('like',"%$this->_keyword%");
        $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");
        $where["zc_yt"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('like',"%$this->_keyword%");
        $where["zc_lx"]  = array('like',"%$this->_keyword%");
        $where["zc_rjlx"]  = array('like',"%$this->_keyword%");
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where["zc_jldw"]  = array('like',"%$this->_keyword%");
        $where["zc_yz"]  = array('like',"%$this->_keyword%");
        $where["zc_azcb"]  = array('like',"%$this->_keyword%");
        $where["zc_sfzjbz"]  = array('like',"%$this->_keyword%");
        $where["zc_zjnxlx"]  = array('like',"%$this->_keyword%");
        $where["zc_ljzj"]  = array('like',"%$this->_keyword%");
        $where["zc_bqzj"]  = array('like',"%$this->_keyword%");
        //$where["zc_gjrq"]  = array('like',"%$this->_keyword%");
        //$where["zc_rzrq"]  = array('like',"%$this->_keyword%");
        //$where["zc_qyrq"]  = array('like',"%$this->_keyword%");
        $where["zc_qdfs"]  = array('like',"%$this->_keyword%");
        //$where["zc_ccsybm"]  = array('like',"%$this->_keyword%");
        $where["zc_sfxz"]  = array('like',"%$this->_keyword%");
        $where["zc_ccglbm"]  = array('like',"%$this->_keyword%");
        $where["zc_txm"]  = array('like',"%$this->_keyword%");
        $where["zc_zrr"]  = array('like',"%$this->_keyword%");
        $where["zc_pfdh"]  = array('like',"%$this->_keyword%");
        $where["zc_kpsm"]  = array('like',"%$this->_keyword%");
        //$where["zc_czrq"]  = array('like',"%$this->_keyword%");
        $where["zc_czlx"]  = array('like',"%$this->_keyword%");
        $where["zc_czyy"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        //var_export($where);
        return $where;
    }
    function clwhere(){
        $where["zc_gzcpp"]  = array('like',"%$this->_keyword%");
        $where["zc_gzcxh"]  = array('like',"%$this->_keyword%");
        $where["zc_jzzl"]  = array('like',"%$this->_keyword%");
        $where["zc_dppp"]  = array('like',"%$this->_keyword%");
        $where["zc_dpxh"]  = array('like',"%$this->_keyword%");
        $where["zc_clpzh"]  = array('like',"%$this->_keyword%");
        $where["zc_clzs"]  = array('like',"%$this->_keyword%");
        $where["zc_fdxbh"]  = array('like',"%$this->_keyword%");
        $where["zc_cjh"]  = array('like',"%$this->_keyword%");
        //$where["zc_scrq"]  = array('like',"%$this->_keyword%");
        $where["zc_sccj"]  = array('like',"%$this->_keyword%");
        $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");
        $where["zc_csys"]  = array('like',"%$this->_keyword%");
        $where["zc_pql"]  = array('like',"%$this->_keyword%");
        $where["zc_ljxsgl"]  = array('like',"%$this->_keyword%");
        $where["zc_dw"]  = array('like',"%$this->_keyword%");
        $where["zc_jgdm"]  = array('like',"%$this->_keyword%");
        $where["zc_jgmc"]  = array('like',"%$this->_keyword%");
        $where["zc_jgxzjb"]  = array('like',"%$this->_keyword%");
        $where["zc_jgxzjbxx"]  = array('like',"%$this->_keyword%");
        $where["zc_bh"]  = array('like',"%$this->_keyword%");
        $where["zc_lx"]  = array('like',"%$this->_keyword%");
        $where["zc_lxid"]  = array('like',"%$this->_keyword%");
        $where["zc_rjlx"]  = array('like',"%$this->_keyword%");
        $where["zc_rjlxid"]  = array('like',"%$this->_keyword%");
        $where["zc_mc"]  = array('like',"%$this->_keyword%");
        $where["zc_jldw"]  = array('like',"%$this->_keyword%");
        $where["zc_yz"]  = array('like',"%$this->_keyword%");
        $where["zc_dj"]  = array('like',"%$this->_keyword%");
        $where["zc_azcb"]  = array('like',"%$this->_keyword%");
        $where["zc_jz"]  = array('like',"%$this->_keyword%");
        $where["zc_sfzjbz"]  = array('like',"%$this->_keyword%");
        $where["zc_zjnxlx"]  = array('like',"%$this->_keyword%");
        $where["zc_ljzj"]  = array('like',"%$this->_keyword%");
        $where["zc_bqzj"]  = array('like',"%$this->_keyword%");
        //$where["zc_gjrq"]  = array('like',"%$this->_keyword%");
        //$where["zc_rzrq"]  = array('like',"%$this->_keyword%");
        //$where["zc_qyrq"]  = array('like',"%$this->_keyword%");
        $where["zc_qdfs"]  = array('like',"%$this->_keyword%");
        $where["zc_ccsybm"]  = array('like',"%$this->_keyword%");
        $where["zc_sfxz"]  = array('like',"%$this->_keyword%");
        $where["zc_ccglbm"]  = array('like',"%$this->_keyword%");
        $where["zc_txm"]  = array('like',"%$this->_keyword%");
        $where["zc_zrr"]  = array('like',"%$this->_keyword%");
        $where["zc_pfdh"]  = array('like',"%$this->_keyword%");
        $where["zc_kpsm"]  = array('like',"%$this->_keyword%");
        //$where["zc_czrq"]  = array('like',"%$this->_keyword%");
        $where["zc_czlx"]  = array('like',"%$this->_keyword%");
        $where["zc_czyy"]  = array('like',"%$this->_keyword%");
        $where["zc_zcdjr"]  = array('like',"%$this->_keyword%");
        $where["zc_bz"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        return $where;
    }
    //读本部门电子设备信息
    function DzsbCompList(){
        $TableName=M("dzsb_tb");
        $u=$this->getuser();
        $this->_keyword=I("keyword");
        $this->_zcsybm=$u->user_comp;
        $where=$this->sbwhere();
        //var_export($ii);
        //$where=$ii->_sbwhere;
        $mmmap['_complex']=$where;
        $mmmap['zc_zt']=array('eq',1);
        $mmmap["zc_ccsybm"]  = array('like',"$u->user_comp%");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_dzsbcount=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;
        $this->_dzpage=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //本部门机械器具
    function DqsbCompList(){
        $TableName=M("dqsb_tb");
        $u=$this->getuser();
        //echo $u->user_comp;
        $this->_keyword=I("keyword");
        $this->_zcsybm=$u->user_comp;
        $where=$this->sbwhere();
        //var_export($ii);
        //$where=$ii->_sbwhere;
        $mmmap['_complex']=$where;
        $mmmap['zc_zt']=array('eq',1);
        $mmmap["zc_ccsybm"]  = array('like',"$u->user_comp%");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_dqsbcount=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_dqpage=$Page->show(); //把分布内容赋值给变量
        $this->_Dqsbinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();

    }
    //本部门其他设备
    function QtsbCompList(){
        $TableName=M("qtzc_tb");
        $u=$this->getuser();
        $this->_keyword=I("keyword");
        $this->_zcsybm=$u->user_comp;
        $where=$this->sbwhere();
        //var_export($ii);
        //$where=$ii->_sbwhere;
        $mmmap['_complex']=$where;
        $mmmap['zc_zt']=array('eq',1);
        $mmmap["zc_ccsybm"]  = array('like',"$u->user_comp%");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_qtsbcount=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_qtpage=$Page->show(); //把分布内容赋值给变量
        $this->_Qtsbinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
    }
    //本部门运输工具
    function YsgjCompList(){
        $TableName=M("ysgj_tb");
        $u=$this->getuser();
        $this->_keyword=I("keyword");
        $this->_zcsybm=$u->user_comp;
        $where=$this->clwhere();
        //var_export($ii);
        //$where=$ii->_sbwhere;
        $mmmap['_complex']=$where;
        $mmmap['zc_zt']=array('eq',1);
        $mmmap["zc_ccsybm"]  = array('like',"$u->user_comp%");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_yssbcount=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;
        $this->_clpage=$Page->show(); //把分布内容赋值给变量
        $this->_Ysgjinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
    }
    //机械器具
    function DqsbList(){

        $TableName=M("dqsb_tb");
        $this->_keyword=I("comp");
            //echo $this->_keyword;
            $where["zc_ccsybm"]  = array('like',"$this->_keyword%");
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
            $mmmap['zc_zt']=array('eq',1);
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
        $this->_keyword=I("comp");
            //echo $this->_keyword;
            $where["zc_ccsybm"]  = array('like',"$this->_keyword%");
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
            $mmmap['zc_zt']=array('eq',1);
            $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_Qtsbinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
    }

    function YsgjList(){
        $TableName=M("ysgj_tb");
        $this->_keyword=I("comp");
            //echo $this->_keyword;
            $where["zc_ccsybm"]  = array('like',"$this->_keyword%");
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
            $mmmap['zc_zt']=array('eq',1);
            $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            //$Page->parameter=$this->_keyword;
            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_Ysgjinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
    }
    /*封装用户设备操作日志类*/
    function SbxxInfoAdd($ActContent,$zt,$logid){

        $TableName=M("sbxx_log_tb");
        if (!$logid){
            $TableName->sblx=I("sblx");
            $TableName->sbid=I("sbid");
            $TableName->sbbh=I("sbbh");
            $TableName->sbmc=I("sbmc");
            $TableName->ywlx=I("ywlx");
            $TableName->czr=I("czr");
            $TableName->czsj=date("Y-m-d H:i:s");
            $TableName->cznr=$ActContent;
            $TableName->yzrr=I("yzrr");
            //维修业务处理
            $TableName->zc_sqwxsj=I("zc_sqwxsj");
            $TableName->zc_sqwxbm=I("zc_sqwxbm");
            $TableName->zc_sqly=I("zc_sqly");
            $TableName->zc_sqr=I("zc_sqr");
            if (I("zc_wxsj")!=""){
                $TableName->zc_wxsj=I("zc_wxsj");
            }
            $TableName->zc_note=I("zc_note");
            $TableName->zc_fsje=I("zc_wxje");
            $TableName->spzt=$zt;
            $ret=$TableName->add();
            $this->_zt=$ret;
        }else{
            $TableName->czr=I("czr");
            $TableName->spzt=$zt;
            $TableName->zc_wxsj=date('Y-m-d H:i:s',time());
            $TableName->zc_fsje=I("zc_wxje");
            $where["id"]=array("eq",$logid);
            $ret=$TableName->where($where)->save();
            //echo $TableName->_sql();
            $this->_zt=$ret;
        }
        if ($ret){
            return true;
        }else{
            return false;
        }

    }
    /*封装设备主表状态操作类*/
    function SbxxZt($sblx,$sbid,$zt){ //需要两个参数，第一个为操作类，实际为设备表名；第二个为设备ID值
        $TableName=M("$sblx");
        $TableName->zc_zt=$zt;
        $where["id"]=array("eq",$sbid);
        $ret=$TableName->where($where)->save();
        $this->_zt=$ret;
        if ($ret){
            return true;
        }else{
            return false;
        }
    }
    /*设备审批类*/
    function SbSpxx($LogId){
        $TableName=M("spxx_tb");
        $TableName->log_id=$LogId;
        $TableName->sb_lx=I("sblx");
        $TableName->sb_id=I("sbid");
        $TableName->sp_lx=I("ywlx");
        $TableName->sp_zt=I("spzt");
        $TableName->sp_yj=I("sp_yj");
        $TableName->sp_tjr=I("czr");
        $TableName->sp_sj=date('Y-m-d H:i:s',time()); //后端获取日期
        $ret=$TableName->add();
        $this->_zt=$ret;
        //驳回时改变资产状态
        if (I("spzt")==1){
            $io=new ZcxxAPI();
            $io->SbxxZt(I("sblx"),I("sbid"),1);
        }
    }
    function SpInfoList(){
        $id=I("log_id");
        $ii=new ActionAPI();
        $ii->ChId($id);
        $TableName=M("spxx_tb");
        $where["log_id"]=array("eq",$id);
        $ret=$TableName->where($where)->order("id desc")->select();
        $this->_main_data=$ret;
    }
    //多ID读取资产信息
    function InZcinfo($id,$zctable){
        $table=M($zctable);
        $id=$id;
        $where["id"]=array("in",$id);
        $this->_main_data=$table->where($where)->order("id")->select();
        //echo $table->_sql();
    }
}