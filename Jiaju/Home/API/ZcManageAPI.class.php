<?php
namespace Home\API;

class ZcManageAPI
{
    public $_page_size = "1000"; //每页显示条数
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
    public $_comp="";
    public $_Jsoninfo="";
    public $_zt=""; //数据状态
    public $_page_ys="";
    public $_Msg="";

    //读取设备信息
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
                if ($count==0){
                    $this->_Msg='数据结果为0';
                }else{
                    $this->_Msg='获取成功';
                }

    }
    //读取净值比过高的电子设备信息
    function DzsbwjList(){

        $TableName=M("dzsb_tb");
        $this->_comp=I("comp");
        $this->_keyword=I("keyword");
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

        $mmmap['zc_zt']=array('eq',1);
        $mmmap['wjb']=array('EGT',0.5);
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
        $Expcount=$Expcount;
        $TableName=M("dqsb_tb");
        $this->_comp=I("comp");
        $this->_keyword=I("keyword");
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
        if ($zt!=0){
            $mmmap['zc_zt']=array('eq',1);
        }
        $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            if ($Expcount!=""){
                $Page = new \Think\Page($count,$count);
            }else{
                $Page = new \Think\Page($count,$this->_page_size);
            }

            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_page_ys=$Page->totalPages;
            $this->_Dqsbinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
            //echo $TableName->getLastSql();

    }
    //机械器具
    function DqsbwjList(){

        $TableName=M("dqsb_tb");
        $this->_comp=I("comp");
        $this->_keyword=I("keyword");
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
        $mmmap['zc_zt']=array('eq',1);
        $mmmap['wjb']=array('EGT',0.5);
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
        $this->_comp=I("comp");
        $this->_keyword=I("keyword");
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
        if ($zt!=0){
            $mmmap['zc_zt']=array('eq',1);
        }
        $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        if ($Expcount!=""){
            $Page = new \Think\Page($count,$count);
        }else{
            $Page = new \Think\Page($count,$this->_page_size);
        }
            //$Page->parameter=$this->_keyword;

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_page_ys=$Page->totalPages;
            $this->_Qtsbinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成


    }
    //维净比其他设备
    function QtsbwjList(){

        $TableName=M("qtzc_tb");
        $this->_comp=I("comp");
        $this->_keyword=I("keyword");
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
        $mmmap['zc_zt']=array('eq',1);
        $mmmap['wjb']=array('EGT',0.5);
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_Qtsbinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成


    }
    function YsgjList(){
        $Expcount="";
        $TableName=M("ysgj_tb");
        $this->_comp=I("comp");
        $this->_keyword=I("keyword");
        //echo $this->_keyword;
        $where["zc_gzcpp"]  = array('like',"%$this->_keyword%");
        $where["zc_gzcxh"]  = array('like',"%$this->_keyword%");
        //$where["zc_scrq"]  = array('like',"%$this->_keyword%");
        $where["zc_sccj"]  = array('like',"%$this->_keyword%");
        $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");
        //$where["zc_yt"]  = array('like',"%$this->_keyword%");
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
        if ($zt!=0){
            $mmmap['zc_zt']=array('eq',1);
        }
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        if ($Expcount!=""){
            $Page = new \Think\Page($count,$count);
        }else{
            $Page = new \Think\Page($count,$this->_page_size);
        }

            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_page_ys=$Page->totalPages;
            $this->_Ysgjinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
    }
    function YsgjwjList(){
        $TableName=M("ysgj_tb");
        $this->_comp=I("comp");
        $this->_keyword=I("keyword");
        //echo $this->_keyword;
        $where["zc_gzcpp"]  = array('like',"%$this->_keyword%");
        $where["zc_gzcxh"]  = array('like',"%$this->_keyword%");
        //$where["zc_scrq"]  = array('like',"%$this->_keyword%");
        $where["zc_sccj"]  = array('like',"%$this->_keyword%");
        $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");
        //$where["zc_yt"]  = array('like',"%$this->_keyword%");
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
        $mmmap['zc_zt']=array('eq',1);
        $mmmap['wjb']=array('EGT',0.5);
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_Ysgjinfo=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
    }
        //增加信息
        function AddPdjhInfo(){
            $AddData=D("zcpdzb_tb");  //注意去除前缀
            $AddData->stNO=I("stNO"); //盘点单编号
            $AddData->stUser=I("stUser"); //盘点创建人
            $AddData->stTime=I("stTime"); //计划盘点日期
            $AddData->depName=I("depName"); //部门名称
            $AddData->pd_dzsb=I("pd_dzsb"); //电子设备信息
            $AddData->pd_dqsb=I("pd_dqsb"); //机械器具
            $AddData->pd_ysgj=I("pd_ysgj"); //运输工具
            $AddData->pd_qtsb=I("pd_qtsb"); //其他设备
            $AddData->pd_zt=0; //盘点状态(0,未盘点;1,已下载;2,盘点结果;10盘点完成)
            $ret=$AddData->add();

            if(!$ret){
                $this->_pass="error";
            }else {
                $this->_pass="ok";
            }
    }
    //初始化维修金额
    function Cswxje(){
        $wxje=I("CsWxje");
        $id=I("id");
        $table='dzsb_tb';
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
    //盘点计划列表
    function loadPdjhdata(){
        $TableName=M("zcpdzb_tb");
        $zt=I("zt");
        if (!$zt){
            $zt='0,1';
        }
        $this->_keyword=I("keyword");
            $where["stno"]  = array('like',"%$this->_keyword%");
            $where["stuser"]  = array('like',"%$this->_keyword%");
            //$where["stTime"]  = array('like',"%$this->_keyword%");
            $where["depname"]  = array('like',"%$this->_keyword%");
            /*$where["pd_dzsb"]  = array('like',"%$this->_keyword%");
            $where["pd_dqsb"]  = array('like',"%$this->_keyword%");
            $where["pd_ysgj"]  = array('like',"%$this->_keyword%");
            $where["pd_qtsb"]  = array('like',"%$this->_keyword%");
            $where["pd_zt"]  = array('like',"%$this->_keyword%"); */
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
            $mmmap['pd_zt']=array('in',$zt);
            $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //盘点计划Json文件生成
    function PdxxJson(){
        $dzsb=I("dzsb");
        $dqsb=I("dqsb");
        $qtsb=I("qtsb");
        $ysgj=I("ysgj");
        $zb_id=I("zb_id"); //主表id
        $this->_stId=$zb_id;
        $this->_stTime=I("sttime");
        $this->_handingUser=I("stuser");
        $this->_stNO=I("stno");
        $this->_depName=I("depname");


        $Fbtable=M("zcpdfb_tb");
        $Fbtable->where('1')->delete(); //清除附表中的数据
        echo $Fbtable->_sql();
        //电子设备
        if ($dzsb!=''){
            $Dzsb_tb=M("dzsb_tb");
            $where["id"]  = array('in',$dzsb);
            $this->_main_data=$Dzsb_tb->where($where)->order("id DESC")->select(); //加载电子设备信息
            foreach($this->_main_data as $dzxx_info){
                $Fbtable->zb_id=$zb_id;
                $Fbtable->id=$dzxx_info["id"]; //资产id
                $Fbtable->firstClassify="电子设备"; //一级分类
                $Fbtable->secondClassify=$dzxx_info["zc_rjlx"]; //资产二级分类
                $Fbtable->usingDept=$dzxx_info["zc_ccsybm"]; //使用部门
                $Fbtable->goodsImage=I("goodsImage"); //图片
                $Fbtable->goodsNO=$dzxx_info["zc_bh"]; //资产编号
                $Fbtable->goodsStockNum=1; //库存数量
                $Fbtable->totalNum=$dzxx_info["id"]; //总数
                $Fbtable->goodsUnitValue=$dzxx_info["zc_jldw"]; //计量单位
                $Fbtable->stdNumber=0; //盘点数量
                $Fbtable->enableDate=$dzxx_info["zc_qyrq"]; //启用日期
                $Fbtable->isIdle=$dzxx_info["zc_sfxz"]; //是否闲置
                $Fbtable->goodsStatus=$dzxx_info["zc_zt"]; //使用状态
                $Fbtable->goodsModel=$dzxx_info["zc_pp"]."(".$dzxx_info["zc_xh"].")"; //品牌型号
                $Fbtable->goodsName=$dzxx_info["zc_mc"]; //资产名称
                $Fbtable->net=$dzxx_info["zc_jz"]; //净值
                $Fbtable->responsible=$dzxx_info["zc_zrr"]; //责任人
                $Fbtable->add();
                //echo "ok";
            }
        }
        //机械器具
        if ($dqsb!='') {
            $sb_tb = M("dqsb_tb");
            $where["id"] = array('in', $dqsb);
            $this->_main_data = $sb_tb->where($where)->order("id DESC")->select(); //加载电子设备信息
            foreach ($this->_main_data as $dzxx_info) {
                $Fbtable->zb_id = $zb_id;
                $Fbtable->id = $dzxx_info["id"]; //资产id
                $Fbtable->firstClassify = "机械器具"; //一级分类
                $Fbtable->secondClassify = $dzxx_info["zc_rjlx"]; //资产二级分类
                $Fbtable->usingDept = $dzxx_info["zc_ccsybm"]; //使用部门
                $Fbtable->goodsImage = I("goodsImage"); //图片
                $Fbtable->goodsNO = $dzxx_info["zc_bh"]; //资产编号
                $Fbtable->goodsStockNum = 1; //库存数量
                $Fbtable->totalNum = $dzxx_info["id"]; //总数
                $Fbtable->goodsUnitValue = $dzxx_info["zc_jldw"]; //计量单位
                $Fbtable->stdNumber = 0; //盘点数量
                $Fbtable->enableDate = $dzxx_info["zc_qyrq"]; //启用日期
                $Fbtable->isIdle = $dzxx_info["zc_sfxz"]; //是否闲置
                $Fbtable->goodsStatus = $dzxx_info["zc_zt"]; //使用状态
                $Fbtable->goodsModel = $dzxx_info["zc_pp"] . "(" . $dzxx_info["zc_xh"] . ")"; //品牌型号
                $Fbtable->goodsName = $dzxx_info["zc_mc"]; //资产名称
                $Fbtable->net = $dzxx_info["zc_jz"]; //净值
                $Fbtable->responsible = $dzxx_info["zc_zrr"]; //责任人
                $Fbtable->add();
                //echo "ok";
            }
        }
        //其他设备
        if ($qtsb!='') {
            $sb_tb = M("qtzc_tb");
            $where["id"] = array('in', $qtsb);
            $this->_main_data = $sb_tb->where($where)->order("id DESC")->select(); //加载电子设备信息
            //echo $sb_tb->_sql();
            foreach ($this->_main_data as $dzxx_info) {
                $Fbtable->zb_id = $zb_id;
                $Fbtable->id = $dzxx_info["id"]; //资产id
                $Fbtable->firstClassify = "其他设备"; //一级分类
                $Fbtable->secondClassify = $dzxx_info["zc_rjlx"]; //资产二级分类
                $Fbtable->usingDept = $dzxx_info["zc_ccsybm"]; //使用部门
                $Fbtable->goodsImage = I("goodsImage"); //图片
                $Fbtable->goodsNO = $dzxx_info["zc_bh"]; //资产编号
                $Fbtable->goodsStockNum = 1; //库存数量
                $Fbtable->totalNum = $dzxx_info["id"]; //总数
                $Fbtable->goodsUnitValue = $dzxx_info["zc_jldw"]; //计量单位
                $Fbtable->stdNumber = 0; //盘点数量
                $Fbtable->enableDate = $dzxx_info["zc_qyrq"]; //启用日期
                $Fbtable->isIdle = $dzxx_info["zc_sfxz"]; //是否闲置
                $Fbtable->goodsStatus = $dzxx_info["zc_zt"]; //使用状态
                $Fbtable->goodsModel = $dzxx_info["zc_pp"] . "(" . $dzxx_info["zc_xh"] . ")"; //品牌型号
                $Fbtable->goodsName = $dzxx_info["zc_mc"]; //资产名称
                $Fbtable->net = $dzxx_info["zc_jz"]; //净值
                $Fbtable->responsible = $dzxx_info["zc_zrr"]; //责任人
                $Fbtable->add();
                //echo "ok";
            }
        }
        //运输工具
        if ($ysgj!='') {
            $sb_tb = M("ysgj_tb");
            $where["id"] = array('in', $ysgj);
            $this->_main_data = $sb_tb->where($where)->order("id DESC")->select(); //加载电子设备信息
            //echo $sb_tb->_sql();
            foreach ($this->_main_data as $dzxx_info) {
                $Fbtable->zb_id = $zb_id;
                $Fbtable->id = $dzxx_info["id"]; //资产id
                $Fbtable->firstClassify = "其他设备"; //一级分类
                $Fbtable->secondClassify = $dzxx_info["zc_rjlx"]; //资产二级分类
                $Fbtable->usingDept = $dzxx_info["zc_ccsybm"]; //使用部门
                $Fbtable->goodsImage = I("goodsImage"); //图片
                $Fbtable->goodsNO = $dzxx_info["zc_bh"]; //资产编号
                $Fbtable->goodsStockNum = 1; //库存数量
                $Fbtable->totalNum = $dzxx_info["id"]; //总数
                $Fbtable->goodsUnitValue = $dzxx_info["zc_jldw"]; //计量单位
                $Fbtable->stdNumber = 0; //盘点数量
                $Fbtable->enableDate = $dzxx_info["zc_qyrq"]; //启用日期
                $Fbtable->isIdle = $dzxx_info["zc_sfxz"]; //是否闲置
                $Fbtable->goodsStatus = $dzxx_info["zc_zt"]; //使用状态
                $Fbtable->goodsModel = $dzxx_info["zc_gzcpp"] . "(" . $dzxx_info["zc_gzcxh"] . ")"; //品牌型号
                $Fbtable->goodsName = $dzxx_info["zc_mc"]; //资产名称
                $Fbtable->net = $dzxx_info["zc_jz"]; //净值
                $Fbtable->responsible = $dzxx_info["zc_zrr"]; //责任人
                $Fbtable->add();
                //echo "ok";
            }
        }
        $this->_dateil_data=$Fbtable->where("zb_id=$zb_id")->order("id DESC")->select(); //加载盘点表具体物料信息
        $EdifTable=M("zcpdzb_tb");
        $EdifTable->pd_zt=1;
        $EdifTable->where("id=$zb_id")->save();
    }
    //上传JSON文件
    function JsonUpload(){
        $config = C('uploadjson'); //读取上传文件配置类
        $upload=new \Think\Upload($config); // 实例化上传类
        $info=$upload->upload();
        if(!$info) {// 上传错误提示错误信息
            echo $upload->getError();
        }else{// 上传成功
            //$this->success('上传成功！');
            foreach ($info as $file) {
                //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                $JsonFile=$file['savepath'] . $file['savename'];
            }
        }
        //echo $JsonFile;
        $filename="/".$JsonFile;
        //echo $filename;
        $json_string = file_get_contents("http://127.0.0.1:8080/".$filename);//读取json内容
        //$data = json_decode($json_string);
        //echo $json_string;
        if (!$json_string){
            echo "文件读取错误";
            exit();
        }else{
            $this->_Jsoninfo=$json_string;
            $info=$this->_Jsoninfo;
            $data = json_decode(trim($info,chr(239).chr(187).chr(191)),true);
            $stId = $data[0]['stId']; //盘点单ID
            $stTime = $data[0]['stTime']; //盘点时间
            $handingUser=$data[0]['handingUser']; //申请人
            $stNO=$data[0]['stNO']; //盘点单号
            $depName=$data[0]['depName']; //盘点部门
            $StockTakeDetail=$data[0]['StockTakeDetail'];
            //$data["$stId"]['formatted_address'];
            //var_export($StockTakeDetail) ;

            $Table=M("zcpdjgb_tb"); //盘点结果表
            $where['zb_id']=$stId; //根据主表ID检索数据

            $count=$Table->where($where)->order("id DESC")->count();
            if ($count>0){ //如果存在该盘点单数据
                exit("该盘点表已经上传，是否要重新上传(<a href='#'>是</a>/<a href='#'>否</a>)");
            }else{
                foreach ($StockTakeDetail as $info){
                    //echo $info['zb_id']."<br />";
                    //echo $info['firstClassify']."<br />";
                    $AddData=M("zcpdjgb_tb");  //注意去除前缀
                    $AddData->zb_id=$info["zb_id"]; //盘点计划ID
                    $AddData->firstClassify=$info["firstClassify"]; //一级分类
                    $AddData->secondClassify=$info["secondClassify"]; //资产二级分类
                    $AddData->usingDept=$info["usingDept"]; //使用部门
                    $AddData->goodsImage=$info["goodsImage"]; //图片
                    $AddData->goodsNO=$info["goodsNO"]; //资产编号
                    $AddData->goodsStockNum=$info["goodsStockNum"]; //库存数量
                    $AddData->totalNum=$info["totalNum"]; //总数
                    $AddData->goodsUnitValue=$info["goodsUnitValue"]; //计量单位
                    $AddData->stdNumber=$info["stdNumber"]; //盘点数量
                    $AddData->enableDate=$info["enableDate"]; //启用日期
                    $AddData->isIdle=$info["isIdle"]; //是否闲置
                    $AddData->goodsStatus=$info["goodsStatus"]; //使用状态
                    $AddData->goodsModel=$info["goodsModel"]; //品牌型号
                    $AddData->goodsName=$info["goodsName"]; //资产名称
                    $AddData->net=$info["net"]; //净值
                    $AddData->responsible=$info["responsible"]; //责任人
                    $AddData->up_datetime=date('Y-m-d H:i:s',time()); //后端获取日期
                    $ret=$AddData->add();
                    $this->_zt=$ret;
                }
            };
            //echo $this->ajaxReturn($json_string);
        }
    }
    //盘点结果信息查询
    function loadPdjgdata(){
        $TableName=M("zcpdjgb_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            //$where["zb_id"]  = array('like',"%$this->_keyword%");
            $where["firstClassify"]  = array('like',"%$this->_keyword%");
            $where["secondClassify"]  = array('like',"%$this->_keyword%");
            $where["usingDept"]  = array('like',"%$this->_keyword%");
            $where["goodsImage"]  = array('like',"%$this->_keyword%");
            $where["goodsNO"]  = array('like',"%$this->_keyword%");
            $where["goodsStockNum"]  = array('like',"%$this->_keyword%");
            $where["totalNum"]  = array('like',"%$this->_keyword%");
            $where["goodsUnitValue"]  = array('like',"%$this->_keyword%");
            $where["stdNumber"]  = array('like',"%$this->_keyword%");
            //$where["enableDate"]  = array('like',"%$this->_keyword%");
            $where["isIdle"]  = array('like',"%$this->_keyword%");
            $where["goodsStatus"]  = array('like',"%$this->_keyword%");
            $where["goodsModel"]  = array('like',"%$this->_keyword%");
            $where["goodsName"]  = array('like',"%$this->_keyword%");
            $where["net"]  = array('like',"%$this->_keyword%");
            $where["responsible"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //手工编辑盘点结果
    function EditPdjg(){
        $TableName=M("zcpdjgb_tb");
        $id=I("id");
        $num=I("num");
        $where["id"]  = array('eq',$id);
        $TableName->stdNumber=$num;
        $this->_zt=$TableName->where($where)->save();
    }
}