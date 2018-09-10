<?php
namespace Home\API;
class InfostatAPI
{
    public $_2011="";
    public $_2012="";
    public $_2013="";
    public $_2014="";
    public $_2015="";
    public $_2016="";
    public $hj_2011="";
    public $hj_2012="";
    public $hj_2013="";
    public $hj_2014="";
    public $hj_2015="";
    public $hj_2016="";
    public $zj_qn;
    public $zj_zj;
    public $zj_gw;
    public $zj_bj="";
    public $zj_tj="";
    public $zj_sh="";
    public $zj_cq="";
    public $zj_hb="";
    public $zj_hn="";
    public $zj_yn="";
    public $zj_ln="";
    public $zj_hlj="";
    public $zj_hnn="";
    public $zj_ah="";
    public $zj_sd="";
    public $zj_xj="";
    public $zj_js="";
    public $zj_zjj="";
    public $zj_jx="";
    public $zj_hbb="";
    public $zj_gx="";
    public $zj_gs="";
    public $zj_sx="";
    public $zj_nmg="";
    public $zj_sxx="";
    public $zj_jl="";
    public $zj_fj="";
    public $zj_gz="";
    public $zj_gd="";
    public $zj_qh="";
    public $zj_sc="";
    public $zj_nx="";
    public $zj_hnnn="";
    public $zj_tw="";
    public $zj_xg="";
    public $zj_am="";
    public $zj_xz="";


    function cgxx_statistics(){

        $this->_2011=$count=M("cgxxjc_tb")->where("cg_xmbh like '2011%'")->count();
        $this->_2012=$count=M("cgxxjc_tb")->where("cg_xmbh like '2012%'")->count();
        $this->_2013=$count=M("cgxxjc_tb")->where("cg_xmbh like '2013%'")->count();
        $this->_2014=$count=M("cgxxjc_tb")->where("cg_xmbh like '2014%'")->count();
        $this->_2015=$count=M("cgxxjc_tb")->where("cg_xmbh like '2015%'")->count();
        $this->_2016=$count=M("cgxxjc_tb")->where("cg_xmbh like '2016%'")->count();

        $this->hj_2011=$count=M("cgxxjc_tb")->where("cg_xmbh like '2011%' and cg_jldj!=''")->count();
        $this->hj_2012=$count=M("cgxxjc_tb")->where("cg_xmbh like '2012%' and cg_jldj!=''")->count();
        $this->hj_2013=$count=M("cgxxjc_tb")->where("cg_xmbh like '2013%' and cg_jldj!=''")->count();
        $this->hj_2014=$count=M("cgxxjc_tb")->where("cg_xmbh like '2014%' and cg_jldj!=''")->count();
        $this->hj_2015=$count=M("cgxxjc_tb")->where("cg_xmbh like '2015%' and cg_jldj!=''")->count();
        $this->hj_2016=$count=M("cgxxjc_tb")->where("cg_xmbh like '2016%' and cg_jldj!=''")->count();

    }
    function zjxx_statistics(){
        $this->zj_qn=$count=M("zjwc_tb")->where("zj_type=1")->count();
        $this->zj_zj=$count=M("zjwc_tb")->where("zj_type=2")->count();
        $this->zj_gw=$count=M("zjwc_tb")->where("zj_type=3")->count();
    }
    function zjxx_dq_view($where){
        //$where['cg_wcrjg']  = array('like',"%$where%");  //地区
        $this->zj_bj=M("zjwc_tb")->where("cg_wcrjg like '%北京%'")->count();
        $this->zj_tj=M("zjwc_tb")->where("cg_wcrjg like '%天津%'")->count();
        $this->zj_sh=M("zjwc_tb")->where("cg_wcrjg like '%上海%'")->count();
        $this->zj_cq=M("zjwc_tb")->where("cg_wcrjg like '%重庆%'")->count();
        $this->zj_hb=M("zjwc_tb")->where("cg_wcrjg like '%河北%'")->count();
        $this->zj_hn=M("zjwc_tb")->where("cg_wcrjg like '%河南%'")->count();
        $this->zj_yn=M("zjwc_tb")->where("cg_wcrjg like '%云南%'")->count();
        $this->zj_ln=M("zjwc_tb")->where("cg_wcrjg like '%辽宁%'")->count();
        $this->zj_hlj=M("zjwc_tb")->where("cg_wcrjg like '%黑龙江%'")->count();
        $this->zj_hnn=M("zjwc_tb")->where("cg_wcrjg like '%湖南%'")->count();
        $this->zj_ah=M("zjwc_tb")->where("cg_wcrjg like '%安徽%'")->count();
        $this->zj_sd=M("zjwc_tb")->where("cg_wcrjg like '%山东%'")->count();
        $this->zj_xj=M("zjwc_tb")->where("cg_wcrjg like '%新疆%'")->count();
        $this->zj_js=M("zjwc_tb")->where("cg_wcrjg like '%江苏%'")->count();
        $this->zj_zjj=M("zjwc_tb")->where("cg_wcrjg like '%浙江%'")->count();
        $this->zj_jx=M("zjwc_tb")->where("cg_wcrjg like '%江西%'")->count();
        $this->zj_hbb=M("zjwc_tb")->where("cg_wcrjg like '%湖北%'")->count();
        $this->zj_gx=M("zjwc_tb")->where("cg_wcrjg like '%广西%'")->count();
        $this->zj_gs=M("zjwc_tb")->where("cg_wcrjg like '%甘肃%'")->count();
        $this->zj_sx=M("zjwc_tb")->where("cg_wcrjg like '%山西%'")->count();
        $this->zj_nmg=M("zjwc_tb")->where("cg_wcrjg like '%内蒙古%'")->count();
        $this->zj_sxx=M("zjwc_tb")->where("cg_wcrjg like '%陕西%'")->count();
        $this->zj_jl=M("zjwc_tb")->where("cg_wcrjg like '%吉林%'")->count();
        $this->zj_fj=M("zjwc_tb")->where("cg_wcrjg like '%福建%'")->count();
        $this->zj_gz=M("zjwc_tb")->where("cg_wcrjg like '%贵州%'")->count();
        $this->zj_gd=M("zjwc_tb")->where("cg_wcrjg like '%广东%'")->count();
        $this->zj_qh=M("zjwc_tb")->where("cg_wcrjg like '%青海%'")->count();
        $this->zj_xz=M("zjwc_tb")->where("cg_wcrjg like '%西藏%'")->count();
        $this->zj_sc=M("zjwc_tb")->where("cg_wcrjg like '%四川%'")->count();
        $this->zj_nx=M("zjwc_tb")->where("cg_wcrjg like '%宁夏%'")->count();
        $this->zj_hnnn=M("zjwc_tb")->where("cg_wcrjg like '%海南%'")->count();
        $this->zj_tw=M("zjwc_tb")->where("cg_wcrjg like '%台湾%'")->count();
        $this->zj_xg=M("zjwc_tb")->where("cg_wcrjg like '%香港%'")->count();
        $this->zj_am=M("zjwc_tb")->where("cg_wcrjg like '%澳门%'")->count();

        //echo M("zjwc_tb")->_sql();
        //echo $this->zj_bj;
    }

}