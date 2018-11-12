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

    public function upload()
    {
        $files = $_FILES;
        $imags = [];
        $errors = [];
        $filesname=$_FILES["images"];
        echo $filesname;
        foreach ($files[1] as $file) {
            // 移动到框架应用根目录/public/uploads/ 目录下
            echo ($file->name);
            /*$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename();
                $path = 'public/uploads/' . $info->getSaveName();
                array_push($imags, $path);
            } else {
            // 上传失败获取错误信息
            //echo $file->getError();
                array_push($errors, $file->getError());
            }*/
        }
        /*if (!$errors) {
            $msg['errno'] = 0;
            $msg['data'] = $imags;
            $this->response($msg,'json');
        } else {
            $msg['errno'] = 1;
            $msg['data'] = $imags;
            $msg['msg'] = "上传出错";
            $this->response($msg,'json');
        }*/
    }
}