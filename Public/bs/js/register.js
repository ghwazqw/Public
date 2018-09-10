$(document).ready(function(){
    $("#Submit").prop("disabled",true);
    function trim(str){
        return str.replace(/^\s*|\s*$/ig,"")
    }
    function getUserName(){
        return trim($("#Username").val());
    }
    function txtcode(){
        return trim($("#txtcode").val());
    }
    function txtpwd(){
        return trim($("#textPwd").val());
    }
    function Email() {
        return trim($("#Email").val());
    }
    function tjr() {
        return trim($("#user_tjr").val());
    }
    $("#user_tjr").blur(function () {
       if (!tjr()){
           $("#user_tjr").attr('placeholder',"此项为必填");
           $("#user_tjr").css('border',"1px solid #ff0000");
           //$("#user_chck").html("错误");
           $("#tjr_chck").show();
           $("#Submit").prop("disabled",true);
           return false;
       }else{
           $.ajax({
               type:"POST", //以post提交数据
               url:"/home/Quser/tjrchk",  //提交URL
               data:{"tjm":tjr()}, //提交数据
               success:function (result, state) { //成功调用回调信息
                    //alert(data);
                   $("#chkmsg").css('color','#ff0000');
                   if (result=='Error'){
                       $("#user_tjr").css('border',"1px solid #ff0000");
                       $("#tjr_chck").show();
                       $("#tjr_chck").html('推荐码验证不通过');
                       $("#tjr_ok").hide();
                       $("#Submit").prop("disabled",true);
                       return false;
                   }else if(result==2){
                       $("#chkmsg").css('color','#ff0000');
                       $("#user_tjr").css('border',"1px solid #ff0000");
                       $("#tjr_chck").show();
                       $("#tjr_chck").html('推荐码已经满员，请更换后注册');
                       $("#tjr_ok").hide();
                       $("#Submit").prop("disabled",true);
                       return false;
                   }else if(result==0){
                       $("#user_tjr").css('border',"1px solid #0785e9");
                       $("#tjr_chck").show();
                       $("#tjr_chck").html('您注册的用户为分享线(A区)用户');
                       $("#tjr_ok").show();
                       $("#Submit").prop("disabled",false);
                   }else if(result==1){
                       $("#user_tjr").css('border',"1px solid #0785e9");
                       $("#tjr_chck").show();
                       $("#tjr_chck").html('您注册的用户为开市线(B区)用户');
                       $("#tjr_ok").show();
                       $("#Submit").prop("disabled",false);
                   }else{
                       $("#user_tjr").css('border',"1px solid #0785e9");
                       $("#tjr_chck").hide();
                       $("#tjr_ok").show();
                       $("#Submit").prop("disabled",false);
                   }
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
    });
    $("#Email").blur(function () {
        if (!Email()){
            $("#Email").attr('placeholder',"此项为必填");
            $("#Email").css('border',"1px solid #ff0000");
            //$("#user_chck").html("错误");
            $("#Email_chck").show();
            $("#Submit").prop("disabled",true);
            return false;
        }else{
            var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email
            if(!preg.test(Email())){
                $("#Email").attr('placeholder',"邮箱填写错误");
                $("#Email").css('border',"1px solid #ff0000");
                $("#Email_chck").show();
                $("#Email_chck").html("请填写正确的邮箱！");
                $("#Email_ok").hide();
                $("#Submit").prop("disabled",true);
                return false;
            }else{
                $.ajax({
                    type:"POST",
                    url:"/home/Quser/Forgot_Password",
                    data:{"email":Email()},
                    success:function(result,state){ //成功调用回调信息
                        $("#chkmsg").css('color','#ff0000');
                        if (result!='Error'){
                            $("#Email").css('border',"1px solid #ff0000");
                            $("#Email_chck").show();
                            $("#Email_chck").html('邮箱已经被注册');
                            $("#Email_ok").hide();
                            $("#Submit").prop("disabled",true);
                            return false;
                        }else{
                            $("#Email").css('border',"1px solid #0785e9");
                            $("#Email_chck").hide();
                            $("#Email_ok").show();
                            $("#Submit").prop("disabled",false);
                        }
                    },
                    complete:function(XMLHttpRequest, textStatus){  //调用后返回信息
                        /*$("#Submit").html("提交");
                        $("#Submit").prop("disabled",false);*/
                    },
                    timeout:60000,
                    error:function(XMLHttpRequest, textStatus, errorThrown){  //失败后调用回调信息
                        alert("响应超时，请稍候重试"+errorThrown);
                    }
                })
            }
        }

    })
    $("#Username").blur(function(){
        if (!getUserName()){
            $("#Username").attr('placeholder',"此项为必填");
            $("#Username").css('border',"1px solid #ff0000");
            //$("#user_chck").html("错误");
            $("#user_chck").show();
            $("#Submit").prop("disabled",true);
            return false;
        }
        else{
            if (getUserName().length<6 || getUserName().length>20){

                $("#Username").css('border',"1px solid #ff0000");
                $("#user_chck").html("请输入6-20位字母或数字的组合。");
                $("#user_chck").show();
                $("#user_ok").hide();
                $("#Submit").prop("disabled",true);
                return false;
            }
            else{
                $.ajax({
                    type:"POST",
                    url:"/home/Quser/user_reg",
                    data:{"Username":getUserName(),"action":1},
                    success:function(result,state){
                        var getResult=eval("("+result+")");
                        //alert(getResult.user_info);
                        if (getResult.user_callback==1){
                            //alert(getResult.user_callback);
                            $("#Username").css('border',"1px solid #0785e9");
                            $("#user_chck").hide();
                            $("#user_ok").show();
                            $("#Submit").prop("disabled",false);
                        }
                        else{
                            //alert(getResult.user_callback);
                            $("#Username").css('border',"1px solid #ff0000");
                            $("#user_chck").html("用户被占用。");
                            $("#user_chck").show();
                            $("#user_ok").hide();
                            $("#Submit").prop("disabled",true);
                            return false;
                        }
                    },
                    timeout:8000,
                    error:function(XMLHttpRequest, textStatus, errorThrown){  //失败后调用回调信息
                        alert("出错，具体为"+textStatus);
                    }
                })
            }
        }
    })
    $("#textPwd").blur(function(){
        var reg=/^\w{6,}$/;
        var textPwd = trim($("#textPwd").val());
        if (textPwd==""){
            $("#textPwd").attr('placeholder',"此项为必填");
            $("#textPwd").css('border',"1px solid #ff0000");
            $("#pass_chck").show();
            $("#pass_ok").hide();
            $("#Submit").prop("disabled",true);
            return false;
        }
        else
        {
            if (!reg.test(textPwd)){
                $("#pass_chck").show();
                $("#pass_ok").hide();
                $("#pass_chck").html("请输入6-20位字母/数字/符号的组合。");
                $("#Submit").prop("disabled",true);
                return false;
            }else
            {
                $("#textPwd").css('border',"1px solid #0785e9");
                $("#pass_chck").hide();
                $("#pass_ok").show();
                $("#Submit").prop("disabled",false);

            }
        }

    });
    $("#rePwd").blur(function(){
        var rePwd=trim($("#rePwd").val());
        var textPwd=trim($("#textPwd").val());
        if(rePwd==""){
            $("#rePwd").attr('placeholder',"此项为必填");
            $("#rePwd").css('border',"1px solid #ff0000");
            $("#repass_chck").show();
            $("#repass_ok").hide();
            $("#Submit").prop("disabled",true);
            return false;

        }
        else{
            if (textPwd!=rePwd){
                $("#repass_ok").hide();
                $("#repass_chck").html("两次输入的密码不一致");
                $("#repass_chck").show();
                $("#Submit").prop("disabled",true);
                return false;
            }
            else{
                $("#repass_chck").hide();
                $("#rePwd").css('border',"1px solid #0785e9");
                $("#repass_ok").show();
                $("#Submit").prop("disabled",false);
            }


        }
    });
    $("#txtcode").blur(function(){
        var txtcode=trim($("#txtcode").val());
        if(txtcode==""){
            $("#txtcode").attr('placeholder',"此项为必填");
            $("#txtcode").css('border',"1px solid #ff0000");
            $("#code_chck").show();
            $("#code_ok").hide();
            $("#Submit").prop("disabled",true);
            return false;
        }
        else{
            $.ajax({
                type:"POST",
                url:"/home/Quser/user_reg",
                data:{"txtcode":txtcode,"action":2},
                success:function(data,state){
                    var gettxtcode=eval("("+data+")");
                    //alert(gettxtcode.txt_info);
                    if (gettxtcode.txt_callback==0){
                        $("#txtcode").css('border',"1px solid #ff0000");
                        $("#Info").html(gettxtcode.txt_info);
                        $("#code_chck").show();
                        $("#code_ok").hide();
                        $("#Submit").prop("disabled",true);
                        return false;
                    }else{
                        $("#code_chck").hide();
                        $("#txtcode").css('border',"1px solid #0785e9");
                        $("#Info").hide();
                        $("#code_ok").show();
                        $("#Submit").prop("disabled",false);
                    }
                },
            })
        }
    });


    $("#Submit").click(function(){
            if (!getUserName() || !txtcode() || !Email() || !tjr()){
                alert("所有信息必须输入");
            }
            else
            {
                //alert("正在提交后端");
                $("#Submit").html("正在提交...");
                $("#Submit").prop("disabled",true);
                $.ajax({
                    type:"POST",
                    url:"/home/Quser/user_reg",
                    data:{"Username":getUserName(),"action":3,"textPwd":txtpwd(),"user_yx":Email(),"user_tjr":tjr()},
                    success:function(result,state){ //成功调用回调信息
                        window.location.href="/?a=user_ok&c=Quser";
                    },
                    complete:function(XMLHttpRequest, textStatus){  //调用后返回信息
                        $("#Submit").html("提交");
                        $("#Submit").prop("disabled",false);
                    },
                    timeout:8000,
                    error:function(XMLHttpRequest, textStatus, errorThrown){  //失败后调用回调信息
                        alert("出错，具体为"+textStatus);
                    }
                })
            }
        }
    )
})