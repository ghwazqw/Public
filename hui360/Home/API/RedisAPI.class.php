<?php

namespace Home\API;
use Think\Cache\Driver\Redis;

class RedisAPI{
    public $_cilck="";
    function set_redis(){
        $redis=new \Redis();
        $redis_address=C("Redis_config");
        //echo $redis_ip;
        $redis->connect($redis_address["host"],$redis_address["port"]);
        return $redis;
        /*if (!$redis){
            echo "Service Error!";
            return false;
        }
        else {
        $redis->incr("new_id");
        echo $redis->get("new_id");
        }*/
    }
    //设置redis值
    function Yw_data($key,$max,$where){

        $redis=self::set_redis();
        if (!$redis) return false;
        $get_count=intval($redis->get($key));
        //echo $get_count;
        if ($get_count==$max){
            //超过最大值
            $redis->incr("$key");
            $data = array("update"=>$key,"click"=>$get_count+1);
            $this->_cilck = 0;
            $update_table=D("info_meta_tb");
            $source = $data["update"]; //按下划线分离字符串
            $str = explode('_',$source);
            //echo $str[0]."<br />";
            //echo $str[1]."<br />";
            $update_table->lx=$str[0];
            $update_table->info_id=$str[1];
            //$update_table->cilck=$data["click"];
            //查询是否有重复数据
            $where['lx']  = array('eq',$str[0]); //类型
            $where['info_id']  = array('eq',$str[1]); //数据ID
            $where['im_key']  = array('eq',"dianji"); //数据ID
            $this->_page_count=$ret=$update_table->where($where)->order("id DESC")->count();
            $this->_main_data=$ret=$update_table->where($where)->order("id DESC")->select();


            if ($this->_page_count==0){
                $update_table->im_value=$data["click"];
                $update_table->im_key="dianji";
                $update_table->add();
            }
            else{
                $id="";
                $cil="";
                foreach($this->_main_data as $id_info){
                    $id=$id_info["id"];
                    $cil=$id_info["im_value"];
                }
                $update_table->im_value=$data["click"]+$cil;
                $update_table->where($where)->save();
            }
            //echo D("info_meta_tb")->_sql();
            //重置redis key值
            $redis->delete($data["update"]);


            //var_export($data);
        }
        else
        {
            $redis->incr("$key");
            $this->_cilck = $redis->get("$key");
        }
    }
}