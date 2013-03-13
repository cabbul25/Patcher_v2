var upload_disable = false;

function DoLogout()
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&logout").done(function(data) {
		if (data == "0")
		{
			alert("Es ist ein Fehler beim Abmelden aufgetreten.");
		}
		else
		{
			$.ajax({url: "index.php"}).done(function (data) {
				$("#content_box").hide("drop", { direction: "down" }, 300, function() {
					$("#menu_box").hide("drop", { direction: "down" }, 300, function() {
						$("#header").hide("drop", { direction: "down" }, 300, function() {
							var newSite = document.open("text/html", "replace");
							newSite.write(data);
							newSite.close();
						});
					});
				});
			});
		}
	});
}

function ShowSite(SiteName)
{
	$("#load").slideDown(100);
	
	$.ajax({url: "index.php?ajax&site=" + SiteName}).done(function(data){
		$("#content_text").slideUp(100, function(){
			$("#content_text").html(data);
			$("#content_text").slideDown(100);
		});
		$("#load").slideUp(100);
	});
}

function ShowInfo()
{
	ShowSite("info");
}

function ManageFiles()
{
	ShowSite("manage_files");
}

function ShowDirectory(Directory)
{
	$("#load").slideDown(100);
	
	$.ajax({url: "index.php?ajax&site=manage_files&directory="+Directory}).done(function(data){
		$("#content_text").slideUp(100, function(){
			$("#content_text").html(data);
			$("#content_text").slideDown(100);
		});
		$("#load").slideUp(100);
	});
}

function DeleteFile(File)
{
	$("#load").slideDown(100);
	
	$.ajax("index.php?ajax&deletefile="+File)
	.done(function(data) {
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				alert("Die Datei konnte nicht gelöscht werden.");
			});
		}
		else
		{
			$("#load").slideUp(100, function(){
				alert("Die Datei wurde erfolgreich gelöscht.");
				ManageFiles();
			});
		}
	});
}

function DeleteDirectory(Directory)
{
	$("#load").slideDown(100);
	
	$.ajax("index.php?ajax&deletedirectory="+Directory)
	.done(function(data) {
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				alert("Der Ordner konnte nicht gelöscht werden.");
			});
		}
		else
		{
			$("#load").slideUp(100, function(){
				alert("Der Ordner wurde erfolgreich gelöscht.");
				ManageFiles();
			});
		}
	});
}

function ManageUsers()
{
	ShowSite("manage_users");
}

function ManageClientsideDelete()
{
	ShowSite("manage_clientside_delete");
}

function ManageGroups()
{
	ShowSite("manage_groups");
}

function ManagePassword()
{
	ShowSite("manage_password");
}

function ManagePatchlist()
{
	ShowSite("manage_patchlist");
}

function ManagePatcherVersion()
{
	ShowSite("manage_patcher_version");
}

function ShowCreateUser()
{
	ShowSite("create_user");
}

function ShowCreateGroup()
{
	ShowSite("create_group");
}

function ShowEditUser(GroupID)
{
	$("#load").slideDown(100);
	
	$.ajax({url: "index.php?ajax&site=edit_user&user=" + GroupID}).done(function(data){
		$("#content_text").slideUp(100, function(){
			$("#content_text").html(data);
			$("#content_text").slideDown(100);
		});
		$("#load").slideUp(100);
	});
}

function ShowEditGroup(GroupID)
{
	if (GroupID == "1")
	{
		alert("Die Admin-Gruppe kann nicht bearbeitet werden.");
	}
	else
	{
		$("#load").slideDown(100);
		
		$.ajax({url: "index.php?ajax&site=edit_group&group=" + GroupID}).done(function(data){
			$("#content_text").slideUp(100, function(){
				$("#content_text").html(data);
				$("#content_text").slideDown(100);
			});
			$("#load").slideUp(100);
		});
	}
}

