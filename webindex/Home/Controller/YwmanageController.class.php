<?php
namespace Home\Controller;
use Home\API\YwzxAPI;
use Home\API\CgxxAPI;
use Home\API\YwzxManageAPI;
use Think\Controller;
class YwmanageController extends Controller {
    public function cgrk(){
        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadcgrkdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->theme("50")->display();
    }
    //成果需求信息
    public function  xqsq(){

        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadcgxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果需求");
        $this->theme("50")->display();
    }

    public function kjsq(){
        $this->theme("50")->display();
    }
    public function  kjzx(){

        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadkjzxdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->theme("50")->display();

    }
    public function  kyzx(){


        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadkyzxdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->theme("50")->display();
    }
    public function  tzxq(){
        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadtzxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->theme("50")->display();
    }
    public function  djxq(){
        if ($_POST){
            $a= new YwzxAPI();
            $a->add_djxm();
            if($a->actionInfo!=""){
                eval($a->actionInfo);
            }
        }
        $this->theme("50")->display();
    }
    public function  hyxq(){
        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadhyxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->theme("50")->display();
    }
    public function  rzxq(){
        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadrzxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->theme("50")->display();
    }
    //需求信息列表
    public function xq_list(){
        $this->assign("title","中国公路科技成果转化平台|需求信息列表");
        $a=new YwzxAPI();
        $a->xq_list();
        $this->assign("keyword",$a->_keyword);
        $this->assign("count",$a->_page_count);
        $this->assign("info_data",$a->_main_data);


        $this->theme("50")->display();
    }
    //需求详细列表
    public function xq_dal(){
        $this->assign("title","中国公路科技成果转化平台|需求详细信息");
        $a=new YwzxAPI();
        $a->xq_dal();
        $this->assign("info_data",$a->_main1_data);

        $this->theme("50")->display();

    }
    //供给信息列表
    public function gj_list(){
        $this->assign("title","中国公路科技成果转化平台|供给信息列表");
        $a=new YwzxAPI();
        $a->gj_list();
        $this->assign("info_data",$a->_main_data);
        $this->assign("keyword",$a->_keyword);
        $this->assign("count",$a->_page_count);


        $this->theme("50")->display();
    }
    //供给详细信息
    public function gj_dal(){
        $this->assign("title","中国公路科技成果转化平台|供给详细信息");
        $a=new YwzxAPI();
        $a->gj_dal();
        $this->assign("info_data",$a->_main1_data);
        $this->theme("50")->display();

    }
    public function zjrk(){
        if ($_POST){
            $a= new YwzxAPI();
            $a->add_djxm();
            if($a->actionInfo!=""){
                eval($a->actionInfo);
            }
        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|融资需求");

        $this->theme("50")->display();
    }
    public function  gjxq(){
        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadgjxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->theme("50")->display();

    }
    public function  gjxq_edit(){
        if ($_POST){
            $ii=new YwzxAPI();
            $ii->edit_djxm();
            if($ii->actionInfo!=""){
                $this->success('首页推荐成功，正在跳转','/home/manage/gjxq_manage',1);
            }
        }else{
            $ii=new YwzxManageAPI();
            $ii->loadgjxqdaldata();
            $this->assign("InfoData",$ii->_main_data);
            $this->assign("HfData",$ii->_dateil_data);
            $this->theme("50")->display();
        }


    }
    public function  gjxq_sub()
    {
        $ii = new YwzxAPI();
        $ii->edit_djxm();

            $this->success('首页推荐成功，正在跳转', '/home/manage/gjxq_manage', 1);
    }

    public function cgpg(){
        if ($_POST){
            $ii=new YwzxManageAPI();
            $ii->loadhfxxdata();
            if($ii->actionInfo!=""){
                eval($ii->actionInfo);
            }
        }
        $ii=new YwzxManageAPI();
        $ii->loadcgpgdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->theme("50")->display();
    }
}
