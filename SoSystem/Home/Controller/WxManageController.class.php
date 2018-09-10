<?php
namespace Home\Controller;
use Home\API\PdManageAPI;
use Home\API\UserAPI;
use Home\API\WxManageAPI;
use Think\Controller;
class WxManageController extends Controller {
    function index(){
        $ii=new WxManageAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //编辑信息
    function Editor(){
        if ($_POST){
            $a=new WxManageAPI();
            $a->Addinfo();
        }
        $this->theme("manage")->display();
    }
    //新增信息
    function Addinfo(){
        $ii=new WxManageAPI();
        $ii->Addinfo();
    }
    //列表信息
    function Wxsq(){
        /*if ($_POST){
            if ($action=="S"){
                $ii=new WxManageAPI();
                $ii->Sbxxlist();
                $this->assign("InfoData",$ii->_main_data); //主表数据
                $this->assign("pagebar",$ii->_page_bar);    //分页组件
                $this->assign("count",$ii->_page_count);    //统计数据
                $this->assign("keyword",$ii->_keyword);
                $this->assign("page_count",$ii->_page_size);
                $this->assign("sblx",$ii->_sblx);
            }elseif ($action=="A"){
            }
        }*/
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


        $this->theme("manage")->display();
    }
    //维净比过高信息
    function Wxsqwjb(){
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        //var_export($ic->_class_data);
        $io=new PdManageAPI();
        $io->DzsbwjList(); //电子设备
        $this->assign("DzsbInfo",$io->_main_data);
        $this->assign("Dzpage",$io->_page_bar);
        $this->assign("Dz_count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $io->DqsbwjList();  //机械器具
        $this->assign("DqsbInfo",$io->_Dqsbinfo);
        $this->assign("Dq_count",$io->_page_count) ;
        $this->assign("Dqpage",$io->_page_bar);
        $io->QtsbwjList(); //其他设备
        $this->assign("QtsbInfo",$io->_Qtsbinfo);
        $this->assign("Qt_count",$io->_page_count) ;
        $this->assign("Qtpage",$io->_page_bar);
        $io->YsgjwjList(); //运输工具
        $this->assign("YssbInfo",$io->_Ysgjinfo);
        $this->assign("Ys_count",$io->_page_count) ;
        $this->assign("Yspage",$io->_page_bar);
        //var_export($io->_Ysgjinfo);
        $this->theme("manage")->display();
    }
    //导出信息
    function infoExp(){
        $ii=new WxManageAPI();
        $ii->expExcel();
    }
    //等待
    function wait(){
        $this->theme("manage")->display();
    }
    //详细信息
    function detail(){
        $ii=new WxManageAPI();
        $ii->Detail();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("DalData",$ii->_dateil_data); //主表数据
        //var_export($ii->_main_data);
        $this->theme("manage")->display();
    }
    //维修记录保存
    function WxSubmit(){
        $sub=new WxManageAPI();
        $sub->WxSubmit();
    }
    //保养信息
    function Bysq(){
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
        //var_export($io->_Ysgjinfo);

        $this->theme("manage")->display();
    }
    //维修记录保存
    function YhSubmit(){
        $sub=new WxManageAPI();
        $sub->YhSubmit();
    }
    function Bylist(){
        $ii=new WxManageAPI();
        $ii->Bylist();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }


}
