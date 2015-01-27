var map;
var MYmarker;
var selected_event;
var geostatus;

var latlng = "no-geo"; //default

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
    zoom: 11,
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