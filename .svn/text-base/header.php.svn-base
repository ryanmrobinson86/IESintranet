<a href="/"><img src="/img/ies.png" height="70"></a>
<nav id="mainNav">
	<ul>
		<?php if(isset($_COOKIE['username']) && isset($_COOKIE['userLevel'])){ ?>
			<li><a href="/dept/software/">Software</a></li>
			<?php if($_COOKIE['userLevel'] == 15){?>
				<li><a href="/admin">Admin</a></li>
			<?php }
		} ?>
	</ul>
</nav>
<div id="loginBox">
	<span id="loginLogin" class="loginContent" onclick="processLogin()"></span>
	<span id="loginLogout" class="loginContent" onclick="processLogout()"></span>
</div>
<div id="loginBoxForm">
	<form id="login" action="/scripts/login.php" method="post">
		<fieldset>
			<input class="textField" type="text" name="userName" placeholder="user">
			<input class="textField" type="password" name="userPwd" placeholder="password">
			<input type="submit" value="login">
		</fieldset>
	</form>
	<span id="loginCancel" class="loginContent" onclick="hideLogin()">Cancel</span>
</div>
