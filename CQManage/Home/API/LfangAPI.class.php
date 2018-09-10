<?php
namespace Home\API;
class LfangAPI
{
    public $_page_size="25"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_dal_hj_data=array();  //获奖信息
    public $_dal_wcdw_data=array(); //完成单位信息
    public $_keyword=""; //关键字
    public $_class_data=""; //分类信息
    public $_class_meta_data=""; //子分类信息
    public $_xmbh=""; //项目编号
    public $_lx="";

    //增加信息
    function AddLouFangInfo(){
        $config = C('uploadfile'); //读取上传文件配置类
        $upload = new \Think\Upload($config);// 实例化上传类
        $AddData=D("building_tb");  //注意去除前缀
        $AddData->buing_bh=I("buing_bh"); //楼房编号
        $AddData->buing_loor=I("buing_loor"); //楼房层数
        $AddData->buing_rooms=I("buing_rooms"); //房间数
        //$AddData->buing_img=I("buing_img"); //楼房图片|File
        //$AddData->BUILDINGPICTURE=I("BUILDINGPICTURE"); //图片
        $AddData->buing_name=I("buing_name"); //楼宇名称
        //上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            //$this->error($upload->getError());
        }else{// 上传成功
            //$this->success('上传成功！');
            foreach ($info as $file) {
                //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                $AddData->buing_img=$file['savepath'] . $file['savename'];
            }
        }
        $ret=$AddData->add();
        if(!$ret){
            $this->_pass="error";
        }else {
            $this->_pass="ok";
        }
    }
    //编辑信息
    function EditLouFangInfo(){
        $id=I("id");
        if (!$id){
            $this->_pass="error";
            exit();
        }
        $config = C('uploadfile'); //读取上传文件配置类
        $upload = new \Think\Upload($config);// 实例化上传类
        $AddData=D("building_tb");  //注意去除前缀
        $AddData->buing_bh=I("buing_bh"); //楼房编号
        $AddData->buing_loor=I("buing_loor"); //楼房层数
        $AddData->buing_rooms=I("buing_rooms"); //房间数
        //$AddData->buing_img=I("buing_img"); //楼房图片|File
        //$AddData->BUILDINGPICTURE=I("BUILDINGPICTURE"); //图片
        $AddData->buing_name=I("buing_name"); //楼宇名称
        //上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            //$this->error($upload->getError());
        }else{// 上传成功
            //$this->success('上传成功！');
            foreach ($info as $file) {
                //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                $AddData->buing_img=$file['savepath'] . $file['savename'];
            }
        }
        $ret=$AddData->where("id=$id")->save();
        if(!$ret){
            $this->_pass="error";
        }else {
            $this->_pass="ok";
        }
    }
    //解除人员分配
    function RyJc(){
        $ryid=I("ryid");
        if (!$ryid){
            echo "ryid error";
            exit();
        }else{
            $JCtable=D("ryxx_tb");
            $JCtable->ry_fjid="";
            $JCtable->ry_fjhao="";
            $JCtable->where("id=$ryid")->save();
            echo "ok";
        }
    }
    //解除设备分配
    function SbJc(){
        $sbid=I("sbid");
        $sbtable=I("sbtable");
        if (!$sbid){
            echo "id error";
            exit();
        }else{
            $JCtable=D("$sbtable");
            $JCtable->zc_cfwz=0;
            //$JCtable->ry_fjhao="";
            $JCtable->where("id=$sbid")->save();
            echo "ok";
        }
    }
    //增加信息
    function AddHouseInfo(){
        $AddData=D("house_tb");  //注意去除前缀
        $AddData->homename=I("homename"); //房间名称
        $AddData->zclb=I("zclb"); //资产类型
        $AddData->zcbm=I("zcbm"); //资产编码
        $AddData->glyxm=I("glyxm"); //管理员姓名
        $AddData->fzrq=I("fzrq"); //发证日期
        $AddData->fczbh=I("fczbh"); //证书编号
        $AddData->zlwz=I("zlwz"); //坐落位置
        $AddData->mj=I("mj"); //面积
        $AddData->symj=I("symj"); //实用面积
        $AddData->szlc=I("szlc"); //所在楼层
        $AddData->buildingid=I("buildingid"); //所属楼宇
        $AddData->huxing=I("huxing"); //户型
        $AddData->nolur=I("nolur"); //土地使用性质
        $ret=$AddData->add();
        if(!$ret){
            $this->_pass="error";
        }else {
            $this->_pass="ok";
        }
    }
    //编辑信息
    function EditHouseInfo(){
        $id=I("id");
        if (!$id){
            echo "id error";
            exit();
        }
        $AddData=D("house_tb");  //注意去除前缀
        $AddData->homename=I("homename"); //房间名称
        $AddData->zclb=I("zclb"); //资产类型
        $AddData->zcbm=I("zcbm"); //资产编码
        $AddData->glyxm=I("glyxm"); //管理员姓名
        $AddData->fzrq=I("fzrq"); //发证日期
        $AddData->fczbh=I("fczbh"); //证书编号
        $AddData->zlwz=I("zlwz"); //坐落位置
        $AddData->mj=I("mj"); //面积
        $AddData->symj=I("symj"); //实用面积
        $AddData->szlc=I("szlc"); //所在楼层
        $AddData->buildingid=I("buildingid"); //所属楼宇
        $AddData->huxing=I("huxing"); //户型
        $AddData->nolur=I("nolur"); //土地使用性质
        $ret=$AddData->where("id=$id")->save();
        if(!$ret){
            $this->_pass="error";
        }else {
            $this->_pass="ok";
        }
    }
}