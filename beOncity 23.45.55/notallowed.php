<div id="notallowed" class="popupbox">
	Чтобы воспользоваться данной функцией вы должны зарегистрироваться.
	<div id="register">
		<section id="signupbox">
			<div id="signup-title">Регистрация</div>
			<input type="text" id="new_name" placeholder="Отображаемое имя" class="field">
			<input type="email" id="new_email" placeholder="Ваш email адрес" class="field">
			<input type="password" id="new_pass" placeholder="Пароль" class="field">
			<div class="button" id="sign_up_send">Готово</div>
			<div id="error"></div>
		</section>
	</div>
	<div id="loginform">
		<div class="title">Авторизация</div>
		<div class="field" id="emailField"><input type="email" id="email" placeholder="Email"></div>
		<div class="field" id="passField"><input type="password" id="pass" placeholder="Пароль"></div>
		<div class="button" id="signin">Войти</div>
		<div id="social">
			<div id="centeredS">
				<div class="text">Войти через:</div>
				<div class="fl_l" id="vk" onclick="VK.Auth.login(authInfo)"><img src="/img/vk.png"></div>
				<div class="fl_l" id="fb"><img src="/img/fb.png"></div>
				<div style="clear:both"></div>
			</div>
		</div>
	</div>
	<section id="fadeBlock"></section>
</div>