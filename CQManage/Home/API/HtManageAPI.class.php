<?php
namespace Home\API;

class HtManageAPI
{
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字数据
    public $_class_data=""; //类型数据
    public $_class_meta_data=""; //关键字数据
    public $actionInfo=""; //返回要执行的动作

    function loadmatedata(){
        $TableName=M("ht_tb");
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["ht_lx"]  = array('like',"%$this->_keyword%");
            $where["ht_mc"]  = array('like',"%$this->_keyword%");
            $where["ht_qsf"]  = array('like',"%$this->_keyword%");
            //$where["ht_je"]  = array('like',"%$this->_keyword%");
            $where["ht_fkfs"]  = array('like',"%$this->_keyword%");
            /*$where["ht_kssj"]  = array('like',"%$this->_keyword%");
            $where["ht_jssj"]  = array('like',"%$this->_keyword%");
            $where["ht_bz"]  = array('like',"%$this->_keyword%"); */
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
    function AddHtxx(){
                //$TableName=$TableName;
                //echo $TableName;
            $AddData=D("ht_tb");  //注意去除前缀
            $AddData->ht_lx=I("ht_lx");
            $AddData->ht_mc=I("ht_mc");
            $AddData->ht_qsf=I("ht_qsf");
            $AddData->ht_je=I("ht_je");
            $AddData->ht_fkfs=I("ht_fkfs");
            $AddData->ht_kssj=I("ht_kssj");
            $AddData->ht_jssj=I("ht_jssj");
            $AddData->ht_bz=I("ht_bz");
            $AddData->ht_osj=I("ht_osj");
            $AddData->ht_oje=I("ht_oje");
            if (I("ht_tsj")!=""){
                $AddData->ht_tsj=I("ht_tsj");
                $AddData->ht_tje=I("ht_tje");
            };
            if (I("ht_csj")!=""){
                $AddData->ht_csj=I("ht_csj");
                $AddData->ht_cje=I("ht_cje");
            };
            if (I("ht_ssj")!=""){
                $AddData->ht_ssj=I("ht_ssj");
                $AddData->ht_sje=I("ht_sje");
            };
            if (I("ht_wsj")!=""){
                $AddData->ht_wsj=I("ht_wsj");
                $AddData->ht_wje=I("ht_wje");
            };


            $config = C('uploaddoc'); //读取上传文件配置类
            $upload = new \Think\Upload($config);// 实例化上传类
            //上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                //$this->error($upload->getError());
            }else{// 上传成功
                //$this->success('上传成功！');
                foreach ($info as $file) {
                    //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                    $AddData->ht_htfj=$file['savepath'] . $file['savename'];
                }
            }
            $AddData->add();
    }
    //编辑读取信息
    function EditHtxx(){
        $EditData=D("ht_tb");  //注意去除前缀
            $id=I("id");
            if (!$id){
                echo "Info Error";
                exit;
            }
            $ret=$EditData->where("id=$id")->limit(1)->select();
            $this->_main_data=$ret;
            }
    //编辑信息
    function EditHtxxOk(){
            $id=I("id");
            $EditData=D("ht_tb");
            $EditData->ht_lx=I("ht_lx");
            $EditData->ht_mc=I("ht_mc");
            $EditData->ht_qsf=I("ht_qsf");
            $EditData->ht_je=I("ht_je");
            $EditData->ht_fkfs=I("ht_fkfs");
            $EditData->ht_kssj=I("ht_kssj");
            $EditData->ht_jssj=I("ht_jssj");
            $EditData->ht_bz=I("ht_bz");
            $EditData->where("id=$id")->save();
    }
    //导出Excelw
    function expExcel(){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["ht_lx"]  = array('like',"%$this->_keyword%");
            $where["ht_mc"]  = array('like',"%$this->_keyword%");
            $where["ht_qsf"]  = array('like',"%$this->_keyword%");
            //$where["ht_je"]  = array('like',"%$this->_keyword%");
            $where["ht_fkfs"]  = array('like',"%$this->_keyword%");
            //$where["ht_kssj"]  = array('like',"%$this->_keyword%");
            //$where["ht_jssj"]  = array('like',"%$this->_keyword%");
            $where["ht_bz"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }

        $m = M ('ht_tb');  //
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
        $filename="ht_tb信息表";
        $headArr=array("ID","合同类型","合同名称","签署方","合同金额","付款方式","开始日期","结束日期","合同附件","备注");
        $getExcel=new ExcelAPI();
        $getExcel->getExcel($filename,$headArr,$data);
    }
    function Htlist(){
        $time=date("Y-m-d"); //获取当前时间
        $otime=date("Y-m-d",strtotime("+15 day")); //30天时间提醒

        $TableName=M("ht_tb");
        $where["ht_osj"]  = array('BETWEEN',"$time,$otime");
        $where["ht_tsj"]  = array('BETWEEN',"$time,$otime");
        $where["ht_csj"]  = array('BETWEEN',"$time,$otime");
        $where["ht_ssj"]  = array('BETWEEN',"$time,$otime");
        $where["ht_wsj"]  = array('BETWEEN',"$time,$otime");
        $where['_logic']='OR';

        $this->_page_count=$count=$TableName->where($where)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($where)->select(); //主表数据取值完成
        //echo $TableName->_sql();
    }
    function Htdqtx(){
        $id=I("id");
        $info=I("info");
            $TableName=M("ht_tb");
            $TableName->ht_txzt=$info;
            $ret=$TableName->where("id=$id")->save();
        $time=date("Y-m-d"); //获取当前时间
        $otime=date("Y-m-d",strtotime("+15 day")); //15天时间提醒
            $this->_page_count=$count=$TableName->where("ht_jssj BETWEEN '$time' and '$otime' and ht_txzt=1")->order("id DESC")->count();
                echo $this->_page_count;

    }
}

