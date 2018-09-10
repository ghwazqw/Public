<?php
namespace Home\Controller;
use Home\API\PdManageAPI;
use Home\API\UserAPI;
use Think\Controller;
class PdManageController extends Controller {
    //读取信息
    function index(){
        //读取部门信息
        $ic=new UserAPI();
        $ic->loadcompdata();
        $this->assign("CompInfo",$ic->_class_data);
        //var_export($ic->_class_data);
        $io=new PdManageAPI();
        $io->DzsbList(); //电子设备
        $this->assign("DzsbInfo",$io->_main_data);
        $this->assign("Dzpage",$io->_page_bar);
        $this->assign("Dz_count",$io->_page_count) ;
        $this->assign("keyword",$io->_keyword) ;
        $this->assign("comp",$io->_comp) ;
        $io->DqsbList();  //机械器具
        $this->assign("DqsbInfo",$io->_Dqsbinfo);
        $this->assign("Dq_count",$io->_page_count) ;
        $this->assign("Dqpage",$io->_page_bar);
        $io->QtsbList(); //其他设备
        $this->assign("QtsbInfo",$io->_Qtsbinfo);
        $this->assign("Qt_count",$io->_page_count) ;
        $this->assign("Qtpage",$io->_page_bar);
        $io->YsgjList(); //运输工具
        $this->assign("YssbInfo",$io->_Ysgjinfo);
        $this->assign("Ys_count",$io->_page_count) ;
        $this->assign("Yspage",$io->_page_bar);
        //var_export($io->_Ysgjinfo);
            //var_export($io->_Ysgjinfo);
            $this->theme("manage")->display();
    }
    /*写入盘点计划*/
    function AddPdjhInfo(){
        if ($_POST){
            $ii=new PdManageAPI();
            $ii->AddPdjhInfo();
            if ($ii->_pass=="ok"){
                $this->success('盘点计划制作成功，正在跳转','/home/PdManage',1);
            }else{
                $this->error('盘点计划制作失败','/home/PdManage',1);
            }
        }
    }
    //显示盘点计划信息
    function PdjhDown(){
        $ii=new PdManageAPI();
        $ii->loadPdjhdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //JSON格式返回盘点计划并生成文件
    function JsonDownload(){
        $ii=new PdManageAPI();
        $ii->PdxxJson();
        $arr=array( array(
            'stId'=>$ii->_stId,
            'stTime'=>$ii->_stTime,
            'handingUser'=>$ii->_handingUser,
            'stNO'=>$ii->_stId,
            'depName'=>$ii->_depName,
            'StockTakeDetail'=>$ii->_dateil_data,

        ));
        //$E=$this->ajaxReturn($arr,'JSON');
        $json_string=json_encode($arr,JSON_UNESCAPED_UNICODE);

        $filename=C('JsonFilePath');
        //$filename = 'c:\stock.json';
        if (is_writable($filename)) {
            file_put_contents($filename, $json_string);
        } else {
            echo "文件 $filename 不可写";
        }
    }
    //Json文件下载
    function download()
    {
        $file_name=C('JsonFilePath');
        $file_name=iconv("utf-8","gb2312",$file_name);
        //$file_sub_path=$_SERVER['DOCUMENT_ROOT']."cardmanage/Public/downfile/";
        $file_path=$file_name;
        $fp=fopen($file_path,"r");
        $file_size=filesize($file_path);
        //下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=stock.json");
        $buffer=1024;
        $file_count=0;
        while(!feof($fp) && $file_count<$file_size){
            $file_con=fread($fp,$buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        fclose($fp);
        exit();
    }
    public function PdjgUp(){
        $this->theme("manage")->display();
    }
    public function JsonUp(){
        $ii=new PdManageAPI();
        $ii->JsonUpload();
        if ($ii->_zt>1){
            $this->success('盘点数据上传成功，将转入结果修正','/home/Pdjgedit',1);
        }else{
            $this->error('盘点数据上传失败，数据为空或者发生错误，请检查您的Json文件是否正确。','/home/PdManage',1);
        }
    }
    public function Pdjgedit(){
        $ii=new PdManageAPI();
        $ii->loadPdjgdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        if ($_POST){
            $ii->EditPdjg();
            if ($ii->_zt>0){
                echo "盘点结果编辑成功。";
            }else{
                echo "盘点结果编辑失败，请重试";
            }
        }else{
            $this->theme("manage")->display();
        }

    }
}
