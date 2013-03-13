function DoLogin()
{
	$("#load").html("<b>Wird geladen...</b><br><img src=\"img/ajax-loader.gif\">");
	var Username = $("#Username").val();
	var Password = $("#Password").val();
	
	$.post("index.php?ajax&login", {username: Username, password: Password}).done(function(data) {
		if (data == "0")
		{
			$("#box").effect("bounce", { times:5 }, 400);
			$("#load").html("<fieldset class=\"error\">Logindaten sind falsch.</fieldset>");
		}
		else
		{
			$.ajax({url: "index.php"}).done(function (data) {
				$("#box").hide("drop", { direction: "down" }, 500, function() {
					$("#title").hide("drop", { direction: "down" }, 300, function() {
						var newSite = document.open("text/html", "replace");
						newSite.write(data);
						newSite.close();
					});
				});
			});
		}
	});
}