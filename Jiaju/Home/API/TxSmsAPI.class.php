<?php
namespace Home\API;


class TxSmsAPI
{
/*
 *
 * 短信模板
 * {1}为您的登录验证码，请于{2}分钟内填写。如非本人操作，请忽略本短信。
 *
 * */

   //通过https 中的get 或 post
    function get_web($url, $data = null, $header = null, $ip = null)
    {
        $https = substr($url, 0, 5);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if ('https' == $https) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        if (!empty($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER  , $header);
        }

        if (!empty($ip)) {
            $header= array(
                'CLIENT-IP:'.$ip,
                'X-FORWARDED-FOR:'.$ip
            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        $char_a = array('GBK', 'GB2312', 'ASCII','UTF-8');
        $encode = mb_detect_encoding($output, $char_a);
        if ('UTF-8' != $encode && in_array($encode, $char_a)) {
            $string = mb_convert_encoding($string, 'UTF-8', $encode);
        }
        curl_close($curl);
        return $output;
    }
    //生成sig
    function CreateSig($appkey){
        $hash=hash("sha256",$appkey);
        return $hash;
    }
    //接收返回json并转换成数组
    function json2array($json){
        return json_decode($json,true);
    }



    //发送短信
     function SmsSender(){
        //读取短信配置
         $sms=C("Tx_sms");
         $appkey=$sms["Sms_appkey"]; //appkey
         $appid=$sms["Sms_appid"]; //appid
         $random=$sms["random"]; //随机数
         $tpl_id=$sms["tpl_id"]; //内容模板id
         $sign=$sms["sign"]; //签名

        //接收前台传递变量
         $time=I("time");
         $mobile=I("mobile"); //手机号
         //发送参数设置
         $type=0; //短信类型，单一指定模板0

         $code=mt_rand(100000,999999); //随机数验证码
         session('mobcode',$code); //设置SESSION

         //session(array('name'=>'mobcode','expire'=>3600*15));
         $Country_code=86; //国家代码
         $yx_date=15; //有效时间
         //$cyf="韵达快递"; //韵达

         /*生成sig*/
         $hash="appkey=".$appkey."&random=".$random."&time=".$time."&mobile=".$mobile;
         $sig=$this->CreateSig($hash);
         /*提效url*/
         $send_url="https://yun.tim.qq.com/v5/tlssmssvr/sendsms?sdkappid=".$appid."&random=".$random;
         /*短信内容设置*/
         $sms_tpl='{
        "type":'.$type.', 
        "ext":"",
        "extend": "",
        "params":[
            "'.$code.'", 
            "'.$yx_date.'"
        ],
        "sig":"'.$sig.'",
        "sign":"'.$sign.'",
        "tel": {
            "mobile": "'.$mobile.'",
            "nationcode": "'.$Country_code.'"
        },
        "time":'.$time.',
        "tpl_id":'.$tpl_id.'
        }';

         $ii=new ActionAPI();
         $ret=$this->get_web($send_url,$sms_tpl);
         $retdata=$this->json2array($ret);
             if ($retdata["result"]==0){
                 //echo '1';
                 //$this->Smstable($mobile,$time,$code,$yx_date,1,$retdata["result"]); //记录发送信息至数据库
                 $ii->UserLogInfoRecode(50,1,$mobile,1); //记录日志
                 //$ii->UserCache($mobile); //记录缓存
                 return true;
             }else{
                 //失败的业务逻辑处理
                 //$this->Smstable($mobile,$time,$code,$yx_date,0,$retdata["result"]);
                 $ii->UserLogInfoRecode(50,0,$mobile,1); //记录日志
                 //echo $retdata["result"];
                 return false;
             }
     }
     //短信处理类
    function Smstable($mobile,$time,$code,$yx_date,$zt,$retdata){
        $SmsTable=M("sms_tb");
        $SmsTable->mobile=$mobile;
        $SmsTable->timed=$time;
        $SmsTable->code=$code;
        $SmsTable->yxq=$yx_date;
        $SmsTable->zt=$zt;
        $SmsTable->msg=$retdata;
        $SmsTable->send_datetime=date('Y-m-d H:i:s',time());
        $SmsTable->add();
    }
     //发送短信回调信息处理
    function CallBackSms($Data){
        $ret=$this->json2array($Data);
        $ii=new ActionAPI();
        foreach ($ret as $info){
            $mobile=$info["mobile"]; //接收手机号
            $report_status=$info["report_status"]; //接收状态
            $description=$info["description"]; //信息
            $errmsg=$info["errmsg"]; //错误信息
            $sid=$info["sid"]; //唯一标识
            $user_receive_time=$info["user_receive_time"]; //接收时间
        }
        if ($report_status=="SUCCESS"){
            $ii->UserLogInfoRecode(49,1,$mobile,1);
        }else{
            $ii->UserLogInfoRecode(49,0,$mobile,1);
        }
    }
}	
