<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */

namespace Home\Controller;




use Home\API\ActivitiesAPI;
use Home\API\CourseAPI;

class CourseController extends PublicController
{

    public function _initialize()
    {
        parent::_initialize();
        //parent::_IsAuth();
    }

    public function index(){
        $this->assign("title","課程信息管理");
        $this->theme("WebApps")->display();
    }
    public function CourseManage(){
        $this->theme("WebApps")->display();
    }
    //資費郵件發送
    public function SendJfAPI(){
        $email=I("email");
        $id=I("id");
        if (!$email || !$id){
            $this->error('id error');
        }else{
            $ii=new ActivitiesAPI();
            if ($ii->SendJfInfo($email,$id)){
                $this->success("交費通知郵件發送成功!");
            }else{
                $this->error("交費通知郵件發送失敗!");
            }
        }
    }
    //提醒郵件發送
    public function SendTfAPI(){
        $email=I("email");
        $id=I("id");
        if (!$email || !$id){
            $this->error('id error');
        }else{
            $ii=new ActivitiesAPI();
            if ($ii->SendTfInfo($email,$id)){
                $this->success("提醒郵件發送成功!");
            }else{
                $this->error("提醒郵件發送失敗!");
            }
        }
    }


}