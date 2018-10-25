<?php
namespace Home\API;

class WxManageAPI
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
    public $_sblx=""; //设备类型
    //维修信息
    function loadmatedata($lx,$zt,$comp){
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
            $mmmap['ywlx']=array('like',"$lx%");
            if ($comp!=""){
                $mmmap['zc_sqwxbm']=array('eq',"$comp%");
            }
            //$mmmap['spzt']=array('eq',$zt);
            $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //维修信息
    function LoadWxSpdata($zt){
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
        $mmmap['spzt']=array('eq',$zt);
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //保养信息查询
    function Bylist($where){
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
        $mmmap['ywlx']=array('EQ','养护记录');
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;

        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //增加信息
    function Addinfo(){
            $AddData=D("wxwhxx_tb");  //注意去除前缀
            $AddData->zc_lx=I("zc_lx"); //资产类型
            $AddData->zc_id=serialize(I("zc_id")); //资产名称
            $AddData->zc_jldw=I("zc_jldw"); //计量单位
            $AddData->zc_ggxh=I("zc_ggxh"); //规格型号
            $AddData->zc_sqwxsj=date("Y-m-d H:i:s"); //申请维修时间
            $AddData->zc_sqwxbm=I("zc_sqwxbm"); //申请处室
            $AddData->zc_sqly=I("zc_sqly"); //申请维修理由
            $AddData->zc_sqr=I("zc_sqr"); //申请人
            $AddData->zc_wxsj=I("zc_wxsj"); //维修时间
            //$AddData->zc_photo=I("zc_photo"); //维修图片|File
            $AddData->zc_note=I("zc_note"); //备注
            //$config = C('uploadfile'); //读取上传文件配置类
            //$upload = new \Think\Upload($config);// 实例化上传类
            /*//上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                //$this->error($upload->getError());
            }else{// 上传成功
                //$this->success('上传成功！');
                foreach ($info as $file) {
                    //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                    $AddData->zc_photo=$file['savepath'] . $file['savename'];
                }
            }*/
                $AddData->add();
                echo "提交成功！";
                    //$this->actionInfo='{$this->assign("sussInfo","信息录入成功，请继续！");}';
            }
    /*导出Excel信息*/
    function expExcel($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["zc_lx"]  = array('like',"%$this->_keyword%");  //资产类型
            $where["zc_zcmc"]  = array('like',"%$this->_keyword%");  //资产名称
            $where["zc_jldw"]  = array('like',"%$this->_keyword%");  //计量单位
            $where["zc_ggxh"]  = array('like',"%$this->_keyword%");  //规格型号
            //$where["zc_sqwxsj"]  = array('like',"%$this->_keyword%");  //申请维修时间
            $where["zc_sqwxbm"]  = array('like',"%$this->_keyword%");  //申请处室
            $where["zc_sqly"]  = array('like',"%$this->_keyword%");  //申请维修理由
            $where["zc_sqr"]  = array('like',"%$this->_keyword%");  //申请人
            //$where["zc_wxsj"]  = array('like',"%$this->_keyword%");  //维修时间
            //$where["zc_photo"]  = array('like',"%$this->_keyword%");  //维修图片|File
            $where["zc_note"]  = array('like',"%$this->_keyword%");  //备注
            $where['_logic']='OR';
        }

        $m = M ('wxwhxx_tb');  //
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
        $filename="zc_cq_wxwhxx_tb信息表";
        $headArr=array("ID","资产类型","类型ID","资产名称","计量单位","规格型号","申请维修时间","申请处室","申请维修理由","申请人","维修时间","维修图片","备注");
        $getExcel=new ExcelAPI();
        $getExcel->getExcel($filename,$headArr,$data);
    }
    //读取设备信息
    function Sbxxlist(){
       $lxTable=I("sb_lx");
       $this->_sblx=$lxTable;
       if (!$lxTable){
           echo "类型错误!";
           exit();
       }else{
           $TableName=M($lxTable);
           $this->_keyword=I("keyword");
           if ($lxTable=="dqsb_tb" || $lxTable=="dzsb_tb" || $lxTable=="qtzc_tb"){ //工具、电子设备、其他
               $where["zc_pp"]  = array('like',"%$this->_keyword%");
               $where["zc_xh"]  = array('like',"%$this->_keyword%");
               //$where["zc_scrq"]  = array('like',"%$this->_keyword%");
               $where["zc_sccj"]  = array('like',"%$this->_keyword%");
               $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");
               $where["zc_yt"]  = array('like',"%$this->_keyword%");
               $where["zc_bh"]  = array('like',"%$this->_keyword%");
               $where["zc_lx"]  = array('like',"%$this->_keyword%");
               $where["zc_rjlx"]  = array('like',"%$this->_keyword%");
               $where["zc_mc"]  = array('like',"%$this->_keyword%");
               $where["zc_jldw"]  = array('like',"%$this->_keyword%");
               $where["zc_yz"]  = array('like',"%$this->_keyword%");
               $where["zc_azcb"]  = array('like',"%$this->_keyword%");
               $where["zc_sfzjbz"]  = array('like',"%$this->_keyword%");
               $where["zc_zjnxlx"]  = array('like',"%$this->_keyword%");
               $where["zc_ljzj"]  = array('like',"%$this->_keyword%");
               $where["zc_bqzj"]  = array('like',"%$this->_keyword%");
               //$where["zc_gjrq"]  = array('like',"%$this->_keyword%");
               //$where["zc_rzrq"]  = array('like',"%$this->_keyword%");
               //$where["zc_qyrq"]  = array('like',"%$this->_keyword%");
               $where["zc_qdfs"]  = array('like',"%$this->_keyword%");
               $where["zc_ccsybm"]  = array('like',"%$this->_keyword%");
               $where["zc_sfxz"]  = array('like',"%$this->_keyword%");
               $where["zc_ccglbm"]  = array('like',"%$this->_keyword%");
               $where["zc_txm"]  = array('like',"%$this->_keyword%");
               $where["zc_zrr"]  = array('like',"%$this->_keyword%");
               $where["zc_pfdh"]  = array('like',"%$this->_keyword%");
               $where["zc_kpsm"]  = array('like',"%$this->_keyword%");
               //$where["zc_czrq"]  = array('like',"%$this->_keyword%");
               $where["zc_czlx"]  = array('like',"%$this->_keyword%");
               $where["zc_czyy"]  = array('like',"%$this->_keyword%");
               $where['_logic']='OR';
               $mmmap['_complex']=$where;
               $mmmap['zc_zt']=array('eq',1);
               $mmmap['_logic']='AND';
           }
           elseif ($lxTable=="fwkp_tb"){  //房屋信息
               $where["zc_jzmj"]  = array('like',"%$this->_keyword%");  //建筑面积
               $where["zc_jzjg"]  = array('like',"%$this->_keyword%");  //建筑结构
               $where["zc_jzcc"]  = array('like',"%$this->_keyword%");  //建筑层次
               $where["zc_dscc"]  = array('like',"%$this->_keyword%");  //地上层次
               $where["zc_dxcc"]  = array('like',"%$this->_keyword%");  //地下层次
               $where["zc_fwts"]  = array('like',"%$this->_keyword%");  //房屋套数
               $where["zc_dz"]  = array('like',"%$this->_keyword%");  //地址
               $where["zc_djbh"]  = array('like',"%$this->_keyword%");  //地籍编号
               $where["zc_tdzh"]  = array('like',"%$this->_keyword%");  //土地证号
               $where["zc_fzjg"]  = array('like',"%$this->_keyword%");  //发证机关
               $where["zc_fczh"]  = array('like',"%$this->_keyword%");  //房产证号
               $where["zc_fttdmj"]  = array('like',"%$this->_keyword%");  //分摊土地面积
               $where["zc_fttdjz"]  = array('like',"%$this->_keyword%");  //分摊土地价值
               $where["zc_sjzdmj"]  = array('like',"%$this->_keyword%");  //实际占地面积
               $where["zc_pjwh"]  = array('like',"%$this->_keyword%");  //批建文号
               $where["zc_sfww"]  = array('like',"%$this->_keyword%");  //是否文物
               $where["zc_fwlx"]  = array('like',"%$this->_keyword%");  //房屋类型
               $where["zc_fxkmj"]  = array('like',"%$this->_keyword%");  //发行库面积
               $where["zc_fxkyz"]  = array('like',"%$this->_keyword%");  //发行库原值
               $where["zc_ywkmj"]  = array('like',"%$this->_keyword%");  //业务库面积
               //$where["zc_jfsyrq"]  = array('like',"%$this->_keyword%");  //交付使用日期
               $where["zc_skjjzdjmj"]  = array('like',"%$this->_keyword%");  //守库交接整点间面积
               $where["zc_dsjksmj"]  = array('like',"%$this->_keyword%");  //电视监控室面积
               $where["zc_jwyfmj"]  = array('like',"%$this->_keyword%");  //警卫用房面积
               $where["zc_kjdakmj"]  = array('like',"%$this->_keyword%");  //会计档案库面积
               $where["zc_kbpzkmj"]  = array('like',"%$this->_keyword%");  //空白凭证库面积
               $where["zc_yytmj"]  = array('like',"%$this->_keyword%");  //营业厅面积
               $where["zc_pjjhzxmj"]  = array('like',"%$this->_keyword%");  //票据交换中心面积
               $where["zc_dzjszxmj"]  = array('like',"%$this->_keyword%");  //电子计算中心面积
               $where["zc_xjclzxmj"]  = array('like',"%$this->_keyword%");  //现金处理中心面积
               $where["zc_rfgcmj"]  = array('like',"%$this->_keyword%");  //人防工程面积
               $where['_logic']='OR';
               $mmmap['_complex']=$where;
               $mmmap['zc_zt']=array('eq',1);
               $mmmap['_logic']='AND';

                }elseif ($lxTable=="ysgj_tb"){  //运输工具
               $where["zc_gzcpp"]  = array('like',"%$this->_keyword%");  //改装车品牌
               $where["zc_gzcxh"]  = array('like',"%$this->_keyword%");  //改装车型号
               //$where["zc_pp"]  = array('like',"%$this->_keyword%");  //品牌
               //$where["zc_xh"]  = array('like',"%$this->_keyword%");  //型号
               $where["zc_jzzl"]  = array('like',"%$this->_keyword%");  //净载重量
               $where["zc_dppp"]  = array('like',"%$this->_keyword%");  //底盘品牌
               $where["zc_dpxh"]  = array('like',"%$this->_keyword%");  //底盘型号
               $where["zc_clpzh"]  = array('like',"%$this->_keyword%");  //车辆牌照号
               $where["zc_clzs"]  = array('like',"%$this->_keyword%");  //车辆座数
               $where["zc_fdxbh"]  = array('like',"%$this->_keyword%");  //发动机编号
               $where["zc_cjh"]  = array('like',"%$this->_keyword%");  //车架号
               //$where["zc_scrq"]  = array('like',"%$this->_keyword%");  //生产日期
               $where["zc_sccj"]  = array('like',"%$this->_keyword%");  //生产厂家
               $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");  //出厂产品编号
               $where["zc_csys"]  = array('like',"%$this->_keyword%");  //车上颜色
               $where["zc_pql"]  = array('like',"%$this->_keyword%");  //排气量
               $where["zc_ljxsgl"]  = array('like',"%$this->_keyword%");  //累计行驶公里
               $where["zc_dw"]  = array('like',"%$this->_keyword%");  //吨位

               $where["zc_bh"]  = array('like',"%$this->_keyword%");
               $where["zc_lx"]  = array('like',"%$this->_keyword%");
               $where["zc_rjlx"]  = array('like',"%$this->_keyword%");
               $where["zc_mc"]  = array('like',"%$this->_keyword%");
               $where["zc_jldw"]  = array('like',"%$this->_keyword%");
               $where["zc_yz"]  = array('like',"%$this->_keyword%");
               $where["zc_azcb"]  = array('like',"%$this->_keyword%");
               $where["zc_sfzjbz"]  = array('like',"%$this->_keyword%");
               $where["zc_zjnxlx"]  = array('like',"%$this->_keyword%");
               $where["zc_ljzj"]  = array('like',"%$this->_keyword%");
               $where["zc_bqzj"]  = array('like',"%$this->_keyword%");
               //$where["zc_gjrq"]  = array('like',"%$this->_keyword%");
               //$where["zc_rzrq"]  = array('like',"%$this->_keyword%");
               //$where["zc_qyrq"]  = array('like',"%$this->_keyword%");
               $where["zc_qdfs"]  = array('like',"%$this->_keyword%");
               $where["zc_ccsybm"]  = array('like',"%$this->_keyword%");
               $where["zc_sfxz"]  = array('like',"%$this->_keyword%");
               $where["zc_ccglbm"]  = array('like',"%$this->_keyword%");
               $where["zc_txm"]  = array('like',"%$this->_keyword%");
               $where["zc_zrr"]  = array('like',"%$this->_keyword%");
               $where["zc_pfdh"]  = array('like',"%$this->_keyword%");
               $where["zc_kpsm"]  = array('like',"%$this->_keyword%");
               //$where["zc_czrq"]  = array('like',"%$this->_keyword%");
               $where["zc_czlx"]  = array('like',"%$this->_keyword%");
               $where["zc_czyy"]  = array('like',"%$this->_keyword%");
               $where['_logic']='OR';
               $mmmap['_complex']=$where;
               $mmmap['zc_zt']=array('eq',1);
               $mmmap['_logic']='AND';
           }
               //加载主表数据
               $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->where("zc_zt=1")->count();
               $Page = new \Think\Page($count,$this->_page_size);
               //$Page->parameter=$this->_keyword;

               $this->_page_bar=$Page->show(); //把分布内容赋值给变量
               $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
               //echo $TableName->getLastSql();
       }
    }
    function Detail(){
        $id=I("id");
        $daltable=I("zc_lx");
        $zc_id=I("zc_id");
        if (!$id || !$daltable || !$zc_id){
            echo "Id Error";
            exit();
        }else{
            $TableName=M("wxwhxx_tb");
            $where["id"]=array('eq',$id);
            $this->_main_data=$TableName->where($where)->order("id DESC")->LIMIT(1)->select(); //主表数据取值完成
            $sbxx=$this->_main_data;
            //$sbid=unserialize($zc_id);
            foreach($sbxx as $id_info){
                $set_id=unserialize($id_info["zc_id"]);
            }
            //var_export($set_id);
            $where["id"]=array('in',$set_id);
            //echo $TableName->getLastSql();
            $daltables=M($daltable);
            $this->_dateil_data=$daltables->where($where)->order("id DESC")->select();
            //echo $daltables->_sql();
        }
    }
    //提交维修记录
    function WxSubmit(){
        $zc_wxsj=I("zc_wxsj");
        $TableName=D("sbxx_log_tb");
        $content="该业务发生于：".date("Y-m-d H:i:s")."，由".I("czr")."对".I("sbmc").", 编号：".I("sbbh")."的资产设备进行了维修信息记录。";
        $TableName->sblx=I("sblx");
        $TableName->sbid=I("sbid");
        $TableName->sbbh=I("sbbh");
        $TableName->sbmc=I("sbmc");
        $TableName->ywlx=I("ywlx");
        $TableName->czr=I("czr");
        $TableName->czsj=date("Y-m-d H:i:s");
        $TableName->cznr=$content;
        $TableName->yzrr=I("yzrr");
        //维修业务处理
        $TableName->zc_sqwxsj=I("zc_sqwxsj");
        $TableName->zc_sqwxbm=I("zc_sqwxbm");
        $TableName->zc_sqly=I("zc_sqly");
        $TableName->zc_sqr=I("zc_sqr");
        if ($zc_wxsj!=""){
            $TableName->zc_wxsj=I("zc_wxsj");
        }
        $TableName->zc_note=I("zc_note");
        $TableName->zc_fsje=I("zc_wxje");
        $TableName->add();
        //维修总金额更新
        $lx=I("sblx");
        $ywxje=I("ywxje");
        $wxzje=$ywxje+I("zc_wxje");
        $id=I("sbid");
        $EditTable=D("$lx");
        $EditTable->wxzje=$wxzje;
        $result=$EditTable->where("id=$id")->save();
        if($result===false)
            //$this->error('保存失败，请检查网络或与系统管理员联系！','javascript:history.back(-1);',1);
            redirect('javascript:history.back(-1);', 1, '保存失败，请检查网络或与系统管理员联系！');
        else
            redirect('/Home/WxManage/wxsq', 1, '记录保存成功，正在返回...');
    }

    //提交养护记录
    function YhSubmit(){
        $TableName=M("sbxx_log_tb");
        $content="该业务发生于：".date("Y-m-d H:i:s")."，由".I("czr")."对".I("sbmc").", 编号：".I("sbbh")."的资产设备进行了养护信息记录。";
        $TableName->sblx=I("sblx");
        $TableName->sbid=I("sbid");
        $TableName->sbbh=I("sbbh");
        $TableName->sbmc=I("sbmc");
        $TableName->ywlx=I("ywlx");
        $TableName->czr=I("czr");
        $TableName->czsj=date("Y-m-d H:i:s");
        $TableName->cznr=$content;
        $TableName->yzrr=I("yzrr");
        //维修业务处理
        $TableName->zc_sqwxsj=I("zc_sqwxsj");
        $TableName->zc_sqwxbm=I("zc_sqwxbm");
        $TableName->zc_sqly=I("zc_sqly");
        $TableName->zc_sqr=I("zc_sqr");
        $TableName->zc_wxsj=I("zc_wxsj");
        $TableName->zc_note=I("zc_note");
        $TableName->zc_fsje=I("zc_wxje");
        $result=$TableName->add();
        if($result===false)
            //$this->error('保存失败，请检查网络或与系统管理员联系！','javascript:history.back(-1);',1);
            redirect('javascript:history.back(-1);', 1, '保存失败，请检查网络或与系统管理员联系！');
        else
            redirect('/Home/WxManage/Bysq', 1, '养护记录保存成功，正在返回...');
    }

}