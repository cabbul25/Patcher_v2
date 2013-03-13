<!DOCTYPE html>
<html>
	<head>
		<title id="title_text">Patcher - Administration</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/patcher.css" />
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/jquery-ui.js" type="text/javascript"></script>
		<script src="js/patcher.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="header">
			<div id="header_bg">
				<div id="header_left">
					<div id="title">Patcher</div>
				</div>
				<div id="header_right">
					<div id="header_right_content">
						Angemeldet als {$Username}&nbsp;&nbsp;
						<a href="javascript:ManagePassword()"><img src="img/settings.png" class="header_btn" alt="Settings"></a>
						<a href="javascript:DoLogout()"><img src="img/logout.png" class="header_btn" alt="Logout?"></a>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="menu_box">
			<div class="spacer1_0"></div>
			<div class="spacer1_1"></div>
			{if $Rights["can_manage_files"] eq "1"}
				<div class="menu_btn"><a href="javascript:ManageFiles();">Dateiverwaltung</a></div>
				<div class="spacer2_0"></div>
			<div class="spacer2_1"></div>
			{/if}
			{if $Rights["can_manage_delete_client_files"] eq "1"}
				<div class="menu_btn"><a href="javascript:ManageClientsideDelete();">Clientseitig löschen</a></div>
				<div class="spacer2_0"></div>
				<div class="spacer2_1"></div>
			{/if}
			{if $Rights["can_manage_patchlist"] eq "1"}
				<div class="menu_btn"><a href="javascript:ManagePatchlist();">Patchliste</a></div>
				<div class="spacer2_0"></div>
				<div class="spacer2_1"></div>
			{/if}
			{if $Rights["can_upload_newpatcher"] eq "1"}
				<div class="menu_btn"><a href="javascript:ManagePatcherVersion();">Patcherversion</a></div>
				<div class="spacer2_0"></div>
				<div class="spacer2_1"></div>
			{/if}
			{if $Rights["can_manage_users"] eq "1"}
				<div class="menu_btn"><a href="javascript:ManageUsers();">Benutzerverwaltung</a></div>
				<div class="spacer2_0"></div>
				<div class="spacer2_1"></div>
			{/if}
			{if $Rights["can_manage_groups"] eq "1"}
				<div class="menu_btn"><a href="javascript:ManageGroups();">Gruppenverwaltung</a></div>
				<div class="spacer2_0"></div>
				<div class="spacer2_1"></div>
			{/if}
			<div class="menu_btn"><a href="javascript:ShowInfo();">Info</a></div>
			<div class="spacer3_0"></div>
		</div>
		<div id="content_box">
			<div id="content">
				<div id="load"><b>Wird geladen...</b><br><img src="img/ajax-loader.gif"></div>
				<div id="content_text">