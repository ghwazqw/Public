<?php
namespace Home\Controller;
use Home\API\XgnewsAPI;
use Think\Controller;
use Home\API\NewstestAPI;
use Think\Model;

class NewstestController extends Controller {
   public function news_list(){

      $get_info_type=I("get.type",1,"/^\d+$/");
       $ii=new NewstestAPI();
       $ii->loadmatedata();
       $this->assign("main_data",$ii->_main_data);
       $this->assign("dal_data",$ii->_dateil_data);
       $this->assign("pagebar",$ii->_page_bar);
       $this->assign("count",$ii->_page_count);    //统计数据
       $this->assign("keyword",$ii->_keyword);

       if ($_GET)
       {
           $io=new NewstestAPI();
           $io->del_info();
           if ($io->actionInfo!=""){
               eval($io->actionInfo);
           }
       }

       $this->theme("manage")->display();
   }
    public function news_add(){
        //读取信息分类，给前端选择框赋值
        $ii=new NewstestAPI();
        $ii->loadlxdata();
        $this->assign("lx_data",$ii->_lxdata);

        if ($_POST)
        {
            $a = new NewstestAPI();
            $a->add_info();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }
        $this->theme("manage")->display();
    }
    public function news_edit(){
        $ii=new NewstestAPI();
        $ii->news_dal();
        $this->assign("meta_data",$ii->_meta_data);
        $this->assign("dateil_data",$ii->_dateil_data);
        $io=new NewstestAPI();
        $io->loadlxdata();
        $this->assign("lx_data",$io->_lxdata);
        if ($_POST){
            $a = new NewstestAPI();
            $a->edit_info();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }

        $this->theme("manage")->display();
    }
    public function news_dal(){
        $ii=new NewstestAPI();
        $ii->news_dal();
        $this->assign("meta_data",$ii->_meta_data);
        //$this->assign("id",$ii->_meta_data["info_id"]);
        $this->assign("web_manage_title","信息管理系统 | 资讯信息管理 | 详细资讯信息");
        $this->assign("dateil_data",$ii->_dateil_data);
        $this->assign("info_cilck",$ii->_cilck+$ii->_data_cilck); //输出redis点击量值
        $this->assign("data_cilck",$ii->_data_cilck); //输出数据库中点击量值
        $io=new XgnewsAPI();
        $io->list_info();
        $this->assign("tf_idf",$io->_TF_IDF);
        $this->assign("id_act",$io->_act);



        //var_export($ii);

        $this->theme("manage")->display();
    }
    public function fileupload(){

        $config = C('uploadfile');
        var_export($config);
        if ($_POST){
            $upload = new \Think\Upload($config);// 实例化上传类
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
                //$this->success('上传成功！');
                foreach ($info as $file) {
                    $this->assign("photo_add",$file['savepath'] . $file['savename']);
                }
            }
        }
        $this->theme("manage")->display();
    }

}
