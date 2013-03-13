<h1>Benutzerverwaltung</h1>
{if $Rights["can_manage_users"] eq "1"}
	<div class="submit" style="margin:0;margin-bottom:10px;"><a href="javascript:ShowCreateUser()">Neuer Benutzer</a></div>
	<table class="table">
		<tr>
			<th style="width:50px;">#ID</th>
			<th style="width:200px;">Benutzername</th>
			<th style="width:200px;">Aktionen</th>
		</tr>
		{foreach key=key item=val from=$Users}
			<tr>
				<td>{$val["UserID"]}</td>
				<td>{$val["Username"]}</td>
				<td><div class="submit"><a href="javascript:ShowEditUser('{$val["UserID"]}')">Bearbeiten</a></div> <div class="submit"><a href="javascript:DeleteUser('{$val["UserID"]}')" onClick="return confirm('Möchtest du diesen Benutzer wirklich löschen?')">Löschen</a></div></td>
			</tr>
		{/foreach}
	</table>
{else}
	Du hast keine Rechte für diese Seite!
{/if}