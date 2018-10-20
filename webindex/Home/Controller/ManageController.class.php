<?php
namespace Home\Controller;
use Home\API\HdxxAPI;
use Home\API\UserAPI;
use Home\API\UserLogAPI;
use Home\API\YwzxManageAPI;
use Think\Controller;
use Home\API\CgxxAPI;
class ManageController extends Controller {
    public function index(){

        $this->theme("50")->display();
        
        
    }
    //前端用户管理
    public function QUser_Manage(){
        if ($_GET){
            $io=new UserAPI();
            $io->ActUser();

        }
        $ii=new UserAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    //后端用户管理
    public function User_Manage(){
        if ($_GET){
            $io=new UserAPI();
            $io->ActUser();

        }
        $ii=new UserAPI();
        $ii->loaddata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    public function cgrk_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    public function xqsq_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadxqsqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    public function gjxq_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadgjxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    public function hyxq_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadhyxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    //科技咨询
    public function kjzx_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadkjzxdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    //成果评估
    public function cgpg_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadcgpgdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    //科研咨询
    public function kyzx_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadkyzxdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    //创业融资
    public function rzxq_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadrzxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    //创业融资
    public function rzlist_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadrzxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    //投资意向
    public function tzxq_manage(){

        $ii=new YwzxManageAPI();
        $ii->loadtzxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    //专家入库
    public function zjrk_manage(){
        $ii=new YwzxManageAPI();
        $ii->loadzjrkdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    public function uttest(){

        $this->theme("50")->display();


    }
    public function hyxx_manage(){
        $ii=new HdxxAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    public function addhyxx(){
        if ($_POST){
            $aa=new HdxxAPI();
            $aa->AddHdxx();
            if ($aa->actionInfo!="")
            {
                eval($aa->actionInfo);
            }
        }
        $this->theme("50")->display();
    }
    public function bmxx_manage(){
        $a=new HdxxAPI();
        $a->loadmanagebmdata();
        $this->assign("hy_id",I("hy_id"));
        $this->assign("Bmxx",$a->_bm_info);
        $this->theme("50")->display();
    }
    public function bmchr_manage(){
        $a=new HdxxAPI();
        $a->loadmanagechrdata();
        $this->assign("Hdxx",$a->_dateil_data);
        $this->assign("Userdata",$a->_user_info);
        $this->assign("count",$a->_page_count);
        $this->assign("Bmxx",$a->_bm_info);
        $this->assign("Chrxx",$a->_chr_info);

        $this->theme("50")->display("bmchrxx_manage");
    }
    public function HuserLog_manage(){
        $ii=new UserLogAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display("");
    }
    public function ExprzInfo(){
        $ii=new YwzxManageAPI();
        $ii->expRZExcel();

    }
   
}
