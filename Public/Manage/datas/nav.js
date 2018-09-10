var navs = [{
	"title": "基础信息管理",
	"icon": "fa-cubes",
	"spread": true,
	"children": [{
		"title": "组织机构管理",
		"icon": "&#xe641;",
		"href": "/index.php/Home/Cgxx/comp_list"
	},{
		"title": "角色信息管理",
		"icon": "&#xe628;",
		"href": "/index.php/Home/user/role_manage"
	} ,{
		"title": "用户信息管理",
		"icon": "&#xe60c;",
		"href": "/index.php/Home/user/U_manage"
	}, {
		"title": "设备分类信息管理",
		"icon": "&#xe609;",
		"href": "/Home/Jcxx/zclx_list"
	}/*, {
		"title": "导航",
		"icon": "&#xe609;",
		"href": "nav.html"
	}, {
		"title": "辅助性元素",
		"icon": "&#xe60c;",
		"href": "auxiliar.html"
	}*/]
}, {
	"title": "人员信息管理",
	"icon": "fa-newspaper-o",
	"spread": false,
	"children": [ {
		"title": "人员基础信息管理",
		"icon": "fa-navicon",
		"href": "/home/user/Ryuan_manage"
	}/*, {
		"title": "人员信息变更管理",
		"icon": "&#xe62a;",
		"href": "tab.html"
	}*/
		/*, {
		 "title": "Laytpl+Laypage",
		 "icon": "&#xe628;",
		 "href": "paging.html"
		 }*/]
} ,{
	"title": "房屋信息管理",
	"icon": "fa-cogs",
	"spread": false,
	"children": [{
		"title": "楼宇信息管理",
		"icon": "fa-table",
		"href": "/index.php/Home/cgxx/cgxx_class"
	}, {
		"title": "房屋信息管理",
		"icon": "fa-navicon",
		"href": "/index.php/Home/cgxx/house_list"
	}/*, {
		"title": "设备维修信息管理",
		"icon": "&#xe62a;",
		"href": "/index.php/Home/cgxx/Cgwcdw_list"
	}*/]
},{
	"title": "资产卡片信息管理",
	"icon": "fa-newspaper-o",
	"spread": false,
	"children": [{
		"title": "机械器具信息管理",
		"icon": "&#xe63c;",
		"href": "/Home/ZcManage/JxqjManage"
	}, {
		"title": "电子设备信息管理",
		"icon": "&#xe63c;",
		"href": "/Home/ZcManage/DzsbManage?lx=59"
	}/*, {
		"title": "房屋信息管理",
		"icon": "&#xe63c;",
		"href": "/Home/ZcManage/fwxxEditor"
	}*/, {
		"title": "运输工具信息管理",
		"icon": "&#xe63c;",
		"href": "/Home/ZcManage/ClxxManage"
	}, {
		"title": "其他设备信息管理",
		"icon": "&#xe63c;",
		"href": "/Home/ZcManage/QtsbManage"
	}]
}, {
	"title": "合同管理",
	"icon": "fa-newspaper-o",
	"spread": false,
	"children": [{
		"title": "合同信息录入/导入",
		"icon": "&#xe63c;",
		"href": "/Home/ZcManage/HtManage"
	}/*, {
		"title": "合同信息统计查询",
		"icon": "&#xe63c;",
		"href": "/Home/ZcManage/DzsbEditor"
	}*/, {
		"title": "合同到期提醒",
		"icon": "&#xe63c;",
		"href": "/Home/ZcManage/HtManage"
	}]
}
	, {
		"title": "资产调配管理",
		"icon": "fa-newspaper-o",
		"spread": false,
		"children": [{
			"title": "调配管理",
			"icon": "&#xe63c;",
			"href": "/Home/DpManage"
		}, {
			"title": "调配信息查询",
			"icon": "&#xe63c;",
			"href": "/Home/DpManage/Dpview"
		}]
}, {
		"title": "盘点管理",
		"icon": "fa-newspaper-o",
		"spread": false,
		"children": [{
			"title": "盘点计划制作",
			"icon": "&#xe63c;",
			"href": "/Home/PdManage"
		}, {
			"title": "盘点表下载(PDA)",
			"icon": "&#xe63c;",
			"href": "/Home/PdManage"
		}, {
			"title": "盘点结果修正",
			"icon": "&#xe63c;",
			"href": "/Home/PdManage"
		}, {
			"title": "盘点信息统计",
			"icon": "&#xe63c;",
			"href": "/Home/PdManage"
		}]
	}

	, {
		"title": "设备维修养护管理",
		"icon": "fa-newspaper-o",
		"spread": false,
		"children": [{
			"title": "维修记录管理",
			"icon": "&#xe63c;",
			"href": "/Home/WxManage/wxsq"
		}, {
			"title": "维修记录统计",
			"icon": "&#xe63c;",
			"href": "/Home/WxManage"
		}, {
            "title": "养护记录管理",
            "icon": "&#xe63c;",
            "href": "/Home/WxManage/Bysq"
        }
		, {
				"title": "养护记录统计",
				"icon": "&#xe63c;",
				"href": "/Home/WxManage/ByList"
			}
			/*, {
				"title": "资产状态评估",
				"icon": "&#xe63c;",
				"href": "/Home/ZcManage/DzsbEditor"
			}, {
				"title": "资产变更记录",
				"icon": "&#xe63c;",
				"href": "/Home/ZcManage/DzsbEditor"
			}*/
			, {
				"title": "资产报表导出",
				"icon": "&#xe63c;",
				"href": "/Home/WxManage/wait"
			}]
	}
	, {
		"title": "报废管理",
		"icon": "fa-newspaper-o",
		"spread": false,
		"children": [{
			"title": "报废申请",
			"icon": "&#xe63c;",
			"href": "/Home/BfManage/Editor"
		},{
			"title": "报废确认",
			"icon": "&#xe63c;",
			"href": "/Home/BfManage/BfManage"
		}, {
			"title": "报废信息查询",
			"icon": "&#xe63c;",
			"href": "/Home/BfManage/Bflist"
		}]
	}
];