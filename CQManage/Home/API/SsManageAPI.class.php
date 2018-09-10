<?php
namespace Home\API;

class SsManageAPI
{
    public $_page_size = "100"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $_keyword = ""; //关键词
    public $_class_data = "";
    public $_class_meta_data = "";
    public $_xmbh = "";
    public $actionInfo = ""; //返回要执行的动作
    public $_stId=""; //盘点单id
    public $_stTime=""; //盘点日期
    public $_handingUser=""; //盘点人
    public $_stNO=""; //盘点单编号
    public $_depName=""; //盘点部门
    public $_comp="";
    public $_Jsoninfo="";
    public $_nf="";

    //读取当前房间内人员信息
    function HouseRyInfo(){
        $houser_id=I("id");
        if (!$houser_id){
            echo "房间ID错误";
            exit();
        }
        $table=M("ryrzxx_tb");
        $where["ry_ssfjid"]  = array('eq',$houser_id);
        $this->_page_count=$count=$table->where($where)->order("id DESC")->count();
        $this->_main_data=$table->where($where)->order("id DESC")->select();
        //$this->_page_count=$table->where($where)->count;
        //echo $table->_sql();
    }
    //给房间增加人员信息
    function AddRyInfo(){
         $AddData=D("ryrzxx_tb");  //人员入住主表
           $this->_stId=I("ry_ssfjid");;
        $AddData->ry_name=I("ry_name"); //人员姓名
            $AddData->ry_xb=I("ry_xb"); //人员性别
            $AddData->ry_sfzh=I("ry_sfzh"); //身份证号
            $AddData->ry_lxid=I("ry_lxid"); //人员类型id
            $AddData->ry_ssfjid=I("ry_ssfjid"); //所属房间id
            $AddData->ry_ssfjname=I("ry_ssfjname"); //所属房间名称
            $AddData->ry_ssfjmj=I("ry_ssfjmj"); //所属房间面积
            $AddData->ry_rzrq=I("ry_rzrq"); //入住日期
            $AddData->ry_dqrq=I("ry_dqrq"); //到期日期
            //$AddData->ry_ttrq=I("ry_ttrq"); //腾退日期
            $AddData->ht_nxlx=I("ht_nx"); //合同类型
            $AddData->ht_nx=I("ht_nx1"); //合同年限
            $AddData->ht_zj=I("ht_zj"); //租金
            $AddData->bz=I("bz"); //备注
            $AddData->kssfyf=I("kssfyf"); //开始收费月份
            $AddData->jssfyf=I("jssfyf"); //结束收费月份
            $zb_id=$AddData->add();
            //echo $zb_id;
            $KsSfsj=I("kssfyf"); //开始收费时间
            $JsSfsj=I("jssfyf"); //结束收费时间
            $SfNf=date("Y",strtotime($KsSfsj)); //开始收费年份
            $SfYf=date("m",strtotime($KsSfsj)); //开始收费月份
            $SfYfS=13-$SfYf; //当不是整年度时的第一年收取月份数
            $TempYf=$SfYf-1; //多一个月份修正
            $Fjmj=I("ry_ssfjmj"); //房间面积
            $HtZj=I("ht_zj"); //协议租金
            $HtNx=I("ht_nx1");
            /*个人每年租金计算*/
            $RyZjTable=M("temprzxx_tb"); //人员详细表
            $ht_nxlx=I("ht_nx");
            if ($ht_nxlx==4){ //类型为4年固定期时
                if ($SfYf==1){ //收费周期为整年度计算
                    //第一年
                    $YnJe=10*12;
                    $RyZjTable->nf=$SfNf;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                    //第二年
                    $YnJe=20*12;
                    $RyZjTable->nf=$SfNf+1;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                    //第三、四年
                    for ($i=1;$i<3;$i+=1){
                        if ($i==1){
                            $SfNf=$SfNf+2;
                        }else{
                            $SfNf=$SfNf+1;
                        }
                        $YnJe=$Fjmj*12;
                        $RyZjTable->nf=$SfNf;
                        $RyZjTable->zj=$YnJe;
                        $RyZjTable->fj_id=I("ry_ssfjid");
                        $RyZjTable->nx_lx=I("ht_nx");
                        $RyZjTable->ry_name=I("ry_name");
                        $RyZjTable->zb_id=$zb_id;
                        $RyZjTable->add();
                    };
                }else{ //收费年度不是整年时计算方法
                    //第一年
                    //echo $SfYfS;
                    $YnJe=10*$SfYfS;
                    $RyZjTable->nf=$SfNf;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                    //第二年
                    $tempje1=10*$TempYf; //按照第一年费用收取计算
                    $tempje2=20*$SfYfS; //按照第二年费用收取计算
                    $YnJe=$tempje1+$tempje2; //第二年费用由以上两个数值相加
                    //echo $SfYfS;
                    $RyZjTable->nf=$SfNf+1;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                    //第三年
                    $tempje1=20*$TempYf; //按照第二年费用收取计算
                    $tempje2=$Fjmj*$SfYfS; //按照第三年费用收取计算
                    $YnJe=$tempje1+$tempje2; //第三年费用由以上两个数值相加
                    //echo $SfYfS;
                    $RyZjTable->nf=$SfNf+3;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                    //第四年
                    $tempje1=$Fjmj*$TempYf; //按照第三年费用收取计算
                    $tempje2=$Fjmj*$SfYfS; //按照第四年费用收取计算
                    $YnJe=$tempje1+$tempje2; //第四年费用由以上两个数值相加
                    //echo $SfYfS;
                    $RyZjTable->nf=$SfNf+4;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                    //第五年
                    $tempje1=$Fjmj*$TempYf; //最后结算
                    $YnJe=$tempje1;
                    //echo $SfYfS;
                    $RyZjTable->nf=$SfNf+5;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                }
            }else{ //合同类型为“其他”时
                $TempNx=$HtNx+1;
                if ($SfYf==1){
                    for ($i=1;$i<$TempNx;$i+=1){
                        $YnJe=$HtZj*12;
                        $RyZjTable->nf=$SfNf;
                        $RyZjTable->zj=$YnJe;
                        $RyZjTable->fj_id=I("ry_ssfjid");
                        $RyZjTable->nx_lx=I("ht_nx");
                        $RyZjTable->ry_name=I("ry_name");
                        $RyZjTable->zb_id=$zb_id;
                        $RyZjTable->add();
                        $SfNf=$SfNf+1;
                    };
                }else{
                    //第一年
                    $YnJe=$HtZj*$SfYfS;
                    $RyZjTable->nf=$SfNf;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                    $SfNf=$SfNf+1;
                    //中间年度循环处理
                    for ($i=1;$i<$TempNx-1;$i+=1){
                        $YnJe=$HtZj*12;
                        $RyZjTable->nf=$SfNf;
                        $RyZjTable->zj=$YnJe;
                        $RyZjTable->fj_id=I("ry_ssfjid");
                        $RyZjTable->nx_lx=I("ht_nx");
                        $RyZjTable->ry_name=I("ry_name");
                        $RyZjTable->zb_id=$zb_id;
                        $RyZjTable->add();
                        $SfNf=$SfNf+1;
                    }
                    //最后一年处理
                    $tempje1=$HtZj*$TempYf; //最后结算
                    $YnJe=$tempje1;
                    //echo $SfYfS;
                    $RyZjTable->nf=$SfNf;
                    $RyZjTable->zj=$YnJe;
                    $RyZjTable->fj_id=I("ry_ssfjid");
                    $RyZjTable->nx_lx=I("ht_nx");
                    $RyZjTable->ry_name=I("ry_name");
                    $RyZjTable->zb_id=$zb_id;
                    $RyZjTable->add();
                }
            }
            //房间表状态更新
            $Fjtable=M("house_tb");
            $fjid=I("ry_ssfjid");
            $Fjtable->rz_zt=1;
            $Fjtable->where("id=$fjid")->save();
    }
    //人员租金信息读取
    function RzInfoList(){
        $table=M("temprzxx_tb");
        $fjid=I("fjid");
        $Ryname=I("name");
        $where["fj_id"]  = array('eq',$fjid);
        if ($Ryname!=""){
            $where["ry_name"]  = array('eq',"$Ryname");
        }
        //$where['_logic']='and';
        $this->_main_data=$table->where($where)->order("id")->select();
        //echo $table->_sql();
    }
    //年度租金信息读取
    function RzInfoNdList($fjid){
        $table=M("temprzxx_tb");
        $fjid=I("fjid");
        $Sqnd=date("Y");
        $Sqnd=$Sqnd-1;
        $Ryname=I("name");
        $where["fj_id"]  = array('eq',$fjid);
        $where["nf"]=array('eq',$Sqnd);
        if ($Ryname!=""){
            $where["ry_name"]  = array('eq',"$Ryname");
        }
        //$where['_logic']='and';
        $this->_main_data=$table->where($where)->order("id")->select();
        //echo $table->_sql();
    }
    //年度所有人员租金信息统计
    function RzInfoNdNdList($fjid){
        $table=M("temprzxx_tb");
        $fjid=I("fjid");
        $Sqnd=date("Y");
        $Sqnd=$Sqnd-1;
        $Ryname=I("name");
        $where["fj_id"]  = array('eq',$fjid);
        $where["nf"]=array('eq',$Sqnd);
        //$where['_logic']='and';
        $count=$table->where($where)->order("id")->count();
        $where["zt"]=array('eq',1);
        $sum=$table->where($where)->order("id")->sum("zt");
        if (!$count){
            $this->_page_count=0;
        }else{
            $hj=$sum/$count;
            $hj=sprintf("%.2f", $hj)*100;
            $this->_page_count=$hj;
        }

        //$this->_main_data=$table->where($where)->order("id")->select();
        //echo $table->_sql();
    }