function CreateUser()
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&createuser",
		{Username: $("#Username").val(),
		 Password1: $("#Password1").val(),
		 Password2: $("#Password2").val(),
		 GroupID: $("#Group").val()})
		.done(function(data) {
			if (data == 1)
			{
				$("#load").slideUp(100, function(){
					alert("Der Benutzername muss mindestens 5 Zeichen lang sein.");
				});
			}
			else if (data == 2)
			{
				$("#load").slideUp(100, function(){
					alert("Der Benutzername darf maximal 16 Zeichen lang sein.");
				});
			}
			else if (data == 3)
			{
				$("#load").slideUp(100, function(){
					alert("Der Benutzername darf nur aus Buchstaben und Zahlen bestehen.");
				});
			}
			else if (data == 4)
			{
				$("#load").slideUp(100, function(){
					alert("Der Benutzername wird bereits verwendet.");
				});
			}
			else if (data == 5)
			{
				$("#load").slideUp(100, function(){
					alert("Die beiden Passwörter stimmen nicht überein.");
				});
			}
			else if (data == 6)
			{
				$("#load").slideUp(100, function(){
					alert("Das Passwort muss mindestens 6 Zeichen lang sein.");
				});
			}
			else if (data == 7)
			{
				$("#load").slideUp(100, function(){
					alert("Das Passwort darf maximal 30 Zeichen lang sein.");
				});
			}
			else if (data == 8)
			{
				$("#load").slideUp(100, function(){
					alert("Es ist ein unbekannter Fehler beim Erstellen des Benutzers aufgetreten..");
				});
			}
			else
			{
				$("#load").slideUp(100, function(){
					alert("Der Benutzer wurde erfolgreich angelegt.");
					ManageUsers();
				});
			}
	});
}

function CreateGroup()
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&creategroup",
		{GroupName: $("#GroupName").val(),
		 can_manage_files: ($("#can_manage_files").is(":checked") == true) ? 1 : 0,
		 can_upload_files: ($("#can_upload_files").is(":checked") == true) ? 1 : 0,
		 can_delete_files: ($("#can_delete_files").is(":checked") == true) ? 1 : 0,
		 can_manage_delete_client_files: ($("#can_manage_delete_client_files").is(":checked") == true) ? 1 : 0,
		 can_manage_patchlist: ($("#can_manage_patchlist").is(":checked") == true) ? 1 : 0,
		 can_generate_patchlist: ($("#can_generate_patchlist").is(":checked") == true) ? 1 : 0,
		 can_edit_patchlist: ($("#can_edit_patchlist").is(":checked") == true) ? 1 : 0,
		 can_upload_newpatcher: ($("#can_upload_newpatcher").is(":checked") == true) ? 1 : 0,
		 can_manage_users: ($("#can_manage_users").is(":checked") == true) ? 1 : 0,
		 can_manage_groups: ($("#can_manage_groups").is(":checked") == true) ? 1 : 0})
		.done(function(data) {
			if (data == 1)
			{
				$("#load").slideUp(100, function(){
					alert("Der Gruppenname muss mindestens 3 Zeichen lang sein.");
				});
			}
			else if (data == 2)
			{
				$("#load").slideUp(100, function(){
					alert("Der Gruppenname darf maximal 20 Zeichen lang sein.");
				});
			}
			else if (data == 3 || data == 4 || data == 5)
			{
				$("#load").slideUp(100, function(){
					alert("Es ist ein Fehler beim Erstellen der Gruppe aufgetreten.");
				});
			}
			else
			{
				$("#load").slideUp(100, function(){
					alert("Die Gruppe wurde erfolgreich angelegt.");
					ManageGroups();
				});
			}
	});
}

function SaveGroup(GroupID)
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&savegroup",
		{GroupID: GroupID,
		 GroupName: $("#GroupName").val(),
		 can_manage_files: ($("#can_manage_files").is(":checked") == true) ? 1 : 0,
		 can_upload_files: ($("#can_upload_files").is(":checked") == true) ? 1 : 0,
		 can_delete_files: ($("#can_delete_files").is(":checked") == true) ? 1 : 0,
		 can_manage_delete_client_files: ($("#can_manage_delete_client_files").is(":checked") == true) ? 1 : 0,
		 can_manage_patchlist: ($("#can_manage_patchlist").is(":checked") == true) ? 1 : 0,
		 can_generate_patchlist: ($("#can_generate_patchlist").is(":checked") == true) ? 1 : 0,
		 can_edit_patchlist: ($("#can_edit_patchlist").is(":checked") == true) ? 1 : 0,
		 can_upload_newpatcher: ($("#can_upload_newpatcher").is(":checked") == true) ? 1 : 0,
		 can_manage_users: ($("#can_manage_users").is(":checked") == true) ? 1 : 0,
		 can_manage_groups: ($("#can_manage_groups").is(":checked") == true) ? 1 : 0})
		.done(function(data) {
			if (data == 1)
			{
				$("#load").slideUp(100, function(){
					alert("Der Gruppenname muss mindestens 3 Zeichen lang sein.");
				});
			}
			else if (data == 2)
			{
				$("#load").slideUp(100, function(){
					alert("Der Gruppenname darf maximal 20 Zeichen lang sein.");
				});
			}
			else if (data == 3 || data == 4 || data == 5)
			{
				$("#load").slideUp(100, function(){
					alert("Es ist ein Fehler beim Erstellen der Gruppe aufgetreten.");
				});
			}
			else
			{
				$("#load").slideUp(100, function(){
					alert("Die Gruppe wurde erfolgreich gespeichert.");
					ManageGroups();
				});
			}
	});
}

