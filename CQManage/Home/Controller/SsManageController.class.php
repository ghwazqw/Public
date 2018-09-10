<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/1/22
 * Time: 下午9:15
 */
namespace Home\Controller;
use Home\API\CgxxAPI;
use Home\API\DelDataAPI;
use Home\API\SsManageAPI;
use Home\API\UserAPI;
use Think\Controller;
class SsManageController extends Controller {
    public function index(){
        $this->theme("manage")->display("");
    }
    public function RzhuManage(){
        $ii=new CgxxAPI();
        $ii->SsInfolist();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("count",$ii->_page_count);
        //echo $ii->_page_count;
        $this->theme("manage")->display("");
    }
    public function Rzsq(){

        //读取房间详细信息
        $ii=new CgxxAPI();
        $ii->Fjian_dal();
        $this->assign("info_data",$ii->_dateil_data); //房间详细信息读取
        $io=new SsManageAPI();
        $io->HouseRyInfo();
        $this->assign("count",$io->_page_count);
        $this->assign("ryinfo",$io->_main_data);
        $ic=new UserAPI();
        $ic->loadRyuandata();
        $this->assign("RyInfoData",$ic->_main_data); //主表数据
        $this->theme("manage")->display("");
    }
    //入住信息
    public function RzSubmit(){
        $ii=new SsManageAPI();
        $ii->AddRyInfo();
        $id=$ii->_stId;
        $this->success('入住信息填写成功','/home/SsManage/Rzsq?id='.$id,1);
    }
    //租金信息列表
    public function RzInfoList(){
        $ii=new SsManageAPI();
        $ii->RzInfoList();
        $this->ajaxReturn($ii->_main_data,'JSON');
        //echo $Ryname;
    }
    //年度租金信息列表
    public function RzInfoNdList(){
        $ii=new SsManageAPI();
        $ii->RzInfoNdList();
        $this->ajaxReturn($ii->_main_data,'JSON');
        //echo $Ryname;
    }
    //年度所有人员租金信息统计
    public function RzInfoNdNdList(){
        $ii=new SsManageAPI();
        $ii->RzInfoNdNdList();
        $this->ajaxReturn($ii->_page_count,'JSON');
        //$this->ajaxReturn($ii->_main_data,'JSON');
        //echo $Ryname;
    }
    //租金收取列表
    public function Zjsq(){
        $ii=new CgxxAPI();
        $ii->SsInfolist();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("count",$ii->_page_count);
        $this->theme("manage")->display("");
    }
    //提交租金取
    public function ZjSubmit(){
        $fjid=I("fjid");
        $ii=new SsManageAPI();
        $ii->ZjSubmit(); //提交租金信息
        $ii->RzInfoNdList("$fjid"); //重新读取信息
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //人员信息查询
    public function RyInfo(){
        $ii=new SsManageAPI();
        $ii->RyInfo();
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //退宿管理
    public function TsManage(){
        $ii=new SsManageAPI();
        $ii->RzFjInfo();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display("");
    }
    //退宿信息提交
    public function TsSubmit(){
        $ii=new SsManageAPI();
        $ii->TsSubmit();
        $this->success('房间腾退成功','/home/SsManage/tsmanage',1);
    }
    //腾退完数据查询
    public function TtView(){
        $ii=new SsManageAPI();
        $ii->TtInfo();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display("");
    }
    //信息数据查询
    public function RzView(){
        $ii=new SsManageAPI();
        $ii->RzInfo();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        if (!$ii->_nf){
            $this->assign("nf",date("Y"));
        }else{
            $this->assign("nf",$ii->_nf);
        };
        $this->assign("nfxx",date("Y")-5); //开始年份
        $this->theme("manage")->display("");
    }
    //租金进度统计
    public function ZjjdView(){
        $ii=new CgxxAPI();
        $ii->SsInfolist();
        $this->assign("info_data",$ii->_main_data);
        //var_export($ii->_main_data);
        $this->assign("count",$ii->_page_count);
        $ii=new SsManageAPI();
        $ii->RzInfoNdNdList();
        $this->theme("manage")->display("");
    }
    //年度租金查询
    public function NdZjView(){
        $ii=new SsManageAPI();
        $ii->NdZjView();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        if (!$ii->_nf){
            $this->assign("nf",date("Y"));
        }else{
            $this->assign("nf",$ii->_nf);
        };
        $this->assign("nfxx",date("Y")-5); //开始年份
        $this->theme("manage")->display("");
    }
}
