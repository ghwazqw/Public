<?php
namespace Home\Controller;
use Home\API\DelDataAPI;
use Home\API\ExcelAPI;
use Home\API\QregAPI;
use Home\API\RoleAPI;
use Home\Lib\PasswordHash;
use Think\Controller;
use Home\API\UserAPI;
class UserController extends PublicController {
    public function adduser(){
        //增加用户
        if($_POST){
            $a=new UserAPI();
            $a->add_user();
            if ($a->actionInfo!="")
            {
                eval($a->actionInfo);
            }
        }
        $this->theme("manage")->display();
    }
	//增加用户用户
    public function Userredit(){
        $edit=new UserAPI();
        $edit->Userredit();
    }
    public function sqbdzx(){
        $ii=new UserAPI();
        $ii->Userbdzx(1);
    }
    public function qxbdzx(){
        $ii=new UserAPI();
        $ii->Userbdzx(0);
    }
    public function U_manage(){
        $ii=new UserAPI();
        $ii->loadmatedata(1);
        $this->assign("info_data",$ii->_main_data);
        //读取角色信息
        $io=new RoleAPI();
        $io->loadmatedata();
        $this->assign("RoleData",$io->_main_data);

        $this->theme("manage")->display("User_Manage");
    }

    //前端用户管理
    public function Q_manage(){
        $ii=new UserAPI();
        $ii->loadQuserdata(2);
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display("Quser_Manage");
    }
    //前端已激活用户管理
    public function Qr_manage(){
        $ii=new UserAPI();
        $ii->loadQuserdata(3);
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display("Qruser_Manage");
    }
    //服务人员帮忙报单
    public function Quser_bd(){
        if ($_POST){
            $ii=new QregAPI();
            $ii->AddJyInfo();
            if (!$ii->_jyinfo){
                $this->error('交易失败，即将返回用户中心!','/home/user/Quser_bd',1);
            }else{
                $this->success('交易成功，正在跳转！','/home/user/Quser_bd',1);
            }
        }else{
            $ii=new UserAPI();
            $ii->loadWbduserdata();
            $this->assign("info_data",$ii->_main_data);
            $jy=C("Jyconfig");
            $this->assign("jyje",$jy['Jyje']);
            $io=new UserAPI();
            $io->loadBdryinfo();
            //echo $io->_ft;
            if ($io->_ft==0 || !$io->_ft){
                $this->assign("dqje",0);
            }else{
                $this->assign("dqje",$io->_ft);
            }

            $this->theme("manage")->display();
        }

    }
    //读取前端用户信息
    public function getQuser(){
        $ii=new UserAPI();
        $ii->loadQuserMetadata();
        $this->ajaxReturn($ii->_main_data,'json');
    }
    //读取前端人员交易信息
    public function  getjyinfo(){
        $ii=new QregAPI();
        $ii->loadQjyinfodata();
        $count=$ii->_page_count;
        echo $count;
    }
    //读取报单中心人员相关信息
    public function getBdUser(){
        $ii=new UserAPI();
        $ii->BdCentInfo();
    }
    //读取前端人员交易信息列表
    public function  Quser_jyManage(){
        $ii=new QregAPI();
        $ii->loadQjyinfodata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //读取前端人员收易信息列表
    public function  Quser_syManage(){
        $ii=new QregAPI();
        $ii->loadQsydata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //读取前端人员信用信息列表
    public function  Quser_xyManage(){
        $ii=new QregAPI();
        $ii->loadQcatdata(2);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //读取前端人员现金帐户列表
    public function  Quser_xjManage(){
        $ii=new QregAPI();
        $ii->loadQcatdata(1);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //读取前端人员现金帐户列表
    public function  Quser_shopManage(){
        $ii=new QregAPI();
        $ii->loadQcatdata(4);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //读取公司现金帐户列表
    public function  Quser_gsManage(){
        $ii=new QregAPI();
        $ii->loadQcatdata(3);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //系统登录
    public function login(){
        if ($_POST){
            $a = new UserAPI();
            $a -> UserLogin();
            //exit();
            $info=$a->_info;
            if ($info!="OK"){
                $this->error("$info",'/?a=login&c=User',2);
            }else{
                $this->success('系统登录成功,正在跳转...','/home/index/manage',1);
            }
        }else{
            $this->theme("manage")->display("login_new");
        }
    }
    //验证验证码
    public function ChVer(){
        $ii=new UserAPI();
        $ii->VerCh();
    }
    public function role_manage(){
        $ii=new RoleAPI();
        $ii->loadmatedata();
        //读取表单数据
        $this->assign("info_data",$ii->_main_data);
        $this->assign("count",$ii->_page_count);
        $this->assign("pagebar",$ii->_page_bar);
        $this->assign("keyword",$ii->_keyword);
        $io=new RoleAPI();
        $io->operation();
        //读取操作数据
        $this->assign("oper_data",$io->_oper_data);
        $aa=new RoleAPI();
        $aa->D_oper();
        $this->assign("d_oper_data",$aa->_oper_data);
        //提交数据
        if ($_POST)
        {
            $a = new RoleAPI();
            $a->AddRole();
            $this->success('角色增加成功','/Home/User/role_manage',1);
        }else{
            $this->theme("manage")->display("");
        }
    }
    public function Delrole(){
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/Home/User/role_manage',1);
        }else{
            $this->error('信息删除失败','/Home/User/role_manage',1);
        }
    }
    public function EditRole(){
        $ii=new RoleAPI();
        $ii->EditRole();
        if ($ii->_info=="OK"){
            $this->success('信息编辑成功','/Home/User/role_manage',1);
        }else{
            $this->error('信息编辑失败','/Home/User/role_manage',1);
        }
    }
    public function expRole(){
        $ii=new RoleAPI();
        $ii->expExcel();
    }
    public function Ryuan_manage(){
        //增加信息
        if ($_POST){
            $a=new UserAPI();
            $a->AddRyxxData(); //调用增加信息实体类
        }
        //读取主表信息
        $ii=new UserAPI();
        $ii->loadRyuandata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->assign("zt",$ii->_zt);
        //读取角色信息
        $io=new RoleAPI();
        $io->loadmatedata();
        $this->assign("RoleData",$io->_main_data);
        //var_export($io->_main_data);

        //读取组织机构信息
        $id=I("id");
        if ($id!=""){
            $io=new UserAPI();
            $io->loadmetaclass();
            $this->ajaxReturn($io->_class_meta_data,'JSON');
        }
        else{
            $ii->loadcompdata();
            $this->assign("class_info",$ii->_class_data);
            $this->theme("manage")->display();
        }

    }
    function EditRyinfo(){
        $ii=new UserAPI();
        $ii->EditRyxxData();
        $this->success('人员信息更新成功','/home/user/ryuan_manage',1);
    }
    function getFirstCharter($str){
        if(empty($str)){return '';}
        $fchar=ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
        $s1=iconv('UTF-8','gb2312',$str);
        $s2=iconv('gb2312','UTF-8',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319&&$asc<=-20284) return 'A';
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return null;
    }
    public function RyPy(){
        $pystr=I("xm");
        echo $this->getFirstCharter($pystr);
    }
    //增加用户
    public function UserAdd(){
       $Add=new UserAPI();
       $Add->add_user();
    }
    //增加用户用户
    public function Useredit(){
        $edit=new UserAPI();
        $edit->Useredit();
    }
    //以json的形式获取用户信息
    public function UserInfo(){
        $ii=new UserAPI();
        $ii->loadmatedata();
        //$this->assign("info_data",$ii->_main_data);
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //删除用户信息
    function delinfo(){
        /*$clear=new UserAPI();
        $clear->ClearUser();*/
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/Home/user/u_manage',0);
        }else{
            $this->error('信息删除失败','/Home/user/u_manage',0);
        }
    }
    //删除前端用户信息
    function delqinfo(){
        /*$clear=new UserAPI();
        $clear->ClearUser();*/
        $ii=new DelDataAPI();
        $ii->DelInfo();
        if ($ii->_info=="OK"){
            $this->success('信息删除成功','/home/user/Q_manage',0);
        }else{
            $this->error('信息删除失败','/home/user/Q_manage',0);
        }
    }
    //重置密码
    function repass(){
        $re=new UserAPI();
        $re->RePass();
        if ($re->_info=="OK"){
            $this->success('密码重置成功，当前密码为：123456，请记录。','/Home/user/u_manage',3);
        }else{
            $this->error('信息删除失败','/Home/user/u_manage',0);
        }
    }
    //重置密码
    function reqpass(){
        $re=new UserAPI();
        $re->RePass();
        if ($re->_info=="OK"){
            $this->success('密码重置成功，当前密码为：123456，请记录。','/Home/user/u_manage',3);
        }else{
            $this->error('信息删除失败','/Home/user/u_manage',0);
        }
    }
    //无效/有效操作
    function sfyx(){
        $act=new UserAPI();
        $act->UserSfyx();
    }
    //前端无效/有效操作
    function Qsfyx(){
        $act=new UserAPI();
        $act->QuserSfyx();
    }
    //修改密码
    function Repassword(){
        if ($_POST){
            $a=new UserAPI();
            $a->EditUserPassWord();
            if ($a->_info==0){
                $this->error('原密码输入错误。','',1);
                exit();
            }elseif ($a->_info=1){
                $this->success('密码修改成功。','/Home/user/Repassword',1);
            }
        }else{
            $this->theme("manage")->display();
        }

    }
    //读取人员日志信息
    public function RyLog(){
        $ii=new UserAPI();
        $ii->RyLog();
        $this->ajaxReturn($ii->_main_data,'JSON');
    }
    //获取角色下属菜单信息
    public function RoleMenu(){
        $ii=new RoleAPI();
        $ii->RoleMenu();
        $count=$ii->_page_count;
        if ($count>0){
            $this->ajaxReturn($ii->_main_data,'JSON');
        }
    }
    public function UserInfoView(){
        $ii=new UserAPI();
        $ii->LoadUserMetainfo();
        $this->assign("UserInfo",$ii->_main_data);
        $this->assign("BdInfo",$ii->_MetaBdInfo);
        $this->assign("GxInfo",$ii->_MetaGxInfo);
        $this->assign("SyInfo",$ii->_MetaSyInfo);
        $this->assign("CatInfo",$ii->_MetaCatInfo);
        $this->theme("manage")->display();
    }
    public function Quser_txspManage(){
        $ii=new QregAPI();
        $ii->loadTxdata(5,0);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    public function Quser_bdbspManage(){
        $ii=new QregAPI();
        $ii->bdblist(1,2);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    public function txsp(){
        $ii=new QregAPI();
        $ii->TxSp();
        if ($ii->_ret>0){
            $this->success('审批完成！','/home/user/Quser_txspManage',1);
        }else{
            $this->error('审批失败，请重试！','/home/user/Quser_txspManage',1);
        }
    }
    //报单审批
    public function bdsp(){
        $ii=new QregAPI();
        $ii->BdSp();
        if ($ii->_ret>0){
            $this->success('审批完成！','/home/user/Quser_bdbspManage',1);
        }else{
            $this->error('审批失败，请重试！','/home/user/Quser_bdbspManage',1);
        }
    }
    public function Quser_bdbqrManage(){
        $ii=new QregAPI();
        $ii->bdblist(10,2);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    public function Quser_bdyspManage(){
        $ii=new QregAPI();
        $ii->loadTxdata(5,10);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }

    public function Quser_bdyqrManage(){
        $ii=new QregAPI();
        $ii->loadTxdata(10,10);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }

    public function Quser_txqrManage(){
        $ii=new QregAPI();
        $ii->loadTxdata(10,0);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    public function Quser_txManage(){
        $ii=new QregAPI();
        $ii->loadTxdata(100,0);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    public function Quser_bdyManage(){
        $ii=new QregAPI();
        $ii->loadTxdata(100,10);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    public function txqr(){
        $ii=new QregAPI();
        $ii->Txqr();
        if ($ii->_ret>0){
            $this->success('确认成功！','/home/user/Quser_txqrManage',1);
        }else{
            $this->error('确认失败，请重试！','/home/user/Quser_txqrManage',1);
        }
    }
    public function bdyqr(){
        $ii=new QregAPI();
        $ii->Bdyqr();
        if ($ii->_ret>0){
            $this->success('确认成功！','/home/user/Quser_bdyqrManage',1);
        }else{
            $this->error('确认失败，请重试！','/home/user/Quser_bdyqrManage',1);
        }
    }

    public function txcl(){
        $ii=new UserAPI();
        $logtable=M("usertxlog_tt");
        $where["tx_zt"]=array("eq",100);
        $where["tx_je"]=array("neq",0);
        $where["username"]=array("neq",'GS');
        //$where["username"]=array("eq",'tjc123');
        $ret=$logtable->where($where)->select();
        //echo $logtable->_sql();
        foreach ($ret as $info){
            $ii->txcl1($info["username"],10000);
        }
    }
    public function bdqr(){
        $ii=new QregAPI();
        $ii->Bdqr();
        if ($ii->_ret>0){
            $this->success('确认成功！','/home/user/Quser_bdbqrManage',1);
        }else{
            $this->error('确认失败，请重试！','/home/user/Quser_bdbqrManage',1);
        }
    }
    public function txView(){
        $ii=new QregAPI();
        $ii->loadtxinfodata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display("Quser_txView");
    }
    public function Qbd_cent(){
        $ii=new UserAPI();
        $ii->LoadBdUserdata(1);
        $this->assign("info_data",$ii->_main_data);
        if ($_POST){
            $io=new UserAPI();
            $io->SunBdCent(1,1);
            if ($io->_zt>0){
                $this->success('资金注入成功！','/home/user/Qbd_cent',1);
            }else{
                $this->error('资金注入失败，请重试！','/home/user/Qbd_cent',1);
            }
        }else{
            $this->theme("manage")->display("");
        }

    }
    //读取前端人员帐户信息列表
    public function  Quser_bdManage(){
        $ii=new UserAPI();
        $ii->loadbdmatedata();
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }

    //读取前端人员帐户信息列表
    public function  Quser_zjManage(){
        $ii=new UserAPI();
        $ii->loadbdzjmatedata(1);
        $this->assign("InfoData",$ii->_main_data); //主表数据
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //验证提现密码
    public function ChTxP(){
        $II=new UserAPI();
        $II->ChTxPwd();
    }
    //报单中心
    public function Quser_bdzxManage(){
        $ii=new UserAPI();
        $ii->loadQuserdata(3);
        $this->assign("info_data",$ii->_main_data);
        $this->assign("pagebar",$ii->_page_bar);    //分页组件
        $this->assign("count",$ii->_page_count);    //统计数据
        $this->assign("keyword",$ii->_keyword);
        $this->assign("page_count",$ii->_page_size);
        $this->theme("manage")->display();
    }
    //选择转帐人
    public function selectry(){
        $ii=new UserAPI();
        $ii->SelectRyInfo();
    }
    /*public function catinfoedit(){
        $str='zf1234,ldj1131,lsj8899,why8899,nl6789,lwg6688,wdc6789,lms6789,ll6789,wch6789,wc6789,cj6688,lzq6789,zbj6789,yxy6688,kwg123,hxl8899,lxw1314,lhl123,lhd6789,sgl6789,lq6789,sqj6789,jw1234,wjy1131,jfc123,klb141319,ptz141319,ldf141319,weg141319,ch1727,yzc1314,LQ1234,syl141319,tjc123,lr1234,ljz6688,myl6688,wss141319,gyj123,ww67892,dly6789,dl6789,lyh6789,dwp6789,sxw67892,wxh67892,xll6789,ycm6789,yfj6789,yxy6789,sxy6789,sxy6789';

        $userinfo=(explode(',',$str,-1));

        foreach ($userinfo as $info){
            $table=M("usercat_tb");
            $where["cat_username"]=array("eq",$info);
            $where["cat_type"]=array("eq",1);
            $dqje=$table->where($where)->getField("cat_dqje");
            //echo M("usercat_tb")->_sql()."<br />";
            $dqje=$dqje-10000;
            $table->cat_dqje=$dqje;
            $table->where($where)->save();
        }
    }*/
    //报单中心报单记录查询
    public function BdlogManage(){
        $this->theme("manage")->display();
    }
    //用户姓名读取
    public function getxm(){
        $username=$_POST["xm"];
        $ii=new UserAPI();
        $ii->GetUserXm($username);
    }
    //报单积分记录查询
    public function BdjfManage(){

        $this->theme("manage")->display();
    }
    //报单现金帐户查询
    public function BdxjManage(){
        $this->theme("manage")->display();
    }

}
