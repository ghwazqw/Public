<?php
namespace Home\Controller;
use Home\API\BdCentAPI;
use Home\API\FromAPI;
use Home\API\HdxxAPI;
use Home\API\QregAPI;
use Home\API\WxchatAPI;
use Home\API\YwzxManageAPI;
use Think\Controller;
use Home\API\UserAPI;
use Home\API\QyzxAPI;
class QuserController extends PublicController {
    public function user_reg(){
        if ($_POST){
            $a=new QregAPI();
            $action=I("action");
            if ($action==1){
                $a->ch_user();
            }
            elseif ($action==2){
                $a->ch_txtcode();
            }
            elseif ($action==3){
                $a->add_quser();
                if ($a->actionInfo!="")
                {
                    eval($a->actionInfo);
                }
            }
        }
    }
    public function tjrchk(){
        $ii=new UserAPI();
        $ii->TjrCh();
    }

    public function Edit_userinfo(){
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $this->getUserInfo();
        $this->assign("Duser_info",$ii->_dateil_data);
        if ($_POST){
            $ii=new UserAPI();
            $ii->EditUserInfo();
            if ($ii->actionInfo!="")
            {
                eval($ii->actionInfo);
            }

        }
        $this->assign("title","|用户信息编辑");
        $this->theme("Webapps")->display();
    }
    public function sq_core(){
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $this->assign("InfoData",$ii->_dateil_data);
        $this->assign("title","|用户中心|申请报单中心");
        $ii=new QregAPI();
        $ii->loadcatdata();
        $this->assign("catData",$ii->_main_data);
        $this->assign("count",$ii->_count);
        $this->assign("sdje",$ii->_sdje);
        foreach ($ii->_main_data as $info){
            $catzt=$info["cat_zt"];
        }
        if ($catzt!=1){
            $this->error('帐户未激活不可操作!','/home/Quser/user_cent',3);
            exit();
        }
        $this->theme("Webapps")->display();
    }
    public function getUserInfo(){
        /*$ii=new UserAPI();
        $ii->Sjuserinfo();
        echo "ok";*/
    }
    public function Edit_userP(){

        if ($_POST){
            $ii=new UserAPI();
            $ii->EditUserPassWord();
            if ($ii->_info==2){
                $this->error('旧密码输入错误!');
            }elseif ($ii->_info==0){
                $this->error('编辑失败!');
            }elseif ($ii->_info==1){
                $this->success("密码信息编辑成功");
            }

        }else{
            $ii=new UserAPI();
            $ii->EditUserPassWord();
            $this->assign("Duser_info",$ii->_dateil_data);
            $this->assign("title","|用户密码修改");
            $this->theme("Webapps")->display();
        }

    }
    public function Edit_userguestbook(){

        if ($_POST){
            $ii=new UserAPI();
            $ii->Editguestbook();
            if ($ii->actionInfo!="")
            {
                eval($ii->actionInfo);
            }

        }
        $this->assign("title","|用户中心|平台反馈");
        $this->theme("web")->display();
    }
    public function login(){

        if ($_POST)
        {
            $a = new UserAPI();
            $a -> login();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }
        else
        {
            $ii=new WxchatAPI();
            $ii->select_appid();
            $this->assign("appid",$ii->_wxapp_id);
        }
        $this->assign("title","|用户登录");
		//echo "系统正在维护，请等待。。。给您带来的不便敬请谅解";
        $this->theme("Webapps")->display();
    }

    public function user_cent(){
        //var_export($this->_dateil_data);
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $this->assign("InfoData",$ii->_dateil_data);
        $this->assign("title","|用户中心");
        $ic=new UserAPI();
        $ic->FtUserInfo();
        //echo $ic->_ft;
        //$this->assign("ftinfo",$ic->_ft);
        if ($ic->_ftzt==1){
            $ic->Ftinfo();
        }
       /* $ii->QuserFt();
        $this->assign("ft",$ii->_ft);
        $this->assign("zsy",$ii->_zsy);
        $this->assign("ztx",$ii->_ztx);*/
		//echo "系统正在维护，请等待。。。给您带来的不便敬请谅解";
            $this->theme("Webapps")->display("core");

    }
    public function xq_list(){
        $a= new QyzxAPI();
        $a->djzx_yw();

        $this->assign("info_data",$a->_main1_data);
        $this->assign("title","|用户中心");

        $this->theme("web")->display();

    }
    public function detail(){
        $a= new QyzxAPI();
        $a->djxz_detail();
        $this->assign("meta_data",$a->_meta_data);
        $this->assign("detail_data",$a->_dateil_data);
        $this->assign("main_data",$a->_main_date);
        $this->theme("web")->display();
    }
    public function user_ok(){

        $this->theme("WebApps")->display("regsuc");
    }
    public function hybm(){
        $a=new HdxxAPI();
        $a->loadhybmdata();
        $this->assign("Hdxx",$a->_dateil_data);
        $this->assign("Userdata",$a->_user_info);
        $this->assign("count",$a->_page_count);
        $this->assign("Bmxx",$a->_bm_info);
        $this->assign("Chrxx",$a->_chr_info);
        $this->assign("title","|用户中心|会议回执信息填写");
        $this->theme("web")->display("");
    }
    public function ChryAdd(){
        $a=new HdxxAPI();
        $a->AddHzxx();
    }
    public function ChrAdd(){
        $a=new HdxxAPI();
        $a->AddChr();
    }
    public function Forgot_Password(){
        if ($_POST){
            $ii=new UserAPI();
            $ii->CheckEmail();
        }
        else{
            $this->theme("web")->display("");
        }
    }
    public function Forgot_Pass(){
        $this->theme("web")->display("");
    }
    public function my_order(){
        $ii=new QregAPI();
        $ii->myorder();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("Info",$ii->_dal_data);
        //var_export($ii->_main_data);
        //var_export($ii->_dal_data);
        $this->theme("web")->display("");
    }

