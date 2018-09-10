<?php
namespace Home\Controller;
use Home\API\NavbarAPI;
use Home\API\UserAPI;
use Think\Controller;
use Think\Controller\RestController;

class RestfulController extends RestController {
    //主导航信息
    public function NavbarInfo(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new NavbarAPI();
                $ii->LoadNavbarData();
                $this->response($ii->_main_data,'json');
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                break;
        }
        //echo $this->_method;
    }
    //子导航信息
    public function Navbarsinfo(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new NavbarAPI();
                $ii->LoadNavbarData(2);
                $this->response($ii->_main_data,'json');
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                break;
        }
    }
    //用户信息
    public function QuserInfo(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new NavbarAPI();
                $ii->LoaduserInfo(2);
                $this->response($ii->_main_data,'json');
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                break;
        }
    }
    //用户报单信息
    public function UserBdInfo(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new NavbarAPI();
                $ii->LoadJyInfo();
                if ($ii->_page_count>0){
                    $this->response($ii->_main_data,'json');
                }else{
                    $userinfo=array(
                        "user_name"=>"no",
                        "jy_je"=>"0.00"
                    );
                    $this->response($userinfo,'json');
                }

                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                break;
        }
    }
    //报单中心报单记录数据接口
    public function Bdjson(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new UserAPI();
                $ii->BdCentLogInfo(10);
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["msg"] = $ii->_Msg;
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码

                break;
        }
    }
    //报单中心积分记录数据接口
    public function bdjfjson(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new UserAPI();
                $ii->BdCentjfInfo(11);
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                //$result["msg"] = $ii->_Msg;
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码

                break;
        }
    }
    //报单30元帐户
    public function Bdxjjson(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new UserAPI();
                $ii->BdCatInfo(10);
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                //$result["msg"] = $ii->_Msg;
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码

                break;
        }
    }
}