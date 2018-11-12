<?php
namespace Home\API;

use Home\Lib\PasswordHash;
use Think\Auth;

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
    public $_Msg="";
    public $_ImgUrl="";

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
            $this->_Msg="id error";
            return false;
        }else{
            return true;
        }
    }
    //客户端token认证
    function checkAppToken($apptoken){
        $AppToken=$apptoken;
        if (!$AppToken){
            return false;
        }else{
            $TokenTable=M("client_tb");
            $where["client_token"]=array("eq",$AppToken);
            $count=$TokenTable->where($where)->count();
            if (!$count || $count==0){
                return false;
            }else{
                return true;
            }
        }
    }
    //创建APPID appkey认证信息
    function WriteAppkey($appid,$Token,$appkey){
        $appkey=md5($appkey); //Hash方式加密
        $appid=$appid;
        $token=$Token;
        $username="ghwazqw";
        $TokenTable=M("client_tb");
        $TokenTable->client_appid=$appid; //appid
        $TokenTable->client_appkey=$appkey; //appkey
        $TokenTable->client_token=$token; //token认证
        $TokenTable->client_username=$username; //所属用户
        $TokenTable->client_actdate=date('Y-m-d H:i:s',time()); //注册时间
        $TokenTable->client_date=-1; //有效时长，-1为长期有效
        $ret=$TokenTable->add();
        if (!$ret){
            return false;
        }else{
            return true;
        }
    }
    //验证Appid及appkey
    function CheckAppkey($appid,$appkey){

        if (!$appid || !$appkey){
            return false;
        }else{
            $TokenTable=M("client_tb");
            $where["client_appid"]=array("eq",$appid);
            $count=$TokenTable->where($where)->count();

            if (!$count || $count==0){
                return false;
            }else{
                $ret=$TokenTable->where($where)->select();
                foreach ($ret as $info){
                    $data_appkey=$info["client_appkey"]; //读取appid
                    $acttime=$info["client_actdate"]; //注册时间
                    $actts=$info["client_date"]; //诚取有效天数
                }
                if ($actts==-1){ //-1为长期有效，只需要验证appkey是否正确
                    if ($appkey==$data_appkey){
                        return true;
                    }else{
                        return false;
                    }
                }else{

                }

            }
        }
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
            case 50;  //50为短信发送
                $Act="短信发送";
                break;
            case 49;  //49为短信接收
                $Act="短信接收";
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
            case 500;  //89用户置为有效
                $Act="表单Token验证";
                break;
            default;
                $Act="";
        }
        if ($zt==1){
            $info="操作成功";
            \Think\Log::write($get_UserName.':'.$Act.$info."，操作时间：".$Acttime."，客户端IP地址：".$ip,'INFO');
        }elseif ($zt==0){
            $info="操作失败";
            $info.=$RcodeType;
            \Think\Log::write($get_UserName.':'.$Act.$info."，操作时间：".$Acttime."，客户端IP地址：".$ip,'WARN');
        }
    }
    //用户缓存处理
    function UserCache($mobile){
        // 初始化缓存
        $cache = S(array('type'=>'xcache','prefix'=>'SmsCode','expire'=>60));
        $cache->mobile=$mobile;
    }
    //Auth权限验证处理
    function ChAuth(){
        $userinfo=New UserAPI();
        $userinfo->GetUserInfo();
        $userid=$userinfo->_userid;
        //exit($userid);
        $this->actionInfo=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
        $Auth=New Auth();
        if($Auth->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,$userid)){
            return true;
        }else{
            return false;
            //todo...
        }
    }
    //增加权限控制基础表
    function AddAuthTable($Name,$Title,$menuid,$type){ //实际控制器，标题，菜单ID，类型
        //exit($menuid);
        $Table=M("auth_rule");
        $Table->name=$Name;
        $Table->title=$Title;
        if ($menuid){
            $Table->id=$menuid;
        }
        /*if ($type==1){
            $Table->id=1;
        }else{
            $Table->id=0;
        }*/
        $where["name"]=array("eq","$Name");
        $where["title"]=array("eq","$Title");
        $count=$Table->where($where)->count();
        if ($count>0){ //如果该权限存在，就不再更新数据。
            $ret=$Table->where($where)->save();
        }else{
            $ret=$Table->add();
        }
        return $ret;
    }
    //临时图片上传类
    function ImgUpload($sort){

        $config = C('uploadfile'); //读取上传文件配置类
        $upload = new \Think\Upload($config);// 实例化上传类
        //上传文件
        $info = $upload->upload();

        if (!$info) {// 上传错误提示错误信息
            $this->_Msg=$upload->getError();
            return false;
            //$this->error($upload->getError());
        } else {// 上传成功
            //$this->success('上传成功！');
            foreach ($info as $file) {
                $zc_photo = $file['savepath'] . $file['savename'];
                $this->_ImgUrl=$zc_photo;
                return true;
            }
        }
    }

    //临时图片上传信息表
    function UpTmppImg($imgUrl,$sort,$username){
        if (!$username){
            return false;
        }else{
        $Table=M("imgtmp_tb");
        $Table->imageurl=$imgUrl;
        $Table->sort=$sort;
        $Table->username=$username;
        $Table->updatetime=date('Y-m-d H:i:s',time());
        $ret=$Table->add();
        if ($ret){
            return true;
        }else{
            return false;
        }
        }
    }
}