<h1>Neuen Benutzer anlegen</h1>
{if $Rights["can_manage_users"] eq "1"}
	<table>
		<tr>
			<td>Benutzername:</td>
			<td><input type="text" id="Username" style="text-align:left;" onkeydown="if (event.keyCode == 13) CreateUser()"></td>
		</tr>
		<tr>
			<td>Passwort:</td>
			<td><input type="password" id="Password1" style="text-align:left;" onkeydown="if (event.keyCode == 13) CreateUser()"></td>
		</tr>
		<tr>
			<td>Password wiederholen:</td>
			<td><input type="password" id="Password2" style="text-align:left;" onkeydown="if (event.keyCode == 13) CreateUser()"></td>
		</tr>
		<tr>
			<td>Gruppe:</td>
			<td>
				<select id="Group" onkeydown="if (event.keyCode == 13) CreateUser()">
					{foreach key=key item=val from=$Groups}
						<option value="{$val["GroupID"]}">{$val["GroupName"]}</option>
					{/foreach}
				</select>
			</td>
		</tr>
	</table>
	<div class="submit" style="margin:0;"><a href="javascript:CreateUser()">Erstellen</a></div>
{else}
	Du hast keine Rechte für diese Seite!
{/if}