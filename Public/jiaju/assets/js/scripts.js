
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch("/public/jiaju/assets/img/backgrounds/1.jpg");
    
    /*
        Form validation
    */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.login-form').on('submit', function(e) {
    	var username=$("#form-username").val();
    	var pass=$("#form-password").val();
    	if (!username){
            $("#form-username").addClass('input-error');
            return false;
		}else{
            $("#form-username").removeClass('input-error');
		}
		if (!pass){
            $("#form-password").addClass('input-error');
            return false;
		}else{
            $("#form-password").removeClass('input-error');
		}
        $("#submit").html("正在登录中，请稍候...");
        $("#submit").prop("disabled",true);
    });
});
