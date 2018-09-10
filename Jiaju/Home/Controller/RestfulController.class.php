<?php
namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\BooksAPI;
use Home\API\ContractAPI;
use Home\API\MenuAPI;
use Home\API\NewsAPI;
use Home\API\TxSmsAPI;
use Home\API\UserAPI;
use Think\Controller\RestController;

class RestfulController extends RestController {

    // 自动加载验证
    function _initialize() {
        $token_switch=C("token_switch");
        if ($token_switch==1){
            $token=I("apptoken");
            $ii=new ActionAPI();
            if($ii->checkAppToken($token)){
                return true;
            }else{
                $data['code'] = '401';
                $data['msg'] = 'apptoken无效';
                $data['data'] = null;
                $this -> response($data, 'json');
                exit();
            }
        }
    }
    //加载资讯分类信息
    public function NewsSortList(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new NewsAPI();
                $ii->NewSort();
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
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
    //加载资讯信息
    public function NewsList(){
         $id=I("id");
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new NewsAPI();
                $ii->NewsInfo($id);
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                echo "add ok";
                break;
        }
    }
    //加载菜单详细信息
    public function Menudal(){
        $id=I("id");
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new MenuAPI();
                $ii->LoadMenuDal($id);
                $this->response($ii->_dal_data,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                echo "add ok";
                break;
        }
    }
    //加载图书信息
    public function Bookinfo(){
        $id=I("id");
        switch ($this->_method){
            case 'get': //get请求处理代码
                $ii=new BooksAPI();
                $ii->LoadBookInfo($id);
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["data"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
        }
    }
    //加载角色列表
    public function RoleList(){
        switch ($this->_method){
            case 'get': // get请求处理代码
               $ii=new UserAPI();
               $ii->LoadRoleInfo();
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["list"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
               //$this->response($ii->_main_data,'json');
                break;
            case 'put': // put改变状态请求处理代码
                break;
            case 'delete': // delete请求处理代码
                $id=I("id");
                $ii=new ActionAPI();
                $ii->ChId($id);
                $io=new UserController();
                if ($io->RoleDel($id)){
                    $msg="信息删除成功";
                    /*$result['code'] = '200'; //状态码
                    $result["msg"] = $msg;
                    $this->response($result,'json'); //返回JSON接口*/
                    echo 200;
                }else{
                    $msg="信息删除失败";
                    /*$result['code'] = '200'; //状态码
                    $result["msg"] = $msg;
                    $this->response($result,'json'); //返回JSON接口*/
                    echo 500;
                }
                break;
            case 'post': // post请求为编辑数据
                $name=I("name");
                $id=I("id");
                $ii=new UserAPI();
                if ($ii->RoleEdit($id,$name)){
                    if ($id==""){
                        $msg="信息增加成功";
                        $result['code'] = '200'; //状态码
                        /*$result["msg"] = $msg;*/
                        $this->response($result,'json'); //返回JSON接口
                    }else{
                        $msg="信息编辑成功";
                        $result['code'] = '200'; //状态码
                        /*$result["msg"] = $msg;*/
                        $this->response($result,'json'); //返回JSON接口
                    }
                }else{
                    $msg="信息编辑失败";
                    $result['code'] = '500'; //状态码
                    /*$result["msg"] = $msg;*/
                    $this->response($result,'json'); //返回JSON接口
                }
                break;
        }
    }
    //加载信息站点系统信息
    public function SystemInfo(){
        $sysconfig = C('SysConfig'); //读取基础配置类
        switch ($this->_method){
            case 'get':

                $result["msg"]="获取成功";
                $result["code"]=200;
                $result["data"]=$sysconfig;
                $this->response($result,'json');
                break;
        }
    }
    //加载用户登录日志
    public function UserLogInfo(){
        switch ($this->_method){
            case 'get':
                $ii=new UserAPI();
                $ii->LoadUserLog();
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["msg"]="获取成功";
                $result["code"]=200;
                $result["data"]=$ii->_main_data;
                $this->response($result,'json');
                break;
        }
    }
    //加载合同信息
    public function ContractInfo(){
        $id=I("id");
        switch ($this->_method){
            case 'get':
                $ii=new ContractAPI();
                $ii->ContractInfo($id);
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["msg"]="获取成功";
                $result["code"]=200;
                $result["data"]=$ii->_main_data;
                $this->response($result,'json');
                break;
            case 'post':
                $ii=new ContractAPI();
                if ($ii->EditContract()){
                    $result["code"]=200;
                    $result["msg"]=$ii->_Msg;
                    $result["state"]=1;
                    $this->success($ii->_Msg,'/restful/ContractInfo');
                }else{
                    $result["code"]=500;
                    $result["msg"]=$ii->_Msg;
                    $result["state"]=0;
                    $this->error($ii->_Msg);
                }
                //$this->response($result,'json');
                break;
        }
    }
    //加载图形验证码信息
    public function Vercode(){
        switch ($this->_method){
            case 'get':
                $result["total"] = 1; //分页时需要获取记录总数，键值为total
                $result["msg"]="获取成功";
                $result["code"]=200;
                $result["img"]='/index/VarImg';
                $this->response($result,'json');
                break;
        }
    }
    //加载手机验证码
    public function getcode(){
        switch ($this->_method){
            case 'post':
                $mob=I("mobile");
                $io=new UserAPI();
                if (!$io->chmob($mob)){ //检测不能过的情况
                    $result["total"] = 0; //分页时需要获取记录总数，键值为total
                    $result["msg"]="该手机已存在";
                    $result["code"]=200;
                    $this->response($result,'json');
                }else{
                    $ii=new TxSmsAPI();
                    if ($ii->SmsSender()){
                        $result["total"] = 1; //分页时需要获取记录总数，键值为total
                        $result["msg"]="验证码发送成功";
                        $result["code"]=200;
                        $this->response($result,'json');
                    }else{
                        $result["total"] = 0; //分页时需要获取记录总数，键值为total
                        $result["msg"]="发送失败，请重试";
                        $result["code"]=200;
                        $this->response($result,'json');
                    }
                }
                break;
            default :
                $result["total"] = 0; //分页时需要获取记录总数，键值为total
                $result["msg"]="不允许get方式请求";
                $result["code"]=200;
                $this->response($result,'json');
                break;
        }
    }
    //检测手机号是否存在
    public function chmobile(){
        switch ($this->_method){
            case 'post':
                $mob=I("mobile");
                $ii=new UserAPI();
                if ($ii->chmob($mob)){
                    $result["total"] = 1; //分页时需要获取记录总数，键值为total
                    $result["msg"]="输入正确";
                    $result["code"]=200;
                    $this->response($result,'json');
                }else{
                    $result["total"] = 0; //分页时需要获取记录总数，键值为total
                    $result["msg"]="该手机已存在";
                    $result["code"]=200;
                    $this->response($result,'json');
                }
                break;
            default :
                $result["total"] = 0; //分页时需要获取记录总数，键值为total
                $result["msg"]="不允许get方式请求";
                $result["code"]=200;
                $this->response($result,'json');
                break;
        }

    }
    //手机用户注册接口
    public function MobRegister(){
        switch ($this->_method){
            case 'post':
                $ii=new UserAPI();
                if ($ii->reg()){
                    $result["total"] = 1;
                    $result["msg"]=$ii->_Msg;
                    $result["code"]=200;
                    $this->response($result,'json');
                }else{
                    $result["total"] = 0;
                    $result["msg"]=$ii->_Msg;
                    $result["code"]=200;
                    $this->response($result,'json');
                }
                break;
            default :
                $result["total"] = 0; //分页时需要获取记录总数，键值为total
                $result["msg"]="不允许get方式请求";
                $result["code"]=200;
                $this->response($result,'json');
                break;
        }
    }

}
