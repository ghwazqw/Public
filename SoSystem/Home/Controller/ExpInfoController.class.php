<?php
namespace Home\Controller;
use Home\API\ExpInfoAPI;
use Home\API\HtManageAPI;
use Home\API\RoleAPI;
use Home\API\ZcManageAPI;
use Think\Controller;

class ExpInfoController extends Controller {

    public function HtExp(){
        $ii=new HtManageAPI();
        $ii->expExcel();
    }
    public function DzsbExp(){
        $ii=new ExpInfoAPI();
        $ii->expDzsbExcel();
    }
    public function DqsbExp(){
        $ii=new ExpInfoAPI();
        $ii->expDqsbExcel();
    }
   
}
