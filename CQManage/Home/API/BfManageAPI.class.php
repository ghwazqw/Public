<?php
namespace Home\API;

class BfManageAPI
{
    public $_page_size = "40"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $_keyword = ""; //
    public $_class_data = "";
    public $_class_meta_data = "";
    public $_xmbh = "";
    public $actionInfo = ""; //返回要执行的动作
    //读取登录信息
    function getuser(){
        $get_logincook=$_COOKIE['user_info'];
        if (!$get_logincook) return false; //
        $get_user_log=unserialize($get_logincook);
        if (!$get_user_log) return false;
        if ($get_user_log->user_id && intval($get_user_log->user_id)>0){
            return $get_user_log;
        }
        return false;
    }
    //读取报废信息
    function loadmatedata($where){
        $TableName=M("bfxx_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["zc_lx"]  = array('like',"%$this->_keyword%");
            $where["zc_zcmc"]  = array('like',"%$this->_keyword%");
            $where["zc_jldw"]  = array('like',"%$this->_keyword%");
            $where["zc_ggxh"]  = array('like',"%$this->_keyword%");
            $where["zc_bfbz"]  = array('like',"%$this->_keyword%");
            //$where["zc_bfsj"]  = array('like',"%$this->_keyword%");
            $where["zc_bfzrr"]  = array('like',"%$this->_keyword%");
            $where["zc_note"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //增加信息
    function AddBfxx(){
        $config = C('uploadfile'); //读取上传文件配置类
        $upload = new \Think\Upload($config);// 实例化上传类

            $AddData=D("bfxx_tb");  //注意去除前缀
            $AddData->zc_lx=I("zc_lx"); //资产类型
            $AddData->zc_zcmc=I("zc_zcmc"); //资产名称
            $AddData->zc_jldw=I("zc_jldw"); //计量单位
            $AddData->zc_ggxh=I("zc_ggxh"); //规格型号
            $AddData->zc_bfbz=I("zc_bfbz"); //报废标志
            $AddData->zc_bfsj=I("zc_bfsj"); //报废时间
            $AddData->zc_bfzrr=I("zc_bfzrr"); //报废责任人
            //$AddData->zc_photo=I("zc_photo"); //报废图片|File
            $AddData->zc_note=I("zc_note"); //备注
            //上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                //$this->error($upload->getError());
            }else{// 上传成功
                //$this->success('上传成功！');
                foreach ($info as $file) {
                    //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                    $AddData->zc_photo=$file['savepath'] . $file['savename'];
                }
            }
            $AddData->add();
                $this->actionInfo='{$this->assign("sussInfo","信息录入成功，请继续！");}';

            }
    /*导出Excel信息*/
    function expExcel($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["zc_lx"]  = array('like',"%$this->_keyword%");  //资产类型
            $where["zc_zcmc"]  = array('like',"%$this->_keyword%");  //资产名称
            $where["zc_jldw"]  = array('like',"%$this->_keyword%");  //计量单位
            $where["zc_ggxh"]  = array('like',"%$this->_keyword%");  //规格型号
            //$where["zc_bfbz"]  = array('like',"%$this->_keyword%");  //报废标志
            //$where["zc_bfsj"]  = array('like',"%$this->_keyword%");  //报废时间
            $where["zc_bfzrr"]  = array('like',"%$this->_keyword%");  //报废责任人
            //$where["zc_photo"]  = array('like',"%$this->_keyword%");  //报废图片|File
            $where["zc_note"]  = array('like',"%$this->_keyword%");  //备注
            $where['_logic']='OR';
        }

        $m = M ('bfxx_tb');  //
        // $datas['order_p_name'] = $p_name;
        $data = $m->where($where)->order("id DESC")->select();
        foreach ($data as $k => $v)
        {
            $data[$k]['id']=$v['id'];
        }
        //var_export($data);
        //exit;
        //用vendor导入PHPExcel类库
        vendor("PHPExcel.PHPExcel");
        $filename="zc_cq_bfxx_tb信息表";
        $headArr=array("ID","类型ID","资产类型","资产名称","计量单位","规格型号","报废标志","报废时间","报废责任人","报废图片","备注");
        $getExcel=new ExcelAPI();
        $getExcel->getExcel($filename,$headArr,$data);
    }
    //提交报废信息
    function BfSubmit(){
        $config = C('uploadfile'); //读取上传文件配置类
        $upload = new \Think\Upload($config);// 实例化上传类
        $TableName=D("sbxx_log_tb");
        $content="该业务发生于：".date("Y-m-d H:i:s")."，由".I("czr")."对".I("sbmc").", 编号：".I("sbbh")."的资产设备进行了报废申请。";
        $TableName->sblx=I("sblx");
        $TableName->sbid=I("sbid");
        $TableName->sbbh=I("sbbh");
        $TableName->sbmc=I("sbmc");
        $TableName->ywlx=I("ywlx");
        $TableName->czr=I("czr");
        $TableName->cznr=$content;
        $TableName->yzrr=I("yzrr");
        $TableName->zc_note=I("zc_note");
        //报废业务处理
        $TableName->zc_sqr=I("zc_sqr");
        $TableName->zc_sqwxbm=I("zc_sqwxbm");
        $TableName->zc_bfbz=I("zc_bfbz");
        $TableName->zc_kpsm=I("kpsm");
        $TableName->zc_bfly=I("zc_bfly");
        $TableName->ppxh=I("ppxh");
        $TableName->yz=I("yz");
        $TableName->gjrq=I("gjrq");
        $TableName->czsj=date("Y-m-d H:i:s");
        //$TableName->zc_wxsj=I("zc_wxsj");
        $TableName->zc_bfzrr=I("zc_bfzrr");
        //上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            //$this->error($upload->getError());
        }else{// 上传成功
            //$this->success('上传成功！');
            foreach ($info as $file) {
                //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                $TableName->zc_photo=$file['savepath'] . $file['savename'];
            }
        }
        $result=$TableName->add();
        if($result===false)
            //$this->error('保存失败，请检查网络或与系统管理员联系！','javascript:history.back(-1);',1);
            redirect('javascript:history.back(-1);', 1, '保存失败，请检查网络或与系统管理员联系！');
        else
            redirect('/Home/BfManage/Editor', 1, '报废申请提交成功，正在返回...');
    }
    //报废信息查询
    function Bflist($where){
        $TableName=M("sbxx_log_tb");
        $this->_keyword=I("keyword");
        $where["sblx"]  = array('like',"%$this->_keyword%");
        $where["sbid"]  = array('like',"%$this->_keyword%");
        $where["sbbh"]  = array('like',"%$this->_keyword%");
        $where["sbmc"]  = array('like',"%$this->_keyword%");
        $where["ywlx"]  = array('like',"%$this->_keyword%");
        $where["czr"]  = array('like',"%$this->_keyword%");
        //$where["czsj"]  = array('like',"%$this->_keyword%");
        $where["cznr"]  = array('like',"%$this->_keyword%");
        $where["ycomp"]  = array('like',"%$this->_keyword%");
        $where["yzrr"]  = array('like',"%$this->_keyword%");
        $where["xcomp"]  = array('like',"%$this->_keyword%");
        $where["xzrr"]  = array('like',"%$this->_keyword%");

        //$where["zc_sqwxsj"]  = array('like',"%$this->_keyword%");
        $where["zc_sqwxbm"]  = array('like',"%$this->_keyword%");
        $where["zc_sqly"]  = array('like',"%$this->_keyword%");
        $where["zc_sqr"]  = array('like',"%$this->_keyword%");
        // $where["zc_wxsj"]  = array('like',"%$this->_keyword%");
        //$where["zc_photo"]  = array('like',"%$this->_keyword%");
        $where["zc_note"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['ywlx']=array('EQ','报废申请');
        $mmmap['zc_bfbz']=array('EQ',0);
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //报废信息确认
    function Bfqueren(){
        $u=$this->getuser();
        //echo $u->user_comp;
        $czr=$u->user_name;
        $table=D("sbxx_log_tb");
        $bfbz=I("zc_bfbz");
        $id=I("id");
        $nr=I("nr");
        if ($bfbz==5){
            $bz="驳回";
        }else{
            $bz="通过";
        }
        $nr.="<br />审批时间为：".date('Y-m-d H:i:s')."审批人：".$czr."审批结果：".$bz;
        if (!$table || !$id){
            echo "info error";
            exit();
        }
        //echo $nr.",".$id.",".$czr;
        $table->zc_bfsj=date("Y-m-d H:i:s");
        $table->zc_bfbz=I("zc_bfbz");
        $table->zc_sqr=$czr;
        $table->cznr=$nr;
        $table->spyj=I("cznr");
        $result=$table->where("id=$id")->save();
        //echo $table->_sql();
        if($result===false)
            //$this->error('保存失败，请检查网络或与系统管理员联系！','javascript:history.back(-1);',1);
            redirect('javascript:history.back(-1);', 1, '保存失败，请检查网络或与系统管理员联系！');
        else
            $ii=new WxManageAPI();
        if ($ii->UpdateZT(I("sblx"),I("sbid"),10)){
            redirect('/Home/BfManage/BfManage', 1, '报废信息确认成功，正在返回...');
        }else{
            redirect('/Home/WxManage/BfManage', 3, '提交成功，资产状态改变失败...');
        }

    }
    //报废信息重新发起申请
    function BfCxSq(){
        $u=$this->getuser();
        //echo $u->user_comp;
        $czr=$u->user_name;
        $table=D("sbxx_log_tb");
        $bfbz=0;
        $id=I("id");
        $nr=I("nr");
        $nr.="<br />重新提交时间为：".date('Y-m-d H:i:s')."申请人：".$czr;
        if (!$table || !$id){
            echo "info error";
            exit();
        }
        //echo $nr.",".$id.",".$czr;
        $table->zc_bfsj=date("Y-m-d H:i:s");
        $table->zc_bfbz=I("zc_bfbz");
        $table->zc_sqr=$czr;
        $table->cznr=$nr;
        $table->bfbz=$bfbz;
        $table->spyj=I("cznr");
        $result=$table->where("id=$id")->save();
        //echo $table->_sql();
        if($result===false)
            //$this->error('保存失败，请检查网络或与系统管理员联系！','javascript:history.back(-1);',1);
            redirect('javascript:history.back(-1);', 1, '保存失败，请检查网络或与系统管理员联系！');
        else
            redirect('/Home/BfManage/BfCxSq', 1, '重新申请成功，正在返回...');
    }
    //报废信息查询(全部信息)
    function Bflistq($where){
        $TableName=M("sbxx_log_tb");
        $this->_keyword=I("keyword");
        $where["sblx"]  = array('like',"%$this->_keyword%");
        $where["sbid"]  = array('like',"%$this->_keyword%");
        $where["sbbh"]  = array('like',"%$this->_keyword%");
        $where["sbmc"]  = array('like',"%$this->_keyword%");
        $where["ywlx"]  = array('like',"%$this->_keyword%");
        $where["czr"]  = array('like',"%$this->_keyword%");
        //$where["czsj"]  = array('like',"%$this->_keyword%");
        $where["cznr"]  = array('like',"%$this->_keyword%");
        $where["ycomp"]  = array('like',"%$this->_keyword%");
        $where["yzrr"]  = array('like',"%$this->_keyword%");
        $where["xcomp"]  = array('like',"%$this->_keyword%");
        $where["xzrr"]  = array('like',"%$this->_keyword%");

        //$where["zc_sqwxsj"]  = array('like',"%$this->_keyword%");
        $where["zc_sqwxbm"]  = array('like',"%$this->_keyword%");
        $where["zc_sqly"]  = array('like',"%$this->_keyword%");
        $where["zc_sqr"]  = array('like',"%$this->_keyword%");
        // $where["zc_wxsj"]  = array('like',"%$this->_keyword%");
        //$where["zc_photo"]  = array('like',"%$this->_keyword%");
        $where["zc_note"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['ywlx']=array('EQ','报废申请');
        //$mmmap['zc_bfbz']=array('EQ',0);
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //驳回信息查询
    function BfBhList(){
        $TableName=M("sbxx_log_tb");
        $this->_keyword=I("keyword");
        $where["sblx"]  = array('like',"%$this->_keyword%");
        $where["sbid"]  = array('like',"%$this->_keyword%");
        $where["sbbh"]  = array('like',"%$this->_keyword%");
        $where["sbmc"]  = array('like',"%$this->_keyword%");
        $where["ywlx"]  = array('like',"%$this->_keyword%");
        $where["czr"]  = array('like',"%$this->_keyword%");
        //$where["czsj"]  = array('like',"%$this->_keyword%");
        $where["cznr"]  = array('like',"%$this->_keyword%");
        $where["ycomp"]  = array('like',"%$this->_keyword%");
        $where["yzrr"]  = array('like',"%$this->_keyword%");
        $where["xcomp"]  = array('like',"%$this->_keyword%");
        $where["xzrr"]  = array('like',"%$this->_keyword%");
        //$where["zc_sqwxsj"]  = array('like',"%$this->_keyword%");
        $where["zc_sqwxbm"]  = array('like',"%$this->_keyword%");
        $where["zc_sqly"]  = array('like',"%$this->_keyword%");
        $where["zc_sqr"]  = array('like',"%$this->_keyword%");
        // $where["zc_wxsj"]  = array('like',"%$this->_keyword%");
        //$where["zc_photo"]  = array('like',"%$this->_keyword%");
        $where["zc_note"]  = array('like',"%$this->_keyword%");
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['ywlx']=array('EQ','报废申请');
        $mmmap['zc_bfbz']=array('eq','5');
        //$mmmap['zc_bfbz']=array('EQ',0);
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
}