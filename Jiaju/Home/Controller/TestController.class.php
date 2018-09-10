<?php
namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\FromAPI;
use Think\Controller;

class TestController extends PublicController {
    function _initialize() {
        /*$ii=new ActionAPI();
        if ($ii->ChAuth()){
            echo "ok";
        }else{
            $this->error("权限不足！");
        }*/
    }
    public function index(){

    }
    public function uploadphoto(){
        $this->theme("manage")->display();
    }
    public function auth(){

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

    public function chva(){
        echo getcwd();
        $this->theme("manage")->display("");
    }
    /**
     * webuploader 上传文件
     */
    public function ajax_upload(){
        // 根据自己的业务调整上传路径、允许的格式、文件大小
        ajax_upload('/Public/Uploads/');
    }
    /**
     * webuploader 上传demo
     */
    public function webuploader(){
        // 如果是post提交则显示上传的文件 否则显示上传页面
        if(IS_POST){
            p($_POST);die;
        }else{
            $this->theme("manage")->display("upload");
        }
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
    }
}
