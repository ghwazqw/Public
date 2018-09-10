<?php
namespace Home\API;

class DelDataAPI
{
    public $_info="";
    //树形数据删除
    function Deltreeinfo(){
        $Table=I("table");
        $id=I("cglx_id");
        if (!$Table || !$id){
            echo "信息错误，请检查!";
        }else{
            $Acttable=D($Table);
            $count=D($Table)->where("cglx_sjid=$id")->count();
            if ($count>=1){
                echo "下属还有信息，请先删除！";
                exit();
            }else{
                $Acttable->where("id=$id")->delete();
                echo "信息删除成功!";
            }
        }
    }
    //普通信息数据删除
    function DelInfo(){
        $Table=I("table");
        $id=I("id");
        if (!$Table || !$id){
            echo "Info Error";
            exit();
        }else{
            $Acttable=D($Table);
            $Acttable->where("id=$id")->delete();
            $this->_info="OK";
        }

    }
}