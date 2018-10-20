<?php
namespace Home\Widget;
use Home\API\UserAPI;
use Think\Controller;
class NavWidget extends Controller {
    //取出一级菜单
    public $_username="";

    public function _initialize(){
        $get_logincook = $_COOKIE['user_info'];
        $get_user_log = unserialize($get_logincook);
        $this->_username=$get_user_log->user_name;
    }
    public function def(){
       $cache = S(array('type'=>'file','prefix'=>'glxh_info','expire'=>3)); //读取缓存配置
 	   $navbar=M("navbar_tb");

        //echo $navbar->getLastSql();
        if (!$cache->Hnavone){
            if ($this->_username!="rootsystem"){
                $ret=$navbar->where("nav_sfyx=1 and nav_jb=1 and nav_lx=1")->order("nav_show")->select();
            }else{
                $ret=$navbar->where("nav_sfyx=1 and nav_jb=1 and nav_lx=1 and nav_auth=1")->order("nav_show")->select();
            }
            $cache->Hnavone=$ret;
        }
       return $cache->Hnavone;
    }
    //取出二级菜单
    public function defr(){

        $navbar=M("navbar_tb");
        if ($this->_username!="rootsystem"){
            $ret=$navbar->where("nav_sfyx=1 and nav_jb=2 and nav_lx=1")->order("nav_show")->select();
        }else{
            $ret=$navbar->where("nav_sfyx=1 and nav_jb=2 and nav_lx=1 and nav_auth=1")->order("nav_show")->select();
        }
        //echo $navbar->getLastSql();
        return $ret;
    }
    public function qdef(){
        $cache = S(array('type'=>'file','prefix'=>'glxh_info','expire'=>6));
        $navbar=M("navbar_tb");
        if(!$cache->Qnavbar){
            $ret=$navbar->where("nav_sfyx=1 and nav_jb=1 and nav_lx=2")->order("nav_show")->select();
            $cache->Qnavbar=$ret;
        }
        //echo $navbar->getLastSql();
        return $cache->Qnavbar;
    }
}

?>