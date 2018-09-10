<?php
namespace Home\API;
class NewstestAPI
{
    public $_info_type=1;  //获取类型�?的信息，1为新�?
    public $_page_size="10"; //每页显示条数
    public $_page_bar=""; //分布组件需要展示的内容
    public $_page_count=""; //统计数量
    public $_main_data=array(); //主表数据
    public $_meta_data=array();
    public $_dateil_data=array();  //子表数据
    public $_keyword=""; // 关键字数�?
    public $_lxdata=""; //资讯类型
    public $actionInfo=""; //返回要执行的动作
    public $_type="";
    public $_cilck="";  //新闻点击量计算�?
    public $_data_data_cilck="";
    public $_data_cilck=""; //数量库中的点击量�?
    public $_file_data=array();
    function __construct($infoType,$pageSize=10)
    {
        $this->_info_type=$infoType;
        $this->_page_size=$pageSize;
    }

    function loadmatedata($where_main="",$where_dateil=""){
        //加载输入关键�?
        $this->_keyword=I("keyword");
        $this->_type=I("info_type");
        if ($this->_type!=""){
            $where_main['info_type']  = array('eq',"$this->_type");
        }
        else{
           $where_main['info_type']  = array('in',"1,2");
           $where_main['info_title'] = array('like',"%$this->_keyword%");
        }

        //加载主表数据
        $this->_page_count=$count=M("info_tb")->where($where_main)->order("info_id DESC")->count(); //获取统计数量
        $Page = new \Think\Page($count,$this->_page_size); //设置每页行数
        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_main_data=$ret=M("info_tb")->where($where_main)->order("info_id DESC")
            ->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完�?
        //echo M("info_tb")->getLastSql();
        //循环取出主表中的ID
        $set_id="";
        foreach($this->_main_data as $id_info){
            if ($set_id!="")
                $set_id.=",";
            $set_id.=$id_info["info_id"];
        }
        if ($set_id!=""){
            //判断$where_dateil不为空的情况下加入and
            if($where_dateil!="") $where_dateil=" and ".$where_dateil;
            //取出子表数据
            $this->_dateil_data=M("info_meta_tb")->where("info_id in (".$set_id.")".$where_dateil)->order("im_id DESC")->select();
        }
    }
    function loadlxdata(){
        $this->_lxdata=$ret=M("infolx_tb")->where("infolx_sfyx=1 and id in (1,2)")->order("id")->select();
        //var_export($ret);
    }
    function delnews(){
        $TableName=D("info_tb");
        $id=I("meta");
        $TableName->where("info_id=$id")->delete();
    }
    function news_dal($where)
    {
        $this->_keyword = I("id");

        if ($this->_keyword!=""){
            $where['info_id']  = array('eq',$this->_keyword); //成果名称
            //$where['_logic']='OR';
        }
        //点击量计�?
        $key="new_".$this->_keyword; //获取新闻点击量ID
        $max="4";  //每隔多少次更新数据库
        $cilck=new RedisAPI();
        $cilck->Yw_data($key,$max);
        $this->_cilck = $cilck->_cilck;
        $this->_data_data_cilck=$ret=M("info_cilck_tb")->where($where)->order("id DESC")->select(); //获取统计分析总数�?
        foreach($this->_data_data_cilck as $id_info){  //获取数据库中的统计�?
            $cil=$id_info["cilck"];
            $this->_data_cilck=$cil;
        }


        //$this->_page_count=$count=M("info_tb")->where($where)->limit(1)->order("info_id DESC")->count();
        $this->_meta_data=$ret=M("info_tb")->where($where)->limit(1)->order("info_id")->select(); //详细表数据取值完�?
        $this->_file_data=M("infofile_tb")->where($where)->order("id DESC")->select(); //附件信息查询
        //$this->_dateil_data=$ret=M("info_anal_tb")->where($where)->order("info_id DESC")->select(); //统计分析数据
        $this->_page_count=$ret=M("info_anal_tb")->where($where)->order("info_id DESC")->count(); //获取统计分析总数�?

        //echo ($this->_page_count);
        if ($this->_page_count<2){
            $this->_dateil_data=0;
            //echo $this->_dateil_data;
        }else{
            //echo "分析完成";
            $this->_dateil_data=$ret=M("info_anal_tb")->where($where)->order("info_count DESC")->LIMIT(2)->select(); //统计分析数据
            //更新分析结果
            $set_anal_type="";
            $set_count="";
            foreach($this->_dateil_data as $anal_info){

                $set_anal_type=$anal_info["info_type"];
                $set_count=$anal_info["info_count"];
            }
            $info_edit_table=D("info_tb")->where($where);
            $info_edit_table->info_count=$set_count;
            $info_edit_table->info_anal_type=$set_anal_type;
            $info_edit_table->save();
        }
       //echo M("info_anal_tb")->_sql();

    }
    function about_dal($where)
    {
        $this->_keyword = I("id");
        if ($this->_keyword!=""){
            $where['info_id']  = array('eq',$this->_keyword); //新闻ID
            //$where['info_type']= array('eq','5');
            //$where['_logic']='OR';
        }
        else{
            $where['info_id']  = array('eq','94');
            //return false;
        }

        $this->_page_count=$count=M("info_tb")->where($where)->order("info_id DESC")->where("info_type=3")->count();
        $this->_meta_data=$ret=M("info_tb")->where($where)->order("info_id DESC")->where("info_type=3")->select(); //详细表数据取值完�?
    }


    function add_info(){
        $config = C('up_file'); //读取上传文件配置�?
        //增加数据
        if ($_POST) {
            $info_add_tb=D("info_tb");  //D方法获取表名
            $info_add_tb->info_type=I("zx_lx");
            $info_add_tb->info_title=I("info_title");
            $info_add_tb->info_keywords=I("info_keywords");
            $info_add_tb->info_user=I("info_user");
            $newDateStr = date('Y-m-d',strtotime(I("info_date")));
            $info_add_tb->info_date=date('Y-m-d H:i:s',time()); 
            $info_add_tb->info_note=I("info_note");
            $info_add_tb->info_laiyuan=I("info_laiyuan");
            $info_add_tb->info_content=$_POST["content"];
            $info_add_tb->info_photonew=I("photo");

          $ret=$info_add_tb->add();
            $upload = new \Think\Upload($config);// 实例化上传类
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                //$this->error($upload->getError());
            }else{// 上传成功
                //$this->success('上传成功�?);
                $filetable=M("infofile_tb");
                foreach ($info as $file) {
                    //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                    $filetable->info_id=$ret;
                    $filetable->photo=$file['savepath'] . $file['savename'];
                    $filetable->add();
                }
            }
                $this->actionInfo='{$this->assign("sussInfo","信息录入成功，请继续�?);}';


        }

    }
    function edit_info(){
        $id=I("id");
            $info_add_tb=D("info_tb");  //D方法获取表名
            $info_add_tb->info_type=I("zx_lx");
            $info_add_tb->info_title=I("info_title");
            $info_add_tb->info_keywords=I("info_keywords");
            $info_add_tb->info_user=I("info_user");
            $newDateStr = date('Y-m-d',strtotime(I("info_date")));
            $info_add_tb->info_date=I("info_date");
            $info_add_tb->info_note=I("info_note");
            $info_add_tb->info_laiyuan=I("info_laiyuan");
            $info_add_tb->info_content=$_POST["content"];
            $info_add_tb->where("info_id=$id")->save();
            $this->actionInfo='{$this->assign("sussInfo","信息编辑成功，请继续�?);}';
    }


}