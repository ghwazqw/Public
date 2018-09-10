<?php
namespace Home\Controller;
use Think\Controller;
use Home\API\UserAPI;
class QUserController extends Controller {
    public function user_reg(){

        $this->theme("glxh")->display();
    }
    public function user_login(){

        if ($_POST)
        {
            $a = new UserAPI();
            $a -> login();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }
        else
        {
        }
        $this->theme("glxh")->display();
    }
    public function user_cent(){
        $this->theme("glxh")->display();

    }
   
}
