<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class UserAPI
{
	public $_page_size="50"; //每页显示条数
	public $_page_bar=""; //分布组件需要展示的内容
	public $_page_count=""; //统计数量
	public $_main_data=array(); //主表数据
	public $_dateil_data=array();  //子表数据
	public $_keyword=""; //关键字数据
	public $_class_data=""; //类型数据
	public $_class_meta_data="";
	public $_xmbh=""; //编号数据
	public $actionInfo=""; //返回要执行的动作
    public $_info="";
    public $_zt=""; //状态
    public $_comp=""; //组织机构
    public $_username="";
    public $_usercomp=""; //当前用户组织机构

    function loadRyuandata(){
        $TableName=M("ryxx_tb");
        $ry_zt=I("ry_zt");
        $this->_comp=I("comp");
        //echo $this->_comp;
        $this->_keyword=I("keyword");
        $this->_zt=$ry_zt;
        if ($this->_keyword!=""){
            $where["ry_xm"]  = array('like',"%$this->_keyword%");
            $where["ry_zw"]  = array('like',"%$this->_keyword%");
            //$where["ry_bm"]  = array('like',"%$this->_keyword%");
            $where["ry_ks"]  = array('like',"%$this->_keyword%");
            $where["ry_fjh"]  = array('like',"%$this->_keyword%");
            $where["ry_bgdh"]  = array('like',"%$this->_keyword%");
            $where["ry_sjhm"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }else{
            $where["ry_zt"]=array("eq",1);
            $where['_logic']='OR';
        }
        if ($ry_zt!=""){
            $mapp['_complex']=$where;
            $mapp['ry_zt']=array('eq',$ry_zt);
            $mapp['_logic']='AND';
        }
        if ($this->_comp!==""){
            $mapp['_complex']=$where;
            $mapp['ry_bm']=array('eq',$this->_comp);
            $mapp['_logic']='AND';
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mapp)->order("ry_zt desc,ry_bm")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
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
                           $info=$EditTable->where("id=$user_id")->save();
                           if ($info){
                               $this->_zt=1;
                           }else{
                               $this->_zt=0;
                           }
                           //redirect('/home/user/ryuan_manage',1, '用户增加成功,正在返回...');
                       }
                       else{
                           $this->_zt=1;
                           //redirect('/home/user/U_manage',1, '用户增加成功,正在返回...');
                       }

                   }
                   else
                   {
                       $this->_zt=0;
                       //$this->actionInfo='{$this->assign("sussInfo","增加失败，请继续！");}';
                   }
			}
		}
		catch(\Think\Exception $ex){
			$ex->getMessage();
			$this->_zt=0;
			$this->actionInfo='{$this->assign("errorInfo","该用户名被占用，请检查！");}';
		}

	}
	function Useredit(){
        $id=I("id");
        $user=M("qx_user_tb");
        $user->user_role=I("role_name");
        $user->user_roleid=I("user_role");
        $user->where("id=$id")->save();
        redirect('/Home/user/U_manage',1, '用户编辑成功,正在返回...');
    }
    function UserDal($username){
        $where["user_name"]=array("eq",$username);
        $count=M("qx_user_tb")->where($where)->count();
        $this->_page_count=$count;
    }


	function loadmatedata(){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
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
        }
		//加载主表数据
		$this->_page_count=$count=M("qx_user_tb")->where($where)->order("id DESC")->count();
		$Page = new \Think\Page($count,"40");

		$this->_page_bar=$Page->show(); //把分布内容赋值给变量
		$this->_main_data=$ret=M("qx_user_tb")->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
		//echo M("qx_user_tb")->getLastSql();
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
            $result=M("qx_user_tb")->where("user_name='".$get_UserName."' ")->limit(1)->select(); //取出用户信息
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
                $this->_info="无此用户,请检查";
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
        if (I("ry_xm")!=""){
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
    //清除与人员相关的用户信息
    function ClearUser(){
        $ryid=I("ry_id");
        if ($ryid!='')
        {
            $table=D("ryxx_tb");
            $table->user_name='';
            $table->ry_yh=0;
            $table->where("id=$ryid")->save();
        }
    }
    /*读取登录后当前用户信息*/
    function GetUserInfo(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $this->_username=$globar_user->user_name;
        $this->_usercomp=$globar_user->user_comp;
        if ($this->_username==""){
            $this->_zt=0;
        }else{
            $this->_zt=1;
        }
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
    //通过部门读取用户名信息
    function getUsername(){
        $id=I("comp");
        $ii=new ActionAPI();
        $ii->ChId($id);
        $TableName=M("qx_user_tb");
        $where["user_comp"]=array("eq",$id);
        $this->_main_data=$TableName->where($where)->order("id desc")->select(); //主表数据取值完成
    }
    //改变用户状态
    function UserZt($id,$zt){
        $UserTable=M("qx_user_tb");
        $where["id"]=array("eq",$id);
        $UserTable->user_sfyx=$zt;
        $this->_zt=$UserTable->where($where)->save();
        //echo $UserTable->_sql();
    }
    //角色对应菜单信息
    function RoleAuthMenu(){
        $id=I("id");
        if (!$id){
            echo "Id Error";
            exit();
        }
        //读取角色信息下的菜音列表ID
        $RoleMenuTable=M("qx_rolemenu_tb");
        $where['Rolid']=array('eq',$id);
        $this->_main_data=$ret=$RoleMenuTable->where($where)->select(); //以数组方式取值
        //echo $RoleMenuTable->_sql();
        //var_export($ret);
        foreach ($ret as $Menuid){
            $rolemenu=$Menuid["rolemenu"];  //取值成功
        }
        if ($rolemenu!=''){
            //读取菜单信息
            $MenuTable=M("qx_menu_tb");
            $key['id']=array('in',$rolemenu);
            $this->_page_count=$MenuTable->where($key)->count();
            $this->_main_data=$MenuTable->where($key)->select(); //菜单取值完成
            //echo $MenuTable->_sql();
            //var_export($this->_main_data);
        }
    }
}	

?>