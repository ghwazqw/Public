<?php
namespace Home\Model;
use Think\Model;
class UserModel extends BaseModel {
    protected $tableName = 'qx_user_tb';
    //自定义
        function showname(){
    	echo "ghw";

	}
}

?>