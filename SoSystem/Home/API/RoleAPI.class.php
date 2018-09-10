<?php
namespace Home\API;
use Home\Lib\PasswordHash;

class RoleAPI
{
	public $_page_size="40"; //每页显示条数
	public $_page_bar=""; //分布组件需要展示的内容
	public $_page_count=""; //统计数量
	public $_main_data=array(); //主表数据
	public $_dateil_data=array();  //子表数据
	public $_keyword=""; //
	public $_class_data="";
	public $_class_meta_data="";
	public $_xmbh="";
	public $actionInfo=""; //返回要执行的动作
	public $_oper_data=""; //读取平台操作信息

	/*查询信息*/
	function loadmatedata(){
		$this->_keyword=I("keyword1");

		$where['role_name']  = array('like',"%$this->_keyword%"); //成果名称
        $mmmap['_complex']=$where;
        $mmmap['role_sfyx']=array('eq',1);
        $mmmap['_logic']='AND';
		//加载主表数据
		$this->_page_count=$count=M("qx_role_tb")->where($mmmap)->order("id DESC")->count();
		$Page = new \Think\Page($count,$this->_page_size);

		$this->_page_bar=$Page->show(); //把分布内容赋值给变量
		$this->_main_data=$ret=M("qx_role_tb")->where($mmmap)->order("id DESC")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //主表数据取值完成
		//echo M("qx_role_tb")->getLastSql();
	}
	/*编辑信息*/
	function AddRole(){
		$data=D("qx_role_tb");
		$data->role_name=I("role_name");
		$data->role_note=I("role_note");
		$data->role_id=I("id");
		$data->role_sfyx=I("role_sfyx");
        if ($_POST){
            $data->add();
            $this->actionInfo='{$this->assign("sussInfo","增加成功！");}';
        }

	}
	function EditRole(){
        $where['id'] = array('eq', I("id"));
        $data=D("qx_role_tb");
        $data->role_name=I("role_name");
        $data->role_note=I("role_note");
        $data->role_sfyx=I("role_sfyx");
        $data->role_id=I("id");
        $data->where($where)->save();
        $this->_info="OK";
    }
	/*导出Excel信息*/
	function expExcel($where){
		$this->_keyword=I("keyword");
		if ($this->_keyword!=""){
			$where['role_name']  = array('like',"%$this->_keyword%"); //角色名称
		}
		$m = M ('qx_role_tb');
		// $datas['order_p_name'] = $p_name;
		$data = $m->where($where)->order("id DESC")->select();
		foreach ($data as $k => $v)
		{
			$data[$k]['id']=$v['id'];
		}
		//var_export($data);
		//exit;
		//用vendor导入PHPExcel类库
		vendor("PHPExcel.PHPExcel");
		$filename="角色信息表";
		$headArr=array("ID","角色名称","角色说明","是否有效");
		$getExcel=new ExcelAPI();
		$getExcel->getExcel($filename,$headArr,$data);
	}
	function operation($where){  //列表功能
		$where['oper_lx']=array('eq',1);
		$this->_page_count=$count=M("pt_operation_tb")->where($where)->order("oper_pX")->count();
		$Page = new \Think\Page($count,$this->_page_size);
		$this->_page_bar=$Page->show(); //把分布内容赋值给变量
		$this->_oper_data=$ret=M("pt_operation_tb")->where($where)->order("oper_pX")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //操作信息取值完成
	}
	function D_oper($where){  //列表功能
		$where['oper_lx']=array('eq',2);
		$this->_page_count=$count=M("pt_operation_tb")->where($where)->order("oper_pX")->count();
		$Page = new \Think\Page($count,$this->_page_size);
		$this->_page_bar=$Page->show(); //把分布内容赋值给变量
		$this->_oper_data=$ret=M("pt_operation_tb")->where($where)->order("oper_pX")->LIMIT($Page->firstRow.','.$Page->listRows)->select(); //操作信息取值完成
	}
	//角色对应菜单信息
    function RoleMenu($where){
	    $id=I("id");
	    if (!$id){
	        echo "Id Error";
	        exit();
        }
        //读取角色信息下的菜音列表ID
        $RoleMenuTable=M("qx_rolemenu_tb");
        $where['Rolid']=array('eq',$id);
        $this->_main_data=$ret=$RoleMenuTable->where($where)->select(); //以数组方式取值
        //echo $RoleMenuTable->_sql();
        //var_export($ret);
        foreach ($ret as $Menuid){
            $rolemenu=$Menuid["rolemenu"];  //取值成功
        }
        if ($rolemenu!=''){
        //读取菜单信息
        $MenuTable=M("qx_menu_tb");
        $key['id']=array('in',$rolemenu);
        $this->_page_count=$MenuTable->where($key)->count();
        $this->_main_data=$MenuTable->where($key)->select(); //菜单取值完成
        //echo $MenuTable->_sql();
        //var_export($this->_main_data);
        }
    }


	
}	
