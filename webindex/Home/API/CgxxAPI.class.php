<?php
namespace Home\API;
class CgxxAPI
{
    public $_page_size="25"; //每页显示条数
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
    public $_lx=""; //类型
    public $_nd=""; //奖励年度


    function loadmatedata($where){
        //加载输入类型

        $this->_lx=I("lx");
        //加载输入关键字
        $this->_keyword=I("keyword");
        if ($this->_keyword!="" and $this->_lx==""){
            $where['cg_cgmc']  = array('like',"%$this->_keyword%"); //成果名称
            //$where['cg_gjz']  = array('like',"%$this->_keyword%");  //成果关键词
            //$where['cg_xmjj']  = array('like',"%$this->_keyword%"); //成果简介
            $where['cg_xkflmc']  = array('like',"%$this->_keyword%");  //成果分类
            $where['cg_dq']  = array('like',"%$this->_keyword%");  //地区
            //$where['cg_zywcr']  = array('like',"%$this->_keyword%");  //主要完成人
            //$where['cg_xmbh']  = array('like',"%$this->_keyword%");  //项目编号
            //$where['cg_zywcdw']  = array('like',"%$this->_keyword%"); //成果完成单位
            $where['_logic']='OR';
        }
        else if($this->_keyword!="" and $this->_lx!=""){
            if ($this->_lx=="cgmc") {
            $where['cg_cgmc']  = array('like',"%$this->_keyword%"); //成果名称
            }
            if ($this->_lx=="gjz") {
                $where['cg_gjz'] = array('like', "%$this->_keyword%");  //成果关键词
            }
            if ($this->_lx=="xmjj") {
                $where['cg_xmjj']  = array('like',"%$this->_keyword%"); //成果简介
            }
            if ($this->_lx=="xkflmc"){
                $where['cg_xkflmc']  = array('like',"%$this->_keyword%");  //成果分类
            }
            if ($this->_lx=="zywcr"){
                $where['cg_zywcr']  = array('like',"%$this->_keyword%");  //主要完成人
            }
            if ($this->_lx=="xmbh"){
                $where['cg_xmbh']  = array('like',"%$this->_keyword%");  //项目编号
            }
        }
        //加载主表数据
        $this->_page_count=$count=M("cgxxjc_tb")->where($where)->order("cg_wcsj DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=M("cgxxjc_tb")->where($where)->order("cg_wcsj DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("cgxxjc_tb")->getLastSql();
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
            $ret=M("cglx_tb")->where("cglx_jb=1".$where)->order("id")->select();
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
                $ret=M("cglx_tb")->where("cglx_sjid in (".$set_class_id.") and cglx_jb=2")->order("id")->select();
                $cache->Cg_Classtwo=$ret;

            }
            $this->_class_meta_data=$cache->Cg_Classtwo;
            //ar_export($ret);
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
        $cg_nd=I("cg_nd");
        $cg_lx=I("lx");
        $this->_nd=$cg_nd;

        if ($cg_lx!=""){
        if ($cg_lx==1) {
            $data = array(
                "cg_mc" => I("cg_mc"),
                "cg_sbdw" => I("cg_sbdw"),
                "cg_zsbh" => I("cg_zsbh"),

            );
            $this->_keyword = $data;

            $where['cg_mc'] = array('like', "%$cg_mc%");
            $where['cg_sbdw'] = array('like', "%$cg_sbdw%");
            $where['cg_zsbh'] = array('like', "$cg_zsbh%");
            $where['cg_lx'] = array('eq', "$cg_lx");


            $this->_page_count = $count = M("cgtg_tb")->where($where)->order("cg_zsbh ")->count();
            $Page = new \Think\Page($count, $this->_page_size);
            $this->_page_bar = $Page->show(); //把分布内容赋值给变量
            $this->_main_data = M("cgtg_tb")->where($where)->order("cg_zsbh ")->select(); //主表数据取值完成
        }
            elseif ($cg_lx==2){
                $data = array(
                    "cg_mc" => I("cg_mc"),
                    "cg_sbdw" => I("cg_sbdw"),
                    "cg_zsbh" => I("cg_zsbh"),
                    "cg_nd"=>I("cg_nd"),

                );
                $this->_keyword = $data;

                $where['cg_xmbh'] = array('like', "$cg_nd%");
                $where['cg_lx'] = array('eq', "$cg_lx");
                //$where['cg_zsbh'] = array('eq', "");


                $this->_page_count = $count = M("hjtg_vm")->where($where)->order("gl_jlsz")->count();
                $Page = new \Think\Page($count, $this->_page_size);
                $this->_page_bar = $Page->show(); //把分布内容赋值给变量
                $this->_main_data = M("hjtg_vm")->where($where)->order("gl_jlsz")->select(); //主表数据取值完成
                //echo M("cgtg_tb")->_sql();
            }
        }
        else{
            //echo "class error";
            return false;
        }
    }
    function loadseadata($where){

        $this->_keyword=I("keyword");
        if ($this->_keyword==""){
            echo "Keyword Error!";
        }
            $where['cg_cgmc']  = array('like',"%$this->_keyword%"); //成果名称
            //$where['cg_gjz']  = array('like',"%$this->_keyword%");  //成果关键词
            //$where['cg_xmjj']  = array('like',"%$this->_keyword%"); //成果简介
            $where['cg_xkflmc']  = array('like',"%$this->_keyword%");  //成果分类
            $where['cg_dq']  = array('like',"%$this->_keyword%");  //地区
            //$where['cg_zywcr']  = array('like',"%$this->_keyword%");  //主要完成人
            //$where['cg_xmbh']  = array('like',"%$this->_keyword%");  //项目编号
            //$where['cg_zywcdw']  = array('like',"%$this->_keyword%"); //成果完成单位
            $where['_logic']='OR';

        //加载主表数据
        $this->_page_count=$count=M("cgxxjc_tb")->where($where)->order("cg_wcsj DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=M("cgxxjc_tb")->where($where)->order("cg_wcsj DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("cgxxjc_tb")->getLastSql();

    }

}