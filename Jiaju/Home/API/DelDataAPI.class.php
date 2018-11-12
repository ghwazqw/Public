<?php
namespace Home\API;

class DelDataAPI
{
    public $_info="";
    //菜单数据删除
    function Deltreeinfo($Table,$id){
        if (!$Table || !$id){
            echo "信息错误，请检查!";
        }else{
            $Acttable=D($Table);
            $count=D($Table)->where("menu_sjid=$id")->count();
            if ($count>=1){
                echo "下属还有信息，请先删除！";
                exit();
            }else{
                $Acttable->where("id=$id")->delete();
                echo "信息删除成功!";
            }
        }
    }
    //树形数据删除
    function DelTreeNewInfo($Table,$id,$where){
        if (!$Table || !$id || !$where){
            echo "信息错误，请检查!";
        }else{
            $Acttable=D($Table);
            $count=D($Table)->where($where)->count();
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
    function DelInfo($Table,$id){
        if (!$Table || !$id){
            return false;
        }else{
            $Acttable=M($Table);
            if ($id=="all"){
                $Acttable->where('1')->delete(); //删除表中的所有数据
            }
            else{
                if ($Table=="info_tb"){
                    $Acttable->where("n_id=$id")->delete();
                }else{
                    $Acttable->where("id=$id")->delete();
                }
            }
            //echo $Acttable->_sql();
            return true;
        }
    }
    //按照条件删除数据
    function DelSortInfo($Table,$where){
        if (!$Table || !$where){
            return false;
        }else{
            $Acttable=M($Table);
            $Acttable->where($where)->delete();
            //echo $Acttable->_sql();
            return true;
        }
    }
    //包含子数据的表删除
    function DelSubInfo($Table,$SubTable,$id,$lx){ //要求的四个参数为：操作表、子数据表、主表ID、类型字段
        $ii=new ActionAPI();
        $ii->ChId($Table);
        $ii->ChId($SubTable);
        $ii->ChId($id);
        $SubTable=M($SubTable);
        $ActTable=M($Table);
        $where[$lx]=array("eq",$id);
        $count=$SubTable->where($where)->count();
        if ($count>0){
            return false;
        }else{
            $Twhere["id"]=array("eq",$id);
            $ret=$ActTable->where($Twhere)->delete();
            //echo $Table->_sql;
            if (!$ret){
                return false;
            }else{
                return true;
            }
        }
    }
    //角色有效无效操作类
    function Status($id,$status,$Table){ //id，状态，操作表名
        $Table=M($Table);
        if ($status==1){
            $Mst=0;
        }else{
            $Mst=1;
        }
        $Table->status=$Mst;
        $where["id"]=array("eq",$id);
        $ret=$Table->where($where)->save();
        if (!$ret){
            return false;
        }else{
            return true;
        }
    }
}