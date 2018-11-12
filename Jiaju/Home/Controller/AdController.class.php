<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */
namespace Home\Controller;


use Home\API\ActionAPI;
use Home\API\AdAPI;
use Home\API\DelDataAPI;
use Home\API\UserAPI;

class AdController extends PublicController {

    public function _initialize(){
        parent::_initialize();
        //parent::_IsAuth();
    }
    public function AdSortManage(){

        $this->assign("title","广告(AD)类型管理");
        $this->theme("webapps")->display();
    }
    public function AdManage(){
        $this->assign("title","广告信息管理");
        $this->theme("webapps")->display();
    }
    public function UpImg(){

        //获取当前登录名
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $get_UserName=$ii->_username;

        $sort=I("sort");
        $io=new ActionAPI();
        if ($io->ImgUpload($sort)){
            $ImgUrl="/".$io->_ImgUrl;
            if ($io->UpTmppImg($ImgUrl,'ad',$get_UserName)){
                $Msg="记录成功";
            }else{
                $Msg="记录失败";
            }
            echo json_encode(array('code' => 200, 'src' => $ImgUrl,'Msg' => '上传成功'.$Msg));
        }else{
            echo json_encode(array('code' => 500,'Msg' => $ii->_Msg));
        }
    }
    public function ClearImg(){
        $sort=I("sort");
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $get_UserName=$ii->_username;
        $ii=new DelDataAPI();
        $where['sort']=array('eq',$sort);
        $where['username']=array('eq',$get_UserName);
        if ($ii->DelSortInfo('imgtmp_tb',$where)){
            echo json_encode(array('code' => 200, 'Msg' => '删除成功'));
        }else{
            echo json_encode(array('code' => 500, 'Msg' => '删除失败'));
        }
    }
    public function adItemEdit(){
        $ii=new UserAPI();
        $ii->GetUserInfo();
        $get_UserName=$ii->_username;
        $type=I("ad_id");
        $keyword=I("keyword");
        $ii=new AdAPI();
        if ($ii->EditAdItem($get_UserName,$type,$keyword)){
            //清空临时表
            $io=new AdAPI();
            if ($io->ClearTmp($get_UserName)){
                $Msg="临时表删除成功";
            }else{
                $Msg="临时表删除失败";
            }

            echo json_encode(array('code' => 200, 'Msg' => '信息编辑成功'.$Msg));
        }else{
            echo json_encode(array('code' => 500, 'Msg' => '信息编辑失败'.$Msg));
        }

    }
}