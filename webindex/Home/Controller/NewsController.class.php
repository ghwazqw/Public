<?php
namespace Home\Controller;
use Think\Controller;
use Home\API\NewstestAPI;
use Think\Model;

class NewsController extends Controller {
   public function news_list(){

      $get_info_type=I("get.type",1,"/^\d+$/");
       $ii=new NewstestAPI();
       $ii->loadmatedata();
       $this->assign("main_data",$ii->_main_data);
       $this->assign("dal_data",$ii->_dateil_data);
       $this->assign("pagebar",$ii->_page_bar);

       $this->theme("glxh")->display();
   }

    public function news_dal(){
        $ii=new NewstestAPI();
        $ii->news_dal();
        $this->assign("meta_data",$ii->_meta_data);
        $this->assign("count",$ii->_page_count);
        $this->assign("file_data",$ii->_file_data); //附件信息上传
        $this->assign("info_cilck",$ii->_cilck+$ii->_data_cilck); //输出redis点击量值
        $this->assign("data_cilck",$ii->_data_cilck); //输出数据库中点击量值
        $NewInfo=$ii->_meta_data[0];
        $this->assign("title","中国公路科技成果转化平台|新闻资讯|".$NewInfo['info_title']);
        $this->assign("keywords","科技成果,转化,科技,平台,中国公路科技成果转化平台,新闻资讯,".$NewInfo['info_title']);
        $this->assign("Description",$NewInfo['info_note']);
        $this->theme("glxh")->display();
    }
    public function news_z_list(){

        $get_info_type=I("get.type",1,"/^\d+$/");
        $ii=new NewstestAPI();
        $ii->loadmatedata();
        $this->assign("main_data",$ii->_main_data);
        $this->assign("dal_data",$ii->_dateil_data);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("type",$ii->_type);
        if ($ii->_type!=1 && $ii->_type!=2){
            echo "Illegal to attempt a file lock in a transaction after taking prior record locks.";
            return false;
        }

        $this->theme("glxh")->display();
    }
    public function fund_dal(){
        $ii=new NewstestAPI();
        $ii->news_dal();
        $this->assign("meta_data",$ii->_meta_data);
        $this->assign("count",$ii->_page_count);
        $this->theme("glxh")->display();
    }

}
