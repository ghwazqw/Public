<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class UserAPI //填写控制器名称规则:"控制器名称+API"
{
    public $_page_size = "40"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $_keyword = ""; //
    public $_class_data = "";
    public $_class_meta_data = "";
    public $_xmbh = "";
    public $actionInfo = ""; //返回要执行的动作
    public $_pass = "";

    //获取用户登录后的信息对象

    function getuser()
    {
        $get_logincook = $_COOKIE['user_info'];
        if (!$get_logincook) return false; //
        $get_user_log = unserialize($get_logincook);
        if (!$get_user_log) return false;
        if ($get_user_log->user_id && intval($get_user_log->user_id) > 0) {
            return $get_user_log;
        }
        return false;
    }

    function ActUser()
    {
        $user = D("qx_user_tb");
        $infoid = I("meta");
        $act_lx = I("Act");
        if ($_GET) {
            if ($act_lx == "mu") {
                if (!$infoid) {
                    echo "Id Error!";
                } else {
                    $user->where("id=$infoid")->delete();

                }
            }
        }
    }

    function isLogin()
    {
        //判断用户是否登录
        $u = $this->getuser();
        if ($u->user_id && intval($u->user_id) > 0) {
            return true;
        }
    }

    function add_user()
    {
        $user = D("qx_user_tb");
        $ph = new PasswordHash(8, FALSE);
        try {
            if ($_POST) {
                $user->user_name = I("Username");
                $user->user_pwd = $ph->HashPassword(I("textPwd"));
                $user->user_regdate = date('Y-m-d h:i:s');
                $user->user_sfyx = 1;
                $user->user_lx = 1;
                $ret = $user->add();
                if ($ret) {
                    //$this->actionInfo='{$this->assign("sussInfo","用户增加成功，请继续！");}';
                    $this->actionInfo = "header('location:/index.php/home/user/U_manage');";
                } else {
                    $this->actionInfo = '{$this->assign("sussInfo","增加失败，请继续！");}';
                }
            }
        } catch (\Think\Exception $ex) {
            $ex->getMessage();
            $this->actionInfo = '{$this->assign("errorInfo","该用户名被占用，请检查！");}';
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
            $this->_dateil_data = $result = M("qx_user_tb")->where("user_name='" . $get_UserName . "' and user_lx=2")->limit(1)->select();
            //echo $get_UserName;
            //var_export($this->_dateil_data);
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
            $user->user_cz = I("user_cz");
            $get_UserName = I("user_name");
            if (!$get_UserName) {
                echo I("user_name");
                echo "UserInfo Error!";
                exit();
            } else {
                $user->where("user_name='" . $get_UserName . "'")->save();
                //echo D("qx_user_tb")->_sql();
                redirect('/index.php/home/Quser/user_cent', 1, '编辑成功，正在返回用户中心...');
            }

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
            $this->_dateil_data = $result = M("qx_user_tb")->where("user_name='" . $get_UserName . "' and user_lx=2")->limit(1)->field("user_pwd")->select();
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
                    redirect('/index.php/home/Quser/user_cent', 1, '编辑成功，正在返回用户中心...');
                } else {
                    echo "旧密码信息输入错误，请检查";
                    exit;
                }


            }

        }
    }

    function Editguestbook()
    {
        if ($_POST) {
            $info_add_tb = D("ly_tb");
            $info_add_tb->title = I("title");
            $info_add_tb->content = I("content");
            $info_add_tb->tjr = I("tjr");
            $info_add_tb->tjsj = date('Y-m-d H:i:s', time());
            /*$info_add_tb->title=I("title");
            $info_add_tb->title=I("title");*/
            $info_add_tb->add();
            redirect('/index.php/home/Quser/user_cent', 1, '提交成功请耐心等待回复，即将返回用户中心...');
        }
    }


    function loadmatedata($where)
    {
        $TableName = M("qx_user_tb");
        $this->_keyword = I("keyword");
        if ($this->_keyword != "") {
            $where["user_name"] = array('like', "%$this->_keyword%");
            $where["user_xm"] = array('like', "%$this->_keyword%");
            $where["user_comp"] = array('like', "%$this->_keyword%");
            $where["user_zw"] = array('like', "%$this->_keyword%");
            $where["user_dh"] = array('like', "%$this->_keyword%");
            $where["user_sj"] = array('like', "%$this->_keyword%");
            $where["user_yx"] = array('like', "%$this->_keyword%");
            $where["user_lxdz"] = array('like', "%$this->_keyword%");
            $where["user_cz"] = array('like', "%$this->_keyword%");
            $where['_logic'] = 'OR';
        }
        //加载主表数据
        $this->_page_count = $count = $TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count, $this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar = $Page->show(); //把分布内容赋值给变量
        $this->_main_data = $TableName->where($where)->order("id DESC")->where("user_lx=2")->LIMIT($Page->firstRow . ',' . $Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }

    function loaddata($where)
    {
        $TableName = M("qx_user_tb");
        $this->_keyword = I("keyword");
        if ($this->_keyword != "") {
            $where["user_name"] = array('like', "%$this->_keyword%");
            $where["user_xm"] = array('like', "%$this->_keyword%");
            $where["user_comp"] = array('like', "%$this->_keyword%");
            $where["user_zw"] = array('like', "%$this->_keyword%");
            $where["user_dh"] = array('like', "%$this->_keyword%");
            $where["user_sj"] = array('like', "%$this->_keyword%");
            $where["user_yx"] = array('like', "%$this->_keyword%");
            $where["user_lxdz"] = array('like', "%$this->_keyword%");
            $where["user_cz"] = array('like', "%$this->_keyword%");
            $where['_logic'] = 'OR';
        }
        //加载主表数据
        $this->_page_count = $count = $TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count, $this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar = $Page->show(); //把分布内容赋值给变量
        $this->_main_data = $TableName->where($where)->order("id DESC")->where("user_lx=1")->LIMIT($Page->firstRow . ',' . $Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }

    //检测邮箱并发送验证邮件
    function CheckEmail($where)
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

    //根据邮件重置密码
    function ReSetPass($where)
    {
        $H = I("h");
        $TableName = M("quser_zhma_tb");
        $where["user_md5"] = array('eq', "$H");
        $ret = $TableName->where($where)->order("id desc")->find();
        //echo $TableName->_sql();
        if (!$ret) {
            echo "Info Error";
            exit();
        } else {
            $this->_keyword = $ret['user_id'];
            //echo $ret['user_id'];
            $current_date = $ret['user_zhsj'];
            $zhsj = date('Y-m-d H:m:s', strtotime("$current_date + 1 day"));
            $dqsj = date('Y-m-d H:m:s');
            if (strtotime($zhsj) < strtotime($dqsj)) {
                $this->_pass = "OK";
            } else {
                $this->_pass = "dateInfoError";
            }
            //echo $zhsj;
        }

    }

    function editpass()
    {
        $id = I("id");
        if (!$id) {
            echo "id error";
            exit();
        }
        $ph = new PasswordHash(8, FALSE);
        $user = D("qx_user_tb");
        $user->user_pwd = $ph->HashPassword(I("textPwd"));
        $user->where("id=$id")->save();
        //echo D("qx_user_tb")->_sql();
        redirect('/?a=user_login&c=Quser', 1, '密码修改成功，正在转入登录页面...');
    }


	function login(){
	   $get_UserName = I("post.Username","","/^\w{3,20}$/");
       $get_UserPwd = I("post.textPwd","","/^\w{3,20}$/");
		$getcode=I("post.txtcode");
		$get_sj=I("post.sj");
		$get_lx=I("post.aa");
		$ip = get_client_ip();
		//后端用户登录
		if ($get_lx!="q") {

		$Verify = new \Think\Verify();
			//登录日志存储过程
			$model = M("");

       if ($get_UserName=="" || $get_UserPwd==""){

       	 $this->actionInfo='$this->assign("errorInfo","用户名密码输入错误，请检查！");';
		   $sql = "call sp_user_login('{$get_UserName}','Error','$ip','user/pwd null')";
		   $ref = $model -> query($sql);
       return; 
       }
		else if(!$Verify->check($getcode)){
			$this->actionInfo='$this->assign("errorInfo","验证码输入错误，请检查！");';

			return;
		}
       else
       {
       	$result=M("qx_user_tb")->where("user_name='".$get_UserName."' and user_lx=1")->limit(1)->select();
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
				$use_log->user_comp=$result[0]["user_comp"];
				$use_log->user_lx="q";
				if ($get_sj!=""){
       			setcookie("user_info",serialize($use_log),time()+3600,"/");
					$sql = "call sp_user_login('{$get_UserName}','successful','$ip','1 day')";
					$ref = $model -> query($sql);
				}
				else{
				setcookie("user_info",serialize($use_log),time()+3600*12*7,"/");
					$this->actionInfo="header('location:/index.php/home/Manage');";
					$sql = "call sp_user_login('{$get_UserName}','successful','$ip','7 day')";
					$ref = $model -> query($sql);
				}

       			return; //不再执行以下操作
       		}
       		else{
       			$this->actionInfo='{$this->assign("errorInfo","密码错误！");}';
				$sql = "call sp_user_login('{$get_UserName}','error','$ip','password error')";
				$ref = $model -> query($sql);
       			return; //不再执行以下操作
       		}
       		
       	}
       	else{
       		$this->actionInfo='$this->assign("errorInfo","无此用户，请检查！");';
			$sql = "call sp_user_login('{$get_UserName}','error','$ip','username error')";
			$ref = $model -> query($sql);
       	    return;
       	}
       }	
	}
		//前端用户登录
		else{
			$Verify = new \Think\Verify();

			if ($get_UserName=="" || $get_UserPwd==""){
				$this->actionInfo='$this->assign("errorInfo","用户名密码输入错误，请检查！");';
				return;
			}
			else if(!$Verify->check($getcode)){
				$this->actionInfo='$this->assign("errorInfo","验证码输入错误，请检查！");';
				return;
			}
			else
			{
				$result=M("qx_user_tb")->where("user_name='".$get_UserName."' and user_lx=2 and user_sfyx=1")->limit(1)->select();
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
						$use_log->user_comp=$result[0]["user_comp"];
						$use_log->user_lx="h";
						if ($get_sj!=""){
							setcookie("user_info",serialize($use_log),time()+3600,"/");
						}
						else{
							setcookie("user_info",serialize($use_log),time()+3600*12*7,"/");
						}
						$this->actionInfo="header('location:/index.php/home/Quser/user_cent');";
						return; //不再执行以下操作
					}
					else{
						$this->actionInfo='{$this->assign("errorInfo","密码错误！");}';
						return; //不再执行以下操作
					}
				}
				else{
					$this->actionInfo='$this->assign("errorInfo","无此用户或正在审核中！");';
					return;
				}
			}
		}
	}
	
}	

?>