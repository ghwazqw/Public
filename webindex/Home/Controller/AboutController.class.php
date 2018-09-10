<?php
namespace Home\Controller;
use Think\Controller;
use Home\API\NewstestAPI;
use Think\Model;

class AboutController extends Controller {
   public function news_list(){

      $get_info_type=I("get.type",1,"/^\d+$/");
       $ii=new NewstestAPI();
       $ii->loadmatedata();
       $this->assign("main_data",$ii->_main_data);
       $this->assign("dal_data",$ii->_dateil_data);
       $this->assign("pagebar",$ii->_page_bar);
       //$this->assign("title","中国公路科技成果转化平台|关于我们");
       $this->theme("glxh")->display();
   }

    public function news_dal(){
        $ii=new NewstestAPI();
        $ii->news_dal();
        $this->assign("meta_data",$ii->_meta_data);
        $this->assign("count",$ii->_page_count);
        //var_export($ii);

        $this->theme("glxh")->display();
    }
    public  function about_us(){
        $ii=new NewstestAPI();
        $ii->about_dal();
        $this->assign("meta_data",$ii->_meta_data);
        $this->assign("count",$ii->_page_count);
        $this->assign("title","中国公路科技成果转化平台|关于我们");
        $this->theme("glxh")->display();
    }

}
