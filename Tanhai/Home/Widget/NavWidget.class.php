<?php
namespace Home\Widget;
use Think\Controller;
class NavWidget extends Controller {
    //取出一级菜单


    public function def(){
       $cache = S(array('type'=>'file','prefix'=>'glxh_info','expire'=>60)); //读取缓存配置
 	   $navbar=M("navbar_tb");

        //echo $navbar->getLastSql();
        if (!$cache->Hnavone){
            $ret=$navbar->where("nav_sfyx=1 and nav_jb=1 and nav_lx=1")->order("nav_show")->select();
            $cache->Hnavone=$ret;
        }
       return $cache->Hnavone;
    }
    //取出二级菜单
    public function defr(){

        $navbar=M("navbar_tb");
        $ret=$navbar->where("nav_sfyx=1 and nav_jb=2 and nav_lx=1")->order("nav_show")->select();
        //echo $navbar->getLastSql();
        return $ret;
    }
    public function qdef(){
        $cache = S(array('type'=>'file','prefix'=>'glxh_info','expire'=>6000));
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