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
        field: 'cat_username',
        title: '报单中心用户',
        formatter: function(value, row) {
            return value + " <span class='label label-primary'>" + row.user_xm + "</span>"
        }
    }, {
        field: 'cat_dqje',
        title: '当前余额（单位：元）',
        align:'right'
    }, {
        field: 'cat_sj',
        title: '开设/更新时间',
        align: 'right'
    }, {
        field: 'zc_jldw',
        title: '备注'
    }, ],
    url: '/Home/Restful/Bdxjjson',
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