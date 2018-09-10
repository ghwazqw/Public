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
    public $_ServerInfo=array(); //服务器信息

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
    function ServerInfo(){
        $this->_ServerInfo=$info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            '主机名'=>$_SERVER['SERVER_NAME'],
            'WEB服务端口'=>$_SERVER['SERVER_PORT'],
            '网站文档目录'=>$_SERVER["DOCUMENT_ROOT"],
            '浏览器信息'=>substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            '通信协议'=>$_SERVER['SERVER_PROTOCOL'],
            '请求方法'=>$_SERVER['REQUEST_METHOD'],
            //'ThinkPHP版本'=>THINK_VERSION,
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            //'北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            //'用户的IP地址'=>$_SERVER['REMOTE_ADDR'],
            '剩余空间'=>round((disk_free_space(".")/(1024*1024)),2).'M',
        );
    }
    function MaxLoginInfo(){
        $table=M("user_log");
        $ret=$table->where("log_type='Success'")->order("id desc")->limit('0,1')->select();
        $this->_dateil_data=$ret;
        //echo $table->_sql();
    }
}