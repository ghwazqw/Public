<?php
namespace Home\API;
class LinkAPI
{
    public $_info_type=1;  //获取类型为1的信息，1为新闻
    public $_page_size="40"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_meta_data=array();
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; // 关键字数据
    public $_lxdata=""; //资讯类型
    public $actionInfo=""; //返回要执行的动作
    function __construct($infoType,$pageSize=40)
    {
        $this->_info_type=$infoType;
        $this->_page_size=$pageSize;
    }

    function loadmatedata($where_main="",$where_dateil=""){
        //加载输入关键字
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where_main['info_title']  = array('like',"%$this->_keyword%"); //新闻标题
            $where_main['info_keywords']  = array('like',"%$this->_keyword%");  //关键词
            //$where['_logic']='OR';
        }
        //加载主表数据
        $this->_page_count=$count=M("info_tb")->where($where_main)->order("info_id DESC")->where("info_type=4")->count(); //获取统计数量
        $Page = new \Think\Page($count,$this->_page_size); //设置每页行数
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("info_tb")->where("info_type=".$this->_info_type)->order("info_id DESC")
            ->where("info_type=4")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
        //echo $ret->getLastSql();
        //循环取出主表中的ID
    }
    function loadlxdata(){
        $this->_lxdata=$ret=M("infolx_tb")->where("infolx_sfyx=1")->order("id")->select();
        //var_export($ret);
    }
    function news_dal($where)
    {
        $this->_keyword = I("id");
        if ($this->_keyword!=""){
            $where['info_id']  = array('eq',$this->_keyword); //成果名称
            //$where['_logic']='OR';
        }
        $this->_page_count=$count=M("info_tb")->where($where)->order("info_id DESC")->count();
        $this->_meta_data=$ret=M("info_tb")->where($where)->order("info_id DESC")->select(); //详细表数据取值完成
    }

    function add_info(){
        $config = C('uploadfile'); //读取上传文件配置类
        //增加数据
        if ($_POST) {
            $info_add_tb=D("info_tb");  //D方法获取表名
            $info_add_tb->info_type="4";
            $info_add_tb->info_title=I("info_title");
            $info_add_tb->info_keywords=I("info_keywords");
            $newDateStr = date('Y-m-d',strtotime(I("info_date")));
            $info_add_tb->info_date=$newDateStr;
            $info_add_tb->info_link=I("info_link");

            $upload = new \Think\Upload($config);// 实例化上传类
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) { // 上传错误提示错误信息
                $this->error($upload->getError());
                return false;
            }else{ // 上传成功
                //$this->success('上传成功！');
                foreach ($info as $file) {
                    //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                    $info_add_tb->info_photo=$file['savepath'] . $file['savename'];
                }
            }
            $info_add_tb->add();
            $this->actionInfo='{$this->assign("sussInfo","信息录入成功，请继续！");}';


        }

    }


}