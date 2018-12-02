<?php
namespace Home\Widget;
use Think\Controller;
use Think\Model;
class infoWidget extends Controller {
    public function load($info_id){

        //$cache = S(array('type'=>'file','prefix'=>'glxh_file','expire'=>60)); //启用缓存
        //$cache->testcache="test1";
        //echo $cache->testcache;

        $get_wiginfo_config=M("info_widget_tb")->where("wid_id=".$info_id)->limit(1)->select();
        //var_export(count($get_wiginfo_config));
        if($get_wiginfo_config && count($get_wiginfo_config)==1){
            $get_wiginfo_config=$get_wiginfo_config[0];

            $get_wid_data=array();
            //var_export($get_wiginfo_config);
            $m=new Model();
            eval('$get_wid_data=$m->'.$get_wiginfo_config['wid_model'].';'); //读取数据库内容

            /*if (!$cache->info_list){
                eval('$get_wid_data=$m->'.$get_wiginfo_config['wid_model'].';');
                $cache->info_list=$get_wid_data;
            }*/

            $this->assign("w_title",$get_wiginfo_config["wid_title"]);
            $this->assign("w_data",$get_wid_data);
            //var_export($get_wid_data);
            $this->theme("50")->display($get_wiginfo_config["wid_tpl"]);
        }
        else{
            echo("列表信息错误！");
        }
    }
}
?>