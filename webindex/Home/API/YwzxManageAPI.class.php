<?php

namespace Home\API;
class YwzxManageAPI {
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字数据
    public $_class_data=""; //类型数据
    public $_class_meta_data=""; //关键字数据
    public $actionInfo=""; //返回要执行的动作

    //成果入库
    function loadmatedata($where){
        $TableName=M("cgrk_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_cgmc"]  = array('like',"%$this->_keyword%");
            $where["gl_gjc"]  = array('like',"%$this->_keyword%");
            $where["gl_cgtxxs"]  = array('like',"%$this->_keyword%");
            $where["gl_yyly"]  = array('like',"%$this->_keyword%");
            $where["gl_syfw"]  = array('like',"%$this->_keyword%");
            $where["gl_yydq"]  = array('like',"%$this->_keyword%");
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
    //成果需求
    function loadxqsqdata($where){
        $TableName=M("xqsq_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_xqnr"]  = array('like',"%$this->_keyword%");
            $where["gl_xqlx"]  = array('like',"%$this->_keyword%");
            $where["gl_xqly"]  = array('like',"%$this->_keyword%");
            //$where["gl_trys"]  = array('like',"%$this->_keyword%");
            $where["gl_xqms"]  = array('like',"%$this->_keyword%");
            //$where["gl_jzrq"]  = array('like',"%$this->_keyword%");
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
    //供需对接
    function loadgjxqdata($where){
        $TableName=M("gjxq_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_cpmc"]  = array('like',"%$this->_keyword%");
            $where["gl_txxs"]  = array('like',"%$this->_keyword%");
            $where["gl_yyly"]  = array('like',"%$this->_keyword%");
            $where["gl_cpjj"]  = array('like',"%$this->_keyword%");
            $where["gl_syqy"]  = array('like',"%$this->_keyword%");
            $where["gl_tgxs"]  = array('like',"%$this->_keyword%");
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
    //会议会展
    function loadhyxqdata($where){
        $TableName=M("hyxq_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_xqms"]  = array('like',"%$this->_keyword%");
            $where["gl_hylx"]  = array('like',"%$this->_keyword%");
            $where["gl_hyfx"]  = array('like',"%$this->_keyword%");
            $where["gl_hycs"]  = array('like',"%$this->_keyword%");
            //$where["gl_hyrq"]  = array('like',"%$this->_keyword%");
            $where["gl_hyys"]  = array('like',"%$this->_keyword%");
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
    //科技咨询
    function loadkjzxdata($where){
        $TableName=M("kjzx_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_zxnr"]  = array('like',"%$this->_keyword%");
            $where["gl_zxnrscjd"]  = array('like',"%$this->_keyword%");
            $where["gl_zxly"]  = array('like',"%$this->_keyword%");
            $where["gl_xmjj"]  = array('like',"%$this->_keyword%");
            $where["gl_xqms"]  = array('like',"%$this->_keyword%");
            //$where["gl_trys"]  = array('like',"%$this->_keyword%");                $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //成果评估
    function loadcgpgdata($where){
        $TableName=M("cgpg_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["id"]  = array('like',"%$this->_keyword%");
            $where["gl_cgmc"]  = array('like',"%$this->_keyword%");
            $where["gl_cglx"]  = array('like',"%$this->_keyword%");
            $where["gl_cgjj"]  = array('like',"%$this->_keyword%");
            $where["gl_yyqk"]  = array('like',"%$this->_keyword%");
            $where["gl_tgqj"]  = array('like',"%$this->_keyword%");
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
    //科研咨询
    function loadkyzxdata($where){
        $TableName=M("kyzx_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_zxnr"]  = array('like',"%$this->_keyword%");
            $where["gl_ncjdw"]  = array('like',"%$this->_keyword%");
            $where["gl_yjly"]  = array('like',"%$this->_keyword%");
            //$where["gl_nlxrq"]  = array('like',"%$this->_keyword%");
            //$where["gl_jhjtrq"]  = array('like',"%$this->_keyword%");
            $where["gl_jfys"]  = array('like',"%$this->_keyword%");
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
    //创业融资
    function loadrzxqdata($where){
        $TableName=M("rzxq_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_jgxz"]  = array('like',"%$this->_keyword%");$where["gl_xmmc"]  = array('like',"%$this->_keyword%");$where["gl_hzdw"]  = array('like',"%$this->_keyword%");$where["gl_xmztzje"]  = array('like',"%$this->_keyword%");$where["gl_xmyyly"]  = array('like',"%$this->_keyword%");$where["gl_yrzje"]  = array('like',"%$this->_keyword%");$where["gl_zjyt"]  = array('like',"%$this->_keyword%");$where["gl_rzfs"]  = array('like',"%$this->_keyword%");$where["gl_zjtrfs"]  = array('like',"%$this->_keyword%");                $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //融资需求信息导出
    function expRZExcel($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_jgxz"]  = array('like',"%$this->_keyword%");$where["gl_xmmc"]  = array('like',"%$this->_keyword%");$where["gl_hzdw"]  = array('like',"%$this->_keyword%");$where["gl_xmztzje"]  = array('like',"%$this->_keyword%");$where["gl_xmyyly"]  = array('like',"%$this->_keyword%");$where["gl_yrzje"]  = array('like',"%$this->_keyword%");$where["gl_zjyt"]  = array('like',"%$this->_keyword%");$where["gl_rzfs"]  = array('like',"%$this->_keyword%");$where["gl_zjtrfs"]  = array('like',"%$this->_keyword%");                $where['_logic']='OR';
        }
        $m = M ('quser_rzxq_tb');
        // $datas['order_p_name'] = $p_name;
        $data = $m->where($where)->order("id DESC")->select();
        foreach ($data as $k => $v)
        {
            $data[$k]['id']=$v['id'];
        }
        //var_export($data);
        //exit;
        //用vendor导入PHPExcel类库
        vendor("PHPExcel.PHPExcel");
        $filename="融资信息表";
        $headArr=array(
            "ID",
            "机构性质",
            "项目名称",
            "合作单位",
            "项目总投资金额",
            "项目应用领域",
            "预融资金额",
            "资金用途",
            "项目应用地域",
            "融资方式",
            "资金来源",
            "资金投入方式",
            "共担资金风险",
            "共同经营管理",
            "项目回报周期",
            "项目应用范围",
            "项目已有条件",
            "项目前景分析",
            "项目单位(人)",
            "团队介绍",
            "产品运营",
            "商业计划书",);
        $getExcel=new ExcelAPI();
        $getExcel->getExcel($filename,$headArr,$data);
    }
    //融资详细
    function loadrzxqdaldata($where){
        $TableName=M("rzxq_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='quser_rzxq_tb' and hf_ywid=$id")->select();
    }
    //入库表详细
    function loadcgrkdaldata($where){
        $TableName=M("cgrk_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='quser_cgrk_tb' and hf_ywid=$id")->select();
    }
    //成果需求详细
    function loadcgxqdaldata($where){
        $TableName=M("xqsq_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='quser_xqsq_tb' and hf_ywid=$id")->select();
    }
    //供需对拉详细
    function loadgjxqdaldata($where){
        $TableName=M("gjxq_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='gjxq_tb' and hf_ywid=$id")->select();
    }

    //会议信息详细
    function loadhyxqdaldata($where){
        $TableName=M("hyxq_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='quser_hyxq_tb' and hf_ywid=$id")->select();
    }
    //科技咨询详细
    function loadkjzxdaldata($where){
        $TableName=M("kjzx_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='quser_kjzx_tb' and hf_ywid=$id")->select();
    }
    //科研咨询详细
    function loadkyzxdaldata($where){
        $TableName=M("kyzx_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='quser_kyzx_tb' and hf_ywid=$id")->select();
    }
    //成果评估详细
    function loadcgpgdaldata($where){
        $TableName=M("cgpg_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='quser_cgpg_tb' and hf_ywid=$id")->select();
    }
    //专家信息详细
    function loadzjxxinfo(){
        $TableName=M("zjinfoxx_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='zjxxinfo_tb' and hf_ywid=$id")->select();
    }
    //投资需求详细
    function loadtzxqdaldata($where){
        $TableName=M("tzxq_vm");
        $id=I("id");
        if (!$id){
            echo "Id info error";
            exit();
        }
        else{
            $this->_keyword=$id;
            $where["id"]  = array('eq',"$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
        $this->_dateil_data=M("quser_hfxx_tb")->where("hf_ywlx='quser_tzxq_tb' and hf_ywid=$id")->select();
    }
    function loadhfxxdata(){
        $id=I("hf_ywid");
        $gl_ywlx=I("hf_ywlx");
        $hf_content=I("hf_content");
        $gl_hdzt=I("gl_hdzt");
        $hf_hfr=I("hf_hfr");
        //exit($gl_hdzt);
        if (!$id){
            echo "Id Error!";
            exit();
        }
        else{
            //改变业务状态
            $Edit_data=D("quser_lxxx_tb");
            $Edit_data->gl_hdzt=$gl_hdzt;
            $ret=$Edit_data->where("gl_ywid=$id")->save();
            //增加回复信息
            $add_data=D("quser_hfxx_tb");
            $add_data->hf_content=$hf_content;
            $add_data->hf_ywid=$id;
            $add_data->hf_sj=date('Y-m-d H:i:s',time());
            $add_data->hf_hfr=$hf_hfr;
            $add_data->hf_ywlx=$gl_ywlx;
            $add_data->add();
            redirect('/home/manage', 1, '回复成功，正在跳转...');
        }

    }

    function zjhfxxdata(){
        $id=I("hf_ywid");
        $gl_ywlx=I("hf_ywlx");
        $hf_content=I("hf_content");
        $gl_hdzt=I("gl_hdzt");
        $hf_hfr=I("hf_hfr");
        //exit($gl_hdzt);
        if (!$id){
            echo "Id Error!";
            exit();
        }
        else{
            //改变业务状态
            $Edit_data=D("quser_lxxx_tb");
            $Edit_data->gl_hdzt=$gl_hdzt;
            $ret=$Edit_data->where("id=$id")->save();
            //增加回复信息
            $add_data=D("quser_hfxx_tb");
            $add_data->hf_content=$hf_content;
            $add_data->hf_ywid=$id;
            $add_data->hf_sj=date('Y-m-d H:i:s',time());
            $add_data->hf_hfr=$hf_hfr;
            $add_data->hf_ywlx=$gl_ywlx;
            $add_data->add();
            redirect('/home/manage', 1, '回复成功，正在跳转...');
        }

    }

    //投资意向
    function loadtzxqdata($where){
        $TableName=M("tzxq_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_ntzxm"]  = array('like',"%$this->_keyword%");
            $where["gl_ntzgm"]  = array('like',"%$this->_keyword%");
            $where["gl_ntzfs"]  = array('like',"%$this->_keyword%");
            $where["gl_ntzjd"]  = array('like',"%$this->_keyword%");
            $where["gl_tzrmc"]  = array('like',"%$this->_keyword%");
            $where["gl_zsd"]  = array('like',"%$this->_keyword%");
            $where["gl_zczb"]  = array('like',"%$this->_keyword%");
            $where["gl_tzrlx"]  = array('like',"%$this->_keyword%");
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
    //专职入库
    function loadzjrkdata($where){
        $TableName=M("zjinfoxx_vm");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["cg_wcrxm"]  = array('like',"%$this->_keyword%");
            $where["cg_wcrxb"]  = array('like',"%$this->_keyword%");
            $where["cg_wcrchj"]  = array('like',"%$this->_keyword%");
            $where["gl_ntzjd"]  = array('like',"%$this->_keyword%");
            $where["gl_tzrmc"]  = array('like',"%$this->_keyword%");
            $where["gl_zsd"]  = array('like',"%$this->_keyword%");
            $where["gl_zczb"]  = array('like',"%$this->_keyword%");
            $where["gl_tzrlx"]  = array('like',"%$this->_keyword%");
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
    function loadQhfdata(){
        $TableName=M("quser_hfxx_tb");
        $this->_page_count=$count=$TableName->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        echo $TableName->_sql();
    }

}