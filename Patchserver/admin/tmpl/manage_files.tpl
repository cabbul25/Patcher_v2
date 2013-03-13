<h1>Dateiverwaltung</h1>
{if $Rights["can_manage_files"] eq "1"}
	{if $Rights["can_upload_files"] eq "1"}
		<div class="submit" style="margin:0;margin-bottom:10px;"><a href="javascript:document.getElementById('ulFile').click();">Hochladen</a></div>
		<input type="file" name="ulFile[]" id="ulFile" onchange="handleFile(this.files)" style="visibility:hidden;display:none;">
	{/if}
	<b>Derzeitig in /{$Path}</b>
	<table class="table">
		<tr>
			<th style="width:400px;">Datei/Ordner</th>
			{if $Rights["can_delete_files"] eq "1"}<th style="width:200px;">Aktionen</th>{/if}
		</tr>
		{if $subdir ne "0"}
			<tr>
				<td style="text-align:left; height:40px;"{if $Rights["can_delete_files"] eq "1"} colspan="2"{/if}><a href="javascript:ShowDirectory('{$subdir}')">..</a></td>
			</tr>
		{/if}
		{foreach from=$Directories item=val}
			<tr>
				<td style="text-align:left;height:40px;"><a href="javascript:ShowDirectory('{$Path}{$val}/')">{$val}/</a></td>
				{if $Rights["can_delete_files"] eq "1"}<td><div class="submit"><div class="submit"><a href="javascript:DeleteDirectory('{$Path}{$val}/')" onClick="return confirm('Möchtest du diese Datei wirklich löschen?')">Löschen</a></div></td>{/if}
			</tr>
		{/foreach}
		{foreach from=$Files item=val}
			<tr>
				<td style="text-align:left;height:40px;">{$val}</td>
				{if $Rights["can_delete_files"] eq "1"}<td><div class="submit"><div class="submit"><a href="javascript:DeleteFile('{$Path}{$val}')" onClick="return confirm('Möchtest du diese Datei wirklich löschen?')">Löschen</a></div></td>{/if}
			</tr>
		{/foreach}
	</table>
{else}
	Du hast keine Rechte für diese Seite!
{/if}