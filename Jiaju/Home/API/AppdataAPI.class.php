<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/3/29
 * Time: 上午9:04
 */
namespace Home\API;



class AppdataAPI

{
    public $_UploadFile=""; //上传文件路径
    public $_Msg="";

   public function AuthentState($appid,$restid,$token){

   }
    /**
     *  作用：产生随机字符串，不长于32位
     */
    function createNoncestr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        echo $str;
    }
    //生成随机数
    function GetRandStr($len)
    {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i=0; $i<$len; $i++)
        {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;

    }
    //数字序列
    function GetAppid($len)
    {
        $chars = array(
            "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i=0; $i<$len; $i++)
        {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;

    }
    //验证码信息
    public function vercode(){
        ob_clean();
        $config =    array(
            'fontSize'    =>    35,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点

        );
        $Verify =     new \Think\Verify($config);
        //$Verify->useImgBg =true;   //背景图片
        $Verify->entry();
        //$this->theme("50")->display();
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
    //系统信息
    function ServerInfo(){
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            '主机名'=>$_SERVER['SERVER_NAME'],
            'WEB服务端口'=>$_SERVER['SERVER_PORT'],
            '网站文档目录'=>$_SERVER["DOCUMENT_ROOT"],
            '浏览器信息'=>substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            '通信协议'=>$_SERVER['SERVER_PROTOCOL'],
            '请求方法'=>$_SERVER['REQUEST_METHOD'],
            //'MySQL版本'=>mysql_get_server_info(),
            '系统版本'=>THINK_VERSION,
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '用户的IP地址'=>$_SERVER['REMOTE_ADDR'],
            '剩余空间'=>round((disk_free_space(".")/(1024*1024)),2).'M',
        );
        $this->_server_info=$info;
    }
    //系统配置
    function Sysinfo(){
        //基础信息配置
        $sysconfig = C('SysConfig'); //读取基础配置类
        $SystemName=$sysconfig["SystemName"]; //系统名称
        $Mobblie=$sysconfig["isMoblie"]; //手机端支持启动，
        /*$logo=$sysconfig["Logo"]; //系统Logo
        $this->assign("sys_title",$SystemName); //系统配置
        $this->assign("logo",$logo); //LOGO输出到模板
        $this->assign("address",$sysconfig["address"]); //地址
        $this->assign("addressx",$sysconfig["addressx"]); //地址
        $this->assign("email",$sysconfig["email"]); //邮箱
        $this->assign("tel",$sysconfig["tel"]); //邮箱
        $this->assign("ICP",$sysconfig["ICP"]); //ICP
        $this->assign("about",$sysconfig["about"]); //关于我们
        $this->assign("copyright",$sysconfig["copyright"]); //版权声明
        $this->assign("date",date('Y-m-d H:i:s',time()));*/
        //echo json_encode($sysconfig);
        if ($Mobblie==1){  //为1时启动对手机端的支持
            if (ismobile()) {
                //设置默认默认主题为 Mobile
                C('DEFAULT_V_LAYER','Mobile');
            }
        }
        return $sysconfig;
    }
    //1级菜单信息配置
    function OMenuApi(){
        //读取相应的菜单信息
        $Menu=new MenuAPI();
        $Menu->LoadAuthMenuInfo(1);
        $OMenu=$Menu->_main_data;
        return $OMenu;
        //$this->assign("MenuInfo",$Menu->_main_data);
        //var_export($Menu->_main_data);

        //var_export($Menu->_main_data);
    }
    //2级菜单信息配置
    function TMenuApi(){
        $Menu=new MenuAPI();
        $Menu->LoadAuthMenuInfo(2);
        $TMenu=$Menu->_main_data;
        return $TMenu;
        //$this->assign("MetaInfo",$Menu->_main_data);
    }
    //图形验证码生成
    function Varcode(){
        ob_clean();
        $config =    array(
            'fontSize'    =>    35,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点

        );
        $Verify =     new \Think\Verify($config);
        //$Verify->useImgBg =true;   //背景图片
        $Verify->entry();
        /*$this->theme("manage")->display();*/
    }
    //上传文件类封
    function UpLoadFile(){
        $config = C('up_file'); //读取上传文件配置
        $Upload= new \Think\Upload($config);
        // 上传文件
        $info   =   $Upload->upload();
        if(!$info) {// 上传错误提示错误信息
            //$this->error($upload->getError());
            $this->_Msg=$Upload->getError();
            return false;
        }else{// 上传成功
            //$this->success('上传成功');
            $filetable=M("infofile_tb");
            foreach ($info as $file) {
                //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                //$filetable->info_id=$ret;
                $this->_UploadFile=$file['savepath'] . $file['savename'];
                return true;
            }
        }
    }

}
