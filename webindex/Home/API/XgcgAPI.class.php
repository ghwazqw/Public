<?php

namespace Home\API;

class XgcgAPI{
    public $tf_idf_list="";
    public $_dic="";
    public $_str="";
    public $_cg_data="";
    //取出字典
    function loaddic(){
        //字典路径
        $txt=file_get_contents("http://127.0.0.1:8080/Dict/CgInfo/lxdict.txt");
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
    function getWords($str,$dic){
        $this->_main_data=M("cgxxjc_tb")->where("cg_xmjj!=''")->order("cg_wcsj DESC")->LIMIT(1)->select();
        foreach($this->_main_data as $cg_xmmc){
            $str=$cg_xmmc["cg_xmjj"];
            //echo $str;
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
        $this->_main_data=M("gjc_tb")->where("info_lx=2 and info_rlx=1")->order("id DESC")->LIMIT(5)->select();
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
        var_export($files) ;

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

        $dic=$this->loaddic();
        $str=$this->getWords();
        $words=$this->getWords($str,$dic);
        $words_tf=$this->getTF($words);

        $words_idf=$this->getIDF($words,"pro");

        $tf_idf=0;
        foreach($words_tf as $k=>$v){
            $tf_idf+=$words_tf[$k]*$words_idf[$k];
        }

        echo "TF值：";

        var_export($words_tf);
        echo "<br />IDF值：";
        var_export($words_idf);
        //var_export($words);
        echo "<br />综合指标：";
        echo $tf_idf."<br />关键字列表：";
        var_export($words);

    }




}