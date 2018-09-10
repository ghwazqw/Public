<?php
namespace Home\Controller;
use Home\API\DpManageAPI;
use Home\API\PdManageAPI;
use Home\API\UserAPI;
use Think\Controller;
class DpManageController extends Controller {
    //读取人员信息
    public function index(){
        /*$ii=new DpManageAPI();
        $ii->loadRyuandata();
        $this->assign("RyInfoData",$ii->_main_data); //主表数据
        $this->assign("keyword",$ii->_keyword); //关键字输出*/
        //读取部门信息
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        //var_export($ic->_class_data);

            $io=new PdManageAPI();
            $io->DzsbList(); //电子设备
            $this->assign("DzsbInfo",$io->_main_data);
            $this->assign("Dzpage",$io->_page_bar);
            $this->assign("keyword",$io->_keyword) ;
            $this->assign("comp",$io->_comp) ;
            $io->DqsbList();  //机械器具
            $this->assign("DqsbInfo",$io->_Dqsbinfo);
            $this->assign("Dqpage",$io->_page_bar);
            $io->QtsbList(); //其他设备
            $this->assign("QtsbInfo",$io->_Qtsbinfo);
            $this->assign("Qtpage",$io->_page_bar);
            $io->YsgjList(); //运输工具
            $this->assign("YssbInfo",$io->_Ysgjinfo);
            $this->assign("Yspage",$io->_page_bar);
            //var_export($io->_Ysgjinfo);

        $id=I("id");
        if ($id!=""){
            $io=new DpManageAPI();
            $io->LoadZrrInfo();
            //$this->assign("info",$io->_class_meta_data);
            //var_export($io->_class_meta_data);
            $this->ajaxReturn($io->_main_data,'JSON');
        }
        else{
            /*$this->assign("class_info",$ii->_class_data);*/
            $this->theme("manage")->display("dpsq");
        }

    }
    //AJAX获取人员的当前下属的资产情况
    public function ry_zcsb(){
        $ii=new DpManageAPI();
        $ii->loadRyZcsbData();
        $count=$ii->_page_count;
        $this->ajaxReturn($ii->_main_data,'JSON');
    }

    //AJax根据类别获取资产信息
    public  function ZcsbData(){
        $ii=new DpManageAPI();
        $ii->loadZcSbData();
        $this->ajaxReturn($ii->_main_data,'JSON');
        //var_export($ii->_main_data);
    }
    //AJAX提交分配信息
    public function DpAddInfo(){
        $ii=new DpManageAPI();
        $ii->DpxxAddInfo();
    }
    //读取调配信息
    public function DpView(){
        $ii=new DpManageAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    public function DpSubmit(){
        $ii=new DpManageAPI();
        $ii->SubmitDpinfo();
    }
}