function SaveUser(UserID)
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&saveuser",
		{UserID: UserID,
		 Password1: $("#Password1").val(),
		 Password2: $("#Password2").val(),
		 GroupID: $("#Group").val()})
		.done(function(data) {
			if (data == 1)
			{
				$("#load").slideUp(100, function(){
					alert("Die beiden Passwörter stimmen nicht überein.");
				});
			}
			else if (data == 2)
			{
				$("#load").slideUp(100, function(){
					alert("Das Passwort muss mindestens 6 Zeichen lang sein.");
				});
			}
			else if (data == 3)
			{
				$("#load").slideUp(100, function(){
					alert("Das Passwort darf maximal 30 Zeichen lang sein.");
				});
			}
			else if (data == 4)
			{
				$("#load").slideUp(100, function(){
					alert("Es ist ein Fehler beim Speichern aufgetreten.");
				});
			}
			else
			{
				$("#load").slideUp(100, function(){
					alert("Der Benutzer wurde erfolgreich gespeichert.");
					ManageUsers();
				});
			}
	});
}

function DeleteUser(UserID)
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&deleteuser", {UserID: UserID}).done(function(data) {
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				alert("Es ist ein Fehler beim Löschen aufgetreten.");
			});
		}
		else
		{
			$("#load").slideUp(100, function(){
				alert("Der Benutzer wurde erfolgreich gelöscht.");
				ManageUsers();
			});
		}
	});
}

function DeleteGroup(GroupID)
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&deletegroup", {GroupID: GroupID}).done(function(data) {
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				alert("Die Admingruppe kann nicht gelöscht werden.");
			});
		}
		else if (data == 2)
		{
			$("#load").slideUp(100, function(){
				alert("Es ist ein Fehler beim Löschen aufgetreten.");
			});
		}
		else
		{
			$("#load").slideUp(100, function(){
				alert("Die Gruppe wurde erfolgreich gelöscht.");
				ManageGroups();
			});
		}
	});
}

function ChangePassword()
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&changepassword", {OldPW: $("#OldPW").val(), PW1: $("#PW1").val(), PW2: $("#PW2").val()}).done(function(data) {
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				alert("Das alte Passwort ist falsch.");
			});
		}
		else if (data == 2)
		{
			$("#load").slideUp(100, function(){
				alert("Die beiden Passwörter stimmen nicht überein.");
			});
		}
		else if (data == 3)
		{
			$("#load").slideUp(100, function(){
				alert("Das Passwort muss mindestens 6 Zeichen lang sein.");
			});
		}
		else if (data == 4)
		{
			$("#load").slideUp(100, function(){
				alert("Das Passwort darf maximal 30 Zeichen lang sein.");
			});
		}
		else if (data == 5)
		{
			$("#load").slideUp(100, function(){
				alert("Es ist ein Fehler beim Ändern aufgetreten.");
			});
		}
		else
		{
			$("#load").slideUp(100, function(){
				alert("Das Passwort wurde erfolgreich geändert. Du wirst nun ausgeloggt.");
				DoLogout();
			});
		}
	});
}

function AddDeletedFile()
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&adddeletedfile", {File: $("#File").val()}).done(function(data) {
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				alert("Datei wurde bereits als gelöscht markiert.");
			});
		}
		else if (data == 2)
		{
			$("#load").slideUp(100, function(){
				alert("Hinzufügen fehlgeschlagen.");
			});
		}
		else
		{
			$("#load").slideUp(100, function(){
				alert("Die Datei wurde erfolgreich hinzugefügt.");
				ManageClientsideDelete();
			});
		}
	});
}

