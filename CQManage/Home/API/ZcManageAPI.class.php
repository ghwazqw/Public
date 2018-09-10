<?php
namespace Home\API;
class ZcManageAPI
{
    public $_page_size="80"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_ys="";
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_class_three_data="";
    public $_dal_hj_data=array();  //获奖信息
    public $_dal_wcdw_data=array(); //完成单位信息
    public $_keyword=""; //关键字
    public $_class_data=""; //分类信息
    public $_class_meta_data=""; //子分类信息
    public $_xmbh=""; //项目编号
    Public $_zc_zt="";
    Public $_lx="";
    Public $_zc_bh="";
    Public $_zc_lx="";
    Public $_zc_rjlx="";
    Public $_zc_mc="";
    Public $_zc_jldw="";
    Public $_zc_yz="";
    Public $_zc_dj="";
    Public $_zc_azcb="";
    Public $_zc_sfzjbz="";
    Public $_zc_zjnxlx="";
    Public $_zc_ljzj="";
    Public $_zc_gjrq="";
    Public $_zc_rzrq="";
    Public $_zc_qyrq="";
    Public $_zc_qdfs="";
    Public $_zc_ccsybm="";
    Public $_zc_sfxz="";
    Public $_zc_ccglbm="";
    Public $_zc_txm="";
    Public $_zc_zzr="";
    Public $_zc_pfdh="";
    Public $_zc_kpsm="";
    Public $_zc_czrq="";
    Public $_zc_zcdjr="";
    public $_Excel="";

    //读取二级分类信息
    function loadclassdata($where,$keyword){
        //加载主分类数据
        $this->_keyword=I("lx");
        if ($this->_keyword==""){
            //$this->_class_data=$et=M("zclx_tb")->where("cglx_jb=2".$where)->order("id")->select();
            //echo M("zclx_tb")->_sql();
            //echo "lx Erroe";
        }else
        {
            $where['cglx_sjid']  = array('eq',$this->_keyword);
            $where['cglx_jb'] = array('eq',2);
            //echo $this->_keyword;
            $this->_class_data=$et=M("zclx_tb")->where($where)->order("id")->select();
            //echo M("zclx_tb")->_sql();
        }

        //循环取出主分类表中的ID
        $set_class_id="";
        foreach($this->_class_data as $class_id){
            if ($set_class_id!="")
                $set_class_id.=",";
            $set_class_id.=$class_id["id"];
            //echo $set_class_id;

        }
    }
    //读取三级分类信息
    function loadmetaclass($id){
        $id=I("id");
        if (!$id){
            echo "Id Error";
        }else{
            $this->_class_meta_data=$ret=M("zclx_tb")->where("cglx_sjid in (".$id.") and cglx_jb=3")->order("id")->select();
            //echo M("zclx_tb")->_sql();
        }
    }
    //电子设备信息编辑
    function AddDzsbData(){
        //表信息
        $AddData=D("dzsb_tb");  //注意去除前缀
        //子表信息
        $AddData->zc_pp=I("zc_pp"); //品牌
        $AddData->zc_xh=I("zc_xh"); //型号
        if (I("zc_scrq")!=""){
            $AddData->zc_scrq=I("zc_scrq"); //生产日期
        }
        $AddData->zc_sccj=I("zc_sccj"); //生产厂家
        $AddData->zc_cccpbh=I("zc_cccpbh"); //出厂产品编号
        $AddData->zc_yt=I("zc_yt"); //用途
        //主表信息
        $AddData->zc_bh=I("zc_bh"); //资产编号|int
        $AddData->zc_lx=I("zc_lx"); //资产类型|LxSelect|zclx_tb|id|cglx_mc
        $AddData->zc_rjlxid=I("zc_rjlx"); //资产二级分类ID
        $AddData->zc_rjlx=I("zc_lxname"); //二级分类名称
        $AddData->zc_mc=I("zc_mc"); //资产名称
        $AddData->zc_jldw=I("zc_jldw"); //计量单位
        $AddData->zc_yz=I("zc_yz"); //原值
        $AddData->zc_jz=I("zc_jz"); //净值
        $AddData->zc_azcb=I("zc_azcb"); //其中:安装成本
        $AddData->zc_sfzjbz=I("zc_sfzjbz"); //是否折旧标志|RadioSelect
        $AddData->zc_zjnxlx=I("zc_zjnxlx"); //折旧年限类型
        $AddData->zc_ljzj=I("zc_ljzj"); //累计折旧
        $AddData->zc_bqzj=I("zc_bqzj"); //本期折旧
        $AddData->zc_gjrq=I("zc_gjrq"); //购建日期
        $AddData->zc_rzrq=I("zc_rzrq"); //入帐日期
        $AddData->zc_qyrq=I("zc_qyrq"); //启用日期
        $AddData->zc_qdfs=I("zc_qdfs"); //取得方式
        $AddData->zc_ccsybm=I("zc_ccsybm"); //财产使用部门
        $AddData->zc_sfxz=I("zc_sfxz"); //是否闲置
        $AddData->zc_ccglbm=I("zc_ccglbm"); //财产管理部门
        $AddData->zc_txm=I("zc_txm"); //条形码|Rcode
        $AddData->zc_zrr=I("zc_zrr"); //责任人
        $AddData->zc_pfdh=I("zc_pfdh"); //批复单号
        $AddData->zc_kpsm=I("zc_kpsm"); //卡片说明
        $AddData->zc_czrq=I("zc_czrq"); //出帐日期
        $AddData->zc_czlx=I("zc_czlx"); //出帐类型
        $AddData->zc_czyy=I("zc_czyy"); //出帐原因
        $AddData->add();
    }

