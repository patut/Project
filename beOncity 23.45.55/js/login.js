var checkedTerms = true;

$(document).ready(function(){
	//.setAttribute("type", "password");
	

	$("#signin").bind("click",function(){
		$.post("server/signin.php", { email: $("#email").val(), pass: $("#pass").val() }, function(data) {
			if (data=="ok") { document.location.href = "http://beoncity.com/"; }
			else {
				if (data=="noemail") $("#emailField").css("border","1px solid red");
				if (data=="nopass") $("#passField").css("border","1px solid red");
				$("#loginerror").fadeIn(250); $("#loginerror").html(data); hideBlock1(); return false;
			}
			return false;
    	});
	});

	$(".field input").keyup(function(){
		$("#emailField").css("border","1px solid rgba(182,182,182,.4)");
		$("#passField").css("border","1px solid rgba(182,182,182,.4)");
	});

	$("#sign_up_send").bind("click",function(){
		if (checkedTerms) {
			$("#error").fadeOut(250); $("#error").html("");
			if (($("#new_name").val()=="") || ($("#new_email").val()=="") || ($("#new_pass").val()==""))
				{ $("#error").fadeIn(250); $("#error").html("* Заполните, пожалуйста, все поля."); hideBlock();  return false; }
			if ($("#new_pass").val().lenght < 6)
				{ $("#error").fadeIn(250); $("#error").html("* Пароль должен состоять из 6 символов или более."); hideBlock(); return false; }
			if ($("#new_pass").val().lenght > 50)
				{ $("#error").fadeIn(250); $("#error").html("* Длина пароля не должна превышать 50 символов."); hideBlock(); return false; }

			$.post("server/signup.php", { name: $("#new_name").val(), regemail: $("#new_email").val(), regpasswd: $("#new_pass").val() }, function(data) {
				if (data=="ok") {
					$("#new_name").css("display","none");
					$("#new_email").css("display","none");
					$("#new_pass").css("display","none");
					$("#terms").css("display","none");
					$("#sign_up_send").css("display","none");
					$("#signupbox").css("width","480px");
					var popuptopmargin = ($('#signupbox').height() + 10) / 2;
					var popupleftmargin = ($('#signupbox').width() + 10) / 2;
					$('#signupbox').css({
						'margin-top' : -popuptopmargin,
						'margin-left' : -popupleftmargin
					});
					$("#signup-title").html("Спасибо за регистрацию! На Ваш адрес " + $("#new_email").val() + " было выслано сообщение с дальнейшей инструкцией. До встречи на Beoncity.");
				}
				else { $("#error").fadeIn(250); $("#error").html(data); hideBlock(); return false; }
	    	});
		}
		else {
			return false;
		}
	});

	$('#signup').bind('click',function(){
        var popuptopmargin = ($('#signupbox').height() + 10) / 2;
		var popupleftmargin = ($('#signupbox').width() + 10) / 2;
		$('#signupbox').css({
			'margin-top' : -popuptopmargin,
			'margin-left' : -popupleftmargin
		});
		$('#fadeBlock').fadeIn(250);
        $('#signupbox').fadeIn(250);
    });

    $('#fadeBlock').bind('click',function(){
        $('#fadeBlock').fadeOut(250);
        $('#signupbox').fadeOut(250);
        $("#new_name").val("");
		$("#new_surname").val("");
		$("#new_email").val("");
		$("#new_pass").val("");
		$("#error").html("");
		$("#error").fadeOut(250);
		return false;
    }); 

    function hideBlock(){ setTimeout(fo, 4000); }
    function fo(){ $('#error').fadeOut(300); }

    function hideBlock1(){ setTimeout(fo1, 4000); }
    function fo1(){ $('#loginerror').fadeOut(300); }
});
function checkifchecked(flag){
	checkedTerms = flag;
	if (!checkedTerms) {
		$('#sign_up_send').css('boxShadow','inset 0 1px 6px rgba(0,0,0,.15)');
		$('#sign_up_send').css('background-color','rgba(0,0,0,.15)');
		$('#sign_up_send').hover(function(){
			$('#sign_up_send').css('cursor','default');
		});
	}
	else {
		$('#sign_up_send').css('boxShadow','0 1px 6px rgba(0,0,0,.15)');
		$('#sign_up_send').css('background-color','transparent');
		$('#sign_up_send').hover(function(){
			$('#sign_up_send').css('cursor','pointer');
		});
	}
}