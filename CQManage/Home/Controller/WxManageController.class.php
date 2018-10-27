<?php
namespace Home\Controller;
use Home\API\ActionAPI;
use Home\API\PdManageAPI;
use Home\API\UserAPI;
use Home\API\WxManageAPI;
use Home\API\ZcxxAPI;
use Think\Controller;
class WxManageController extends Controller {
    function index(){
        $ii=new WxManageAPI();
        $ii->loadmatedata("维修",0);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    function WxView(){
        $ii=new WxManageAPI();
        $ii->loadmatedata("维修审批",100);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    function Wxsp(){
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $this->assign("zcusername",$ii->_username); //当前用户名信息
        $this->assign("date",date('Y-m-d',time())); //当前日期信息
        $ii=new WxManageAPI();
        $ii->LoadWxSpdata(2);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    function Wxqr(){
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $this->assign("zcusername",$ii->_username); //当前用户名信息
        $this->assign("date",date('Y-m-d',time())); //当前日期信息
        $ii=new WxManageAPI();
        $ii->LoadWxSpdata(99);
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

        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        //var_export($ic->_class_data);
        $this->assign("date",date('Y-m-d',time()));
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
    //维修审批开始
    function WxSpSub(){
        $sblx=I("sblx");
        $sbid=I("sbid");
        $zt=I("spzt"); //2为维修状态
        $io=new ZcxxAPI();
        $io->SbxxZt($sblx,$sbid,$zt);
        if ($io->_zt==1){ //调用设备记录类
            $content="该业务发生于：".date("Y-m-d H:i:s")."，由".I("czr")."对".I("sbmc").", 编号：".I("sbbh")."的资产设备进行了维修申请。";
            $io->SbxxInfoAdd($content,$zt); //调用日志操作类
            if ($io->_zt>0){ //调用设备审批类
                $logid=$io->_zt;
                $io->SbSpxx($logid);
            }
            $this->success('成功提交审批，请等待审批结果','/Home/WxManage/wxsq_comp',1);
        }else{
            $this->error('提交失败，请重试','/Home/WxManage/wxsq_comp',1);
        }
    }
    //维修审批过程
    function WxSpManage(){
        $id=I("logid");
        $zt=I("spzt");
        //exit();
        $ii=new ActionAPI();
        $ii->ChId($id);
        $io=new ZcxxAPI();
        //改变审批状态
        $io->SbSpxx($id);
        if ($io->_zt>0){
            $ic=new ZcxxAPI();
            $ic->SbxxInfoAdd("1",$zt,$id);
            $this->success('审批成功。','/Home/WxManage/wxsp',1);
        }else{
            $this->error('审批失败，请重试','/Home/WxManage/wxsp',1);
        }

    }
    //维修完工确认
    function WxWgQr(){
        $id=I("logid");
        $zt=I("spzt");
        $sblx=I("sblx");
        $sbid=I("sbid");
        $ii=new ActionAPI();
        $ii->ChId($id);
        $io=new ZcxxAPI();
        $io->SbSpxx($id);
        if ($io->_zt>0){
            $ic=new ZcxxAPI();
            $ic->SbxxInfoAdd("1",$zt,$id);
            $zt=I("spzt"); //2为维修状态
            $io=new ZcxxAPI();
            $io->SbxxZt($sblx,$sbid,1);
            $this->success('确认成功。','/Home/WxManage/wxqr',1);
        }else{
            $this->error('确认失败，请重试','/Home/WxManage/wxqr',1);
        }
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
        /*$io=new ZcxxAPI();
        $io->SbSpxx($logid);*/
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
    //维修申请(部门)管理
    public function wxsq_comp(){
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $this->assign("zcusername",$ii->_username); //当前用户名信息
        $this->assign("date",date('Y-m-d',time())); //当前日期信息
        $io=new ZcxxAPI();
        $io->DzsbCompList(); //电子设备
        $this->assign("DzsbInfo",$io->_main_data);
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("zccomp",$io->_zcsybm);
        $this->assign("dzcount",$io->_dzsbcount);
        $this->assign("dzpage",$io->_dzpage);    //分页组件
        $io->DqsbCompList();  //机械器具
        $this->assign("DqsbInfo",$io->_Dqsbinfo);
        $this->assign("dqcount",$io->_dqsbcount);
        $this->assign("dqpage",$io->_dqpage);    //分页组件
        $io->QtsbCompList(); //其他设备
        $this->assign("QtsbInfo",$io->_Qtsbinfo);
        $this->assign("qtcount",$io->_qtsbcount);
        $this->assign("qtpage",$io->_qtpage);    //分页组件
        $io->YsgjCompList(); //运输工具
        $this->assign("YssbInfo",$io->_Ysgjinfo);
        $this->assign("yscount",$io->_yssbcount);
        $this->assign("clpage",$io->_clpage);    //分页组件
        //var_export($io->_Ysgjinfo);
        $this->theme("manage")->display();
    }



}
