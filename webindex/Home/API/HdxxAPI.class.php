<?php
namespace Home\API;
class HdxxAPI
{
    public $_page_size="25"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_user_info=array(); //用户信息
    public $_bm_info=array(); //会议报名单位信息
    public $_chr_info=array(); //参会人信息
    public $actionInfo=""; //返回要执行的动作


    //数据增加
    function AddHdxx(){
        if ($_POST){
            $add_data=D("hdxx_tb");
            $add_data->gl_hdlx="会议";
            $add_data->gl_mc=I("gl_mc");
            $add_data->gl_zbf=I("gl_zbf");
            $add_data->gl_dd=I("gl_dd");
            $add_data->gl_kssj=I("gl_kssj");
            $add_data->gl_jssj=I("gl_jssj");
            $add_data->gl_bmkssj=I("gl_bmkssj");
            $add_data->gl_bmjssj=I("gl_bmjssj");
            $add_data->add();
            $this->actionInfo='{$this->assign("sussInfo","增加成功，请继续！");}';
        }
    }
    //全部数据查询
    function loadmatedata($where){
        $TableName=M("hdxx_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["gl_mc"]  = array('like',"%$this->_keyword%");
            $where["gl_zbf"]  = array('like',"%$this->_keyword%");
            $where["gl_dd"]  = array('like',"%$this->_keyword%");
            /*$where["gl_kssj"]  = array('like',"%$this->_keyword%");
            $where["gl_jssj"]  = array('like',"%$this->_keyword%");
            $where["gl_bmkssj"]  = array('like',"%$this->_keyword%");
            $where["gl_bmjssj"]  = array('like',"%$this->_keyword%");  */
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

    //可报名的会议数据查询
    function loadbmdata($where){
        $TableName=M("hdxx_tb");
        $date = date('Y-m-d H:m:s');
        $where["gl_bmkssj"]  = array('ELT',$date);
        $where["gl_bmjssj"]  = array('EGT',$date);
        $this->_dateil_data=$TableName->where($where)->order("id DESC")->select(); //主表数据取值完成
        //echo $TableName->getLastSql()."<br />";
        //var_export($this->_dateil_data);
        //echo $date;
    }
    //
    function loadhybmdata($where){
        $TableName=M("hdxx_tb");
        $hy_id=I("hy_id");
        if (!$hy_id){
            echo "Info Error!";
            exit();
        }

        $where["id"]  = array('eq',$hy_id);
        $this->_dateil_data=$TableName->where($where)->limit(1)->select(); //读取会议信息
        //echo $TableName->_sql();
        $get_logincook=$_COOKIE['user_info'];
        $get_user_log=unserialize($get_logincook);
        $user_name=$get_user_log->user_name;
        $user_comp=$get_user_log->user_comp;
        //var_export($get_user_log);
        $userTable=M("qx_user_tb");
        $this->_user_info=$userTable->where("user_name='$user_name'")->limit(1)->select(); //读取用户信息
        $BmTable=M("hdhz_tb");
        $this->_bm_info=$BmTable->where("gl_dwmc='$user_comp'")->limit(1)->select(); //读取单位报名信息
        $bm_info=$this->_bm_info;
        $bm_dwid=$bm_info[0];
        $bm_dwid=$bm_dwid['id'];
        $this->_page_count=$BmTable->where("gl_dwmc='$user_comp'")->count();
        if ($bm_dwid>0){
        $ChTable=M("hdchry_tb");
        $this->_chr_info=$ChTable->where("gl_dwid=$bm_dwid")->select(); //读取参会人信息
        $this->_page_bar=$ChTable->where("gl_dwid=$bm_dwid")->count();
        }
        //echo $this->_page_count;
        //echo $ChTable->_sql();
    }
    function AddHzxx(){
        $AddTable=D("hdhz_tb");
        $dw=I("gl_dwmc");
        $AddTable->gl_hdid=I("gl_hdid");
        $AddTable->gl_dwmc=I("gl_dwmc");
        $AddTable->gl_txdz=I("gl_txdz");
        $AddTable->gl_ssap=I("gl_ssap");
        $AddTable->gl_lxr=I("gl_lxr");
        $AddTable->gl_lxdh=I("gl_lxdh");
        $AddTable->gl_dzyx=I("gl_dzyx");
        $AddTable->gl_bmsj=date("Y-m-d H:m:s");

        $count=$AddTable->where("gl_dwmc='$dw'")->count();
        if ($count==0){
            $AddTable->add();
            $id= $AddTable->getLastInsID();
            echo $id;
        }else
        {
            echo "您所在的单位已经报过名了!";
        }
    }
    function AddChr(){
        $AddTable=D("hdchry_tb");
        $dw=I("gl_dwid");
        $AddTable->gl_dwid=I("gl_dwid");
        $AddTable->gl_chrxm=I("gl_chrxm");
        $AddTable->gl_bmzw=I("gl_bmzw");
        $AddTable->gl_xb=I("gl_xb");
        $AddTable->gl_sj=I("gl_sj");
        $AddTable->gl_yx=I("gl_yx");
        $AddTable->gl_bz=I("gl_bz");
        $AddTable->gl_bmsj=date("Y-m-d H:m:s");

        $count=$AddTable->where("gl_dwid='$dw'")->count();
        if ($count<=5){
            $AddTable->add();
            $id= $AddTable->getLastInsID();
            echo $id;
        }else
        {
            echo "最多只能报六个人，你的名额满了!";
        }

    }
    function loadmanagebmdata($where){
        $TableName=M("hdxx_tb");
        $hy_id=I("hy_id");
        $dw_id=I("dw_id");
        if (!$hy_id){
            echo "Info Error!";
            exit();
        }

        $where["id"]  = array('eq',$hy_id);
        $this->_dateil_data=$TableName->where($where)->limit(1)->select(); //读取会议信息
        //echo $TableName->_sql();
        $get_logincook=$_COOKIE['user_info'];
        $get_user_log=unserialize($get_logincook);
        $user_name=$get_user_log->user_name;
        $user_comp=$get_user_log->user_comp;
        //var_export($get_user_log);
        $userTable=M("qx_user_tb");
        $this->_user_info=$userTable->where("user_name='$user_name'")->limit(1)->select(); //读取用户信息
        $BmTable=M("hdhz_tb");
        $this->_bm_info=$BmTable->where("gl_hdid=$hy_id")->order("id desc")->select(); //读取单位报名信息
        $bm_info=$this->_bm_info;
        $bm_dwid=$bm_info[0];
        $bm_dwid=$bm_dwid['id'];
        $this->_page_count=$BmTable->where("gl_dwmc='$user_comp'")->count();
        if ($bm_dwid>0){
            $ChTable=M("hdchry_tb");
            $this->_chr_info=$ChTable->where("gl_dwid=$bm_dwid")->select(); //读取参会人信息
            $this->_page_bar=$ChTable->where("gl_dwid=$bm_dwid")->count();
        }
        //echo $this->_page_count;
        //echo $ChTable->_sql();
    }
    function loadmanagechrdata($where){
        $TableName=M("hdxx_tb");
        $hy_id=I("hy_id");
        $dw_id=I("dw_id");
        if (!$hy_id){
            echo "Info Error!";
            exit();
        }

        $where["id"]  = array('eq',$hy_id);
        $this->_dateil_data=$TableName->where($where)->limit(1)->select(); //读取会议信息
        //echo $TableName->_sql();
        $get_logincook=$_COOKIE['user_info'];
        $get_user_log=unserialize($get_logincook);
        $user_name=$get_user_log->user_name;
        $user_comp=$get_user_log->user_comp;
        //var_export($get_user_log);
        $BmTable=M("hdhz_tb");
        $this->_bm_info=$BmTable->where("id=$dw_id")->order("id desc")->select(); //读取单位报名信息

            $ChTable=M("hdchry_tb");
            $this->_chr_info=$ChTable->where("gl_dwid=$dw_id")->select(); //读取参会人信息
            $this->_page_bar=$ChTable->where("gl_dwid=$dw_id")->count();
        //echo $this->_page_count;
        //echo $ChTable->_sql();
    }

}