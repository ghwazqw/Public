<?php
namespace Home\Controller;

use Home\API\HtManageAPI;
use Home\API\MenuAPI;
use Home\API\NavbarAPI;

use Home\API\QregAPI;
use Home\API\TreeAPI;
use Think\Controller;
class IndexController extends PublicController {
    public function index(){

        $ii=new NavbarAPI();
        $ii->LoadNavbarData(1);
        $this->assign("InfoData",$ii->_main_data);
        $ii->LoadNavbarData(2);
        $this->assign("MetaData",$ii->_main_data);
        //var_export($ii->_main_data);
       $this->theme("WebApps")->display();
    }
    public function manage(){
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
        $this->theme("Manage")->display("index");
    }

    //首页信息展示
    public function main_dal(){
        $this->theme("manage")->display();
    }
    //用户树结构信息展示
    public function User_dal(){
        $this->theme("manage")->display();
    }
    //加载用户树
    public function UserTree(){
        $ii=new QregAPI();
        $ii->loadusertree();
        $data=$ii->_main_data;
        $tree=new TreeAPI("id","user_pid","children");
        $tree->load($data);
        $treelist=$tree->DeepTree();//所有分类树结构
        echo json_encode($treelist);//查看结果
        $result = json_decode($treelist, true);
       /* if(!$result)
        {
            //error handle ,错误处理
            $ret = json_last_error();
            print_r($ret);   //打印为： 4,查错误信息表，可知是语法错误

        }else{
            echo $result;
        }*/


        //var_dump($treelist);
        //$subtree=$tree->DeepTree(1);//获取id为1下面的子树
        //var_dump($subtree);
    }
    //根据传入ID加载用户数
    public function UserIdTree(){
        $id=I("id");
        if (!$id){
            echo "ID Error";
            exit();
        }
        $ii=new QregAPI();
        $ii->loadusertree();
        $data=$ii->_main_data;
        $tree=new TreeAPI("id","user_pid","children");
        $tree->load($data);
        $treelist=$tree->DeepTree($id); //下属分类树结构
        echo json_encode($treelist); //查看结果
    }
    public function register(){
        $this->theme("WebApps")->display();
    }
    public function regsuc(){
        $this->theme("WebApps")->display();
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
        //$this->theme("50")->display();
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