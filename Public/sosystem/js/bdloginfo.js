/*Ghw*/
$('#exp').bootstrapTable({
    columns: [{
        checkbox: true
    }, {
        field: 'id',
        title: '序号.',
        formatter: function(value, row, index) {
            return (index + 1)
        },
        width: 50,
        align: 'center'
    }, {
        field: 'user_name',
        title: '报单中心用户'
    }, {
        field: 'jy_sj',
        title: '报单时间'
    }, {
        field: 'jt_dx',
        title: '报单对像',
        formatter: function(value, row) {
            return value + " <span class='label label-primary'>" + row.user_xm + "</span>"
        }
    }, {
        field: 'jy_je',
        title: '支出金额',
        align: 'right'
    }, {
        field: 'jy_zt',
        title: '报单状态',
        align: 'right',
        formatter: function(value, row) {
            if (value == 100) {
                return "<span class='label label-success'>报单成功</span>"
            } else {
                return "<span class='label label-danger'>报单失败</span>"
            }
        }
    }, {
        field: 'zc_jldw',
        title: '备注'
    }, ],
    url: '/Home/Restful/Bdjson',
    method: 'get',
    datatype: 'json',
    striped: true,
    height: 760,
    undefinedText: '--',
    toolbar: '#toolbar',
    toolbarAlign: 'left',
    striped: true,
    dataField: "rows",
    pageNumber: 1,
    pagination: true,
    queryParamsType: 'limit',
    sidePagination: 'server',
    pageSize: 100,
    pageList: [100, 200, 500, 1000, 'All'],
    data_local: "zh-US",
    showRefresh: true,
    showColumns: true,
    sortOrder: 'desc',
    sortName: 'id',
});

function expinfo() {
    var myDate = new Date();
    $("#exp").table2excel({
        exclude: ".noExl",
        name: "Excel Document Name.xls",
        filename: myDate.toLocaleString() + ".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: false
    })
}