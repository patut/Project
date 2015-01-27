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
function toevent(id) { document.location.href = '/event?id=' + id; }