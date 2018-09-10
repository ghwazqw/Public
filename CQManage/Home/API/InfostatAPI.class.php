<?php
namespace Home\API;
class InfostatAPI
{
    public $DzsbCount="";
    public $DqsbCount="";
    public $YsgjCount="";
    public $QtsbCount="";
    public $WxCount="";
    public $zj_qn="";
    public $zj_zj="";
    public $zj_gw="";
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_Wx_data=array(); //主表数据
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; //关键字数据
    public $_class_data=""; //类型数据
    public $_class_meta_data=""; //关键字数据
    public $actionInfo=""; //返回要执行的动作
    public $_sblx=""; //设备类型

    function zcxx_statistics(){
        $this->_DzsbCount=$count=M("dzsb_tb")->count();
        $this->_DqsbCount=$count=M("dqsb_tb")->count();
        $this->_YsgjCount=$count=M("ysgj_tb")->count();
        $this->_QtsbCount=$count=M("qtzc_tb")->count();

    }
    function zjxx_statistics(){
        $this->zj_qn=$count=M("house_tb")->where("zclb='职工宿舍'")->count();
        $this->zj_zj=$count=M("house_tb")->where("zclb='办公用房'")->count();
        $this->zj_gw=$count=M("house_tb")->where("zclb='发行库'")->count();
        $this->zj_qt=$count=M("house_tb")->where("zclb='其他房屋'")->count();
    }
    function SbwxInfo(){
        $model = M("");
        $sql = "SELECT sum(zc_fsje) as zc_fsje,count(*) as wx_count,zc_sqwxbm FROM `zc_cq_sbxx_log_tb` where ywlx='维修记录' GROUP BY zc_sqwxbm ORDER BY sum(zc_fsje) desc LIMIT 0,10";
        $this->_Wx_data = $model -> query($sql);
        //var_export($this->_Wx_data);
        $TableName=M("sbxx_log_tb");
        $where['ywlx']=array('eq','维修记录');
        //$where['zc_sqwxbm']=array('eq','维修记录');
        $this->WxCount=$count=$TableName->where($where)->order("id DESC")->sum('zc_fsje');
        /*$Page = new \Think\Page($count,$this->_page_size);
        $this->_Wx_data=$TableName->where($where)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成*/
        //echo $TableName->_sql();*/
    }

}