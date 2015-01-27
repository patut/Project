function del(eventid){
    if (confirm("Вы точно хотите удалить это событие?")) {
        ajax.post('/server/del.php', { id: eventid }, function(data){
            if(data=="ok") {
                $('#post'+eventid).remove();
            }
            else alert(data);
        });
    } else {
        return false;
    }
}
function toevent(id) { document.location.href = '/event?id=' + id; }