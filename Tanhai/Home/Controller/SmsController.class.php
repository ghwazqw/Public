<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */
namespace Home\Controller;
use Home\API\TxSmsAPI;


class SmsController extends PublicController {
    //发送短信页面
    public function smssend(){
        $this->theme("WebApps")->display();
    }
    //获取验证码
    public function getcode(){
        $mob=I("mobile");
            $ii=new TxSmsAPI();
            if ($ii->SmsSender($mob)){
                echo "OK";
            }else{
                echo "error";
            }
    }
    //短信回调信息处理
    public function smscallback(){
        $Data=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ii=new TxSmsAPI();
        if ($ii->CallBackSms($Data)){
            echo "发送成功";
        }else{
            echo "error";
        }
    }
    //加密处理
    public function cookpass(){
        $key=C("cookkey");
        echo DxydEncrypt("123456",$key);
        $str="MDAwMDAwMDAwMIWEea6BfYiT";
        echo DxydDecrypt($str,$key);
    }
}