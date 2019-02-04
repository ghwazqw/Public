<?php
namespace Home\Controller;


use Home\API\ActionAPI;
use Home\API\ActivitiesAPI;
use Home\API\AppdataAPI;
use Home\API\CourseAPI;
use Home\API\NewsAPI;


class IndexController extends PublicController {


    public function index(){
        $ii=new AppdataAPI();
        $ii->ServerInfo();
        $this->assign("sysconfig",$ii->_server_info);
        $sysinfo=C("SysConfig");
        $this->assign("sysinfo",$sysinfo);
        //var_dump($sysinfo);
           $this->assign("title","首頁");
           $this->theme("webApps")->display();
    }
    public function About(){
        $this->assign("title","關於我們");
        $this->theme("web")->display();
    }
    public function Aboutcase(){
        $id=I("id");
        //检查传入参数是否完整
        $ii=new ActionAPI();
        $ii->ChId($id);
        $io=new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData",$io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title","關於我們");
        $this->theme("web")->display();
    }
    public function Liquidation(){
        $id=I("id");
        //检查传入参数是否完整
        $ii=new ActionAPI();
        $ii->ChId($id);
        $io=new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData",$io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title","存量變現");
        $this->theme("web")->display();
    }
    public function service(){
        $id=I("html");
        //检查传入参数是否完整
        $ii=new ActionAPI();
        $ii->ChId($id);
        $io=new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData",$io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title","易物平臺");
        $this->theme("web")->display();
    }
    public function Entrepreneur(){
        $id=I("id");

        $io=new CourseAPI();
        $io->pt_course_tbmatedata($id);
        $this->assign("InfoData",$io->_main_data);
        var_export($io->_main_data);
        $this->assign("title","課程列表");
        $this->theme("web")->display();
    }
    public function training(){
        $id=I("html");
        //检查传入参数是否完整
        $ii=new ActionAPI();
        $ii->ChId($id);
        $io=new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData",$io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title","內部培訓");
        $this->theme("web")->display();
    }
    public function application(){
        $id=I("html");
        $type="活動課程";
        //检查传入参数是否完整
        $ii=new ActionAPI();
        $ii->ChId($id);
        $io=new NewsAPI();
        $io->applicationinfo($type);
        $this->assign("InfoData",$io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title","在線報名");
        $this->theme("web")->display();
    }
    public function Editapplic(){

            $ii=new ActivitiesAPI();
            if ($ii->EditActInfo()){
                $this->success('提交成功，我們將儘快聯係您，確認後續事宜。','/');
            }else{
                $this->success('報名失敗，請重試。');
            }

    }
}
