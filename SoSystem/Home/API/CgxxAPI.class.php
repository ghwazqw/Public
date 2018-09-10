<?php
namespace Home\API;
class CgxxAPI
{
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_dal_hj_data=array();  //获奖信息
    public $_dal_wcdw_data=array(); //完成单位信息
    public $_keyword=""; //关键字
    public $_class_data=""; //分类信息
    public $_class_meta_data=""; //子分类信息
    public $_xmbh=""; //项目编号
    public $_lx="";

    function loadmatedata($where){
        //加载输入关键字
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["buing_bh"]  = array('like',"%$this->_keyword%");
            //$where["buing_loor"]  = array('like',"%$this->_keyword%");
            //$where["buing_rooms"]  = array('like',"%$this->_keyword%");
            $where["buing_name"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=M("building_tb")->where($where)->order("id desc")->count();
        $Page = new \Think\Page($count,$this->_page_size);

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("building_tb")->where($where)->order("id desc")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $this->_main_data->getLastSql();
    }
    function loaddaldata($where,$wherejl,$wheredw){
        //加载输入关键字
        $this->_keyword=I("id");
        if ($this->_keyword!=""){
            $where['id']  = array('eq',$this->_keyword); //成果名称
            //$where['_logic']='OR';
        }
        /*//点击量计量
        $key="cgxx_".$this->_keyword; //获取新闻点击量ID
        $max="4";  //每隔多少次更新数据库
        $cilck=new RedisAPI();
        $cilck->Yw_data($key,$max);
        $this->_cilck = $cilck->_cilck;
        $this->_data_data_cilck=$ret=M("info_cilck_tb")->where($where)->order("id DESC")->select(); //获取统计分析总数量
        foreach($this->_data_data_cilck as $id_info){  //获取数据库中的统计值
            $cil=$id_info["cilck"];
            $this->_data_cilck=$cil;
        }*/

        //加载主表数据
        $this->_page_count=$count=M("cgxxjc_tb")->where($where)->limit(1)->order("cg_wcsj DESC")->count();
        $this->_main_data=$ret=M("cgxxjc_tb")->where($where)->limit(1)->order("cg_wcsj DESC")->select(); //主表数据取值完成
        //echo $ret->getLastSql();

        //加载获奖信息数据
        $set_xmbh="";
        foreach($this->_main_data as $cg_xmbh){
            $set_xmbh=$cg_xmbh["cg_xmbh"];
            $set_cgmc=$cg_xmbh["cg_cgmc"];
            //echo $set_xmbh;
            if ($set_xmbh=="" or $set_cgmc==""){
                echo "取值错误";
                return false;
            }
            else{
            $wherejl['JL_XMBH']  = array('eq',$set_xmbh);
            //$wheredw['cg_cgmc']=array('FIND_IN_SET',"%$set_cgmc%");
            $this->_dal_hj_data=$ret=M("Hjcg_vm")->where($wherejl)->order("jl_hjsj DESC")->select(); //输出奖励情况
            //$this->_dal_wcdw_data=$ret1=M("wcdw_vm")->where(('$set_xmbh','cg_xmbh'))->order("cgwc_pm DESC")->select(); //输出单位情况
               //echo M("wcdw_vm")->_sql();
                //echo M('Hjcg_vm')->getLastSql();
            }
        }

    }
    function loadclassdata($where,$where_dateil=""){
        //加载主分类数据
        $cache = S(array('type'=>'file','prefix'=>'glxh_info','expire'=>6000)); //读取缓存配置
        if (!$cache->Cg_Classone){
            $ret=M("zclx_tb")->where("cglx_jb=1".$where)->order("id")->select();
            $cache->cg_class=$ret;
        }
        $this->_class_data=$cache->cg_class;
        //循环取出主分类表中的ID
        $set_class_id="";
        foreach($this->_class_data as $class_id){
            if ($set_class_id!="")
                $set_class_id.=",";
            $set_class_id.=$class_id["id"];
            //echo $set_class_id;
        }
        if ($set_class_id!=""){
            //取出子分类数据
            if (!$cache->Cg_Classtwo){
                $ret=M("zclx_tb")->where("cglx_sjid in (".$set_class_id.") and cglx_jb=2")->order("id")->select();
                $cache->Cg_Classtwo=$ret;

            }
            $this->_class_meta_data=$cache->Cg_Classtwo;
            //ar_export($ret);
        }
    }
    function loadcompdata($where,$where_dateil=""){
        //加载主分类数据
        $cache = S(array('type'=>'file','prefix'=>'comp_info','expire'=>1)); //读取缓存配置
        if (!$cache->Cg_Classone){
            $ret=M("comp_tb")->where("cglx_jb=1".$where)->order("id")->select();
            $cache->cg_class=$ret;
        }
        $this->_class_data=$cache->cg_class;
        //循环取出主分类表中的ID
        $set_class_id="";
        foreach($this->_class_data as $class_id){
            if ($set_class_id!="")
                $set_class_id.=",";
            $set_class_id.=$class_id["id"];
            //echo $set_class_id;
        }
        if ($set_class_id!=""){
            //取出子分类数据
            if (!$cache->Cg_Classtwo){
                $ret=M("comp_tb")->where("cglx_sjid in (".$set_class_id.") and cglx_jb=2")->order("id")->select();
                $cache->Cg_Classtwo=$ret;

            }
            $this->_class_meta_data=$cache->Cg_Classtwo;
            $set_towclass_id="";
            foreach($this->_class_meta_data as $class_id){
                if ($set_towclass_id!="")
                    $set_towclass_id.=",";
                $set_towclass_id.=$class_id["id"];
                //echo $set_towclass_id;
            }
            if ($set_class_id!=""){
                //取出三级分类数据
                if (!$cache->Cg_Classthree){
                    $ret=M("comp_tb")->where("cglx_sjid in (".$set_towclass_id.") and cglx_jb=3")->order("id")->select();
                    $cache->Cg_Classthree=$ret;
                }
                $this->_dateil_data=$ret;
                //echo $ret;
                //echo M("comp_tb")->_sql();
                //var_export($this->_dateil_data);

            }
        }
    }
    function loadcompstatdata($where,$where_dateil=""){
        //加载主分类数据
        $cache = S(array('type'=>'file','prefix'=>'comp_info','expire'=>1)); //读取缓存配置
        if (!$cache->Cg_Classone){
            $ret=M("comp_tb")->where("cglx_jb=1".$where)->order("id")->select();
            $cache->cg_class=$ret;
        }
        $this->_class_data=$cache->cg_class;
        //循环取出主分类表中的ID
        $set_class_id="";
        foreach($this->_class_data as $class_id){
            if ($set_class_id!="")
                $set_class_id.=",";
            $set_class_id.=$class_id["id"];
            //echo $set_class_id;
        }
        if ($set_class_id!=""){
            //取出子分类数据
            if (!$cache->Cg_Classtwo){
                $ret=M("comp_tb")->where("cglx_sjid in (".$set_class_id.") and cglx_jb=2")->order("id")->select();
                $cache->Cg_Classtwo=$ret;

            }
            $this->_comp_data=$cache->Cg_Classtwo;
            $set_towclass_id="";
            foreach($this->_comp_data as $class_id){
                if ($set_towclass_id!="")
                    $set_towclass_id.=",";
                $set_towclass_id.=$class_id["id"];
                //echo $set_towclass_id;
            }
            if ($set_class_id!=""){
                //取出三级分类数据
                if (!$cache->Cg_Classthree){
                    $ret=M("comp_tb")->where("cglx_sjid in (".$set_towclass_id.") and cglx_jb=3")->order("id")->select();
                    $cache->Cg_Classthree=$ret;
                }
                $this->_dateil_data=$ret;
                //echo $ret;
                //echo M("comp_tb")->_sql();
                //var_export($this->_dateil_data);

            }
        }
    }

    function cgwcdw($where){
        $cgwc_xmbh=I("cgwc_xmbh");
        $cgwc_wcdw=I("cgwc_wcdw");
        $cgwc_szd=I("cgwc_szd");
        $cgwc_dwsx=I("cgwc_dwsx");

        $where['cgwc_xmbh']  = array('eq',"$cgwc_xmbh"); //项目编号
        $where['cgwc_wcdw']  = array('like',"%$cgwc_wcdw%"); //单位名称
        $where['cgwc_szd']  = array('like',"%$cgwc_szd%"); //项目编号
        $where['cgwc_dwsx']  = array('like',"%$cgwc_dwsx%"); //单位名称
            //$where['_logic']='OR';
        $data = array(
            "cgwc_xmbh" => I("cgwc_xmbh"),
            "cgwc_wcdw" => I("cgwc_wcdw"),
            "cgwc_szd" => I("cgwc_szd"),
            "cgwc_dwsx" => I("cgwc_dwsx"),

        );
        $this->_keyword=$data;

        //加载主表数据
        $this->_page_count=$count=M("cgwcdw_tb")->where($where)->order("cgwc_pm DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("cgwcdw_tb")->where($where)->order("cgwc_pm DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("cgwcdw_tb")->_sql();
        //var_export($ret->getLastSql());
    }
    public $_data="";
    function loadsearchdata($where){
           //加载输入关键字
            $bh=I("bh_keyword");
            $name=I("name_keyword");
            $dq=I("dq_keyword");
            $wcr=I("wcr_keyword");
            $wcdw=I("wcdw_keyword");
            $tjdw=I("tjdw_keyword");
            $wcsj=I("wcsj_keyword");
            $gjc=I("gjc_keyword");
            $fl=I("fl_keyword");
            $fx=I("fx_keyword");
            $ly=I("ly_keyword");
            $jj=I("jj_keyword");
            $nd=I("nd_keyword");
            $dj=I("dj_keyword");

        $data = array (
            "bh" => I("bh_keyword"),
            "name"=>I("name_keyword"),
            "dq"=>I("dq_keyword"),
            "wcr"=>I("wcr_keyword"),
            "wcdw"=>I("wcdw_keyword"),
            "tjdw"=>I("tjdw_keyword"),
            "wcsj"=>I("wcsj_keyword"),
            "gjc"=>I("gjc_keyword"),
            "fl"=>I("fl_keyword"),
            "fx"=>I("fx_keyword"),
            "ly"=>I("ly_keyword"),
            "jj"=>I("jj_keyword"),
            "nd"=>I("nd_keyword"),
            "dj"=>I("dj_keyword"),
        );
        //var_export($data);

            $where['cg_xmbh']  = array('like',"%$bh%");
            $where['cg_cgmc']  = array('like',"%$name%");
            $where['cg_dq'] = array('like',"%$dq%");
            $where['cg_zywcr']  = array('like',"%$wcr%");
            $where['cg_zywcdw']  = array('like',"%$wcdw%");
            $where['cg_tjdw']  = array('like',"%$tjdw%");
            $where['cg_wcsj']  = array('like',"%$wcsj%");
            $where['cg_gjz']  = array('like',"%$gjc%");
            $where['cg_xkflmc']  = array('like',"%$fl%");
            $where['cg_zyfx']  = array('like',"%$fx%");
            $where['cg_ktly']  = array('like',"%$ly%");
            $where['cg_xmjj']  = array('like',"%$jj%");
            $where['cg_jlnd']  = array('like',"%$nd%");
            $where['cg_jldj']  = array('like',"%$dj%");
            //$where['_logic']='OR';
            //加载主表数据
            $this->_page_count=$count=M("cgxxjc_tb")->where($where)->order("cg_wcsj DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            $this->_keyword= $data;
            /*foreach($where as $key => $val){
                var_export($key.$val[1]);
                $Page->parameter[$key] = $where;
                //var_export($key);
            }*/

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=M("cgxxjc_tb")->where($where)->order("cg_wcsj DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M('cgxxjc_tb')->getLastSql();
        //echo $this->_main_data->getLastSql();
    }
    function cgdw_dal($where,$whar){
        $id=I("id");
        $cgwc_xmbh=I("bh");
        $where['id']=array('eq',"$id");
        $whar['cgwc_xmbh']=array('like',"%$cgwc_xmbh%");
        $this->_main_data=M("cgwcdw_tb")->where($where)->LIMIT(1)->select(); //主数据取值
        $this->_dateil_data=M("cgwcdw_tb")->where($whar)->order("cgwc_pm ")->select();
        //echo M("cgwcdw_tb")->_sql();
    }
    function cgtg_list($where){

        $cg_mc=I("cg_mc");
        $cg_sbdw=I("cg_sbdw");
        $cg_zsbh=I("cg_zsbh");

        $data=array(
            "cg_mc" => I("cg_mc"),
            "cg_sbdw" => I("cg_sbdw"),
            "cg_zsbh" => I("cg_zsbh"),

        );
        $this->_keyword=$data;

        $where['cg_mc']=array('like',"%$cg_mc%");
        $where['cg_sbdw']=array('like',"%$cg_sbdw%");
        $where['cg_zsbh']=array('like',"$cg_zsbh%");


        $this->_page_count=$count=M("cgtg_tb")->where($where)->order("cg_zsbh ")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=M("cgtg_tb")->where($where)->order("cg_zsbh ")->select(); //主表数据取值完成
    }
    //增加资产类型
    function cglx_add(){
        //需提交的数据接收
        $title=I("title");
        $cglx_fl=I("cglx_fl");
        $cglx_sfyx=I("cglx_sfyx");
        //辅助数据接收
        $cglx_id=I("cglx_id");
        //判断上级分类和分类等级
        if ($cglx_fl==1 or $cglx_fl=="" ){
            $cglx_sjid=0;
            $cglx_jb=1;
        }
        elseif ($cglx_fl==2){
            $cglx_sjid=I("cglx_sjid");
            $cglx_jb=I("cglx_jb");
        }
        elseif ($cglx_fl==3) {
            $cglx_sjid=I("cglx_id");
            $cglx_jb=I("cglx_jb")+1;
        }
        //echo $cglx_jb;
        $info_add_tb = D("cglx_tb");
        $info_add_tb->cglx_mc = $title;
        $info_add_tb->cglx_sjid = $cglx_sjid;
        $info_add_tb->cglx_jb = $cglx_jb;
        $info_add_tb->cglx_sfyx = $cglx_sfyx;
        $info_add_tb->add();
        $this->actionInfo='{$this->assign("sussInfo","信息录入成功，请继续！");}';

    }
    //增加组织机构类型
    function comp_add(){
        //需提交的数据接收
        $title=I("title");
        $cglx_fl=I("cglx_fl");
        $cglx_sfyx=I("cglx_sfyx");
        //辅助数据接收
        $cglx_id=I("cglx_id");
        //判断上级分类和分类等级
        if ($cglx_fl==1 or $cglx_fl=="" ){
            $cglx_sjid=0;
            $cglx_jb=1;
        }
        elseif ($cglx_fl==2){
            $cglx_sjid=I("cglx_sjid");
            $cglx_jb=I("cglx_jb");
        }
        elseif ($cglx_fl==3) {
            $cglx_sjid=I("cglx_id");
            $cglx_jb=I("cglx_jb")+1;
        }
        //echo $cglx_jb;
        $info_add_tb = D("comp_tb");
        $info_add_tb->cglx_mc = $title;
        $info_add_tb->cglx_sjid = $cglx_sjid;
        $info_add_tb->cglx_jb = $cglx_jb;
        $info_add_tb->cglx_sfyx = $cglx_sfyx;
        $info_add_tb->add();
        $this->actionInfo='{$this->assign("sussInfo","信息录入成功，请继续！");}';

    }
    //编辑信息
    function comp_edit(){
        $id=I("cglx_id");
        $info_edit_tb = D("comp_tb");
        $info_edit_tb->cglx_mc=I("cglx_mc");
        $info_edit_tb->where("id=$id")->save();
        echo "信息编辑成功";
    }
    //编辑信息
    function fl_edit(){
        $id=I("cglx_id");
        $info_edit_tb = D("zclx_tb");
        $info_edit_tb->cglx_mc=I("cglx_mc");
        $info_edit_tb->zjnx=I("zjnx");
        $info_edit_tb->where("id=$id")->save();
        echo "信息编辑成功";
    }

    function home_list($where){
        $this->_keyword=I("bh");
        if ($this->_keyword!=""){
            $where["homename"]  = array('like',"%$this->_keyword%");
            //$where["zclb"]  = array('like',"%$this->_keyword%");
            //$where["zcbm"]  = array('like',"%$this->_keyword%");
            //$where["glyxm"]  = array('like',"%$this->_keyword%");
            //$where["fzrq"]  = array('like',"%$this->_keyword%");
            //$where["fczbh"]  = array('like',"%$this->_keyword%");
            //$where["zlwz"]  = array('like',"%$this->_keyword%");
            //$where["nolur"]  = array('like',"%$this->_keyword%");
           // $where["mj"]  = array('like',"%$this->_keyword%");
            //$where["symj"]  = array('like',"%$this->_keyword%");
            //$where["szlc"]  = array('like',"%$this->_keyword%");
            $where["buildingid"]  = array('eq',"$this->_keyword");
            //$where["huxing"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }
        $this->_page_count=$count=M("house_tb")->where($where)->order("id")->count();
        $Page = new \Think\Page($count,$this->_page_size);

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("house_tb")->where($where)->order("id")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("house_tb")->_sql();
    }
    //宿舍信息读取
    function SsInfolist($where){
        $this->_keyword=I("keyword");
            $where["homename"]  = array('like',"%$this->_keyword%");
            $where["zcbm"]  = array('like',"%$this->_keyword%");
            $where["glyxm"]  = array('like',"%$this->_keyword%");
            //$where["fzrq"]  = array('like',"%$this->_keyword%");
            $where["fczbh"]  = array('like',"%$this->_keyword%");
            $where["zlwz"]  = array('like',"%$this->_keyword%");
            $where["nolur"]  = array('like',"%$this->_keyword%");
            $where["mj"]  = array('like',"%$this->_keyword%");
            $where["symj"]  = array('like',"%$this->_keyword%");
            $where["szlc"]  = array('like',"%$this->_keyword%");
            //$where["buildingid"]  = array('eq',"$this->_keyword");
            $where["huxing"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
            $mmmap["zclb"]  = array('eq',"职工宿舍");
            $mmmap['_logic']='AND';
        $this->_page_count=$count=M("house_tb")->where($mmmap)->order("id")->count();
        $Page = new \Think\Page($count,$this->_page_size);

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("house_tb")->where($mmmap)->order("id")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("house_tb")->_sql();
    }
    function LouFangdata($where){
        //加载输入关键字
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["buing_bh"]  = array('like',"%$this->_keyword%");
            //$where["buing_loor"]  = array('like',"%$this->_keyword%");
            //$where["buing_rooms"]  = array('like',"%$this->_keyword%");
            $where["buing_name"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=M("building_tb")->where($where)->order("id desc")->count();
        $Page = new \Think\Page($count,$this->_page_size);

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("building_tb")->where($where)->order("id desc")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $this->_main_data->getLastSql();
    }
    function Fjian_dal(){
        $id=I("id");
        if (!$id){
            echo "ID Info Error";
        };
        $where['id']=array('eq',$id);
        $this->_dateil_data=M("house_tb")->where($where)->select();
        //echo M("house_tb")->_sql();
    }

}