    public function rePass(){
        if ($_POST){
            $a=new UserAPI();
            $a->editpass();

        }else{
            $h=I("h");
            if (!$h){
                echo "非法操作";
                exit();
            }else{
                $ii=new UserAPI();
                $ii->reSetPass();
                $this->assign("id",$ii->_keyword);
                echo $ii->pass;
            }
            /*if ($ii->pass=="ok"){*/
            $this->theme("web")->display("");
            /*}
            else{
            	echo "密码重置时间已过，请<a href='/home/Quser/Forgot_Password.html'>重新操作</a>";
            	exit();
            }*/
        }
    }
    //推荐码生成
    public function tjdoce(){
        $ii=new QregAPI();
        $code=I("code");
        $id=I("id");
        $ii->GetRandStr($code);
        $table=M("qx_user_tb");
        $table->user_tjm=$ii->_sjm;
        $table->where("id=$id")->save();
        echo $ii->_sjm;
    }
    //编辑交易信息
    public function EditJy(){
        $jy=C("Jyconfig");
        $this->assign("jyje",$jy['Jyje']);
        if ($_POST){
            $ii=new QregAPI();
            $ii->AddNewBd();
            if (!$ii->_jyinfo){
                $this->error('交易失败，即将返回用户中心!','/home/Quser/user_cent',1);
            }else{
                $this->success('交易成功，正在跳转！','/home/Quser/user_cent',1);
            }
        }else{
            $ii=new UserAPI();
            $ii->EditUserInfo();
            $userinfo=$ii->_dateil_data;
            //var_export($userinfo);
            foreach ($userinfo as $user){
                //echo $user['user_tjr'];
                if (!$user['user_tjm'] || !$user['user_tjr'] || $user['user_lx']==2){
                    //exit("推荐人信息不全，无法交易!");
                    $this->error('用户未激活，不可进行交易!','/home/Quser/user_cent',2);
                }
            }
            $io=new QregAPI();
            $io->loadJydata();
            $this->assign("count",$io->_page_count);
            //echo $io->_page_count;
            $this->assign("Duser_info",$ii->_dateil_data);
			//echo "系统正在维护，请等待。。。给您带来的不便敬请谅解";
            $this->theme("Webapps")->display("Edit_Jy");
        }
    }
    public function tjinfo(){
        $jy=C("Jyconfig");
        $this->assign("jyje",$jy['Jyje']);
        if ($_POST){
            $ii=new QregAPI();
            $ii->AddNewJy();

        }
    }
    //交易流水查询
    public function jylist(){
        $ii=new QregAPI();
        $ii->loadsydata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $userinfo=$ii->_dateil_data;
        //var_export($userinfo);
        foreach ($userinfo as $user){
            //echo $user['user_tjr'];
            if (!$user['user_tjm'] || !$user['user_tjr'] || $user['user_lx']==2){
                //exit("推荐人信息不全，无法交易!");
                $this->error('帐户未激活，不可操作!','/home/Quser/user_cent',2);
                exit();
            }
        }
		//echo "系统正在维护，请等待。。。给您带来的不便敬请谅解";
        $this->theme("Webapps")->display("jy_list");
    }
    //现金帐户查询
    public function xjcat_list(){
        //关闭该功能
        $this->error('非法操作!');
        exit();
        $it=new UserAPI();
        $it->loaduserinfo();
        if ($it->_zt==0){
            $this->error('必须设置提现密码，现在将转入设置页面!','/home/Quser/user_cent',3);
            exit();
        }
        $ic=new UserAPI();
        $ic->FtUserInfo();
        //echo $ic->_ft;
        $this->assign("ftinfo",$ic->_ft);
        $ib=new UserAPI();
        $ib->TxInfo();
        //echo $ib->_zt;
        if ($ib->_zt==0){
            $this->assign("txlog",0);
        }else{
            $this->assign("txlog",1);
        }
        $ii=new QregAPI();
        $ii->loadcatdata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("count",$ii->_count);
        $this->assign("sdje",$ii->_sdje);
        foreach ($ii->_main_data as $info){
            $catzt=$info["cat_zt"];
        }
        if ($catzt!=1){
            $this->error('该帐户未激活不可操作!','/home/Quser/user_cent',3);
            exit();
        }
        //var_export($ii->_main_data);
        $jy=C("Jyconfig");
        $this->assign("sxf",$jy['Sxf']*100);
        //echo $jy['Sxf'];
        /*$ii=new UserAPI();
        $ii->QuserFt();
        $this->assign("ft",$ii->_ft);
        $this->assign("zsy",$ii->_zsy);
        $this->assign("ztx",$ii->_ztx);*/
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $userinfo=$ii->_dateil_data;
        //var_export($userinfo);
        foreach ($userinfo as $user){
            //echo $user['user_tjr'];
            if (!$user['user_tjm'] || !$user['user_tjr'] || $user['user_lx']==2){
                //exit("推荐人信息不全，无法交易!");
                $this->error('帐户未激活，不可操作!','/home/Quser/user_cent',2);
                exit();
            }
        }
        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii->week($now_time);
        $this->assign("week",$ii->_lx);
        $this->assign("day",$now_time);

            $this->theme("Webapps")->display("");
    }
    //积分转币帐户查询
    public function xjbdbcat_list(){
        $it=new UserAPI();
        $it->loaduserinfo();
        if ($it->_zt==0){
            $this->error('必须设置提现密码，现在将转入设置页面!','/home/Quser/user_cent',3);
            exit();
        }
        $ic=new UserAPI();
        $ic->FtUserInfo();
        //echo $ic->_ft;
        $this->assign("ftinfo",$ic->_ft);
        $ib=new UserAPI();
        $ib->TxInfo();
        //echo $ib->_zt;
        if ($ib->_zt==0){
            $this->assign("txlog",0);
        }else{
            $this->assign("txlog",1);
        }
        $ii=new QregAPI();
        $ii->loadcatdata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("count",$ii->_count);
        $this->assign("sdje",$ii->_sdje);
        foreach ($ii->_main_data as $info){
            $catzt=$info["cat_zt"];
        }
        if ($catzt!=1){
            $this->error('该帐户未激活不可操作!','/home/Quser/user_cent',3);
            exit();
        }
        //var_export($ii->_main_data);
        $jy=C("Jyconfig");
        $this->assign("sxf",$jy['Sxf']*100);
        //echo $jy['Sxf'];
        /*$ii=new UserAPI();
        $ii->QuserFt();
        $this->assign("ft",$ii->_ft);
        $this->assign("zsy",$ii->_zsy);
        $this->assign("ztx",$ii->_ztx);*/
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $userinfo=$ii->_dateil_data;
        //var_export($userinfo);
        foreach ($userinfo as $user){
            //echo $user['user_tjr'];
            if (!$user['user_tjm'] || !$user['user_tjr'] || $user['user_lx']==2){
                //exit("推荐人信息不全，无法交易!");
                $this->error('帐户未激活，不可操作!','/home/Quser/user_cent',2);
                exit();
            }
        }
        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii->week($now_time);
        $this->assign("week",$ii->_lx);
        $this->assign("day",$now_time);

        $this->theme("Webapps")->display("");
    }
    public function shopcat_list(){
        $ii=new QregAPI();
        $ii->loadjfinfo();
        $now_time = date('Y-m-d',time());
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("count",$ii->_count);
        $this->assign("sdje",$ii->_sdje);
        $this->assign("day",$now_time);
        foreach ($ii->_main_data as $info){
            $catzt=$info["cat_zt"];
        }
        if ($catzt!=1){
            $this->error('该帐户未激活，请至少提现或转帐成功一次!','/home/Quser/user_cent',3);
            exit();
        }
        $this->theme("Webapps")->display("");
    }
    //我的团队
    public function My_group(){
        //var_export($ii->_main_data);

        $this->assign("title","|用户中心");
        $this->theme("Webapps")->display("");
    }
    //异步加载我的团队
    public function group(){
        $io=new UserAPI();
        $io->QuserGinfo();
        $this->assign("InfoData",$io->_main_data);
        $this->assign("count",$io->_page_count);
    }
    //我的报单信息
    public function Bd_list(){
        $ii=new QregAPI();
        $ii->loadQbdinfo();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("txrq",$ii->_txrq);
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $userinfo=$ii->_dateil_data;
        //var_export($userinfo);
        foreach ($userinfo as $user){
            //echo $user['user_tjr'];
            if (!$user['user_tjm'] || !$user['user_tjr'] || $user['user_lx']==2){
                //exit("推荐人信息不全，无法交易!");
                $this->error('帐户未激活，不可操作!','/home/Quser/user_cent',2);
                exit();
            }
        }
		//echo "系统正在维护，请等待。。。给您带来的不便敬请谅解";
        $this->theme("Webapps")->display("");
    }
    public function Txsub(){
        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii->week($now_time);
        if ($ii->_lx==0){
            $this->error('当前时间不可进行提现，请在工作时间进行该操作！','/home/Quser/xjcat_list',1);
            exit();
        }
        $ib=new UserAPI();
        $ib->TxInfo();
        echo $ib->_zt;
        if ($ib->_zt==0){
            $this->error('非法操作！','/home/Quser/xjcat_list',1);
            exit();
        }
        $ii=new QregAPI();
        $ii->TxSubInfo();
        if ($ii->_ret>0){
            $this->success('申请提交成功，我们尽快审核，请耐心等待！','/home/Quser/xjcat_list',1);
        }else{
            $this->error('由于某些原因申请提交失败，请重试！','/home/Quser/xjcat_list',1);
        }
    }
    //转报单币
    public function bdbzcsub(){
        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii=new QregAPI();
        $ii->BdbZcNew();
        if ($ii->_ret>0){
            $this->success('提交成功！','/home/Quser/xjbdbcat_list',1);
        }else{
            $this->success('提交成功！','/home/Quser/xjbdbcat_list',1);
            //$this->error('由于某些原因申请提交失败，请重试！','/home/Quser/xjbdbcat_list',1);
        }
    }
    //报单积分转报单币
    public function bdbjfsub(){
        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii=new QregAPI();
        $ii->Bdjfbdb();
        if ($ii->_ret>0){
            $this->success('提交成功！','/home/Quser/jfbcat_list',1);
        }else{
            $this->success('提交成功！','/home/Quser/jfbcat_list',1);
            //$this->error('由于某些原因申请提交失败，请重试！','/home/Quser/xjbdbcat_list',1);
        }
    }
    //积分提现申请
    public function JfTxsub(){
        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii->week($now_time);
        if ($ii->_lx==0){
            $this->error('当前时间不可进行提现，请在工作时间进行该操作！','/home/Quser/jfcat_list',1);
            exit();
        }
        $ib=new UserAPI();
        $ib->TxInfo();
        echo $ib->_zt;
        if ($ib->_zt==0){
            $this->error('非法操作！','/home/Quser/jfcat_list',1);
            exit();
        }
        $ii=new QregAPI();
        $ii->JfTxSubInfo();
        if ($ii->_ret>0){
            $this->success('申请提交成功，我们尽快审核，请耐心等待！','/home/Quser/jfcat_list',1);
        }else{
            $this->error('由于某些原因申请提交失败，请重试！','/home/Quser/jfcat_list',1);
        }
    }
    public function tx_list(){
        $ii=new QregAPI();
        $ii->loadTxmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $userinfo=$ii->_dateil_data;
        //var_export($userinfo);
        foreach ($userinfo as $user){
            //echo $user['user_tjr'];
            if (!$user['user_tjm'] || !$user['user_tjr'] || $user['user_lx']==2){
                //exit("推荐人信息不全，无法交易!");
                $this->error('帐户未激活，不可操作!','/home/Quser/user_cent',2);
                exit();
            }
        }
        $this->theme("Webapps")->display("");
    }
    public function dbinfo(){
        $table=M("qx_user_tb");
        $where["user_lx"]=array("eq",3);
        $where["user_jb"]=array("neq",0);
        $where["user_regdate"]=array("BETWEEN",'2018-05-27,2018-05-28');
        //$where["user_regdate"]=array("GT",'2018-04-22 00:00:00');
        $ret=$table->where($where)->order("id")->select();
        //var_export($ret);


        $this->assign("info",$ret);
        $this->theme("Webapps")->display("");
    }
    public function dbinfo1(){
        $table=M("qx_user_tb");
        $where["user_lx"]=array("eq",3);
        $where["user_jb"]=array("neq",0);
        $where["user_regdate"]=array("BETWEEN",'2018-05-28,2018-05-29');
        //$where["user_regdate"]=array("GT",'2018-04-22 00:00:00');
        $ret=$table->where($where)->order("id")->select();
        //var_export($ret);


        $this->assign("info",$ret);
        $this->theme("Webapps")->display("dbinfo");
    }