    //收取租金提交
    function ZjSubmit(){
        $id=I("id");
        if (!$id){
            echo "ID Error";
            exit;
        }
        $table=M("temprzxx_tb");
        $table->zt=1;
        $where["id"]  = array('eq',$id);
        $table->where($where)->save(); //提交数据
    }
    //人员信息查询
    function RyInfo(){
        $table=M("ryrzxx_tb");
        $fjid=I("fjid");
        $where["ry_ssfjid"]  = array('eq',$fjid);
        $this->_main_data=$table->where($where)->order("id")->select();

    }
    //入住中的房间信息查询
    function RzFjInfo(){
            $TableName=M("ryrzxx_tb");
            $this->_keyword=I("keyword");
                $where["ry_name"]  = array('like',"%$this->_keyword%");
                $where["ry_sfzh"]  = array('like',"%$this->_keyword%");
                $where["ry_xb"]  = array('like',"%$this->_keyword%");
                //$where["ry_lxid"]  = array('like',"%$this->_keyword%");
                //$where["ry_ssfjid"]  = array('like',"%$this->_keyword%");
                $where["ry_ssfjname"]  = array('like',"%$this->_keyword%");
                /*$where["ry_ssfjmj"]  = array('like',"%$this->_keyword%");
                //$where["ry_rzrq"]  = array('like',"%$this->_keyword%");
                //$where["ry_dqrq"]  = array('like',"%$this->_keyword%");
                //$where["ry_ttrq"]  = array('like',"%$this->_keyword%");
                $where["ht_nx"]  = array('like',"%$this->_keyword%");
                $where["ht_zj"]  = array('like',"%$this->_keyword%");
                $where["bz"]  = array('like',"%$this->_keyword%");
                $where["kssfyf"]  = array('like',"%$this->_keyword%");
                //$where["zt"]  = array('like',"%$this->_keyword%");
                $where["jssfyf"]  = array('like',"%$this->_keyword%");*/
                $where['_logic']='OR';
                $mmmap['_complex']=$where;
                $mmmap['zt']=array('eq',1);
                $mmmap['ry_ttrq']=array('exp', 'is null');
                $mmmap['_logic']='AND';
            //加载主表数据
            $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
            $Page = new \Think\Page($count,$this->_page_size);
            //$Page->parameter=$this->_keyword;
            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
            //echo $TableName->getLastSql();
    }
    //腾退间信息查询
    function TtInfo(){
        $TableName=M("ryrzxx_tb");
        $this->_keyword=I("keyword");
        $where["ry_name"]  = array('like',"%$this->_keyword%");
        $where["ry_sfzh"]  = array('like',"%$this->_keyword%");
        $where["ry_xb"]  = array('like',"%$this->_keyword%");
        //$where["ry_lxid"]  = array('like',"%$this->_keyword%");
        //$where["ry_ssfjid"]  = array('like',"%$this->_keyword%");
        $where["ry_ssfjname"]  = array('like',"%$this->_keyword%");
        /*$where["ry_ssfjmj"]  = array('like',"%$this->_keyword%");
        //$where["ry_rzrq"]  = array('like',"%$this->_keyword%");
        //$where["ry_dqrq"]  = array('like',"%$this->_keyword%");
        //$where["ry_ttrq"]  = array('like',"%$this->_keyword%");
        $where["ht_nx"]  = array('like',"%$this->_keyword%");
        $where["ht_zj"]  = array('like',"%$this->_keyword%");
        $where["bz"]  = array('like',"%$this->_keyword%");
        $where["kssfyf"]  = array('like',"%$this->_keyword%");
        //$where["zt"]  = array('like',"%$this->_keyword%");
        $where["jssfyf"]  = array('like',"%$this->_keyword%");*/
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        $mmmap['ry_ttrq']=array('exp', 'is not null');
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    //入住信息查询
    function RzInfo(){
        $TableName=M("ryrzxx_tb");
        $this->_keyword=I("keyword");
        $this->_nf=I("nf");
        $where["ry_name"]  = array('like',"%$this->_keyword%");
        $where["ry_sfzh"]  = array('like',"%$this->_keyword%");
        $where["ry_xb"]  = array('like',"%$this->_keyword%");
        //$where["ry_lxid"]  = array('like',"%$this->_keyword%");
        //$where["ry_ssfjid"]  = array('like',"%$this->_keyword%");
        $where["ry_ssfjname"]  = array('like',"%$this->_keyword%");
        /*$where["ry_ssfjmj"]  = array('like',"%$this->_keyword%");
        //$where["ry_rzrq"]  = array('like',"%$this->_keyword%");
        //$where["ry_dqrq"]  = array('like',"%$this->_keyword%");
        //$where["ry_ttrq"]  = array('like',"%$this->_keyword%");
        $where["ht_nx"]  = array('like',"%$this->_keyword%");
        $where["ht_zj"]  = array('like',"%$this->_keyword%");
        $where["bz"]  = array('like',"%$this->_keyword%");
        $where["kssfyf"]  = array('like',"%$this->_keyword%");
        //$where["zt"]  = array('like',"%$this->_keyword%");
        $where["jssfyf"]  = array('like',"%$this->_keyword%");*/
        $where['_logic']='OR';
        $mmmap['_complex']=$where;
        //$mmmap['ry_ttrq']=array('exp', 'is not null');
        if (I("nf")!=""){
            $mmmap['ry_rzrq']=array('like', "$this->_nf%");
        }
        $mmmap['_logic']='AND';
        //加载主表数据
        $this->_page_count=$count=$TableName->where($mmmap)->order("id DESC")->count();
        $Page = new \Think\Page($count,$this->_page_size);
        //$Page->parameter=$this->_keyword;
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$TableName->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $TableName->getLastSql();
    }
    function TsSubmit(){
        /*接收房间ID\姓名\腾退日期\面积变量*/
        $fjid=I("fjid");
        $subname=I("subname");
        $fjmj=I("fjmj");
        $xyzj=I("zjxx");
        $nxlx=I("nxlx");
        $ry_ttrq=I("ry_ttrq");
        $zjksyf=I("zjksyf");
        $KszjNf=round(date("Y",strtotime($zjksyf))); //年
        $KszjYf=date("m",strtotime($zjksyf)); //月
        $sfsj=I("sfsj"); //收费月份
        $TtzjNf=round(date("Y",strtotime($sfsj))); //年
        $TtzjYf=date("m",strtotime($sfsj)); //月
        $sfnfjs=round($TtzjNf-$KszjNf);
        $sfyfjs=$TtzjYf-$KszjYf;

        if (!$fjid || !$subname || !$ry_ttrq || !$zjksyf || !$sfsj){
            echo "Id Error";
            exit();
        }else{
            /*echo $zjksyf."开始<br />";
            echo $sfsj."结束收费<br />";
            echo $sfnfjs."年数量<br />";
            echo $sfyfjs."月数量<br />";*/
        }
        //编辑详细表数据
        $EditTable=M("temprzxx_tb");
        $where['ry_name']=array('eq',$subname);
        $where['fj_id']=array('eq',$fjid);
        $where['nf']=array('GT',$TtzjNf);
        //$ret=$EditTable->where($where)->save();
        $mmap['ry_name']=array('eq',$subname);
        $mmap['fj_id']=array('eq',$fjid);
        $mmap['nf']=array('eq',$TtzjNf);
        //echo $EditTable->_sql();
        if ($nxlx==4){ //类型为4年年限时
        switch ($sfnfjs){  //循环判断年份
            default; //年份错误计算
                echo "年份错误";
                break;
            case '0'; //第一年计算
                if ($sfyfjs<=0){
                    $zj="";
                    echo "腾退日期输入错误,请检查";
                    exit();
                }else{
                    $zj="";
                    $zj=$sfyfjs*10+10;
                    //echo $zj."<br />";
                    //echo $TtzjNf;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }
                break;
            case '1'; //第二年
                $zj="";
            //echo "1年收费";
            if ($sfyfjs<0){
                $zj="";
                $zj=$TtzjYf*10;
                //echo $zj;
                $EditTable->zj=$zj;
                $EditTable->where($mmap)->save(); //更新本年度数据
                $EditTable->zj=0;
                $EditTable->where($where)->save(); //清空多余数据
            }else{
                $zj="";
                $dezj=$sfyfjs*20+20; //第二年总和
                $dyzj=$KszjYf*10-10; //第一年剩余
                $zj=$dezj+$dyzj;
                //echo $zj;
                $EditTable->zj=$zj;
                $EditTable->where($mmap)->save(); //更新本年度数据
                $EditTable->zj=0;
                $EditTable->where($where)->save(); //清空多余数据
            }
                break;
            case '2'; //第三年
                //echo "1年收费";
                if ($sfyfjs<0){
                    $zj="";
                    $mj2=$TtzjYf*20;
                    $zj=$mj2;
                    //echo $zj;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }else{
                    $zj="";
                    $mj2=$fjmj;
                    $dezj=$sfyfjs*$fjmj+$mj2; //第二年总和
                    $dyzj=$KszjYf*20-20; //第一年剩余
                    $zj=$dezj+$dyzj;
                    //echo $zj;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }
                break;
            case '3': //第四年
                //$sfyfjs11=$KszjYf-$TtzjYf;
                //echo $sfyfjs;
                if ($sfyfjs<0){
                    $zj="";
                    $mj2=$fjmj*$TtzjYf;
                    $zj=$mj2;
                    //echo $zj;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }else{
                    $zj="";
                    $mj2=$fjmj;
                    $dezj=$sfyfjs*$fjmj+$mj2; //第二年总和
                    $dyzj=$KszjYf*$fjmj-$fjmj; //第一年剩余
                    $zj=$dezj+$dyzj;
                    //echo $zj;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }
                break;
            case '4': //第四年
                //$sfyfjs11=$KszjYf-$TtzjYf;
                //echo $sfyfjs;
                if ($sfyfjs<0){
                    $zj="";
                    $mj2=$fjmj*$TtzjYf;
                    $zj=$mj2;
                    //echo $zj;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }else{
                    $zj="";
                    $mj2=$fjmj;
                    $dezj=$sfyfjs*$fjmj+$mj2; //第二年总和
                    $dyzj=$KszjYf*$fjmj-$fjmj; //第一年剩余
                    $zj=$dezj+$dyzj;
                    //echo $zj;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }
                break;
            case '5': //第四年
                //$sfyfjs11=$KszjYf-$TtzjYf;
                //echo $sfyfjs;
                if ($sfyfjs<0){
                    $zj="";
                    $mj2=$fjmj*$TtzjYf;
                    $zj=$mj2;
                    //echo $zj;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }else{
                    $zj="";
                    $mj2=$fjmj;
                    $dezj=$sfyfjs*$fjmj+$mj2; //第二年总和
                    $dyzj=$KszjYf*$fjmj-$fjmj; //第一年剩余
                    $zj=$dezj+$dyzj;
                    //echo $zj;
                    $EditTable->zj=$zj;
                    $EditTable->where($mmap)->save(); //更新本年度数据
                    $EditTable->zj=0;
                    $EditTable->where($where)->save(); //清空多余数据
                }
                break;
        }
        }else{ //其他年限
            switch ($sfnfjs){

                case '0'; //第一年计算
                    if ($sfyfjs<=0){
                        $zj="";
                        echo "腾退日期输入错误,请检查";
                    }else{
                        $zj=$sfyfjs*$xyzj+$xyzj;
                        //echo $zj."<br />";
                        //echo $TtzjNf;
                       /* $EditTable->zj=$zj;
                        $EditTable->where($mmap)->save(); //更新本年度数据
                        $EditTable->zj=0;
                        $EditTable->where($where)->save(); //清空多余数据*/
                    }
                    break;
                default;
                    if ($sfyfjs<0){
                        $mj2=$xyzj*$TtzjYf;
                        $zj=$mj2;
                        //echo $zj;
                        $EditTable->zj=$zj;
                        $EditTable->where($mmap)->save(); //更新本年度数据
                        $EditTable->zj=0;
                        $EditTable->where($where)->save(); //清空多余数据
                    }else{
                        $dezj=$sfyfjs*$xyzj+$xyzj; //第二年总和
                        $dyzj=$KszjYf*$xyzj-$xyzj; //第一年剩余
                        $zj=$dezj+$dyzj;
                        //echo $zj;
                        $EditTable->zj=$zj;
                        $EditTable->where($mmap)->save(); //更新本年度数据
                        $EditTable->zj=0;
                        $EditTable->where($where)->save(); //清空多余数据
                    }
                    break;
            }

        }
        //编辑入住表数据
        $EditZTable=M("ryrzxx_tb");
        $edinfo['ry_ssfjid']=array('eq',$fjid);
        $edinfo['ry_name']=array('eq',$subname);
        $EditZTable->ry_ttrq=$ry_ttrq;  //更新腾退日期
        $EditZTable->where($edinfo)->save();
        //echo M("ryrzxx_tb")->_sql();
    }

    function NdZjView($where){
        $TableName=M("zjxx_vm");
        $this->_nf=I("nf");
        $this->_keyword=I("keyword");
            $where["ry_name"]  = array('like',"%$this->_keyword%");
            $where["nx_lx"]  = array('like',"%$this->_keyword%");
            $where["fj_id"]  = array('like',"%$this->_keyword%");
            //$where["nf"]  = array('like',"%$this->_keyword%");
            $where["zj"]  = array('like',"%$this->_keyword%");
            $where["zb_id"]  = array('like',"%$this->_keyword%");
            //$where["zt"]  = array('like',"%$this->_keyword%");
            $where["homename"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
            //$mmmap['ry_ttrq']=array('exp', 'is not null');
            if (I("nf")!=""){
                $mmmap['nf']=array('eq', "$this->_nf");
            }else{
                $mmmap['nf']=array('eq', "2018");
            }
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