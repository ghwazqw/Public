<?php
namespace Home\Controller;
use Home\API\ExcelAPI;
use Home\API\FromAPI;
use Home\API\PdfAPI;
use Home\API\PinyinAPI;
use Home\API\ResAPI;
use Home\API\ZcManageAPI;
use Think\Controller;
class TestController extends Controller {
    public function index(){
        $act=new FromAPI();
        $act->Act_from();
        $this->assign("formname",$act->_CommentName);
        $list=new FromAPI();
        $list->List_table();
        $this->assign("Table",$list->_TableNmae);
        $input_list=new FromAPI();
        $input_list->list_input();
        $this->assign("list_input",$input_list->_List_input_list);
        $this->theme("manage")->display();

    }
    public function PageMon(){
        $act=new FromAPI();
        $act->Act_from();
        $this->assign("formname",$act->_CommentName);
        $table_name=I("table");
        $this->assign("TableName",$table_name);
        $list=new FromAPI();
        $list->List_table();
        $this->assign("Table",$list->_TableNmae);

        $input_list=new FromAPI();
        $input_list->list_input();
        $lx=I("lx");
        $this->assign("lx",$lx);
        $this->assign("list_input",$input_list->_List_input_list);
        $this->theme("manage")->display();

    }
    public function listpage(){
        $act=new FromAPI();
        $act->Act_from();
        $this->assign("formname",$act->_CommentName);
        $this->assign("TableName",$act->_TableNmae);
        $list=new FromAPI();
        $list->List_table();
        $this->assign("Table",$list->_TableNmae);
        $input_list=new FromAPI();
        $input_list->list_input();
        $this->assign("list_input",$input_list->_List_input_list);
        $this->theme("manage")->display("list");

    }
    public function page(){
        $act=new FromAPI();
        $act->Page_from();
        $this->assign("formname",$act->_CommentName);
        $this->assign("TableName",$act->_TableNmae);
        $list=new FromAPI();
        $list->page_table();
        $this->assign("Table",$list->_TableNmae);
        $input_list=new FromAPI();
        $input_list->list_input();
        $this->assign("list_input",$input_list->_List_input_list);
        $this->theme("manage")->display("");

    }
    public function pdftest(){
        $ii=new PdfAPI();
        $ii->expPDF();
        $this->theme("manage")->display();
    }
    public function uploadphoto(){
        $this->theme("manage")->display();
    }
    public function upload(){
        $config = C('uploadfile'); //读取上传文件配置类
        $upload = new \Think\Upload($config);// 实例化上传类
        //上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            //$this->error($upload->getError());
        }else{// 上传成功
            //$this->success('上传成功！');
            foreach ($info as $file) {
                //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                $zc_photo=$file['savepath'] . $file['savename'];
            }
            echo json_encode(array('code' => 200, 'src' => "/".$zc_photo));
        }
        /*$file = $_FILES["file"]; // file是上传按钮名
        if(!isset($file['tmp_name']) || !$file['tmp_name']) {
            echo json_encode(array('code' => 401, 'msg' => '没有文件上传'));
            return false;
        }
        if($file["error"] > 0) {
            echo json_encode(array('code' => 402, 'msg' => $file["error"]));
            return false;
        }

        $upload_path = $_SERVER['DOCUMENT_ROOT']."/Public/Uploads/";
        $file_path   = 'http://' . $_SERVER['HTTP_HOST']."/Public/Uploads/";

        if(!is_dir($upload_path)){
            echo json_encode(array('code' => 403, 'msg' => '上传目录不存在'));
            return false;
        }

        if(move_uploaded_file($file["tmp_name"], $upload_path.$file['name'])){
            echo json_encode(array('code' => 200, 'src' => $file_path.$file['name']));
            return false;
        }else{
            echo json_encode(array('code' => 404, 'msg' => '上传失败'));
            return false;
        }*/
    }
    public function pintest(){
        $pinyin = new PinyinAPI();
        echo $pinyin->getFirstChar("湖北武汉")."<br/>";
        echo $pinyin->getPinyin("北上广")."<br/>";
        echo $pinyin->getPinyin("火影")."<br/>";
        echo $pinyin->getFirstChar("获得")."<br/>";
        echo $pinyin->getFirstChar("TOM")."<br/>";
    }
    public function jsprint(){
        $this->theme("manage")->display("print");
    }
    public function ExcelUp(){
        $this->theme("manage")->display();
    }
    public function zcupload(){
        //echo "正在上传中，请稍候";
        $lxtable=I("lx");
        $filepath=C("ExcelPath");
        $dateinfo=date('Ymd',time());
        $filepath=$filepath."@".$dateinfo."@";
        $filepath=str_replace("@","\\",$filepath);
        //echo $filepath;
        $ii=new ZcManageAPI();
        $ii->ZcInfoUpload();
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
            if ($lxtable=="ysgj_tb"){
                $txm=str_replace("[","",$info["28"]);
                $txm=str_replace("]","",$txm);
            }else{
                $txm=str_replace("[","",$info["28"]);
                $txm=str_replace("]","",$txm);
            }

            $AddData->z1z=$info['0']; //1
            $AddData->z2z=$info['1']; //2
            $AddData->z3z=$info['2']; //3
            $AddData->z4z=$info['3'];; //4
            $AddData->z5z=$bh; //5
            $AddData->z6z=$info['5']; //6
            $AddData->z7z=$info['6']; //7
            //$AddData->z8z=0; //8
            $AddData->z9z=$info['7']; //9
            $yz=str_replace("'","",$info['8']);
            $yz=str_replace(",","",$yz);
            $AddData->z10z=$yz; //11
            $dj=str_replace("'","",$info['9']);
            $dj=str_replace(",","",$dj);
            $AddData->z11z=$dj; //12
            $az=str_replace("'","",$info['10']);
            $az=str_replace(",","",$az);
            //echo $info['12'];
            $AddData->z12z=$az; //13
            $jz=str_replace("'","",$info['11']);
            $jz=str_replace(",","",$jz);
            $AddData->z13z=$jz; //14
            $AddData->z14z=$info['12']; //15
            $AddData->z15z=$info['13']; //16
            $AddData->z16z=$info['14']; //17
            $AddData->z17z=$info['15']; //18
            $AddData->z18z=$info['16']; //19
            $AddData->z19z=$info['17']; //19
            $gjrq=gmdate('Y-m-d', ($info['18'] - $d) * $t);
            $rzrq=gmdate('Y-m-d', ($info['19'] - $d) * $t);
            $qyrq=gmdate('Y-m-d', ($info['20'] - $d) * $t);
            $AddData->z20z=$gjrq; //19
            /*$datainfo=$shared ->ExcelToPHP($info['21']);*/
            /*$datainfo=strtotime(gmdate('Y-m-d',\PHPExcel_Shared_Date::ExcelToPHP($info['21'])));*/
            $AddData->z21z=$rzrq; //21
            $AddData->z22z=$qyrq; //22
            $AddData->z23z=$info['21']; //23
            $AddData->z24z=$info['22']; //24
            $AddData->z25z=$info['23']; //25
            $AddData->z26z=$info['24']; //26
            $AddData->z27z=$info['25']; //27
            $AddData->z28z=$info['26']; //28
            $AddData->z29z=$txm; //29
            if ($lxtable=="ysgj_tb"){
                $AddData->z30z=$info['27']; //31
            }else{
                $AddData->z30z=$info['27']; //31
            }
            $AddData->z31z=$info['29']; //32
            $AddData->z32z=$info['30']; //32
            $AddData->z33z=$info['31']; //33
            $AddData->z34z=$info['32']; //34
            $AddData->z35z=$info['33']; //35
            $AddData->z36z=$info['34']; //36
            $AddData->z37z=$info['35']; //36
            $AddData->z38z=$info['36']; //36
            $AddData->z39z=$info['37']; //36
            $AddData->z40z=$info['38']; //36
            $AddData->z41z=$info['39']; //36
            $AddData->z42z=$info['40']; //36
            $AddData->z43z=$info['41']; //36
            $AddData->z44z=$info['42']; //36
            $AddData->z45z=$info['43']; //36
            $AddData->z46z=$info['44']; //36
            $AddData->z47z=$info['45']; //36
            $AddData->z48z=$info['46']; //36
            $AddData->z49z=$info['47']; //36
            $AddData->z50z=$info['48']; //36

            if ($bh!=""){
                $AddData->add();
            }

        }
        $impret=$AddData->order("id desc")->select();
        //var_dump(array_diff_assoc($impret, $zcinfo));
        //var_dump(array_intersect($impret,$zcinfo));
        $table=M($lxtable);
        /*if ($lxtable=="ysgj_tb"){
            echo "运输工具";
            exit();
        }*/
        foreach ($impret as $imp){
            $bh=$imp['z5z'];
            if ($bh!=""){
                $where["zc_bh"]=array('eq',$bh);
                $count=$table->where($where)->count();
                if ($count==0){
                    $table->zc_jgdm=$imp['z1z'];
                    $table->zc_jgmc=$imp['z2z'];
                    $table->zc_jgxzjb=$imp['z3z'];
                    $table->zc_jgxzjbxx=$imp['z4z'];
                    $table->zc_bh=$imp['z5z'];
                    $table->zc_rjlx=$imp['z7z'];
                    $rjlx=$imp['z7z'];
                    $rjwhere["cglx_mc"]=array("eq",$rjlx);
                    $rxlxid=M("zclx_tb")->where($rjwhere)->getField("");
                    $table->zc_rjlxid=$rxlxid;
                    $table->zc_mc=$imp['z6z'];
                    $table->zc_jldw=$imp['z9z'];
                    $table->zc_yz=$imp['z10z'];
                    $table->zc_dj=$imp['z11z'];
                    $table->zc_azcb=$imp['z12z'];
                    $table->zc_jz=$imp['z13z'];
                    $table->zc_sfzjbz=$imp['z14z'];
                    $table->zc_zjnxlx=$imp['z17z'];
                    $table->zc_ljzj=$imp['z16z'];
                    $table->zc_bqzj=$imp['z15z'];
                    /*$table->zc_nzjl=$imp['z19z'];*/
                    $table->zc_gjrq=$imp['z20z'];
                    $table->zc_rzrq=$imp['z21z'];
                    $table->zc_qyrq=$imp['z22z'];
                    $table->zc_qdfs=$imp['z23z'];
                    $table->zc_ccsybm=$imp['z27z'];
                    $table->zc_sfxz=$imp['z25z'];
                    $table->zc_ccglbm=$imp['z26z'];
                    $table->zc_txm=$imp['z29z'];
                    $table->zc_zrr=$imp['z28z'];
                    /*$table->zc_pfdh=$imp['z1z'];
                    $table->zc_kpsm=$imp['z1z'];
                    $table->zc_czrq=$imp['z1z'];
                    $table->zc_czlx=$imp['z1z'];
                    $table->zc_czyy=$imp['z1z'];*/
                    $table->zc_zcdjr=$imp['z30z'];

                    if ($imp['z33z']!=""){
                        $table->zc_scrq=$imp['z33z'];
                    }
                    $table->zc_sccj=$imp['z34z'];
                    $table->zc_cccpbh=$imp['z35z'];
                    $table->zc_kpsm=$imp['z36z'];
                    if ($lxtable=="ysgj_tb"){
                        //echo "运输工具";
                        $table->zc_pp=$imp['z31z'];
                        $table->zc_xh=$imp['z32z'];
                        $table->zc_gzcpp=$imp['z31z'];
                        $table->zc_gzcxh=$imp['z32z'];
                        /*$table->zc_jzzl=$imp['z37z'];
                        $table->zc_dppp=$imp['z37z'];
                        $table->zc_dpxh=$imp['z37z'];*/
                        $table->zc_clpzh=$imp['z39z'];
                        $table->zc_clzs=$imp['z40z'];
                        $table->zc_fdxbh=$imp['z41z'];
                        $table->zc_cjh=$imp['z42z'];
                        $table->zc_csys=$imp['z43z'];
                        $table->zc_pql=$imp['z44z'];
                        $table->zc_ljxsgl=$imp['z45z'];
                        $table->zc_dw=$imp['z46z'];
                    }else{
                        $table->zc_yt=$imp['z37z'];
                        $table->zc_pp=$imp['z31z'];
                        $table->zc_xh=$imp['z32z'];
                    }

                    $table->zc_zt=1;
                    $ret=$table->add();
                }
            }
        }
            if ($ret==0){
                if ($lxtable=="dzsb_tb") {
                    $this->assign("link","/Home/ZcManage/DzsbManage?lx=59");
                    $this->error("没有需要新增的数据", "/Home/ZcManage/ExcelUp?lx=dz", 1);
                }elseif ($lxtable=="dqsb_tb"){
                    $this->assign("link","/Home/ZcManage/JxqjManage");
                    $this->error("没有需要新增的数据","/Home/ZcManage/ExcelUp?lx=dq",1);
                }elseif ($lxtable=="ysgj_tb"){
                    $this->assign("link","/Home/ZcManage/ClxxManage");
                    $this->error("没有需要新增的数据","/Home/ZcManage/ExcelUp?lx=ys",1);
                }elseif ($lxtable=="qtzc_tb"){
                    $this->assign("link","/Home/ZcManage/QtsbManage");
                    $this->error("没有需要新增的数据","/Home/ZcManage/ExcelUp?lx=qt",1);
                }
            }else{
                //echo $lxtable;
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
