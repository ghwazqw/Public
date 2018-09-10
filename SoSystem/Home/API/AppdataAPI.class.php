<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/3/29
 * Time: 上午9:04
 */
namespace Home\API;

class AppdataAPI
{
   public function AuthentState($appid,$restid,$token){

   }
    /**
     *  作用：产生随机字符串，不长于32位
     */
    function createNoncestr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        echo $str;
    }
}