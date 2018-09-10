<?php

namespace Home\API;
class YwzxAPI {
    public $actionInfo="";
    public $_main_date="";
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main1_data=array(); //主表数据
    public $_meta1_data=array();
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; // 关键字数据
    public $_lxdata=""; //资讯类型
    public $_hfdata="";

    //投资需求
    function AddTzxq(){
        $info_add_tb=D("quser_tzxq_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="quser_tzxq_tb";
        if($_POST){
            $info_add_tb->gl_ntzxm=I("gl_ntzxm");
            $info_add_tb->gl_ntzgm=I("gl_ntzgm");
            $info_add_tb->gl_ntzdq=I("gl_ntzdq");
            $info_add_tb->gl_ntzfs=I("gl_ntzfs");
            $info_add_tb->gl_ntzjd=I("gl_ntzjd");
            $info_add_tb->gl_ntzqyxz=I("gl_ntzqyxz");
            $info_add_tb->gl_gqjgyq=I("gl_gqjgyq");
            $info_add_tb->gl_gxtzjy=I("gl_gxtzjy");
            $info_add_tb->gl_sfyghz=I("gl_sfyghz");
            $info_add_tb->gl_qttzyq=I("gl_qttzyq");
            $info_add_tb->gl_tzrmc=I("gl_tzrmc");
            $info_add_tb->gl_zsd=I("gl_zsd");
            $info_add_tb->gl_zczb=I("gl_zczb");
            $info_add_tb->gl_tzrlx=I("gl_tzrlx");
            $info_add_tb->gl_bz=I("gl_bz");
            $info_add_tb->add();
            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();

            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            //var_export($set_id);
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息

                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx=$Ywlx;
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;
                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }
        }
    }
    //会议需求
    function  AddHyxq(){
        $info_add_tb=D("quser_hyxq_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="quser_hyxq_tb";
        if($_POST){
            $info_add_tb->gl_xqms=I("gl_xqms");
            $info_add_tb->gl_hylx=I("gl_hylx");
            $info_add_tb->gl_hyfx=I("gl_hyfx");
            $info_add_tb->gl_hycs=I("gl_hycs");
            $info_add_tb->gl_hyrq=I("gl_hyrq");
            $info_add_tb->gl_xqms=I("gl_xqms");
            $info_add_tb->gl_hyys=I("gl_hyys");
            $info_add_tb->add();

            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();

            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            //var_export($set_id);
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息

                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx=$Ywlx;
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;

                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }
        }
    }
    //需求申请
    function  AddXqsq(){
        $info_add_tb=D("quser_xqsq_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="quser_xqsq_tb";
        if($_POST){
            $info_add_tb->gl_xqnr=I("gl_xqnr");
            $info_add_tb->gl_xqlx=I("gl_xqlx");
            $info_add_tb->gl_xqly=I("gl_xqly");
            $info_add_tb->gl_trys=I("gl_trys");
            $info_add_tb->gl_xmjj=I("gl_xmjj");
            $info_add_tb->gl_xqms=I("gl_xqms");
            $info_add_tb->gl_jzrq=I("gl_jzrq");
            $info_add_tb->add();

            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();

            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            //var_export($set_id);
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息

                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx=$Ywlx;
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;

                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }
        }
    }
    //增加成果信息
    function AddCgrk(){
        $upfile_config = C('up_file');
        $info_add_tb=D("quser_cgrk_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="quser_cgrk_tb";
        if ($_POST){
            $info_add_tb->gl_cgmc=I("gl_cgmc");
            $info_add_tb->gl_gjc=I("gl_gjc");
            $info_add_tb->gl_cgtxxs=I("gl_cgtxxs");
            $info_add_tb->gl_yyly=I("gl_yyly");
            $info_add_tb->gl_syfw=I("gl_syfw");
            $info_add_tb->gl_zljs=I("gl_zljs");
            $info_add_tb->gl_zlssdq=I("gl_zlssdq");
            $info_add_tb->gl_zllx=I("gl_zllx");
            $info_add_tb->gl_zlh=I("gl_zlh");
            $info_add_tb->gl_zljj=I("gl_zljj");
            $info_add_tb->gl_qtzljs=I("gl_qtzljs");
            $info_add_tb->gl_cgjj=I("gl_cgjj");
            $info_add_tb->gl_yyqk=I("gl_yyqk");
            $info_add_tb->gl_tgqj=I("gl_tgqj");
            $info_add_tb->gl_jspgjz=I("gl_jspgjz");
            $info_add_tb->gl_cgyyzt=I("gl_cgyyzt");
            $info_add_tb->gl_yydq=I("gl_yydq");
            $info_add_tb->gl_jstp=I("gl_jstp");
            $info_add_tb->gl_csdzmcl=I("gl_csdzmcl");

            //上传文件
            $upload = new \Think\Upload($upfile_config);
            $info = $upload->upload();
            if ($info!=""){
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {// 上传成功
                    //$this->success('上传成功！');
                    foreach ($info as $file) {
                        //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                        $info_add_tb->gl_csdzmcl = $file['savepath'] . $file['savename'];
                    }
                }
            }
            $info_add_tb->add();
            //echo $info_add_tb->_sql();
            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();

            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息
                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx=$Ywlx;
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;

                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }

        }

    }
    function AddCgpg(){
        $upfile_config = C('up_file');
        $info_add_tb=D("quser_cgpg_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="quser_cgpg_tb";
        if ($_POST){
            $info_add_tb->gl_cgmc=I("gl_cgmc");
            $info_add_tb->gl_cglx=I("gl_cglx");
            $info_add_tb->gl_cgjj=I("gl_cgjj");
            $info_add_tb->gl_yyqk=I("gl_yyqk");
            $info_add_tb->gl_tgqj=I("gl_tgqj");
            $info_add_tb->gl_zljs=I("gl_zljs");
            $info_add_tb->gl_zlssdq=I("gl_zlssdq");
            $info_add_tb->gl_zllx=I("gl_zllx");
            $info_add_tb->gl_zlh=I("gl_zlh");
            $info_add_tb->gl_zljj=I("gl_zljj");
            $info_add_tb->gl_qtzljs=I("gl_qtzljs");

            //上传文件
            $upload = new \Think\Upload($upfile_config);
            $info = $upload->upload();
            if ($info!=""){
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {// 上传成功
                    //$this->success('上传成功！');
                    foreach ($info as $file) {
                        //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                        $info_add_tb->gl_jcbg = $file['savepath'] . $file['savename'];
                    }
                }
            }
            $info_add_tb->add();
            //echo $info_add_tb->_sql();
            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();

            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息
                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx=$Ywlx;
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;

                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }

        }

    }
    //融资需求
    function AddRzxq(){
        $upfile_config = C('up_file');
        $info_add_tb=D("quser_rzxq_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="quser_rzxq_tb";
        if ($_POST){
            $info_add_tb->gl_jgxz=I("gl_jgxz");
            $info_add_tb->gl_xmmc=I("gl_xmmc");
            $info_add_tb->gl_hzdw=I("gl_hzdw");
            $info_add_tb->gl_xmztzje=I("gl_xmztzje");
            $info_add_tb->gl_xmyyly=I("gl_xmyyly");
            $info_add_tb->gl_yrzje=I("gl_yrzje");
            $info_add_tb->gl_zjyt=I("gl_zjyt");
            $info_add_tb->gl_xmyydy=I("gl_xmyydy");
            $info_add_tb->gl_rzfs=I("gl_rzfs");
            $info_add_tb->gl_zjly=I("gl_zjly");
            $info_add_tb->gl_zjtrfs=I("gl_zjtrfs");
            $info_add_tb->gl_gdzjfx=I("gl_gdzjfx");
            $info_add_tb->gl_gtjygl=I("gl_gtjygl");
            $info_add_tb->gl_zmhbzq=I("gl_zmhbzq");
            $info_add_tb->gl_xmyyfw=I("gl_xmyyfw");
            $info_add_tb->gl_xmyytj=I("gl_xmyytj");
            $info_add_tb->gl_xmqjfx=I("gl_xmqjfx");
            $info_add_tb->gl_xmdw=I("gl_xmdw");
            $info_add_tb->gl_tdjs=I("gl_tdjs");
            $info_add_tb->gl_cpyy=I("gl_cpyy");

            //上传文件
            $upload = new \Think\Upload($upfile_config);
            $info = $upload->upload();
            if ($info!=""){
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {// 上传成功
                    //$this->success('上传成功！');
                    foreach ($info as $file) {
                        //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                        $info_add_tb->gl_syjhs = $file['savepath'] . $file['savename'];
                    }
                }
            }
            $info_add_tb->add();
            //echo $info_add_tb->_sql();
            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();

            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息
                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx=$Ywlx;
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;

                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }

        }

    }
    //增加对接需求
    function add_djxm(){
        $upfile_config = C('up_file'); //读取上传文件配置类
        //var_export($upfile_config);

        if ($_POST){
            $info_add_tb=D("quser_gjxq_tb");
            $info_lx_tb=D("quser_lxxx_tb");
            $info_add_tb->gl_cpmc=I("cg_cpmc");
            $info_add_tb->gl_txxs=I("gl_txxs");
            $info_add_tb->gl_yyly=I("gl_yyly");
            $info_add_tb->gl_cpjj=I("gl_cpjj");
            //$info_add_tb->gl_jcbg=I("gl_jcbg");
            $info_add_tb->gl_syqy=I("gl_syqy");
            $info_add_tb->gl_tgxs=I("gl_tgxs");
            $info_add_tb->gl_zjlx=I("gl_zjlx");

            $upload = new \Think\Upload($upfile_config);// 实例化上传类
            // 上传文件
            $info = $upload->upload();
            if ($info!=""){
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {// 上传成功
                    //$this->success('上传成功！');
                    foreach ($info as $file) {
                        //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                        $info_add_tb->gl_jcbg = $file['savepath'] . $file['savename'];
                    }
                }
            }

            $info_add_tb->add();
            //echo $info_add_tb->_sql();
            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();

            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            //var_export($set_id);
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息

                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx="gjxq_tb";
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;

                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }

           // $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
        }

    }
    //增加对接需求
    function edit_djxm(){
        //var_export($upfile_config);
        $id=I("id");
        if (!$id){
            exit("id error");
        }
        $where["id"]=array("eq",$id);
        if ($_POST) {
            $info_add_tb = D("quser_gjxq_tb");
            $info_add_tb->gl_cpmc = I("cg_cpmc");
            $info_add_tb->gl_txxs = I("gl_txxs");
            $info_add_tb->gl_yyly = I("gl_yyly");
            $info_add_tb->gl_cpjj = I("gl_cpjj");
            $info_add_tb->gl_syqy = I("gl_syqy");
            $info_add_tb->gl_tgxs = I("gl_tgxs");
            $info_add_tb->gl_zjlx = I("gl_zjlx");
            $info_add_tb->gl_tjzt = I("cg_tjzt");
            $ret=$info_add_tb->where($where)->save();
            //echo $info_add_tb->_sql();
            $this->actionInfo=$ret;
        }

    }
    //增加成果需求信息
    function  add_cgxq(){
        if ($_POST){
            $info_add_tb=D("quser_cgxq_tb");
            $info_lx_tb=D("quser_lxxx_tb");
            //主表信息
            $info_add_tb->gl_xqmc=I("gl_xqmc");
            $info_add_tb->gl_xqjs=I("gl_xqjs");
            $info_add_tb->gl_yyly=I("gl_yyly");
            $info_add_tb->gl_trys=I("gl_trys");
            $info_add_tb->gl_xqlx=I("gl_xqlx");
            $info_add_tb->gl_jzrq=I("gl_jzrq");
            $info_add_tb->add();
            //读取主表插入后的ID
            $this->_main_date=$ret=M("quser_cgxq_tb")->order("id desc")->LIMIT(1)->select();
            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","主表信息插入失败，请检查！");}';
            }
            else{
                //联系信息
                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_ywlx=I("gl_ywlx");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;
                $info_lx_tb->add();
                //$this->ajaxReturn('$this->assign("sussInfo","信息保存成功，请继续！");');
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }

        }
    }
    //增加专家信息
    function AddZjxx(){
        $info_add_tb=D("zjxxinfo_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="zjxxinfo_tb";
        $info_add_tb->cg_wcrxm=I("gl_name");
        $info_add_tb->cg_wcrxb=I("zj_xb");
        $info_add_tb->cg_wcrmz=I("gl_mz");
        $nian=I("nian");
        $yue=I("yue");
        $ri=I("ri");
        $csny=$nian."-".$yue."-".$ri;
        $info_add_tb->cg_wcrcsny=$csny;
        $info_add_tb->cg_wcrsfzh=I("gl_sfzh");
        $info_add_tb->cg_wcrjg=I("gl_ssdq");
        $info_add_tb->zj_type=I("gl_zjlx");

        $info_add_tb->cg_wcrbyyx=I("gl_byyx");
        $info_add_tb->cg_wcrzgxl=I("gl_zgxl");
        $info_add_tb->cg_wcrzyzc=I("gl_zyxx");
        //$info_add_tb->zj_type=I("");

        $info_add_tb->cg_wcrgzdw=I("gl_gzdw");
        $info_add_tb->cg_wcrxzzw=I("gl_xzzw");
        $info_add_tb->cg_wcrjszc=I("gl_jszc");
        $info_add_tb->cf_wcrnx=I("gl_gznx");
        $info_add_tb->cg_wcrzybq=I("gl_zybq");
        $info_add_tb->cg_wcrjs=I("gl_zyjs");
        $ret=$info_add_tb->add();
        //增加联系信息
        $info_lx_tb->gl_ywid="$ret";
        $info_lx_tb->gl_lxr=I("gl_lxr");
        $info_lx_tb->gl_ywlx=$Ywlx;
        $info_lx_tb->gl_gzdw=I("gl_gzdw");
        $info_lx_tb->gl_zw=I("gl_zw");
        $info_lx_tb->gl_dh=I("gl_dh");
        $info_lx_tb->gl_sj=I("gl_sj");
        $info_lx_tb->gl_yx=I("gl_yx");
        $info_lx_tb->gl_cz=I("gl_cz");
        $info_lx_tb->gl_lxdz=I("gl_lxdz");
        $info_lx_tb->gl_yb=I("gl_yb");
        $info_lx_tb->gl_cjr=I("gl_cjr");
        $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
        $info_lx_tb->gl_hdzt= 1;

        $info_lx_tb->add();
        $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
    }
    //增加科技咨询
    function Addkjzx()
    {
        $info_add_tb=D("quser_kjzx_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="quser_kjzx_tb";
        if($_POST){
            $info_add_tb->gl_zxnr=I("gl_zxnr");
            $info_add_tb->gl_zxnrscjd=I("gl_zxnrscjd");
            $info_add_tb->gl_zxly=I("gl_zxly");
            $info_add_tb->gl_xmjj=I("gl_xmjj");
            $info_add_tb->gl_xqms=I("gl_xqms");
            $info_add_tb->gl_trys=I("gl_trys");
            $info_add_tb->add();
            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();
            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            //var_export($set_id);
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息
                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx=$Ywlx;
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;

                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }
        }
    }
    //增加科研咨询
    function AddKyzx()
    {
        $info_add_tb=D("quser_kyzx_tb");
        $info_lx_tb=D("quser_lxxx_tb");
        $Ywlx="quser_kyzx_tb";
        if($_POST){
            $info_add_tb->gl_zxnr=I("gl_zxnr");
            $info_add_tb->gl_xmjj=I("gl_xmjj");
            $info_add_tb->gl_yxcxdms=I("gl_yxcxdms");
            $info_add_tb->gl_ncjdw=I("gl_ncjdw");
            $info_add_tb->gl_yjly=I("gl_yjly");
            $info_add_tb->gl_nlxrq=I("gl_nlxrq");
            $info_add_tb->gl_jhjtrq=I("gl_jhjtrq");
            $info_add_tb->gl_jfys=I("gl_jfys");
            $info_add_tb->add();

            $this->_main_date=$ret=$info_add_tb->order("id desc")->LIMIT(1)->select();

            $set_id="";
            foreach ($ret as $main_id){
                $set_id=$main_id{"id"};
            }
            //var_export($set_id);
            if ($set_id==""){
                $this->actionInfo='{$this->assign("errorInfo","联系信息插入失败，请检查！");}';
            }
            else{
                //增加联系信息

                $info_lx_tb->gl_ywid="$set_id";
                $info_lx_tb->gl_lxr=I("gl_lxr");
                $info_lx_tb->gl_ywlx=$Ywlx;
                $info_lx_tb->gl_gzdw=I("gl_gzdw");
                $info_lx_tb->gl_zw=I("gl_zw");
                $info_lx_tb->gl_dh=I("gl_dh");
                $info_lx_tb->gl_sj=I("gl_sj");
                $info_lx_tb->gl_yx=I("gl_yx");
                $info_lx_tb->gl_cz=I("gl_cz");
                $info_lx_tb->gl_lxdz=I("gl_lxdz");
                $info_lx_tb->gl_yb=I("gl_yb");
                $info_lx_tb->gl_cjr=I("gl_cjr");
                $info_lx_tb->gl_cjsj=date('Y-m-d H:i:s',time());
                $info_lx_tb->gl_hdzt= 1;

                $info_lx_tb->add();
                $this->actionInfo='{$this->assign("sussInfo","信息保存成功，请继续！");}';
            }
        }
    }
    function djzx_manage($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where['cg_cgmc']  = array('like',"%$this->_keyword%"); //创建人
        }
        $this->_page_count=$count=M("djxq_vm")->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,"40");

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main1_data=$ret=M("djxq_vm")->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $ret->getLastSql();
        if($_POST){
            $info_add_tb=D("quser_ywgthf_tb");
            $info_edit_tb=D("quser_lxxx_tb");
            $info_add_tb->gl_hfr=I("gl_hfr");
            $info_add_tb->gl_ywid=I("ywid");
            $info_add_tb->gl_hfrip=get_client_ip();
            $info_add_tb->gl_hfsj=date('Y-m-d H:i:s',time());
            $info_add_tb->gl_content=I("gl_content");
            $info_add_tb->gl_ywlx="zjxq";
            $info_add_tb->gl_ywcjr=I("gl_ywcjr");
            $info_add_tb->gl_hfyj=I("gl_hfyj");
            $info_add_tb->add();
            $set_id=I("ywid");

            $info_edit_tb->gl_hdzt=I("gl_hfyj");

            $info_edit_tb->where("gl_ywid=$set_id")->save();

            $this->actionInfo='{$this->assign("sussInfo","信息已回复！");}';


        }
    }
    //需求管理
    function xqsq_manage($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where['gl_xqmc']  = array('like',"%$this->_keyword%"); //需求名称
            $where['gl_hdzt']  = array('eq',"$this->_keyword"); //待回复
            $where['_logic']='OR';
        }
        $this->_page_count=$count=M("xqsq_vm")->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,"10");

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main1_data=$ret=M("xqsq_vm")->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        $this->_hfdata=$ret=M("xqsq_vm")->where("gl_hdzt=1")->order("id DESC")->count();
        //echo $ret->getLastSql();

        //回复
        if($_POST ){
            $ii=I("ywid");;
            if ($ii!=""){
            $info_add_tb=D("quser_ywgthf_tb");
            $info_edit_tb=D("quser_lxxx_tb");

            $info_add_tb->gl_hfr=I("gl_hfr");
            $info_add_tb->gl_ywid=I("ywid");
            $info_add_tb->gl_hfrip=get_client_ip();
            $info_add_tb->gl_hfsj=date('Y-m-d H:i:s',time());
            $info_add_tb->gl_content=I("gl_content");
            $info_add_tb->gl_ywlx="xqsq";
            $info_add_tb->gl_ywcjr=I("gl_ywcjr");
            $info_add_tb->gl_hfyj=I("gl_hfyj");
            $info_add_tb->add();
            $set_id=I("ywid");

            $info_edit_tb->gl_hdzt=I("gl_hfyj");

            $info_edit_tb->where("gl_ywid=$set_id")->save();

            $this->actionInfo='{$this->assign("sussInfo","信息已回复！");}';
            }
            else{
                echo ("Data Error");
                return false;
            }

        }
    }
    function xq_dal($where){
        $this->_keyword=I("id");
        if ($this->_keyword==""){
            echo ("Info Error");
            return false;
        }
        else
        {
            $where['id']  = array('eq',"$this->_keyword"); //待回复
            $this->_main1_data=$ret=M("xqsq_vm")->where($where)->order("id DESC")->LIMIT(1)->select();
        }
    }
    //供给详细信息
    function gj_dal($where){
        $this->_keyword=I("id");
        if ($this->_keyword==""){
            echo ("Info Error");
            return false;
        }
        else
        {
            $where['id']  = array('eq',"$this->_keyword"); //待回复
            $this->_main1_data=$ret=M("gjxq_vm")->where($where)->order("id DESC")->LIMIT(1)->select();
        }
    }

    function xq_list($where){
        $this->_keyword=I("keyword");
            $where['gl_xqmc']  = array('like',"%$this->_keyword%"); //需求名称
            //$where['gl_hdzt']  = array('eq',"$this->_keyword"); //待回复
            //$where['_logic']='OR';
        $this->_page_count=$count=M("xqsq_vm")->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,"10");

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("xqsq_vm")->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("xqsq_vm")->_sql();
    }
    function gj_list($where){
        $this->_keyword=I("keyword");
            $where['gl_hdxq']  = array('like',"%$this->_keyword%"); //需求名称
            $where['gl_hdzt']  = array('eq',10); //待回复

        $this->_page_count=$count=M("gjxq_vm")->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,"10");

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("gjxq_vm")->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo M("djxq_vm")->_sql();

    }


}