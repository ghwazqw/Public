<?php
namespace Home\API;

class MenuAPI
{
	public $_page_size="100"; //每页显示条数
	public $_page_bar=""; //分布组件需要展示的内容
	public $_page_count=""; //统计数量
	public $_main_data=array(); //主表数据
	public $_dateil_data=array();  //子表数据
	public $_keyword=""; //
	public $_class_data="";
	public $_class_meta_data="";
	public $_xmbh="";
	public $actionInfo=""; //返回要执行的动作
    public $_info="";

    //加载菜单数据
    function LoadMenuData(){
        //加载主分类数据
        $cache = S(array('type'=>'file','prefix'=>'comp_info','expire'=>1)); //读取缓存配置
        if (!$cache->Cg_Classone){
            $ret=M("qx_menu_tb")->where("cglx_jb=1".$where)->order("id")->select();
            $cache->cg_class=$ret;
        }
        $this->_class_data=$cache->cg_class;
        //循环取出主分类表中的ID
        $set_class_id="";
        foreach($this->_class_data as $class_id){
            if ($set_class_id!="")
                $set_class_id.=",";
            $set_class_id.=$class_id["id"];
            //echo $set_class_id;
        }
        if ($set_class_id!=""){
            //取出子分类数据
            if (!$cache->Cg_Classtwo){
                $ret=M("qx_menu_tb")->where("cglx_sjid in (".$set_class_id.") and cglx_jb=2")->order("id")->select();
                $cache->Cg_Classtwo=$ret;

            }
            $this->_class_meta_data=$cache->Cg_Classtwo;
            $set_towclass_id="";
            foreach($this->_class_meta_data as $class_id){
                if ($set_towclass_id!="")
                    $set_towclass_id.=",";
                $set_towclass_id.=$class_id["id"];
                //echo $set_towclass_id;
            }
            if ($set_class_id!=""){
                //取出三级分类数据
                if (!$cache->Cg_Classthree){
                    $ret=M("qx_menu_tb")->where("cglx_sjid in (".$set_towclass_id.") and cglx_jb=3")->order("id")->select();
                    $cache->Cg_Classthree=$ret;
                }
                $this->_dateil_data=$ret;
                //echo $ret;
                //echo M("comp_tb")->_sql();
                //var_export($this->_dateil_data);

            }
        }
    }
    //按照权限加载菜单数据
    function LoadRoleMenuData(){
        //读取cookie信息
        $GetUser=new UserAPI();
        $GetUser->getuser();
        $user_info=$_COOKIE['user_info'];
        $globar_user=unserialize($user_info);
        $user_role=$globar_user->user_role;
        //echo $user_role;
        $where["RoleName"]  = array('eq',"$user_role");
        $retr=M("qx_rolemenu_tb")->where($where)->select();
        //echo M("qx_rolemenu_tb")->_sql();
        foreach ($retr as $menu){
            $rolemenu=$menu['rolemenu'];
        }
        //exit();
        //加载主分类数据
        //$mmap["id"]  = array('in',"$rolemenu");
        $mmap["cglx_jb"]  = array('eq',1);
        $cache = S(array('type'=>'file','prefix'=>'menu_info','expire'=>1)); //读取缓存配置
        if (!$cache->Cg_Classone){
            $ret=M("qx_menu_tb")->where($mmap)->order("id")->select();
            $cache->cg_class=$ret;
        }
        $this->_class_data=$cache->cg_class;
        //echo M("qx_menu_tb")->_sql();
        //var_export($ret);
        //exit();
        //循环取出主分类表中的ID
        $set_class_id="";
        foreach($this->_class_data as $class_id){
            if ($set_class_id!="")
                $set_class_id.=",";
            $set_class_id.=$class_id["id"];
            //echo $set_class_id;
        }
        if ($set_class_id!=""){
            //取出子分类数据
            $mmap["id"]  = array('in',"$rolemenu");
            $mmap["cglx_jb"]  = array('eq',2);
            if (!$cache->Cg_Classtwo){
                $ret=M("qx_menu_tb")->where($mmap)->order("id")->select();
                $cache->Cg_Classtwo=$ret;
            }
            //echo M("qx_menu_tb")->_sql();
            $this->_class_meta_data=$cache->Cg_Classtwo;
            $set_towclass_id="";
            foreach($this->_class_meta_data as $class_id){
                if ($set_towclass_id!="")
                    $set_towclass_id.=",";
                $set_towclass_id.=$class_id["id"];
                //echo $set_towclass_id;
            }
            if ($set_class_id!=""){
                //取出三级分类数据
                $mmap["id"]  = array('in',"$rolemenu");
                $mmap["cglx_jb"]  = array('eq',3);
                if (!$cache->Cg_Classthree){
                    $ret=M("qx_menu_tb")->where($mmap)->order("id")->select();
                    $cache->Cg_Classthree=$ret;
                }
                $this->_dateil_data=$ret;
                //echo $ret;
                //echo M("comp_tb")->_sql();
                //var_export($this->_dateil_data);

            }
        }
    }
    //编辑菜单信息
    //编辑信息
    function MenuEdit(){
        $id=I("cglx_id");
        $info_edit_tb = D("qx_menu_tb");
        $info_edit_tb->cglx_mc=I("cglx_mc");
        $info_edit_tb->where("id=$id")->save();
        echo "信息编辑成功";
    }
    //菜单信息增加
    function MenuAdd(){
        //需提交的数据接收
        $title=I("title");
        $cglx_fl=I("cglx_fl");
        $cglx_sfyx=I("cglx_sfyx");

        //辅助数据接收
        $cglx_id=I("cglx_id");
        //判断上级分类和分类等级
        if ($cglx_fl==1 or $cglx_fl=="" ){
            $cglx_sjid=0;
            $cglx_jb=1;
        }
        elseif ($cglx_fl==2){
            $cglx_sjid=I("cglx_sjid");
            $cglx_jb=I("cglx_jb");
        }
        elseif ($cglx_fl==3) {
            $cglx_sjid=I("cglx_id");
            $cglx_jb=I("cglx_jb")+1;
        }
        //echo $cglx_jb;
        $info_add_tb = D("qx_menu_tb");
        $info_add_tb->cglx_mc = $title;
        $info_add_tb->cglx_sjid = $cglx_sjid;
        $info_add_tb->cglx_jb = $cglx_jb;
        $info_add_tb->cglx_sfyx = $cglx_sfyx;
        //菜单信息
        $info_add_tb->menu_icon = I("menu_icon");
        $info_add_tb->menu_sfzk = I("menu_sfzk");
        $info_add_tb->menu_link = I("menu_link");
        $info_add_tb->add();
        $this->actionInfo='{$this->assign("sussInfo","信息录入成功，请继续！");}';

    }
    function MenuRoleList(){
        $table=M("qx_rolemenu_tb");
        $RoleNmae=I("Role");
        if (!$RoleNmae){
            echo "角色读取错误";
        }else{
            $this->actionInfo=$RoleNmae;

        }
    }
    function EditRoleMenu(){
        $table=D("qx_rolemenu_tb"); //角色菜单表
        $select_roleid=I("select_roleid"); //接收变量
        $select_rolename=I("select_rolename"); //接收角色名称
        $select_info=I("select_info"); //接收具体菜单信息
        $table->Rolid=$select_roleid;
        $table->RoleName=$select_rolename;
        $table->rolemenu=$select_info;

        $where["Rolid"]  = array('eq',$select_roleid); //判断ID是否存在
        $count=$table->where($where)->count(); //读取菜单信息
        if ($count>0){ //如大于0时，更新数据
            $ret=$table->where($where)->save();
        }else{ //否则新增数据
            $ret=$table->add();
        }
        //echo $table->_sql();
    }
}	
