<?php

namespace Home\Controller;

use Home\API\ActionAPI;
use Home\API\ProductAPI;
use Think\Controller\RestController;

class ProductAPIController extends RestController
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

    //加载类型详细信息
    public function ProductSortDal()
    {
        $id = I("id");
        switch ($this->_method) {
            case 'get': // get请求处理代码
                $ii = new ProductAPI();
                $ii->LoadSortDal($id);
                $this->response($ii->_dal_data, 'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                //echo "add ok";
                $id = I("id");
                $ii = new ProductAPI();
                if ($ii->SortEdit($id)) {
                    $this->success("分类信息编辑成功", "/Product/SortManage", 1);
                } else {
                    $this->error("编辑失败，请检查信息");
                }
                break;
        }
    }

    //加载规格信息
    public function ProductTpl()
    {
        $id = I("id");
        switch ($this->_method) {
            case 'get': // get请求处理代码
                $ii = new ProductAPI(); //自行修改API接口
                $ii->pt_producttpl_tbmatedata($id);
                $total = $ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["data"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result, 'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                break;
        }
    }

    //加载产品类型
    public function PSort()
    {
        $jb = I("jb");
        switch ($this->_method) {
            case 'get': // get请求处理代码
                $ii = new ProductAPI(); //自行修改API接口
                $ii->LoadSortInfo($jb);
                //$result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["data"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result, 'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                break;
        }
    }

    //加载子分类信息
    public function Ssort()
    {
        $sjid = I("sjid");
        $ii = new ActionAPI();
        if (!$ii->ChId($sjid)) {
            $result['code'] = '500'; //状态码
            $result["msg"] = '参数错误/数据错误';
            $this->response($result, 'json'); //返回JSON接口
        } else {
            $io = new ProductAPI();
            $io->LoadSsoftInfo($sjid);
            $result['code'] = '200'; //状态码
            $result["msg"] = "获取成功";
            $result["data"] = $io->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
            $this->response($result, 'json'); //返回JSON接口
        }
    }

    //编辑规格模板信息
    public function EditTplInfo()
    {
        $id = I("id");
        switch ($this->_method) {
            case 'post':
                $ii = new ProductAPI();
                if ($ii->EditTpl($id)) {
                    $result['code'] = '200'; //状态码
                    $result["msg"] = "获取成功";
                } else {
                    $result['code'] = '500'; //状态码
                    $result["msg"] = '参数错误/数据错误';
                }
                break;
            case 'delete':
                $id = I("id");
                $ii = new ActionAPI();
                if (!$ii->ChId($id)) {
                    $result['code'] = '500'; //状态码
                    $result["msg"] = '参数错误/数据错误';
                    $this->response($result, 'json'); //返回JSON接口
                } else {
                    $ii = new ProductAPI();
                    if ($ii->TplDel($id)) {
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

    //商品信息处理
    public function ProductInfo()
    {
        $id = I("id");
        switch ($this->_method) {
            case 'get': // get请求处理代码
                $ii = new ProductAPI(); //自行修改API接口
                $ii->pt_product_tbmatedata($id);
                $total = $ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result['code'] = '200'; //状态码
                $result["msg"] = $ii->_Msg;
                $result["data"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result, 'json'); //返回JSON接口
                break;
            case 'post': // post请求处理代码
                $id = I("id");
                $ii = new ProductAPI();
                if ($ii->EditProduct($id)) {
                    $result['code'] = '200';
                    $result['msg'] = $ii->_Msg;
                    //$this->response($result,'json'); //返回JSON接口
                    $this->success($ii->_Msg, '/Product/ProductManage', 1);
                } else {
                    $result['code'] = '500';
                    $result['msg'] = $ii->_Msg;
                    $this->response($result, 'json'); //返回JSON接口
                    $this->error($ii->_Msg);
                }
                break;
            case 'delete':
                $id = I("id");
                $ii = new ActionAPI();
                if (!$ii->ChId($id)) {
                    $result['code'] = '500'; //状态码
                    $result["msg"] = '参数错误/数据错误';
                    $this->response($result, 'json'); //返回JSON接口
                } else {
                    $io = new ProductAPI();
                    if ($io->ProductDel($id)) {
                        $result['code'] = '200';
                        $result['total'] = 1;
                        $result['msg'] = $ii->_Msg;
                        $this->response($result, 'json'); //返回JSON接口
                    } else {
                        $result['code'] = '500';
                        $result['total'] = 0;
                        $result['msg'] = $ii->_Msg;
                        $this->response($result, 'json'); //返回JSON接口
                    }
                }
                break;


            default:
                $result['code'] = '500';
                $result['msg'] = '不允许的请求方式';
                $this->response($result, 'json');
                break;
        }
    }
    //商品上下架处理
    public function ProduxtSxj(){
        switch ($this->_method) {
            case 'post':
                $id = I("id");
                $ii = new ActionAPI();
                if (!$ii->ChId($id)) {
                    $result['code'] = '500'; //状态码
                    $result["msg"] = '参数错误/数据错误';
                    $this->response($result, 'json'); //返回JSON接口
                }else{
                    $status=I("status");
                    if ($status==1){
                        $st=0;
                    }elseif ($status==0){
                        $st=1;
                    }
                    $vol=I("vol");
                    $ii=new ProductAPI();
                    if ($ii->ProductSxj($id,$st,$vol)){
                        $result['code'] = '200';
                        $result['total'] = 1;
                        $result['msg'] = $ii->_Msg;
                        $this->response($result, 'json'); //返回JSON接口
                    }else{
                        $result['code'] = '500';
                        $result['total'] = 0;
                        $result['msg'] = $ii->_Msg;
                        $this->response($result, 'json'); //返回JSON接口
                    }
                }
                break;
            default:
                $result['code'] = '500';
                $result['msg'] = '不允许的请求方式';
                $this->response($result, 'json');
                break;
        }
    }
    //商品图片信息加载
    public function ImgView(){
        switch ($this->_method){
            case 'get':
                $id= I("id");
                $ii = new ActionAPI();
                if (!$ii->ChId($id)) {
                    $result['code'] = '500'; //状态码
                    $result["msg"] = '参数错误/数据错误';
                    $this->response($result, 'json'); //返回JSON接口
                }else{
                    $ii=new ProductAPI();
                    $ii->ImgInfo($id);
                    $result['code'] = '200';
                    //$result['total'] = 1;
                    $result['msg'] = $ii->_Msg;
                    $result['data']=$ii->_dateil_data;
                    $this->response($result, 'json'); //返回JSON接口
                }
                break;
            default:
                $result['code'] = '500';
                $result['msg'] = '不允许的请求方式';
                $this->response($result, 'json');
                break;
        }
    }


}
