<?php

namespace Home\API;


class ActivitiesAPI
{
    //public $_page_size = "1000"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    public $_main_data = array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $actionInfo = ""; //返回要执行的动作
    public $_Msg = "";
    public $_zt = 0;

    //增加报名信息
    function EditActInfo()
    {
        $user = new UserAPI();
        $userinfo = $user->getuser();
        if (!$userinfo->user_name) {
            $username = 0;
        } else {
            $username = $userinfo->user_name;
        }
        //增加信息
        $AddData = M("activities_tb");  //注意去除前缀
        if (!$AddData->autoCheckToken($_POST)) {
            // 令牌验证错误
            return false;
        } else {
            $AddData->name = I("name"); //姓名
            $AddData->emailtel = I("email"); //郵箱/電話
            $AddData->company = I("company"); //公司名稱
            $AddData->message = I("message"); //其他信息
            $AddData->actdate = date('Y-m-d H:i:s', time()); //提交時間
            $AddData->isuser = $username; //是否會員
            $AddData->activitiesid = I("activitiesid"); //參與活動信息
            $AddData->address = I("address"); //參會地址
            $AddData->zhicheng = I("zhicheng"); //職稱
            $AddData->mobile = I("mobile");
            $ret = $AddData->add();
            if ($ret) {
                $this->SendQrInfo(I("email"),$ret);
                return true;
            } else {
                return false;
            }
        }
    }

    //發送資費成功郵件
    function SendJfInfo($email, $id)
    {
        $content = "<h3>完成報名!我們已收到您繳費資料，課程前二天會再發郵件提醒上課。</h3>";
        $content .= "<p style='font-size: 14px;line:25px;line-height: 25px'>祝：貴公司業績龍騰虎躍!<br />如有問題歡迎撥打02-26082656，陳助理</p>";
        if (SendMail($email, '課程資費成功提醒郵件', $content)) {
            $this->UpJfStatus($id,1,1,"");
            return true;
        } else {
            return false;
        }
    }

    //報名確認郵件
    function SendQrInfo($email, $id)
    {
        $ret = M("actry_vm")->where("id=$id")->order("id desc")->select();
        foreach ($ret as $info) {
            $content = '<h3>報名成功!我們已經收到您回覆表單，請您完成繳費手續，繳費單可通過郵件發回或線上繳費，我司好安排行政作業。謝謝您的配合!</h3>';
            $content .= "<p style='font-size: 14px;line-height: 25px'>課程主題：" . $info["co_title"] . "<br />";
            if ($info["address"] == "台北") {
                $content .= "課程日期：" . $info["co_date"] . "<br/>";
            } elseif ($info["address"] == "台中") {
                $content .= "課程日期：" . $info["co_date2"] . "<br/>";
            } elseif ($info["address"] == "高雄") {
                $content .= "課程日期：" . $info["co_date3"] . "<br/>";
            }
            $content .= '課程時間：' . $info["co_sktime"] . "<br />";
            $content .= '課程地點：您的上課地點為'.$info["address"].'<br />';
            $content .= '繳費方式: 電匯 國泰世華銀行連城分行  帳號 128-03-500565-6  帳戶: 網天下移動科技有限公司';
            $content .= '</p>';
        }

        $content .= "<p style='font-size: 14px;line:25px;line-height: 25px'>祝您順心圓滿!<br />如有問題歡迎撥打02-26082656，陳助理</p>";
        if (SendMail($email, '網天下科技溫馨提醒', $content)) {
            $this->UpJfStatus($id,1,1,1);
            return true;
        } else {
            return false;
        }
    }
    //發送提醒郵件
    function SendTfInfo($email, $id)
    {
        $ret = M("actry_vm")->where("id=$id")->order("id desc")->select();
        foreach ($ret as $info) {
            $content = '<h3>' . $info["company"] . '公司,' . $info["name"] . '君，您好!</h3>';
            $content .= "<p style='font-size: 14px;line-height: 25px'>課程主題：" . $info["co_title"] . "<br />";
            if ($info["address"] == "台北") {
                $content .= "課程日期：" . $info["co_date"] . "<br/>";
            } elseif ($info["address"] == "台中") {
                $content .= "課程日期：" . $info["co_date2"] . "<br/>";
            } elseif ($info["address"] == "高雄") {
                $content .= "課程日期：" . $info["co_date3"] . "<br/>";
            }
            $content .= '課程時間：' . $info["co_sktime"] . "<br />";
            $content .= '課程地點：您的上課地點為'.$info["address"].'<br />台北班 : 台北市中正區青島西路7號9樓 (近台北火車站)女青年會<br />
台中班 : 台中市西屯區臺灣大道三段658號3樓 (近中港交流道)Rich19中國文化大學推廣部<br />
高雄班 : 高雄班前金區中正四路215號3樓 (華國世貿金融中心大樓)文化大學推廣中心';
            $content .= '</p>';
        }

        $content .= "<p style='font-size: 14px;line:25px;line-height: 25px'>請開課前15分鐘前入場!<br />期待當日與您相會!<br />如有問題歡迎撥打02-26082656，陳助理</p>";
        if (SendMail($email, '網天下科技溫馨提醒', $content)) {
            $this->UpJfStatus($id,1,1,1);
            return true;
        } else {
            return false;
        }
    }

    //更新資費狀態
    function UpJfStatus($id, $mst, $actst,$txst)
    {
        $Table = M("activities_tb");
        $where["id"] = array("eq", $id);
        $Table->moneystatus = $mst;
        $Table->actstatus = $actst;
        if ($txst!=""){
            $Table->txstatus = $txst;
        }
        $ret = $Table->where($where)->save();
        if ($ret) {
            return true;
        } else {
            return false;
        }
    }
}	
