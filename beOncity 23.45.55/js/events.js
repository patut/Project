var curDate = new Date();
var months = curDate.getMonth();
var monthString = '';
var eventTitle = '';
var eventLocation = '';
var eventTime = '';
var eventType = '';
var address = '';
var addressRU = '';
var addressEN = '';
var newlat = '';
var newlong = '';
var desc = '';
var chosenTypeText = '';


switch (months) {
	case 0: monthString = 'января'; break;
	case 1: monthString = 'февраля'; break;
	case 2: monthString = 'марта'; break;
	case 3: monthString = 'апреля'; break;
	case 4: monthString = 'мая'; break;
	case 5: monthString = 'июня'; break;
	case 6: monthString = 'июля'; break;
	case 7: monthString = 'августа'; break;
	case 8: monthString = 'сентября'; break;
	case 9: monthString = 'октября'; break;
	case 10: monthString = 'ноября'; break;
	case 11: monthString = 'декабря'; break;
}
var days = curDate.getDate();
var hours = curDate.getHours();
var minutes = curDate.getMinutes();
var seconds = curDate.getSeconds();

if (hours < 10) { hours = "0" + hours; }
if (minutes < 10) { minutes = "0" + minutes; }

var datastr = 'Сегодня ' + days + ' ' + monthString;
document.getElementById('currdate').innerHTML = datastr;


//getPointData('address', Moscow', 'en')
function getPointData(arg, val, lang) { // запрос информации о точке по адресу/координатам и языку || 
    //arg : { 'address', 'latlng' }
    //val: { 'Москва, улица Вернадского, 13', '55.75320193022759,37.61922086773683' }
    //lang: { 'ru', 'en' }
    if (arg != "address" && arg != "latlng") { alert("wrong argument type, choose 'address' or 'latlng'"); return; }
    if (lang != "ru" && lang != "en") { alert("wrong language, choose 'ru' or 'en'"); return; }
    var jsonRU = eval('(' + ajax.jsonQuery('http://maps.googleapis.com/maps/api/geocode/json?' + arg + '=' + val + '&sensor=false&language=ru') + ')');
    var jsonEN = eval('(' + ajax.jsonQuery('http://maps.googleapis.com/maps/api/geocode/json?' + arg + '=' + val + '&sensor=false&language=en') + ')');
    // доступ к results address components: json.results[0].address_components[3].long_name
    var status = jsonEN.status;
    var error = 0;
    switch(status) {
        case "OK":
            break;
        case "ZERO_RESULTS":
            error = "No results";
            return false;
            break;
        case "OVER_QUERY_LIMIT":
            error = "Too long address string";
            return false;
            break;
        case "REQUEST_DENIED":
            error = "Request denied. Check sensor parameter";
            return false;
            break;
        case "INVALID_REQUEST":
            error = "Invalid request. Address or Latlng can be missed";
            return false;
            break;
    }

    if (arg == 'address') {
        newlat = jsonEN.results[0].geometry.location.lat;
        newlong = jsonEN.results[0].geometry.location.lng;
    }

    addressEN = jsonEN.results[0].formatted_address;
    addressRU = jsonRU.results[0].formatted_address;
    for (var i = 0; i < jsonRU.results[0].address_components.length; i++) {
        var addr = jsonRU.results[0].address_components[i];
        if (addr.types[0] == 'postal_code'){
            alert("вижу индекс");
            var postal_code = addr.long_name;
            addressEN = addressEN.substring(0,addressEN.indexOf(postal_code)-2);
            addressRU = addressRU.substring(0,addressRU.indexOf(postal_code)-2);
            alert(addressRU+"\n"+addressEN);
        }
    }

    switch(lang) {
        case 'ru':
            return addressRU;
            break;
        case 'en':
            return addressEN;
            break;
        default:
            return true;
            break;
    }
}
function setCookie (name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}
function getCookie(name) {
    var cookie = " " + document.cookie;
    var search = " " + name + "=";
    var setStr = null;
    var offset = 0;
    var end = 0;
    if (cookie.length > 0) {
        offset = cookie.indexOf(search);
        if (offset != -1) {
            offset += search.length;
            end = cookie.indexOf(";", offset)
            if (end == -1) {
                end = cookie.length;
            }
            setStr = unescape(cookie.substring(offset, end));
        }
    }
    return(setStr);
}
function willgo(id,usr) {
    if (usr == 'notauth') alert("Чтобы воспользоваться данной функцией, вы должны зарегистрироваться.");
    else ajax.post('/server/willgo.php', { event_id: id, user_id: usr}, function(data){
        alert(data);
    });
}
function havebeen(id,usr) {
    if (usr == 'notauth') alert("Чтобы воспользоваться данной функцией, вы должны зарегистрироваться.");
    else ajax.post('/server/ivebeen.php', { event_id: id, user_id: usr}, function(data){
        alert(data);
    });
}
function cool(id) {
    if (getCookie("cool"+id) == "closed") alert("Вы уже отправляли отзыв.");
    else ajax.post('/server/cool.php', { event_id: id }, function(data) {
        var x = new Date();
        var y = x.getFullYear() + 1;
        var m = x.getMonth();
        var d = x.getDate();
        var h = x.getHours();
        var mi = x.getMinutes();
        var s = x.getSeconds();
        var newd = new Date(y,m,d,h,mi,s);
        setCookie("cool"+id, "closed", newd, "/");
        alert(data);
    });
}

