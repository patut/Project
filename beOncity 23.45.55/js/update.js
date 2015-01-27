var map;
var MYmarker;
var selected_event;
var geostatus;


/* MAP STYLING */
var myLatlng = new google.maps.LatLng(55.751849391735284,37.61924743652344);
var styles = [
    { featureType: 'road', elementType: 'labels.icon', stylers: [ {visibility: 'off'} ] },
    { featureType: 'road', elementType: 'geometry.fill', stylers: [ {color: "#F7F7F7"} ] },
    { featureType: 'road', elementType: 'geometry.stroke', stylers: [ {color: "#C7C7C7"} ] },
    { featureType: 'road', elementType: 'labels.text.stroke', stylers: [ {color: "#ffffff"} ] },
    { featureType: 'landscape.natural', elementType: 'geometry', stylers: [ {color: "#C8D4BF"} ] },
    { featureType: 'landscape.man_made', elementType: 'geometry.fill', stylers: [ {color: "#D4CABC"} ] },
    { featureType: 'landscape.man_made', elementType: 'geometry.stroke', stylers: [ {color: "#6F5E47"} ] },
    { featureType: 'transit.station', elementType: 'labels', stylers: [ {visibility: 'simplified'} ] }
]
var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});
var myOptions = {
    zoom: 12,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    streetViewControl: false,
    mapTypeControl: false
}
map = new google.maps.Map(document.getElementById("map"), myOptions);
map.mapTypes.set('map_style', styledMap);
map.setMapTypeId('map_style');
lastValidCenter = map.getCenter();//temp допустимого центра
google.maps.event.addListener(map, 'zoom_changed', function() {//ограничиваем зум
    if (map.getZoom() < minZoomLevel) map.setZoom(minZoomLevel);
});

google.maps.event.addDomListener(window, 'load', initGeo);