    //机械器具信息编辑
    function AddJxqjData(){
        //表信息
        $AddData=D("dqsb_tb");  //注意去除前缀
        //子表信息
        $AddData->zc_pp=I("zc_pp"); //品牌
        $AddData->zc_xh=I("zc_xh"); //型号
        if (I("zc_scrq")!=""){
            $AddData->zc_scrq=I("zc_scrq"); //生产日期
        }
        $AddData->zc_sccj=I("zc_sccj"); //生产厂家
        $AddData->zc_cccpbh=I("zc_cccpbh"); //出厂产品编号
        $AddData->zc_yt=I("zc_yt"); //用途
        //主表信息
        $AddData->zc_bh=I("zc_bh"); //资产编号|int
        $AddData->zc_lx=I("zc_lx"); //资产类型|LxSelect|zclx_tb|id|cglx_mc
        $AddData->zc_rjlxid=I("zc_rjlx"); //资产二级分类ID
        $AddData->zc_rjlx=I("zc_lxname"); //二级分类名称
        $AddData->zc_mc=I("zc_mc"); //资产名称
        $AddData->zc_jldw=I("zc_jldw"); //计量单位
        $AddData->zc_yz=I("zc_yz"); //原值
        $AddData->zc_jz=I("zc_jz"); //净值
        $AddData->zc_azcb=I("zc_azcb"); //其中:安装成本
        $AddData->zc_sfzjbz=I("zc_sfzjbz"); //是否折旧标志|RadioSelect
        $AddData->zc_zjnxlx=I("zc_zjnxlx"); //折旧年限类型
        $AddData->zc_ljzj=I("zc_ljzj"); //累计折旧
        $AddData->zc_bqzj=I("zc_bqzj"); //本期折旧
        $AddData->zc_gjrq=I("zc_gjrq"); //购建日期
        $AddData->zc_rzrq=I("zc_rzrq"); //入帐日期
        $AddData->zc_qyrq=I("zc_qyrq"); //启用日期
        $AddData->zc_qdfs=I("zc_qdfs"); //取得方式
        $AddData->zc_ccsybm=I("zc_ccsybm"); //财产使用部门
        $AddData->zc_sfxz=I("zc_sfxz"); //是否闲置
        $AddData->zc_ccglbm=I("zc_ccglbm"); //财产管理部门
        $AddData->zc_txm=I("zc_txm"); //条形码|Rcode
        $AddData->zc_zrr=I("zc_zrr"); //责任人
        $AddData->zc_pfdh=I("zc_pfdh"); //批复单号
        $AddData->zc_kpsm=I("zc_kpsm"); //卡片说明
        $AddData->zc_czrq=I("zc_czrq"); //出帐日期
        $AddData->zc_czlx=I("zc_czlx"); //出帐类型
        $AddData->zc_czyy=I("zc_czyy"); //出帐原因
        $AddData->add();
    }
//其他设备信息编辑
    function AddQtsbData(){
        //表信息
        $AddData=D("qtzc_tb");  //注意去除前缀
        //子表信息
        $AddData->zc_pp=I("zc_pp"); //品牌
        $AddData->zc_xh=I("zc_xh"); //型号
        if (I("zc_scrq")!=""){
            $AddData->zc_scrq=I("zc_scrq"); //生产日期
        }
        $AddData->zc_sccj=I("zc_sccj"); //生产厂家
        $AddData->zc_cccpbh=I("zc_cccpbh"); //出厂产品编号
        $AddData->zc_yt=I("zc_yt"); //用途
        $AddData->zc_zcsm=I("zc_zcsm"); //资产说明
        //主表信息
        $AddData->zc_bh=I("zc_bh"); //资产编号|int
        $AddData->zc_lx=I("zc_lx"); //资产类型|LxSelect|zclx_tb|id|cglx_mc
        $AddData->zc_rjlxid=I("zc_rjlx"); //资产二级分类ID
        $AddData->zc_rjlx=I("zc_lxname"); //二级分类名称
        $AddData->zc_mc=I("zc_mc"); //资产名称
        $AddData->zc_jldw=I("zc_jldw"); //计量单位
        $AddData->zc_yz=I("zc_yz"); //原值
        $AddData->zc_jz=I("zc_jz"); //净值
        $AddData->zc_azcb=I("zc_azcb"); //其中:安装成本
        $AddData->zc_sfzjbz=I("zc_sfzjbz"); //是否折旧标志|RadioSelect
        $AddData->zc_zjnxlx=I("zc_zjnxlx"); //折旧年限类型
        $AddData->zc_ljzj=I("zc_ljzj"); //累计折旧
        $AddData->zc_bqzj=I("zc_bqzj"); //本期折旧
        $AddData->zc_gjrq=I("zc_gjrq"); //购建日期
        $AddData->zc_rzrq=I("zc_rzrq"); //入帐日期
        $AddData->zc_qyrq=I("zc_qyrq"); //启用日期
        $AddData->zc_qdfs=I("zc_qdfs"); //取得方式
        $AddData->zc_ccsybm=I("zc_ccsybm"); //财产使用部门
        $AddData->zc_sfxz=I("zc_sfxz"); //是否闲置
        $AddData->zc_ccglbm=I("zc_ccglbm"); //财产管理部门
        $AddData->zc_txm=I("zc_txm"); //条形码|Rcode
        $AddData->zc_zrr=I("zc_zrr"); //责任人
        $AddData->zc_pfdh=I("zc_pfdh"); //批复单号
        $AddData->zc_kpsm=I("zc_kpsm"); //卡片说明
        $AddData->zc_czrq=I("zc_czrq"); //出帐日期
        $AddData->zc_czlx=I("zc_czlx"); //出帐类型
        $AddData->zc_czyy=I("zc_czyy"); //出帐原因
        $AddData->add();
    }
    //其他设备信息编辑
    function AddClxxData(){
        //表信息
        $AddData=D("ysgj_tb");  //注意去除前缀
        //子表信息
        $AddData->zc_gzcpp=I("zc_gzcpp"); //改装车品牌
        $AddData->zc_gzcxh=I("zc_gzcxh"); //改装车型号
        $AddData->zc_jzzl=I("zc_jzzl"); //净载重量
        $AddData->zc_dppp=I("zc_dppp"); //底盘品牌
        $AddData->zc_dpxh=I("zc_dpxh"); //底盘型号
        $AddData->zc_clpzh=I("zc_clpzh"); //车辆牌照号
        $AddData->zc_clzs=I("zc_clzs"); //车辆座数
        $AddData->zc_fdxbh=I("zc_fdxbh"); //发动机编号
        $AddData->zc_cjh=I("zc_cjh"); //车架号
        $AddData->zc_scrq=I("zc_scrq"); //生产日期
        $AddData->zc_sccj=I("zc_sccj"); //生产厂家
        $AddData->zc_cccpbh=I("zc_cccpbh"); //出厂产品编号
        $AddData->zc_csys=I("zc_csys"); //车上颜色
        $AddData->zc_pql=I("zc_pql"); //排气量
        $AddData->zc_ljxsgl=I("zc_ljxsgl"); //累计行驶公里
        $AddData->zc_dw=I("zc_dw"); //吨位
        //主表信息
        $AddData->zc_bh=I("zc_bh"); //资产编号|int
        $AddData->zc_lx=I("zc_lx"); //资产类型|LxSelect|zclx_tb|id|cglx_mc
        $AddData->zc_rjlxid=I("zc_rjlx"); //资产二级分类ID
        $AddData->zc_rjlx=I("zc_lxname"); //二级分类名称
        $AddData->zc_mc=I("zc_mc"); //资产名称
        $AddData->zc_jldw=I("zc_jldw"); //计量单位
        $AddData->zc_yz=I("zc_yz"); //原值
        $AddData->zc_jz=I("zc_jz"); //净值
        $AddData->zc_azcb=I("zc_azcb"); //其中:安装成本
        $AddData->zc_sfzjbz=I("zc_sfzjbz"); //是否折旧标志|RadioSelect
        $AddData->zc_zjnxlx=I("zc_zjnxlx"); //折旧年限类型
        $AddData->zc_ljzj=I("zc_ljzj"); //累计折旧
        $AddData->zc_bqzj=I("zc_bqzj"); //本期折旧
        $AddData->zc_gjrq=I("zc_gjrq"); //购建日期
        $AddData->zc_rzrq=I("zc_rzrq"); //入帐日期
        $AddData->zc_qyrq=I("zc_qyrq"); //启用日期
        $AddData->zc_qdfs=I("zc_qdfs"); //取得方式
        $AddData->zc_ccsybm=I("zc_ccsybm"); //财产使用部门
        $AddData->zc_sfxz=I("zc_sfxz"); //是否闲置
        $AddData->zc_ccglbm=I("zc_ccglbm"); //财产管理部门
        $AddData->zc_txm=I("zc_txm"); //条形码|Rcode
        $AddData->zc_zrr=I("zc_zrr"); //责任人
        $AddData->zc_pfdh=I("zc_pfdh"); //批复单号
        $AddData->zc_kpsm=I("zc_kpsm"); //卡片说明
        $AddData->zc_czrq=I("zc_czrq"); //出帐日期
        $AddData->zc_czlx=I("zc_czlx"); //出帐类型
        $AddData->zc_czyy=I("zc_czyy"); //出帐原因
        $AddData->add();
    }
    //电子设备信息列表
    function loadDzsbdata($Expcount){
        $TableName=M("dzsb_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
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
            $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        if ($Expcount==""){
            $Page = new \Think\Page($count,$this->_page_size);
        }else{
            $Page = new \Think\Page($count,$count);
        }
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    function loadJxqjdata($where){
        $TableName=M("dqsb_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["zc_pp"]  = array('like',"%$this->_keyword%");
            $where["zc_xh"]  = array('like',"%$this->_keyword%");
            //$where["zc_scrq"]  = array('like',"%$this->_keyword%");
            $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");
            $where["zc_sccj"]  = array('like',"%$this->_keyword%");
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
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    function loadQtsbdata($where){
        $TableName=M("qtzc_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["zc_pp"]  = array('like',"%$this->_keyword%");
            $where["zc_xh"]  = array('like',"%$this->_keyword%");
            //$where["zc_scrq"]  = array('like',"%$this->_keyword%");
            $where["zc_sccj"]  = array('like',"%$this->_keyword%");
            $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");
            $where["zc_zcsm"]  = array('like',"%$this->_keyword%");
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
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //加载车辆信息
    function loadClxxdata($where){
        $TableName=M("ysgj_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
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
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //初始化维修金额
    function Cswxje(){
        $wxje=I("wxje");
        $id=I("id");
        $table=I("table");
        if (!$wxje || !$id || !$table){
            echo "数据填写不完整请检查后重新提交。";
            exit();
        }else{
            $Edittable=D("$table");
            $Wxtje=M("sbxx_log_tb")->where("sbid=$id and sblx='$table' and ywlx='维修记录'")->field('id,zc_fsje,sbbh')->sum('zc_fsje');
            $wxzje=$Wxtje+$wxje;
            $Edittable->wxzje=$wxzje;
            $Edittable->wxje=$wxje;
            $Edittable->where("id=$id")->save();
            echo "维修初始金额保存成功";
            //echo $wxzje;
        }
    }
    //初始化维修金额
    function CswxjeNew($table){
        $wxje=I("CsWxje");
        $id=I("id");
        $table=$table;
        if (!$wxje || !$id || !$table){
            echo "数据填写不完整请检查后重新提交。";
            exit();
        }else{
            $Edittable=D("$table");
            $Wxtje=M("sbxx_log_tb")->where("sbid=$id and sblx='$table' and ywlx='维修记录'")->field('id,zc_fsje,sbbh')->sum('zc_fsje');
            $wxzje=$Wxtje+$wxje;
            $Edittable->wxzje=$wxzje;
            $Edittable->wxje=$wxje;
            $Edittable->where("id=$id")->save();
            echo "维修初始金额保存成功";
            //echo $wxzje;
        }
    }
    //通过大类读取二级分类
    function ZclxSelect(){
        $lx=I("lx");
        $TableName=M("zclx_tb");
        if (!$lx){
            echo "参数出错，请检查";
            exit();
        }else{
            if ($lx=='dzsb_tb'){
                $this->_main_data=$TableName->where("cglx_sjid=59")->order("id DESC")->select(); //主表数据取值完成
            }
            if ($lx=='dqsb_tb'){
                $this->_main_data=$TableName->where("cglx_sjid=87")->order("id DESC")->select(); //主表数据取值完成
            }
            if ($lx=='ysgj_tb'){
                $this->_main_data=$TableName->where("cglx_sjid=95")->order("id DESC")->select(); //主表数据取值完成
            }
            if ($lx=='qtzc_tb'){
                $this->_main_data=$TableName->where("cglx_sjid=96")->order("id DESC")->select(); //主表数据取值完成
            }
        }
    }
    //通过二级分类读取资产名称
    function ZcmcSelect(){
        $lx=I("lx");
        $TableName=M("zclx_tb");
        if (!$lx){
            echo "参数出错，请检查";
            exit();
        }else{
            $this->_main_data=$TableName->where("cglx_sjid=$lx")->select(); //主表数据取值完成
        }
    }
    //自定义查询功能实现
    function SearchZcInfo(){
        $zc_zt=I("zc_zt");
        $lx=I("zc_lx");
        $zc_bh=I("zc_bh");
        $zc_lx=I("zc_lx");
        $zc_rjlx=I("zc_rjlx");
        $zc_mc=I("zc_mc");
        $zc_jldw=I("zc_jldw");
        $zc_yz=I("zc_yz");
        $zc_dj=I("zc_dj");
        $zc_azcb=I("zc_azcb");
        $zc_sfzjbz=I("zc_sfzjbz");
        $zc_zjnxlx=I("zc_zjnxlx");
        $zc_ljzj=I("zc_ljzj");
        $zc_gjrq=I("zc_gjrq");
        $zc_rzrq=I("zc_rzrq");
        $zc_qyrq=I("zc_qyrq");
        $zc_qdfs=I("zc_qdfs");
        $zc_ccsybm=I("zc_ccsybm");
        $zc_sfxz=I("zc_sfxz");
        $zc_ccglbm=I("zc_ccglbm");
        $zc_txm=I("zc_txm");
        $zc_zrr=I("zc_zrr");
        $zc_pfdh=I("zc_pfdh");
        $zc_kpsm=I("zc_kpsm");
        $zc_czrq=I("zc_czrq");
        $zc_zcdjr=I("zc_zcdjr");

        $this->_zc_zt=$zc_zt;
        $this->_lx=$lx;
        $this->_zc_bh=$zc_bh;
        $this->_zc_lx=$zc_lx;
        $this->_zc_rjlx=$zc_rjlx;
        $this->_zc_mc=$zc_mc;
        $this->_zc_jldw=$zc_jldw;
        $this->_zc_yz=$zc_yz;
        $this->_zc_dj=$zc_dj;
        $this->_zc_azcb=$zc_azcb;
        $this->_zc_sfzjbz=$zc_sfzjbz;
        $this->_zc_zjnxlx=$zc_zjnxlx;
        $this->_zc_ljzj=$zc_ljzj;
        $this->_zc_gjrq=$zc_gjrq;
        $this->_zc_rzrq=$zc_rzrq;
        $this->_zc_qyrq=$zc_qyrq;
        $this->_zc_qdfs=$zc_qdfs;
        $this->_zc_ccsybm=$zc_ccsybm;
        $this->_zc_sfxz=$zc_sfxz;
        $this->_zc_ccglbm=$zc_ccglbm;
        $this->_zc_txm=$zc_txm;
        $this->_zc_zzr=$zc_zrr;
        $this->_zc_pfdh=$zc_pfdh;
        $this->_zc_kpsm=$zc_kpsm;
        $this->_zc_czrq=$zc_czrq;
        $this->_zc_zcdjr=$zc_zcdjr;

        if (!$zc_zt || !$lx){
            echo "请选择需要搜索卡片的类型及资产类型";
        }else{
            $TableName=M("$lx");
            if ($lx=='dzsb_tb'){
               /* $where["zc_pp"]  = array('like',"%$this->_keyword%");
                $where["zc_xh"]  = array('like',"%$this->_keyword%");
                //$where["zc_scrq"]  = array('like',"%$this->_keyword%");
                $where["zc_sccj"]  = array('like',"%$this->_keyword%");
                $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");
                $where["zc_yt"]  = array('like',"%$this->_keyword%");*/
               if ($zc_bh!=""){
                   $where["zc_bh"]  = array('eq',"$zc_bh");
               }
                if ($zc_rjlx!=""){
                    $where["zc_rjlxid"]  = array('eq',"$zc_rjlx");
                }
                if ($zc_mc!=""){
                    $where["zc_mc"]  = array('like',"$zc_mc%");
                }
                if ($zc_jldw!=""){
                    $where["zc_jldw"]  = array('eq',"$zc_jldw");
                }
                if ($zc_yz!=""){
                    $where["zc_yz"]  = array('eq',"$zc_yz");
                }
                if ($zc_dj!=""){
                    $where["zc_dj"]  = array('eq',"$zc_dj");
                }
                if ($zc_azcb!=""){
                    $where["zc_azcb"]  = array('eq',"$zc_azcb");
                }
                if ($zc_sfzjbz!=""){
                    $where["zc_sfzjbz"]  = array('eq',"$zc_sfzjbz");
                }
                if ($zc_zjnxlx!=""){
                    $where["zc_zjnxlx"]  = array('eq',"$zc_zjnxlx");
                }
                if ($zc_ljzj!=""){
                    $where["zc_ljzj"]  = array('eq',"$zc_ljzj");
                }
                if ($zc_gjrq!=""){
                    $where["zc_gjrq"]  = array('EGT',"$zc_gjrq");
                }
                if ($zc_rzrq!=""){
                    $where["zc_rzrq"]  = array('EGT',"$zc_rzrq");
                }
                if ($zc_qyrq!=""){
                    $where["zc_qyrq"]  = array('EGT',"$zc_qyrq");
                }
                if ($zc_qdfs!=""){
                    $where["zc_qdfs"]  = array('eq',"$zc_qdfs");
                }
                if ($zc_ccsybm!=""){
                    $where["zc_ccsybm"]  = array('eq',"$zc_ccsybm");
                }
                if ($zc_sfxz!=""){
                    $where["zc_sfxz"]  = array('eq',"$zc_sfxz");
                }
                if ($zc_ccglbm!=""){
                    $where["zc_ccglbm"]  = array('eq',"$zc_ccglbm");
                }
                if ($zc_txm!=""){
                    $where["zc_txm"]  = array('eq',"$zc_txm");
                }
                if ($zc_zrr!=""){
                    $where["zc_zrr"]  = array('eq',"$zc_zrr");
                }
                if ($zc_pfdh!=""){
                    $where["zc_pfdh"]  = array('eq',"$zc_pfdh");
                }
                if ($zc_kpsm!=""){
                    $where["zc_kpsm"]  = array('eq',"$zc_kpsm");
                }
                if ($zc_czrq!=""){
                    $where["zc_czrq"]  = array('EGT',"$zc_czrq");
                }
                if ($zc_zcdjr!=""){
                    $where["zc_zcdjr"]  = array('eq',"$zc_zcdjr");
                }
                $this->_page_count=$TableName->where($where)->order("id DESC")->count();    //统计数据
                $this->_main_data=$TableName->where($where)->order("id DESC")->select(); //主表数据取值完成
                //echo $TableName->_sql();
            }
            elseif ($lx=='dqsb_tb'){
                if ($zc_bh!=""){
                    $where["zc_bh"]  = array('eq',"$zc_bh");
                }
                if ($zc_rjlx!=""){
                    $where["zc_rjlxid"]  = array('eq',"$zc_rjlx");
                }
                if ($zc_mc!=""){
                    $where["zc_mc"]  = array('like',"$zc_mc%");
                }
                if ($zc_jldw!=""){
                    $where["zc_jldw"]  = array('eq',"$zc_jldw");
                }
                if ($zc_yz!=""){
                    $where["zc_yz"]  = array('eq',"$zc_yz");
                }
                if ($zc_dj!=""){
                    $where["zc_dj"]  = array('eq',"$zc_dj");
                }
                if ($zc_azcb!=""){
                    $where["zc_azcb"]  = array('eq',"$zc_azcb");
                }
                if ($zc_sfzjbz!=""){
                    $where["zc_sfzjbz"]  = array('eq',"$zc_sfzjbz");
                }
                if ($zc_zjnxlx!=""){
                    $where["zc_zjnxlx"]  = array('eq',"$zc_zjnxlx");
                }
                if ($zc_ljzj!=""){
                    $where["zc_ljzj"]  = array('eq',"$zc_ljzj");
                }
                if ($zc_gjrq!=""){
                    $where["zc_gjrq"]  = array('EGT',"$zc_gjrq");
                }
                if ($zc_rzrq!=""){
                    $where["zc_rzrq"]  = array('EGT',"$zc_rzrq");
                }
                if ($zc_qyrq!=""){
                    $where["zc_qyrq"]  = array('EGT',"$zc_qyrq");
                }
                if ($zc_qdfs!=""){
                    $where["zc_qdfs"]  = array('eq',"$zc_qdfs");
                }
                if ($zc_ccsybm!=""){
                    $where["zc_ccsybm"]  = array('eq',"$zc_ccsybm");
                }
                if ($zc_sfxz!=""){
                    $where["zc_sfxz"]  = array('eq',"$zc_sfxz");
                }
                if ($zc_ccglbm!=""){
                    $where["zc_ccglbm"]  = array('eq',"$zc_ccglbm");
                }
                if ($zc_txm!=""){
                    $where["zc_txm"]  = array('eq',"$zc_txm");
                }
                if ($zc_zrr!=""){
                    $where["zc_zrr"]  = array('eq',"$zc_zrr");
                }
                if ($zc_pfdh!=""){
                    $where["zc_pfdh"]  = array('eq',"$zc_pfdh");
                }
                if ($zc_kpsm!=""){
                    $where["zc_kpsm"]  = array('eq',"$zc_kpsm");
                }
                if ($zc_czrq!=""){
                    $where["zc_czrq"]  = array('EGT',"$zc_czrq");
                }
                if ($zc_zcdjr!=""){
                    $where["zc_zcdjr"]  = array('eq',"$zc_zcdjr");
                }
                $this->_page_count=$TableName->where($where)->order("id DESC")->count();    //统计数据
                $this->_main_data=$TableName->where($where)->order("id DESC")->select(); //主表数据取值完成
                //echo $TableName->_sql();
            }
            elseif ($lx=='ysgj_tb'){
                if ($zc_bh!=""){
                    $where["zc_bh"]  = array('eq',"$zc_bh");
                }
                if ($zc_rjlx!=""){
                    $where["zc_rjlxid"]  = array('eq',"$zc_rjlx");
                }
                if ($zc_mc!=""){
                    $where["zc_mc"]  = array('like',"$zc_mc%");
                }
                if ($zc_jldw!=""){
                    $where["zc_jldw"]  = array('eq',"$zc_jldw");
                }
                if ($zc_yz!=""){
                    $where["zc_yz"]  = array('eq',"$zc_yz");
                }
                if ($zc_dj!=""){
                    $where["zc_dj"]  = array('eq',"$zc_dj");
                }
                if ($zc_azcb!=""){
                    $where["zc_azcb"]  = array('eq',"$zc_azcb");
                }
                if ($zc_sfzjbz!=""){
                    $where["zc_sfzjbz"]  = array('eq',"$zc_sfzjbz");
                }
                if ($zc_zjnxlx!=""){
                    $where["zc_zjnxlx"]  = array('eq',"$zc_zjnxlx");
                }
                if ($zc_ljzj!=""){
                    $where["zc_ljzj"]  = array('eq',"$zc_ljzj");
                }
                if ($zc_gjrq!=""){
                    $where["zc_gjrq"]  = array('EGT',"$zc_gjrq");
                }
                if ($zc_rzrq!=""){
                    $where["zc_rzrq"]  = array('EGT',"$zc_rzrq");
                }
                if ($zc_qyrq!=""){
                    $where["zc_qyrq"]  = array('EGT',"$zc_qyrq");
                }
                if ($zc_qdfs!=""){
                    $where["zc_qdfs"]  = array('eq',"$zc_qdfs");
                }
                if ($zc_ccsybm!=""){
                    $where["zc_ccsybm"]  = array('eq',"$zc_ccsybm");
                }
                if ($zc_sfxz!=""){
                    $where["zc_sfxz"]  = array('eq',"$zc_sfxz");
                }
                if ($zc_ccglbm!=""){
                    $where["zc_ccglbm"]  = array('eq',"$zc_ccglbm");
                }
                if ($zc_txm!=""){
                    $where["zc_txm"]  = array('eq',"$zc_txm");
                }
                if ($zc_zrr!=""){
                    $where["zc_zrr"]  = array('eq',"$zc_zrr");
                }
                if ($zc_pfdh!=""){
                    $where["zc_pfdh"]  = array('eq',"$zc_pfdh");
                }
                if ($zc_kpsm!=""){
                    $where["zc_kpsm"]  = array('eq',"$zc_kpsm");
                }
                if ($zc_czrq!=""){
                    $where["zc_czrq"]  = array('EGT',"$zc_czrq");
                }
                if ($zc_zcdjr!=""){
                    $where["zc_zcdjr"]  = array('eq',"$zc_zcdjr");
                }
                $this->_page_count=$TableName->where($where)->order("id DESC")->count();    //统计数据
                $this->_main_data=$TableName->where($where)->order("id DESC")->select(); //主表数据取值完成
                //echo $TableName->_sql();
            }
            elseif ($lx=='qtzc_tb'){
                if ($zc_bh!=""){
                    $where["zc_bh"]  = array('eq',"$zc_bh");
                }
                if ($zc_rjlx!=""){
                    $where["zc_rjlxid"]  = array('eq',"$zc_rjlx");
                }
                if ($zc_mc!=""){
                    $where["zc_mc"]  = array('like',"$zc_mc%");
                }
                if ($zc_jldw!=""){
                    $where["zc_jldw"]  = array('eq',"$zc_jldw");
                }
                if ($zc_yz!=""){
                    $where["zc_yz"]  = array('eq',"$zc_yz");
                }
                if ($zc_dj!=""){
                    $where["zc_dj"]  = array('eq',"$zc_dj");
                }
                if ($zc_azcb!=""){
                    $where["zc_azcb"]  = array('eq',"$zc_azcb");
                }
                if ($zc_sfzjbz!=""){
                    $where["zc_sfzjbz"]  = array('eq',"$zc_sfzjbz");
                }
                if ($zc_zjnxlx!=""){
                    $where["zc_zjnxlx"]  = array('eq',"$zc_zjnxlx");
                }
                if ($zc_ljzj!=""){
                    $where["zc_ljzj"]  = array('eq',"$zc_ljzj");
                }
                if ($zc_gjrq!=""){
                    $where["zc_gjrq"]  = array('EGT',"$zc_gjrq");
                }
                if ($zc_rzrq!=""){
                    $where["zc_rzrq"]  = array('EGT',"$zc_rzrq");
                }
                if ($zc_qyrq!=""){
                    $where["zc_qyrq"]  = array('EGT',"$zc_qyrq");
                }
                if ($zc_qdfs!=""){
                    $where["zc_qdfs"]  = array('eq',"$zc_qdfs");
                }
                if ($zc_ccsybm!=""){
                    $where["zc_ccsybm"]  = array('eq',"$zc_ccsybm");
                }
                if ($zc_sfxz!=""){
                    $where["zc_sfxz"]  = array('eq',"$zc_sfxz");
                }
                if ($zc_ccglbm!=""){
                    $where["zc_ccglbm"]  = array('eq',"$zc_ccglbm");
                }
                if ($zc_txm!=""){
                    $where["zc_txm"]  = array('eq',"$zc_txm");
                }
                if ($zc_zrr!=""){
                    $where["zc_zrr"]  = array('eq',"$zc_zrr");
                }
                if ($zc_pfdh!=""){
                    $where["zc_pfdh"]  = array('eq',"$zc_pfdh");
                }
                if ($zc_kpsm!=""){
                    $where["zc_kpsm"]  = array('eq',"$zc_kpsm");
                }
                if ($zc_czrq!=""){
                    $where["zc_czrq"]  = array('EGT',"$zc_czrq");
                }
                if ($zc_zcdjr!=""){
                    $where["zc_zcdjr"]  = array('eq',"$zc_zcdjr");
                }
                $this->_page_count=$TableName->where($where)->order("id DESC")->count();    //统计数据
                $this->_main_data=$TableName->where($where)->order("id DESC")->select(); //主表数据取值完成
                //echo $TableName->_sql();
            }
        }

    }
    //通过直线折旧法更新设备净值
    function JzJsUpdate(){
        //判断是否本月第一次登录
        $Dtime=date("Y-m"); //获取当前月份
        $UserLogTable=M("user_log");
        $count=$UserLogTable->where("log_date like '$Dtime%'")->count();
        if ($count>0){
            //echo "无需更新净值";
        }else{
            //echo "应更新净值";
            //读取资产分类信息
            $ii= new JcxxAPI();
            $ii->RjList();
            $ii->_class_meta_data;
            //var_export($ii->_class_meta_data);
            //$set_class_id="";
            //电子设备表更新
            foreach($ii->_class_meta_data as $class){
                $zctable=D("dzsb_tb");
                $class_name=$class['cglx_mc'];
                $zjnx=$class['zjnx']; //取得当前分类折旧年限
                $czl=$class['zcl'];  //取得当前分类残值率
                $zcyf=$zjnx*12; //从折旧年限换算折旧总月数
                //echo $zjnx."<br />";
                $ret=$zctable->where("zc_rjlx='$class_name'")->select();
                //echo $zctable->_sql();
                foreach($ret as $D){
                    $yz=$D['zc_yz']; //获取设备原值
                    $Date_1 = date("Y-m-d"); //获取系统当前日期
                    $Date_2 = $D['zc_gjrq'];
                    $d1 = strtotime($Date_1);
                    $d2 = strtotime($Date_2);
                    $Days = round(($d1-$d2)/3600/24/30); //计算“购建日期”到当前日期的使用月数
                    //$gjyf=date("Y-m-d",$D['zc_rzrq']);
                    $zjjs=round($yz/$zcyf,2); //保留两位小数显示每月应扣减的折旧金额
                    $jz_t=$zjjs*$Days;  //应扣折旧总金额计算
                    $jz=$yz-$jz_t; //净值金额计算
                    $jz_v=$jz/$yz; //当前净值比计算
                    if ($jz_v<$czl){ //如果净值率小于残值率，则净值等于残值
                        $jz=round($yz*$czl,2);
                    }
                    //echo "原值：".$yz."，每月扣旧金额：".$zjjs."，折旧月份：".$zcyf."，残值率：".$czl."，使用月份：".$Days."，购建日期：".$Date_2."，当前净值：".$jz."<br />";
                    $zjzyf=$zcyf-$Days;
                    //echo $zjzyf;
                    if ($zjzyf>=0){ //判断使用月份大于等于0的时候更新净值
                        //$zctable->zc_jz=$jz;
                        $id=$D['id'];
                        $zctable->where("id=$id")->setField('zc_jz',$jz);
                        //echo $zctable->_sql()."<br />";
                    }
                }
            }
            //机械器具表更新
            foreach($ii->_class_meta_data as $class){
                $zctable=D("dqsb_tb");
                $class_name=$class['cglx_mc'];
                $zjnx=$class['zjnx']; //取得当前分类折旧年限
                $czl=$class['zcl'];  //取得当前分类残值率
                $zcyf=$zjnx*12; //从折旧年限换算折旧总月数
                //echo $zjnx."<br />";
                $ret=$zctable->where("zc_rjlx='$class_name'")->select();
                //echo $zctable->_sql();
                foreach($ret as $D){
                    $yz=$D['zc_yz']; //获取设备原值
                    $Date_1 = date("Y-m-d"); //获取系统当前日期
                    $Date_2 = $D['zc_gjrq'];
                    $d1 = strtotime($Date_1);
                    $d2 = strtotime($Date_2);
                    $Days = round(($d1-$d2)/3600/24/30); //计算“购建日期”到当前日期的使用月数
                    //$gjyf=date("Y-m-d",$D['zc_rzrq']);
                    $zjjs=round($yz/$zcyf,2); //保留两位小数显示每月应扣减的折旧金额
                    $jz_t=$zjjs*$Days;  //应扣折旧总金额计算
                    $jz=$yz-$jz_t; //净值金额计算
                    $jz_v=$jz/$yz; //当前净值比计算
                    if ($jz_v<$czl){ //如果净值率小于残值率，则净值等于残值
                        $jz=round($yz*$czl,2);
                    }
                    //echo "原值：".$yz."，每月扣旧金额：".$zjjs."，折旧月份：".$zcyf."，残值率：".$czl."，使用月份：".$Days."，购建日期：".$Date_2."，当前净值：".$jz."<br />";
                    $zjzyf=$zcyf-$Days;
                    //echo $zjzyf;
                    if ($zjzyf>=0){ //判断使用月份大于等于0的时候更新净值
                        //$zctable->zc_jz=$jz;
                        $id=$D['id'];
                        $zctable->where("id=$id")->setField('zc_jz',$jz);
                        //echo $zctable->_sql()."<br />";
                    }
                }
            }
            //运输工具表更新
            foreach($ii->_class_meta_data as $class){
                $zctable=D("ysgj_tb");
                $class_name=$class['cglx_mc'];
                $zjnx=$class['zjnx']; //取得当前分类折旧年限
                $czl=$class['zcl'];  //取得当前分类残值率
                $zcyf=$zjnx*12; //从折旧年限换算折旧总月数
                //echo $zjnx."<br />";
                $ret=$zctable->where("zc_rjlx='$class_name'")->select();
                //echo $zctable->_sql();
                foreach($ret as $D){
                    $yz=$D['zc_yz']; //获取设备原值
                    $Date_1 = date("Y-m-d"); //获取系统当前日期
                    $Date_2 = $D['zc_gjrq'];
                    $d1 = strtotime($Date_1);
                    $d2 = strtotime($Date_2);
                    $Days = round(($d1-$d2)/3600/24/30); //计算“购建日期”到当前日期的使用月数
                    //$gjyf=date("Y-m-d",$D['zc_rzrq']);
                    $zjjs=round($yz/$zcyf,2); //保留两位小数显示每月应扣减的折旧金额
                    $jz_t=$zjjs*$Days;  //应扣折旧总金额计算
                    $jz=$yz-$jz_t; //净值金额计算
                    $jz_v=$jz/$yz; //当前净值比计算
                    if ($jz_v<$czl){ //如果净值率小于残值率，则净值等于残值
                        $jz=round($yz*$czl,2);
                    }
                    //echo "原值：".$yz."，每月扣旧金额：".$zjjs."，折旧月份：".$zcyf."，残值率：".$czl."，使用月份：".$Days."，购建日期：".$Date_2."，当前净值：".$jz."<br />";
                    $zjzyf=$zcyf-$Days;
                    //echo $zjzyf;
                    if ($zjzyf>=0){ //判断使用月份大于等于0的时候更新净值
                        //$zctable->zc_jz=$jz;
                        $id=$D['id'];
                        $zctable->where("id=$id")->setField('zc_jz',$jz);
                        //echo $zctable->_sql()."<br />";
                    }
                }
            }
            //其他资产表更新
            foreach($ii->_class_meta_data as $class){
                $zctable=D("qtzc_tb");
                $class_name=$class['cglx_mc'];
                $zjnx=$class['zjnx']; //取得当前分类折旧年限
                $czl=$class['zcl'];  //取得当前分类残值率
                $zcyf=$zjnx*12; //从折旧年限换算折旧总月数
                //echo $zjnx."<br />";
                $ret=$zctable->where("zc_rjlx='其他资产'")->select();
                //echo $zctable->_sql();
                foreach($ret as $D){
                    $yz=$D['zc_yz']; //获取设备原值
                    $Date_1 = date("Y-m-d"); //获取系统当前日期
                    $Date_2 = $D['zc_gjrq'];
                    $d1 = strtotime($Date_1);
                    $d2 = strtotime($Date_2);
                    $Days = round(($d1-$d2)/3600/24/30); //计算“购建日期”到当前日期的使用月数
                    //$gjyf=date("Y-m-d",$D['zc_rzrq']);
                    $zjjs=round($yz/$zcyf,2); //保留两位小数显示每月应扣减的折旧金额
                    $jz_t=$zjjs*$Days;  //应扣折旧总金额计算
                    $jz=$yz-$jz_t; //净值金额计算
                    $jz_v=$jz/$yz; //当前净值比计算
                    if ($jz_v<$czl){ //如果净值率小于残值率，则净值等于残值
                        $jz=round($yz*$czl,2);
                    }
                    //echo "原值：".$yz."，每月扣旧金额：".$zjjs."，折旧月份：".$zcyf."，残值率：".$czl."，使用月份：".$Days."，购建日期：".$Date_2."，当前净值：".$jz."<br />";
                    $zjzyf=$zcyf-$Days;
                    //echo $zjzyf;
                    if ($zjzyf>=0){ //判断使用月份大于等于0的时候更新净值
                        //$zctable->zc_jz=$jz;
                        $id=$D['id'];
                        $zctable->where("id=$id")->setField('zc_jz',$jz);
                        //echo $zctable->_sql()."<br />";
                    }
                }
            }

        }
    }
    //电子设备更新
    function WxlJsUpdate(){
        $Table=M("dzsb_tb");
        $ret=$Table->select();
        //echo $Table->_sql();
        foreach($ret as $D){
            $zc_bh=$D['zc_bh'];
            $wxje=$D['wxje'];
            $dalcount=M("sbxx_log_tb")->where("sbbh=$zc_bh and ywlx='维修记录'")->count();
            $Page = new \Think\Page($dalcount,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_page_ys=$Page->totalPages;
            $dal_je=M("sbxx_log_tb")->where("sbbh=$zc_bh and ywlx='维修记录'")->field('id,zc_fsje,sbbh')->sum('zc_fsje');
            if (!$dal_je){
                $dal_je=0;
            }
            $id=$D['id'];
            $wxzje=$dal_je+$wxje;
            $Table->wxzje=$wxzje;
            $Table->wxcs=$dalcount;
            $Table->where("id=$id")->save();
            //echo $zc_bh.",初始维修金额：".$wxje.",维修次数统计：".$dalcount.",维修记录金额：".$wxzje."<br />";
        }
    }
    //机械器具
    function WxldqUpdate(){
        $Table=M("dqsb_tb");
        $ret=$Table->select();
        //echo $Table->_sql();
        foreach($ret as $D){
            $zc_bh=$D['zc_bh'];
            $wxje=$D['wxje'];
            $dalcount=M("sbxx_log_tb")->where("sbbh=$zc_bh and ywlx='维修记录'")->count();
            $Page = new \Think\Page($dalcount,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_page_ys=$Page->totalPages;
            $dal_je=M("sbxx_log_tb")->where("sbbh=$zc_bh and ywlx='维修记录'")->field('id,zc_fsje,sbbh')->sum('zc_fsje');
            if (!$dal_je){
                $dal_je=0;
            }
            $id=$D['id'];
            $wxzje=$dal_je+$wxje;
            $Table->wxzje=$wxzje;
            $Table->wxcs=$dalcount;
            $Table->where("id=$id")->save();
            //echo $zc_bh.",初始维修金额：".$wxje.",维修次数统计：".$dalcount.",维修记录金额：".$wxzje."<br />";
        }
    }
    //运输工具
    function WxlysUpdate(){
        $Table=M("ysgj_tb");
        $ret=$Table->select();
        //echo $Table->_sql();
        foreach($ret as $D){
            $zc_bh=$D['zc_bh'];
            $wxje=$D['wxje'];
            $dalcount=M("sbxx_log_tb")->where("sbbh=$zc_bh and ywlx='维修记录'")->count();
            $Page = new \Think\Page($dalcount,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_page_ys=$Page->totalPages;
            $dal_je=M("sbxx_log_tb")->where("sbbh=$zc_bh and ywlx='维修记录'")->field('id,zc_fsje,sbbh')->sum('zc_fsje');
            if (!$dal_je){
                $dal_je=0;
            }
            $id=$D['id'];
            $wxzje=$dal_je+$wxje;
            $Table->wxzje=$wxzje;
            $Table->wxcs=$dalcount;
            $Table->where("id=$id")->save();
            //echo $zc_bh.",初始维修金额：".$wxje.",维修次数统计：".$dalcount.",维修记录金额：".$wxzje."<br />";
        }
    }
    //其他资产
    function WxlqtUpdate(){
        $Table=M("qtzc_tb");
        $ret=$Table->select();
        //echo $Table->_sql();
        foreach($ret as $D){
            $zc_bh=$D['zc_bh'];
            $wxje=$D['wxje'];
            $dalcount=M("sbxx_log_tb")->where("sbbh=$zc_bh and ywlx='维修记录'")->count();
            $Page = new \Think\Page($dalcount,$this->_page_size);
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_page_ys=$Page->totalPages;
            $dal_je=M("sbxx_log_tb")->where("sbbh=$zc_bh and ywlx='维修记录'")->field('id,zc_fsje,sbbh')->sum('zc_fsje');
            if (!$dal_je){
                $dal_je=0;
            }
            $id=$D['id'];
            $wxzje=$dal_je+$wxje;
            $Table->wxzje=$wxzje;
            $Table->wxcs=$dalcount;
            $Table->where("id=$id")->save();
            //echo $zc_bh.",初始维修金额：".$wxje.",维修次数统计：".$dalcount.",维修记录金额：".$wxzje."<br />";
        }
    }

    function ZcInfoUpload(){
        $config = C('uploadjson'); //读取上传文件配置类
        $upload=new \Think\Upload($config); // 实例化上传类
        $info=$upload->upload();
        if(!$info) {// 上传错误提示错误信息
            exit ($upload->getError());
        }else{// 上传成功
            //$this->success('上传成功！');
            foreach ($info as $file) {
                //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                $JsonFile=$file['savepath'] . $file['savename'];
            }
        }
        //echo $JsonFile;
        $filename='\\'.$file['savename'];
        $this->_Excel=$filename;
    }
    function upexcel(){

    }
    function UpDatabase($lx){
        $impret=M("zctmp_tb")->order("id desc")->select();
        //var_dump(array_diff_assoc($impret, $zcinfo));
        //var_dump(array_intersect($impret,$zcinfo));
        $table=M($lx);
        foreach ($impret as $imp){
            $bh=$imp['z5z'];
            if ($bh!=""){
                $where["zc_bh"]=array('eq',$bh);
                $count=$table->where($where)->count();
                if ($count==0){
                    $table->zc_jgdm=$imp['z1z'];
                    $table->zc_jgmc=$imp['z2z'];
                    $table->zc_jgxzjb=$imp['z3z'];
                    $table->zc_jgxzjbxx=$imp['z4z'];
                    $table->zc_bh=$imp['z5z'];
                    $table->zc_rjlx=$imp['z7z'];
                    $rjlx=$imp['z7z'];
                    $rjwhere["cglx_mc"]=array("eq",$rjlx);
                    $rxlxid=M("zclx_tb")->where($rjwhere)->getField("");
                    $table->zc_rjlxid=$rxlxid;
                    $table->zc_mc=$imp['z6z'];
                    $table->zc_jldw=$imp['z9z'];
                    $table->zc_yz=$imp['z10z'];
                    $table->zc_dj=$imp['z11z'];
                    $table->zc_azcb=$imp['z12z'];
                    $table->zc_jz=$imp['z13z'];
                    $table->zc_sfzjbz=$imp['z14z'];
                    $table->zc_zjnxlx=$imp['z17z'];
                    $table->zc_ljzj=$imp['z16z'];
                    $table->zc_bqzj=$imp['z15z'];
                    /*$table->zc_nzjl=$imp['z19z'];*/
                    $table->zc_gjrq=$imp['z20z'];
                    $table->zc_rzrq=$imp['z21z'];
                    $table->zc_qyrq=$imp['z22z'];
                    $table->zc_qdfs=$imp['z23z'];
                    $table->zc_ccsybm=$imp['z27z'];
                    $table->zc_sfxz=$imp['z25z'];
                    $table->zc_ccglbm=$imp['z26z'];
                    $table->zc_txm=$imp['z29z'];
                    $table->zc_zrr=$imp['z28z'];
                    /*$table->zc_pfdh=$imp['z1z'];
                    $table->zc_kpsm=$imp['z1z'];
                    $table->zc_czrq=$imp['z1z'];
                    $table->zc_czlx=$imp['z1z'];
                    $table->zc_czyy=$imp['z1z'];*/
                    $table->zc_zcdjr=$imp['z30z'];
                    $table->zc_pp=$imp['z31z'];
                    $table->zc_xh=$imp['z32z'];
                    $table->zc_scrq=$imp['z33z'];
                    $table->zc_sccj=$imp['z34z'];
                    $table->zc_cccpbh=$imp['z35z'];
                    $table->zc_kpsm=$imp['z36z'];
                    $table->zc_yt=$imp['z37z'];
                    $table->zc_zt=1;
                    $ret=$table->add();
                }
            }
        }
        if ($ret>0){
            $this->_lx=1;
        }else{
            $this->_lx=0;
        }
    }
    //读取电子设备信息
    function DzsbList(){

        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        $comp=I("comp"); //获取使用部门名称

        $TableName=M("dzsb_tb");
        $this->_comp=$comp;
        //echo $comp;
        //echo I("appid");
        //exit();
        $this->_keyword=$search;
        //echo $this->_keyword;
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
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        if ($this->_comp==1){
            $mmmap["zc_ccsybm"]  = array('eq','');
        }else{
            $mmmap["zc_ccsybm"]  = array('like',"$this->_comp%");
        }
        /*if ($zt!=0){
            $mmmap['zc_zt']=array('eq',1);
        }*/

        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($mmmap)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //echo $TableName->getLastSql();

    }
    //读取机械器具设备信息
    function JxsbList(){

        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        $comp=I("comp"); //获取使用部门名称

        $TableName=M("dqsb_tb");
        $this->_comp=$comp;
        //echo $comp;
        //echo I("appid");
        //exit();
        $this->_keyword=$search;
        //echo $this->_keyword;
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
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        if ($this->_comp==1){
            $mmmap["zc_ccsybm"]  = array('eq','');
        }else{
            $mmmap["zc_ccsybm"]  = array('like',"$this->_comp%");
        }
        /*if ($zt!=0){
            $mmmap['zc_zt']=array('eq',1);
        }*/

        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($mmmap)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //echo $TableName->getLastSql();

    }
    //读取其他设备信息
    function qtsbList(){

        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        $comp=I("comp"); //获取使用部门名称

        $TableName=M("qtzc_tb");
        $this->_comp=$comp;
        //echo $comp;
        //echo I("appid");
        //exit();
        $this->_keyword=$search;
        //echo $this->_keyword;
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
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        if ($this->_comp==1){
            $mmmap["zc_ccsybm"]  = array('eq','');
        }else{
            $mmmap["zc_ccsybm"]  = array('like',"$this->_comp%");
        }
        /*if ($zt!=0){
            $mmmap['zc_zt']=array('eq',1);
        }*/

        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order($sort." ". $order)->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($mmmap)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //echo $TableName->getLastSql();

    }
    //加载车辆信息
    function loadYsgjdata($sort,$order){

        $limit=I("limit"); //从前端获取每页显示的数量
        //$order=I("order"); //排序方式获取
        //$sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        $comp=I("comp"); //获取使用部门名称
        $id=I("id");
        //exit($id);
        //exit($sort);
        $TableName=M("ysgj_tb");
        $this->_keyword=$search;
        $this->_comp=$comp;

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
            $mmmap['_complex']=$where;
            if ($id!=""){
                $mmmap["id"]  = array('eq',$id);
            }
            if ($this->_comp==1){
                $mmmap["zc_ccsybm"]  = array('eq','');
            }else{
                $mmmap["zc_ccsybm"]  = array('like',"$this->_comp%");

            }
            /*if ($zt!=0){
                $mmmap['zc_zt']=array('eq',1);
            }*/

            $mmmap['_logic']='AND';

        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order($sort." ". $order)->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($mmmap)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //主表数据取值完成

    }
}