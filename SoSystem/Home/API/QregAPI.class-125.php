<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class QregAPI
{
    public $_page_size="40"; //每页显示条数
    public $_page_count = ""; //统计数量
    public $_main_data = array();
    public $_dal_data=array();
    public $_sjm=""; //随机数
    public $_jyinfo="";
    public $_txrq="";
    public $_ret="";
    public $_count=0;
    public $_gssy=0;
    public $_yhsy=0;
    public $_sdje=0;
    public $_Pcount=100;
    public $_jyzt=0;
    public $_userlx="";

    //检查用户是否重复
    public function ch_user()
    {
        $user=M("qx_user_tb");
        $user->user_name=I("Username");
        $this->_page_count=M("qx_user_tb")->where("user_name='".$user->user_name."' and user_lx=2")->count();
        $count=$this->_page_count;
        //echo $this->_page_count;
        if ($count==0){
            //echo $this->_page_count;
            $result=array("user_info"=>"succeed","user_callback"=>1);
            echo json_encode($result);
            return;
        }
        else{
            //echo $this->_page_count;
            $result=array("user_info"=>"error","user_callback"=>0);
            echo json_encode($result);
            return;
        }
    }
    public function ch_txtcode(){
        $getcode=I("txtcode");
        $Verify = new \Think\Verify();
        if(!$Verify->check($getcode)){
            $data=array("txt_info"=>"验证码出错，请检查","txt_callback"=>0);
            echo json_encode($data);
            return;
        }
        else
        {
            $data=array("txt_info"=>"succeed","txt_callback"=>1);
            echo json_encode($data);
            return;
        }
    }
    public function add_quser(){
        $tjr=I("user_tjr");
        $user=M("qx_user_tb");
        $getcode=I("txtcode");
        $ph=new PasswordHash(8, FALSE);
        $user->user_name=I("Username");
        $user->user_pwd=$ph->HashPassword(I("textPwd"));
        $user->user_yx=I("user_yx");
        $user->user_regdate=date('Y-m-d h:i:s');
        $user->user_sfyx=1;
        $user->user_tjr=I("user_tjr");
        $user->user_lx=2;
        $mpp["user_tjm"]=array("eq",$tjr);
        $selwhere['user_tjr']=array("eq",$tjr);
        $count=$user->where($mpp)->count();
        $selcount=$user->where($selwhere)->count();
        //echo $user->_sql();
        //exit();
        if ($selcount==0){
            $user->user_type=1;
        }elseif($selcount==1){
            $user->user_type=2;
        }else{
            echo "该推荐码人数已满，请更换后重新注册";
            exit();
        }
        if (!$tjr){ //没有推荐人由级别自动成1
            $user->user_jb=1;
        }else{
            $selectinfo=$user->where($mpp)->select();
            foreach ($selectinfo as $info){
                $user->user_jb=$info['user_jb']+1;
                $user->user_pid=$info['id'];
            }
        }
        $ret=$user->add();
        /*读取收益配置信息*/
        $jy=C("Jyconfig");
        $XyCsJe=$jy["XyCsJe"]; //分享线直接收益

        if($ret){
            $data=array("txt_callback"=>1);
            $CatTable=M("usercat_tb");
            /*开设现金帐户*/
            $CatTable->cat_type=1; //开户现金帐户
            $CatTable->cat_dqje=0; //初始金额为0
            $CatTable->cat_ztxje=0; //初始总提现金额为0
            $CatTable->cat_zsyje=0; //初始总收益金额为0
            $CatTable->cat_username=I("Username"); //用户名
            $CatTable->cat_userid=$ret; //用户ID
            $CatTable->cat_sj=date('Y-m-d h:i:s'); //开设时间
            $CatTable->add();
            /*开设信用帐户*/
            $CatTable=M("usercat_tb");
            $CatTable->cat_type=2; //开户信用帐户
            $CatTable->cat_dqje=$XyCsJe; //初始金额为配置值
            $CatTable->cat_ztxje=0; //初始总提现金额为0
            $CatTable->cat_zsyje=0; //初始总收益金额为0
            $CatTable->cat_username=I("Username"); //用户名
            $CatTable->cat_userid=$ret; //用户ID
            $CatTable->cat_sj=date('Y-m-d h:i:s'); //开设时间
            $CatTable->add();
            echo json_encode($data);
        }
        else
        {
            $this->actionInfo='{$this->assign("sussInfo","注册失败！");}';
        }
    }
    function myorder(){
        $get_logincook = $_COOKIE['user_info'];
        if (!$get_logincook) return false; //
        $get_user_log = unserialize($get_logincook);
        if (!$get_user_log) return false;
        if ($get_user_log->user_id && intval($get_user_log->user_id) > 0) {
            $username=$get_user_log->user_name;
        }
        $where['username']=array('eq',$username);
        $this->_main_data=M("shinfo_tb")->where($where)->order("id DESC")->select();
        $ordernum=$this->_main_data[0]['ordernum'];
        $mmap['ordernum']=array('eq',$ordernum);
        $this->_dal_data=M("usercat_vm")->order("id DESC")->select();
        //echo M("usercat_vm")->_sql();
        //var_export($this->_dal_data);

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
        $this->_sjm=$output;
    }
    //收益信息封装
    function syinfo($syr_name,$syr_gxrname,$syr_gxje){
        $sytable=M("syinfo_tb");
        $sytable->syr_name=$syr_name;
        $sytable->syr_gxje=$syr_gxje;
        $sytable->syr_gxrname=$syr_gxrname;
        $sytable->syr_sj=date('Y-m-d H:i:s',time()); //后端获取日期;
        $sytable->syr_day=date('Y-m-d',time());
        $sytable->add();
    }
    function AddNewBd(){
        /*接收数据*/
        $user_id=I("user_id");
        $tjr=I("user_tjr"); //上级推荐人获取
        $AddData=M("jybd_tb");  //报单表
        $user_type=I("user_type"); //用户类型
        $AddData->user_name=I("user_name"); //用户名
        $AddData->user_id=I("user_id"); //用户ID
        $AddData->user_type=$user_type; //用户类型
        $AddData->jy_je=I("jy_je"); //交易金额
        //$AddData->jy_sj=date('Y-m-d H:i:s', time()); //交易时间
        $AddData->jy_sj=date('Y-m-d H:i:s',time()); //交易时间
        $AddData->user_tjm=I("user_tjm"); //推荐码
        $AddData->user_tjr=I("user_tjr"); //推荐人
        $bdusername=I("user_name");
        $BDwhere["user_name"]=array("eq",$bdusername);
        $BdCount=$AddData->where($BDwhere)->count();
        //echo $AddData->_sql();
        //判定用户报单数据如果存在，则停止报单，以防用户重复报单
        if ($BdCount>0){
            echo "非法操作！";
            redirect('/home/Quser/user_cent', 1, '报单失败，正在返回用户中心...');
            exit();
        }
        if (I("user_type")==1){
            //开始报单，修改规则后要读取报单用户的直接上级信息
            $UserTable=M("qx_user_tb");
            $Jytjrwhere["user_tjm"]=array("eq",I("user_tjr"));
            $gxruserinfo=$UserTable->where($Jytjrwhere)->select();
            foreach ($gxruserinfo as $userinfo){
                $gxrusername=$userinfo["user_name"];  //读取“贡献人”用户名
                $gxrregdate=$userinfo["user_regdate"]; //读取“贡献人”注册时间
                $gxrtype=$userinfo["user_type"]; //读取“贡献人”类型
                $gxrid=$userinfo["id"]; //读取“贡献人ID”
                $gxrtjr=$userinfo["user_tjr"];
            }
            $this->Zjsy($gxrusername,$gxrtjr,$gxrtype); //调用收益
            $ret=$AddData->add();
            if ($ret>0){
                $this->GsEdit(3,1000); //公司金额更新
                if(I("user_type")==1){
                    $this->ActCat($gxrusername,2); //激活信用帐户
                }else{
                    $this->ActCat($gxrusername,1); //调用现金帐户
                }
                $this->_jyinfo=$ret;
            }
        }else{
            $UserTable=M("qx_user_tb");
            $Jytjrwhere["user_tjm"]=array("eq",I("user_tjr"));
            $gxruserinfo=$UserTable->where($Jytjrwhere)->select();
            foreach ($gxruserinfo as $userinfo){
                $gxrusername=$userinfo["user_name"];  //读取“贡献人”用户名
                $gxrregdate=$userinfo["user_regdate"]; //读取“贡献人”注册时间
                $gxrtype=$userinfo["user_type"]; //读取“贡献人”类型
                $gxrid=$userinfo["id"]; //读取“贡献人ID”
                $gxrtjr=$userinfo["user_tjr"];
            }
            $ret=$AddData->add();
            $this->_jyinfo=$ret;
            $this->GsEdit(3,1000); //公司金额更新
            $this->ActCat($gxrusername,1); //调用现金帐户
        }

    }
    function Ksselect($gxrusername,$sjuserid){
        $Qusertable=M("qx_user_tb");
        $userwhere["_string"]="FIND_IN_SET(id,getParLst($sjuserid))";
        $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->select();
        $ksinfo=0;
        foreach ($Jjsyy as $userinfo ){
            if ($userinfo["user_type"]==2 && $ksinfo==0){
                $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                $ksinfo=1;
            }
        }
    }
    //更新公司帐户
    function GsEdit($cattype,$je){
        $cattable=M("usercat_tb");
        $where["cat_type"]=array("eq",$cattype);
        $dqje=$cattable->where($where)->getField("cat_dqje");
        $catje=$dqje+$je;
        $cattable->cat_dqje=$catje;
        $cattable->where($where)->save();
    }
    //激活上级用户帐户封装
    function ActCat($catuser,$cattype){
        if (!$catuser){
            exit("用户信息错误 ");
        }
        $cattable=M("usercat_tb");
        $where["cat_username"]=array("eq",$catuser);
        $where["cat_type"]=array("eq",$cattype);
        $cattable->cat_zt=1;
        $cattable->where($where)->save();
    }
    //贡献人信用帐户变化封装
    function ZjXy($gxrusername,$jyje){
        $CatTable=M("usercat_tb");
        $where["cat_username"]=array("eq",$gxrusername);
        $where["cat_type"]=array("eq",2);
        $catzt=$CatTable->where($where)->getField("cat_zt"); //读取信用帐户状态
        $catdqje=$CatTable->where($where)->getField("cat_dqje"); //读取信用帐户当前金额
        if ($catzt==0){ //如帐户未启用
            //exit("帐户未启用");
        }
        //保存金额
        if (!$jyje){
            $jyje=0;
        }
        $dqje=$catdqje-$jyje;
        if ($dqje<500){ //金额过低的处理方式
        }

        $CatTable->cat_dqje=$dqje;
        $ret=$CatTable->where($where)->save();
        return $ret;
    }
    //直接收益封装
    function Zjsy($gxrusername,$gxrtjr,$gxrtype){
        /*读取收益配置信息*/
        $jy=C("Jyconfig");
        $kszjje=$jy["KsZjSy"];  //开市直接收益
        $fxzjje=$jy["FxZjSy"];  //分享直接收益
        /*读取收益人信息*/
        $where["user_tjm"]=array("eq",$gxrtjr);
        $UserTable=M("qx_user_tb");
        $syuserinfo=$UserTable->where($where)->select();
        //echo $UserTable->_sql()."<br />";
        foreach ($syuserinfo as $syuser){
            $syuserid=$syuser["id"]; //收益人用户ID
            $syusername=$syuser["user_name"]; //收益人用户名
            $syusertjm=$syuser["user_tjm"]; //收益人推荐码
            $syusertjr=$syuser["user_tjr"];
        }
        $uwhere["user_tjm"]=array("eq",$syusertjr);
        $getuserid=$UserTable->where($uwhere)->getField("id");
        //echo $syusername;
        /*读取收益人现金帐户信息*/
        $cattable=M("usercat_tb");
        $catwhere["cat_username"]=array("eq",$syusername);
        $catwhere["cat_type"]=array("eq",1); //现金帐户类型为1
        $xjdqje=$cattable->where($catwhere)->getField("cat_dqje");
        $xjzt=$cattable->where($catwhere)->getField("cat_zt");
            if ($gxrtype==1){ //分享线用户时
                $clje=$xjdqje+$fxzjje;
                $jyje=$fxzjje;
            }elseif ($gxrtype==2) { //开市线用户时
                $clje=$xjdqje+$kszjje;
                $jyje=$kszjje;
            }
        $cattable->cat_dqje=$clje;
        $cattable->where($catwhere)->save();
        //echo $gxrtype."<br />";
        //exit();
        //echo $clje."<br />";
        //echo $cattable->_sql()."<br />";
        $this->ZjXy($gxrusername,$jyje); //核减自己信用帐户
        $this->syinfo($syusername,$gxrusername,$jyje);
        $this->UserUP($syuserid,$gxrusername,9); //调用找出循环根用户
        $this->UserwUup($syuserid,$gxrusername,9,$gxrtype); //循环收益类

    }
    //间接接收益封装
    function Jjsy($gxrusername,$gxrtjr,$gxrtype,$je){
        /*读取收益配置信息*/
        $jy=C("Jyconfig");
        $kszjje=$jy["KsJjSy"];  //开市直接收益
        $fxzjje=$jy["FxJjSy"];  //分享直接收益
        /*读取收益人信息*/
        $where["user_tjm"]=array("eq",$gxrtjr);
        $UserTable=M("qx_user_tb");
        $syuserinfo=$UserTable->where($where)->select();
        //echo $UserTable->_sql()."<br />";
        foreach ($syuserinfo as $syuser){
            $syuserid=$syuser["id"]; //收益人用户ID
            $syusername=$syuser["user_name"]; //收益人用户名
            $syusertjm=$syuser["user_tjm"]; //收益人推荐码
        }
        //echo $syusername;
        /*读取收益人现金帐户信息*/
        $cattable=M("usercat_tb");
        $catwhere["cat_username"]=array("eq",$syusername);
        $catwhere["cat_type"]=array("eq",1); //现金帐户类型为1
        $xjdqje=$cattable->where($catwhere)->getField("cat_dqje");
        $xjzt=$cattable->where($catwhere)->getField("cat_zt");
        if ($je!=""){
            $fxzjje=$je;
            $kszjje=$je;
        }
        if ($gxrtype==1){ //分享线用户时
            $clje=$xjdqje+$fxzjje;
            $jyje=$fxzjje;
        }elseif ($gxrtype==2) { //开市线用户时
            $clje=$xjdqje+$kszjje;
            $jyje=$kszjje;
        }
        //echo $gxrtype."<br />";
        //echo $clje."<br />";
        $cattable->cat_dqje=$clje;
        $cattable->where($catwhere)->save();
        //echo $cattable->_sql()."<br />";
        $this->ZjXy($gxrusername,$jyje); //调用自己信用帐户进行核减
        $this->syinfo($syusername,$gxrusername,$jyje);
    }
    //封装用户循环根的类型
    function UserUP($sjuserid,$gxrusername,$shu){
        $Qusertable=M("qx_user_tb");
        $userwhere["_string"]="FIND_IN_SET(id,getParLst($sjuserid))";
        $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit($shu)->select();
        //$Arr=array(1,2,3,4);
        $user_type="";
        $Last=end($Jjsyy); //设置数组结束值
        foreach($Jjsyy as $Key=>$Value) {
            $user_type.=$Value["user_type"].",";
            if ($Last === $Value) {
                $userlx=$Value["user_type"]; //读取用户的类型
            }

            $this->_userlx=$userlx;
        }
        $pdlx=strstr($user_type,"2");
        if (!$pdlx){
            $this->Ksselect($gxrusername,$sjuserid);
        }
    }
    //间接收益循环
    function UserwUup($sjuserid,$gxrusername,$shu,$gxrtype){
        $Qusertable=M("qx_user_tb");
        $userwhere["_string"]="FIND_IN_SET(id,getParLst($sjuserid))";

        $lx=$this->_userlx;
        if (!$lx){
            $count=$Qusertable->where($userwhere)->order("id desc")->count();
            $count=$count-1;
            $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit($count)->select();
            //var_export($Jjsyy);
            $Last=end($Jjsyy); //设置数组结束值
            foreach ($Jjsyy as $userinfo){
                if ($Last === $userinfo) {
                    $lx=$userinfo["user_type"];
                }
            }
        }
        //echo $lx;
        if ($lx==1){ //分享线用户处理
            $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(2)->select(); //循环两次读取可能出现的分享用户
            //var_export($Jjsyy);
            $Last=end($Jjsyy); //设置数组结束值
            foreach ($Jjsyy as $userinfo){
                if ($userinfo["user_type"]==2 && $gxrtype==1){
                    $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                    $gxrtype=2;
                }else{
                    $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"]);
                }
                if ($Last === $userinfo) {
                    $usertjr=$userinfo["user_tjr"]; //读取用户的类型
                    $usertype=$userinfo["user_type"]; //读取用户的类型
                    $userid=$userinfo["id"]; //读取用户ID
                    $username=$userinfo["user_name"];
                }
            }
            $uswhere["user_tjm"]=array("eq",$usertjr);
            $getid=$Qusertable->where($uswhere)->getField("id");
            $getuuwhere["_string"]="FIND_IN_SET(id,getParLst($getid))";
            $Jjsyy=$Qusertable->where($getuuwhere)->order("id desc")->limit(7)->select(); //循环两次读取可能出现的分享用户
            //echo $Qusertable->_sql();
            //var_export($Jjsyy);
            foreach ($Jjsyy as $userinfo){
                if ($userinfo["user_type"]==2){ //开市线用户收取收益
                    if ($userinfo["user_type"]==2 && $gxrtype==1){
                        $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                        $gxrtype=2;
                    }else{
                        $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"]);
                    }
                }
            }
        }elseif ($lx==2){ //开市线用户处理
            $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(2)->select(); //循环两次读取可能出现的分享用户
            //var_export($Jjsyy);
            $Last=end($Jjsyy); //设置数组结束值
            foreach ($Jjsyy as $userinfo){
                if ($userinfo["user_type"]==2 && $gxrtype==1){
                    $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                    $gxrtype=2;
                }else{
                    $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"]);
                }
                if ($Last === $userinfo) {
                    $usertjr=$userinfo["user_tjr"]; //读取用户的类型
                    $usertype=$userinfo["user_type"]; //读取用户的类型
                    $userid=$userinfo["id"]; //读取用户ID
                    $username=$userinfo["user_name"];
                }
            }
            $uswhere["user_tjm"]=array("eq",$usertjr);
            $getid=$Qusertable->where($uswhere)->getField("id");
            $getuuwhere["_string"]="FIND_IN_SET(id,getParLst($getid))";
            $Jjsyy=$Qusertable->where($getuuwhere)->order("id desc")->limit(7)->select(); //循环两次读取可能出现的分享用户
            //echo $Qusertable->_sql();
            //var_export($Jjsyy);
            foreach ($Jjsyy as $userinfo){
                if ($userinfo["user_type"]==2 && $gxrtype==1){ //开市线用户收取收益
                    if ($gxrtype==1){
                        $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                        $gxrtype=2;
                    }else{
                        $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"]);
                    }

                }
            }

        }
    }

    function loadJydata($where){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        //echo $globar_user->user_name;
        $TableName=M("jybd_tb");
        $this->_keyword=I("keyword");

        $where["user_name"]  = array('eq',"$globar_user->user_name");
        /*$where["user_id"]  = array('like',"%$this->_keyword%");
        $where["user_type"]  = array('like',"%$this->_keyword%");
        $where["jy_je"]  = array('like',"%$this->_keyword%");
        $where["jy_sj"]  = array('like',"%$this->_keyword%");
        $where["user_tjm"]  = array('like',"%$this->_keyword%");
        $where["user_tjr"]  = array('like',"%$this->_keyword%");*/

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    function loadQJydata($where){
        $user_info=I("info");
        $globar_user=unserialize($user_info);
        //echo $globar_user->user_name;
        $TableName=M("jybd_tb");
        $this->_keyword=I("keyword");

        $where["user_name"]  = array('eq',"$user_info");
        /*$where["user_id"]  = array('like',"%$this->_keyword%");
        $where["user_type"]  = array('like',"%$this->_keyword%");
        $where["jy_je"]  = array('like',"%$this->_keyword%");
        $where["jy_sj"]  = array('like',"%$this->_keyword%");
        $where["user_tjm"]  = array('like',"%$this->_keyword%");
        $where["user_tjr"]  = array('like',"%$this->_keyword%");*/

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    function loadsydata($where){
        $TableName=M("syinfo_tb");
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $username=$globar_user->user_name;

        $where["syr_name"]  = array('eq',$username);
        $where['_logic']='OR';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,10);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    function loadcatdata($where){
        $TableName=M("usercat_tb");
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $username=$globar_user->user_name;

        $where["cat_type"]  = array('eq',1);
        $where["cat_username"]  = array('eq',$username);
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成

        //当天收益计算
        $Sytable=M("syinfo_tb");
        $map["syr_name"]=array("eq",$username);
        //$map["syr_day"]=array("elt",date('Y-m-d',strtotime('-1 day')));
        $map["syr_day"]=array("eq",date('Y-m-d',time()));
        /*$map['_logic']='and';
        $mmmap['_complex']=$map;
        $map["syr_name"]=array("eq",$username);
        $mmmap["syr_day"]=array("eq",date('Y-m-d',strtotime('-1 day')));
        $mmmap['_logic']='or';*/
        $this->_sdje=$Sytable->where($map)->sum("syr_gxje");
        if (!$this->_sdje){
            $this->_sdje=0;
        }
        //echo $summoney;
        //echo $Sytable->_sql();
        foreach ($this->_main_data as $info){
            $username=$info["cat_username"];
            $countwhere["username"]=array("eq",$username);
            $countwhere["tx_zt"]=array("eq",100);
            $count=M("usertxlog_tb")->where($countwhere)->count();
            //echo M("usertxlog_tb")->_sql();
            //echo $count;
            if ($count>0){
                $this->_count=1;
            }
        }
        //echo $TableName->getLastSql();
    }
    function loadQjyinfodata($where){
        $TableName=M("jybd_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["user_name"]  = array('like',"%$this->_keyword%");
            $where["user_id"]  = array('like',"%$this->_keyword%");
            $where["user_type"]  = array('like',"%$this->_keyword%");
            $where["jy_je"]  = array('like',"%$this->_keyword%");
            $where["jy_sj"]  = array('like',"%$this->_keyword%");
            $where["user_tjm"]  = array('like',"%$this->_keyword%");
            $where["user_tjr"]  = array('like',"%$this->_keyword%");
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
    function loadQsydata($where){
        $TableName=M("syinfo_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["syr_name"]  = array('like',"%$this->_keyword%");
            $where["syr_tjm"]  = array('like',"%$this->_keyword%");
            $where["syr_gxrtjm"]  = array('like',"%$this->_keyword%");
            $where["syr_gxje"]  = array('like',"%$this->_keyword%");
            $where["syr_gxrname"]  = array('like',"%$this->_keyword%");
            $where["syr_sj"]  = array('like',"%$this->_keyword%");
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
    function loadQcatdata($lx){
        $TableName=M("usercat_tb");
        $this->_keyword=I("keyword");

        $where["cat_type"]  = array('like',"%$this->_keyword%");
        $where["cat_dqje"]  = array('like',"%$this->_keyword%");
        $where["cat_ztxje"]  = array('like',"%$this->_keyword%");
        $where["cat_zsyje"]  = array('like',"%$this->_keyword%");
        $where["cat_username"]  = array('like',"%$this->_keyword%");
        $where["cat_userid"]  = array('like',"%$this->_keyword%");
        $where["cat_sj"]  = array('like',"%$this->_keyword%");
        $where["cat_tjm"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['cat_type']=array('eq',$lx);
        $mmmap['_logic']='AND';

        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //读取用户树
    function loadusertree(){
        $Table=M("qx_user_tb");
        $ret=$Table->where("user_lx=3")->order("id")->getField('id,user_pid,concat(user_name) as text,state');
        //echo $Table->_sql();
        //var_export($ret);
        $this->_main_data=$ret;
        //echo json_encode($ret);
    }
    //读取用户报单信息
    function loadQbdinfo(){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $user_name=$globar_user->user_name;
        //echo $user_name;
        $BdTable=M("jybd_tb");
        $where["user_name"]=array("eq",$user_name);
        $this->_main_data=$BdTable->where($where)->order("id desc")->select();
        //echo $BdTable->_sql();
        foreach ($this->_main_data as $info){
            $dateinfo=$info['jy_sj'];
        }
        //echo $dateinfo."<br />";
        $time=strtotime("$dateinfo + 7 days");
        $time = date("Y-m-d H:i:s", $time);
        $day=date("Y-m-d H:i:s");
        //echo $day;
        if(strtotime($day)<strtotime($time)){
            $this->_txrq=1;
        }else{
            $this->_txrq=0;
        }
    }
    //提现申请
    function TxSubInfo(){
        $zhje=I("zhje");
        $txje=I("txje");
        $ktxje=I("ktxje");
        if ($ktxje<$txje) {
            redirect('/home/Quser/xjcat_list', 1, '非法操作，提现金额不符合规则...');
            exit();
        }
        $AddData=M("usertxlog_tb");  //注意去除前缀
        $now_time = date('Y-m-d',time());
        $where["username"]=array("eq",I("username"));
        $where["tx_sj"]=array("like","$now_time%");
        $where["tx_zt"]=array("neq",7);
        $count=$AddData->where($where)->count();
        if ($count>0){
            redirect('/home/Quser/xjcat_list', 1, '非法操作,一天只能申请提现一次，您今天已经申请过一次...');
            exit();
        }else{
            $AddData->username=I("username"); //用户名
            $AddData->tx_je=I("txje"); //提现金额
            $AddData->tx_sj=date("Y-m-d H:i:s"); //申请提现时间
            $AddData->tx_zt=5; //1为申请，5为审核中，7为驳回，10为通过
            /*$AddData->tx_shr=I("tx_shr"); //审核人
            $AddData->tx_shsj=I("tx_shsj"); //审核时间*/
            $this->_ret=$AddData->add();
            //echo $this->_ret;
            if ($this->_ret>0){
                $catTable=M("usercat_tb");
                $where["cat_type"]=array("eq",1);
                $where["cat_username"]=array("eq",I("username"));
                $catTable->cat_dqje=$zhje-I("txje");
                $catTable->where($where)->save();
            }
        }

    }
    //提现记录表
    function loadTxmatedata($where){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $user_name=$globar_user->user_name;
        $TableName=M("usertxlog_tb");
        $this->_keyword=I("keyword");

        $where["username"]  = array('eq',"$user_name");
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //提现审批表
    function loadTxdata($zt){
        $TableName=M("usertxlog_tb");
        $this->_keyword=I("keyword");
        $where["username"]  = array('like',"%$this->_keyword%");
        $where["tx_je"]  = array('like',"%$this->_keyword%");
        //$where["tx_sj"]  = array('like',"%$this->_keyword%");
        //$where["tx_zt"]  = array('like',"%$this->_keyword%");
        $where["tx_shr"]  = array('like',"%$this->_keyword%");
        $where["tx_shsj"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['tx_zt']=array('eq',$zt);
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //提现审批
    function TxSp(){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $user_name=$globar_user->user_name;
        $id=I("id");
        $spxx=I("spxx");
        $txje=I("txje");
        if (!$id || !$spxx){
            echo "Info Error";
            exit();
        }
        $where["id"]=array("eq",$id);
        $AddData=D("usertxlog_tb");  //注意去除前缀
        //$AddData->username=I("username"); //用户名
        //$AddData->tx_je=I("txje"); //提现金额
        $AddData->tx_shsj=date("Y-m-d H:i:s"); //申请提现时间
        $AddData->tx_zt=$spxx; //1为申请，5为审核中，7为驳回，10为通过
        $AddData->tx_shr=$user_name;
        /*$AddData->tx_shr=I("tx_shr"); //审核人
        $AddData->tx_shsj=I("tx_shsj"); //审核时间*/
        $this->_ret=$AddData->where($where)->save();
        //echo $AddData->_sql();
        //echo $this->_ret;
        if ($spxx==7){
            $catTable=M("usercat_tb");
            $mapp["cat_type"]=array("eq",1);
            $mapp["cat_username"]=array("eq",I("username"));
            $ret=$catTable->where($mapp)->limit(1)->select();
            foreach ($ret as $catinfo){
                $catje=$catinfo['cat_dqje'];
            }
            $catTable->cat_dqje=$catje+$txje;
            $catTable->where($mapp)->save();
            //echo $catTable->_sql();
        }
    }
    //提现确认
    function Txqr(){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $user_name=$globar_user->user_name;
        $id=I("id");
        $spxx=I("spxx");
        $txje=I("txje");
        $username=I("user_name");
        $jy=C("Jyconfig");
        $Sxf=$jy["Sxf"]; //分享线直接收益
        $sjSxf=$txje*$Sxf;
        $txje=$txje-$sjSxf;
        if (!$id || !$spxx){
            echo "Info Error";
            exit();
        }
        $where["id"]=array("eq",$id);
        $AddData=D("usertxlog_tb");  //注意去除前缀
        $AddData->tx_sjdzje=$txje; //实际到帐金额
        //$AddData->tx_je=$txje; //提现金额
        $AddData->tx_fkqrsj=date("Y-m-d H:i:s"); //申请提现时间
        $AddData->tx_zt=$spxx; //1为申请，5为审核中，7为驳回，10为通过

        $this->_ret=$AddData->where($where)->save();
        //echo $AddData->_sql();
        //echo $this->_ret;
        if ($this->_ret>0){
            $catTable=M("usercat_tb");
            $mapp["cat_type"]=array("eq",3);
            //$mapp["cat_username"]=array("eq",I("username"));
            $ret=$catTable->where($mapp)->limit(1)->select();
            foreach ($ret as $catinfo){
                $catje=$catinfo['cat_dqje'];
            }
            $catTable->cat_dqje=$catje+$sjSxf;
            $catTable->where($mapp)->save();
            $mappp["cat_type"]=array("eq",1);
            $mappp["cat_username"]=array("eq",$username);
            $ret=$catTable->where($mappp)->limit(1)->select();
            $countwhere["username"]=array("eq",$username);
            $countwhere["tx_zt"]=array("eq",100);
            $count=M("usertxlog_tb")->where($countwhere)->count();
            //echo M("usertxlog_tb")->_sql();
            //echo $count;
            if ($count>0){
                $je=0;
            }else{
                $je=10000;
            }
            foreach ($ret as $catinfo){
                $catje=$catinfo['cat_dqje'];
            }
            $catTable->cat_dqje=$catje-$je;
            $catTable->where($mappp)->save();
            //echo $catTable->_sql();
        }
    }

    function loadtxinfodata($where){
        $TableName=M("usertxlog_tb");
        $this->_keyword=I("keyword");
        $where["username"]  = array('like',"%$this->_keyword%");
        $where["tx_je"]  = array('like',"%$this->_keyword%");
        //$where["tx_sj"]  = array('like',"%$this->_keyword%");
        $where["tx_zt"]  = array('eq',$this->_keyword);
        $where["tx_shr"]  = array('like',"%$this->_keyword%");
        //$where["tx_shsj"]  = array('like',"%$this->_keyword%");
        $where["tx_spyj"]  = array('like',"%$this->_keyword%");
        //$where["tx_fkqrsj"]  = array('like',"%$this->_keyword%");
        $where["tx_sjdzje"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
}