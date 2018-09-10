<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class QregAPI
{
    public $_page_size="100"; //每页显示条数
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
        $user->user_lx=3;
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
        $UTable=M("qx_user_tb");
        $uuwhere["user_name"]=array("eq",I("user_name"));
        $uret=$UTable->where($uuwhere)->select();
        /*var_export($uret);
        exit();*/
        foreach ($uret as $iinfo){
            $user_type=$iinfo["user_type"];
            $user_id=$iinfo["id"];
            $user_tjm=$iinfo["user_tjm"];
            $user_tjr=$iinfo["user_tjr"];
        }
        $AddData->user_name=I("user_name"); //用户名
        $AddData->user_id=$user_id; //用户ID
        $AddData->user_type=$user_type; //用户类型
        $AddData->jy_je=I("jy_je"); //交易金额
        //$AddData->jy_sj=date('Y-m-d H:i:s', time()); //交易时间
        $AddData->jy_sj=date('Y-m-d H:i:s',time()); //交易时间
        $AddData->user_tjm=$user_tjm; //推荐码
        $AddData->user_tjr=$user_tjr; //推荐人
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
        if ($user_type==1){ //分享线用户需要进行分学润
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
            $this->Zjsy($gxrusername,$gxrtjr,$gxrtype); //调用直接收收益
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
        }else{ //开市线用户无需进行分润

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
        if ($this->_jyinfo>0){ //以上信息保存成功后执行保存用户报单状态
            $UserTable=M("qx_user_tb");
            $uswhere["user_name"]=array("eq",I("user_name"));
            $UserTable->bd_zt=1;
            $UserTable->where($uswhere)->save();

            //核减报单员报单报单币信息
            $this->hjbdb(1000,I("user_name"));
            /*//核减贡献人信用帐户
            $this->ZjXy($gxrusername,30); //核减自己信用帐户*/
            //核减公司帐户
            $this->HjGsCat(3,30);

        }

    }
    //核减报单币封装
    function hjbdb($je,$bdry){
        //核减报单币帐户
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        $bdtable=M("bdcent_tb");
        $where["user_name"]=array("eq",$get_UserName);
        $dqje=$bdtable->where($where)->getField("dqje");
        $cljq=$dqje-$je;
        $bdtable->dqje=$cljq;
        $bdtable->where($where)->save();
        //加入日志记录
        $logtable=M("bdcent_log_tb");
        $logtable->user_name=$get_UserName;
        $logtable->jy_lx=10; //为报单
        $logtable->jy_je=$je;
        $logtable->jy_sj=date('Y-m-d H:i:s',time());
        $logtable->jt_dx=$bdry;
        $logtable->dq_je=$cljq;
        $logtable->jy_zt=100;
        $logtable->add();
        //增加报单员收益
        $this->bdysy($get_UserName,30);

    }
    //增加报单员收益
    function bdysy($name,$jyje){
        $CatTable=M("usercat_tb");
        $where["cat_username"]=array("eq",$name);
        $where["cat_type"]=array("eq",10);
        $count=$CatTable->where($where)->count(); //读取帐户状态

        if ($count==0){ //如帐户未启用
            $CatTable->cat_dqje=$jyje;
            $CatTable->cat_type=10;
            $CatTable->cat_username=$name;
            $CatTable->cat_zt=1;
            $CatTable->cat_sj=date('Y-m-d H:i:s',time());
            $ret=$CatTable->add();
        }
        else{
            $catdqje=$CatTable->where($where)->getField("cat_dqje"); //读取信用帐户当前金额
            $CatTable->cat_dqje=$catdqje+$jyje;
            $CatTable->cat_zt=1;
            $ret=$CatTable->where($where)->save();
        }
        //加入日志记录
        $logtable=M("bdcent_log_tb");
        $logtable->user_name=$name;
        $logtable->jy_lx=11; //为报单员收益
        $logtable->jy_je=$jyje;
        $logtable->jy_sj=date('Y-m-d H:i:s',time());
        //$logtable->jt_dx=$bdry;
        //$logtable->dq_je=$cljq;
        $logtable->jy_zt=100;
        $logtable->add();
        return $ret;
    }
    function Ksselect($gxrusername,$sjuserid,$shu){
        //echo $shu."<br />";
        $Qusertable=M("qx_user_tb");
        $userwhere["_string"]="FIND_IN_SET(id,getParLst($sjuserid)) ";
        $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(0,$shu)->select();
        $ksinfo=0;
        $syuserid=0;
        foreach ($Jjsyy as $userinfo ){
            if ($ksinfo==0){
                $shu=$shu-1;
            }
            if ($userinfo["user_type"]==2 && $ksinfo==0){
                $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                $ksinfo=1;
                $syuserid=$userinfo["id"];
                $syusername=$userinfo["user_name"];
                $syusertjr=$userinfo["user_tjr"];
            }

            //echo $shu."<br />";

        }
        //var_dump($Jjsyy);
        $i=0;
        if ($shu==0){
            $shu1=1;
        }
        /*echo $shu."<br />";
        exit();*/
        $uuwhere["user_tjm"]=array("eq",$syusertjr);
        $syuserid=$Qusertable->where($uuwhere)->getField("id");
        if ($syuserid!=0){
            if ($shu1==1){
                $userwhere["_string"]="FIND_IN_SET(id,getParLst($syuserid)) and user_type=2";
                $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(0,$shu1)->select();
            }else{
                $userwhere["_string"]="FIND_IN_SET(id,getParLst($syuserid))";
                $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(0,$shu+1)->select();
            }

            /*echo $Qusertable->_sql();
            var_export($Jjsyy);*/
            //exit();

            foreach ($Jjsyy as $Value){
                if ($shu1!=1){
                    if ($Value["user_type"]==2 && $i<$shu+1){
                        $this->Jjsy($gxrusername,$Value["user_tjr"],$Value["user_type"],500);
                        $syuserid=$Value["id"];
                    }

                }else{
                    if ($Value["user_type"]==2 && $i<$shu1){
                        $this->Jjsy($gxrusername,$Value["user_tjr"],$Value["user_type"],500);
                        $syuserid=$Value["id"];
                    }
                }

                //echo $i."<br />";
                $i=$i+1;
            }

            $Last=end($Jjsyy); //设置数组结束值
            //var_export($Last);
            echo $Last["user_type"];
            if ($Last["user_type"]==1 && $shu1!=1){
                $syuserid=$Last["id"];
                $userwhere["_string"]="FIND_IN_SET(id,getParLst($syuserid)) and user_type=2";
                $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(0,1)->select();
                foreach ($Jjsyy as $Value) {
                    $this->Jjsy($gxrusername, $Value["user_tjr"], $Value["user_type"], 500);
                }
            }
        }


        //如果在八级以内都没有开市线用户时需要找出最近的开市线用户，不再受级别限制
        if ($ksinfo==0){
            $userwhere1["_string"]="FIND_IN_SET(id,getParLst($sjuserid)) and user_type=2";
            $Jjsyy1=$Qusertable->where($userwhere1)->order("id desc")->limit(0,1)->select();
            foreach ($Jjsyy1 as $Value){
                if ($Value["user_type"]==2){
                    $this->Jjsy($gxrusername,$Value["user_tjr"],$Value["user_type"],1000);
                    $i=$i+1;
                }
                //echo $i."<br />";
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
    //核减公司帐户
    function HjGsCat($cattype,$je){
        $cattable=M("usercat_tb");
        $where["cat_type"]=array("eq",$cattype);
        $dqje=$cattable->where($where)->getField("cat_dqje");
        $catje=$dqje-$je;
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
        }else{ //开市线用户时
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
        /*$this->UserUP($syuserid,$gxrusername,9); //调用找出循环根用户*/
        $Qusertable=M("qx_user_tb");
        $userwhere["_string"]="FIND_IN_SET(id,getParLst($syuserid)) and id<=$syuserid";
        $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(2)->select();
        $jjwhere["user_type"]=array("eq",2);
        $Last=end($Jjsyy); //设置数组结束值
        $user_type="";
        $i=0;
        foreach($Jjsyy as $Key=>$Value) {
            $user_type.=$Value["user_type"].",";
            if ($Value["user_type"]==1) {
                $this->Jjsy($gxrusername,$Value["user_tjr"],$Value["user_type"],300);
            }else{
                if ($gxrtype==1 && $i==0){
                    $this->Jjsy($gxrusername,$Value["user_tjr"],$Value["user_type"],1000);
                    $i=1;
                    $ksinfo=1;
                }else{
                    $this->Jjsy($gxrusername,$Value["user_tjr"],$Value["user_type"],500);
                    $ksinfo=0;
                }
            }
            if ($Last === $Value) {
                $syname=$Value["user_name"]; //读取用户的类型
                $syuserid=$Value["id"]; //读取用户的类型
                $syusertjr=$Value["user_tjr"];
                $syusertype=$Value["user_type"];
            }
        }
        //读取上一级级用户
        $uuwhere["user_tjm"]=array("eq",$syusertjr);
        $Jj1syy=$Qusertable->where($uuwhere)->order("id desc")->limit(1)->select();
        foreach($Jj1syy as $Key=>$Value) {
            //$syname=$Value["user_name"]; //读取用户的类型
            $syuserid=$Value["id"]; //读取用户的类型
            $syusertjr=$Value["user_tjr"];
            $syusertype=$Value["user_type"];
        }
        $str=$user_type;
        $maxcount=0;
        $maxcount=substr_count($str,'2');
        $mincount=$gxrtype;
        if ($mincount==1){
        }else{
            $mincount=1;
            $maxcount=$mincount+$maxcount;
        }
        $shuu=6-$maxcount; //最大收益级别，在以上已计算三级，所以在此为6级，共计9级信息
        $i=0; //I从0开始计算

        //echo $maxcount;
        if ($gxrtype==1){ //分享线
            //echo $maxcount;
            if ($maxcount==0){
                $this->Ksselect($gxrusername,$syuserid,$shuu);
            }else{
                $shuu=$shuu+3;
                //echo $shuu."<br />";
                $userwhere["_string"]="FIND_IN_SET(id,getParLst($syuserid))";
                $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(0,$shuu)->select();

                foreach ($Jjsyy as $Value){
                    if ($Value["user_type"]==2 && $i<=$shuu){
                        $this->Jjsy($gxrusername,$Value["user_tjr"],$Value["user_type"]);

                    }
                    //echo $i."<br />";
                    $i=$i+1;
                }
            }
        }else{
            $shuu=$shuu+3;
            //echo $shuu."<br />";

            $userwhere["_string"]="FIND_IN_SET(id,getParLst($syuserid))";
            $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(0,$shuu)->select();
            foreach ($Jjsyy as $Value){
                if ($Value["user_type"]==2 && $i<=$shuu){
                    $this->Jjsy($gxrusername,$Value["user_tjr"],$Value["user_type"]);

                }
                //echo $i."<br />";
                $i=$i+1;
            }
        }
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
    /*//封装用户循环根的类型
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
    }*/
    /*//间接收益循环
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
            $Last=end($Jjsyy); //设置数组结束值
            $i=0;
            foreach ($Jjsyy as $userinfo){
                if ($userinfo["user_type"]==2 && $gxrtype==1){
                    $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                    $gxrtype=2;
                }elseif ($userinfo["user_type"]==2 && $gxrtype==2 && $i<9){
                    $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"]);
                    $i=$i+1;
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
            $Jjsyy=$Qusertable->where($getuuwhere)->order("id desc")->select(); //循环两次读取可能出现的分享用户
            //echo $Qusertable->_sql();
            //var_export($Jjsyy);
            $I=0;
            foreach ($Jjsyy as $userinfo){
                if ($userinfo["user_type"]==2){ //开市线用户收取收益
                    if ($userinfo["user_type"]==2 && $gxrtype==1){
                        $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                        $gxrtype=2;
                    }elseif ($userinfo["user_type"]==2 && $gxrtype==2 && $I<9){
                        $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"]);
                        $I=$I+1;
                    }
                }
            }

        }else{ //处理开市线用户收益
            $Jjsyy=$Qusertable->where($userwhere)->order("id desc")->limit(2)->select(); //循环两次读取可能出现的分享用户
            $Last=end($Jjsyy); //设置数组结束值
            $i=0;
            foreach ($Jjsyy as $userinfo){
                if ($userinfo["user_type"]==2 && $gxrtype==1){
                    $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                    $gxrtype=2;
                }elseif ($userinfo["user_type"]==2 && $gxrtype==2 && $i<9){
                    $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"]);
                    $i=$i+1;
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
            $Jjsyy=$Qusertable->where($getuuwhere)->order("id desc")->select(); //循环两次读取可能出现的分享用户
            //echo $Qusertable->_sql();
            //var_export($Jjsyy);
            $I=0;
            foreach ($Jjsyy as $userinfo){
                if ($userinfo["user_type"]==2){ //开市线用户收取收益
                    if ($userinfo["user_type"]==2 && $gxrtype==1){
                        $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"],1000);
                        $gxrtype=2;
                    }elseif ($userinfo["user_type"]==2 && $gxrtype==2 && $I<9){
                        $this->Jjsy($gxrusername,$userinfo["user_tjr"],$userinfo["user_type"]);
                        $I=$I+1;
                    }
                }
            }
        }
    }*/

    function loadJydata(){
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
    function loadQJydata(){
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
    function loadsydata(){
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
    function loadjfinfo(){
        $TableName=M("usercat_tb");
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $username=$globar_user->user_name;
        $where["cat_type"]  = array('eq',4);
        $where["cat_username"]  = array('eq',$username);
        //加载主表数据
        $this->_main_data=$TableName->where($where)->order("id DESC")->select();
        //var_export($ret);

    }
    function loadcatdata(){
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
    //积分帐户
    function loadjfcatdata(){
        $TableName=M("usercat_tb");
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $username=$globar_user->user_name;

        $where["cat_type"]  = array('eq',10);
        $where["cat_username"]  = array('eq',$username);
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成

        //当天收益计算
        $Sytable=M("bdcent_log_tb");
        $map["user_name"]=array("eq",$username);
        //$map["syr_day"]=array("elt",date('Y-m-d',strtotime('-1 day')));
        $map["jy_sj"]=array("eq",date('Y-m-d',time()));
        /*$map['_logic']='and';
        $mmmap['_complex']=$map;
        $map["syr_name"]=array("eq",$username);
        $mmmap["syr_day"]=array("eq",date('Y-m-d',strtotime('-1 day')));
        $mmmap['_logic']='or';*/
        $this->_sdje=$Sytable->where($map)->sum("jy_je");
        if (!$this->_sdje){
            $this->_sdje=0;
        }
    }
    function loadQjyinfodata(){
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
    function loadQsydata(){
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
        $ret=$Table->where("user_lx=3")->order("id")->getField('id,user_pid,concat(user_name,user_xm) as text,state');
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
    //报单积分转报单币操作
    function Bdjfbdb(){
        //接收变量
        $zhje=I("zhje");
        $txje=I("txje");
        $ktxje=I("ktxje");
        $username=I("username");
        if ($ktxje<$txje) {
            redirect('/home/Quser/jfbcat_list', 1, '非法操作，金额不符合规则...');
            exit();
        }
        //判断用户有无提现成功
        $countwhere["username"]=array("eq",$username);
        $countwhere["tx_zt"]=array("eq",100);
        $count=M("usertxlog_tb")->where($countwhere)->count();
        if ($count==0){ //如没有提现成功记录，减少用户帐户中的授信额度
            $catTable=M("usercat_tb");
            $mappp["cat_type"]=array("eq",1);
            $mappp["cat_username"]=array("eq",$username);
            $userdqje=$catTable->where($mappp)->getField("cat_dqje");
            $catTable->cat_dqje=$userdqje-10000;
            $ret=$catTable->where($mappp)->save();
            if ($ret>0){
                //保存用户信用帐户减少记录
                $AddData=M("usertxlog_tb");  //注意去除前缀
                $AddData->username=I("username"); //用户名
                $AddData->tx_je=10000; //提现金额
                $AddData->tx_sj=date("Y-m-d H:i:s"); //申请提现时间
                $AddData->tx_zt=100; //1为申请，5为审核中，7为驳回，10为通过
                $AddData->tx_lx=91;
                $this->_ret=$AddData->add();
            }
        }
        //检查用户当前帐户金额
        $catTable=M("usercat_tb");
        $mappp1["cat_type"]=array("eq",10);
        $mappp1["cat_username"]=array("eq",$username);
        $user1dqje=$catTable->where($mappp1)->getField("cat_dqje");
        if ($user1dqje<$txje){
            redirect('/home/Quser/jfbcat_list', 1, '非法操作，金额不符合规则...');
            exit();
        }
        //减少积分帐户信息
        $catTable=M("usercat_tb");
        $where["cat_type"]=array("eq",10);
        $where["cat_username"]=array("eq",I("username"));
        $user1dqje=$catTable->where($where)->getField("cat_dqje");
        $catTable->cat_dqje=$user1dqje-I("txje");
        $catTable->where($where)->save();
        //保存用户提现记录
        $AddData=M("usertxlog_tb");  //注意去除前缀
        $AddData->username=I("username"); //用户名
        $AddData->tx_je=I("txje"); //提现金额
        $AddData->tx_sj=date("Y-m-d H:i:s"); //申请提现时间
        $AddData->tx_zt=100; //1为申请，5为审核中，7为驳回，10为通过,99为通过
        $AddData->tx_lx=95; //95为报单积分转报单币
        $this->_ret=$AddData->add();
        //增加报单币帐户
        $bdcent=M("bdcent_tb");
        $uswhere["user_name"]=array("eq",I("username"));
        $dqje=$bdcent->where($uswhere)->getField("dqje");
        $jyje=I("txje");

        if (!$dqje){
            $bdcent->user_name=I("username");
            $bdcent->dqje=$jyje;
            $bdcent->sj=date("Y-m-d H:i:s");
            $bdcent->add();
        }else{
            $dqje=$jyje+$dqje;
            $bdcent->dqje=$dqje;
            $bdcent->where($uswhere)->save();
        }
    }
    function  BdbZcNew(){
        //接收变量
        $zhje=I("zhje");
        $txje=I("txje");
        $ktxje=I("ktxje");
        $username=I("username");
        if ($ktxje<$txje) {
            redirect('/home/Quser/xjbdbcat_list', 1, '非法操作，金额不符合规则...');
            exit();
        }
        //检查用户当前帐户金额
        $catTable=M("usercat_tb");
        $mappp1["cat_type"]=array("eq",1);
        $mappp1["cat_username"]=array("eq",$username);
        $user1dqje=$catTable->where($mappp1)->getField("cat_dqje");
        if ($user1dqje<$txje){
            redirect('/home/Quser/xjbdbcat_list', 1, '非法操作，金额不符合规则...');
            exit();
        }
        //判断用户有无提现成功
        $countwhere["username"]=array("eq",$username);
        $countwhere["tx_zt"]=array("eq",100);
        $count=M("usertxlog_tb")->where($countwhere)->count();
        if ($count==0){ //如没有提现成功记录，减少用户帐户中的授信额度
            $catTable=M("usercat_tb");
            $mappp["cat_type"]=array("eq",1);
            $mappp["cat_username"]=array("eq",$username);
            $userdqje=$catTable->where($mappp)->getField("cat_dqje");
            $catTable->cat_dqje=$userdqje-10000;
            $ret=$catTable->where($mappp)->save();
            if ($ret>0){
                //保存用户信用帐户减少记录
                $AddData=M("usertxlog_tb");  //注意去除前缀
                $AddData->username=I("username"); //用户名
                $AddData->tx_je=10000; //提现金额
                $AddData->tx_sj=date("Y-m-d H:i:s"); //申请提现时间
                $AddData->tx_zt=100; //1为申请，5为审核中，7为驳回，10为通过
                $AddData->tx_lx=91;
                $this->_ret=$AddData->add();
            }

        }
        //保存用户提现记录
        $AddData=M("usertxlog_tb");  //注意去除前缀
        $AddData->username=I("username"); //用户名
        $AddData->tx_je=I("txje"); //提现金额
        $AddData->tx_sj=date("Y-m-d H:i:s"); //申请提现时间
        $AddData->tx_zt=100; //1为申请，5为审核中，7为驳回，10为通过
        $AddData->tx_lx=90;
        $this->_ret=$AddData->add();

        //减少现金帐户信息
        $catTable=M("usercat_tb");
        $where["cat_type"]=array("eq",1);
        $where["cat_username"]=array("eq",I("username"));
        $user1dqje=$catTable->where($where)->getField("cat_dqje");
        $catTable->cat_dqje=$user1dqje-I("txje");
        $catTable->where($where)->save();

        //增加报单币帐户
        $bdcent=M("bdcent_tb");
        $uswhere["user_name"]=array("eq",I("username"));
        $dqje=$bdcent->where($uswhere)->getField("dqje");
        $jyje=I("txje")*0.65;

        if (!$dqje){
            $bdcent->user_name=I("username");
            $bdcent->dqje=$jyje;
            $bdcent->sj=date("Y-m-d H:i:s");
            $bdcent->add();
        }else{
            $dqje=$jyje+$dqje;
            $bdcent->dqje=$dqje;
            $bdcent->where($uswhere)->save();
        }
        //处理公司帐户
        $catTable=M("usercat_tb");
        $mapp["cat_type"]=array("eq",3);
        //$mapp["cat_username"]=array("eq",I("username"));
        $ret=$catTable->where($mapp)->limit(1)->select();
        foreach ($ret as $catinfo){
            $catje=$catinfo['cat_dqje'];
        }
        $sjSxf=I("txje")*0.15;
        $clje=$catje+$sjSxf;
        $logje=$sjSxf;

        $catTable->cat_dqje=$clje;
        $catTable->where($mapp)->save();
        //处理个人商城积分信息
        $username=I("username");
        $sjshop=I("txje")*0.20;
        $mapppp["cat_type"]=array("eq",4);
        $mapppp["cat_username"]=array("eq",I("username"));
        $catcount=$catTable->where($mapppp)->limit(1)->count();
        if ($catcount==0){
            $catTable->cat_dqje=$sjshop;
            $catTable->cat_type=4;
            $catTable->cat_zt=1;
            $catTable->cat_sj=date("Y-m-d H:i:s");
            $catTable->cat_username=$username;
            $catTable->add();
        }else{
            $getdqje=$catTable->where($mapppp)->getField("cat_dqje");
            $catTable->cat_dqje=$sjshop+$getdqje;
            $catTable->where($mapppp)->save();
        }
        //增加公司帐户变动日志
        $logTable=M("usertxlog_tb");
        $logTable->username='GS';
        $logTable->tx_fkqrsj=date("Y-m-d H:i:s");
        $logTable->tx_je=$logje;
        $logTable->add();
    }

    //报单币转出
    function BdbzcSubInfo(){
        $zhje=I("zhje");
        $txje=I("txje");
        $ktxje=I("ktxje");
        if ($ktxje<$txje) {
            redirect('/home/Quser/xjcat_list', 1, '非法操作，金额不符合规则...');
            exit();
        }
        $AddData=M("usertxlog_tb");  //注意去除前缀

        $AddData->username=I("username"); //用户名
        $AddData->tx_je=I("txje"); //提现金额
        $AddData->tx_sj=date("Y-m-d H:i:s"); //申请提现时间
        $AddData->tx_zt=100; //1为申请，5为审核中，7为驳回，10为通过
        /*$AddData->tx_shr=I("tx_shr"); //审核人
        $AddData->tx_shsj=I("tx_shsj"); //审核时间*/
        //$this->_ret=$AddData->add();
        //echo $this->_ret;

            //减少现金帐户信息
            $catTable=M("usercat_tb");
            $where["cat_type"]=array("eq",1);
            $where["cat_username"]=array("eq",I("username"));
            $catTable->cat_dqje=$zhje-I("txje");
            $catTable->where($where)->save();
            //增加报单币帐户
            $bdcent=M("bdcent_tb");
            $uswhere["user_name"]=array("eq",I("username"));
            $dqje=$bdcent->where($uswhere)->getField("dqje");
            $jyje=I("txje")*0.65;

            if (!$dqje){
                $bdcent->user_name=I("username");
                $bdcent->dqje=$jyje;
                $bdcent->sj=date("Y-m-d H:i:s");
                $bdcent->add();
            }else{
                $dqje=$jyje+$dqje;
                $bdcent->dqje=$dqje;
                $bdcent->where($uswhere)->save();
            }
            //处理公司帐户
            $catTable=M("usercat_tb");
            $mapp["cat_type"]=array("eq",3);
            //$mapp["cat_username"]=array("eq",I("username"));
            $ret=$catTable->where($mapp)->limit(1)->select();
            foreach ($ret as $catinfo){
                $catje=$catinfo['cat_dqje'];
            }
            $sjSxf=I("txje")*0.15;
            $clje=$catje+$sjSxf;
            $logje=$sjSxf;

            $catTable->cat_dqje=$clje;
            $catTable->where($mapp)->save();
            //处理个人商城积分信息
            $username=I("username");
            $sjshop=I("txje")*0.20;
            $mapppp["cat_type"]=array("eq",4);
            $mapppp["cat_username"]=array("eq",I("username"));
            $catcount=$catTable->where($mapppp)->limit(1)->count();
            if ($catcount==0){
                $catTable->cat_dqje=$sjshop;
                $catTable->cat_type=4;
                $catTable->cat_zt=1;
                $catTable->cat_sj=date("Y-m-d H:i:s");
                $catTable->cat_username=$username;
                $catTable->add();
            }else{
                $getdqje=$catTable->where($mapppp)->getField("cat_dqje");
                $catTable->cat_dqje=$sjshop+$getdqje;
                $catTable->where($mapppp)->save();
            }
            //增加公司帐户变动日志
            $logTable=M("usertxlog_tb");
            $logTable->username='GS';
            $logTable->tx_fkqrsj=date("Y-m-d H:i:s");
            $logTable->tx_je=$logje;
            $logTable->add();
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
            $this->_ret=$AddData->add();
            //$this->_ret=$AddData->where($where)->save();
            foreach ($ret as $catinfo){
                $catje=$catinfo['cat_dqje'];
            }
            $catTable->cat_dqje=$catje-$je;
            $catTable->where($mappp)->save();
    }

    //积分提现申请
    function JfTxSubInfo(){
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
            $AddData->tx_lx=10;
            /*$AddData->tx_shr=I("tx_shr"); //审核人
            $AddData->tx_shsj=I("tx_shsj"); //审核时间*/
            $this->_ret=$AddData->add();
            //echo $this->_ret;
            if ($this->_ret>0){
                $catTable=M("usercat_tb");
                $where["cat_type"]=array("eq",10);
                $where["cat_username"]=array("eq",I("username"));
                $catTable->cat_dqje=$zhje-I("txje");
                $catTable->where($where)->save();
            }
        }

    }

    //提现记录表
    function loadTxmatedata(){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $user_name=$globar_user->user_name;
        $TableName=M("usertxlog_tb");
        $this->_keyword=I("keyword");

        $where["username"]  = array('eq',"$user_name");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        //$mmmap['jy_zt']=array('eq',$zt);
        $mmmap["jy_lx"]  = array('eq',0);  //类型
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //报单币审批表
    function bdblist($zt,$lx){
        $TableName=M("bdcent_log_tb");
        $this->_keyword=I("keyword");
        $where["user_name"]  = array('like',"%$this->_keyword%");  //用户名
        //$where["jy_lx"]  = array('like',"%$this->_keyword%");  //类型
        $where["jy_je"]  = array('like',"%$this->_keyword%");  //金额
        $where["jy_sj"]  = array('like',"%$this->_keyword%");  //交易时间
        $where["jt_dx"]  = array('like',"%$this->_keyword%");  //交易对像
        $where["dq_je"]  = array('like',"%$this->_keyword%");  //当前金额
        //$where["jy_zt"]  = array('like',"%$this->_keyword%");  //交易状态
        $where["bdr"]  = array('like',"%$this->_keyword%");  //报单人
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['jy_zt']=array('eq',$zt);
        $mmmap["jy_lx"]  = array('eq',$lx);  //类型
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //提现审批表
    function loadTxdata($zt,$lx){
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
        $mmmap['tx_lx']=array('eq',$lx);
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
    //报单审批
    function BdSp(){
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
        $AddData=D("bdcent_log_tb");  //注意去除前缀
        //$AddData->username=I("username"); //用户名
        //$AddData->tx_je=I("txje"); //提现金额
        $AddData->tx_shsj=date("Y-m-d H:i:s"); //申请提现时间
        $AddData->jy_zt=$spxx; //1为申请，5为审核中，7为驳回，10为通过
        $AddData->tx_shr=$user_name;
        /*$AddData->tx_shr=I("tx_shr"); //审核人
        $AddData->tx_shsj=I("tx_shsj"); //审核时间*/
        $this->_ret=$AddData->where($where)->save();
        //echo $AddData->_sql();
        //echo $this->_ret;
        if ($spxx==7){
            $catTable=M("bdcent_tb");
            $mapp["user_name"]=array("eq",I("username"));
            $ret=$catTable->where($mapp)->limit(1)->select();
            foreach ($ret as $catinfo){
                $catje=$catinfo['dqje'];
            }
            $catTable->dqje=$catje+$txje;
            $catTable->where($mapp)->save();
            echo $catTable->_sql();
        }
    }

    //报单确认
    function Bdqr(){
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
        $AddData=D("bdcent_log_tb");  //注意去除前缀
        //$AddData->username=I("username"); //用户名
        //$AddData->tx_je=I("txje"); //提现金额
        $AddData->tx_shsj=date("Y-m-d H:i:s"); //申请提现时间
        $AddData->jy_zt=$spxx; //1为申请，5为审核中，7为驳回，10为通过
        $AddData->tx_shr=$user_name;
        /*$AddData->tx_shr=I("tx_shr"); //审核人
        $AddData->tx_shsj=I("tx_shsj"); //审核时间*/
        $this->_ret=$AddData->where($where)->save();
        //echo $AddData->_sql();
        //echo $this->_ret;
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
        $Sxf=$jy["Sxf"];
        $shop=$jy["shop"];
        $sjSxf=$txje*$Sxf;
        $sjshop=$txje*$shop;
        $txje=$txje-$sjSxf-$sjshop;
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


        //echo $AddData->_sql();
        //echo $this->_ret;
        $catTable=M("usercat_tb");
        $mapp["cat_type"]=array("eq",3);
        //$mapp["cat_username"]=array("eq",I("username"));
        $ret=$catTable->where($mapp)->limit(1)->select();
        foreach ($ret as $catinfo){
            $catje=$catinfo['cat_dqje'];
        }
        $clje=$catje+$sjSxf-$txje;
        $logje=$txje-$sjSxf;

        $catTable->cat_dqje=$clje;
        $catTable->where($mapp)->save();

        //增加公司帐户变动日志
        $logTable=M("usertxlog_tb");
        $logTable->username='GS';
        $logTable->tx_fkqrsj=date("Y-m-d H:i:s");
        $logTable->tx_je=$logje;
        $logTable->add();
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
        $this->_ret=$AddData->where($where)->save();
        foreach ($ret as $catinfo){
            $catje=$catinfo['cat_dqje'];
        }
        $catTable->cat_dqje=$catje-$je;
        $catTable->where($mappp)->save();
        //echo $catTable->_sql();
        $mapppp["cat_type"]=array("eq",4);
        $mapppp["cat_username"]=array("eq",$username);
        $catcount=$catTable->where($mapppp)->limit(1)->count();
        if ($catcount==0){
            $catTable->cat_dqje=$sjshop;
            $catTable->cat_type=4;
            $catTable->cat_zt=1;
            $catTable->cat_sj=date("Y-m-d H:i:s");
            $catTable->cat_username=$username;
            $catTable->add();
        }else{
            $getdqje=$catTable->where($mapppp)->getField("cat_dqje");
            $catTable->cat_dqje=$sjshop+$getdqje;
            $catTable->where($mapppp)->save();
        }
    }

    //报单员确认
    function Bdyqr(){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $user_name=$globar_user->user_name;
        $id=I("id");
        $spxx=I("spxx");
        $txje=I("txje");
        $username=I("user_name");
        $jy=C("Jyconfig");
        $Sxf=$jy["Sxf"];
        $shop=$jy["shop"];
        $sjSxf=$txje*$Sxf;
        $sjshop=$txje*$shop;
        $txje=$txje;
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
    }

    function loadtxinfodata(){
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
        $mmmap['_complex']=$where;
        //$mmmap['tx_zt']=array('eq',$zt);
        $mmmap['username']=array('neq',"GS");
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //报单中心日志查询
    function bdcentlog($lx){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        $logtable=M("bdcent_log_tb");
        $where["jy_lx"]=array("eq",$lx);
        $where["user_name"]=array("eq",$get_UserName);
        //加载主表数据
        $this->_page_count=$count=$logtable->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,15);
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$logtable->where($where)->order("id desc")->LIMIT($Page->firstRow.','.$Page->listRows)->select();
        //var_export($this->_main_data);
    }
}