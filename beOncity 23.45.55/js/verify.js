
$(document).ready(function(){

	$("#table .value").keyup(function(){
		$("#name").css("border","1px solid rgba(182,182,182,.4)");
		$("#phone").css("border","1px solid rgba(182,182,182,.4)");
		$("#about").css("border","1px solid rgba(182,182,182,.4)");
		$("#loc").css("border","1px solid rgba(182,182,182,.4)");
	});

	$("#submit").bind("click",function(){
	
		if ($.trim($("#name").val()) == 0)
			{ $("#error").fadeIn(250); $("#error").html("* Имя не может быть пустым."); hideBlock(); $("#name").val($.trim(($("#name").val()))); return false; }
		if ($("#phone").val().length != 11 && $("#phone").val().length!=0)
			{ $("#error").fadeIn(250); $("#error").html("* Номер телефона состоит из 11 цифр."); hideBlock(); return false; }
		if ($.trim($("#about").val()) == '')
			{ $("#error").fadeIn(250); $("#error").html("* Вам нужно рассказать немного о себе."); hideBlock(); $("#about").val($.trim($("#about").val())); return false; }
		if ($.trim($("#loc").val()) == '')
			{ $("#error").fadeIn(250); $("#error").html("* Пожалуйста, укажите ваше местоположение."); hideBlock(); $("#loc").val($.trim($("#loc").val())); return false; }

		
		$.post("verify.php", { name: $("#name").val(), email: $("#email").val(), phone: $("#phone").val(), about: $("#about").val(), location: $("#loc").val() }, function(data) {
			if (data=="ok") {
				document.location.href = "http://beoncity.com/";
			}
			else { $("#error").fadeIn(250); $("#error").html(data); hideBlock(); return false; }
    	});

	});
	function hideBlock(){ setTimeout(fo, 4000); }
    function fo(){ $('#error').fadeOut(300); }
});
