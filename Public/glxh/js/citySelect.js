

var cityA = $(".city_a_le1 a"); //城市
var pla = $("#place");  //出发地
var dest = $("#destination");  //目的地
// 默认值
inCity.width = "450px";  //城市选择框  宽
inCity.height = "auto";  //城市选择框  高
inCity.id = "#in_city";  //城市选择框  父级ID
inCity.Children = '.city_a_le1';  //城市名box
// 初始化 城市HTML模板
$(inCity.id).prepend(inCity._template.join(''));
inCity.Hot(cityA);

//城市 导航
var apay = $(".screen a");

var placeThis; //当前选择标签
apay.click(function(obj){  //城市导航
    inCity.payment($(this));
})

inCity.place(pla); //出发地
inCity.destination(dest);  //目的地
inCity.cityClick(cityA); //显示赋值城市}