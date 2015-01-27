$(document).ready(function(){init()});
$(window).resize(function(){changeHeight()});
var dots, events;
function init(){
    dots = $(".dots");
    events = $(".events");
    changeHeight();
}
function changeHeight(){
    heightEqualWidth($(".photo_1"));
    heightEqualWidth($(".photo_2"));
    heightEqualWidth($(".photo_3"));
    $(".photo_2_3").css({"height" : $(".photo1_wrap").height() + "px"});
    var h_photos_block = $(".profile_photos").height() - $(".profile_photos .settings_2").height();
    var margin_top = parseInt($(".profile_description .profile_pict").css("margin-top"));
    $(".profile_description .profile_pict_wrap").css({"height" : h_photos_block + "px"});
    $(".profile_description .profile_about article").css({"font-size" :  17 + "px"});
    while ($(".profile_description .profile_about").height() + 20 >  $(".profile_description .profile_pict_wrap").height()){
        $(".profile_description .profile_about article").css({"font-size" :  parseInt($(".profile_description .profile_about article").css("font-size")) - 1 + "px"});
    }
    widthEqualHeight($(".profile_description .profile_pict"));


    if ($(window).width() < 1280){
        dots.attr("class", "min_dots block");
        events.attr("class", "min_events block");
    }
    else{
        dots.attr("class", "dots block");
        events.attr("class", "events block");
    }

}
function heightEqualWidth(element){
    var needed_height = element.width();
    element.css({"height" : needed_height + "px"});
}
function widthEqualHeight(element){
    var needed_width = element.height();
    element.css({"width" : needed_width + "px"});
}

