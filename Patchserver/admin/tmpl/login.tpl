<!DOCTYPE html>
<html>
	<head>
		<title>Patcher - Login</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/login.css" />
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/jquery-ui.js" type="text/javascript"></script>
		<script src="js/login.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="center">
			<div id="title">Patcher - Login</div>
			<center>
				<div id="box">
					<div id="box_content">
						<div id="load"></div>
						<form action="index.php" method="post">
							Benutzername:<br>
							<input type="text" id="Username" onkeydown="if (event.keyCode == 13) DoLogin()"><br><br>
							Passwort:<br>
							<input type="password" id="Password" onkeydown="if (event.keyCode == 13) DoLogin()">
							<br><br>
							<div class="submit"><a href="javascript:DoLogin()">Einloggen</a></div>
						</form>
					</div>
				</div>
			</center>
		</div>
	</body>
</html>