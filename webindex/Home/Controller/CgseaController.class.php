<?php
namespace Home\Controller;
use Think\Controller;
use Home\API\CgxxAPI;
class CgseaController extends Controller {
    public function search(){
        $io=new CgxxAPI();
        $io->loadmatedata();
        $this->assign("info_data",$io->_main_data); //主表数据
        $this->assign("pagebar",$io->_page_bar);    //分页组件
        $this->assign("count",$io->_page_count);    //统计数据
        $this->assign("keyword",$io->_keyword);
        $this->assign("lx",$io->_lx);
        $ii=new CgxxAPI();
        $ii->loadclassdata();
        $this->assign("class_data",$ii->_class_data); //主分类数据
        $this->assign("class_mtea_data",$ii->_class_meta_data);
        $view_lx=I("view_lx");
        //echo $view_lx;
        $this->assign("title","中国公路科技成果转化平台|成果信息中心");
        $this->theme("glxh")->display();
    }
    public function search_dal(){
        $ii=new CgxxAPI();
        $ii->loaddaldata();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("jl_data",$ii->_dal_hj_data); //获奖信息
        //$this->assign("dw_data",$ii->_dal_wcdw_data); //完成单位信息
        $this->assign("title","中国公路科技成果转化平台|成果信息中心|成果详情");

        $this->theme("glxh")->display();
    }
    public function index(){

        $io=new CgxxAPI();
        $io->loadsearchdata();
        $this->assign("info_data",$io->_main_data); //主表数据
        $this->assign("pagebar",$io->_page_bar);    //分页组件
        $this->assign("pagecount",$io->_page_size);
        $this->assign("count",$io->_page_count);    //统计数据
        $this->assign("bh",$io->_keyword['bh']);
        $this->assign("name",$io->_keyword['name']);
        $this->assign("dq",$io->_keyword['dq']);
        $this->assign("wcr",$io->_keyword['wcr']);
        $this->assign("wcdw",$io->_keyword['wcdw']);
        $this->assign("tjdw",$io->_keyword['tjdw']);
        $this->assign("wcsj",$io->_keyword['wcsj']);
        $this->assign("gjc",$io->_keyword['gjc']);
        $this->assign("fl",$io->_keyword['fl']);
        $this->assign("fx",$io->_keyword['fx']);
        $this->assign("ly",$io->_keyword['ly']);
        $this->assign("jj",$io->_keyword['jj']);
        $this->assign("nd",$io->_keyword['nd']);
        $this->assign("dj",$io->_keyword['dj']);
        $this->assign("lx",$io->_lx);
        $this->theme("glxh")->display();

    }
    public function cgtg(){
        $ii=new CgxxAPI();
        $ii->cgtg_list();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("pagecount",$ii->_page_size);
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("cg_zsbh",$ii->_keyword['cg_zsbh']);
        $this->assign("cg_mc",$ii->_keyword['cg_mc']);
        $this->assign("cg_sbdw",$ii->_keyword['cg_sbdw']);
        $this->assign("title","中国公路科技成果转化平台|交通运输部科技成果推广目录");

        $this->theme("glxh")->display("hj_list");
    }
    public function hj_dal(){
        $ii=new CgxxAPI();
        $ii->cgtg_list();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("pagecount",$ii->_page_size);
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("cg_zsbh",$ii->_keyword['cg_zsbh']);
        $this->assign("cg_mc",$ii->_keyword['cg_mc']);
        $this->assign("cg_sbdw",$ii->_keyword['cg_sbdw']);
        $this->assign("title","中国公路科技成果转化平台|交通运输部科技成果推广目录");

        $this->theme("glxh")->display();
    }
    public function glhj_dal(){
        $ii=new CgxxAPI();
        $ii->cgtg_list();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("pagecount",$ii->_page_size);
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("jlnd",$ii->_keyword['cg_nd']);
        $this->assign("cg_mc",$ii->_keyword['cg_mc']);
        $this->assign("cg_sbdw",$ii->_keyword['cg_sbdw']);

        $this->assign("title","中国公路科技成果转化平台|中国公路学会科学技术奖");

        $this->theme("glxh")->display();
    }
    public function cghj(){

        $this->assign("title","中国公路科技成果转化平台|交通运输部科技成果推广目录");

        $this->theme("glxh")->display("glhj_list");
    }

   
}
