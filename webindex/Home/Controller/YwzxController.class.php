<?php
namespace Home\Controller;
use Home\API\YwzxAPI;
use Think\Controller;
class YwzxController extends Controller {
    public function xqsq_manage(){
        $a=new YwzxAPI();
        $a->xqsq_manage();
        $this->assign("info_data",$a->_main1_data);
        $this->assign("pagebar",$a->_page_bar);
        $this->assign("count",$a->_page_count);
        $this->assign("hfsl",$a->_hfdata);
        $this->theme("50")->display();
        if($_POST){
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }
    }
    public function djzx_manage(){
        $a= new YwzxAPI();
        $a->djzx_manage();
        $this->assign("info_data",$a->_main1_data);

        if($_POST){
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);

            }
        }

        $this->theme("50")->display();
    }
}
