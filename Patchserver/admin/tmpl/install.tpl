<!DOCTYPE html>
<html>
	<head>
		<title>Patcher - Installation</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="js/jquery.js" type="text/javascript"></script>
		<style type="text/css">
			body
			{
				background-color:#696969;
				margin:0;
				font-family: arial, verdana, sans-serif;
			}

			#center
			{
				text-align:center;
			}

			#title
			{
				color:#E3E3E3;
				font-size:35px;
				text-shadow: 4px 4px 4px #636363;
				filter: dropshadow(color=#636363, offx=4, offy=4);
			}

			#box
			{
				width:500px;
				min-height:180px;
				background-color:#fdfffa;
				border:1px solid #121212;
				margin:0 auto;
				margin-top:10px;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
				-webkit-box-shadow: 4px 4px 4px 0px #575757;
				box-shadow: 4px 4px 4px 0px #575757;
			}

			#box_content
			{
				padding:10px;
			}

			input[type=text], input[type=password]
			{
				border:1px solid #9F9F9F;
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
				outline: none;
				text-align:center;
			}

			.submit
			{
				background: #8E8E8E;
				background: -moz-linear-gradient(top,  #8E8E8E 0%, #666666 100%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#8E8E8E), color-stop(100%,#666666));
				background: -webkit-linear-gradient(top,  #8E8E8E 0%,#666666 100%);
				background: -o-linear-gradient(top,  #8E8E8E 0%,#666666 100%);
				background: -ms-linear-gradient(top,  #8E8E8E 0%,#666666 100%);
				background: linear-gradient(to bottom,  #8E8E8E 0%,#666666 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8E8E8E', endColorstr='#666666',GradientType=0 );
				width:170px;
				height:30px;
				margin:0 auto;
				-webkit-border-radius: 5px;
			}

			.submit a
			{
				padding:5px;
				font-size:18px;
				display:block;
				color:#DDDDDD;
				text-decoration:none;
			}

			.submit a:visited
			{
				padding:5px;
				font-size:18px;
				display:block;
				color:#DDDDDD;
				text-decoration:none;
			}

			.submit a:hover
			{
				padding:5px;
				font-size:18px;
				display:block;
				color:#D2D2D2;
				text-decoration:none;
			}

			.submit:hover
			{
				background: #5f8db3;
				background: -moz-linear-gradient(top,  #5f8db3 0%, #1271b5 99%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#5f8db3), color-stop(99%,#1271b5));
				background: -webkit-linear-gradient(top,  #5f8db3 0%,#1271b5 99%);
				background: -o-linear-gradient(top,  #5f8db3 0%,#1271b5 99%);
				background: -ms-linear-gradient(top,  #5f8db3 0%,#1271b5 99%);
				background: linear-gradient(to bottom,  #5f8db3 0%,#1271b5 99%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5f8db3', endColorstr='#1271b5',GradientType=0 );
			}

			.succes
			{
				background-color:#060;
				border:#0C0 1px solid;
				color:#FFF
			}

			.error
			{
				background-color:#900;
				border:#F00 1px solid;
				color:#FFF;
			}

			fieldset {
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
				width:440px;
				text-align:center;
				margin-bottom:5px;
			}
		</style>
		<script type="text/javascript">
			function StartInstall()
			{
				$("#content").html("Installing Database...<br><img src=\"img/ajax-loader.gif\">");
				
				$.ajax({
					url: "install.php?ajax&install=db"
				}).done(function(response)
				{
					if (response != "0")
					{
						$("#content").html("<fieldset class=\"error\">Error on installing database.</fieldset>");
					}
					else
					{
						InstallGroups();
					}
				});
			}
			
			function InstallGroups()
			{
				$("#content").html("Installing Groups...<br><img src=\"img/ajax-loader.gif\">");
				
				$.ajax({
					url: "install.php?ajax&install=groups"
				}).done(function(response)
				{
					if (response != "0")
					{
						$("#content").html("<fieldset class=\"error\">Error on installing Groups.</fieldset>");
					}
					else
					{
						InstallRights();
					}
				});
			}
			
			function InstallRights()
			{
				$("#content").html("Installing Rights...<br><img src=\"img/ajax-loader.gif\">");
				
				$.ajax({
					url: "install.php?ajax&install=rights"
				}).done(function(response)
				{
					if (response != "0")
					{
						$("#content").html("<fieldset class=\"error\">Error on installing Rights.</fieldset>");
					}
					else
					{
						CreateAdmin();
					}
				});
			}
			
			function CreateAdmin()
			{
				$("#content").html("Create Admin...<br><img src=\"img/ajax-loader.gif\">");
				
				$.ajax({
					url: "install.php?ajax&install=admin"
				}).done(function(response)
				{
					if (response != "0")
					{
						$("#content").html("<fieldset class=\"error\">Error on creating Admin.</fieldset>");
					}
					else
					{
						FinishInstalling();
					}
				});
			}
			
			function FinishInstalling()
			{
				$("#content").html("Installation is completed...<br><img src=\"img/ajax-loader.gif\">");
				
				$.ajax({
					url: "install.php?ajax&install=install"
				}).done(function(response)
				{
					if (response != "0")
					{
						$("#content").html("<fieldset class=\"error\">Failed to complete installation.</fieldset>");
					}
					else
					{
						$("#content").html("Patcher Administration was successfully installed. Please remove install.php and tmpl/install.tpl<br><b>Username:</b> admin<br><b>Passwort:</b> admin123<br><a href=\"index.php\">Login</a>");
					}
				});
			}
		</script>
	</head>
	<body>
		<div id="center">
			<div id="title">Patcher - Installation</div>
			<div id="box">
				<div id="box_content">
					<form action="index.php" method="post">
						{foreach from=$Rights item=Value key=Right}
							{if $Value ne "777"}
								<fieldset class="error">
									The directory/file "{$Right}" is not writeable.
								</fieldset>
							{/if}
						{/foreach}
						<div id="content" style="margin-top:50px;">
							<div class="submit"><a href="javascript:StartInstall();">Install</a></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>