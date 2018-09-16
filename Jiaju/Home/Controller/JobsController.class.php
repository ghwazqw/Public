<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */
namespace Home\Controller;


use Home\API\ActionAPI;
use Home\API\DelDataAPI;
use Home\API\JobAPI;
use Home\API\UserAPI;
use Think\Controller\RestController;

class JobsController extends RestController {

    public function _initialize(){
        $ii=new PublicController();
        $ii->_initialize();
        //$ii->_IsAuth();
    }

    //职位信息管理
    public function index(){
        $ii=new UserAPI();
        $ii->GetUserInfo();

        $this->assign("username",$ii->_userinfo);
        $this->assign("title","职位信息管理");
        $this->theme("webapps")->display();
    }

    //加载职位信息列表
    public function PositionInfo(){
        switch ($this->_method) {
            case 'get': // get请求处理代码
                $id=I("id");
                $ii=new JobAPI();
                $ii->PositionList($id);
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["data"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
        }
    }

    //编辑职位信息列表
    public function EditPosition(){
        $id=I("id");
        switch ($this->_method){
            case 'post':
                $ii=new JobAPI();
                if ($ii->EditPosition($id)){
                    $result["total"] = 1; //分页时需要获取记录总数，键值为total
                    $result['code'] = '200'; //状态码
                    $result["msg"] = $ii->_Msg;
                    //$this->response($result,'json'); //返回JSON接口
                    $this->success($ii->_Msg,'/jobs',1);
                }else{
                    $result["total"] = 0; //分页时需要获取记录总数，键值为total
                    $result['code'] = '200'; //状态码
                    $result["msg"] = $ii->_Msg; //信息
                    //$this->response($result,'json'); //返回JSON接口
                    $this->error($ii->_Msg);
                }
                break;
            case 'delete': // delete请求处理代码
                $id=I("id");
                $ii=new ActionAPI();
                $ii->ChId($id);
                $io=new DelDataAPI();
                if ($io->DelInfo('position_tb',$id)){
                    $msg="信息删除成功";
                    $result["total"] = 1;
                    $result['code'] = '200'; //状态码
                    $result["msg"] = $msg;
                    $this->response($result,'json'); //返回JSON接口
                    //echo 200;
                }else{
                    $msg="信息删除失败";
                    $result["total"] = 0;
                    $result['code'] = '200'; //状态码
                    $result["msg"] = $msg;
                    $this->response($result,'json'); //返回JSON接口
                    //echo 500;
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