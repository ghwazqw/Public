<?php
namespace Home\API;
class JcxxAPI
{
    public $_page_size="25"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字
    public $_class_data=""; //分类信息
    public $_class_meta_data=""; //子分类信息
    public $_class_three_data="";
    public $_xmbh=""; //项目编号
    public $_lx="";

    function loadclassdata(){
        //加载主分类数据
        //$cache = S(array('type'=>'file','prefix'=>'glxh_info','expire'=>6000)); //读取缓存配置
            $this->_class_data=$et=M("zclx_tb")->where("cglx_jb=1".$where)->order("id")->select();
        //循环取出主分类表中的ID
        $set_class_id="";
        foreach($this->_class_data as $class_id){
            if ($set_class_id!="")
                $set_class_id.=",";
            $set_class_id.=$class_id["id"];
            //echo $set_class_id;
        }
        //取出二级分类
        if ($set_class_id!=""){
            //取出子分类数据
                $this->_class_meta_data=$ret=M("zclx_tb")->where("cglx_sjid in (".$set_class_id.") and cglx_jb=2")->order("id")->select();
            }
        //循环取出二级分类表中的ID
        $two_class_id="";
        foreach($this->_class_meta_data as $two_id){
            if ($two_class_id!="")
                $two_class_id.=",";
            $two_class_id.=$two_id["id"];
            //echo $set_class_id
        }
        if ($two_class_id!=""){
            //取出三级分类数据
            $this->_class_three_data=$ret=M("zclx_tb")->where("cglx_sjid in (".$two_class_id.") and cglx_jb=3")->order("id")->select();
            //echo M("zclx_tb")->_sql();
            //var_export($this->_class_three_data);
        }

    }
    //二级分类信息读取
    function RjList(){
        $this->_class_meta_data=$ret=M("zclx_tb")->where("cglx_jb=2")->order("id")->select();
    }
    //类型增加
    function zclx_add(){
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
        $info_add_tb = D("zclx_tb");
        $info_add_tb->cglx_mc = $title;
        $info_add_tb->cglx_sjid = $cglx_sjid;
        $info_add_tb->cglx_jb = $cglx_jb;
        $info_add_tb->cglx_sfyx = $cglx_sfyx;
        $info_add_tb->add();
        $this->actionInfo='{$this->assign("sussInfo","信息录入成功，请继续！");}';

    }

}