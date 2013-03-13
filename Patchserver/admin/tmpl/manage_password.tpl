<h1>Passwort ändern</h1>
<table>
	<tr>
		<td>Altes Passwort:</td>
		<td><input type="password" id="OldPW" onkeydown="if (event.keyCode == 13) ChangePassword()" style="text-align:left;"></td>
	</tr>
	<tr>
		<td>Neues Passwort:</td>
		<td><input type="password" id="PW1" onkeydown="if (event.keyCode == 13) ChangePassword()" style="text-align:left;"></td>
	</tr>
	<tr>
		<td>Passwort wiederholen:</td>
		<td><input type="password" id="PW2" onkeydown="if (event.keyCode == 13) ChangePassword()" style="text-align:left;"></td>
	</tr>
</table>
<div class="submit" style="margin:0;"><a href="javascript:ChangePassword()">Ändern</a></div>