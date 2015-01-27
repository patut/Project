var map;
var selected_event;
var currentPosition;
var tempInfoBox;


if (MAC) {
    document.getElementById('mapcontainer').style.height = '543px';
    document.getElementById('events').style.height = '543px';
    document.getElementById('map').style.height = '568px';
}
if (MOBILE_SAFARI) {
    document.getElementById('mapcontainer').style.height = '563px';
    document.getElementById('events').style.height = '563px';
    document.getElementById('map').style.height = '588px';
}
google.maps.event.addDomListener(window, 'load', GetEvents);

function GenRandPoints(){
    var maxLng = allowedBounds.getNorthEast().lng();
    var minLng = allowedBounds.getSouthWest().lng();
    var maxLat = allowedBounds.getNorthEast().lat();
    var minLat = allowedBounds.getSouthWest().lat();
    for (var i=0;i<50;i++){
        var lat = Math.random() * (maxLat - minLat) + minLat;//min=-85 max=85
        var long = Math.random() * (maxLng - minLng) + minLng;//min=-180 max=180
        var title = "Point"+(i+1);
        ajax.post('../server/newpoint.php', { 
            title: title, 
            lat: lat, 
            long: long }, 
            function(data){alert(data)} 
        );
    }
    alert("done");
}
function GetEvents(){
    var events = new Array();
    var jsonString;
    ajax.post('../server/getevents.php',null,
        function(data){
            var events = JSONtoEvents(data);
            showEvents(events);
        });
}
function JSONtoEvents(jsonString){
    var events = Array();
    var jsonData = JSON.parse(jsonString);
    for (var i=0; i<jsonData.data.length;i++){
        if (i == 20) break; // показываем ТОП 8
        var event = jsonData.data[i];
        var eventArr = Array();
        eventArr.push(event.latitude,event.longitude,event.id,event.title,event.desc,event.loc_ru,event.loc_en,event.img,event.filter,event.author_id);
        events.push(eventArr);
    }
    return events;
}

