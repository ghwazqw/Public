<?php
namespace Home\API;
class ZjxxAPI
{
    public $_page_size="10"; //每页显示条数
    public $_page_bar=""; //分页组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //表数据
    public $_keyword=""; //检索关键字
    public $_meta_data=array();
    public $_xmbh="";
    public $_type="";
    public $_lx="";
    public $actionInfo="";

    function loadmatedata($where,$wheredal){
        //加载输入关键字
        $this->_keyword=I("keyword");
        $this->_type=I("type");
        if ($this->_keyword!=""){
            $where['gl_zjxm']  = array('like',"%$this->_keyword%"); //专家姓名
            //$where['gl_zjgzdw']  = array('like',"%$this->_keyword%");  //工作单位
            //$where['cg_xmjj']  = array('like',"%$this->_keyword%"); //成果简介
            //$where['cg_xmjj']  = array('like',"%$this->_keyword%"); //
            //$where['_logic']='OR';
        }
        if ($this->_type==""){
            echo ("类别错误，请检查");
            return false;
        }
        $wheredal['gl_zjlx']=array('eq',$this->_type);
        //var_export($where) ;
        //加载主表数据
        $this->_page_count=$count=M("zjwc_tb")->where($where)->order("id DESC")->where($wheredal)->count();
        $Page = new \Think\Page($count,"40");

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("zjwc_tb")->where($where)->order("id DESC")->where($wheredal)->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $ret->getLastSql();
    }
    function loaddaldata($where,$wheredal){
        //加载输入关键字
        $this->_keyword=I("id");
        $this->_type=I("type");
        if ($this->_keyword!=""){
            $where['id']  = array('eq',$this->_keyword); //ID
            //$where['_logic']='OR';
        }

            //行业专家顾问单独处理
            //$this->_page_count=$count=M("zjwc_tb")->where($where)->order("id DESC")->count();
            $this->_main_data=$ret=M("zjwc_tb")->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
            //echo $ret->getLastSql();
            //加载专家数据
            $set_zj_xm="";
            foreach($this->_main_data as $class_id){
                if ($set_zj_xm!="")
                    $set_zj_xm.=",";
                $set_zj_xm.=$class_id["cg_wcrxm"];
                //echo $set_zj_xm;
            }
            if ($set_zj_xm!=""){
                //取出相关成果数据
                $set_zj_xm=$set_zj_xm.",";
                $wheredal['cg_zywcr']  = array('like',"%$set_zj_xm%");
                $this->_meta_data=$ret=M("cgxxjc_tb")->where($wheredal)->order("cg_wcsj desc")->select();
                //echo M("cgxxjc_tb")->_sql();
            }

        }
    //成果完成人（专家信息）
    function zjwcrdata($where,$type){
        $this->_lx=I("lx");
        $this->_keyword=I("keyword");
        $type=I("type");

        if ($this->_lx==""){
        $cg_wcrxm=I("cg_wcrxm");
        $cg_wcrxb=I("cg_wcrxb");
        $cg_wcrcsny=I("cg_wcrcsny");
        $cg_wcrjg=I("cg_wcrjg");
        $cg_wcrmz=I("cg_wcrmz");
        $cg_wcrsfzh=I("cg_wcrsfzh");
        $cg_wcrdp=I("cg_wcrdp");
        $cg_wcrxzzw=I("cg_wcrxzzw");
        $cg_wcrgzdw=I("cg_wcrgzdw");
        $cg_wcrzyzc=I("cg_wcrzyzc");
        $cg_wcrzgxl=I("cg_wcrzgxl");
        $cg_wcryddh=I("cg_wcryddh");
        if (I("zj_type")==""){
            $zj_type="1,2,3";
        }
        else{
            $zj_type=I("zj_type");
        }
        $data = array (
            "cg_wcrxm" => I("cg_wcrxm"),
            "cg_wcrxb"=>I("cg_wcrxb"),
            "cg_wcrcsny"=>I("cg_wcrcsny"),
            "cg_wcrjg"=>I("cg_wcrjg"),
            "cg_wcrmz"=>I("cg_wcrmz"),
            "cg_wcrsfzh"=>I("cg_wcrsfzh"),
            "cg_wcrdp"=>I("cg_wcrdp"),
            "cg_wcrxzzw"=>I("cg_wcrxzzw"),
            "cg_wcrgzdw"=>I("cg_wcrgzdw"),
            "cg_wcrzyzc"=>I("cg_wcrzyzc"),
            "cg_wcrzgxl"=>I("cg_wcrzgxl"),
            "cg_wcryddh"=>I("cg_wcryddh"),
            "zj_type"=>$zj_type
        );
        //var_export($data);
        $where['cg_wcrxm']  = array('like',"%$cg_wcrxm%");
        $where['cg_wcrxb']  = array('like',"%$cg_wcrxb%");
        $where['cg_wcrcsny'] = array('like',"%$cg_wcrcsny%");
        $where['cg_wcrjg']  = array('like',"%$cg_wcrjg%");
        $where['cg_wcrmz']  = array('like',"%$cg_wcrmz%");
        $where['cg_wcrsfzh']  = array('like',"%$cg_wcrsfzh%");
        $where['cg_wcrdp']  = array('like',"%$cg_wcrdp%");
        $where['cg_wcrxzzw']  = array('like',"%$cg_wcrxzzw%");
        $where['cg_wcrgzdw']  = array('like',"%$cg_wcrgzdw%");
        $where['cg_wcrzyzc']  = array('like',"%$cg_wcrzyzc%");
        $where['cg_wcrzgxl']  = array('like',"%$cg_wcrzgxl%");
        $where['cg_wcryddh']  = array('like',"%$cg_wcryddh%");
        $where['zj_type']  = array('in',"$zj_type");
        }
        //关键字加类型搜索
        elseif ($this->_lx!="" and $this->_keyword!=""){
            //echo ($this->_lx);
            if ($this->_lx=="cg_wcrxm") {
                $where['cg_wcrxm']  = array('like',"%$this->_keyword%"); //专家姓名
            }
            if ($this->_lx=="cg_wcrgzdw") {
                $where['cg_wcrgzdw']  = array('like',"%$this->_keyword%"); //工作单位
            }
            if ($this->_lx=="cg_wcrzyzc") {
                $where['cg_wcrzyzc']  = array('like',"%$this->_keyword%"); //从事专业
            }
            if ($this->_lx=="cg_wcrjszc") {
                $where['cg_wcrjszc']  = array('like',"%$this->_keyword%"); //技术职称
            }
            if ($this->_lx=="cg_wcrbyyx") {
                $where['cg_wcrbyyx']  = array('like',"%$this->_keyword%"); //专业院校
            }
            if ($this->_lx=="cg_wcrjg") {
                $where['cg_wcrjg']  = array('like',"%$this->_keyword%"); //籍贯地区
            }
            if ($type!=""){
                $where['zj_type']  = array('eq',"$type");
                $this->_type=$type;
            }
        }
        //类型为空关键字搜索
        elseif ($this->_lx=="" and $this->_keyword!=""){
                $where['cg_wcrxm']  = array('like',"%$this->_keyword%"); //专家姓名
                $where['cg_wcrgzdw']  = array('like',"%$this->_keyword%"); //工作单位
                $where['cg_wcrzyzc']  = array('like',"%$this->_keyword%"); //从事专业
                $where['cg_wcrjszc']  = array('like',"%$this->_keyword%"); //技术职称
                $where['cg_wcrbyyx']  = array('like',"%$this->_keyword%"); //专业院校
                $where['cg_wcrjg']  = array('like',"%$this->_keyword%"); //籍贯地区
                $where['_logic']='OR';
            //echo ($this->_keyword);
        }
        $this->_keyword= $data;
        $this->_page_count=$count=M("zjwc_tb")->where($where)->order("zj_photo,id desc")->count();
        //echo M("zjwc_tb")->_sql();
        $Page = new \Think\Page($count,"40");
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("zjwc_tb")->where($where)->order("zj_photo,id desc")->LIMIT($Page->firstRow.','.$Page->listRows)->select();//主表数据取值完成
        //echo M("zjwc_tb")->_sql();


    }
    function zjxx_search($where){
        $this->_keyword=I("keyword");
        $lx=I("lx");
        if  ($this->_keyword!="" and $lx=="" ){
            $where['cg_wcrxm']  = array('like',"%$this->_keyword%"); //专家姓名
            $where['cg_wcrgzdw']  = array('like',"%$this->_keyword%"); //工作单位
            $where['cg_wcrzyzc']  = array('like',"%$this->_keyword%"); //从事专业
            $where['cg_wcrjszc']  = array('like',"%$this->_keyword%"); //技术职称
            $where['cg_wcrbyyx']  = array('like',"%$this->_keyword%"); //专业院校
            $where['cg_wcrjg']  = array('like',"%$this->_keyword%"); //籍贯地区
            $where['_logic']='OR';
        }
        if  ($this->_keyword!="" and $lx!="") {
            //echo ($this->_lx);
            if ($this->_lx=="cg_wcrxm") {
                $where['cg_wcrxm']  = array('like',"%$this->_keyword%"); //专家姓名
            }
            if ($this->_lx=="cg_wcrgzdw") {
                $where['cg_wcrgzdw']  = array('like',"%$this->_keyword%"); //工作单位
            }
            if ($this->_lx=="cg_wcrzyzc") {
                $where['cg_wcrzyzc']  = array('like',"%$this->_keyword%"); //从事专业
            }
            if ($this->_lx=="cg_wcrjszc") {
                $where['cg_wcrjszc']  = array('like',"%$this->_keyword%"); //技术职称
            }
            if ($this->_lx=="cg_wcrbyyx") {
                $where['cg_wcrbyyx']  = array('like',"%$this->_keyword%"); //专业院校
            }
            if ($this->_lx=="cg_wcrjg") {
                $where['cg_wcrjg']  = array('like',"%$this->_keyword%"); //籍贯地区
            }


        }
        $this->_page_count=$count=M("zjwc_tb")->where($where)->order("zj_type desc")->count();

        $Page = new \Think\Page($count,$this->_page_size);
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("zjwc_tb")->where($where)->order("zj_type desc")->LIMIT($Page->firstRow.','.$Page->listRows)->select();//主表数据取值完成
        //echo M("zjwc_tb")->_sql();

    }
    function zjSearch($where){
        $this->_keyword=I("keyword");
        $lx=I("zj_type");
        if  ($this->_keyword!="" and $lx=="" ){
            $where['cg_wcrxm']  = array('like',"%$this->_keyword"); //专家姓名
            $where['cg_wcrgzdw']  = array('like',"%$this->_keyword%"); //工作单位
            $where['cg_wcrzyzc']  = array('like',"%$this->_keyword%"); //从事专业
            $where['cg_wcrjszc']  = array('like',"%$this->_keyword%"); //技术职称
            $where['cg_wcrbyyx']  = array('like',"%$this->_keyword%"); //专业院校
            $where['cg_wcrjg']  = array('like',"%$this->_keyword%"); //籍贯地区
            $where['_logic']='OR';
        }
        elseif  ($lx!="" and $this->_keyword=="") {
            $where['zj_type']  = array('eq',$lx); //类型
        }
        $this->_page_count=$count=M("zjwc_tb")->where($where)->order("zj_type desc")->count();
        $this->_lx=$lx;

        $Page = new \Think\Page($count,$this->_page_size);
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("zjwc_tb")->where($where)->order("zj_type desc")->LIMIT($Page->firstRow.','.$Page->listRows)->select();//主表数据取值完成
        //echo M("zjwc_tb")->_sql();
    }
    function edit_info(){
        $config = C('uploadfile');
        if ($_POST) {
            $info_add_tb = D("zjwc_tb");
            $upload = new \Think\Upload($config);// 实例化上传类
            $info_add_tb->id = I("id");
            $info_add_tb->cg_wcrxm = I("cg_wcrxm");
            $info_add_tb->cg_wcrxb = I("cg_wcrxb");
            $info_add_tb->cg_wcrcsny = I("cg_wcrcsny");
            $info_add_tb->cg_wcrjg = I("cg_wcrjg");
            $info_add_tb->cg_wcrmz = I("cg_wcrmz");
            $info_add_tb->cg_wcrsfzh = I("cg_wcrsfzh");
            $info_add_tb->cg_wcrdp = I("cg_wcrdp");
            $info_add_tb->cg_wcrgj = I("cg_wcrgj");
            $info_add_tb->cg_wcrgzdw = I("cg_wcrgzdw");
            $info_add_tb->cg_wcrxzzw = I("cg_wcrxzzw");
            $info_add_tb->cg_wcrbgdh = I("cg_wcrbgdh");
            $info_add_tb->cg_wcrtxdz = I("cg_wcrtxdz");
            $info_add_tb->cg_wcryzbm = I("cg_wcryzbm");
            $info_add_tb->cg_wcrdzyx = I("cg_wcrdzyx");
            $info_add_tb->cg_wcryddh = I("cg_wcryddh");
            $info_add_tb->cg_wcrbyyx = I("cg_wcrbyyx");
            $info_add_tb->cg_wcrjszc = I("cg_wcrjszc");
            $info_add_tb->cg_wcrzyzc = I("cg_wcrzyzc");
            $info_add_tb->cg_wcrzgxl = I("cg_wcrzgxl");
            $info_add_tb->cg_wcrchj = I("cg_wcrchj");
            // 上传文件
            $upload = new \Think\Upload($config);// 实例化上传类
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                //echo $upload->getError();
                //exit();
            }else{// 上传成功
                //$this->success('上传成功！');
                foreach ($info as $file) {
                    //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                    $info_add_tb->zj_photo=$file['savepath'] . $file['savename'];
                    //echo $file['savepath'] . $file['savename'];
                    //exit();
                }
            }
            $info_add_tb->where("id=$info_add_tb->id")->save();
            redirect('/?a=Zjwcr_list&c=Zjxx', 2, '更新成功，正在转入列表页面...');
        }
        }
    function add_info(){
        $config = C('uploadfile');
        if ($_POST) {
            $info_add_tb = D("zjwc_tb");
            $upload = new \Think\Upload($config);// 实例化上传类
            $info_add_tb->id = I("id");
            $info_add_tb->cg_wcrxm = I("cg_wcrxm");
            $info_add_tb->cg_wcrxb = I("cg_wcrxb");
            $info_add_tb->cg_wcrcsny = I("cg_wcrcsny");
            $info_add_tb->cg_wcrjg = I("cg_wcrjg");
            $info_add_tb->cg_wcrmz = I("cg_wcrmz");
            $info_add_tb->cg_wcrsfzh = I("cg_wcrsfzh");
            $info_add_tb->cg_wcrdp = I("cg_wcrdp");
            $info_add_tb->cg_wcrgj = I("cg_wcrgj");
            $info_add_tb->cg_wcrgzdw = I("cg_wcrgzdw");
            $info_add_tb->cg_wcrxzzw = I("cg_wcrxzzw");
            $info_add_tb->cg_wcrbgdh = I("cg_wcrbgdh");
            $info_add_tb->cg_wcrtxdz = I("cg_wcrtxdz");
            $info_add_tb->cg_wcryzbm = I("cg_wcryzbm");
            $info_add_tb->cg_wcrdzyx = I("cg_wcrdzyx");
            $info_add_tb->cg_wcryddh = I("cg_wcryddh");
            $info_add_tb->cg_wcrbyyx = I("cg_wcrbyyx");
            $info_add_tb->cg_wcrjszc = I("cg_wcrjszc");
            $info_add_tb->cg_wcrzyzc = I("cg_wcrzyzc");
            $info_add_tb->cg_wcrzgxl = I("cg_wcrzgxl");
            $info_add_tb->cg_wcrchj = I("cg_wcrchj");
            $info_add_tb->zj_type = I("zj_type");
            // 上传文件
            $upload = new \Think\Upload($config);// 实例化上传类
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                //echo $upload->getError();
                //exit();
            }else{// 上传成功
                //$this->success('上传成功！');
                foreach ($info as $file) {
                    //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                    $info_add_tb->zj_photo=$file['savepath'] . $file['savename'];
                    //echo $file['savepath'] . $file['savename'];
                    //exit();
                }
            }
            $info_add_tb->add();
            redirect('/?a=Zjwcr_list&c=Zjxx', 2, '新增成功，正在转入列表页面...');
        }
    }
    function zjxx_list($where){
        $this->_keyword=I("keyword");
        $lx=I("lx");
        if  ($this->_keyword!="" and $lx=="" ){
            $where['cg_wcrxm']  = array('like',"%$this->_keyword%"); //专家姓名
            $where['cg_wcrgzdw']  = array('like',"%$this->_keyword%"); //工作单位
            $where['cg_wcrzyzc']  = array('like',"%$this->_keyword%"); //从事专业
            $where['cg_wcrjszc']  = array('like',"%$this->_keyword%"); //技术职称
            $where['cg_wcrbyyx']  = array('like',"%$this->_keyword%"); //专业院校
            $where['cg_wcrjg']  = array('like',"%$this->_keyword%"); //籍贯地区
            $where['_logic']='OR';
        }
        if  ($this->_keyword!="" and $lx!="") {
            //echo ($this->_lx);
            if ($this->_lx=="cg_wcrxm") {
                $where['cg_wcrxm']  = array('like',"%$this->_keyword%"); //专家姓名
            }
            if ($this->_lx=="cg_wcrgzdw") {
                $where['cg_wcrgzdw']  = array('like',"%$this->_keyword%"); //工作单位
            }
            if ($this->_lx=="cg_wcrzyzc") {
                $where['cg_wcrzyzc']  = array('like',"%$this->_keyword%"); //从事专业
            }
            if ($this->_lx=="cg_wcrjszc") {
                $where['cg_wcrjszc']  = array('like',"%$this->_keyword%"); //技术职称
            }
            if ($this->_lx=="cg_wcrbyyx") {
                $where['cg_wcrbyyx']  = array('like',"%$this->_keyword%"); //专业院校
            }
            if ($this->_lx=="cg_wcrjg") {
                $where['cg_wcrjg']  = array('like',"%$this->_keyword%"); //籍贯地区
            }


        }
        $this->_page_count=$count=M("zjwc_tb")->where($where)->order("zj_type desc")->count();

        $Page = new \Think\Page($count,"5");
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("zjwc_tb")->where($where)->order("zj_type  desc")->LIMIT($Page->firstRow.','.$Page->listRows)->select();//主表数据取值完成
        //echo M("zjwc_tb")->_sql();

    }


}