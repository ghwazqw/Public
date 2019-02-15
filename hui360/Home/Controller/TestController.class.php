<?php

namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\FromAPI;
use Home\API\UserAPI;
use Think\Controller;

class TestController extends PublicController
{
    function _initialize()
    {
        /*$ii=new ActionAPI();
        if ($ii->ChAuth()){
            echo "ok";
        }else{
            $this->error("权限不足！");
        }*/
    }

    public function index()
    {

    }

    public function uploadphoto()
    {
        $this->theme("manage")->display();
    }

    public function auth()
    {

    }

    public function PageMon()
    {
        $act = new FromAPI();
        $act->Act_from();
        $this->assign("formname", $act->_CommentName);
        $table_name = I("table");
        $this->assign("TableName", $table_name);
        $list = new FromAPI();
        $list->List_table();
        $this->assign("Table", $list->_TableNmae);

        $input_list = new FromAPI();
        $input_list->list_input();
        $lx = I("lx");

        $this->assign("lx", $lx);
        $this->assign("list_input", $input_list->_List_input_list);
        $this->theme("manage")->display();

    }

    public function listpage()
    {
        $act = new FromAPI();
        $act->Act_from();
        $this->assign("formname", $act->_CommentName);
        $this->assign("TableName", $act->_TableNmae);
        $list = new FromAPI();
        $list->List_table();
        $this->assign("Table", $list->_TableNmae);
        $input_list = new FromAPI();
        $input_list->list_input();
        $act = I("act");
        $this->assign("act", $act);
        $this->assign("list_input", $input_list->_List_input_list);
        $this->theme("manage")->display("jslist");

    }

    public function setup()
    {
        $act = new FromAPI();
        $act->Act_from();
        $this->assign("formname", $act->_CommentName);
        $this->assign("TableName", $act->_TableNmae);
        //var_dump($act->_CommentName);
        $list = new FromAPI();
        $list->List_table();
        $this->assign("Table", $list->_TableNmae);

        $input_list = new FromAPI();
        $input_list->list_input();
        $act = I("act");
        $this->assign("act", $act);
        $this->assign("list_input", $input_list->_List_input_list);
        $this->theme("manage")->display("");

    }

    public function codesetup()
    {
        //诚取表单信息
        $list = new FromAPI();
        $list->List_table();
        $this->assign("Table", $list->_TableNmae);

        if ($_POST) {
            $id = I("id");
            $act = new FromAPI();
            $act->Act_from();
            $ii = new FromAPI();
            //$this->assign("formname",$act->_CommentName);
            //判断该表的配置信息是否存在
            if ($ii->chcodeset($act->_TableNmae)) { //判断不存在的情况则加入新值
                foreach ($act->_CommentName as $info) {
                    $code = $info['column_name'];
                    $showtext = $info['column_comment'];
                    $actsort = 'text';
                    $table = $act->_TableNmae;
                    $write = 1;
                    $sort = 1;
                    if ($ii->codesetup($code, $showtext, $actsort, $write, $sort, '', $table, $id)) {
                        $ii->LoadCodeInfo($act->_TableNmae);
                        $this->assign("InfoData", $ii->_main_data);
                    } else {
                        echo "error";
                    }
                }
            } else { //已存在，则读取数据
                $ii->LoadCodeInfo($act->_TableNmae);
                $this->assign("InfoData", $ii->_main_data);
            }

            $this->assign("TableName", $act->_TableNmae);
            //var_dump(formname);
        }

        $this->theme("manage")->display("");
    }

    public function page()
    {
        $act = new FromAPI();
        $act->Page_from();
        $this->assign("formname", $act->_CommentName);
        $this->assign("TableName", $act->_TableNmae);
        $list = new FromAPI();
        $list->page_table();
        $this->assign("Table", $list->_TableNmae);
        $input_list = new FromAPI();
        $input_list->list_input();
        $this->assign("list_input", $input_list->_List_input_list);
        $this->theme("manage")->display("");

    }

    public function chva()
    {
        echo getcwd();
        $this->theme("manage")->display("");
    }

    /**
     * webuploader 上传文件
     */
    public function ajax_upload()
    {
        // 根据自己的业务调整上传路径、允许的格式、文件大小
        ajax_upload('/Public/Uploads/');
    }

    /**
     * webuploader 上传demo
     */
    public function webuploader()
    {
        // 如果是post提交则显示上传的文件 否则显示上传页面
        if (IS_POST) {
            p($_POST);
            die;
        } else {
            $this->theme("manage")->display("upload");
        }
    }

    public function upload()
    {
        $ii = new UserAPI();
        $ii->GetUserInfo();
        $get_UserName = $ii->_username;
        $config = C('uploadfile'); //读取上传文件配置类
        $upload = new \Think\Upload($config);// 实例化上传类
        //上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            //$this->error($upload->getError());
        } else {// 上传成功
            //$this->success('上传成功！');
            foreach ($info as $file) {
                $zc_photo = $file['savepath'] . $file['savename'];
                $io = new ActionAPI();
                if ($io->UploadImg('/' . $zc_photo, 'AD', $get_UserName)) {
                    echo json_encode(array('code' => 200, 'src' => "/" . $zc_photo, 'Msg' => '上传成功'));
                } else {
                    echo json_encode(array('code' => 500, 'Msg' => '上传失败'));
                }
            }
            //echo $zc_photo;
        }
    }

    public function setname()
    {
        $tablename = I("tablename");
        $name = I("name");
        $setname = I("setname");
        $ii = new ActionAPI();
        $ii->ChId($tablename);
        $ii->ChId($name);
        $Model = D();
        $Model->query("alter table $tablename CHANGE $setname $name varchar(255) COMMENT '名称';");
        echo "ok";
        //echo $tablename."++".$name;
    }

    public function googlogin()
    {
        $this->theme("manage")->display("");
    }

    public function qqlogin()
    {
        $this->theme("manage")->display("");
    }

    public function facebook()
    {
        $this->theme("manage")->display("");
    }

    public function testsendmail()
    {
        if (SendMail('gao0@me.com', '報名郵件測試', "報名內容測試")) {
            echo "ok";
        }else{
            echo "error";
        }
    }
}
