<h1>Gruppe editieren</h1>
{if $Rights["can_manage_groups"] eq "1"}
	<table>
		<tr>
			<td>Gruppenname:</td>
			<td><input type="text" id="GroupName" style="text-align:left;" value="{$GroupDetails[0]}"></td>
		</tr>
		<tr>
			<td>Darf Dateien verwalten?</td>
			<td><input type="checkbox" id="can_manage_files"{if $GroupDetails[1]["can_manage_files"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf Dateien hochladen?</td>
			<td><input type="checkbox" id="can_upload_files"{if $GroupDetails[1]["can_upload_files"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf Dateien löschen?</td>
			<td><input type="checkbox" id="can_delete_files"{if $GroupDetails[1]["can_delete_files"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf Clientseitiges löschen verwalten?</td>
			<td><input type="checkbox" id="can_manage_delete_client_files"{if $GroupDetails[1]["can_manage_delete_client_files"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf Patchliste verwalten?</td>
			<td><input type="checkbox" id="can_manage_patchlist"{if $GroupDetails[1]["can_manage_patchlist"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf Patchliste generieren?</td>
			<td><input type="checkbox" id="can_generate_patchlist"{if $GroupDetails[1]["can_generate_patchlist"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf Patchliste editieren?</td>
			<td><input type="checkbox" id="can_edit_patchlist"{if $GroupDetails[1]["can_edit_patchlist"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf neue Patcherversion hochladen?</td>
			<td><input type="checkbox" id="can_upload_newpatcher"{if $GroupDetails[1]["can_upload_newpatcher"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf Benutzer verwalten?</td>
			<td><input type="checkbox" id="can_manage_users"{if $GroupDetails[1]["can_manage_users"] eq "1"} checked="checked"{/if}></td>
		</tr>
		<tr>
			<td>Darf Gruppen verwalten?</td>
			<td><input type="checkbox" id="can_manage_groups"{if $GroupDetails[1]["can_manage_groups"] eq "1"} checked="checked"{/if}></td>
		</tr>
	</table>
	<div class="submit" style="margin:0;"><a href="javascript:SaveGroup({$GroupID})">Speichern</a></div>
{else}
	Du hast keine Rechte für diese Seite!
{/if}