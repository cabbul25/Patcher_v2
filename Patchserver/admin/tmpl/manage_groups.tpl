<h1>Gruppenverwaltung</h1>
{if $Rights["can_manage_groups"] eq "1"}
	<div class="submit" style="margin:0;margin-bottom:10px;"><a href="javascript:ShowCreateGroup()">Neue Gruppe</a></div>
	<table class="table">
		<tr>
			<th style="width:50px;">#ID</th>
			<th style="width:200px;">Gruppenname</th>
			<th style="width:200px;">Aktionen</th>
		</tr>
		{foreach key=key item=val from=$Groups}
			<tr>
				<td>{$val["GroupID"]}</td>
				<td>{$val["GroupName"]}</td>
				<td><div class="submit"><a href="javascript:ShowEditGroup('{$val["GroupID"]}')">Bearbeiten</a></div> <div class="submit"><a href="javascript:DeleteGroup('{$val["GroupID"]}')" onClick="return confirm('Möchtest du diese Gruppe wirklich löschen?')">Löschen</a></div></td>
			</tr>
		{/foreach}
	</table>
{else}
	Du hast keine Rechte für diese Seite!
{/if}