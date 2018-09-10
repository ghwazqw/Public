<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2018/7/10
 * Time: 上午9:30
 */
namespace Home\Controller;
use Home\API\TxSmsAPI;
use Home\API\UserAPI;

class SmsController extends PublicController {
    //发送短信页面
    public function smssend(){
        $this->theme("WebApps")->display();
    }
    //获取验证码
    public function getcode(){
        $mob=I("mobile");
        $io=new UserAPI();
        if (!$io->chmob($mob)){ //检测不能过的情况
            $zt=0;
            echo $zt;
        }else{
            $ii=new TxSmsAPI();
            $ii->SmsSender();
        }
    }
    //短信回调信息处理
    public function smscallback(){
        $Data=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ii=new TxSmsAPI();
        $ii->CallBackSms($Data);
    }
    //加密处理
    public function cookpass(){
        $key=C("cookkey");
        echo DxydEncrypt("123456",$key);
        $str="MDAwMDAwMDAwMIWEea6BfYiT";
        echo DxydDecrypt($str,$key);
    }
}