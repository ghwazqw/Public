<?php
namespace Home\Controller;
use Home\API\DelDataAPI;
use Think\Controller;
use Home\API\ZjxxAPI;
class ZjxxController extends Controller {
    public function Zjxx_list(){

        $ii=new ZjxxAPI();
        $ii->loadmatedata();
        $this->assign("info_data",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);     //关键字
        $this->assign("zjlx",$ii->_type);
        $this->assign("page_size",$ii->_page_size);
        $this->theme("50")->display();


    }
   public function Zjxx_dal(){
        //专家详细信息
        $ii=new ZjxxAPI();
        $ii->loaddaldata(); //专家详细信息
       $this->assign("info_data",$ii->_main_data);
       $this->assign("cg_data",$ii->_meta_data);
       $this->assign("type",$ii->_type);
       $this->assign("title","中国公路科技成果转化平台|专家信息");

       $this->theme("50")->display();
   }
    public function  zjwcr_list(){
        //读取当前COOKie信息
        $get_logincook=$_COOKIE['user_info'];
        $get_user_log=unserialize($get_logincook);
        $user_name=$get_user_log->user_name;
        $ii=new ZjxxAPI();
        $ii->zjwcrdata();
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("count",$ii->_page_count);
        $this->assign("keyword",$ii->_keyword);
        $this->assign("cg_wcrxm",$ii->_keyword["cg_wcrxm"]);
        $this->assign("cg_wcrxb",$ii->_keyword["cg_wcrxb"]);
        $this->assign("cg_wcrcsny",$ii->_keyword["cg_wcrcsny"]);
        $this->assign("cg_wcrjg",$ii->_keyword["cg_wcrjg"]);
        $this->assign("cg_wcrmz",$ii->_keyword["cg_wcrmz"]);
        $this->assign("cg_wcrsfzh",$ii->_keyword["cg_wcrsfzh"]);
        $this->assign("cg_wcrdp",$ii->_keyword["cg_wcrdp"]);
        $this->assign("cg_wcrxzzw",$ii->_keyword["cg_wcrxzzw"]);
        $this->assign("cg_wcrgzdw",$ii->_keyword["cg_wcrgzdw"]);
        $this->assign("cg_wcrzyzc",$ii->_keyword["cg_wcrzyzc"]);
        $this->assign("cg_wcrzgxl",$ii->_keyword["cg_wcrzgxl"]);
        $this->assign("cg_wcryddh",$ii->_keyword["cg_wcryddh"]);
        $this->assign("lx",$ii->_lx);
        //$this->assign("type",$ii->_type);
        $this->assign("username",$user_name);
        $this->assign("zj_type",$ii->_keyword["zj_type"]);
        $this->theme("50")->display();
    }

    public  function  zjxx_edit(){

        $ii=new ZjxxAPI();
        $ii->loaddaldata(); //专家详细信息
        $this->assign("info_data",$ii->_main_data);
        $this->assign("cg_data",$ii->_meta_data);
        $this->assign("type",$ii->_type);

        if ($_POST){
            $a=new ZjxxAPI();
            $a->edit_info();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);

            }
        }

        $this->theme("50")->display();
    }
    public function  zjxx_add(){
        if ($_POST){
            $a=new ZjxxAPI();
            $a->add_info();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);

            }
        }
        $this->theme("50")->display();
    }
    public function Delete(){
        $a=new DelDataAPI();
        $a->DelInfo();
        $type=I("type");
        //redirect('javascript:history.back(-1);', 1, '删除成功，正在转入列表页面...');
        $this->redirect('/home/Zjxx/Zjwcr_list', array('type' => $type), 1, '删除成功，正在转入列表页面...');
        //echo "ok";
    }


}
