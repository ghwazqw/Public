<?php
namespace Home\Controller;
use Home\API\YwzxAPI;
use Home\API\CgxxAPI;
use Home\API\YwzxManageAPI;
use Think\Controller;
class YwcentController extends Controller {
    public function cgrk(){

        if ($_POST){
            $a= new YwzxAPI();
            $a->AddCgrk();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果入库申请");
        $this->theme("glxh")->display();
    }
    public function cgrk_list(){
        $ii=new YwzxManageAPI();
        $ii->loadcgrkdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果入库详细信息");
        $this->theme("glxh")->display();
    }
    //成果需求信息
    public function  xqsq(){

        //提交数据
        if ($_POST){
            $a= new YwzxAPI();
            $a->AddXqsq();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->assign("date_show",date("Y-m-d"));
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果需求申请");
        $this->theme("glxh")->display();
    }
    public function xqsq_list(){
        $ii=new YwzxManageAPI();
        $ii->loadcgxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        //var_export($ii->_main_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果需求详细信息");
        $this->theme("glxh")->display();
    }
    public function kjsq(){
        $this->theme("glxh")->display();
    }
    public function  kjzx(){

        if ($_POST){
            $a= new YwzxAPI();
            $a->Addkjzx();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|科技咨询信息");
        $this->theme("glxh")->display();
    }
    public function  kjzx_list(){
        $ii=new YwzxManageAPI();
        $ii->loadkjzxdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|科技咨询详细信息");
        $this->theme("glxh")->display();
    }
    public function  kyzx(){


        if ($_POST){
            $a= new YwzxAPI();
            $a->AddKyzx();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|科研咨询需求");
        $this->assign("date_show",date("Y-m-d"));
        $this->theme("glxh")->display();
    }
    public function  kyzx_list(){
        $ii=new YwzxManageAPI();
        $ii->loadkyzxdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|科研咨询需求");
        $this->theme("glxh")->display();
    }
    public function  tzxq(){
        /*$ii=new CgxxAPI();
        $ii->loadclassdata();
        $this->assign("class_data",$ii->_class_data); //主分类数据
        $this->assign("class_mtea_data",$ii->_class_meta_data);*/
        if ($_POST) {
            $a=new YwzxAPI();
            $a->AddTzxq();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }

        $this->theme("glxh")->display();
    }
    public function tzxq_list(){
        $ii=new YwzxManageAPI();
        $ii->loadtzxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|投资需求详细信息");
        $this->theme("glxh")->display();
    }
    public function  djxq(){
        if ($_POST){
            $a= new YwzxAPI();
            $a->add_djxm();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->theme("glxh")->display();
    }
    public function  hyxq(){
        if ($_POST){
            $a= new YwzxAPI();
            $a->AddHyxq();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|会议会展需求");
        $this->assign("date_show",date("Y-m-d"));
        $this->theme("glxh")->display();
    }
    public function hyhz_list(){
        $ii=new YwzxManageAPI();
        $ii->loadhyxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|会议会展");
        $this->theme("glxh")->display();
    }
    public function  rzxq(){
        if ($_POST){
            $a= new YwzxAPI();
            $a->AddRzxq();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|融资需求");
        $this->theme("glxh")->display();
    }
    public function rzxq_list(){
        $ii=new YwzxManageAPI();
        $ii->loadrzxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|融资需求");
        $this->theme("glxh")->display();
    }
    //需求信息列表
    public function xq_list(){
        $this->assign("title","中国公路科技成果转化平台|需求信息列表");
        $a=new YwzxAPI();
        $a->xq_list();
        $this->assign("keyword",$a->_keyword);
        $this->assign("count",$a->_page_count);
        $this->assign("info_data",$a->_main_data);


        $this->theme("glxh")->display();
    }
    //需求详细列表
    public function xq_dal(){
        $this->assign("title","中国公路科技成果转化平台|需求详细信息");
        $a=new YwzxAPI();
        $a->xq_dal();
        $this->assign("info_data",$a->_main1_data);

        $this->theme("glxh")->display();

    }
    //供给信息列表
    public function gj_list(){
        $this->assign("title","中国公路科技成果转化平台|供给信息列表");
        $a=new YwzxAPI();
        $a->gj_list();
        $this->assign("info_data",$a->_main_data);
        $this->assign("keyword",$a->_keyword);
        $this->assign("count",$a->_page_count);


        $this->theme("glxh")->display();
    }
    //供给详细信息
    public function gj_dal(){
        $this->assign("title","中国公路科技成果转化平台|供给详细信息");
        $a=new YwzxAPI();
        $a->gj_dal();
        $this->assign("info_data",$a->_main1_data);
        $this->theme("glxh")->display();

    }
    public function zjrk(){
        if ($_POST){
            $a= new YwzxAPI();
            $a->AddZjxx();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|专家入库需求");

        $this->theme("glxh")->display();
    }
    public function  gjxq(){
        $this->assign("title","中国公路科技成果转化平台|供给需求填写");
        if ($_POST){
            $a= new YwzxAPI();
            $a->add_djxm();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }

        $this->theme("glxh")->display();
    }
    public function gjxq_list(){
        $ii=new YwzxManageAPI();
        $ii->loadgjxqdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|供给需求详细信息");
        $this->theme("glxh")->display();
    }
    public function cgpg(){
        if ($_POST){
            $a= new YwzxAPI();
            $a->AddCgpg();
            if($a->actionInfo!=""){
                redirect('/home/ywcent/success', 1, '正在提交，请稍候...');
            }
        }
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果评估需求");
        $this->theme("glxh")->display();
    }
    public function cgpg_list(){
        $ii=new YwzxManageAPI();
        $ii->loadcgpgdaldata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果评估信息详细");
        $this->theme("glxh")->display();
    }
    public function zjrk_list(){
        $ii=new YwzxManageAPI();
        $ii->loadzjxxinfo();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("HfData",$ii->_dateil_data);
        $this->assign("title","中国公路科技成果转化平台|用户中心|专家信息详细");
        $this->theme("glxh")->display();
    }
    public function success(){
        $this->theme("glxh")->display();
    }

}
