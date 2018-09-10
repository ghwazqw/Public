<?php
namespace Home\Controller;
use Think\Controller;
class GlxhController extends Controller {
    public function news(){
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
//      echo "中国公路学会";
//      echo "<br />";
        //echo $_GET["info"]." 信息";
        //echo I("get.info","没有").'信息';
        
       // $this->display("set");
       //$this->theme("30")->display();
//     $this->abc="test";
       //$arr["name"]="ghw";
       //$arr["age"]="18";
       //$this->assign($arr);
       $this->title = "新闻列表页 - dxydsoft.com";
       $this->theme("50")->display(newslist);
    }
    public function newsdetail(){
    $this->title="新闻详细页 - dxydsoft.com";
    $this->theme("50")->display();
    }

}
