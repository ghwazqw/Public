<?php
namespace Home\API;

class ActionAPI
{
    public $_page_size="30"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字数据
    public $_class_data=""; //类型数据
    public $_class_meta_data=""; //关键字数据
    public $actionInfo=""; //返回要执行的动作

    //读取用户登录操作信息
    function loadUserLoginData(){
        $TableName=M("user_log");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["log_type"]  = array('like',"%$this->_keyword%");
            //$where["log_date"]  = array('like',"%$this->_keyword%");
            $where["log_info"]  = array('like',"%$this->_keyword%");
            $where["user_id"]  = array('like',"%$this->_keyword%");
            $where["user_name"]  = array('like',"%$this->_keyword%");
            $where["user_ip"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //读取用户登录操作信息
    function loadInfoLoginData($username){
        $TableName=M("user_log");
            $where["user_name"]  = array('eq',"$username");
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //封装判断ID类
    function ChId($id){
        if (!$id){
            echo "Id Error";
            exit();
        }
    }
    //二维码生成
    public function qrcode(){
        Vendor('phpqrcode.phpqrcode');
        $level=3;
        $size=5;
        $data=I("data");
        if ($data==""){
            $data="Auth:Gaohw,Email=Ghwazqw@vip.sina.com";
        }
        $url=$data;
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小
        $thisday=date('Ymd');
        $thistime=time('Hms');
        $daytime=$thisday.'-'.$thistime;
        $path="./PUBLIC/uploads/code/";
        $fileName = $daytime.'.png';
        $fileName =$path.$fileName;
        //生成二维码图片
        //echo $_SERVER['REQUEST_URI'];
        $object = new \QRcode();
        ob_clean();
        $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
        $object::png($url, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);

    }
    //资产临时导入表
    //增加信息
    function AddZcTMP(){
                $AddData=D("zctmp_tb");  //注意去除前缀
                $AddData->z1z=I("z1z"); //1
                $AddData->z2z=I("z2z"); //2
                $AddData->z3z=I("z3z"); //3
                $AddData->z4z=I("z4z"); //4
                $AddData->z5z=I("z5z"); //5
                $AddData->z6z=I("z6z"); //6
                $AddData->z7z=I("z7z"); //7
                $AddData->z8z=I("z8z"); //8
                $AddData->z9z=I("z9z"); //9
                $AddData->z11z=I("z11z"); //11
                $AddData->z12z=I("z12z"); //12
                $AddData->z13z=I("z13z"); //13
                $AddData->z14z=I("z14z"); //14
                $AddData->z15z=I("z15z"); //15
                $AddData->z16z=I("z16z"); //16
                $AddData->z17z=I("z17z"); //17
                $AddData->z18z=I("z18z"); //18
                $AddData->z19z=I("z19z"); //19
                $AddData->z21z=I("z21z"); //21
                $AddData->z22z=I("z22z"); //22
                $AddData->z23z=I("z23z"); //23
                $AddData->z24z=I("z24z"); //24
                $AddData->z25z=I("z25z"); //25
                $AddData->z26z=I("z26z"); //26
                $AddData->z27z=I("z27z"); //27
                $AddData->z28z=I("z28z"); //28
                $AddData->z29z=I("z29z"); //29
                $AddData->z31z=I("z31z"); //31
                $AddData->z32z=I("z32z"); //32
                $AddData->z33z=I("z33z"); //33
                $AddData->z34z=I("z34z"); //34
                $AddData->z35z=I("z35z"); //35
                $AddData->z36z=I("z36z"); //36
                $AddData->z37z=I("z37z"); //37
                $AddData->z38z=I("z38z"); //38
                $AddData->z39z=I("z39z"); //39
                $AddData->add();
    }
    //用户操作日志类
    function UserLogInfoRecode($ActType,$zt,$UserName,$RcodeType){
        //echo "日志记录扩展";
        $ii=new UserAPI();
        $ii->GetUserInfo();
        if (!$UserName){
            $get_UserName=$ii->_username;
        }else{
            $get_UserName=$UserName;
        }
        //echo $ii->_username;
        $Acttime=date('Y-m-d H:i:s',time());
        switch($ActType){
            case 1;    //1为列表页面
            $Act="列表页";
            break;
            case 99;  //99为系统登录
                $Act="系统登录";
                break;
            case 90;  //90为用户"新增"操作
                $Act="用户新增";
                break;
            case 89;  //89用户置为无效
                $Act="用户置为无效";
                break;
            case 88;  //89用户置为有效
                $Act="用户置为有效";
                break;
            default;
            $Act="";
        }


        if ($zt==1){
            $info="操作成功";
            \Think\Log::write($get_UserName.':'.$Act.$info."，操作时间：".$Acttime,'INFO');
        }elseif ($zt==0){
            $info="操作失败";
            \Think\Log::write($get_UserName.':'.$Act.$info."，操作时间：".$Acttime,'WARN');
        }

    }


}