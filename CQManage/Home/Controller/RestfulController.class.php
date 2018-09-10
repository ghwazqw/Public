<?php
namespace Home\Controller;
use Home\API\HtManageAPI;
use Home\API\NavbarAPI;
use Home\API\RestInfoAPI;
use Home\API\RoleAPI;
use Home\API\UserAPI;
use Home\API\ZcManageAPI;
use Think\Controller\RestController;

class RestfulController extends RestController {
    protected $allowMethod    = array('get','post','put'); // REST允许的请求类型列表
    protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表
    //主导航信息
    public function NavbarInfo(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new RestInfoAPI();
                $ii->LoadNavbarData();
                $this->response($ii->_main_data,'json',200);
                break;
            case 'put': // put请求处理代码
                $this->response('','json',400);
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
    //合同信息读取
    public function HtInfo(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new HtManageAPI();
                $ii->loadmatedata();
                $this->response($ii->_main_data,'json');
                break;
            case 'put': // put请求处理代码

                break;
            case 'post': // post请求处理代码
                break;
        }
    }
    //加载用户信息列表
    public function UserList(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                $ii=new UserAPI();
                $ii->loadRyuandata();
                $total=$ii->_page_count;

                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
        }
    }
    //加载电子设备信息列表
    public function SbInfoList(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new ZcManageAPI();
                $ii->DzsbList();
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                $ii=new ZcManageAPI();
                $table="dzsb_tb";
                $ii->CswxjeNew($table);
                //echo "ok";
                break;
        }

    }
    //加载机械器具信息列表
    public function JxsbInfoList(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new ZcManageAPI();
                $ii->JxsbList();
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                $ii=new ZcManageAPI();
                $table="dqsb_tb";
                    $ii->CswxjeNew($table);
                //echo "ok";
                break;
        }
    }
    //加载其他设备信息列表
    public function QtsbInfoList(){
        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new ZcManageAPI();
                $ii->qtsbList();
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                $ii=new ZcManageAPI();
                $table="qtzc_tb";
                $ii->CswxjeNew($table);
                //echo "ok";
                break;
        }
    }
    //加载运输工具信息列表
    public function YsgjInfoList(){
        $sort=I("sort");
        $order=I("order");
        $id=I("id");
        if (!$sort ){
            $sort="id";
        }
        if (!$order){
            $order="desc";
        }


        switch ($this->_method){
            case 'get': // get请求处理代码
                $ii=new ZcManageAPI();

                    $ii->loadYsgjdata($sort,$order);

                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                /*if (!$this->_type || $this->_type == 'json'){
                    $this->response($result,'json');
                }elseif
                ($this->_type == 'html'){
                    $this->assign("Infodata",$ii->_main_data);
                    //var_export($ret);
                }elseif($this->_type == 'xml'){
                    $this->response($result,'xml');
                }*/
                $this->response($result,'json');
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码
                $ii=new ZcManageAPI();
                $table="ysgj_tb";
                $ii->CswxjeNew($table);
                //echo "ok";
                break;
        }
    }
    //加载角色信息列表
    public function RoleList(){
        switch ($this->_method){
            case 'get': // get请求处理代码

                $ii=new RoleAPI();
                $ii->loadmatedata();
                $total=$ii->_page_count;
                $result["total"] = $total; //分页时需要获取记录总数，键值为total
                $result["rows"] = $ii->_main_data; //获取的记录信息，注意数组名称要与前端的指定名称想同
                $this->response($result,'json'); //返回JSON接口
                break;
            case 'put': // put请求处理代码
                break;
            case 'post': // post请求处理代码

                break;
        }
    }
    public function read_get_html(){
        // 输出id为1的Demo的html页面
        echo "输出id为1的Demo的XML数据read_get_html";
    }
    public function read_get_xml(){
        // 输出id为1的Demo的XML数据
        echo "输出id为1的Demo的XML数据read_get_xml";
    }
    public function read_xml(){
        // 输出id为1的Demo的XML数据
        echo "输出id为1的Demo的XML数据read_xml";
    }
    public function read_json(){
        // 输出id为1的Demo的json数据
        echo "输出id为1的Demo的XML数据read_json";
    }
}
