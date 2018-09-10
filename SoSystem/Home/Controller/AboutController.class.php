<?php
namespace Home\Controller;

use Think\Controller;

class AboutController extends PublicController {

    public function index(){

        $this->theme("web")->display();

    }

}
