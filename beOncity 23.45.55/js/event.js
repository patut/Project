function del(commid){
    if (confirm("Вы точно хотите удалить этот комментарий?")) {
        ajax.post('/server/delcom.php', { id: commid }, function(data){
            if(data=="ok") {
                var num = parseInt($('#num').html(),10) - 1;
                var out = '';
                if (num == 1) out = 'Ответов: <span id="num">1</span>';
                else out = 'Ответов: <span id="num">' + num + '</span>';
                if (num == 0) {
                    $('#nocomments').fadeIn(250);
                    $('#footer').fadeIn(250);
                }
                $('#commN').html(out);
                $('#comm'+commid).remove();
            }
            else alert(data);
        });
    } else {
        return false;
    }
}
function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
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
$(document).ready(function(){
    $('#publish').bind('click', function(){
        if ($.trim($('#neweventtip').val()) == '') return false;

        $('#nocomments').fadeOut(250);
        $('#footer').fadeOut(250);
        ajax.post('/server/comment.php', { author_id: usrid, event_id: evntid, text: $('#neweventtip').val(), img: usrimg, name: usrname }, function(data){
            //alert(data);
            var num = parseInt($('#num').html(),10) + 1;
            var out = '';
            if (num == 1) out = 'Ответов: <span id="num">1</span>';
            else out = 'Ответов: <span id="num">' + num + '</span>';
            $('#commN').html(out);
            
            $('#neweventtip').val('');
            $('#neweventtip').animate({
                'height': '18px'
            }, 300);
            $('#commentline').prepend(data);
        });
    });
    $('#neweventtip').focus(function(){ // анимашка - чтобы блок для ввода описания события свормачивался и разворачивался
        $('#neweventtip').animate({
            'height': '70px'
        }, 300);
    });
    $('#neweventtip').focusout(function(){ // анимашка - чтобы блок для ввода описания события свормачивался и разворачивался
        if ($('#neweventtip').val() == '') {
            $('#neweventtip').animate({
                'height': '18px'
            }, 300);
        }
    });
});