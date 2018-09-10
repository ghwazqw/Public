<?php
namespace Home\Controller;
use Home\API\NewsAPI;

class AboutController extends PublicController {

    public function index(){
        $id=I("n");
        $ii=new NewsAPI();
        $ii->NewsKeyList(1);

           $this->assign("title","关于我们");
           $this->assign("InfoData",$ii->_main_data);
           if (!$id){
               $ii->NewsInfo("34");
           }else{
               $ii->NewsInfo($id);
           }
           $this->assign("DalInfo",$ii->_main_data);
           //var_dump($ii->_main_data);
           $this->theme("web")->display("about");
    }
}