function handleFile(File) {
	$("#load").html("<b>Datei wird hochgeladen. Bitte warten...</b><br><img src=\"img/ajax-loader.gif\">");
	$("#load").slideDown(100);
	
	if (upload_disable == false) {
		if(File != undefined)
		{
			var xhr = new XMLHttpRequest();
			this.xhr = xhr;
			
			var fd = new FormData;
			fd.append("file", File[0]);
			
			xhr.open("POST", "index.php?ajax&uploadzip", true);
			xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');
			xhr.onreadystatechange=function() {
				if (xhr.readyState == 4) {
					UnpackZIP(xhr.responseText);
				}
			}
			
			xhr.send(fd);
		}
	}
}

function handlePatcherFile(File) {
	$("#load").html("<b>Datei wird hochgeladen. Bitte warten...</b><br><img src=\"img/ajax-loader.gif\">");
	$("#load").slideDown(100);
	
	if (upload_disable == false) {
		if(File != undefined)
		{
			var xhr = new XMLHttpRequest();
			this.xhr = xhr;
			
			var fd = new FormData;
			fd.append("file", File[0]);
			fd.append("Version", $("#PatcherVersion").val());
			
			xhr.open("POST", "index.php?ajax&uploadpatcher", true);
			xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');
			xhr.onreadystatechange=function() {
				if (xhr.readyState == 4) {
					if (xhr.responseText == "1")
					{
						$("#load").slideUp(100, function(){
							$("#load").html("<b>Wird geladen...</b><br><img src=\"img/ajax-loader.gif\">");
							alert("Es ist ein Fehler beim Erstellen der neuen Version aufgetreten.");
						});
					}
					else if (xhr.responseText == "1")
					{
						$("#load").slideUp(100, function(){
							$("#load").html("<b>Wird geladen...</b><br><img src=\"img/ajax-loader.gif\">");
							alert("Es ist ein Fehler beim Hochladen aufgetreten.");
						});
					}
					else
					{
						$("#load").slideUp(100, function(){
							$("#load").html("<b>Wird geladen...</b><br><img src=\"img/ajax-loader.gif\">");
							alert("Der neue Patcher wurde erfolgreich hochgeladen.");
							ManagePatcherVersion();
						});
					}
				}
			}
			
			xhr.send(fd);
		}
	}
}

function UnpackZIP(ZipName)
{
	$("#load").html("<b>Zip wird entpackt. Bitte warten...</b><br><img src=\"img/ajax-loader.gif\">");
	
	$.ajax({url: "index.php?ajax&unpackzip=" + ZipName}).done(function(data){
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				$("#load").html("<b>Wird geladen...</b><br><img src=\"img/ajax-loader.gif\">");
				alert("Es ist ein Fehler beim Entpacken aufgetreten.");
			});
		}
		else
		{
			MoveFiles();
		}
	});
}

function DeleteClientFile(PatternID)
{
	$("#load").slideDown(100);
	
	$.ajax({url: "index.php?ajax&deletepattern=" + PatternID}).done(function(data){
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				alert("Es ist ein Fehler beim Löschen aufgetreten.");
			});
		}
		else
		{
			$("#load").slideUp(100, function(){
				alert("Der Eintrag wurde aus den zu löschenden Dateien entfernt.");
				ManageClientsideDelete();
			});
		}
	});
}

function MoveFiles()
{
	$("#load").html("<b>Dateien werden verschoben. Bitte warten...</b><br><img src=\"img/ajax-loader.gif\">");
	
	$.ajax({url: "index.php?ajax&movefiles"}).done(function(data){
		$("#load").slideUp(100, function(){
			$("#load").html("<b>Wird geladen...</b><br><img src=\"img/ajax-loader.gif\">");
			alert("Dateien wurden erfolgreich hochgeladen.");
			ManageFiles();
		});
	});
}

function CreatePatchlist()
{
	$("#load").slideDown(100);
		
	$.ajax({url: "index.php?ajax&generatepatchlist"}).done(function(data){
		if (data == 1)
		{
			$("#load").slideUp(100, function(){
				alert("Es ist ein Fehler beim Erstellen der Patchliste aufgetreten.");
			});
		}
		else
		{
			$("#load").slideUp(100, function(){
				alert("Die Patchliste wurde erfolgreich generiert.");
				ManagePatchlist();
			});
		}
	});
}

function SavePatchlist()
{
	$("#load").slideDown(100);
	
	$.post("index.php?ajax&savepatchlist", {Patchlist: $("#Patchlist").val()}).done(function(data) {
		$("#load").slideUp(100, function(){
			alert("Die Patchliste wurde erfolgreich gespeichert.");
		});
	});
}
