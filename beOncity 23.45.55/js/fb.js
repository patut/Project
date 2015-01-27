var button;
window.fbAsyncInit = function() {
	FB.init({ appId: '402647949841091',
	status: true, 
	cookie: true,
	xfbml: true,
	oauth: true});

	function updateButton(response) {
		button = document.getElementById('fb');
		
		//  if (response.authResponse) {
		//	//user is already logged in and connected
		//	FB.api('/me', function(info) {
		//		login(response, info);
		//	});
		//} else 
		//{
		//user is not connected to your app or logged out
		button.onclick = function() {
			FB.login(function(response) {
				if (response.authResponse) {
					FB.api('/me', function(info) {
						login(response, info);
						pol = info['gender'];
					}); 
					FB.api('/me/picture?type=large', function(loool) {
						i = loool['data'];
						k = i['url'];
					});
				} else {}
			}, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'}); 
		}
		//}
	}

	// run once with current status and whenever the status changes
	FB.getLoginStatus(updateButton);
	FB.Event.subscribe('auth.statusChange', updateButton); 
};
(function() {
	var e = document.createElement('script'); e.async = true;
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
	}());
function login(response, info){
	if (response.authResponse) {
		document.location.href = "server/authfb.php?id=fb-"+info.id+"&name="+info.first_name+"&surname="+info.last_name+"&email="+info.email+"&avatar="+k;
		/*
		$.post("http://hangukme.com/server/fb_auth.php", 
			{ 
				id: info.id, 
				name: info.first_name, 
				surname: info.last_name, 
				email: info.email, 
				avatar: k
			},
			function(data) { 
				if (data=="ok") alert("ok"); 
				else alert(data);
			}
		);
		*/
		// и сразу разлогиниться, чтобы не было циклического перенаправления
		//FB.logout(function(response) { logout(response); });
	}
}