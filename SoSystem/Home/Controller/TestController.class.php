<?php
namespace Home\Controller;
use Home\API\FromAPI;
use Home\API\NewsAPI;
use Home\API\PdfAPI;
use Home\API\UserAPI;
use Home\API\WxchatAPI;
use Think\Controller;

class TestController extends PublicController {
    public function test(){
        $ii=new NewsAPI();
        $ii->NewsLx(1);
        $this->assign("lxinfo",$ii->_main_data);
        $this->theme("manage")->display();
    }
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
    public function datatable(){
        $ii=new NewsAPI();
        $ii->NewsLx(1);
        $this->assign("Info",$ii->_main_data);
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
            //echo $zc_photo;
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
    function wxlogin(){
        $ii=new WxchatAPI();
        $ii->select_appid();
        $this->assign("appid",$ii->_wxapp_id);
        $this->theme("glxh")->display("");
    }
    function wxloginretrue(){
        $ii=new WxchatAPI();
        $ii->reauest_info();
        if ($ii->_zt==0){
            $this->error('扫描失败，即将重试','/home/test/wxlogin',1);
        }
        //$this->theme("glxh")->display("");

    }
    function datacad(){
        $ii=new UserAPI();
        $ii->LoadQuserGInfo(0,2);
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("maxjb",$ii->_xmbh);
        $this->theme("manage")->display("");
    }
    function datacadf(){
        $ii=new UserAPI();
        $ii->LoadQuserGInfo(0,2);
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("maxjb",$ii->_xmbh);
        $this->theme("manage")->display("");
    }
    function datainfo(){
        $ii=new UserAPI();
        $ii->LoadQuserinfo(2);
        echo $ii->_xjname;
    }
    function datafinfo(){
        $ii=new UserAPI();
        $ii->LoadfQuserinfo();
        echo $ii->_xjname;
    }
    function datacount(){
        $ii=new UserAPI();
        $ii->LoadQuserinfo();
        echo $ii->_page_count;
    }
    function printcode(){

        $this->theme("manage")->display("");
    }
    //系统cookie加解密方法
    function cookie_test(){
        $key=C("ENCRYPT_COOKIE_KEY");
        $str="123456";
        $unstr="MDAwMDAwMDAwMH61equze7iV";
        echo think_encrypt($str,$key); //加密字符串
        echo think_decrypt($unstr,$key); //解密字符串
    }
    //递归查询方法测试
    function dg_test(){
        $Qusertable=M("qx_user_tb");
        $userwhere["_string"]="FIND_IN_SET(id,getParLst(1198))";
        $ret=$Qusertable->where($userwhere)->order("id DESC")->limit(20)->select();
        echo $Qusertable->_sql();
    }
}
