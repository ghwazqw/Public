// 初始化 app
var myApp = new Framework7();

// 为便于使用，自定义DOM库名字为$$
var $$ = Dom7;

// 添加视图
var mainView = myApp.addView('.view-main', {
    // 让这个视图支持动态导航栏
    dynamicNavbar: true
});

// 下面代码是给“关于”页面使用的（关于页面加载完毕后触发）

// 方式1：通过页面回调 (推荐):
myApp.onPageInit('about', function (page) {
    myApp.alert('"关于"页面加载完毕1!');
})

// 方式2：通过pageInit事件处理所有页面
$$(document).on('pageInit', function (e) {
    // 获取页面数据
    var page = e.detail.page;

    //判断是否是“关于”页面
    if (page.name === 'about') {
        myApp.alert('"关于"页面加载完毕2!');
    }
})

// 方式2：通过pageInit事件处理所有页面(过滤出 data-page 属性为about的页面)
$$(document).on('pageInit', '.page[data-page="about"]', function (e) {
    myApp.alert('"关于"页面加载完毕3!');
})