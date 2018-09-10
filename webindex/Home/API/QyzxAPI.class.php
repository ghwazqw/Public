<?php

namespace Home\API;
class QyzxAPI{
    public $actionInfo="";
    public $_main_date="";
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main1_data=array(); //主表数据
    public $_meta1_data=array();
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; // 关键字数据
    public $_lxdata=""; //资讯类型
    public $_type="";
    
    //对接需求  
    function djzx_yw($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where['gl_cjr']  = array('like',"%$this->_keyword%"); //创建人
        }
        $this->_page_count=$count=M("djxq_vm")->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,"40");

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $get_logincook=$_COOKIE['user_info'];
		if (!$get_logincook) return false; //
		$get_user_log=unserialize($get_logincook);
		//echo ($get_user_log->user_name);
        $set_name=$get_user_log->user_name;
        $this->_main1_data=$ret=M("djxq_vm")->where("gl_cjr='$set_name'")->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成

        //echo $ret->getLastSql();
        if($_POST){
            $info_add_tb=D("quser_ywgthf_tb");
            $info_edit_tb=D("quser_lxxx_tb");

            $info_add_tb->gl_hfr=I("gl_hfr");
            $info_add_tb->gl_ywid=I("ywid");
            $info_add_tb->gl_hfrip=get_client_ip();
            $info_add_tb->gl_hfsj=date('Y-m-d H:i:s',time());
            $info_add_tb->gl_content=I("gl_content");
            $info_add_tb->gl_ywlx="zjxq";
            $info_add_tb->gl_ywcjr=I("gl_ywcjr");
            $info_add_tb->gl_hfyj=I("gl_hfyj");
            $info_add_tb->add();
            $set_id=I("ywid");

            $info_edit_tb->gl_hdzt=I("gl_hfyj");

            $info_edit_tb->where("gl_ywid=$set_id")->save();

            $this->actionInfo='{$this->assign("sussInfo","信息已回复！");}';


        }
    }
    function djxz_detail($where,$where1){
    	//echo(I("bm"));
    	$this->_type=I("type");
        $this->_keyword = I("bm");
        if ($this->_keyword!=""){
            $where['id']  = array('eq',$this->_keyword); //业务表ID
            $where1["gl_ywid"]=array('eq',$this->_keyword);
            //$where['_logic']='OR';
        }

        $this->_page_count=$count=M("djxq_vm")->where($where)->order("id DESC")->count();
        $this->_meta_data=$ret=M("djxq_vm")->where($where)->order("id DESC")->select(); //详细基础数据取值完

        $this->_dateil_data=$re1=M("quser_ywgthf_tb")->where($where1)->order("gl_hfsj")->select();
        $this->_main_date=$ret2=M("quser_ywgthf_tb")->where($where1)->order("gl_hfsj desc")->LIMIT(1)->select();

        if($_POST){
            $info_add_tb=D("quser_ywgthf_tb");
            $info_edit_tb=D("quser_lxxx_tb");

            $info_add_tb->gl_hfr=I("gl_hfr");
            $info_add_tb->gl_ywid=I("ywid");
            $info_add_tb->gl_hfrip=get_client_ip();
            $info_add_tb->gl_hfsj=date('Y-m-d H:i:s',time());
            $info_add_tb->gl_content=I("gl_content");
            $info_add_tb->gl_ywlx="zjxq";
            $info_add_tb->gl_ywcjr=I("gl_ywcjr");
            $info_add_tb->gl_hfyj=I("gl_hfyj");
            $info_add_tb->add();
            $set_id=I("ywid");

            $info_edit_tb->gl_hdzt=I("gl_hfyj");

            $info_edit_tb->where("gl_ywid=$set_id")->save();

            $this->actionInfo='{$this->assign("sussInfo","已提交，请耐心等待！");}';


        }
    }
}