    public function Addbd(){
        $ii=new QregAPI();
        $ii->AddNewBd();
    }
    public function catlist(){
        $where["cat_type"]=array("eq",1);
        $where["cat_dqje"]=array("neq",0);
        $ret=M("usercat_tb")->where($where)->order()->select();
        //echo M("usercat_tb")->_sql();
        foreach ($ret as $info){

            $mapp["syr_name"]=array("eq",$info["cat_username"]);
            //$mapp["syr_day"]=array("eq",'2018-04-16');
            //$mapp["syr_name"]=array("IN","myl1314");
            /*$mapp["syr_name"]=array("neq","gyj6688");
            $mapp["syr_name"]=array("neq","hwc777");
            $mapp["syr_name"]=array("neq","shw1314");
            $mapp["syr_name"]=array("neq","ch777");
            $mapp["syr_name"]=array("neq","llr777");
            $mapp["syr_name"]=array("neq","lm123456");
            $mapp["syr_name"]=array("neq","yqh6688");
            $mapp["syr_name"]=array("neq","jsf123456");
            $mapp["syr_name"]=array("neq","bzf6688");*/
            //$mapp["syr_name"]=array("neq","hwc777");
            $sum=M("syinfo_tb")->where($mapp)->sum('syr_gxje');
            //echo M("syinfo_tb")->_sql();
            $catmoney=$info["cat_dqje"];
                $dyje=$sum-100000;
                $ktxje=$catmoney-$dyje;
                if ($ktxje<0){
                    $ktxje=0;
                }
                if ($sum>100000){
                    echo $info["cat_username"]."总收益：".$sum."当前帐户余额：".$catmoney."可提现金额：".$ktxje."<br />";
                }
            //echo $info["cat_username"]."收益总额：".$sum."<br />";
        }
    }
    public function user_khinfo(){
        $username=I("username");
        if (!$username){
            echo "no";
            exit();
        }
        $where['user_name']=array("eq",$username);
        $userret=M("qx_user_tb")->where($where)->limit(1)->select();
        //var_export($userret);
        $this->ajaxReturn($userret,'JSON');
    }
    public function usersych(){
        set_time_limit(0);
    $jybdtable=M("jybd_tb");
    $jywhere["jy_sj"]=array("GT",'2018-04-22 00:00:00');
    //$jywhere["jy_sj"]=array("LT",'2018-04-23 00:00:00');
    $jyinfo=$jybdtable->where($jywhere)->select();
    //echo $jybdtable->_sql();
    //exit();
        //var_export($jyinfo);
        //exit();
    foreach ($jyinfo as $jyxx){
        //echo $jyxx['user_name']."<br />";
        $rettable=M("syinfo_tb");
        $where["syr_gxrname"]=array("eq",$jyxx['user_name']);
        $ret=$rettable->where($where)->select();
        foreach ($ret as $info){
            $mapp["cat_username"]=array("eq",$info["syr_name"]);
            $mapp["cat_type"]=array("eq",1);
            $mtable=M("usercat_tb");
            $cattable=$mtable->where($mapp)->select();
            foreach ($cattable as $catin){
                $catje=$catin['cat_dqje']-$info['syr_gxje'];
                $mtable->cat_dqje=$catje;
                $mtable->where($mapp)->save();
                //echo $mtable->_sql();
                echo $catin['cat_username'].": ".$catin['cat_dqje']."<br />";
            }
            //echo $catje."<br />";
            //echo $info["syr_name"]."<br />";
        }
    }
}
    public function usergsych(){

            //echo $jyxx['user_name']."<br />";
            $rettable=M("syinfo_tb");
            $where["syr_gxrname"]=array("eq",'liqi1234');
            $ret=$rettable->where($where)->select();
            foreach ($ret as $info){
                $mapp["cat_username"]=array("eq",$info["syr_name"]);
                $mapp["cat_type"]=array("eq",1);
                $mtable=M("usercat_tb");
                $cattable=$mtable->where($mapp)->select();
                foreach ($cattable as $catin){
                    $catje=$catin['cat_dqje']-$info['syr_gxje'];
                    $mtable->cat_dqje=$catje;
                    $mtable->where($mapp)->save();
                    echo $mtable->_sql();
                    echo $catin['cat_dqje']."<br />";
                }
                //echo $catje."<br />";
                //echo $info["syr_name"]."<br />";
            }
    }
    public function usercat(){
        $rettable=M("usercat_tb");
        $retwhere["cat_type"]=array("eq",1);
        $retwhere["cat_dqje"]=array("<",0);
        $ret=$rettable->where($retwhere)->select();
    }
    public function Edit_txpassword(){
        if ($_POST){
            $ii=new UserAPI();
            $ii->SetTxPass();
            if ($ii->_zt==1){
                $this->success('设置成功，将转入用户中心!','/home/Quser/user_cent',2);
            }else{
                $this->error('设置失败!');
            }
                //$this->success('设置成功，将转入用户中心!','/home/Quser/user_cent',2);
        }else{
            $this->theme("Webapps")->display("");
        }
    }
    public function bdcent(){
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $this->assign("InfoData",$ii->_dateil_data);
        $this->assign("title","|我的报单中心");
        $ii->BdUserInfo();
        /*if ($ii->_zt==0){
            $this->error('该帐户不是报单中心用户，不可操作!','/home/Quser/user_cent',2);
            exit();
        }*/
        $ii->LoadBdcentInfo();
        $this->assign("BdInfo",$ii->_main_data);

        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii->week($now_time);
        $this->assign("week",$ii->_lx);
        $this->assign("day",$now_time);

        $this->theme("Webapps")->display("");
    }
    //报单币提现
    public function BdbTx(){
        if ($_POST){
            $ktxje=I("ktxje");
            $zrje=I("zrje");
            if ($zrje>$ktxje){
                $this->error('非法操作！');
            }
            $io=new UserAPI();
            $io->SunBdCent(2,1);
            if ($io->_zt>0){
                $this->success('报单币提现申请提交成功，请等待审核！','/home/Quser/bdcent',1);
            }else{
                $this->error('申请失败，请重试！','/home/Quser/bdcent',1);
            }
        }
    }
    //转帐
    public function Bdbzz(){
        $ktxje=I("ktxje");
        $zrje=I("zrje");
        if ($zrje>$ktxje){
            $this->error('非法操作！');
        }else{
            //echo "ok";
            $io=new UserAPI();
            $io->SunBdCent(3,100);
            if ($io->_zt>0){
                $this->success('转帐成功！','/home/Quser/bdcent',2);
            }else{
                $this->error('转帐失败，请重试！','/home/Quser/bdcent',2);
            }
        }
        //echo $ktxje."<br />";
        //echo $zrje;
    }
    //报单申请
    public function bdsq(){
        if ($_POST){
            if (!I("user_name")){
                $this->error('非法操作!','/home/Quser/bdsq',1);
                exit();
            }
            //提交报单
            /*$myinfo=new BdCentAPI();
            $myinfo->Myinfo();
            if ($myinfo->_jyzt==1){ //为开市线用户的判断
                //读取直接上线为分郭用户
                $Fxusertjm=$myinfo->_tjr;
                $Fxinfo=new BdCentAPI();
                $Fxinfo->FxUserInfo($Fxusertjm);
                $Fxname=$Fxinfo->_gxrname; //分享人用户名
                $Fxtjr=$Fxinfo->_gxrtjr; //分享人推荐码
                $Fxid=$Fxinfo->_gxrid;
                $Fxtype=$Fxinfo->_gxrtype;
                //读取第一个收款人信息
                $zjskinfo=new BdCentAPI();
                $zjskinfo->SkrUserInfo($Fxid,1);
                $zjsyname=$zjskinfo->_syrname;
                $zjsyxm=$zjskinfo->_syrxm;
                $jjskrtjm=$zjskinfo->_gxrtjr;
                //直接收益人帐户进帐
                $zjsy=new BdCentAPI();
                $zjsy->ZjSkrSk($Fxtype,$zjsyname,$zjsyxm,$Fxname);
                echo $jjskrtjm;


            }elseif ($myinfo->_jyzt==2){//为分享线用户的判断
                //开市用户不进行分享

            }*/
            $ii=new QregAPI();
            $ii->AddNewBd();

            if (!$ii->_jyinfo){
                $this->error('交易失败，即将返回报单中心!','/home/Quser/bdsq',1);
            }else{
                $this->success('交易成功，正在跳转！','/home/Quser/bdsq',1);
            }

        }else{
            $ii=new UserAPI();
            $ii->EditUserInfo();
            $this->assign("InfoData",$ii->_dateil_data);
            $this->assign("title","|报单中心");
            $ii->BdUserInfo();
            if ($ii->_zt==0){
                $this->error('该帐户不是报单中心用户，不可操作!','/home/Quser/user_cent',2);
                exit();
            }
            $ii->LoadBdcentInfo();
            $this->assign("BdInfo",$ii->_main_data);
            $ic=new UserAPI();
            $ic->LoadWbdRyinfo();
            $this->assign("info_data",$ic->_main_data);
            $jy=C("Jyconfig");
            $this->assign("jyje",$jy['Jyje']);
            $io=new UserAPI();
            $io->loadBdryinfo();
            if ($io->_ft==0 || !$io->_ft){
                $this->assign("dqje",0);
            }else{
                $this->assign("dqje",$io->_ft);
            }
            $this->theme("Webapps")->display("");
        }


        //var_export($ic->_main_data);

    }
    /*//报单人员列表
    public function bdry(){
        $usertable=M("qx_user_tb");
        $ret=$usertable->order("id desc")->select();
        //echo M("qx_user_tb")->_sql();
        foreach ($ret as $in){
            $name=$in["user_name"];
            $where["user_name"]=array("eq",$name);
            $getusername=M("jybd_tb")->where($where)->getField("user_name");
            if ($getusername!=$name){
                $usertable->bd_zt=0;
                $usertable->where($where)->save();
                echo $name."<br />";
            }else{
                $usertable->bd_zt=1;
                $usertable->where($where)->save();
            }
        }
    }*/
    //退单操作
    public function tdact(){

        $retwhere["jy_sj"]=array("BETWEEN",'2018-06-01,2018-06-05');

        $rett=M("jybd_tb")->where($retwhere)->order("id desc")->select();

        foreach ($rett as $info){
            $bdr=$info["user_name"];
            $userinfowhere["user_name"]=array("eq",$bdr);
            $usertjr=M("qx_user_tb")->where($userinfowhere)->getField("user_tjr");
            $gxrwhere["user_tjm"]=array("eq",$usertjr);
            $gxr=M("qx_user_tb")->where($gxrwhere)->getField("user_name");
            echo $bdr.":";
            echo $gxr."<br />";
            //读取退单信息
            $sytable=M("syinfo_tb");
            $where["syr_gxrname"]=array("eq",$gxr);
            $ret=$sytable->where($where)->order("id desc")->select();
            //echo $sytable->_sql();
            foreach ($ret as $info){
                $cattable=M("usercat_tb");
                $catwhere["cat_username"]=array("eq",$info["syr_name"]);
                $catwhere["cat_type"]=array("eq",1);
                $catret=$cattable->where($catwhere)->getField("cat_dqje");
                $cattable->cat_dqje=$catret-$info["syr_name"];
                $cattable->where($catwhere)->save();
            }
            //核减公司帐户
            $cattable=M("usercat_tb");
            $catwhere1["cat_type"]=array("eq",3);
            $catret=$cattable->where($catwhere1)->getField("cat_dqje");
            $cattable->cat_dqje=$catret-1000;
            $cattable->where($catwhere1)->save();
            //删除报单信息
            $bdtable=M("jybd_tb");
            $bdwhere["user_name"]=array("eq",$bdr);
            $bdtable->where($bdwhere)->delete();
            //删除报单记录
            $sytable->where($where)->delete();
        }
    }

