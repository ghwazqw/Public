<?php
namespace Home\API;

class NewsAPI
{
    //public $_page_size = "1000"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $actionInfo = ""; //返回要执行的动作
    public $_Msg="";
    public $_zt=0;

    //读取新闻分类
    function NewSort(){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字

        if (!$sort){
            $sort="id";
        }

        $TableName=M("infolx_tb");
        if ($search!=""){
            $where["name"]=array("like","%$search%");
        }

            $this->_page_count=$count=$TableName->where($where)->order($sort." ". $order)->count();
            $Page = new \Think\Page($count,$limit);
            //$Page->parameter=$this->_keyword;
            $this->_page_bar=$Page->show(); //把分布内容赋值给变量
            $this->_page_ys=$Page->totalPages;
            $this->_main_data=$TableName->where($where)->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
            //echo $TableName->getLastSql();
            if ($count==0){
                $this->_Msg='数据结果为0';
            }else{
                $this->_Msg='获取成功';
            }
    }
    //按照类别读取资讯信息
    function NewsKeyList($id){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字

        if (!$sort){
            $sort="id";
        }
        $TableName=M("news_vm");
        $where["n_lxid"]=array("eq",$id); //根据上级ID检索
        $where["n_title"]=array("neq","视频");
        $this->_main_data=$TableName->where($where)->select();
        //echo $TableName->_sql();
        //var_dump($this->_main_data);
    }
    //加载分类树
    function LoadNewsSortTree(){
        $Table=M("infolx_tb");
        $ret=$Table->order("id")->getField('id,sjid,name as text');
        //echo $Table->_sql();
        //var_export($ret);
        $this->_main_data=$ret;
        //echo json_encode($ret);
    }
    //讀取活動公告信息
    function applicationinfo($type){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        $lx=$type;
        $recomm=I("recomm");

        if (!$sort){
            $sort="n_id"; //默认排序字段
        }
        if (!$order){
            $order="desc"; //默认排序方式
        }
        if (!$offset){
            $offset=0; //默认数据读取
        }

        $TableName=M("news_vm");
        if ($search!=""){
            $where["n_title"]=array("like","%$search%"); //标题搜索
            $where["n_keyword"]=array("like","%$search%"); //关键字搜索
            $where["n_author"]=array("like","%$search%"); //作者搜索
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
        }


        if ($lx!=""){
            $mmmap["lx_name"]=array("eq",$lx);
        }
        if ($recomm!=""){
            $mmmap["n_recomm"]=array("eq",$recomm);
        }
        $mmmap["n_recomm"]=array("eq",1);
        $mmmap['_logic']='AND';

        $this->_page_count=$count=$TableName->where($mmmap)->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        $this->_main_data=$TableName->where($mmmap)->order($sort." ". $order)->LIMIT($offset.','.$limit)->getField("n_id,n_img,n_note,n_title,n_datetime,lx_name,n_recomm"); //据取值完成
        //exit($TableName->getLastSql()) ;
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }
    //读取资讯信息
    function NewsInfo($id){
        $limit=I("limit"); //从前端获取每页显示的数量
        $order=I("order"); //排序方式获取
        $sort=I("sort"); //排序字段获取
        $offset=I("offset"); //排序位置获取
        $search=I("search"); //获取搜索关键字
        $lx=I("type");
        $recomm=I("recomm");

        if (!$sort){
            $sort="n_id"; //默认排序字段
        }
        if (!$order){
            $order="desc"; //默认排序方式
        }
        if (!$offset){
            $offset=0; //默认数据读取
        }

        $TableName=M("news_vm");
        if ($search!=""){
            $where["n_title"]=array("like","%$search%"); //标题搜索
            $where["n_keyword"]=array("like","%$search%"); //关键字搜索
            $where["n_author"]=array("like","%$search%"); //作者搜索
            $where['_logic']='OR';
            $mmmap['_complex']=$where;
        }


        if ($lx!=""){
            $mmmap["lx_name"]=array("eq",$lx);
        }
        if ($recomm!=""){
            $mmmap["n_recomm"]=array("eq",$recomm);
        }
        $mmmap['_logic']='AND';

        $this->_page_count=$count=$TableName->where($mmmap)->count();
        $Page = new \Think\Page($count,$limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar=$Page->show(); //把分布内容赋值给变量
        $this->_page_ys=$Page->totalPages;
        if (!$id){
            $this->_main_data=$TableName->where($mmmap)->order($sort." ". $order)->LIMIT($offset.','.$limit)->getField("n_id,n_img,n_note,n_title,n_datetime,lx_name,n_recomm"); //据取值完成
        }else{ //ID不为空时读取详细信息
            $this->_main_data=$TableName->where("n_id=$id")->order($sort." ". $order)->LIMIT($offset.','.$limit)->select(); //据取值完成
        }
        //exit($TableName->getLastSql()) ;
        if ($count==0){
            $this->_Msg='数据结果为0';
        }else{
            $this->_Msg='获取成功';
        }
    }

    //资讯信息编辑
    function NewsEdit($id){
        $config = C('up_file'); //读取上传文件配置
        $info_add_tb=M("info_tb");  //D方法获取表名
        //增加数据
        if ($id!=""){
            $where["n_id"]=array("eq",$id);
            $count=$info_add_tb->where($where)->count();
            $this->_dateil_data=$info_add_tb->where($where)->select();
        }
        if ($_POST) {
            $info_add_tb->n_lxid=I("n_lxid");
            $info_add_tb->n_title=I("n_title");
            $info_add_tb->n_keyword=I("n_keyword");
            $info_add_tb->n_author=I("n_author");
            $info_add_tb->n_datetime=date('Y-m-d H:i:s',time());
            $info_add_tb->n_note=I("n_note");
            $info_add_tb->info_laiyuan=I("n_note");
            $info_add_tb->n_content=$_POST["content"];
            //$info_add_tb->info_photonew=I("photo");
            $info_add_tb->n_recomm=I("n_recomm");
            if (!$id){
                $ret=$info_add_tb->add();
            }else{
                if ($count==1){
                    $ret=$info_add_tb->where($where)->save();
                }else{
                    $ret=0;
                }
            }
            $upload = new \Think\Upload($config);// 实例化上传类
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                //$this->error($upload->getError());
            }else{// 上传成功
                //$this->success('上传成功');
                $filetable=M("infofile_tb");
                foreach ($info as $file) {
                    //$this->assign("photo_add",$file['savepath'] . $file['savename']);
                    $filetable->info_id=$ret;
                    $filetable->photo=$file['savepath'] . $file['savename'];
                    $filetable->add();
                }
            }
            $this->_zt=$ret;
        }
    }
    //资讯分类信息编辑
    function NewsSortEdit($id,$name){
        $SortTable=M("infolx_tb");
        $SortTable->name=$name;
        if ($id==0){ //如果ID为0时新增数据
            $SortTable->sfyx=I("sfyx");
            $SortTable->sjid=0;
            $SortTable->jb=1;
            $ret=$SortTable->add();
            if ($ret>0){
                return true;
            }else{
                return false;
            }
        }else{ //有ID时编辑数据
            $where["id"]=array("eq",$id);
            $count=$SortTable->where($where)->count();
            if (!$count){ //如果读取数据失败或该ID值下数据为空，返回失败
                return false;
            }else{
                $ret=$SortTable->where($where)->save();
                if ($ret>0){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

}