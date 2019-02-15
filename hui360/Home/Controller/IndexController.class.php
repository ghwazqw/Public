<?php

namespace Home\Controller;


use Home\API\ActionAPI;
use Home\API\ActivitiesAPI;
use Home\API\AppdataAPI;
use Home\API\CourseAPI;
use Home\API\NewsAPI;
use Home\API\SendMail;


class IndexController extends PublicController
{


    public function index()
    {
        $ii = new AppdataAPI();
        $ii->ServerInfo();
        $this->assign("sysconfig", $ii->_server_info);
        $sysinfo = C("SysConfig");
        $this->assign("sysinfo", $sysinfo);
        //var_dump($sysinfo);
        $this->assign("title", "首頁");
        $this->theme("web")->display();
    }

    public function About()
    {
        $this->assign("title", "關於我們");
        $this->theme("web")->display();
    }

    public function Aboutcase()
    {
        $id = I("id");
        //检查传入参数是否完整
        $ii = new ActionAPI();
        $ii->ChId($id);
        $io = new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData", $io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title", "關於我們");
        $this->theme("web")->display();
    }

    public function Liquidation()
    {
        $id = I("id");
        //检查传入参数是否完整
        $ii = new ActionAPI();
        $ii->ChId($id);
        $io = new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData", $io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title", "存量變現");
        $this->theme("web")->display();
    }

    public function service()
    {
        $id = I("html");
        //检查传入参数是否完整
        $ii = new ActionAPI();
        $ii->ChId($id);
        $io = new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData", $io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title", "易物平臺");
        $this->theme("web")->display();
    }

    public function Entrepreneur()
    {
        $id = I("html");
        //检查传入参数是否完整
        $ii = new ActionAPI();
        $ii->ChId($id);
        $io = new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData", $io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title", "專業家專區");
        $this->theme("web")->display();
    }

    public function Course()
    {
        $id = I("id");
        /*if (!$id){
            echo "id error";
            exit();
        }*/
        $io = new CourseAPI();
        $io->pt_course_tbmatedata($id);
        $this->assign("InfoData", $io->_main_data);
        // var_export($io->_main_data);
        $this->assign("title", "匯360--公開班");
        $this->theme("web")->display();
    }

    public function CourseDal()
    {
        $id = I("id");
        $iid = "";
        if (!$id) {
            echo "id error";
            exit();
        }
        $io = new CourseAPI();
        $io->pt_course_tbmatedata($id);
        $this->assign("InfoData", $io->_main_data);
        $ii = new CourseAPI();
        $ii->pt_course_tbmatedata($iid);
        $this->assign("listData", $ii->_main_data);
        // var_export($io->_main_data);
        $this->assign("title", "課程詳細信息");
        $this->theme("web")->display();
    }

    public function training()
    {
        $id = I("html");
        //检查传入参数是否完整
        $ii = new ActionAPI();
        $ii->ChId($id);
        $io = new NewsAPI();
        $io->NewsInfo($id);
        $this->assign("InfoData", $io->_main_data);
        //var_export($io->_main_data);
        $this->assign("title", "內部培訓");
        $this->theme("web")->display();
    }

    public function application()
    {
        $id = I("id");
        $type = "活動課程";
        //检查传入参数是否完整
        $ii = new ActionAPI();
        $ii->ChId($id);
        $io = new CourseAPI();
        $io->pt_course_tbmatedata($id);
        $getUrl = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        $this->assign("InfoData", $io->_main_data);
        $this->assign("geturl", $getUrl);
        //var_export($io->_main_data);
        $this->assign("title", "在線報名");
        $this->theme("web")->display();
    }

    public function Editapplic()
    {
        $id=I("activitiesid");
        $sendname = I("name");
        $sendconpany = I("company");

        $emailtel = I("email"); //郵箱/電話
        $company = I("company"); //公司名稱
        $message = I("message"); //其他信息
        $actdate = date('Y-m-d H:i:s', time()); //提交時間
        $address = I("address"); //參會地址
        $zhicheng = I("zhicheng"); //職稱
        $mobile = I("mobile");
        $ii = new ActivitiesAPI();
        if ($ii->EditActInfo()) {
            $title=$sendname."報名信息";
            $content = "<h3>$sendname";
            $content .= "於" . $actdate;
            $content .= "報名參加";

            $io = new CourseAPI();
            $io->pt_course_tbmatedata($id);
            $ret=$io->_main_data;
            foreach ($ret as $info) {
                $content .= $info["co_title"] . "</h3>";
                $content .= "上課地點為：";
                $content .= $address . "<br />";
                if ($address == "台北") {
                    $content .= "上課時間為：" . $info["co_date"] . "<br/>";
                } elseif ($address == "台中") {
                    $content .= "上課時間為：" . $info["co_date2"] . "<br/>";
                } elseif ($address == "高雄") {
                    $content .= "上課時間為：" . $info["co_date3"] . "<br/>";
                }
            }
            $content .= "公司名稱：" . $company . "<br />";
            $content .= "報名郵箱：" . $emailtel . "<br />";
            $content .= "職稱：" . $zhicheng . "<br />";
            $content .= "移動電話：" . $mobile . "<br />";
            $content .= "其他要求：" . $message . "<br />";
            if (SendMail('net2ccservice@gmail.com', $title,$content)){
                $this->success('報名成功，我們將儘快聯係您，確認後續事宜。','/');
            }else{
                $this->success('報名成功E，我們將儘快聯係您，確認後續事宜。','/');
            }

        } else {
            $this->success('報名失敗，請重試。');
        }

    }
}
