<?php

namespace Home\API;
class YwzxQManageAPI {
    public $_page_size="10"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字数据
    public $_class_data=""; //类型数据
    public $_class_meta_data=""; //关键字数据
    public $actionInfo=""; //返回要执行的动作

    function user_name(){
        $get_logincook=$_COOKIE['user_info'];
        $get_user_log=unserialize($get_logincook);
        $user_name=$get_user_log->user_name;
        return $user_name;
    }
    //成果入库
    function loadmatedata($where){

        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("cgrk_vm");
        $where["gl_cjr"]=array('eq',"$user_name");

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
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("xqsq_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
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
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("gjxq_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
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
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("hyxq_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
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
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("kjzx_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
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
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("cgpg_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
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
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("kyzx_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
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
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("rzxq_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
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
//供需对接详细
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
        if (!$id){
            echo "Id Error!";
            exit();
        }
        else{
            //改变业务状态
            $Edit_data=D("quser_lxxx_tb");
            $Edit_data->gl_hdzt=$gl_hdzt;
            $Edit_data->where("gl_ywid=$id")->save();
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
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("tzxq_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //投资意向
    function loadzjxxdata($where){
        $user_name=$this->user_name();
        if (!$user_name){
            echo "非法操作";
            exit();
        }

        $TableName=M("zjinfoxx_vm");
        $where["gl_cjr"]=array('eq',"$user_name");
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