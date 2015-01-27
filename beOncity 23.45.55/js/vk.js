VK.init({apiId: 3788673});
function authInfo(response) {
	if (response.session) {
		var uid=response.session.mid;
		VK.Api.call('users.get', {uids: uid, fields: 'city, country, photo_max_orig'}, function(data) {
			if(data.response) {
				var first_name=data.response[0].first_name;
				var last_name=data.response[0].last_name;
				var photo_max_orig=data.response[0].photo_max_orig;
				var cityId=data.response[0].city;
				var countryId=data.response[0].country;
				uid='vk-'+uid;
				ajax.post("server/authvk.php", { uid: uid, name: first_name, surname: last_name, photo_max_orig: photo_max_orig, country: countryId, city: cityId },
				function(data) { if (data=="ok") document.location.href = "http://beoncity.com/"; else alert(data);});
			}
		});
	}
}