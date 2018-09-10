<?php
namespace Home\Controller;
use Home\API\ActionAPI;
use Home\API\CgxxAPI;
use Home\API\DelDataAPI;
use Home\API\HtManageAPI;
use Home\API\PdManageAPI;
use Home\API\RoleAPI;
use Home\API\UserAPI;
use Home\API\ZcManageAPI;
use Home\API\ZcxxAPI;
use Think\Controller;
use Home\API\ExcelAPI;
use Think\Controller\RestController;

class ZcManageController extends RestController  {


    public function ZbManage(){
        $io=new RoleAPI();
        $io->operation();
        //读取操作数据
        $this->assign("oper_data",$io->_oper_data);
        $this->theme("manage")->display();
    }
    public function ZbEditor(){
        $ii=new ZcManageAPI();
        $ii->loadclassdata();

        $id=I("id");
        if ($id!=""){
            $io=new ZcManageAPI();
            $io->loadmetaclass();
            //$this->assign("info",$io->_class_meta_data);
            //var_export($io->_class_meta_data);
            $this->ajaxReturn($io->_class_meta_data,'JSON');
            //$arr=$io->_class_meta_data;
            //echo json_encod($arr);
        }
        else{
            $this->assign("class_info",$ii->_class_data);
            $this->theme("manage")->display();
        }
    }
    public function DqsbEditor(){
        $ii=new ZcManageAPI();
        $ii->loadclassdata();
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        if ($_POST){
            $a=new ZcManageAPI();
            $a->AddJxqjData(); //调用增加信息实体类
            $this->success('机械器具设备信息增加成功,正在跳转...','/Home/ZcManage/JxqjManage',1);
        }else{
            $id=I("id");
            if ($id!=""){
                $io=new ZcManageAPI();
                $io->loadmetaclass();
                //$this->assign("info",$io->_class_meta_data);
                //var_export($io->_class_meta_data);
                $this->ajaxReturn($io->_class_meta_data,'JSON');
                //$arr=$io->_class_meta_data;
                //echo json_encod($arr);
            }
            else{
                $this->assign("class_info",$ii->_class_data);
                $this->theme("manage")->display();
            }
        }
    }
    public function DzsbEditor(){
        $ii=new ZcManageAPI();
        $ii->loadclassdata();
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        if ($_POST){
            $a=new ZcManageAPI();
            $a->AddDzsbData(); //调用增加信息实体类
            $this->success('电子设备信息增加成功,正在跳转...','/Home/ZcManage/DzsbManage?lx=59',1);
        }else{
            $id=I("id");
            if ($id!=""){
                $io=new ZcManageAPI();
                $io->loadmetaclass();
                //$this->assign("info",$io->_class_meta_data);
                //var_export($io->_class_meta_data);
                $this->ajaxReturn($io->_class_meta_data,'JSON');
                //$arr=$io->_class_meta_data;
                //echo json_encod($arr);
            }
            else{
                $this->assign("class_info",$ii->_class_data);
                $this->theme("manage")->display();
            }
        }

    }
    public function DzsbManage(){

        $io=new PdManageAPI();
        $io->DzsbList(0); //电子设备
        $this->assign("InfoData",$io->_main_data);
        $this->assign("pagebar",$io->_page_bar);
        $this->assign("count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $this->assign("page_count",$io->_page_size);
        $this->assign("page_ys",$io->_page_ys);
        $io=new RoleAPI();
        $io->operation();
        //读取操作数据
        $this->assign("oper_data",$io->_oper_data);
        //读取使用部门信息
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        $this->theme("manage")->display("DzsbNewManage");
    }

    public function DzsbManage_All(){
        $ii=new ZcManageAPI();
        $ii->loadDzsbdata(1);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("page_ys",$ii->_page_ys);

        $this->theme("manage")->display();
    }
    public function JxqjManage(){
        /*$io=new PdManageAPI();
        $io->DqsbList(0); //机械器具
        $this->assign("InfoData",$io->_Dqsbinfo);
        $this->assign("pagebar",$io->_page_bar);
        $this->assign("count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $this->assign("page_count",$io->_page_size);
        $this->assign("page_ys",$io->_page_ys);*/

        //读取使用部门信息
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        $this->theme("manage")->display("jxsbnewmanage");
    }
    public function JxqjManage_All(){
        $io=new PdManageAPI();
        $io->DqsbList(0,1); //电子设备
        $this->assign("InfoData",$io->_Dqsbinfo);
        $this->assign("pagebar",$io->_page_bar);
        $this->assign("count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $this->assign("page_count",$io->_page_size);
        $this->assign("page_ys",$io->_page_ys);

        //读取使用部门信息
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        $this->theme("manage")->display();
    }
    public function QtsbManage(){
        $io=new PdManageAPI();
        $io->QtsbList(0); //电子设备
        $this->assign("InfoData",$io->_Qtsbinfo);
        $this->assign("pagebar",$io->_page_bar);
        $this->assign("count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $this->assign("page_count",$io->_page_size);
        $this->assign("page_ys",$io->_page_ys);

        //读取使用部门信息
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        $this->theme("manage")->display("qtsbnewmanage");
    }
    public function QtsbManage_All(){
        $io=new PdManageAPI();
        $io->QtsbList(0,1); //电子设备
        $this->assign("InfoData",$io->_Qtsbinfo);
        $this->assign("pagebar",$io->_page_bar);
        $this->assign("count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $this->assign("page_count",$io->_page_size);
        $this->assign("page_ys",$io->_page_ys);

        //读取使用部门信息
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        $this->theme("manage")->display();
    }
    public function ClxxManage(){
        $io=new PdManageAPI();
        $io->YsgjList(0); //电子设备
        $this->assign("InfoData",$io->_Ysgjinfo);
        $this->assign("pagebar",$io->_page_bar);
        $this->assign("count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $this->assign("page_count",$io->_page_size);
        $this->assign("page_ys",$io->_page_ys);

        //读取使用部门信息
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        $this->theme("manage")->display("ClxxNewManage");
    }
    public function ClxxManage_All(){
        $io=new PdManageAPI();
        $io->YsgjList(0,1); //电子设备
        $this->assign("InfoData",$io->_Ysgjinfo);
        $this->assign("pagebar",$io->_page_bar);
        $this->assign("count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $this->assign("page_count",$io->_page_size);
        $this->assign("page_ys",$io->_page_ys);
        $this->theme("manage")->display();
    }
    public function ClxxEditor(){
        $ii=new ZcManageAPI();
        $ii->loadclassdata();
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        if ($_POST){
            $a=new ZcManageAPI();
            $a->AddClxxData(); //调用增加信息实体类
            $this->success('车辆信息增加成功,正在跳转...','/Home/ZcManage/ClxxManage',1);
        }else{
            $id=I("id");
            if ($id!=""){
                $io=new ZcManageAPI();
                $io->loadmetaclass();
                //$this->assign("info",$io->_class_meta_data);
                //var_export($io->_class_meta_data);
                $this->ajaxReturn($io->_class_meta_data,'JSON');
                //$arr=$io->_class_meta_data;
                //echo json_encod($arr);
            }
            else{
                $this->assign("class_info",$ii->_class_data);
                $this->theme("manage")->display();
            }
        }
    }
    public function QtsbEditor(){
        $ii=new ZcManageAPI();
        $ii->loadclassdata();
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        if ($_POST){
            $a=new ZcManageAPI();
            $a->AddQtsbData(); //调用增加信息实体类
            $this->success('其他设备信息增加成功,正在跳转...','/Home/ZcManage/QtsbManage',1);
        }else{
            $id=I("id");
            if ($id!=""){
                $io=new ZcManageAPI();
                $io->loadmetaclass();
                //$this->assign("info",$io->_class_meta_data);
                //var_export($io->_class_meta_data);
                $this->ajaxReturn($io->_class_meta_data,'JSON');
                //$arr=$io->_class_meta_data;
                //echo json_encod($arr);
            }
            else{
                $this->assign("class_info",$ii->_class_data);
                $this->theme("manage")->display();
            }
        }
    }
    public function HtManage(){
        $ii=new HtManageAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        //$this->ajaxReturn($ii->_main_data,'JSON');
        $io=new RoleAPI();
        $io->operation();
        //读取操作数据
        $this->assign("oper_data",$io->_oper_data);
        if ($_POST)
        {
            $a=new HtManageAPI();
            $a->AddHtxx();
            $this->success('合同信息增加成功','/Home/ZcManage/HtManage',1);
        }else{
            $this->theme("manage")->display("Ht_Manage");
        }
    }
    public function HtList(){
        $ii=new HtManageAPI();
        $ii->Htlist();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    public function HtDqtx(){
        $ii=new HtManageAPI();
        $ii->Htdqtx();
    }
    public function HtManage_1(){
        $ii=new HtManageAPI();
        $ii->loadmatedata();
        /*$this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);*/
        $arr = array(
            'code'=>$ii->_keyword,
            'count'=>$ii->_page_count,
            'data'=>$ii->_main_data
        );
        $this->ajaxReturn($arr,'JSON');
    }
    //合同信息编辑
    public function HtEditor(){
        $ii=new HtManageAPI();
        $ii->EditHtxx();
        if ($_POST){
            $ii->EditHtxxOk();
            $this->success('信息更新成功','/Home/ZcManage/HtManage',0);
        }else{
            $this->assign("InfoData",$ii->_main_data);
            $this->theme("manage")->display();
        }

    }
    public function HtExp(){
        $ii=new HtManageAPI();
        $ii->expExcel();
    }
    //数据删除
    public function Htdel(){
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/Home/ZcManage/HtManage',0);
        }
    }
    //初始化维修金额
    public function Cswxje(){
        $ii=new ZcManageAPI();
        $table=I("table");
        if ($table==""){
            $ii->CswxjeNew();
        }else{
            $ii->Cswxje();
        }

    }
    //自定义查询
    public function ZcView(){
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        if ($_POST){
            $ii=new ZcManageAPI();
            $ii->SearchZcInfo();
            $this->assign("InfoData",$ii->_main_data);
            $this->assign("Count",$ii->_page_count);
            $this->assign("zc_lx",$ii->_lx);
            $this->assign("zc_zt",$ii->_zc_zt);
            //$this->assign("lx",$ii->_lx);
            $this->assign("zc_bh",$ii->_zc_bh);
            $this->assign("zc_lx",$ii->_zc_lx);
            $this->assign("zc_rjlx",$ii->_zc_rjlx);
            $this->assign("zc_mc",$ii->_zc_mc);
            $this->assign("zc_jldw",$ii->_zc_jldw);
            $this->assign("zc_yz",$ii->_zc_yz);
            $this->assign("zc_dj",$ii->_zc_dj);
            $this->assign("zc_azcb",$ii->_zc_azcb);
            $this->assign("zc_sfzjbz",$ii->_zc_sfzjbz);
            $this->assign("zc_zjnxlx",$ii->_zc_zjnxlx);
            $this->assign("zc_ljzj",$ii->_zc_ljzj);
            $this->assign("zc_gjrq",$ii->_zc_gjrq);
            $this->assign("zc_rzrq",$ii->_zc_rzrq);
            $this->assign("zc_qyrq",$ii->_zc_qyrq);
            $this->assign("zc_qdfs",$ii->_zc_qdfs);
            $this->assign("zc_ccsybm",$ii->_zc_ccsybm);
            $this->assign("zc_sfxz",$ii->_zc_sfxz);
            $this->assign("zc_ccglbm",$ii->_zc_ccglbm);
            $this->assign("zc_txm",$ii->_zc_txm);
            $this->assign("zc_zzr",$ii->_zc_zzr);
            $this->assign("zc_pfdh",$ii->_zc_pfdh);
            $this->assign("zc_kpsm",$ii->_zc_kpsm);
            $this->assign("zc_czrq",$ii->_zc_czrq);
            $this->assign("zc_zcdjr",$ii->_zc_zcdjr);
        }
        $this->theme("manage")->display();
    }
    //通过资产大类选择二级分类
    public function ZclxSelect(){
        $ii=new ZcManageAPI();
        $ii->ZclxSelect();
        /*$this->assign("ZcLxinfo",$ii->_main_data);
        var_export($ii->_main_data);*/
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //通过二级分类读取资产名称
    public function ZcmcSelect(){
        $ii=new ZcManageAPI();
        $ii->ZcmcSelect();
        /*$this->assign("ZcLxinfo",$ii->_main_data);
        var_export($ii->_main_data);*/
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //获取审批数据
    public function GetZcSpInfo(){
        $ii=new ZcxxAPI();
        $ii->SpInfoList();
        $this->ajaxReturn($ii->_main_data,"JSON");
    }
    //生成标签并打印
    public function RfidPrint(){
        $id=I("sbid");
        $ii=new ActionAPI();
        $ii->ChId($id);
        $table=I("sbtb");
        $ii->ChId($table);
        switch ($this->_method){
            case 'get': // get请求处理代码
                $act=new ZcxxAPI();
                $act->InZcinfo($id,$table);
                //$this->response($act->_main_data,'xml',200);
                $this->assign("Info",$act->_main_data);
                $this->theme("manage")->display("print");
           //var_export($act->_main_data);
                break;
            case 'put': // put请求处理代码
                $this->response('','json',400);
                break;
            case 'post': // post请求处理代码
                break;
        }
    }
    //资产导入
    public function ExcelUp(){
        $lx=I("lx");
        if ($lx=="dz"){
            $this->assign("lxname","电子设备");
            $this->assign("lxtable","dzsb_tb");
            $this->assign("link","/Home/ZcManage/DzsbManage?lx=59");
        }elseif ($lx=="dq"){
            $this->assign("lxname","机械器具");
            $this->assign("lxtable","dqsb_tb");
            $this->assign("link","/Home/ZcManage/JxqjManage");
        }elseif ($lx=="qt"){
            $this->assign("lxname","其它财产");
            $this->assign("lxtable","qtzc_tb");
            $this->assign("link","/Home/ZcManage/ExcelUp?lx=ys");
        }elseif ($lx=="ys"){
            $this->assign("lxname","运输工具");
            $this->assign("lxtable","ysgj_tb");
            $this->assign("link","/Home/ZcManage/ExcelUp?lx=qt");
        }
        //echo $lx;
        $this->assign("lx",$lx);
        $this->theme("manage")->display();
    }
    /*暂未使用*/
    public function zcupload(){
        $lxtable=I("lx");
        //echo $lxtable;
        $filepath=C("ExcelPath");
        $dateinfo=date('Ymd',time());
        $filepath=$filepath."@".$dateinfo."@";
        $filepath=str_replace("@","\\",$filepath);
        //echo $filepath;
        $this->ZcInfoUpload();
        $io=new ExcelAPI();
        $filelx=substr(strrchr($filepath.$ii->_Excel, '.'), 1);
        $data=$io->read($filepath.$ii->_Excel,$filelx);
        /*var_export($io->_exceldata);*/
        $AddData=M("zctmp_tb");
        $AddData->where('1')->delete();
        import("Common.Org.PHPExcel.Shared.Date");
        $shared = new \PHPExcel_Shared_Date();
        $d = 25569;
        $t = 24 * 60 * 60;
        foreach ($io->_exceldata as $info){
            $bh=str_replace("[","",$info["4"]);
            $bh=str_replace("]","",$bh);
            $txm=str_replace("[","",$info["29"]);
            $txm=str_replace("]","",$txm);
            $AddData->z1z=$info['0']; //1
            $AddData->z2z=$info['1']; //2
            $AddData->z3z=$info['2']; //3
            $AddData->z4z=$info['3'];; //4
            $AddData->z5z=$bh; //5
            $AddData->z6z=$info['5']; //6
            $AddData->z7z=$info['6']; //7
            $AddData->z8z=0; //8
            $AddData->z9z=$info['8']; //9
            $yz=str_replace("'","",$info['9']);
            $AddData->z10z=$yz; //11
            $dj=str_replace("'","",$info['10']);
            $AddData->z11z=$dj; //12
            $az=str_replace("'","",$info['11']);
            //echo $info['12'];
            $AddData->z12z=$az; //13
            $jz=str_replace("'","",$info['12']);
            $AddData->z13z=$jz; //14
            $AddData->z14z=$info['13']; //15
            $AddData->z15z=$info['14']; //16
            $AddData->z16z=$info['15']; //17
            $AddData->z17z=$info['16']; //18
            $AddData->z18z=$info['17']; //19
            $AddData->z19z=$info['18']; //19
            $gjrq=gmdate('Y-m-d', ($info['19'] - $d) * $t);
            $rzrq=gmdate('Y-m-d', ($info['20'] - $d) * $t);
            $qyrq=gmdate('Y-m-d', ($info['21'] - $d) * $t);
            $AddData->z20z=$gjrq; //19
            /*$datainfo=$shared ->ExcelToPHP($info['21']);*/
            /*$datainfo=strtotime(gmdate('Y-m-d',\PHPExcel_Shared_Date::ExcelToPHP($info['21'])));*/
            $AddData->z21z=$rzrq; //21
            $AddData->z22z=$qyrq; //22
            $AddData->z23z=$info['22']; //23
            $AddData->z24z=$info['23']; //24
            $AddData->z25z=$info['24']; //25
            $AddData->z26z=$info['25']; //26
            $AddData->z27z=$info['26']; //27
            $AddData->z28z=$info['27']; //28
            $AddData->z29z=$txm; //29
            $AddData->z30z=$info['28']; //31
            $AddData->z31z=$info['30']; //32
            $AddData->z32z=$info['31']; //32
            $AddData->z33z=$info['32']; //33
            $AddData->z34z=$info['33']; //34
            $AddData->z35z=$info['34']; //35
            $AddData->z36z=$info['35']; //36
            $AddData->z37z=$info['36']; //36
            if ($bh!=""){
                $ret=$AddData->add();
            }
            if ($ret>0){
                $zc_zt=1;
            }else{
                $zc_zt=0;
            }


        }
        if ($zc_zt==0){
            $this->error("没有任何数据上传，请重试","/Home/ZcManage/ExcelUp",1);
        }else{
            $ii->UpDatabase($lxtable);
            if ($ii->_lx==0){
                if ($lxtable=="dzsb_tb") {
                    $this->error("没有需要新增的数据", "/Home/ZcManage/ExcelUp?lx=dz", 1);
                }elseif ($lxtable=="dqsb_tb"){
                    $this->success("没有需要新增的数据","/Home/ZcManage/ExcelUp?lx=dq",1);
                }elseif ($lxtable=="ysgj_tb"){
                    $this->success("没有需要新增的数据","/Home/ZcManage/ExcelUp?lx=ys",1);
                }elseif ($lxtable=="qtzc_tb"){
                    $this->success("没有需要新增的数据","/Home/ZcManage/ExcelUp?lx=qt",1);
                }
            }else{
                if ($lxtable=="dzsb_tb"){
                    $this->success("电子设备数据导入成功","/Home/ZcManage/DzsbManage?lx=59",1);
                }elseif ($lxtable=="dqsb_tb"){
                    $this->success("机械器具数据导入成功","/Home/ZcManage/JxqjManage",1);
                }elseif ($lxtable=="ysgj_tb"){
                    $this->success("运输工具数据导入成功","/Home/ZcManage/ClxxManage",1);
                }elseif ($lxtable=="qtzc_tb"){
                    $this->success("其它财产数据导入成功","/Home/ZcManage/QtsbManage",1);
                }

            }
        }

    }
}
