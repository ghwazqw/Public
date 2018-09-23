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
    public $_userid="";
    public $_Msg="";

    //读取全部角色信息
    function LoadRoleInfo(){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        if (!$sort){
            $sort="id";
        }
        $TableName=M("auth_group");
        if ($search!=""){
            $where["title"]=array("like","%$search%"); //可按照标题进行检索
        }
        $this->_page_count=$count=$TableName->where($where)->order($sort." ". $order)->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($where)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //echo $TableName->getLastSql();
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }
    //读取有效角色信息
    function LoadStatusRole(){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        if (!$sort){
            $sort="id";
        }
        $TableName=M("auth_group");
        if ($search!=""){
            $where["title"]=array("like","%$search%"); //可按照标题进行检索
        }
        $where["status"]=array("eq",1);
        $this->_page_count=$count=$TableName->where($where)->order($sort." ". $order)->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($where)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //echo $TableName->getLastSql();
        //var_dump($this->_main_data);
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }

    }
    //编辑角色信息
    function RoleEdit($id,$name){
        $status=I("status");
        $note=I("note");
        $Table=M("auth_group");
        $Table->title=$name;

        if ($status!=""){ //状态不为空时
            $Table->status=$status;
        }

        if ($note!=""){ //说明不为空时
            $Table->note=$note;
        }

        if (!$id){ //无ID则新增数据
            $ret=$Table->add();

        }else{ //有ID则判断是否有该ID信息
            $where["id"]=array("eq",$id);
            $count=$Table->where($where)->count();
            if (!$count || $count==0){ //没有该ID数据则返回空值，不进行修改
                $ret=0;
            }else{
                $ret=$Table->where($where)->save();
            }
        }
        if ($ret){
            return true;
        }else{
            return false;
        }
    }

    function loadRyuandata(){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字

        //echo $search;

        $TableName=M("qx_user_tb");
        $ry_zt=I("ry_zt");
        $this->_comp=I("comp");
        //echo $this->_comp;
        $this->_keyword=$search;
        $this->_zt=$ry_zt;

            $where["user_xm"]  = array('like',"%$search%");
           /* $where["ry_zw"]  = array('like',"%$this->_keyword%");
            //$where["ry_bm"]  = array('like',"%$this->_keyword%");
            $where["ry_ks"]  = array('like',"%$this->_keyword%");
            $where["ry_fjh"]  = array('like',"%$this->_keyword%");
            $where["ry_bgdh"]  = array('like',"%$this->_keyword%");
            $where["ry_sjhm"]  = array('like',"%$this->_keyword%");*/
            $where['_logic']='OR';

        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->count();
        //echo $TableName->_sql();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
	//获取用户登录后的信息对象
	function getuser(){
		$get_logincook=$_COOKIE['user_info'];
		if (!$get_logincook) return false; //
         //exit($get_logincook);
         $get_logincook=DxydDecrypt($get_logincook,C("cookkey"));
         //exit($get_logincook);
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
        $user_info =DxydDecrypt($user_info,C("cookkey")); //解密cookie信息
        $globar_user = unserialize($user_info); //反序列化用户信息
        $this->_username=$globar_user->user_name;
        $this->_usercomp=$globar_user->user_comp;
        $this->_userinfo=$globar_user->user_xm;
        $this->_userid=$globar_user->user_id;
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
    //加载菜单数据
    function LoadRoleMenuData(){
        //加载主分类数据
        $cache = S(array('type'=>'file','prefix'=>'comp_info','expire'=>1)); //读取缓存配置
        if (!$cache->Cg_Classone){
            $ret=M("auth_menu_tb")->where("menu_jb=1")->order("id")->select();
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
                $ret=M("auth_menu_tb")->where("menu_sjid in (".$set_class_id.") and menu_jb=2")->order("id")->select();
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
                    $ret=M("auth_menu_tb")->where("menu_sjid in (".$set_towclass_id.") and menu_jb=3")->order("id")->select();
                    $cache->Cg_Classthree=$ret;
                }
                $this->_dateil_data=$ret;
                //echo $ret;
                //echo M("comp_tb")->_sql();
                //var_export($this->_dateil_data);
            }
        }
    }
    //角色对应菜单信息
    function RoleAuthMenu(){
        $id=I("id");
        $ii=new ActionAPI();
        $ii->ChId($id);
        //读取角色信息下的菜音列表ID
        $RoleMenuTable=M("auth_group");
        $where['id']=array('eq',$id);
        $this->_main_data=$ret=$RoleMenuTable->where($where)->select(); //以数组方式取值
        //echo $RoleMenuTable->_sql();
        //var_export($ret);
        foreach ($ret as $Menuid){
            $rolemenu=$Menuid["rules"];  //取值成功
        }

            $MenuTable=M("auth_menu_tb");
            $key['id']=array('in',$rolemenu);
            $this->_page_count=$MenuTable->where($key)->count();
            $this->_main_data=$MenuTable->where($key)->select(); //菜单取值完成
            //echo $MenuTable->_sql();
            //var_export($this->_main_data);
    }
    //保存权限菜单
    function EditRoleMenu(){
        $table=D("auth_group"); //角色菜单表
        $select_roleid=I("select_roleid"); //接收角色ID
        $select_rolename=I("select_rolename"); //接收角色名称
        $select_info=I("select_info"); //接收具体菜单信息
        $table->id=$select_roleid; //角色ID
        $table->title=$select_rolename; //角色名称
        $table->rules=$select_info; //对应权限ID

        $where["id"]  = array('eq',$select_roleid); //判断ID是否存在
        $count=$table->where($where)->count(); //读取菜单信息
        if ($count>0){ //如大于0时，更新数据
            $ret=$table->where($where)->save();

        }else{ //否则新增数据
            $ret=$table->add();
        }
        if($ret){
            return true;
        }else{
            return false;
        }
    }
    //读取用户登录日志
    function LoadUserLog(){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字

        if ($search=='成功' || $search=='登录成功'){
            $search='Success';
        }elseif ($search=='失败' || $search=='登录失败'){
            $search='Error';
        }

        if (!$sort){
            $sort="id"; //默认排序字段
        }
        if (!$order){
            $order="desc"; //默认排序方式
        }
        if (!$offset){
            $offset=0; //默认数据读取
        }
        $TableName=M("user_log");
        if ($search!=""){
            $where["user_name"]=array("eq",$search); //用户搜索
            $where["log_type"]=array("eq",$search); //类型搜索
            $where["user_ip"]=array("eq",$search); //类型搜索
            $where['_logic']='OR';
        }

        $this->_page_count=$count=$TableName->where($where)->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($where)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        //exit($TableName->getLastSql()) ;
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }
    //手机号唯一检测
    function chmob($mob){
        $Table=M("user_tb");
        $where["user_moblie"]=array("eq",$mob);
        $count=$Table->where($where)->count();
        //echo $Table->_sql();
        if ($count>0){
            return false;
        }else{
            return true;
        }
    }
    //手机注册
    function reg(){
        $scode=session("mobcode");
        $code=I("code");
        $mobile=I("mobile");
        if (!$mobile || !$code || !$scode){
            $this->_Msg='部分数据为空';
            return false;
        }else{
            if ($code!=$scode){
                //$this->_Msg='用户输入：'.$code.'Session:'.$scode.'验证码不匹配';
                $this->_Msg='注册失败';
                return false;
            }else{
                $Table=M("user_tb");
                $Table->user_name=I("user_name");
                $Table->user_xm=I("user_xm");
                $Table->user_zw=I("user_zw");
                $Table->user_comp=I("user_comp");
                $Table->user_regdate=date('Y-m-d H:i:s',time());
                $Table->user_role=I("user_role");
                $Table->user_role=I("user_role");
                $Table->user_sfyx=1;
                $Table->user_type=01; //01为手机号
                $Table->user_ip = get_client_ip(); //获取客户端IP
                $Table->user_moblie=$mobile;
                $ret=$Table->add();
                if ($ret){
                    $ii=new LoginAPI();
                    $this->_Msg='注册成功';
                    if (!$ii->QuserLogin($mobile)){
                        $this->_Msg.=',自动登录失败，请手工登录';
                    }else{
                        $this->_Msg.=',登录成功';
                    }
                    return true;
                }else{
                    $this->_Msg='注册失败';
                    return true;
                }

            }
        }
    }
    //手机登录
    function Qlogin(){
        $scode=session("mobcode");
        $code=I("code");
        $mobile=I("mobile");
        if (!$mobile || !$code || !$scode){
            $this->_Msg='部分数据为空';
            return false;
        }else{
            if ($code!=$scode){
                $this->_Msg='用户输入：'.$code.'Session:'.$scode.'验证码不匹配';
                //$this->_Msg='验证码输入错误';
                return false;
            }else{
                $ii=new LoginAPI();
                if (!$ii->QuserLogin($mobile)){
                    $this->_Msg.='登录失败';
                    return false;
                }else{
                    $this->_Msg.=',登录成功';
                    return true;
                }
            }
        }
    }
}	

?>