<div id="loginform">
	<div class="title">Авторизация</div>
	<div class="field" id="emailField"><input type="email" id="email" placeholder="Email"></div>
	<div class="field" id="passField"><input type="password" id="pass" placeholder="Пароль"></div>
	<div class="button" id="signin">Войти</div>
	<div class="button" id="signup">Регистрация</div>	
	<div id="loginerror" style="margin:10px 15px"></div>
	<div id="social">
		<div id="centeredS">
			<div class="text">Войти через:</div>
			<div class="fl_l" id="vk" onclick="VK.Auth.login(authInfo)"><img src="/img/vk.png"></div>
			<div class="fl_l" id="fb"><img src="/img/fb.png"></div>
			<div style="clear:both"></div>
		</div>
	</div>
</div>