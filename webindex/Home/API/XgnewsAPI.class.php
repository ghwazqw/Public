<?php

namespace Home\API;

class XgnewsAPI{
    public $tf_idf_list="";
    public $_dic="";
    public $_str="";
    public $_cg_data="";
    public $_TF="";
    public $_IDF="";
    public $_TF_IDF="";
    public $_act="";
    //取出字典
    function loaddic(){
        //字典路径
        $txt=file_get_contents("http://127.0.0.1:8080/Dict/NewsInfo/lxdict.txt");
        if (!$txt){
            echo "File Error";
            return false;
        }
        else{
            //$this->_dic=explode(PHP_EOL,$txt);
            //var_export($this->_dic);
        return explode(PHP_EOL,$txt);
        }
    }
    //获取字符串
    function getWords($str,$dic,$where){
        $id=I("id");
        if ($id==""){
        $this->_main_data=M("info_tb")->where("info_type in (1,2)")->order("info_id DESC")->LIMIT(1)->select();
        }
        else{
        $where['info_id']  = array('eq',$id);
            //echo("$id");
        $this->_main_data=M("info_tb")->where($where)->order("info_id DESC")->LIMIT(1)->select();
        }
        foreach($this->_main_data as $cg_xmmc){
            $str=$cg_xmmc["info_content"];
            //echo $str."<br />";
            if ($str==""){
                echo "取值错误";
                return false;
            }
            else{
            //echo $cg_xmmc["cg_cgmc"]."<br />";
            }
        }
        $result=array();
        for($i=0;$i<mb_strlen($str,"utf-8");$i++){
            for($j=2;$j<=6;$j++){
                if (($j+$i)>mb_strlen($str,"utf-8")) break;
                $txt=mb_substr($str,$i,$j,"utf-8");
                //echo $txt."<br />";
                if(in_array($txt,$dic)){  //如在字典中存在，则取到关键词
                    //$result[]=$txt;
                    if (array_key_exists($txt,$result)){
                        $result[$txt]=$result[$txt]+1; //累加
                    }
                    else
                        $result[$txt]=1;
                }

            }
        }
        return $result;
        return $txt;
    }
    //计算TF值
    function getTF($result){
        $allcount=count($result);
        foreach ($result as $k=>$v){
            $newresult[$k]=$v/$allcount;
        }
        return $newresult;
    }
    //计算IDF值
    function getIDF($result,$path="http://127.0.0.1:8080/pro"){
        /*//获取样板文件内容
        for ($i=1;$i<=2;$i++){
            $files[]=file_get_contents($path."/".$i.".txt"); //读取出样本文件
        }*/
        //获取数据库内容
        $act=I("act");
        if ($act==2){
        $this->_main_data=M("info_tb")->where("info_type=2")->order("info_id DESC")->LIMIT(5)->select();
        }
        else{
        $this->_main_data=M("info_tb")->where("info_type=1")->order("info_id DESC")->LIMIT(5)->select();
        }
        foreach($this->_main_data as $cg_xmmc){
            $files[]=$cg_xmmc["info_content"];
            //echo $str;
            if ($files==""){
                echo "取值错误";
                return false;
            }
            else{
                //echo $cg_xmmc["cg_cgmc"]."<br />";
            }
        }
        //var_export($files) ;

        foreach($result as $k=>$v){
            $c=0;
            foreach($files as $file){
                if(strpos($file,$k)){  //代表关键字在文件中出现
                    $c++;
                }
            }
            if ($c==0){
                $newresult[$k]=0; //代表无权重
            }
            else{
                $newresult[$k]=log((5+1)/$c,10);
            }
        }
        return $newresult; //返回IDF值

    }
    function list_info(){
        $act=I("act");
        if ($act!=""){
        $dic=$this->loaddic();
        $str=$this->getWords();
        $words=$this->getWords($str,$dic);
        $words_tf=$this->getTF($words);

        $words_idf=$this->getIDF($words,"pro");

        $tf_idf=0;
        foreach($words_tf as $k=>$v){
            $tf_idf+=$words_tf[$k]*$words_idf[$k];
        }

        //插入分析结果库
        $info_add_tb=D("info_anal_tb");
        $edit_id=I("id");
        //$info_edit_tb=D("info_tb")->where("info_id=.$edit_id")->limit(1);
            //统计数据增加
        $info_add_tb->info_id=I("id");
        $info_add_tb->info_type=$act;
        $info_add_tb->info_count=$tf_idf;
        //$info_add_tb->info_tf=$words_tf;
        //$info_add_tb->info_gjc=$words;
        $info_add_tb->add();
            //更新新闻信息
       /* $info_edit_tb->info_anal_type=$act;
        $info_edit_tb->info_count=$tf_idf;
        $info_edit_tb->save();*/

        $this->_TF=$words_tf;
        $this->_IDF=$words_idf;
        $this->_TF_IDF=$tf_idf;
        $this->_act=$act;
        //echo "TF值：";
        //var_export($words_tf);
        //echo "<br />IDF值：";
        //var_export($words_idf);
        //var_export($words);
        //echo "<br />综合指标：";
        //echo $tf_idf."<br />关键字列表：";
        //var_export($words);
        }

    }




}