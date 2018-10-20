<?php
namespace Home\Controller;
use Home\API\FromAPI;
use Home\API\NewsAPI;
use Home\API\PdfAPI;
use Home\API\UserAPI;
use Home\API\WxchatAPI;
use Think\Controller;

class TestController extends Controller {
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
    }
    function wxlogin(){
        $ii=new WxchatAPI();
        $ii->select_appid();
        $this->assign("appid",$ii->_wxapp_id);
        $this->theme("glxh")->display("");
    }

    function wxloginretrue()
    {
        $sort='Wx';
        $ii = new WxchatAPI();
        $ii->reauest_info($sort);

        //exit($ii->_username);
        switch ($ii->_zt) {
            case 0:
                $this->error('扫描失败，即将重试', '/home/test/wxlogin', 1);
                break;
            case 2:
                //exit("您还没有绑定用户");
                $this->assign("uid",$ii->_uid);
                $this->theme("glxh")->display("");
                break;
            case 100;
                $io = new UserAPI();
                if ($io->WxUserLogin($ii->_username, false)) {
                    $this->success('登录成功', '/', 1);
                }
                break;
            case 1;
                $this->assign("uid",$ii->_uid);
                $this->theme("glxh")->display("");
                break;
        }
        //$this->theme("glxh")->display("");
    }

   
}
