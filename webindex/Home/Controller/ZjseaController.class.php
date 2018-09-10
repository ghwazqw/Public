<?php
namespace Home\Controller;
use Think\Controller;
use Home\API\ZjxxAPI;
class ZjseaController extends Controller {
    public function search(){
        $ii=new ZjxxAPI();
        $ii->zjSearch();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("count",$ii->_page_count);
        $this->assign("zj_type",$this->_lx);
        //echo $ii->_keyword["zj_type"];
        $this->assign("title","中国公路科技成果转化平台|专家信息");
        $this->theme("glxh")->display("zjxx_list_1");


    }
    public function searchq(){
        $ii=new ZjxxAPI();
        $ii->loadmatedata();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("page_size",$ii->_page_size);
        $this->assign("count",$ii->_page_count);
        $this->assign("keyword",$ii->_keyword);
        $this->assign("type",$ii->_type);
        $this->assign("title","中国公路科技成果转化平台|专家信息");
        $this->theme("glxh")->display();



    }
    public function zj_dal(){
        $ii=new ZjxxAPI();
        $ii->loaddaldata();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("cg_data",$ii->_meta_data);
        $this->assign("type",$ii->_type);
        $this->assign("title","中国公路科技成果转化平台|专家信息");

        $this->theme("glxh")->display();
    }
    public function zjq_dal(){
        $ii=new ZjxxAPI();
        $ii->loaddaldata();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("cg_data",$ii->_meta_data);
        $this->assign("type",$ii->_type);
        $this->assign("title","中国公路科技成果转化平台|专家信息");
        $this->theme("glxh")->display();
    }
    public function index(){
        $ii=new ZjxxAPI();
        $ii->zjwcrdata();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("count",$ii->_page_count);
        $this->assign("keyword",$ii->_keyword[""]);
        $this->assign("cg_wcrxm",$ii->_keyword["cg_wcrxm"]);
        $this->assign("cg_wcrxb",$ii->_keyword["cg_wcrxb"]);
        $this->assign("cg_wcrcsny",$ii->_keyword["cg_wcrcsny"]);
        $this->assign("cg_wcrjg",$ii->_keyword["cg_wcrjg"]);
        $this->assign("cg_wcrmz",$ii->_keyword["cg_wcrmz"]);
        $this->assign("cg_wcrsfzh",$ii->_keyword["cg_wcrsfzh"]);
        $this->assign("cg_wcrdp",$ii->_keyword["cg_wcrdp"]);
        $this->assign("cg_wcrxzzw",$ii->_keyword["cg_wcrxzzw"]);
        $this->assign("cg_wcrzyzc",$ii->_keyword["cg_wcrzyzc"]);
        $this->assign("cg_wcrzgxl",$ii->_keyword["cg_wcrzgxl"]);
        $this->assign("cg_wcryddh",$ii->_keyword["cg_wcryddh"]);
        $this->assign("lx",$ii->_lx);
        $this->assign("zj_type",$ii->_keyword["zj_type"]);
        $this->assign("title","中国公路科技成果转化平台|专家信息");
        $this->theme("glxh")->display();
    }
    public function zjxx_list(){
        $ii=new ZjxxAPI();
        $ii->zjxx_list();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("page_size",$ii->_page_size);
        $this->assign("count",$ii->_page_count);
        $this->assign("keyword",$ii->_keyword);
        $this->assign("title","中国公路科技成果转化平台|专家信息");
        $this->theme("glxh")->display();
    }
    public  function  zjxx_list_1(){
        $ii=new ZjxxAPI();
        $ii->zjxx_list();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("page_size",$ii->_page_size);
        $this->assign("count",$ii->_page_count);
        $this->assign("keyword",$ii->_keyword);
        $this->assign("title","中国公路科技成果转化平台|专家信息");
        $this->theme("glxh")->display();
    }

   
}
