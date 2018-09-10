//异步表格所必须
var opt={
    url: "/Restful/RoleList",
    type:"get",
    silent: true,
    query:{
        type:1,
        level:2
    }
};
$('#exp').bootstrapTable({
    columns: [{
        checkbox: true
    },
        { field: 'id', title: '序号.', formatter: function (value, row, index) {
                //return index + 1;
                return (index+1);
            },
            width:50,
            align: 'center'
        },
        { field: 'title', title: '角色名称',class: 'editinfo',
            align: 'left',
            formatter: function (value, row, index) {
                return "<a href=\"#\" name=\"name\" data-type=\"text\" data-pk=\""+row.Id+"\" data-title=\"角色名称维护\">" + value + "</a>";
            }},
        { field: 'status', title: '是否有效',formatter:function (value) {
                if(value==1){
                    return '<span class="label label-success">有效</span>';
                }else{
                    return "<span class=\"label label-danger\">无效</span>";
                }
            } },
        {field:'note',title:'角色说明',formatter:function(value){
                return value;
            }},
        { field: 'id', title: '功能操作', formatter: function (value,row) {
                //return index + 1;
                if (row.status==1){
                    return '<div class="btn-group" role="group">' +
                        '<input class="btn btn-danger btn-xs" onclick="delinfo('+value+')" type="button" value="删除" title="删除信息" />' +
                        '<input class="btn btn-warning btn-xs" onclick="Status('+value+','+row.status+')" type="button" title="置为无效" value="无效" />' +
                        '<input class="btn btn-default btn-xs" onclick="deli11nfo('+value+')" type="button" value="权限" title="权限操作" />' +
                        '<input class="btn btn-primary btn-xs" onclick="Status('+value+')" type="button" value="用户" title="下属用户查询" />' +
                        '</div>';
                }else{
                    return '<div class="btn-group" role="group">' +
                        '<input class="btn btn-danger btn-xs" onclick="delinfo('+value+')" type="button" value="删除" title="删除信息" />' +
                        '<input class="btn btn-success btn-xs" onclick="Status('+value+','+row.status+')" type="button" title="重新启用角色" value="启用" />' +
                        '<input class="btn btn-default btn-xs" onclick="deli11nfo('+value+')" type="button" value="权限" title="权限操作" />' +
                        '<input class="btn btn-primary btn-xs" onclick="Status('+value+')" type="button" value="用户" title="下属用户查询" />' +
                        '</div>';
                }

            },
            //width:150,
            align: 'left'
        },

    ],
    editable:true,
    onClickRow: function (row, $element) {
        curRow = row;
        //alert(curRow);
    },
    //数据编辑
    onLoadSuccess: function (aa, bb, cc) {
        $("#exp a").editable({
            url: function (params) {
                var sName = $(this).attr("name");
                curRow[sName] = params.value;
                //alert(curRow[sName]);
                if (curRow[sName]==""){
                    $("#exp").bootstrapTable('refresh', opt);
                    $("#error").show().delay(1000).hide(100);
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: "/Restful/RoleList",
                    data: curRow,
                    dataType: 'JSON',
                    success: function (data, textStatus, jqXHR) {
                        $.each(data,function (i,value) {
                            if (value==200){
                                $("#ok").show().delay(1000).hide(100);
                            }else{
                                $("#error").show().delay(1000).hide(100);
                            }
                        });
                    },
                    error: function () { alert("error");}
                });
            },
            type: 'text'
        });
    },
    url:'/restful/RoleList', //请求地址
    method: 'get', //请求方式
    datatype:'json', //返回数据格式
    //striped: true,       //是否显示行间隔色
    height:760,//高度调整
    undefinedText:'--', //数据为空时的显示内容
    /*工具栏处理*/
    toolbar: '#toolbar',//指定工具栏
    toolbarAlign:'left', //工具样位置
    striped: true, //是否显示行间隔色
    //earchText:'请输入搜索内容', //搜索默认文字


    /*分页处理*/
    dataField: "list", //读取后端给出的JSON中的数据记录集合，必须与后端保证一致
    pageNumber: 1, //初始化加载第一页，默认第一页
    pagination:true,//是否分页
    //clickToSelect: true, //
    queryParamsType:'limit',//查询参数组织方式
    //contentType: "application/x-www-form-urlencoded",//发送到服务器的数据编码类型
    sidePagination:'server',//指定服务器端分页
    pageSize:50,//单页记录数
    pageList:[25,50,100,500,'All'],//分页步进值
    data_local: "zh-US",//表格汉化
    showRefresh:true,//刷新按钮
    showColumns:true,
    sortOrder:'',  //排序规则
    sortName:'id' //排序字段
    //responseHandler:responseHandler,//请求数据成功后，渲染表格前的方法

});
//导出Excel
function expinfo(){
    var myDate = new Date();
    $("#exp").table2excel({
        exclude: ".noExl",
        name: "Excel Document Name.xls",
        filename: myDate.toLocaleString()+".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: false
    });
}
//删除信息
function delinfo(id) {
    if (!id){
        alert("请选择一个信息!");
        return false;
    }else{
        var massage=confirm("删除后不可恢复，请确认!");
        if (massage==true){
            $.ajax({
                type : "delete",
                url:"/restful/RoleList?id="+id,
                //contentType: "application/json",
                //data:{"id":id},
                success:function (data, state) { //成功调用回调信息
                    if (data==200){
                        $("#ok").show().delay(1000).hide(100);

                        $("#exp").bootstrapTable('refresh', opt);
                    }else if(data==500){
                        $("#error").show().delay(1000).hide(100);
                        return false;
                    }
                },
                complete: function (XMLHttpRequest, textStatus) {  //调用后返回信息
                    //alert(textStatus);
                },
                timeout: 60000,
                error: function (XMLHttpRequest, textStatus, errorThrown) {  //失败后调用回调信息
                    alert("服务器响应超时，请稍候重试：" + errorThrown);
                    return false;
                }
            })
        }
    }

}
//增加信息
function Addinfo() {
    var name=$("#name").val();
    var note=$("#note").val();
    var status=$("#status").val();
    $.ajax({
        type:"POST", //以post提交数据
        url:"/restful/rolelist",  //提交URL
        data:{"name":name,"note":note,"status":status}, //提交数据
        success:function (data, state) { //成功调用回调信息
            $.each(data,function (i,value) {
                if (value==200){
                    $("#ok").show().delay(1000).hide(100);
                    $("#exp").bootstrapTable('refresh', opt);
                }else{
                    $("#error").show().delay(1000).hide(100);
                }
            });
        },
        complete: function (XMLHttpRequest, textStatus) {  //调用后返回信息，可用于状态保存
            //alert(textStatus);
        },
        timeout: 60000, //执行最大时间，超过该时间为超时
        error: function (XMLHttpRequest, textStatus, errorThrown) {  //失败后调用回调信息
            alert("服务器响应超时，请稍候重试：" + errorThrown);
            return false;
        }

    });
}
//改变角色状态
function Status(id,status) {
    //alert(id);
    if (!id){
        alert("请选择一个信息!");
        return false;
    }else{
        if (status==1){
            var massage=confirm("设置无效后，下属用户将无法登录系统，请确认!");
        }else{
            var massage=confirm("将重新启用该角色，请确认!");
        }
        if (massage==true){
            $.ajax({
                type : "post",
                url:"/User/RoleStatus",
                data:{"id":id,"status":status},
                success:function (data,state) { //成功调用回调信息
                    if (data==200){
                        $("#ok").show().delay(1000).hide(100);
                        $("#exp").bootstrapTable('refresh', opt);
                    }else if(data==500){
                        $("#error").show().delay(1000).hide(100);
                        return false;
                    }
                },
                complete: function (XMLHttpRequest, textStatus) {  //调用后返回信息
                    //alert(textStatus);
                },
                timeout: 60000,
                error: function (XMLHttpRequest, textStatus, errorThrown) {  //失败后调用回调信息
                    alert("服务器响应超时，请稍候重试：" + errorThrown);
                    return false;
                }
            })
        }
    }
}