function initGeo(){
    map.setCenter(myLatlng); // центр Москвы (а вообще - города по языку в браузере, наверное, должен быть)

    CITYmarker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        draggable: true
    });
    var pinIcon = new google.maps.MarkerImage(
        '../img/icons/drag.png',
        null, /* size is determined at runtime */
        null, /* origin is 0,0 */
        null, /* anchor is bottom center of the scaled image */
        new google.maps.Size(48, 56)
    );  
    CITYmarker.setIcon(pinIcon);

    /*------------ INFO WINDOW ------------*/
    var contentString = '<div id="infowindow">Этот маркер указывает на центр города. Перетащите его в нужную точку на карте и адрес появится в форме отправки события.</div>';
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
    google.maps.event.addListener(CITYmarker, 'click', function() {
        infowindow.open(map,CITYmarker);
    });
    /*-------------------------------------*/

    if (CITYmarker.getAnimation() != null) {
        CITYmarker.setAnimation(null);
    } else {
        CITYmarker.setAnimation(google.maps.Animation.BOUNCE);
        setTimeout(function(){ CITYmarker.setAnimation(null); }, 750);
    }

    google.maps.event.addListener(CITYmarker, 'dragend', function() {
        var p = CITYmarker.getPosition();
        //document.getElementById('eventloc').value = 'lat: ' + p.lat() + '; lon: ' + p.lng();
        s = getPointData('latlng', p.lat()+','+p.lng(), 'ru');
        s = s.charAt(0).toUpperCase() + s.substr(1).toLowerCase();
        document.getElementById('eventloc').value = s;
        document.getElementById('coords').innerHTML = p.lat() + ',' + p.lng();
        newlat = p.lat();
        newlong = p.lng();
        infowindow.close();
        //alert('lat: ' + p.lat() + '; lon: ' + p.lng());
        //http://maps.googleapis.com/maps/api/geocode/json?latlng=55.75320193022759,37.61922086773683&sensor=false&language=ru
    });

    infowindow.open(map,CITYmarker);
}

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
    /*for (var i = 0; i < jsonRU.results[0].address_components.length; i++) {
        var addr = jsonRU.results[0].address_components[i];
        if (addr.types[0] == 'postal_code'){
            var postal_code = addr.short_name;
            alert(postal_code);
            if (addressRU.indexOf(postal_code)<0) break;
            addressEN = addressEN.substring(0,addressEN.indexOf(postal_code)-2);
            addressRU = addressRU.substring(0,addressRU.indexOf(postal_code)-2);            
        }
    }
    alert(addressRU);
    */
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

    $("#datepicker").datetimepicker({ dateFormat: "MM dd, yy  " });

    //Dropdown plugin data
    var ddData = [
        { text: "Музыка", key: "music", value: 1, selected: false, description: "Концерты, фестивали", imageSrc: "/img/icons/music.png" },
        { text: "Танцы", key: "dance", value: 2, selected: false, description: "Танцы, выступления", imageSrc: "/img/icons/dance.png" },
        { text: "Культура", key: "culture", value: 3, selected: false, description: "Театры, музеи, выставки", imageSrc: "/img/icons/culture.png" },
        { text: "Активный отдых", key: "activity", value: 4, selected: false, description: "Спорт, ролики, прогулки", imageSrc: "/img/icons/activity.png" },
        { text: "Экстрим", key: "extreme", value: 5, selected: false, description: "Паркур, скейтбординг", imageSrc: "/img/icons/extreme.png" },
        { text: "Жизнь", key: "life", value: 6, selected: false, description: "Дни рождения, пикники", imageSrc: "/img/icons/life.png" },
        { text: "Разное", key: "other", value: 7, selected: false, description: "Разные события", imageSrc: "/img/icons/other.png" },
        { text: "Романтика", key: "romantic", value: 8, selected: false, description: "Встречи, свидания", imageSrc: "/img/icons/romantic.png" },
        { text: "Флешмоб", key: "flashmob", value: 9, selected: false, description: "Флешмобы, митинги", imageSrc: "/img/icons/flashmob.png" }
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
        fileName = $('#userfile').val();

        //проверка на валидность полей
        if (eventType == '') {
            $('#errorText').fadeIn(700).html("Какая категория ближе к Вашему событию?");
            hideBlock();
            return;
        }
        else if (eventTitle == '') {
            $('#errorText').fadeIn(700).html("Придумайте название Вашему мероприятию.");
            hideBlock();
            return;
        }
        else if (eventLocation == '') {
            $('#errorText').fadeIn(700).html("Где будет происходить событие?");
            hideBlock();
            return;
        }
        else if (eventTime == '') {
            $('#errorText').fadeIn(700).html("Когда все начнется?");
            hideBlock();
            return;
        }
        else if (desc == '') {
            $('#errorText').fadeIn(700).html("Пожалуйста, расскажите нам что-нибудь о Вашем событии.");
            hideBlock();
            return;
        }
        else if (fileName == '' || fileName == undefined) {
            $('#errorText').fadeIn(700).html('Вы не выбрали изображение.');
            hideBlock();
            return false;
        }
        
        //получаем из гугла по запросу данные о точке
        address = getPointData('address', eventLocation , 'ru'); // eventLocation ; [language] в случае en возвращают en-US -> надо найти список всех значений language от navigator
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
        /*fileName = $('#userfile').val();
        if (fileName == '' || fileName == undefined) { //если картинку не выбрали
            
            ajax.post('/server/newevent.php', { title: eventTitle, author: $('#userid').html(), desc: desc, ru: addressRU, en: addressEN, lat: newlat, long: newlong, date: eventTime, filter: eventType }, function(data){
                //alert(data);
                $('#errorText').fadeIn(700).html('Ваше событие благополучно отправлено.');
                hideBlock(); // все равно отправляем, ибо картинка не обязательна
            });
            $('#errorText').fadeIn(700).html('Вы не выбрали изображение.');
            hideBlock();
            return false;
        }
        else { // если картинку выбрали */
            fileName = $('#userfile').val();
        ext = fileName.split(".")[1].toUpperCase(); // получаем расширение выбранного файла
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