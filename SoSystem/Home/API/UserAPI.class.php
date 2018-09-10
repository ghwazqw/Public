<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class UserAPI
{
	public $_page_size="100"; //每页显示条数
	public $_page_bar=""; //分布组件需要展示的内容
	public $_page_count=""; //统计数量
	public $_main_data=array(); //主表数据
	public $_dateil_data=array();  //子表数据
	public $_keyword=""; //
	public $_class_data="";
	public $_class_meta_data="";
	public $_xmbh="";
	public $actionInfo=""; //返回要执行的动作
    public $_info="";
    public $_zt="";
    public $_xjname="";
    public $_MetaBdInfo="";
    public $_MetaGxInfo="";
    public $_MetaSyInfo="";
    public $_MetaCatInfo="";
    public $_ft=0;
    public $_zsy=0;
    public $_ztx=0;
    public $_ftzt=0;

    function SelectRyInfo(){
        $TableName=M("qx_user_tb");
        $this->_keyword=I("keyword");
        $where["user_name"]  = array('eq',"$this->_keyword");
        $where["user_sfzh"]  = array('eq',"$this->_keyword");
        $where['_logic']='OR';
        $getusername=$TableName->where($where)->getField("user_xm"); //主表数据取值完成
        if (!$getusername){
            echo "0";
        }else{
            echo $getusername;
        }

    }
	function Userredit(){
        $id=I("id");
        $user=D("qx_user_tb");
        /*$user->user_role=I("role_name");
        $user->user_roleid=I("user_role");*/
        $user->user_xm=I("user_xm");
        $user->user_sj=I("user_sj");
        $user->user_sfzh=I("user_sfzh");
        $user->where("id=$id")->save();
        redirect('/home/user/Qr_manage',1, '用户信息编辑成功,正在返回...');
    }
    function loadRyuandata(){
        $TableName=M("ryxx_tb");
        $ry_zt=I("ry_zt");
        $this->_keyword=I("keyword");
        $this->_zt=$ry_zt;
            $where["ry_xm"]  = array('like',"%$this->_keyword%");
            $where["ry_zw"]  = array('like',"%$this->_keyword%");
            $where["ry_bm"]  = array('like',"%$this->_keyword%");
            $where["ry_ks"]  = array('like',"%$this->_keyword%");
            $where["ry_fjh"]  = array('like',"%$this->_keyword%");
            $where["ry_bgdh"]  = array('like',"%$this->_keyword%");
            $where["ry_sjhm"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
            if ($ry_zt!=""){
                $where['_complex']=$where;
                $where['ry_zt']=array('eq',$ry_zt);
                $where['_logic']='AND';
            }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("ry_zt desc,ry_bm")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
	//获取用户登录后的信息对象

	function getuser(){
		$get_logincook=$_COOKIE['user_info'];
		if (!$get_logincook) return false; //
		$get_user_log=unserialize($get_logincook);
		if (!$get_user_log) return false;
		if ($get_user_log->user_id && intval($get_user_log->user_id)>0){
			return $get_user_log;
		}
		return false;
	}
	function isLogin(){
     //判断用户是否登录
		$u=$this->getuser();
        if ($u->user_id && intval($u->user_id)>0){
			return true;
		}
	}
	//读取单个用户信息
	function loaduserinfo(){
        $get_logincook = $_COOKIE['user_info'];
        if (!$get_logincook) return false; //
        $get_user_log = unserialize($get_logincook);
        if (!$get_user_log) return false;
        if ($get_user_log->user_id && intval($get_user_log->user_id) > 0) {
            $username=$get_user_log->user_name;
        }
        $usertable=M("qx_user_tb");
        $where["user_name"]=array("eq",$username);
        $getbdpassword=$usertable->where($where)->limit(0,1)->getField("txpassword");
        //echo $getbdpassword;
        if (!$getbdpassword){
            //echo "需要设备密码";
            $this->_zt=0;
        }else{
            $this->_zt=1;
        }
    }
    function SetTxPass(){
        $usertable=D("qx_user_tb");
        $ph=new PasswordHash(8, FALSE);
        $user_name=I("user_name");
        $pass=I("textPwd");
            //echo 1;
            $where["user_name"]=array("eq",$user_name);
                $usertable->txpassword=$ph->HashPassword($pass);
                $ret=$usertable->where($where)->save();
                echo $ret;
                if ($ret>0){
                    $this->_zt=1;
                }else{
                    $this->_zt=0;
                }
    }
	function  add_user(){
		$user=D("qx_user_tb");
		$ph=new PasswordHash(8, FALSE);
		try{
			if($_POST){
				$user->user_name=I("user_name");
				$user->user_pwd=$ph->HashPassword(I("user_pwd"));
				$user->user_regdate=date('Y-m-d h:i:s');
				$user->user_sfyx=1;
				$user->user_lx=1;
                $user->user_xm=I("user_xm");
                $user->user_comp=I("user_comp");
                $user->user_ks=I("user_ks");
                $user->user_zw=I("user_zw");
                $user->user_ryid=I("user_id");
                $user->user_role=I("role_name");
                $user->user_roleid=I("user_role");
				$ret=$user->add();
				if($ret){
				    $user_id=I("user_id");
				    if ($user_id!=""){
                        $EditTable=D("ryxx_tb");
                        $EditTable->user_name=I("user_name");
                        $EditTable->ry_yh=1;
                        $EditTable->where("id=$user_id")->save();
                        //$this->success('用户增加成功','/home/user/ryuan_manage',1);
                        redirect('/home/user/ryuan_manage',1, '用户增加成功,正在返回...');
                    }
                    else{
                        //$this->actionInfo='{$this->assign("sussInfo","用户增加成功，请继续！");}';
                        //$this->actionInfo="header('location:/index.php/home/user/U_manage');";
                        redirect('/home/user/U_manage',1, '用户增加成功,正在返回...');
                    }

				}
				else
				{
					$this->actionInfo='{$this->assign("sussInfo","增加失败，请继续！");}';
				}
			}
		}
		catch(\Think\Exception $ex){
			$ex->getMessage();
			$this->actionInfo='{$this->assign("errorInfo","该用户名被占用，请检查！");}';
		}

	}
	function Useredit(){
        $id=I("id");
        $user=D("qx_user_tb");
        $user->user_role=I("role_name");
        $user->user_roleid=I("user_role");
        $user->where("id=$id")->save();
        redirect('/Home/user/U_manage',1, '用户编辑成功,正在返回...');
    }
    function Userbdzx($type){
        $id=I("id");
        if (!$id){
            exit("ID Error");
        }

        $user=D("qx_user_tb");
        $user->bdcore=$type;
        $user->where("id=$id")->save();
        redirect('/home/user/Quser_bdzxManage',1, '操作成功,正在返回列表...');
    }


	function loadmatedata($lx){
        $this->_keyword=I("keyword");
            $where["user_xm"]  = array('like',"%$this->_keyword%");
            $where["user_zw"]  = array('like',"%$this->_keyword%");
            $where["user_comp"]  = array('like',"%$this->_keyword%");
            $where["user_role"]  = array('like',"%$this->_keyword%");
            $where["user_ks"]  = array('like',"%$this->_keyword%");
            $where["user_bgdh"]  = array('like',"%$this->_keyword%");
            //$where["user_sj"]  = array('like',"%$this->_keyword%");
            $where["user_yx"]  = array('like',"%$this->_keyword%");
            $where["user_ryid"]  = array('eq',$this->_keyword);
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
            $mmmap['user_lx']=array('eq',$lx);
            $mmmap['_logic']='AND';
		//加载主表数据
		$this->_page_count=$count=M("qx_user_tb")->where($mmmap)->order("id DESC")->count();
		$Page = new \Think\Page($count,"40");

		$this->_page_bar=$Page->show(); //把分布内容赋值给变量
		$this->_main_data=$ret=M("qx_user_tb")->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
		//echo M("qx_user_tb")->getLastSql();
	}
    function loadQuserdata($lx){
        $this->_keyword=I("keyword");
            $where["user_name"]  = array('like',"$this->_keyword%");
            $where["user_sfzh"]  = array('eq',"$this->_keyword");
            $where["user_xm"]  = array('like',"$this->_keyword%");
            $where["user_zw"]  = array('like',"%$this->_keyword%");
            $where["user_comp"]  = array('like',"%$this->_keyword%");
            $where["user_role"]  = array('like',"%$this->_keyword%");
            $where["user_ks"]  = array('like',"%$this->_keyword%");
            $where["user_bgdh"]  = array('like',"%$this->_keyword%");
            //$where["user_sj"]  = array('like',"%$this->_keyword%");
            $where["user_yx"]  = array('like',"%$this->_keyword%");
            $where["user_ryid"]  = array('eq',$this->_keyword);
            $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['user_lx']=array('eq',$lx);
        //$mmmap['user_tjm']=array('neq',"");
        $mmmap['user_tjr']=array('neq',"");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=M("qx_user_tb")->where($mmmap)->order("id DESC")->count();

        //echo $this->_page_count;
        $Page = new \Think\Page($count,$this->_page_size);
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("qx_user_tb")->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("qx_user_tb")->getLastSql();
    }
    //读取未报单人员信息
    function loadWbduserdata(){
        $this->_keyword=I("keyword");
        $mmmap['user_lx']=array('eq',3);
        //$mmmap['user_tjm']=array('neq',"");
        $mmmap['user_tjr']=array('neq',"");
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=M("qx_user_tb")->where($mmmap)->order("id DESC")->count();
        $this->_main_data=$ret=M("qx_user_tb")->where($mmmap)->order("id DESC")->select(); //主表数据取值完成
        //var_export($this->_main_data);
        //echo M("qx_user_tb")->getLastSql();
    }
    //按照报单人读取未报单人员信息
    function LoadWbdRyinfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_userid = $globar_user->user_id;
        $Qusertable=M("qx_user_tb");
        $userwhere["_string"]="FIND_IN_SET(id,getDarLst($get_userid)) and id>$get_userid and bd_zt=0 and user_xm!=''";
        //$userwhere[""]=array("eq",);
        $this->_main_data=$Qusertable->where($userwhere)->order("id desc")->select();
        //echo $Qusertable->_sql();
    }

    function LoadBdUserdata($lx){
        $this->_keyword=I("keyword");
        $mmmap['bdcore']=array('eq',$lx);
        //$mmmap['user_tjm']=array('neq',"");
        //$mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=M("qx_user_tb")->where($mmmap)->order("id DESC")->count();
        //echo M("qx_user_tb")->_sql();

        //echo $this->_page_count;
        $Page = new \Think\Page($count,"40");
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("qx_user_tb")->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("qx_user_tb")->getLastSql();
    }
    function loadQuserMetadata(){
        $this->_keyword=I("info");
        $where["user_name"]  = array('eq',$this->_keyword);
        $this->_main_data=$ret=M("qx_user_tb")->where($where)->order("id DESC")->select(); //主表数据取值完成
        //echo M("qx_user_tb")->getLastSql();
    }
    function ChTxPwd(){
        $get_UserName = I("Username"); //接收用户名信息
        $get_UserPwd = I("textPwd");  //接收密码
        $result=M("qx_user_tb")->where("user_name='".$get_UserName."' ")->limit(1)->select(); //取出用户信息
        $user_pwd=$result[0]["txpassword"];
        $ph=new PasswordHash(8, FALSE);
        if ($ph->CheckPassword($get_UserPwd,$user_pwd) ){
            echo "1";
        }else{
            echo "0";
        }
    }
    function txcl($username,$je){
        $catTable=M("usercat_tb");
        $mappp["cat_type"]=array("eq",1);
        $mappp["cat_username"]=array("eq",$username);
        $dqje=$catTable->where($mappp)->getField("cat_dqje");
        $catTable->cat_dqje=$dqje-$je;
        echo $username.":".$je."<br />";
        $catTable->where($mappp)->save();
        //处理公司帐户
       /* $mapppm["cat_type"]=array("eq",3);
        $gddqje=$catTable->where($mapppm)->getField("cat_dqje");
        $clje=$je*0.65;
        $sxf=$je*0.15;
        $sjje=$clje-$sxf;
        echo $username.":".$je."<br />";
        $catTable->cat_dqje=$gddqje-$sjje;
        $catTable->where($mapppm)->save();*/
    }
    function txcl1($username,$je){
        $catTable=M("usercat_tb");
        $mappp["cat_type"]=array("eq",1);
        $mappp["cat_username"]=array("eq",$username);
        $dqje=$catTable->where($mappp)->getField("cat_dqje");
        $catTable->cat_dqje=$dqje-$je;
        echo $username.":".$je."<br />";
        $catTable->where($mappp)->save();
    }
	//封装编写用户登录
	function UserLogin(){
        $get_UserName = I("Username"); //接收用户名信息
        $get_UserPwd = I("textPwd");  //接收密码

        $ip = get_client_ip(); //获取客户端IP
        //echo $get_UserName;
        if (!$get_UserName || !$get_UserPwd ){
            $this->_info="信息填写不完整,请检查!";
            //$this->actionInfo='{$this->assign("errorInfo","信息填写不完整,请检查");}';
            $this->LoginLog("$get_UserName","$ip","Error","Info Error");
            //exit();
        }else{
            $result=M("qx_user_tb")->where("user_name='".$get_UserName."' and user_lx=1 and user_sfyx=1")->limit(1)->select(); //取出用户信息
            if ($result && count($result)==1){ //唯一用户值
                //对比密码
                $user_pwd=$result[0]["user_pwd"];
                $ph=new PasswordHash(8, FALSE);
                $UserSfyx=$result[0]["user_sfyx"]; //读取当前用户是否有效信息
                //echo $UserSfyx;
                //exit();
                if ($ph->CheckPassword($get_UserPwd,$user_pwd) && $UserSfyx==1){
                    //$this->actionInfo='{$this->assign("sussInfo","登录成功！");}';
                    $use_log=new \stdclass();
                    $use_log->user_id=$result[0]["id"];
                    $use_log->user_name=$get_UserName;
                    $use_log->user_xm=$result[0]["user_xm"];
                    $use_log->user_role=$result[0]["user_role"];
                    $use_log->role_id=$result[0]["user_roleid"];
                    $use_log->user_comp=$result[0]["user_comp"];
                    $use_log->user_lx=$result[0]["user_lx"];
                    //echo "验证成功";
                    setcookie("user_info",serialize($use_log),time()+3600*12,"/");  //记录用户登录cookie信息，有效期为一天
                    $this->LoginLog("$get_UserName","$ip",'Success','Login Success'); //用户登录日志保存
                    $this->_info="OK";
                    //redirect('/',2, '登录成功,正在跳转...');
                }else{
                    $this->_info="密码错误或用户无效";
                    //$this->actionInfo='{$this->assign("errorInfo","密码错误或用户无效");}';
                    $this->LoginLog("$get_UserName","$ip",'Error','Password Error/Invalid user'); //用户登录日志保存
                    //exit();
                }
            }else{
                $this->_info="非法登录";
                //$this->actionInfo='{$this->assign("errorInfo","无此用户,请检查");}';
                $this->LoginLog("$get_UserName","$ip",'Error','Without this user'); //用户登录日志保存
            }
        }
    }
    //系统登录日志API(调用存储过程)
    function LoginLog($get_UserName,$ip,$zt,$info){
        $model = M("");
        $sql = "call sp_user_login('{$get_UserName}','$zt','$ip','$info')";
        $ref = $model -> query($sql);
    }
    //检测验证码
    function VerCh(){
        $get_UserName = I("Username"); //接收用户名信息
        $get_UserPwd = I("textPwd");  //接收密码
        $ip = get_client_ip(); //获取客户端IP
        $getcode=I("txtcode");  //接收验证码信息
        $Verify = new \Think\Verify();
        if(!$Verify->check($getcode)){
            echo "验证码错误";
            $this->LoginLog("$get_UserName","$ip",'Error','VerCode Error'); //用户登录日志保存
        }else{
            echo "OK";
        }
    }
	//读取部门信息
	function loadcompdata(){
	    $table=M("comp_tb");
	    $this->_class_data=$ret=$table->where("cglx_jb=2")->order("id")->select();
    }
    //读取科室信息
    function loadmetaclass($id){
        $id=I("id");
        if (!$id){
            echo "Id Error";
        }else{
            $this->_class_meta_data=$ret=M("comp_tb")->where("cglx_sjid in (".$id.") and cglx_jb=3")->order("id")->select();
            //echo M("zclx_tb")->_sql();
        }
    }
    //增加人员信息
    function AddRyxxData(){

        $AddData=D("ryxx_tb");  //注意去除前缀
        $AddData->ry_xm=I("ry_xm"); //姓名
        $AddData->ry_zw=I("ry_zw"); //职务
        $AddData->ry_bm=I("ry_bm1"); //部门
        $AddData->ry_ks=I("ry_ks1"); //科室
        $AddData->ry_fjh=I("ry_fjh"); //房间号
        $AddData->ry_bgdh=I("ry_bgdh"); //办公电话
        $AddData->ry_sjhm=I("ry_sjhm"); //手机号码
        $AddData->ry_bmid=I("ry_bmid"); //部门ID
        $AddData->ry_ksid=I("ry_ksid"); //科室ID
        $AddData->ry_zt=I("ry_zt"); //科室ID
        $AddData->ry_bz=I("ry_bz"); //科室ID
        $AddData->ry_px=100; //排序
        $AddData->add();
    }
    //编辑人员信息
    function EditRyxxData(){
        $id=I("id");
        if (!$id){
            echo "ID Error";
            exit();
        }
        $AddData=D("ryxx_tb");  //注意去除前缀
        $AddData->ry_xm=I("ry_xm"); //姓名
        $AddData->ry_zw=I("ry_zw"); //职务
        $AddData->ry_bm=I("ry_bm1"); //部门
        $AddData->ry_ks=I("ry_ks1"); //科室
        $AddData->ry_fjh=I("ry_fjh"); //房间号
        $AddData->ry_bgdh=I("ry_bgdh"); //办公电话
        $AddData->ry_sjhm=I("ry_sjhm"); //手机号码
        $AddData->ry_bmid=I("ry_bmid"); //部门ID
        $AddData->ry_ksid=I("ry_ksid"); //科室ID
        $AddData->ry_zt=I("ry_zt"); //状态
        $AddData->ry_bz=I("ry_bz"); //备注
        $AddData->ry_px=100; //排序
        $AddData->where("id=$id")->save();
        //系统日志开始
        $ry_ybm=I("ry_ybm");
        $ry_yzw=I("ry_yzw");
        $ry_yks=I("ry_yks");
        $ry_yfjh=I("ry_yfjh");
        $ry_ybgdh=I("ry_ybgdh");
        $ry_ysjhm=I("ry_ysjhm");
        $ry_yzt=I("ry_yzt");
        $ry_ybz=I("ry_ybz");
        if (I("ry_zt")==1){
            $zt="在职";
        }else{
            $zt="不在职";
        }
        $strinfo="姓名：".I("ry_xm").",职务：".$ry_yzw.",部门：".$ry_ybm.",科室：".$ry_yks.",房间号：".$ry_yfjh.",办公电话：".$ry_ybgdh.",手机号码：".$ry_ysjhm.",状态：".$ry_yzt.",备注：".$ry_ybz;
        $strinfo.="于".date("Y-m-d h:i:s")."<br /> <span style='color:#ff0000'>变更为</span> <br />";
        $strinfo.="姓名：".I("ry_xm").",职务：".I("ry_zw").",部门：".I("ry_bm1").",科室：".I("ry_ks1").",房间号：".I("ry_fjh").",办公电话：".I("ry_bgdh").",手机号码：".I("ry_sjhm").",状态：".$zt.",备注：".I("ry_bz");
        //echo $strinfo;
        //加入Log记录表
        $LogTable=D("sbxx_log_tb");
        $LogTable->sblx="ryxx_tb";
        $LogTable->sbmc=I("ry_xm");
        $LogTable->sbid=$id;
        $LogTable->zc_sqwxsj=date("Y-m-d h:i:s"); //操作时间
        $LogTable->cznr=$strinfo;
        $LogTable->add();
    }
    //重置密码
    function RePass(){
        $user=D("qx_user_tb");
        $ph=new PasswordHash(8, FALSE);
        $id=I("id");
        $user->user_pwd=$ph->HashPassword("123456");
        $user->where("id=$id")->save();
        $this->_info="OK";
    }
    //有效/无效
    function UserSfyx(){
        $id=I("id");
        $yx=I("yx");
        if (!$id){
            echo "ID Error";
            exit();
        }
        $user=D("qx_user_tb");
        if ($yx==0){
            $user->user_sfyx=1;
        }else{
            $user->user_sfyx=0;
        }
        $user->where("id=$id")->save();
        redirect('/home/user/U_manage',1, '操作成功,正在返回...');
    }

    /*//清除与人员相关的用户信息
    function ClearUser(){
        $ryid=I("ry_id");
        if ($ryid!='')
        {
            $table=D("ryxx_tb");
            $table->user_name='';
            $table->ry_yh=0;
            $table->where("id=$ryid")->save();
        }
    }*/
    function QuserSfyx(){
        $id=I("id");
        $yx=I("yx");
        if (!$id){
            echo "ID Error";
            exit();
        }
        $user=D("qx_user_tb");
        if ($yx==2){
            $user->user_lx=2;
        }else{
            $user->user_lx=3;
        }
        $user->where("id=$id")->save();
        redirect('/home/user/Q_manage',1, '操作成功,正在返回...');

    }
    //编辑用户密码
    function EditUserPassWord()
    {
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        if (!$get_UserName) {
            echo "UserInfo Error!";
            exit;
        } else {
            $this->_dateil_data = $result = M("qx_user_tb")->where("user_name='" . $get_UserName . "'")->limit(1)->field("user_pwd")->select();
            //echo $get_UserName;
            //var_export($this->_dateil_data);
            $this->_pass = $user_pwd = $result[0]["user_pwd"];
            //echo $this->_pass;
        }
        if ($_POST) {
            $ph = new PasswordHash(8, FALSE);
            $user = D("qx_user_tb");
            $user->user_pwd = $ph->HashPassword(I("textPwd"));
            $get_UserName = I("user_name");
            $get_UserPwd = I("LtxtPwd");
            if (!$get_UserName) {
                echo I("user_name");
                echo "UserInfo Error!";
                exit();
            } else {

                if ($ph->CheckPassword($get_UserPwd, $this->_pass)) {
                    $user->where("user_name='" . $get_UserName . "'")->save();
                    //echo D("qx_user_tb")->_sql();
                    $this->_info='1';
                } else {
                    $this->_info='0';
                }
            }

        }
    }
    //加载菜单数据
    function LoadMenuData($where,$where_dateil=""){
        //加载主分类数据
        $cache = S(array('type'=>'file','prefix'=>'comp_info','expire'=>1)); //读取缓存配置
        if (!$cache->Cg_Classone){
            $ret=M("qx_menu_tb")->where("cglx_jb=1".$where)->order("id")->select();
            $cache->cg_class=$ret;
        }
        $this->_class_data=$cache->cg_class;
        //循环取出主分类表中的ID
        $set_class_id="";
        foreach($this->_class_data as $class_id){
            if ($set_class_id!="")
                $set_class_id.=",";
            $set_class_id.=$class_id["id"];
            //echo $set_class_id;
        }
        if ($set_class_id!=""){
            //取出子分类数据
            if (!$cache->Cg_Classtwo){
                $ret=M("qx_menu_tb")->where("cglx_sjid in (".$set_class_id.") and cglx_jb=2")->order("id")->select();
                $cache->Cg_Classtwo=$ret;

            }
            $this->_class_meta_data=$cache->Cg_Classtwo;
            $set_towclass_id="";
            foreach($this->_class_meta_data as $class_id){
                if ($set_towclass_id!="")
                    $set_towclass_id.=",";
                $set_towclass_id.=$class_id["id"];
                //echo $set_towclass_id;
            }
            if ($set_class_id!=""){
                //取出三级分类数据
                if (!$cache->Cg_Classthree){
                    $ret=M("qx_menu_tb")->where("cglx_sjid in (".$set_towclass_id.") and cglx_jb=3")->order("id")->select();
                    $cache->Cg_Classthree=$ret;
                }
                $this->_dateil_data=$ret;
                //echo $ret;
                //echo M("comp_tb")->_sql();
                //var_export($this->_dateil_data);

            }
        }
    }
    //通过房间读取
    function loadFjRyuandata(){
        $TableName=M("ryxx_tb");
        $this->_keyword=I("id");
        if ($this->_keyword!=""){
            $where["ry_fjid"]  = array('eq',$this->_keyword);
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("ry_bm")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //读取未配置房间的人员信息
    function loadNRyuandata(){
        $TableName=M("ryxx_tb");
        $this->_keyword=I("keyword");
        $this->_depName=I("comp");

        $where["ry_xm"]  = array('like',"%$this->_keyword%");
        $where["ry_bm"]  = array('like',"$this->_depName%");
        $where['ry_fjid']=array('eq',0);
        $where['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("ry_bm")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //人员日志信息读取
    function RyLog(){
        $id=I("id");
        $TableName=M("sbxx_log_tb");
        $where["sbid"]  = array('eq',$id);
        $where["sblx"]  = array('eq','ryxx_tb');
        $this->_main_data=$TableName->where($where)->order("id")->select(); //主表数据取值完成
        //echo $TableName->_sql();
    }
    //检测邮箱并发送验证邮件
    function CheckEmail()
    {
        $TableName = M("qx_user_tb");
        $email = I("email");
        $where["user_lx"] = array('eq', 2);
        $where["user_yx"] = array('eq', "$email");
        //echo $email;
        $ret = $TableName->where($where)->find();
        echo $ret;
        if (!$ret) {
            echo "Error";
            exit();
        } else {
            $content = $ret['user_name'] . ',您好！请于24小时之内，点击下面的链接重置您的密码：<p></p>';
            $content .= '<a href=http://www.highwaytech.cn/home/Quser/rePass?h=';
            $content .= md5($ret['user_name'] . $ret['id']);
            $content .= '>http://www.highwaytech.cn/home/Quser/rePass?h=';
            $content .= md5($ret['user_name'] . $ret['id']);
            $content .= '</a>';
            if (SendMail($_POST['email'], $ret['user_name'] . ',密码找回邮件', $content)) {
                $AddTable = D("quser_zhma_tb");
                $AddTable->user_id = $ret['id'];
                $AddTable->user_email = $ret['user_yx'];
                $AddTable->user_zhsj = date('Y-m-d H:m:s');
                $content = md5($ret['user_name'] . $ret['id']);
                $AddTable->user_md5 = $content;
                $AddTable->add();
                echo "Succeed";
            } else {
                echo "Error";
            }
        }
    }
    //前端用户登录
    function login(){
        $get_UserName = I("post.Username","","/^\w{3,20}$/");
        $get_UserPwd = I("post.textPwd","","/^\w{3,20}$/");
        $getcode=I("post.txtcode");
        $get_sj=I("post.sj");
        $get_lx=I("post.aa");
        $ip = get_client_ip();
        //前端端用户登录
        //echo $get_lx;
        //exit();
        $io=new ActionAPI();
        if ($get_lx=="q")
            //前端用户登录
        {
            $Verify = new \Think\Verify();

            if ($get_UserName=="" || $get_UserPwd==""){
                $io->UserLogInfoRecode(99,0,$get_UserName,1);
                $this->actionInfo='$this->assign("errorInfo","用户名密码输入错误，请检查！");';
                exit();
            }
            elseif(!$Verify->check($getcode)){
                $io->UserLogInfoRecode(99,0,$get_UserName,1);
                $this->actionInfo='$this->assign("errorInfo","验证码输入错误，请检查！");';
                return;
            }
            else
            {
                $count=M("qx_user_tb")->where("user_name='".$get_UserName."' and user_lx=2 and user_sfyx=1")->limit(1)->count();
                if ($count<1){
                    $result=M("qx_user_tb")->where("user_name='".$get_UserName."' and user_lx=3 and user_sfyx=1")->limit(1)->select();
                }else{
                    $result=M("qx_user_tb")->where("user_name='".$get_UserName."' and user_lx=2 and user_sfyx=1")->limit(1)->select();
                }
                if ($result && count($result)==1){
                    //对比密码
                    $user_pwd=$result[0]["user_pwd"];
                    $ph=new PasswordHash(8, FALSE);
                    if ($ph->CheckPassword($get_UserPwd,$user_pwd)){
                        //$this->actionInfo='{$this->assign("sussInfo","登录成功！");}';
                        $use_log=new \stdclass();
                        $use_log->user_id=$result[0]["id"];
                        $use_log->user_name=$get_UserName;
                        $use_log->user_xm=$result[0]["user_xm"];
                        $use_log->user_yx=$result[0]["user_yx"];
                        $use_log->user_tjm=$result[0]["user_tjm"];
                        $use_log->user_comp=$result[0]["user_comp"];
                        $use_log->user_lx=$result[0]["user_lx"];
                        $use_log->user_type=$result[0]["user_type"];
                        $use_log->bd_type=$result[0]["bdcore"];
                        if ($get_sj!=""){
                            setcookie("user_info",serialize($use_log),time()+3600*12*7,"/");
                        }
                        else{
                            setcookie("user_info",serialize($use_log),time()+3600*12,"/");
                        }
                        $io->UserLogInfoRecode(99,1,$get_UserName,1);
                        $this->actionInfo="header('location:/home/Quser/user_cent');";
                        return; //不再执行以下操作
                    }
                    else{
                        $io->UserLogInfoRecode(99,0,$get_UserName,1);
                        $this->actionInfo='{$this->assign("errorInfo","密码错误！");}';
                        return; //不再执行以下操作
                    }
                }
                else{
                    $io->UserLogInfoRecode(99,0,$get_UserName,1);
                    $this->actionInfo='$this->assign("errorInfo","无此用户或正在审核中！");';
                    return;
                }
            }
        }
    }
    function Sjuserinfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_Userid = $globar_user->user_id;
        //$get_Userjb = $globar_user->user_jb;
        //$get_Usertjr = $globar_user->user_tjr;
        $get_Usertype= $globar_user->user_type;
        if (!$get_Usertype){
            echo "类型获取错误";
        }

        //echo $get_Userid;
        $Qusertable=M("qx_user_tb");
        //F('user_'.$get_Userid,$userinfo); //缓存上级用户信息
        $where["id"]=array("eq",$get_Userid);
        //var_export($userinfo);
        $tjr=$Qusertable->where($where)->limit(0,1)->getField("user_tjr");
        $tjrwhere["user_tjm"]=array("eq",$tjr);
        $getUser=$Qusertable->where($tjrwhere)->order("id desc")->limit(0,1)->select();
        foreach ($getUser as $userinfo){
            $get_Userid=$userinfo["id"];
        }
        //echo $Qusertable->_sql();
        $fx_value=F('user_3_'.$get_Userid);
        if(empty($fx_value)) {
            G('begin');
            $userwhere["_string"]="FIND_IN_SET(id,getParLst($get_Userid)) and id<$get_Userid";
            $userinfo=$Qusertable->where($userwhere)->order("id desc")->limit(0,3)->select();
            echo $Qusertable->_sql();
            F('user_3_'.$get_Userid,$userinfo); //缓存上级用户信息
            G('end');
            //echo "首次加载用户信息,请稍候";
            //var_export($value);
            echo G('begin','end').'s';
        }else{
            $i=1;
            $ii=1;
            if ($get_Usertype==1){
                /*foreach ($fx_value as $userinfo){
                    echo $i;
                    $i=$i+1;
                }*/
                var_export($fx_value);
            }else{
                //echo "开市线用户，不分钱";
            }

            //echo "chche ok";
        }
    }



    //编辑用户信息
    function EditUserInfo()
    {
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        if (!$get_UserName) {
            echo "UserInfo Error!";
            exit;
        } else {
            $this->_dateil_data = $result = M("qx_user_tb")->where("user_name='" . $get_UserName . "'")->limit(1)->select();
            $maxjb=M("qx_user_tb")->max('user_jb');
            //echo $maxjb;
            //$infoxx=$this->_dateil_data;
            //var_export($infoxx);
            //echo $get_UserName;
            //var_export($this->_dateil_data);
            foreach ($this->_dateil_data as $sjinfo){
                $jb=$sjinfo['user_jb'];
                //echo $jb;
                if (!$sjinfo['user_tjr']){

                }else{
                    $tjr=$sjinfo['user_tjr'];
                    $this->_main_data=M("qx_user_tb")->where("user_tjm='" . $tjr . "'")->limit(1)->select(); //直接上级用户数据读取
                    //ar_export($this->_main_data);
                }
                $tjxx=$sjinfo['user_tjm'];
                $listTable=M("qx_user_tb");
                $xjname="";
                $xjcount=0;
                $xjjb='';
                for ($x=$jb+1; $x<=$maxjb; $x++) { //下级用户
                    $where['user_tjr']=array("eq",$tjxx);
                    $xjcount+=$listTable->where($where)->count();
                    $infoxx=$listTable->where($where)->select();
                    //echo $listTable->_sql()."<br />";
                    //var_export($infoxx);
                    //echo "<br />";
                    foreach ($infoxx as $userinfo){
                        $tjxx=$userinfo['user_tjm'];
                        $xjname.=$userinfo['user_xm'].",";
                    }
                    }
                    //echo $xjname;
                    $this->_xjname=$xjname;
                    $this->_page_count=$xjcount; //下级团队人数
            }
        }
        if ($_POST) {
            $user = D("qx_user_tb");
            $user->user_xm = I("user_xm");
            $user->user_comp = I("user_comp");
            $user->user_zw = I("user_zw");
            $user->user_dh = I("user_dh");
            $user->user_sj = I("user_sj");
            $user->user_yx = I("user_yx");
            $user->user_lxdz = I("user_lxdz");
            $user->user_sfzh = I("user_sfzh");
            $user->user_dz = I("user_dz");
            $user->user_cz = I("user_cz");
            $user->user_carekhh=I("user_carekhh"); //开户行
            $user->user_carename=I("user_carename"); //帐户名称
            $user->user_carenum=I("user_carenum"); //帐户卡号
            $get_UserName = I("user_name");
            if (!$get_UserName) {
                echo I("user_name");
                echo "UserInfo Error!";
                exit();
            } else {
                $user->where("user_name='" . $get_UserName . "'")->save();
                //echo D("qx_user_tb")->_sql();
                redirect('/home/Quser/user_cent', 1, '编辑成功，正在返回用户中心...');
            }

        }
    }
    //判断用户是否为报单中心
    function BdUserInfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        $bdcore = $result = M("qx_user_tb")->where("user_name='" . $get_UserName . "'")->limit(1)->getField("bdcore");
        $this->_zt=$bdcore;
    }
    //读取报单中心用户信息
    function LoadBdcentInfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        $bdtable=M("bdcent_tb");
        $where["user_name"]=array("eq",$get_UserName);
        $this->_main_data=$bdtable->where($where)->order("id desc")->select();
        //var_export($this->_main_data);
    }
    //判段是否为复投用户
    function FtUserInfo()
    {
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;

        $sytable=M("syinfo_tb");
        $where["syr_name"]=array("eq","$get_UserName");
        $sysum=$sytable->where($where)->sum("syr_gxje");

        $where1["username"]=array("eq","$get_UserName");
        $logtable=M("userftlog_tb");
        $count=$logtable->where($where1)->count();
        //echo $sysum;
        /*$syzt=$sysum/115000;
        echo $syzt;*/
        $this->_ft=$count;
        if ($sysum>=115000 && $count==0){
            $this->_ftzt=1;
        }elseif ($sysum>=230000 && $count==1){
            $this->_ftzt=1;
        }elseif ($sysum>=345000 && $count==2){
            $this->_ftzt=1;
        }elseif ($sysum>=460000 && $count==3){
            $this->_ftzt=1;
        }else{
            $this->_ftzt=0;
        }
    }
    //复投操作封装
    function Ftinfo(){
        $ftje=15000;
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        $cattable=M("usercat_tb");
        $where1["cat_type"]=array("eq",1);
        $where1["cat_username"]=array("eq","$get_UserName");

        //现金帐户操作
        $dqje=$cattable->where($where1)->getField("cat_dqje");
        $clje=$dqje-$ftje;
        $cattable->cat_dqje=$clje;
        $ret=$cattable->where($where1)->save();

        //记录信息处理
        $logtable=M("userftlog_tb");
        $logtable->username=$get_UserName;
        $logtable->tx_je=$ftje;
        $logtable->tx_sj=date('Y-m-d H:i:s',time());
        $logtable->tx_zt=1;
        $logtable->add();
        //echo "当前金额：".$dqje;
    }
    //读取正在提现的数据
    function TxInfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        $cattable=M("usertxlog_tb");
        $where1["tx_zt"]=array("not in",'100,7');
        //$where1["tx_zt"]=array("neq",7);
        $where1["username"]=array("eq","$get_UserName");
        $count=$cattable->where($where1)->count();
        if ($count>0){
            $this->_zt=0;
        }else{
            $this->_zt=1;
        }

    }

    //读取前端顶层用户信息表
    function LoadQuserGInfo($jb,$lx){
        $UserTable = M("qx_user_tb");
        $where["user_jb"] = array("eq", $jb);
        $where["user_lx"] = array("eq", $lx);
        $this->_main_data = $UserTable->where($where)->order("id")->select();
        $maxjb=M("qx_user_tb")->max('user_jb');
        $this->_xmbh=$maxjb;
    }
    //读取子信息
    function LoadQuserinfo($lx){
        $user_name=I("user_name");
        $get_UserName = $user_name;
        if (!$get_UserName) {
            echo "UserInfo Error!";
            exit;
        } else {
            $this->_dateil_data = $result = M("qx_user_tb")->where("user_name='" . $get_UserName . "' and user_lx=2")->limit(1)->select();
            $maxjb=M("qx_user_tb")->max('user_jb');
            //echo $maxjb;
            //$infoxx=$this->_dateil_data;
            //var_export($infoxx);
            //echo $get_UserName;
            //var_export($this->_dateil_data);
            foreach ($this->_dateil_data as $sjinfo){
                $jb=$sjinfo['user_jb'];
                //echo $jb;
                if (!$sjinfo['user_tjr']){

                }else{
                    $tjr=$sjinfo['user_tjr'];
                    $this->_main_data=M("qx_user_tb")->where("user_tjm='" . $tjr . "' and user_lx=2")->limit(1)->select(); //直接上级用户数据读取
                    //ar_export($this->_main_data);
                }
                $tjxx=$sjinfo['user_tjm'];
                $listTable=M("qx_user_tb");
                $xjname="<div class='col-md-9' style='margin-left: -10px'>";
                $xjcount=0;
                $ii=0;
                for ($x=$jb+1; $x<=$maxjb; $x++) { //下级用户
                    $where['user_tjr']=array("eq",$tjxx);
                    $where['user_type']=array("eq",2);
                    $xjcount+=$listTable->where($where)->count();
                    $infoxx=$listTable->where($where)->select();
                    //echo $listTable->_sql()."<br />";
                    foreach ($infoxx as $userinfo){
                        $tjxx=$userinfo['user_tjm'];
                        if($x%2==1){
                            $xx=",";
                            $xjname.="<div style='width:100px;";
                            //echo $ii;
                            if ($x>1){
                                $xjname.="margin-left: ".$ii."px;margin-top: -20px";
                            }
                            $ii=$ii+90;
                            $xjname.="'>"."<a href='#' onclick='getmetainfo(".$userinfo['id'].")'>".$userinfo['user_name']."</a>".$xx;
                        }else{
                            $xx='&nbsp;&nbsp;。';
                            $xjname.="<a href='#' onclick='getmetainfo(".$userinfo['id'].")'>".$userinfo['user_name'].$xx."</a></div>";
                        }


                    }
                }
                //echo $xjname;
                $this->_xjname=$xjname."</div>";
                $this->_page_count=$xjcount; //下级团队人数
            }
        }
    }
    //读取分享线子信息
    function LoadfQuserinfo(){
        $user_name=I("user_name");
        $get_UserName = $user_name;
        if (!$get_UserName) {
            echo "UserInfo Error!";
            exit;
        } else {
            $this->_dateil_data = $result = M("qx_user_tb")->where("user_name='" . $get_UserName . "' and user_lx=2")->limit(1)->select();
            $maxjb=M("qx_user_tb")->max('user_jb');
            //echo $maxjb;
            //$infoxx=$this->_dateil_data;
            //var_export($infoxx);
            //echo $get_UserName;
            //var_export($this->_dateil_data);
            foreach ($this->_dateil_data as $sjinfo){
                $jb=$sjinfo['user_jb'];
                //echo $jb;
                if (!$sjinfo['user_tjr']){

                }else{
                    $tjr=$sjinfo['user_tjr'];
                    $this->_main_data=M("qx_user_tb")->where("user_tjm='" . $tjr . "' and user_lx=2")->limit(1)->select(); //直接上级用户数据读取
                    //ar_export($this->_main_data);
                }
                $tjxx=$sjinfo['user_tjm'];
                $listTable=M("qx_user_tb");
                $xjname="<div class='col-md-9' style='margin-left: -10px'>";
                $xjcount1=0;
                $ii=0;
                for ($x=$jb+1; $x<=$maxjb; $x++) { //下级用户
                    $where['user_tjr']=array("eq",$tjxx);
                    $where['user_type']=array("eq",1);
                    $xjcount1+=$listTable->where($where)->count();
                    $infoxx=$listTable->where($where)->select();
                    //echo $listTable->_sql()."<br />";
                    foreach ($infoxx as $userinfo){
                        $tjxx=$userinfo['user_tjm'];
                        if($x%2==1){
                            $xx=",";
                            $xjname.="<div style='width:100px;";
                            //echo $ii;
                            if ($x>1){
                                $xjname.="margin-left: ".$ii."px;margin-top: -20px";
                            }
                            $ii=$ii+90;
                            $xjname.="'>"."<a href='#' onclick='getmetainfo(".$userinfo['id'].")'>".$userinfo['user_name']."</a>".$xx;
                        }else{
                            $xx='&nbsp;&nbsp;。';
                            $xjname.="<a href='#' onclick='getmetainfo(".$userinfo['id'].")'>".$userinfo['user_name'].$xx."</a></div>";
                        }


                    }
                }
                //echo $xjname;
                $this->_xjname=$xjname."</div>";
                $this->_page_count=$xjcount1; //下级团队人数
            }
        }
    }
    //读取用户详细资料
    function LoadUserMetainfo(){
        $id=I("id");
        if (!$id){
            echo "ID error";
            exit();
        }
        $where["id"]=array("eq",$id);
        //读取用户基础信息
        $UserTable=M("qx_user_tb");
        $this->_main_data=$UserTable->where($where)->order("id")->limit(1)->select();
        foreach ($this->_main_data as $user){
            $username=$user["user_name"];
        }
        //var_export($ret);
        //读取用户报单信息
        $UserBdTable=M("jybd_tb");
        $mpp["user_name"]=array("eq",$username);
        $count=$UserBdTable->where($mpp)->order("id desc")->count();
        $this->_MetaBdInfo=$UserBdTable->where($mpp)->order("id desc")->select();
        //echo $UserBdTable->_sql();
        //var_export($this->_MetaBdInfo);
        //读取用户贡献信息
        $UserGxTable=M("syinfo_tb");
        $mapp["syr_gxrname"]=array("eq",$username);
        $this->_MetaGxInfo=$UserGxTable->where($mapp)->order("id desc")->select();
        //echo $UserGxTable->_sql();
        //读取用户收益信息
        $mappp["syr_name"]=array("eq",$username);
        $this->_MetaSyInfo=$UserGxTable->where($mappp)->order("id desc")->select();
        //读取资金信息帐户
        $UserCatTable=M("usercat_tb");
        $mapppp["cat_username"]=array("eq",$username);
        $this->_MetaCatInfo=$UserCatTable->where($mapppp)->order("id desc")->select();
        //echo $UserCatTable->_sql();
    }
    //推荐码输入验证
    function TjrCh(){
        $tjm=I("tjm");
        if (!$tjm){
            echo "Error";
            exit();
        }
        $UserTable=M("qx_user_tb");
        $where["user_tjm"]=array("eq",$tjm);
        $count=$UserTable->where($where)->limit(1)->count();
        if ($count==0){
            echo "Error";
        }else{
            $mapp["user_tjr"]=array("eq",$tjm);
            $retcount=$UserTable->where($mapp)->limit(1)->count();
            //echo $UserTable->_sql();
            //echo "该用户下属人数".$retcount;
            if ($retcount<2){
                echo $retcount;
            }else{
                echo $retcount;
            }
        }
    }
    //读取用户子信息
    function QuserZinfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $user_id = $globar_user->user_id;
        //echo $user_id;
        if (!$user_id){
            $user_id=I("user_id");
            if (!$user_id){
                echo "id Error";
                exit();
            }
        }
        $UserSql=M();
        $user_xm="";
        $cache = S(array('type'=>'file','prefix'=>'user_info','expire'=>12000)); //读取缓存配置
        $ret=$UserSql->query("select id,user_name,user_xm,user_jb,user_type,user_pid from pt_qx_user_tb where FIND_IN_SET(id,getDarLst(".$user_id.")) and id!=".$user_id."") ;
        $count=$UserSql->query("select count(id) from pt_qx_user_tb where FIND_IN_SET(id,getDarLst(".$user_id.")) and id!=".$user_id."");
        //var_export($count);
        foreach ($count as $info){
            $this->_page_count=$info["count(id)"];
            $user_xm.=$info["user_xm"]." | ";
        }
        //echo $user_xm;
        $cache->Daruser=$ret;
        $this->_main_data=$cache->Daruser;
    }
    //异步读取用户子信息
    function QuserGinfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $user_id = $globar_user->user_id;
        //echo $user_id;
        if (!$user_id){
            $user_id=I("user_id");
            if (!$user_id){
                echo "id Error";
                exit();
            }
        }
        $UserSql=M();
        $user_xm="";
        //$cache = S(array('type'=>'file','prefix'=>'user_info','expire'=>12000)); //读取缓存配置
        //S('name',$value,300);

        //$count=$UserSql->query("select count(id) from pt_qx_user_tb where FIND_IN_SET(id,getDarLst(".$user_id.")) and id!=".$user_id."");
        //var_export($count);
        /*foreach ($ret as $info){
            $user_xm.=$info["user_xm"]." | ";
        }*/
        //$cache->Daruser=$user_xm;
        /*S('name',$user_xm,6000);
        $value=S('name');*/
        $value=S('name'.$user_id);
        if(empty($value)){
            $ret=$UserSql->query("select id,user_name,user_xm from pt_qx_user_tb where FIND_IN_SET(id,getDarLst(".$user_id.")) and id>".$user_id." ORDER BY id ");
            foreach ($ret as $info){
                $user_xm.=$info["user_xm"]." | ";
            }
            S('name'.$user_id,$user_xm,6000);
            $value=S('name'.$user_id);
            echo $value;
            //dump($list);
        }else{
            //echo '这个是缓存文件';
            echo $value;
        }

        //$cache->Daruser=$ret;
        $this->_main_data=$ret;
    }

    function QuserFt(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;
        if (!$get_UserName) {
            echo "UserInfo Error!";
            exit;
        }
        $where["cat_type"]=array("eq",1);
        $where["cat_username"]=array("eq",$get_UserName);
        $dqje=M("usercat_tb")->where($where)->getField("cat_dqje"); //现金帐户当前金额
        $mapp["syr_name"]=array("eq",$get_UserName);
        $sum=M("syinfo_tb")->where($mapp)->sum('syr_gxje'); //总收益金额
        $mappp["username"]=array("eq",$get_UserName);
        $mappp["tx_zt"]=array("in",'10,100');
        $txsum=M("usertxlog_tb")->where($mappp)->sum('tx_je'); //总收益金额
        /*echo $sum."<br />";
        echo $dqje."<br />";
        echo $txsum."<br />";*/
        $tx=$txsum;
        if ($sum>100000){
            $this->_zsy=100000;
        }else{
            $this->_zsy=$sum;
        }
        $this->_ztx=$tx;
        if ($tx>=100000){
            $this->_ft=1;
        }
    }
    function UserMeta($username){
        //echo $username;
        $UserTable=M("qx_user_tb");
        $where["user_name"]=array("eq",$username);
        $user_xm=$UserTable->where($where)->getField('user_xm');
        //return $user_xm;
        echo $user_xm;
    }

    function UserCatMeta($username,$cat_type){
        //echo $username;
        $UserTable=M("usercat_tb");
        $where["cat_username"]=array("eq",$username);
        $where["cat_type"]=array("eq",$cat_type);
        $cat_zt=$UserTable->where($where)->getField('cat_zt');
        $cat_dqje=$UserTable->where($where)->getField('cat_dqje');
        //return $user_xm;
        if ($cat_zt==1){
            echo "<a href=\"#\" class=\"btn btn-success btn-xs\" role=\"button\">已激活，帐户余额：$cat_dqje</a>";
        }else{
            echo "<a href=\"#\" class=\"btn btn-warning btn-xs disabled\" role=\"button\">未激活，帐户余额：$cat_dqje</a>";
        }
    }

    function BdCentInfo(){
        $BdCentTable=M("Bdcent_tb");
        $user_name=I("username");
        $where["user_name"]=array("eq",$user_name);
        if (!$user_name){
            echo "User Error";
        }else{
            $dqje=$BdCentTable->where($where)->getField("dqje");
            if (!$dqje || $dqje==0){
                $dqje=0;
                echo $dqje;
            }else{
                echo $dqje;
            }

        }
    }
    //报单中心费用注入
    function SunBdCent($actlx,$zt){
        $AddData=D("bdcent_log_tb");  //注意去除前缀
        $AddData->user_name=I("czr"); //用户名
        $AddData->jy_lx=$actlx; //类型，1为注入2为提现3为转帐
        $AddData->jy_je=I("zrje"); //金额
        $AddData->jy_sj=date('Y-m-d H:i:s',time()); //交易时间
        if ($actlx==1) {
            $AddData->jt_dx=I("user_name"); //交易对像
        }else{
            $AddData->jt_dx=I("czr"); //交易对像
        }
        $AddData->dq_je=I("zrje"); //当前金额
        $AddData->jy_skr=I("jy_skr");
        $AddData->jy_zt=$zt;
        $ret=$AddData->add();
        if ($actlx==1){
            if (!$ret){
                echo "插入数据失败，请后退重试。";
            }else{
                /*处理用户帐户信息*/
                $user_name=I("user_name");
                $EditData=D("bdcent_tb");  //注意去除前缀
                $EditData->user_name=I("user_name"); //用户名
                $EditData->bz=I("bz"); //备注
                $where["user_name"]=array("eq",$user_name);
                $dqje=$EditData->where($where)->getField("dqje");
                $count=$EditData->where($where)->count();
                if ($count>0){
                    $EditData->dqje=$dqje+I("zrje"); //当前金额
                    $retinfo=$EditData->where($where)->save();
                    $this->_zt=$retinfo;
                }else{
                    $EditData->dqje=I("zrje"); //当前金额
                    $retinfo=$EditData->add();
                    $this->_zt=$retinfo;
                }
            }
        }elseif ($actlx==2){
            /*处理用户帐户信息*/
            $user_name=I("czr");
            $EditData=D("bdcent_tb");  //注意去除前缀
            $EditData->user_name=I("czr"); //用户名
            $EditData->bz=I("bz"); //备注
            $where["user_name"]=array("eq",$user_name);
            $dqje=$EditData->where($where)->getField("dqje");
            $count=$EditData->where($where)->count();
            if ($count>0){
                $EditData->dqje=$dqje-I("zrje"); //当前金额
                $retinfo=$EditData->where($where)->save();
                $this->_zt=$retinfo;
            }else{
                $this->_zt=0;
            }
        }elseif ($actlx==3){
            //收款人收款
            $user_name=I("jy_skr");
            $EditData=D("bdcent_tb");  //注意去除前缀
            $EditData->user_name=$user_name; //用户名
            $EditData->bz=I("bz"); //备注
            $where["user_name"]=array("eq",$user_name);
            $dqje=$EditData->where($where)->getField("dqje");
            $count=$EditData->where($where)->count();
            if ($count>0){
                $EditData->dqje=$dqje+I("zrje"); //当前金额
                $retinfo=$EditData->where($where)->save();
                $this->_zt=$retinfo;
            }else{
                $EditData->dqje=I("zrje"); //当前金额
                $retinfo=$EditData->add();
                $this->_zt=$retinfo;
            }
            //转帐人付款
            $user_name=I("czr");
            $EditData=D("bdcent_tb");  //注意去除前缀
            $EditData->user_name=$user_name; //用户名
            $EditData->bz=I("bz"); //备注
            $where["user_name"]=array("eq",$user_name);
            $dqje=$EditData->where($where)->getField("dqje");
                $EditData->dqje=$dqje-I("zrje"); //当前金额
                $retinfo=$EditData->where($where)->save();
                $this->_zt=$retinfo;
        }

    }
    //读取报单人员当前信息
    function loadBdryinfo(){
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $user_name=$globar_user->user_name;
        $where["user_name"]=array("eq",$user_name);
        $this->_ft=M("Bdcent_tb")->where($where)->getField("dqje");
        //echo M("Bdcent_tb")->_sql();
        //echo $this->_ft;
    }
    //读取报单中心所有用户信息
    function loadbdmatedata(){
        $TableName=M("bdcent_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["user_name"]  = array('like',"%$this->_keyword%");
            $where["dqje"]  = array('like',"%$this->_keyword%");
            $where["bz"]  = array('like',"%$this->_keyword%");
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
    //读取用户充值记录信息
    function loadbdzjmatedata($lx){
        $TableName=M("bdcent_log_tb");
        $this->_keyword=I("keyword");
            $where["user_name"]  = array('like',"%$this->_keyword%");
            $where["jy_lx"]  = array('like',"%$this->_keyword%");
            $where["jy_je"]  = array('like',"%$this->_keyword%");
            //$where["jy_sj"]  = array('like',"%$this->_keyword%");
            $where["jt_dx"]  = array('like',"%$this->_keyword%");
            $where["dq_je"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        $mmmap['_complex']=$where;
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
    //读取用户报单币转出记录
    function LoadUserZzInfo($username){
        $logtable=M("bdcent_log_tb");
        $where["jy_zt"]=array("eq",100);
        $where["jy_lx"]=array("eq",3);
        $where["user_name"]=array("eq",$username);

        //加载主表数据
        $this->_page_count=$count=$logtable->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量

        $this->_main_data=$logtable->where($where)->order("id desc")->select();
        //var_dump($this->_main_data);
    }
    //读取用户报单币转出记录
    function LoadUserZrInfo($username){
        $logtable=M("bdcent_log_tb");
        $where["jy_zt"]=array("eq",100);
        $where["jy_lx"]=array("eq",3);
        $where["jy_skr"]=array("eq",$username);

        //加载主表数据
        $this->_page_count=$count=$logtable->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量

        $this->_main_data=$logtable->where($where)->order("id desc")->select();
        //var_dump($this->_main_data);
    }
    //读取用户登录信息
    function GetUserinfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        return $globar_user;
    }
    //读取报单中心记录
    function BdCentLogInfo($lx){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字

        $LogTable=M("bdcentlog_vm");
        $LogWhere["jy_lx"]=array("eq",$lx);
        $LogWhere["user_name"]=array("like","$search%");
        //$LogWhere["jt_dx"]=array("like","$search%");
        //$LogWhere['_logic']='or';
        //加载主表数据
        $this->_page_count=$count=$LogTable->where($LogWhere)->order("id DESC")->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$LogTable->where($LogWhere)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //echo $TableName->getLastSql();
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }
    //读取报单中心报单积分
    function BdCentjfInfo($lx){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字

        $LogTable=M("bdjflog_vm");
        $LogWhere["jy_lx"]=array("eq",$lx);
        $LogWhere["user_name"]=array("like","$search%");
        //$LogWhere["jt_dx"]=array("like","$search%");
        //$LogWhere['_logic']='or';
        //加载主表数据
        $this->_page_count=$count=$LogTable->where($LogWhere)->order("id DESC")->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$LogTable->where($LogWhere)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //echo $TableName->getLastSql();
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }
    //读取用户报单现金
    function BdCatInfo($lx){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字

        $LogTable=M("bdxj_vm");
        $LogWhere["cat_type"]=array("eq",$lx);
        $LogWhere["cat_username"]=array("like","$search%");
        //$LogWhere["jt_dx"]=array("like","$search%");
        //$LogWhere['_logic']='or';
        //加载主表数据
        $this->_page_count=$count=$LogTable->where($LogWhere)->order("id DESC")->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$LogTable->where($LogWhere)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //echo $TableName->getLastSql();
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }
    //通过用户名读取用户信息
    function GetUserXm($username){
        $UserTable=M("qx_user_tb");
        $where["user_name"]=array("eq",$username);
        $this->_username=$UserTable->where($where)->getField("user_xm");
        echo $this->_username;
    }
}
