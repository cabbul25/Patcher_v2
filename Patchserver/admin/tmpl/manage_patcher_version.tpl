<h1>Patcherversion</h1>
{if $Rights["can_upload_newpatcher"] eq "1"}
	<b>Aktuelle Version:</b> {$Version}<br><br>
	Versionsnummer: <input type="text" id="PatcherVersion" style="text-align:left;">
	<br><br>
	<div class="submit" style="margin:0;margin-bottom:10px;"><a href="javascript:document.getElementById('ulFile').click();">Hochladen</a></div>
	<input type="file" name="ulFile[]" id="ulFile" onchange="handlePatcherFile(this.files)" style="visibility:hidden;display:none;">
{else}
	Du hast keine Rechte für diese Seite!
{/if}