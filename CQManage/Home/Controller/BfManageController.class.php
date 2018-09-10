<?php
namespace Home\Controller;
use Home\API\BfManageAPI;
use Home\API\PdManageAPI;
use Home\API\UserAPI;
use Home\API\ZcxxAPI;
use Think\Controller;
class BfManageController extends Controller {
    function index(){
        $ii=new BfManageAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display("");
    }
    function Editor(){
        /*if ($_POST){
            $a=new BfManageAPI();
            $a->AddBfxx();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }*/
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        $io=new ZcxxAPI();
        $io->DzsbCompList(); //电子设备
        $this->assign("DzsbInfo",$io->_main_data);
        $this->assign("keyword",$io->_keyword) ;
        $io->DqsbCompList();  //机械器具
        $this->assign("DqsbInfo",$io->_Dqsbinfo);
        $io->QtsbCompList(); //其他设备
        $this->assign("QtsbInfo",$io->_Qtsbinfo);
        $io->YsgjCompList(); //运输工具
        $this->assign("YssbInfo",$io->_Ysgjinfo);
        //var_export($io->_Ysgjinfo);


        $this->theme("manage")->display("Bfsq");
    }
    function infoExp(){
        $ii=new BfManageAPI();
        $ii->expExcel();
    }
    function BfSubmit(){
        $sub=new BfManageAPI();
        $sub->BfSubmit();
    }
    function BfManage(){
        $ii=new BfManageAPI();
        $ii->Bflist();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    function BfPrint(){
        $ii=new BfManageAPI();
        $ii->Bflist();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    function Bfqueren(){
        $ii=new BfManageAPI();
        $ii->Bfqueren();
    }
    function BfcxsqManage(){
        $ii=new BfManageAPI();
        $ii->BfCxSq();
    }
    function BfList(){
        $ii=new BfManageAPI();
        $ii->Bflistq();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    function BfCxSq(){
        $ii=new BfManageAPI();
        $ii->BfBhList();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
}
