/* CHECK IF BAD BROWSER */
var IE7 = (document.all && !window.opera && window.XMLHttpRequest && navigator.userAgent.toString().toLowerCase().indexOf('trident/4.0') == -1) ? true : false;
var IE8 = (navigator.userAgent.toString().toLowerCase().indexOf('trident/4.0') != -1);
var IE9 = navigator.userAgent.toString().toLowerCase().indexOf("trident/5") > -1;
var IE10 = navigator.userAgent.toString().toLowerCase().indexOf("trident/6") > -1;
var OPERA = (navigator.userAgent.toString().toLowerCase().indexOf("opera") >= 0) ? true : false
var SAFARI = (navigator.userAgent.toString().toLowerCase().indexOf("safari") != -1) && (navigator.userAgent.toString().toLowerCase().indexOf("chrome") == -1);
var FIREFOX = (navigator.userAgent.toString().toLowerCase().indexOf("firefox") != -1);
var CHROME = (navigator.userAgent.toString().toLowerCase().indexOf("chrome") != -1);
var MOBILE_SAFARI = ((navigator.userAgent.toString().toLowerCase().indexOf("iphone")!=-1) || (navigator.userAgent.toString().toLowerCase().indexOf("ipod")!=-1) || (navigator.userAgent.toString().toLowerCase().indexOf("ipad")!=-1)) ? true : false;


//Platforms
var MAC = (navigator.userAgent.toString().toLowerCase().indexOf("mac")!=-1) ? true: false;
var WINDOWS = (navigator.appVersion.indexOf("Win")!=-1) ? true : false;
var LINUX = (navigator.appVersion.indexOf("Linux")!=-1) ? true : false;
var UNIX = (navigator.appVersion.indexOf("X11")!=-1) ? true : false;

if (!(CHROME || OPERA || SAFARI || FIREFOX || MOBILE_SAFARI)) document.location.href = "/badbrowser";

/* LANGUAGE */
var language = navigator.browserLanguage || navigator.language || navigator.userLanguage;

if(MOBILE_SAFARI) document.getElementById('topmenu').style.width = '455px';