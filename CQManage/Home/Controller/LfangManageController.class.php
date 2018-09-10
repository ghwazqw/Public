<?php
namespace Home\Controller;
use Home\API\CgxxAPI;
use Home\API\DelDataAPI;
use Home\API\FpManageAPI;
use Home\API\LfangAPI;
use Home\API\PdManageAPI;
use Home\API\UserAPI;
use Think\Controller;
class LfangManageController extends Controller {
    function index(){
        $io=new CgxxAPI();
        $io->loadmatedata();
        $this->assign("info_data",$io->_main_data); //主表数据
        $this->assign("pagebar",$io->_page_bar);    //分页组件
        $this->assign("count",$io->_page_count);    //统计数据
        $this->assign("keyword",$io->_keyword);
        $this->theme("manage")->display("");

    }
    function addinfo(){
            $ii=new LfangAPI();
            $ii->AddLouFangInfo();
            if ($ii->_pass=="ok"){
                $this->success('新增成功，正在跳转','/Home/LfangManage',1);
            }else{
                $this->error('新增成功，正在返回','/Home/LfangManage',1);
            }

    }
    function Fpei(){
        $fj_id=I("fj_id");
        $fj_name=I("fj_name");
        if (!$fj_id){
            echo "房屋信息读取错误！";
            exit();
        }else
        {
            $this->assign("fj_id",$fj_id);
            $this->assign("fj_name",$fj_name);
            //读取部门信息
            $ic=new UserAPI();
            $ic->loadcompdata();
            $this->assign("CompInfo",$ic->_class_data);
            //var_export($ic->_class_data);
            $io=new FpManageAPI();
            $io->DzsbList(); //电子设备
            $this->assign("DzsbInfo",$io->_main_data);
            $this->assign("comp",$io->_depName);
            $this->assign("keyword",$io->_keyword);
            $this->assign("Dz_count",$io->_page_count) ;
            $io->DqsbList();  //机械器具
            $this->assign("DqsbInfo",$io->_Dqsbinfo);
            $this->assign("Dq_count",$io->_page_count) ;
            $io->QtsbList(); //其他设备
            $this->assign("QtsbInfo",$io->_Qtsbinfo);
            $this->assign("Qt_count",$io->_page_count) ;
            $io->YsgjList(); //运输工具
            $this->assign("YssbInfo",$io->_Ysgjinfo);
            $this->assign("Ys_count",$io->_page_count);
            $ry=new UserAPI();
            $ry->loadNRyuandata(); //人员信息
            $this->assign("ry_info",$ry->_main_data);
            $this->assign("ry_count",$ry->_page_count);


            $this->theme("manage")->display("");
        }
    }
    /*写入分配信息*/
    function AddFpInfo(){
        $fj_id=I("fj_id");
        $fj_name=I("fj_name");
        if ($_POST){
            $ii=new FpManageAPI();
            $ii->AddFpInfo();
            if ($ii->_pass=="ok"){
                $this->success('分配成功，正在跳转','/Home/LfangManage/Fjian?id='.$fj_id,1);
            }else{
                $this->error('分配失败，正在返回','/Home/LfangManage/Fjian?id='.$fj_id,1);
            }
        }
    }
    function editinfo(){
        if ($_POST){
            $ii=new LfangAPI();
            $ii->EditLouFangInfo();
            if ($ii->_pass=="ok"){
                $this->success('楼宇信息编辑成功，正在跳转','/Home/LfangManage',1);
            }else{
                $this->error('楼宇信息编辑失败，正在返回','/Home/LfangManage',1);
            }
        }
    }
    function house_list(){
        $io=new CgxxAPI();
        $io->home_list();
        $this->assign("info_data",$io->_main_data); //主表数据
        $this->assign("pagebar",$io->_page_bar);    //分页组件
        $this->assign("count",$io->_page_count);    //统计数据
        $this->assign("keyword",$io->_keyword);
        $io->LouFangdata();
        $this->assign("LoufData",$io->_main_data);
        $this->theme("manage")->display("");
    }
    //增加房间信息
    function AddHouse(){
            $ii=new LfangAPI();
            $ii->AddHouseInfo();
            if ($ii->_pass=="OK"){
                $this->success('信息增加成功','/Home/LfangManage/house_list',1);
            }else{
                $this->error('信息增加成功','/Home/LfangManage/house_list',1);
            }
    }
    //编辑房间信息
    function EditHouse(){
        $ii=new LfangAPI();
        $ii->EditHouseInfo();
        if ($ii->_pass=="OK"){
            $this->success('信息编辑成功','/Home/LfangManage/house_list',1);
        }else{
            $this->error('信息编辑成功','/Home/LfangManage/house_list',1);
        }
    }
    //删除信息
    function delinfo(){
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/Home/LfangManage',1);
        }else{
            $this->error('信息删除失败','/Home/LfangManage',1);
        }
    }
    //删除信息
    function delhouseinfo(){
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/Home/LfangManage/house_list',1);
        }else{
            $this->error('信息删除失败','/Home/LfangManage/house_list',1);
        }
    }
    //读取房间详细信息
    function Fjian(){
        $ii=new CgxxAPI();
        $ii->Fjian_dal();
        $fjid=I("id");
        $ry=new UserAPI();
        $ry->loadFjRyuandata();
        $this->assign("info_data",$ii->_dateil_data); //房间详细信息读取
        $this->assign("ry_info",$ry->_main_data); //人员信息
        $this->assign("ry_count",$ry->_page_count); //人员数据统计
        $io=new FpManageAPI();
        $io->FjDzsbList();  //电子设备读取
        $this->assign("DzsbInfo",$io->_main_data);
        $this->assign("Dz_count",$io->_page_count);
        $io->FjDqsbList();  //机械器具
        $this->assign("DqsbInfo",$io->_main_data);
        $this->assign("Dq_count",$io->_page_count) ;
        $io->FjQtsbList();  //其他设备
        $this->assign("QtsbInfo",$io->_main_data);
        $this->assign("Qt_count",$io->_page_count) ;
        $io->FjYsgjList(); //运输工具
        $this->assign("YssbInfo",$io->_main_data);
        $this->assign("Ys_count",$io->_page_count);
        //var_export($io->_main_data);

        $this->assign("fjid",$fjid); //房间ID
        $this->theme("manage")->display("");
    }
    //人员解除分配
    function ryjc(){
        $ii=new LfangAPI();
        $ii->RyJc();
    }
    //设备解除分配
    function sbjc(){
        $ii=new LfangAPI();
        $ii->SbJc();
    }
    //读取房间详细信息
    function Fjian_list(){
        echo "test";
    }
}
