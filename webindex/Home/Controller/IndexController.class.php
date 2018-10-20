<?php
namespace Home\Controller;

use Home\API\InfostatAPI;
use Home\API\NewstestAPI;
use Home\API\RedisAPI;

use Home\API\YwzxAPI;
use Home\API\ZjxxAPI;
use Think\Cache\Driver\Redis;
use Think\Controller;
use Think\Verify;
use Home\API\CgxxAPI;
class IndexController extends Controller {
    public function index(){
        $get_logincook=$_COOKIE['user_info'];
        $get_user_log=unserialize($get_logincook);
        $user_name=$get_user_log->user_name;
        $ii=new CgxxAPI();
        $ii->loadmatedata();
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $io=new ZjxxAPI();
        $io->zjwcrdata();
        $this->assign("zjcount",$io->_page_count);
        $this->assign("userinfo",$user_name);

        $this->assign("title","中国公路科技成果转化平台");
        if ($_POST){
            $lx=I("lx");
            if ($lx=="") {
                $this->redirect('/index.php/home/index/search', array('keyword' => $ii->_keyword),0, '');
            }
            elseif ($lx=="cgxx"){
                $this->redirect('/index.php/home/cgsea/search', array('keyword' => $ii->_keyword),1, '成果信息正在检索，请稍候...');
            }
            elseif ($lx=="zjxx"){
                $this->redirect('/index.php/home/zjsea/search', array('keyword' => $ii->_keyword),1, '专家信息正在检索，请稍候...');
            }
            else{
                echo "List Error!";
                return false;
            }
        }
        //成果信息统计
        $ii=new InfostatAPI();
        $ii->cgxx_statistics();
        $this->assign("cg_2011",$ii->_2011);
        $this->assign("cg_2012",$ii->_2012);
        $this->assign("cg_2013",$ii->_2013);
        $this->assign("cg_2014",$ii->_2014);
        $this->assign("cg_2015",$ii->_2015);
        $this->assign("cg_2016",$ii->_2016);

        $this->assign("hj_2011",$ii->hj_2011);
        $this->assign("hj_2012",$ii->hj_2012);
        $this->assign("hj_2013",$ii->hj_2013);
        $this->assign("hj_2014",$ii->hj_2014);
        $this->assign("hj_2015",$ii->hj_2015);
        $this->assign("hj_2016",$ii->hj_2016);

        //读取当前COOKie信息
        $get_logincook=$_COOKIE['user_info'];
        $get_user_log=unserialize($get_logincook);
        $user_name=$get_user_log->user_name;
        $TableName=M("ywcount_vm");
        //读取全部更新
        $this->_page_count=$count=$TableName->where("gl_cjr='$user_name'")->count();
        $this->_main_data=$TableName->where("gl_cjr='$user_name'")->select(); //主表数据取值完成
        $this->assign("Ywxxdata",$this->_main_data);
        $this->assign("count",$this->_page_count);

        $this->assign("title","中国公路科技成果转化平台");
        $this->theme("glxh")->display();

    }
    public function vercode(){
        ob_clean();
        $config =    array(
            'fontSize'    =>    35,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点

        );
        $Verify =     new \Think\Verify($config);
        //$Verify->useImgBg =true;   //背景图片
        $Verify->entry();
        $this->theme("50")->display();
    }
    public function test1(){

        $this->theme("50")->display();
    }
    //二维码生成
    public function qrcode(){
        Vendor('phpqrcode.phpqrcode');
        $level=3;
        $size=5;
        $data=I("data");
        if ($data==""){
            $data="Auth:Gaohw,Email=Ghwazqw@vip.sina.com";
        }
        $url=$data;
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小
        $thisday=date('Ymd');
        $thistime=time('Hms');
        $daytime=$thisday.'-'.$thistime;
        $path="./PUBLIC/uploads/code/";
        $fileName = $daytime.'.png';
        $fileName =$path.$fileName;
        //生成二维码图片
        //echo $_SERVER['REQUEST_URI'];
        $object = new \QRcode();
        ob_clean();
        $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
        $object::png($url, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);

    }
    public function contact_us(){
        $this->assign("title","中国公路科技成果转化平台|联系我们");
        $this->theme("glxh")->display();
    }
    public function stat_info(){
        //成果信息统计
        $this->assign("title","中国公路科技成果转化平台|数据信息统计");
        $this->assign("cg_subtitle","2011-2016公路成果数据");
        $ii=new InfostatAPI();
        $ii->cgxx_statistics();
        $this->assign("cg_2011",$ii->_2011);
        $this->assign("cg_2012",$ii->_2012);
        $this->assign("cg_2013",$ii->_2013);
        $this->assign("cg_2014",$ii->_2014);
        $this->assign("cg_2015",$ii->_2015);
        $this->assign("cg_2016",$ii->_2016);

        $this->assign("hj_2011",$ii->hj_2011);
        $this->assign("hj_2012",$ii->hj_2012);
        $this->assign("hj_2013",$ii->hj_2013);
        $this->assign("hj_2014",$ii->hj_2014);
        $this->assign("hj_2015",$ii->hj_2015);
        $this->assign("hj_2016",$ii->hj_2016);
        //专家信息统计
        $ii->zjxx_statistics();;
        $this->assign("zj_title","专家信息统计");
        $this->assign("zj_subtitle","专家信息分类统计");
        $this->assign("zj_qn",$ii->zj_qn);
        $this->assign("zj_zj",$ii->zj_zj);
        $this->assign("zj_gw",$ii->zj_gw);

        //按地区统计专家
        $ii->zjxx_dq_view();
        $this->assign("zj_bj",$ii->zj_bj);
        $this->assign("zj_tj",$ii->zj_tj);
        $this->assign("zj_sh",$ii->zj_sh);
        $this->assign("zj_cq",$ii->zj_cq);
        $this->assign("zj_hb",$ii->zj_hb);
        $this->assign("zj_hn",$ii->zj_hn);
        $this->assign("zj_yn",$ii->zj_yn);
        $this->assign("zj_ln",$ii->zj_ln);
        $this->assign("zj_hlj",$ii->zj_hlj);
        $this->assign("zj_hnn",$ii->zj_hnn);
        $this->assign("zj_ah",$ii->zj_ah);
        $this->assign("zj_sd",$ii->zj_sd);
        $this->assign("zj_xj",$ii->zj_xj);
        $this->assign("zj_js",$ii->zj_js);
        $this->assign("zj_zjj",$ii->zj_zjj);
        $this->assign("zj_jx",$ii->zj_jx);
        $this->assign("zj_hbb",$ii->zj_hbb);
        $this->assign("zj_gx",$ii->zj_gx);
        $this->assign("zj_gs",$ii->zj_gs);
        $this->assign("zj_sx",$ii->zj_sx);
        $this->assign("zj_nmg",$ii->zj_nmg);
        $this->assign("zj_sxx",$ii->zj_sxx);
        $this->assign("zj_jl",$ii->zj_jl);
        $this->assign("zj_fj",$ii->zj_fj);
        $this->assign("zj_gz",$ii->zj_gz);
        $this->assign("zj_gd",$ii->zj_gd);
        $this->assign("zj_qh",$ii->zj_qh);
        $this->assign("zj_xz",$ii->zj_xz);
        $this->assign("zj_sc",$ii->zj_sc);
        $this->assign("zj_nx",$ii->zj_nx);
        $this->assign("zj_hnnn",$ii->zj_hnnn);
        $this->assign("zj_tw",$ii->zj_tw);
        $this->assign("zj_xg",$ii->zj_xg);
        $this->assign("zj_am",$ii->zj_am);
        $this->assign("day",date("Y年m月d日"));

        $this->theme("glxh")->display("stat");
    }
    public function service(){
        $this->assign("title","中国公路科技成果转化平台|服务流程");

        $this->theme("glxh")->display();
    }
    public function search(){
        //成果信息
        $io=new CgxxAPI();
        $io->loadseadata();
        $this->assign("info_data",$io->_main_data); //主表数据
        $this->assign("pagebar",$io->_page_bar);    //分页组件
        $this->assign("count",$io->_page_count);    //统计数据
        $this->assign("keyword",$io->_keyword);
        $this->assign("lx",$io->_lx);
        //专家信息
        $ii=new ZjxxAPI();
        $ii->zjxx_search();
        $this->assign("zj_data",$ii->_main_data);
        $this->assign("zj_pagebar",$ii->_page_bar);
        $this->assign("zj_page_size",$ii->_page_size);
        $this->assign("zj_count",$ii->_page_count);
        //资讯信息
        $ia=new NewstestAPI();
        $ia->loadmatedata();
        $this->assign("news_data",$ia->_main_data);
        $this->assign("news_pagebar",$ia->_page_bar);
        $this->assign("news_count",$ia->_page_count);
        //需求信息
        $a=new YwzxAPI();
        $a->xq_list();
        $this->assign("xq_data",$a->_main_date);
        $this->assign("xq_pagebar",$a->_page_bar);
        $this->assign("xq_count",$a->_page_count);

        $this->assign("title","中国公路科技成果转化平台|信息检索中心");
        $this->theme("glxh")->display();
    }
    public function falv_dal(){
        $this->assign("title","中国公路科技成果转化平台|法律声明");
        $this->theme("glxh")->display();
    }
    public function web_map(){
        $this->theme("glxh")->display("web_map");
    }
}
