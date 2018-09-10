<?php
namespace Home\API;
namespace Home\Controller;
use Think\Controller\RestController;

class ResAPI extends  RestController {
    protected $allowMethod    = array('get','post','put'); // REST允许的请求类型列表
    protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表

    function ZcInfo(){
        if($this->get_request_method() == "GET"){
            echo "1";
            $this->response('',406);
        }
    }
}