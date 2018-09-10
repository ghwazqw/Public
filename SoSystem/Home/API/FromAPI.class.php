<?php
namespace Home\API;

class FromAPI
{
	public $_CommentName="";
	public $_TableNmae="";
	public $_List_input_list="";
	public $_lx="";
	function Act_from($table_name){
		//$table_name="zc_cq_qx_user_tb";
		$table_name=I("table");
		//echo $table_name;
		if (!$table_name){
			//echo "table error";
		}
		else{
		$Model = M();
		$this->_CommentName=$ret=$Model->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name' and column_comment!='' and column_comment not like '%0'");
		//echo $Model->_sql();
		//var_export($this->_CommentName);
		$this->_TableNmae=$table_name;
		}
	}
	function List_table(){
		$Model = M();
		$this->_TableNmae=$ret=$Model->query("select * from information_schema.tables where table_schema='nanbt'and table_name not like 'zc_cq_pt%' ");
	}
	function page_table(){
		$Model = M();
		$this->_TableNmae=$ret=$Model->query("select * from information_schema.tables where table_schema='nanbt'and table_name not like 'zc_cq_pt%' ");
	}

	function list_input($comment){
		$comment="资产类型|zc_lx";
		$comment=explode("|",$comment);
		$this->_List_input_list=$comment[0];
		//echo $comment[0];

	}
	function Page_from($table_name){

		$table_name=I("table");
		if (!$table_name){
			//echo "table error";
		}
		else{
			$Model = M();
			$this->_CommentName=$ret=$Model->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name' and column_comment!='' ");
			//echo $Model->_sql();
			//var_export($this->_CommentName);
			$this->_TableNmae=$table_name;
		}
	}
	/*判断是否为周末*/
	function week($str){
        if((date('w',strtotime($str))==6) || (date('w',strtotime($str)) == 0)){
        //if( (date('w',strtotime($str)) == 0)){
            //echo '你输入的日期是周末';
            $this->_lx=0;
        }else{
            //echo '当然也不是周末了';
            $checkDayStr = date('Y-m-d ',time());
            $timeBegin1 = strtotime($checkDayStr."09:01".":00");
            $timeEnd1 = strtotime($checkDayStr."16:59".":59");
            $curr_time = time();
            if($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1)
            {
                $this->_lx=1;
            }else{
                $this->_lx=0;
            }

        }

    }

}	
