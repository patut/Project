var ajax = new Ajax();

function Ajax() {
    return {
        _createXMLHttp: function() { //инициализация объекта
            var xmlHttp = null;  //если XMLHttpRequest определен, создаем объект и возвращаем его
            if (typeof(XMLHttpRequest) != undefined) {
                xmlHttp = new XMLHttpRequest;
                return xmlHttp;
                //если доступно window.ActiveXObject, тогда мы столкнулись с IE...
                //всвязи с этим нужно создать новый XMLHttp объект
            } 
            else if (window.ActiveXObject) {
                var ieXMLHttpVersions = ['MSXML2.XMLHttp.5.0', 'MSXML2.XMLHttp.4.0', 'MSXML2.XMLHttp.3.0', 'MSXML2.XMLHttp', 'Microsoft.XMLHttp'];
                //в этом масиве перечислены все последние версии MSXML2 в порядке возрастания возраста
                //пробуем создать объект, если вылетает эксепшн, ловим его и.. и ничего не делаем :)
                for (var i=0; i <ieXMLHttpVersions.length; i++) {
                    try {
                        xmlHttp = new ActiveXObject(ieXMLHttpVersions[i]);
                        return xmlHttp;
                    } catch (e) {}
                }
            }
        },
        jsonQuery: function(url) { // читает весь ответ в одну строку - на клиенте задекодить из JSON
            var req = null;
            try { req = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {
                try { req = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {
                    try { req = new XMLHttpRequest(); } catch(e) {}
                }
            }
            if (req == null) throw new Error('XMLHttpRequest not supported');
            req.open("GET", url, false);
            req.send(null);
            return req.responseText;
        },
        get: function(url) {
            var xmlHttp = this._createXMLHttp(); // вызов через объект, не через класс, потому что через класс вызвать не получится
            xmlHttp.open('get', url, true);
            xmlHttp.send(null);
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState === 4) {
                    if (xmlHttp.status === 200) {
                        alert(xmlHttp.responseText);
                    } 
                    else {
                        alert('Error: ' + xmlHttp.responseText);
                    }
                } else {
                    //до сих пор загружается
                }
            }
        },
        post: function(url, query, action) {
            if (url.substr(0, 1) != '/') url = '/' + url;
            if (typeof(query) != 'object') return false;
            
            var xmlHttp = this._createXMLHttp();
            xmlHttp.open('post', url, true);
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            xmlHttp.onreadystatechange = function() { //при изменении состояния выполнять эту функцию..
                if (xmlHttp.readyState == 4) { //запрос отправлен и ответ получен
                    if (action != null) action(xmlHttp.responseText); //выполняем указанную в параметрах функцию
                }
            }

            //формирование post запроса из элементов формы
            var dataArray = [];
            for (var q in query) {
                var encodedData = encodeURIComponent(q);
                encodedData += "=";
                encodedData += encodeURIComponent(query[q]);
                dataArray.push(encodedData);
            }
            //отправка запроса
            xmlHttp.send(dataArray.join("&"));
        }
    } 
}