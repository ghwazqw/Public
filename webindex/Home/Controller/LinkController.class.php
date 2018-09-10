<?php
namespace Home\Controller;
use Think\Controller;
use Home\API\LinkAPI;
use Think\Model;

class LinkController extends Controller {
   public function Link_list(){
       $ii=new LinkAPI();
       $ii->loadmatedata();
       $this->assign("main_data",$ii->_main_data);


       $this->theme("50")->display();
   }
    public function  Link_add(){
        $ii=new LinkAPI();
        $ii->add_info();
        if ($_POST){

            if ($ii->actionInfo!="")
            {
                eval($ii->actionInfo);
            }
        }

        $this->theme("50")->display();

    }
}
