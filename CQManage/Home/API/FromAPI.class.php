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
		$this->_TableNmae=$ret=$Model->query("select * from information_schema.tables where table_schema='cqzq'and table_name not like 'zc_cq_pt%' ");
	}
	function page_table(){
		$Model = M();
		$this->_TableNmae=$ret=$Model->query("select * from information_schema.tables where table_schema='cqzq'and table_name not like 'zc_cq_pt%' ");
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
	function SocServer(){
	    $socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP); //创建socket服务，相当于电话机
        socket_bind($socket,'127.0.0.1',9090); //绑定地址
        socket_listen($socket,5); //创建监听及最大连接数
        while (true){
            $client=socket_accept($socket); //有人打电话
            $buf=socket_read($client,1024); //最大接收长度
            echo $buf;

            socket_write($client,"hello server");
            socket_close($client);  //关掉客户机
            }
        socket_close($socket);

    }

}	
