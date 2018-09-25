<?php
namespace Home\Controller;
use Home\API\AppdataAPI;


class AppController extends RestfulController {

    public function index(){
        $id=I("id");
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new AppdataAPI(); //自行修改API接口
                $ii->Rulematedata($id);
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