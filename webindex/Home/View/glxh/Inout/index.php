<extend name="Public/adminbase" />
<block name="title">导入导出通讯录-{$webset.webname}</block>
<block name="subtitle">通讯录操作</block>
<block name="rcontent">
    <P><a href="{:U('Inout/expUser')}" >导出数据并生成excel</a></P><br/>
        <form action="{:U('Inout/impUser')}" method="post" enctype="multipart/form-data">
            <input type="file" name="import"/>
			<input type="hidden" name="table" value="tablename"/>
            <input type="submit" value="导入"/>
        </form>
</block>