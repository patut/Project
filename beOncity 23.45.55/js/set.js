$(document).ready(function(){

	$("#table .value").keyup(function(){
		$("#name").css("border","1px solid rgba(182,182,182,.4)");
		$("#phone").css("border","1px solid rgba(182,182,182,.4)");
		$("#about").css("border","1px solid rgba(182,182,182,.4)");
		$("#loc").css("border","1px solid rgba(182,182,182,.4)");
	});

	$('#uploadform').ajaxForm();
	$('#chooseImg').bind('click', function(){
        $('#userfile').click(); // иммитируем нажатие на кнопку 'choose file', ибо ее нельзя кастомно разукрасить
    });

	$("#submit").bind("click",function(){
		
		if (item=='profile') {
			if ($.trim($("#name").val()) == 0)
				{ $("#error").fadeIn(250); $("#error").html("* Имя не может быть пустым."); hideBlock(); $("#name").val($.trim(($("#name").val()))); return false; }

			if (checkIfNumber($("#name").val()))
				{ $("#error").fadeIn(250); $("#error").html("* Имя не может содержать цифры."); hideBlock(); $("#name").val($.trim(($("#name").val()))); return false; }

			if ($("#phone").val().length != 11 && $("#phone").val().length!=0)
				{ $("#error").fadeIn(250); $("#error").html("* Номер телефона состоит из 11 цифр."); hideBlock(); return false; }

			if(!$.isNumeric($("#phone").val()) && $("#phone").val().length!=0 )
				{ $("#error").fadeIn(250); $("#error").html("* Вводить можно только цифры."); hideBlock(); return false; }

			if ($.trim($("#about").val()) == '')
				{ $("#error").fadeIn(250); $("#error").html("* Вам нужно рассказать немного о себе."); hideBlock(); $("#about").val($.trim($("#about").val())); return false; }

			if ($.trim($("#loc").val()) == '')
				{ $("#error").fadeIn(250); $("#error").html("* Пожалуйста, укажите ваше местоположение."); hideBlock(); $("#loc").val($.trim($("#loc").val())); return false; }

			$.post("/server/setprof.php", { id: $('#userid').html(), name: $("#name").val(), email: $("#email").val(), phone: $("#phone").val(), about: $("#about").val(), location: $("#loc").val() }, function(data) {
				if (data=="ok") {
					$("#error").fadeIn(250); $("#error").html("Ваши данные обновлены."); hideBlock(); return false;
				}
				else { $("#error").fadeIn(250); $("#error").html(data); hideBlock(); return false; }
	    	});


			// смотрим, выбран ли файл - изображение
	        var fileName = $('#userfile').val();
	        if (fileName == '' || fileName == undefined) { //если картинку не выбрали
	            return true;
	        }
	        else { // если картинку выбрали
	        	//alert('works1');
	            var ext = fileName.split(".")[1].toUpperCase(); // получаем расширение выбранного файла
	            if ( ext == 'PNG' || ext == 'JPG' || ext == 'JPEG') { // если оно среди допустимых
	            	//alert('works2');
                    $("#uploadform").ajaxSubmit({ 
                        url: '../server/e-upload.php',
                        success: function(data) { // вернется либо '...строка', либо '$$$строка'
                        	//alert('works3');
                            if (data.substr(0,3) == '$$$') {//если начинается с $$$ -> то это имя файла, иначе - ошибка
                                data = data.substr(3); //берем подстроку, начиная с 4 символа
                                var filename = 'http://beoncity.com/uploads/' + data; //генерируем путь к картинке
                                ajax.post('/server/photo2user.php', { id: $('#userid').html(), name: filename }, function(data){
                                	//alert(data);
                                });
                                // отправили картинку посту, который добавит ее к записи в EVENTS с указанным id
                            }
                            else { // на сервере обнаружена ошибка
                                data = data.substr(3);
                                $('#errorText').fadeIn(700).html(data + 'Загрузите, пожалуйста, изображение в одном из указанных форматов: png, jpg или jpeg.');
                            }
                        }
                    });
                    hideBlock();
	            }
	            else { // если формат файла не допустим
	                $('#errorText').fadeIn(700).html('Файл с расширением ' + fileName.split('.')[1] + ' невозможно загрузить.');
	                hideBlock();
	                return false;
	            }
	        }

		}
		else {
			$("#oldpass").val($.trim($("#oldpass").val()));
			$("#newpass").val($.trim($("#newpass").val()));
			$("#confirm").val($.trim($("#confirm").val()));

			if ($("#oldpass").val().length == 0)
				{ $("#error").fadeIn(250); $("#error").html("* Пароль не может быть пустым."); hideBlock(); $("#oldpass").val($.trim(($("#oldpass").val()))); return false; }

			if (($("#oldpass").val().length < 6) && ($("#oldpass").val().length > 60))
				{ $("#error").fadeIn(250); $("#error").html("* Пароль должен быть не менее, чем из 6 и не более, чем из 60 символов."); hideBlock(); $("#oldpass").val($.trim(($("#oldpass").val()))); return false; }

			if ($("#newpass").val().length == 0)
				{ $("#error").fadeIn(250); $("#error").html("* Пароль не может быть пустым."); hideBlock(); $("#newpass").val($.trim(($("#newpass").val()))); return false; }

			if (($("#newpass").val().length < 6) && ($("#newpasss").val().length > 60))
				{ $("#error").fadeIn(250); $("#error").html("* Пароль должен быть не менее, чем из 6 и не более, чем из 60 символов."); hideBlock(); $("#newpass").val($.trim(($("#newpass").val()))); return false; }

			if ($("#confirm").val() != $("#newpass").val())
				{ $("#error").fadeIn(250); $("#error").html("* Пароли не совпадают."); hideBlock(); $("#confirm").val($.trim($("#confirm").val())); return false; }
			
			
			$.post("/server/changepass.php", { userid: $('#userid').html(), old: $("#oldpass").val(), new: $("#newpass").val() }, function(data) {
				if (data=="ok") {
					$("#oldpass").val("");
					$("#newpass").val("");
					$("#confirm").val("");
					$("#error").fadeIn(250); $("#error").html("Пароль сменен."); hideBlock(); return false;
				}
				else { $("#error").fadeIn(250); $("#error").html(data); hideBlock(); return false; }
	    	});
		}

	});
	function hideBlock(){ setTimeout(fo, 4000); }
    function fo(){ $('#error').fadeOut(300); }
    function checkIfNumber(str){
    	for (i=0; i<str.length; i++)
    		if ($.isNumeric(str[i])) return true;
    	return false;
    }
    // обработчик изменения значения userfile 
	document.getElementsByName('userfile')[0].onchange = function(){
	    if ($('#userfile').val() != '') { // если изменилось название (а значит и выбранный файл)
	        name = $('#userfile').val().substr(12); // сохраняем в локальную переменную значение имени файла
	        $('#filenameholder').val(name); // и передаем ее в кастомный холдер на форме
	    }
	};
});
