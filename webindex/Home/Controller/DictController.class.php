<?php
namespace Home\Controller;
use Home\API\XgnewsAPI;
use Think\Controller;
use Think\Model;

class DictController extends Controller {

    public function dict(){
        $ii=new XgnewsAPI();
        $ii->list_info();
        /*$io=new XgcgAPI();
        $io->getWords();*/
        //$this->assign("tf_idf",$ii->tf_idf_list);
        //$this->assi
        $this->theme("dict")->display();
    }
}
