<?php
namespace Home\Controller;
use Home\API\HtManageAPI;
use Home\API\InfostatAPI;
use Home\API\MenuAPI;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $ii= new MenuAPI();
        $ii->LoadRoleMenuData();
        $this->assign("class_data",$ii->_class_data); //主分类数据
        $this->assign("class_mtea_data",$ii->_class_meta_data); //二级菜单
        $this->assign("mtea_data",$ii->_dateil_data); //三级菜单
        //合同数据
        $ii=new HtManageAPI();
        $ii->Htlist();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //首页信息展示
    public function main_dal(){
        //成果信息统计
        $this->assign("cg_title","设备信息统计");
        $this->assign("cg_subtitle","按照资产类型统计");
        //维修信息统计
        $wx=new InfostatAPI();
        $wx->SbwxInfo();
        $this->assign("WxCount",$wx->WxCount);
        $this->assign("WxInfo",$wx->_Wx_data);

        $ii=new InfostatAPI();
        $ii->zcxx_statistics();
        $this->assign("DzsbCount",$ii->_DzsbCount);
        $this->assign("DqsbCount",$ii->_DqsbCount);
        $this->assign("YsgjCount",$ii->_YsgjCount);
        $this->assign("QtsbCount",$ii->_QtsbCount);
        //专家信息统计
        $ii->zjxx_statistics();;
        $this->assign("zj_title","房屋信息统计");
        $this->assign("zj_subtitle","房屋信息统计 ");
        $this->assign("zj_qn",$ii->zj_qn);
        $this->assign("zj_zj",$ii->zj_zj);
        $this->assign("zj_gw",$ii->zj_gw);
        $this->assign("zj_qt",$ii->zj_qt);

        $this->theme("manage")->display();
    }
    //验证码信息
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
        /*$this->theme("manage")->display();*/
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

}