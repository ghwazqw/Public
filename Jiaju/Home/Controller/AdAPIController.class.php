<?php

namespace Home\Controller;

use Home\API\ActionAPI;

use Home\API\AdAPI;
use Think\Controller\RestController;

class AdAPIController extends RestController
{

    // 自动加载验证
    function _initialize()
    {
        $token_switch = C("token_switch");
        if ($token_switch == 1) {
            $token = I("apptoken");
            $ii = new ActionAPI();
            if ($ii->checkAppToken($token)) {
                return true;
            } else {
                $data['code'] = '401';
                $data['msg'] = 'apptoken无效';
                $data['data'] = null;
                $this->response($data, 'json');
                exit();
            }
        }
    }

    //加载AD类型api
    function AdSort()
    {
        $id = I("id");
        switch ($this->_method) {
            case 'get': // get请求处理代码
                $ii = new AdAPI(); //自行修改API接口
                $ii->pt_ad_tbmatedata($id);
                $total = $ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["data"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result, 'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                $id = I("id");
                //检测ID是否存在
                $ii = new ActionAPI();
                if (!$ii->ChId($id)) {
                    $result['code'] = '500'; //状态码
                    $result["msg"] = $ii->_Msg;
                    $result["total"] = 0;
                    $this->response($result, 'json'); //返回JSON接口
                } else {
                    //编辑信息
                    $ii = new AdAPI();
                    if ($ii->EditAdSort($id)) {
                        $result['code'] = '200'; //状态码
                        $result["msg"] = $ii->_Msg;
                        $result["total"] = 1;
                        $this->response($result, 'json'); //返回JSON接口
                    } else {
                        $result['code'] = '500'; //状态码
                        $result["msg"] = $ii->_Msg;
                        $result["total"] = 0;
                        $this->response($result, 'json'); //返回JSON接口
                    }
                }
                break;
            case 'post': // post请求处理代码
                $id = I("id");
                $ii = new AdAPI();
                if ($ii->EditAdSort($id)) {
                    $result['code'] = '200'; //状态码
                    $result["msg"] = $ii->_Msg;
                    $result["total"] = 1;
                    $this->response($result, 'json'); //返回JSON接口
                } else {
                    $result['code'] = '500'; //状态码
                    $result["msg"] = $ii->_Msg;
                    $result["total"] = 0;
                    $this->response($result, 'json'); //返回JSON接口
                }
                break;
            case 'delete': //删除信息
                $id = I("id");
                //echo $id;
                $ii = new ActionAPI();
                if (!$ii->ChId($id)) {
                    $result['code'] = '500'; //状态码
                    $result["msg"] = 'ID Error';
                    $result["total"] = 0;
                    $this->response($result, 'json'); //返回JSON接口
                } else {
                    $ii = new AdAPI();
                    if ($ii->AdSortDel($id)) {
                        $result['code'] = '200'; //状态码
                        $result["msg"] = $ii->_Msg;
                        $result["total"] = 1;
                        $this->response($result, 'json'); //返回JSON接口
                    } else {
                        $result['code'] = '500'; //状态码
                        $result["msg"] = $ii->_Msg;
                        $result["total"] = 0;
                        $this->response($result, 'json'); //返回JSON接口
                    };
                }
                break;
        }
    }
    //加载AD api
    function AdInfo()
    {
        $id=I("id");
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new AdAPI(); //自行修改API接口
                $ii->pt_aditem_tbmatedata($id);
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["data"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                break;
        }
    }

}
