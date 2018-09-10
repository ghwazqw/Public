<?php
namespace Home\Controller;
use Home\API\CgxxAPI;
use Think\Controller;
class CgxxController extends Controller {
    public function Cgxx_list(){
    $ii=new CgxxAPI();
        $ii->loadmatedata();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("50")->display();
    }
    public function Cgxx_dal(){
        $ii=new CgxxAPI();
        $ii->loaddaldata();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("jl_data",$ii->_dal_hj_data);

        $this->theme("50")->display();
    }
    public function Cgxx_class(){
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
        $this->theme("50")->display();
    }
    public function Cgwcdw_list(){
        $ii=new CgxxAPI();
        $ii->cgwcdw();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("cgwc_xmbh",$ii->_keyword['cgwc_xmbh']);
        $this->assign("cgwc_wcdw",$ii->_keyword['cgwc_wcdw']);
        $this->assign("cgwc_szd",$ii->_keyword['cgwc_szd']);
        $this->assign("cgwc_dwsx",$ii->_keyword['cgwc_dwsx']);

        $this->theme("50")->display();
    }
    public function Cgdw_dal(){
        $ii=new CgxxAPI();
        $ii->cgdw_dal();
        $this->assign('info_data',$ii->_main_data);
        $this->assign('dal_data',$ii->_dateil_data);

        $this->theme("50")->display();
    }
    public function Cgxx_search(){
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

        $this->theme("50")->display();
    }
    public function Cgpg_list(){
        $ii=new CgxxAPI();
        $ii->cgtg_list();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("pagecount",$ii->_page_size);
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("cg_zsbh",$ii->_keyword['cg_zsbh']);
        $this->assign("cg_mc",$ii->_keyword['cg_mc']);
        $this->assign("cg_sbdw",$ii->_keyword['cg_sbdw']);

        $this->theme("50")->display();
    }

}
