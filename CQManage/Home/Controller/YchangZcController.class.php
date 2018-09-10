<?php
namespace Home\Controller;

use Home\API\ZcManageAPI;
use Think\Controller;
class YchangZcController extends Controller {
    //更新资产净值信息
    public function UpdateZcjz(){
        $ii=new ZcManageAPI();
        $ii->JzJsUpdate();
    }
    //更新资产维修总费用
    public function WxlJsUpdate(){
        G('begin');
        $ii=new ZcManageAPI();
        //$ii->WxlJsUpdate();
        //$ii->WxldqUpdate();
        //$ii->WxlqtUpdate();
        $ii->WxlysUpdate();
        G('end');
        echo "本页面执行共使用了".G('begin','end').'秒';
    }
}