// обработчик изменения значения userfile 
document.getElementsByName('userfile')[0].onchange = function(){
    if ($('#userfile').val() != '') { // если изменилось название (а значит и выбранный файл)
        name = $('#userfile').val().substr(12); // сохраняем в локальную переменную значение имени файла
        $('#filenameholder').val(name); // и передаем ее в кастомный холдер на форме
    }
};

function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    }
}

function stripslashes(str){
    r = new RegExp("\x27","g");
    return str.replace('/\0/g', '0').replace('/\(.)/g', '$1').replace(r, "’");
}

function descfocus(id){
   $('#'+id).animate({
        'height': '100px'
    }, 300); 
}

function descblur(id){
    $('#'+id).animate({
        'height': '18px'
    }, 300);
}

$(document).ready(function(){
    $("#datepicker").datetimepicker({ dateFormat: "MM dd, yy  " });

    //Dropdown plugin data
    var ddData = [
        { text: "Музыка", key: "music", value: 1, selected: false, description: "Концерты, фестивали", imageSrc: "/img/icon.png" },
        { text: "Танцы", key: "dance", value: 2, selected: false, description: "Танцы, выступления", imageSrc: "/img/icon.png" },
        { text: "Культура", key: "culture", value: 3, selected: false, description: "Театры, музеи, выставки", imageSrc: "/img/icon.png" },
        { text: "Активный отдых", key: "activity", value: 4, selected: false, description: "Спорт, ролики, прогулки", imageSrc: "/img/icon.png" },
        { text: "Экстрим", key: "extreme", value: 5, selected: false, description: "Паркур, скейтбординг", imageSrc: "/img/icon.png" },
        { text: "Жизнь", key: "life", value: 6, selected: false, description: "Дни рождения, пикники", imageSrc: "/img/icon.png" },
        { text: "Разное", key: "other", value: 7, selected: false, description: "Разные события", imageSrc: "/img/icon.png" },
        { text: "Романтика", key: "romantic", value: 8, selected: false, description: "Встречи, свидания", imageSrc: "/img/icon.png" },
        { text: "Флешмоб", key: "flashmob", value: 9, selected: false, description: "Флешмобы, митинги", imageSrc: "/img/icon.png" }
    ];

    $('#checkType').ddslick({ // плагин для красивого отображения выпадающего списка
        data: ddData,
        width: '100%',
        imagePosition: "left",
        selectText: "Выберите подходящую категорию",
        onSelected: function(data) {
            chosenTypeText = data.selectedData.key; // после выбора пихаем значение выбранного элемента в глобальную переменную
            // alert(chosenTypeText);
        }
    });

    $('#sendEvent').bind('click', function() {
        // обнуляем анимашки
        if ($('#errorText').html() != '') $('#errorText').html('');
        $('#controlls').fadeOut(100);

        //собираем значения полей
        eventTitle = $.trim(stripslashes($('#eventname').val().toString()));
        eventLocation = $.trim(stripslashes($('#eventloc').val().toString()));
        eventTime = $('#datepicker').val();
        
        eventType = chosenTypeText.toString().toLowerCase();
        desc = $('#eventdesc').val();

        //проверка на валидность полей
        if (eventType == '') {
            $('#errorText').fadeIn(700);
            $('#errorText').html("Какая категория ближе к Вашему событию?");
            return;
        }
        else if (eventTitle == '') {
            $('#errorText').fadeIn(700);
            $('#errorText').html("Придумайте название Вашему мероприятию.");
            return;
        }
        else if (eventLocation == '') {
            $('#errorText').fadeIn(700);
            $('#errorText').html("Где будет происходить событие?");
            return;
        }
        else if (eventTime == '') {
            $('#errorText').fadeIn(700);
            $('#errorText').html("Когда все начнется?");
            return;
        }
        else if (desc == '') {
            $('#errorText').fadeIn(700);
            $('#errorText').html("Пожалуйста, расскажите нам что-нибудь о Вашем событии.");
            return;
        }
        
        //получаем из гугла по запросу данные о точке
        address = getPointData('address', eventLocation , 'en'); // eventLocation ; [language] в случае en возвращают en-US -> надо найти список всех значений language от navigator
        if (address) { // если возвращается true
            $('#errorText').fadeIn(700).html('Это тот адрес? </br></br>' + address);
            $('#controlls').fadeIn(700); //показываем кнопки "confirm"/"cancel" для подтверждения адреса
        }
        else { // false возвращается в случае ошибки
            $('#errorText').fadeIn(700).html('Вы ввели несуществующий адрес.');
        }
    });
    
    //подтверждение адреса
    $('#confirm').bind('click', function() { // после подтверждения введенного адреса
        // убираем кнопки "confirm"/"cancel"
        $('#controlls').fadeOut(100);
        // отправка события на сервак
        // смотрим, выбран ли файл - изображение
        var fileName = $('#userfile').val();
        if (fileName == '' || fileName == undefined) { //если картинку не выбрали
            ajax.post('/server/newevent.php', { title: eventTitle, author: $('#userid').html(), desc: desc, ru: addressRU, en: addressEN, lat: newlat, long: newlong, date: eventTime, filter: eventType }, function(data){
                //alert(data);
                $('#errorText').fadeIn(700).html('Ваше событие благополучно отправлено.');
                hideBlock(); // все равно отправляем, ибо картинка не обязательна
            });
            return true;
        }
        else { // если картинку выбрали
            var ext = fileName.split(".")[1].toUpperCase(); // получаем расширение выбранного файла
            if ( ext == 'PNG' || ext == 'JPG' || ext == 'JPEG') { // если оно среди допустимых
                //alert('изображение выбрано');
                // отправляем сначала все данные формы (текстовые), чтобы получить автоматически генерируемый id на серваке, а потом его же и получаем в callback в виде data
                ajax.post('/server/newevent.php', { title: eventTitle, author: $('#userid').html(), desc: desc, ru: addressRU, en: addressEN, lat: newlat, long: newlong, date: eventTime, filter: eventType }, function(data){
                    //alert(data);
                    //alert(data);
                    $('#fileid').val(data); // т.к передать значение этого id невозможно внутрь ajaxSubmit(точно нельзя - 100 раз попробовал), передаю в тест, а потом оттуда вытащу
                    $("#uploadform").ajaxSubmit({ 
                        url: '../server/e-upload.php',
                        success: function(data) { // вернется либо '...строка', либо '$$$строка'
                            //alert(data);
                            $('#errorText').fadeIn(700).html('Ваше событие благополучно отправлено! :)');
                            if (data.substr(0,3) == '$$$') {//если начинается с $$$ -> то это имя файла, иначе - ошибка
                                data = data.substr(3); //берем подстроку, начиная с 4 символа
                                var filename = 'http://beoncity.com/uploads/' + data; //генерируем путь к картинке
                                ajax.post('/server/photo2event.php', { id: $('#fileid').val(), name: filename }, null);
                                // отправили картинку посту, который добавит ее к записи в EVENTS с указанным id
                            }
                            else { // на сервере обнаружена ошибка
                                data = data.substr(3);
                                $('#errorText').fadeIn(700).html(data + 'Загрузите, пожалуйста, изображение в одном из указанных форматов: png, jpg или jpeg.');
                            }
                        }
                    });
                    hideBlock();
                });
            }
            else { // если формат файла не допустим
                $('#errorText').fadeIn(700).html('Файл с расширением ' + fileName.split('.')[1] + ' невозможно загрузить.');
                hideBlock();
                return false;
            }
        }
    });

    $('#chooseImg').bind('click', function(){
        $('#userfile').click(); // иммитируем нажатие на кнопку 'choose file', ибо ее нельзя кастомно разукрасить
    });


    $('#eventdesc').focus(function(){ // анимашка - чтобы блок для ввода описания события свормачивался и разворачивался
        $('#eventdesc').animate({
            'height': '100px'
        }, 300);
    });

    $('#eventdesc').focusout(function(){ // анимашка - чтобы блок для ввода описания события свормачивался и разворачивался
        $('#eventdesc').animate({
            'height': '18px'
        }, 300);
    });
    
    $('#cancel').bind('click',function(){ // отмена адреса (не подтвержден)
        $('#errorText').css('display','none');
        $('#controlls').css('display','none');
    });

    // bind 'myForm' and provide a simple callback function 
    $('#uploadform').ajaxForm();

    function hideBlock(){ setTimeout(fo, 5000); }
    function fo(){ $('#errorText').fadeOut(3000); }

});