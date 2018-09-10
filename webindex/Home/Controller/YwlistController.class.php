<?php
namespace Home\Controller;
use Home\API\UserAPI;
use Home\API\YwzxManageAPI;
use Home\API\YwzxQManageAPI;  //
use Think\Controller;
use Home\API\CgxxAPI;
class YwlistController extends Controller {


    public function cgrk_manage(){
        $ii=new YwzxQManageAPI();
        $ii->loadmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果入库信息");
        $this->theme("glxh")->display();
    }
    public function xqsq_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadxqsqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|成果需求信息");
        $this->theme("glxh")->display();
    }
    public function gjxq_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadgjxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|供需对接信息");
        $this->theme("glxh")->display();
    }
    public function hyxq_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadhyxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|会议会展需求信息");
        $this->theme("glxh")->display();
    }
    //科技咨询
    public function kjzx_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadkjzxdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|技术咨询信息");
        $this->theme("glxh")->display();
    }
    //成果评估
    public function cgpg_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadcgpgdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("glxh")->display();
    }
    //科研咨询
    public function kyzx_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadkyzxdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|科研咨询信息");
        $this->theme("glxh")->display();
    }
    //创业融资
    public function rzxq_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadrzxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|创业融资信息");
        $this->theme("glxh")->display();
    }
    //创业融资
    public function rzlist_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadrzxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|创业融资信息");
        $this->theme("glxh")->display();
    }
    //投资意向
    public function tzxq_manage(){

        $ii=new YwzxQManageAPI();
        $ii->loadtzxqdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|投资意向信息");
        $this->theme("glxh")->display();
    }
    public function uttest(){

        $this->theme("glxh")->display();
    }
    public function zjrk_manage(){
        $ii=new YwzxQManageAPI();
        $ii->loadzjxxdata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("title","中国公路科技成果转化平台|用户中心|专家入库信息");
        $this->theme("glxh")->display();
    }
   
}
