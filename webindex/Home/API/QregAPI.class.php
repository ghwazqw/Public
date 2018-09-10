<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class QregAPI
{
	public $_page_count = ""; //统计数量

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
		$user=D("qx_user_tb");
		$getcode=I("txtcode");
		$ph=new PasswordHash(8, FALSE);
		$user->user_name=I("Username");
		$user->user_pwd=$ph->HashPassword(I("textPwd"));
		$user->user_yx=I("user_yx");
		$user->user_regdate=date('Y-m-d h:i:s');
		$user->user_sfyx=1;
		$user->user_lx=2;
		$ret=$user->add();
		if($ret){
			$data=array("txt_callback"=>1);
			echo json_encode($data);
		}
		else
		{
			$this->actionInfo='{$this->assign("sussInfo","注册失败！");}';
		}
	}

}