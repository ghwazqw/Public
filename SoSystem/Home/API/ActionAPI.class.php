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
    function loadUserLoginData($where){
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
    //读取操作功能
    function loadActionMenuData($type,$api_name,$con_name){
        $TableName=M("qx_menuaction_tb");
            //$where["menu_id"]  = array('eq',"%$this->_keyword%");
            //$where['_logic']='OR';
            //$mmmap['_complex']=$where;
            $mmmap["action_type"]  = array('eq',$type);
            $mmmap["api_name"]  = array('eq',"$api_name");
            $mmmap["controller_name"]  = array('eq',"$con_name");
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->actionInfo=$TableName->where($mmmap)->order("id ")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //用户操作日志类
    function UserLogInfoRecode($ActType,$zt,$UserName,$RcodeType){
        //echo "日志记录扩展";
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $ip = get_client_ip();
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
            \Think\Log::write($get_UserName.':'.$Act.$info."，操作时间：".$Acttime."，客户端IP地址：".$ip,'INFO');
        }elseif ($zt==0){
            $info="操作失败";
            \Think\Log::write($get_UserName.':'.$Act.$info."，操作时间：".$Acttime."，客户端IP地址：".$ip,'WARN');
        }

    }



}