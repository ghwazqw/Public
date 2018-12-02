<?php
namespace Home\API;

class MenuAPI
{
    public $_main_data=array(); //主数据数组
    public $_dal_data=array(); //子数据数组

    //加载菜单数据
    function LoadMenuInfo($lx){
        $MenuTable=M("auth_menu_tb");
        if ($lx!=0){
            $where["menu_jb"]=array("eq",$lx);
        }
        $this->_main_data=$MenuTable->where($where)->order("id")->select();
    }
    //按照权限加载菜单信息
    function LoadAuthMenuInfo($lx){
        /*获取当前用户ID*/
        $userinfo=New UserAPI();
        $userinfo->GetUserInfo();
        $userid=$userinfo->_userid;
        //echo $userid;
        /*按照用户ID找出角色ID*/
        $GTable=M("auth_group_access"); //角色表
        $where["uid"]=array("eq",$userid);
        $Groupid=$GTable->where($where)->getField("group_id");
        /*按照角色ID读取对应的菜单id*/
        $Atable=M("auth_group");
        $Awhere["id"]=array("eq",$Groupid);
        $Authid=$Atable->where($Awhere)->getField("rules");
        //echo $Authid;
        /*按照获取到的权限id读取出菜单*/
        $MenuTable=M("auth_menu_tb");
        $Mwhere["menu_jb"]=array("eq",$lx);
        $Mwhere["id"]=array("in","$Authid");
        $this->_main_data=$MenuTable->where($Mwhere)->order("id")->select();
        //var_export($this->_main_data);
    }
    //加载菜单树
    function LoadMenuTree(){
        $Table=M("auth_menu_tb");
        $ret=$Table->order("id")->getField('id,menu_sjid,menu_mc as text');
        //echo $Table->_sql();
        //var_export($ret);
        $this->_main_data=$ret;
        //echo json_encode($ret);
    }
    //加载菜单详细信息
    function LoadMenuDal($id){
        $Table=M("auth_menu_tb");
        $where["id"]=array("eq",$id);
        $this->_dal_data=$Table->where($where)->select();
    }
    function MenuEdit($id){
        $Table=M("auth_menu_tb");
        $Table->menu_mc=I("menu_mc");
        $Table->menu_sfyx=I("menu_sfyx");
        $Table->menu_icon=I("menu_icon");
        $Table->menu_link=I("menu_link");
        $Table->menu_sffg=I("menu_sffg");
        if (!$id){
            if (!I("menu_sjid")){
                $sjid=0;
                $js=1;

            }else{
                $sjid=I("menu_sjid");
                $js=2;
            }
            $Table->menu_jb=$js;
            $Table->menu_sjid=$sjid;
            $ret=$Table->add();
            $menuid=$ret;
            //exit($menuid);
            if (!$ret){
            }else{
                $Name="Home/".I("menu_link");
                $title=I("menu_mc");
                /*增加权限控制表信息*/
                $Auth=new ActionAPI();
                if ($Auth->AddAuthTable($Name,$title,$menuid,1)){ }else
                    {
                    $ret=0;
                }
            }
        }else{
            $where["id"]=array("eq",$id);
            $count=$Table->where($where)->count();
            if (!$count || $count==0){
                $ret=0;
            }else{
                $ret=$Table->where($where)->save();
            }
        }
        return $ret;
    }
}	