    //退单操作
    public function td1act(){

            $bdr="wjy141319";
            //exit($bdr);
        //修正报单中心帐户
        $bdlogtable=M("bdcent_log_tb");
        $bdlogwhere["jt_dx"]=array("eq",$bdr);
        //$bdlogret=$bdlogtable->where($bdlogwhere)->select();
        $getbdusername=$bdlogtable->where($bdlogwhere)->getField("user_name");
        //var_export($bdlogret);
        //echo $getbdusername;
        $bdcenttable=M("bdcent_tb");
        $bdinfowhere["user_name"]=array("eq",$getbdusername);
        $dqje=$bdcenttable->where($bdinfowhere)->getField("dqje");
        echo $getbdusername.":".$dqje."<br />";
        $bdcenttable->dqje=$dqje+1000;
        $bdcenttable->where($bdinfowhere)->save();

        //修正报单中心收益
        $cattable=M("usercat_tb");
        $centwhere["cat_username"]=array("eq",$getbdusername);
        $centwhere["cat_type"]=array("eq",10);
        /*$ret=$cattable->where($centwhere)->select();
        var_export($ret);*/
        $catdqje=$cattable->where($centwhere)->getField("cat_dqje");

        $cattable->cat_dqje=$catdqje-30;
        $cattable->where($centwhere)->save;

        /*//增加公司帐户30元
        $cattable=M("usercat_tb");
        $catwhere2["cat_type"]=array("eq",3);
        $catret=$cattable->where($catwhere2)->getField("cat_dqje");
        $cattable->cat_dqje=$catret+30;
        $cattable->where($catwhere2)->save();*/
        //exit();


        $userinfowhere["user_name"]=array("eq",$bdr);
            $usertjr=M("qx_user_tb")->where($userinfowhere)->getField("user_tjr");
            $gxrwhere["user_tjm"]=array("eq",$usertjr);
            $gxr=M("qx_user_tb")->where($gxrwhere)->getField("user_name");
            echo $bdr.":";
            echo $gxr."<br />";
            //读取退单信息
            $sytable=M("syinfo_tb");
            $where["syr_gxrname"]=array("eq",$gxr);
            $ret=$sytable->where($where)->order("id desc")->select();
            //echo $sytable->_sql();
            foreach ($ret as $info){
                $cattable=M("usercat_tb");
                $catwhere["cat_username"]=array("eq",$info["syr_name"]);
                $catwhere["cat_type"]=array("eq",1);
                $catret=$cattable->where($catwhere)->getField("cat_dqje");
                $cattable->cat_dqje=$catret-$info["syr_name"];
                $cattable->where($catwhere)->save();
            }
            //删除收益信息
            $sytable->where($where)->delete();
            //修正贡献人帐户
            $cattable=M("usercat_tb");
            $gxrwhere["cat_username"]=array("eq",$gxr);
            $gxrwhere["cat_type"]=array("eq",2);
            $cattable->cat_dqje=10000;
            $cattable->where($gxrwhere)->save();


            //核减公司帐户
            $cattable=M("usercat_tb");
            $catwhere1["cat_type"]=array("eq",3);
            $catret=$cattable->where($catwhere1)->getField("cat_dqje");
            $cattable->cat_dqje=$catret-970;
            $cattable->where($catwhere1)->save();
            //删除报单信息
            $bdtable=M("jybd_tb");
            $bdwhere["user_name"]=array("eq",$bdr);
            $bdtable->where($bdwhere)->delete();

            //删除报单人帐户信息
            $cattable=M("usercat_tb");
            $bdrwhere["cat_username"]=array("eq",$bdr);
            $cattable->where($bdrwhere)->delete();
            //删除报单人信息
            M("qx_user_tb")->where($userinfowhere)->delete();
    }
    //读取所有报单信息
    function bdlist(){
        $rett=M("jybd_tb")->select();
        foreach ($rett as $info){
            $username=$info["user_name"];
            echo $username.",";
        }
    }
    //报单员信息列表
    function bdylist(){
        $ii=new QregAPI();
        $ii->bdcentlog(10);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        //$this->assign("keyword",$ii->_keyword);
        $this->theme("Webapps")->display("bdy_list");
    }
    //报单积分日志查询
    function bdjflist(){
        $ii=new QregAPI();
        $ii->bdcentlog(11);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        //$this->assign("keyword",$ii->_keyword);
        $this->theme("Webapps")->display("bdjf_list");
    }
    //报单币转出日志查询
    function zzzc_list(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;

        $ii=new UserAPI();
        $ii->LoadUserZzInfo($get_UserName);

        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据

        $this->theme("Webapps")->display("");
    }
    //报单币转入日志查询
    function zzzr_list(){
        $user_info = $_COOKIE['user_info'];
        $globar_user = unserialize($user_info);
        $get_UserName = $globar_user->user_name;

        $ii=new UserAPI();
        $ii->LoadUserZrInfo($get_UserName);

        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据

        $this->theme("Webapps")->display("");
    }
    //报单帐户查询
    public function jfcat_list(){
        $it=new UserAPI();
        $it->loaduserinfo();
        if ($it->_zt==0){
            $this->error('必须设置提现密码，现在将转入设置页面!','/home/Quser/user_cent',3);
            exit();
        }
        $ib=new UserAPI();
        $ib->TxInfo();
        //echo $ib->_zt;
        if ($ib->_zt==0){
            $this->assign("txlog",0);
        }else{
            $this->assign("txlog",1);
        }
        $ii=new QregAPI();
        $ii->loadjfcatdata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("count",$ii->_count);
        $this->assign("sdje",$ii->_sdje);
        foreach ($ii->_main_data as $info){
            $catzt=$info["cat_zt"];
        }
        if ($catzt!=1){
            $this->error('该帐户未激活不可操作!','/home/Quser/user_cent',3);
            exit();
        }
        //var_export($ii->_main_data);
        $jy=C("Jyconfig");
        $this->assign("sxf",$jy['Sxf']*100);
        //echo $jy['Sxf'];
        /*$ii=new UserAPI();
        $ii->QuserFt();
        $this->assign("ft",$ii->_ft);
        $this->assign("zsy",$ii->_zsy);
        $this->assign("ztx",$ii->_ztx);*/
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $userinfo=$ii->_dateil_data;
        //var_export($userinfo);
        foreach ($userinfo as $user){
            //echo $user['user_tjr'];
            if (!$user['user_tjm'] || !$user['user_tjr'] || $user['user_lx']==2){
                //exit("推荐人信息不全，无法交易!");
                $this->error('帐户未激活，不可操作!','/home/Quser/user_cent',2);
                exit();
            }
        }
        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii->week($now_time);
        $this->assign("week",$ii->_lx);
        $this->assign("day",$now_time);

        $this->theme("Webapps")->display("");
    }
    //报单积分转报单币帐户查询
    public function jfbcat_list(){
        $it=new UserAPI();
        $it->loaduserinfo();
        if ($it->_zt==0){
            $this->error('必须设置提现密码，现在将转入设置页面!','/home/Quser/user_cent',3);
            exit();
        }
        $ib=new UserAPI();
        $ib->TxInfo();
        //echo $ib->_zt;
        if ($ib->_zt==0){
            $this->assign("txlog",0);
        }else{
            $this->assign("txlog",1);
        }
        $ii=new QregAPI();
        $ii->loadjfcatdata();
        $this->assign("InfoData",$ii->_main_data);
        $this->assign("count",$ii->_count);
        $this->assign("sdje",$ii->_sdje);
        foreach ($ii->_main_data as $info){
            $catzt=$info["cat_zt"];
        }
        if ($catzt!=1){
            $this->error('该帐户未激活不可操作!','/home/Quser/user_cent',3);
            exit();
        }
        //var_export($ii->_main_data);
        $jy=C("Jyconfig");
        $this->assign("sxf",$jy['Sxf']*100);
        //echo $jy['Sxf'];
        /*$ii=new UserAPI();
        $ii->QuserFt();
        $this->assign("ft",$ii->_ft);
        $this->assign("zsy",$ii->_zsy);
        $this->assign("ztx",$ii->_ztx);*/
        $ii=new UserAPI();
        $ii->EditUserInfo();
        $userinfo=$ii->_dateil_data;
        //var_export($userinfo);
        foreach ($userinfo as $user){
            //echo $user['user_tjr'];
            if (!$user['user_tjm'] || !$user['user_tjr'] || $user['user_lx']==2){
                //exit("推荐人信息不全，无法交易!");
                $this->error('帐户未激活，不可操作!','/home/Quser/user_cent',2);
                exit();
            }
        }
        $ii=new FromAPI();
        $now_time = date('Y-m-d',time());
        $ii->week($now_time);
        $this->assign("week",$ii->_lx);
        $this->assign("day",$now_time);

        $this->theme("Webapps")->display("");
    }
}