function showEvents(events){
    for (var i = 0; i < events.length; i++) {
        (function(i){
            
            //if (language == "en-US") { address = events[i][6] }
            //else { 
            address = events[i][5];
              //  if (address == null) address = events[i][6] ;
            //}
            
            var Latlng = new google.maps.LatLng(events[i][0], events[i][1]);
            var title = events[i][3];
            var desc = events[i][4];
            var ava = events[i][7];
            var filter = events[i][8];
            var author_id = events[i][9];
            var marker = new google.maps.Marker({
                position: Latlng,
                map: map,
                title: title,
                id: events[i][2]
            });
            var pinIcon = new google.maps.MarkerImage(
                '../img/pins/' + filter + '.png',
                null, /* size is determined at runtime */
                null, /* origin is 0,0 */
                null, /* anchor is bottom center of the scaled image */
                new google.maps.Size(48, 56) //48,56
            );  
            marker.setIcon(pinIcon);



            /* ИНФО БЛОКИ НАД ТОЧКАМИ */
            //infoBox
            var boxText = document.createElement("div");
            boxText.setAttribute("class","infoBox");
            var event_url="http://beoncity.com/event/id"+marker.id;    
            boxText.innerHTML = '<div class="imgContainer fl_l" onclick="window.location.href=\''+event_url+'\';"><img src="' + ava + '"></div><div class="info" onclick="window.location.href=\''+event_url+'\';"><p class="title">' + title + '</p>       <div class="location">' + address + '</div><p class="type">' + filter + '</p><p class="description">' + desc + '</p></div>';

            var myOptions = {
                content: boxText,
                disableAutoPan: false,
                maxWidth: 0,
                pixelOffset: new google.maps.Size(-160, -200),
                zIndex: null,
                boxStyle: {
                    background: "url('tipbox.gif') no-repeat",
                    width: "380px"
                },
                closeBoxMargin: "-10px -7px 2px 2px",
                closeBoxURL: "http://beoncity.com/img/close.png",
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: false,
            };
            var ib = new InfoBox(myOptions);
            /*----------------------------------------*/

            
            var div = document.createElement("div");
            div.setAttribute("id", title);
            div.setAttribute("class", "mapevent");

            // блок с картинкой
            var divimg = document.createElement("div");
            divimg.setAttribute("class", "image fl_l");

            var img = document.createElement("img");
            img.setAttribute("src", ava);
            img.setAttribute("title", title);
            img.setAttribute("alt", title);

            var over = document.createElement("div");
            over.setAttribute("class", "over fl_r");
            over.appendChild(img);

            divimg.appendChild(over);
            //------------------

            div.appendChild(divimg);

            // блок с информацией о событии
            var info = document.createElement("div");
            info.setAttribute("class", "info fl_l");

            var eventtitle = document.createElement("div");
            eventtitle.setAttribute("class", "title");
            eventtitle.appendChild(document.createTextNode(title));

            var eventaddress = document.createElement("div");
            eventaddress.setAttribute("class", "address");
            eventaddress.appendChild(document.createTextNode(address));

            var eventaction = document.createElement("div");
            eventaction.setAttribute("class", "action fl_r");

            var like = document.createElement("div");
            like.setAttribute("class", "likeevent fl_l");
            like.appendChild(document.createTextNode("ПОЙДУ"));

            var bookmark = document.createElement("div");
            bookmark.setAttribute("class", "bookmark fl_l");
            bookmark.appendChild(document.createTextNode("БЫЛ ТУТ"));

            var clearfix = document.createElement("div");
            clearfix.setAttribute("class", "clearfix");

            eventaction.appendChild(like);
            eventaction.appendChild(bookmark);
            eventaction.appendChild(clearfix);

            info.appendChild(eventtitle);
            info.appendChild(eventaddress);
            info.appendChild(eventaction);
            info.appendChild(clearfix);
            
            //------------------------------------

            div.appendChild(info);

            //блок с кнопкой
            var button = document.createElement("div");
            button.setAttribute("class", "arrow fl_l");
            var a = document.createElement("a");
            a.setAttribute("href","http://beoncity.com/event/id"+marker.id);

            var button_img = document.createElement("img");
            button_img.setAttribute("class", "fl_r");
            button_img.setAttribute("src", "/img/arrow.png");

            a.appendChild(button_img);
            button.appendChild(a);

            div.appendChild(button);
            div.appendChild(clearfix);            
            document.getElementById("events").appendChild(div);

            //------------------------------------
            
            /*
            $(document).on("click", like, willgo(marker.id,author_id));
            $(document).on("click", bookmark, havebeen(marker.id,author_id));
            */
            google.maps.event.addListener(marker, 'click', function(){

                //выделение события в списке по клику на маркер
                if (selected_event!=null) selected_event.style.backgroundColor='transparent';
                selected_event = document.getElementById(title);
                selected_event.style.backgroundColor="rgba(255,195,131,.4)";
                
                //открытие инфобокса по клику на маркер
                if (tempInfoBox != null) tempInfoBox.close();
                ib.open(map,marker);
                tempInfoBox = ib;
                /*
                $(document).on("click", ".infoBox", function(){
                    alert("lol");
                    window.location.replace("http://beoncity.com/event/id"+marker.id);
                });
                */
                //ценрирование
                //map.setCenter(marker.position);
                
                //scroll
                selected_event.parentNode.scrollTop = selected_event.offsetTop-150;

                var BoxHeight = boxText.offsetHeight;
                ib.setOptions({pixelOffset: new google.maps.Size(-70, -BoxHeight-180)});
            });
            divimg.addEventListener("click", function(){                
                if (selected_event!=null) selected_event.style.backgroundColor='transparent';
                selected_event = document.getElementById(title);
                selected_event.style.backgroundColor="rgba(255,195,131,.4)";

                //открытие инфобокса по клику на маркер
                if (tempInfoBox != null) tempInfoBox.close();
                ib.open(map,marker);
                tempInfoBox = ib;
                

                
                //ценрирование
                map.setCenter(marker.position);

                map.setCenter(Latlng);
                if (marker.getAnimation() != null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    setTimeout(function(){ marker.setAnimation(null); }, 750);
                }
            });
            eventtitle.addEventListener("click", function(){                
                if (selected_event!=null) selected_event.style.backgroundColor='transparent';
                selected_event = document.getElementById(title);
                selected_event.style.backgroundColor="rgba(255,195,131,.4)";

                //открытие инфобокса по клику на маркер
                if (tempInfoBox != null) tempInfoBox.close();
                ib.open(map,marker);
                tempInfoBox = ib;
                
                //ценрирование
                map.setCenter(marker.position);

                map.setCenter(Latlng);
                if (marker.getAnimation() != null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    setTimeout(function(){ marker.setAnimation(null); }, 750);
                }
            });
            eventaddress.addEventListener("click", function(){                
                if (selected_event!=null) selected_event.style.backgroundColor='transparent';
                selected_event = document.getElementById(title);
                selected_event.style.backgroundColor="rgba(255,195,131,.4)";

                //открытие инфобокса по клику на маркер
                if (tempInfoBox != null) tempInfoBox.close();
                ib.open(map,marker);
                tempInfoBox = ib;
                
                //ценрирование
                map.setCenter(marker.position);

                map.setCenter(Latlng);
                if (marker.getAnimation() != null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    setTimeout(function(){ marker.setAnimation(null); }, 750);
                }
            });/*
            like.addEventListener("click",willgo(marker.id,author_id));
            bookmark.addEventListener("click",havebeen(marker.id,author_id));
            */
            like.addEventListener("click", function(){                
                willgo(marker.id,usr);
            });
            bookmark.addEventListener("click", function(){                
                havebeen(marker.id,usr);
            });
        })(i);
    }
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