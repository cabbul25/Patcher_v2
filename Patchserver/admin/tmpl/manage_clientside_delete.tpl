<h1>Clientseitiges Löschen</h1>
{if $Rights["can_manage_delete_client_files"] eq "1"}
	<table>
		<tr>
			<td><div style="padding-bottom:6px;"><input type="text" id="File" style="text-align:left;" onkeydown="if (event.keyCode == 13) AddDeletedFile()"></div></td>
			<td><div class="submit" style="margin:0;margin-bottom:10px;"><a href="javascript:AddDeletedFile();">Hinzufügen</a></div></td>
		</tr>
	</table>
	<table class="table">
		{foreach key=key item=val from=$DeletedFiles}
			<tr>
				<td style="width:200px;text-align:left;">{$val["Name"]}</td>
				<td><a href="javascript:DeleteClientFile({$val["PatternID"]});"><img src="img/delete.png"></a></td>
			</tr>
		{/foreach}
	</table>
{else}
	Du hast keine Rechte für diese Seite!
{/if}