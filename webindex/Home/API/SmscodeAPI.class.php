<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class SmscodeAPI
{
		 function createSMSCode($length = 6){
			$min = pow(10 , ($length - 1));
			$max = pow(10, $length) - 1;
			//return rand($min, $max);
			 ob_clean ();
			 echo rand($min, $max);
		}
	// 获取图片验证码，刷新图片验证码
	function getPicCode(){
		$config = array(
			'fontSize'=>30, // 验证码字体大小
			'length'=>4, // 验证码位数
			'useNoise'=>false, // 关闭验证码杂点
			'expire'=>600
		);
		$Verify = new \Think\Verify($config);

		$Verify->entry(2333);//2333是验证码标志
	}
}	

