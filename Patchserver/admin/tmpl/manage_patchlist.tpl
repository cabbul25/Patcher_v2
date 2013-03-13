<h1>Patchliste</h1>
{if $Rights["can_manage_patchlist"] eq "1"}
	{if $Rights["can_generate_patchlist"] eq "1"}
		<div class="submit" style="margin:0;margin-bottom:10px;"><a href="javascript:CreatePatchlist();">Neu generieren</a></div>
	{/if}
	<textarea rows="20" cols="80" id="Patchlist">{$patchlist}</textarea>
	{if $Rights["can_edit_patchlist"] eq "1"}
		<div class="submit" style="margin:0;margin-bottom:10px;"><a href="javascript:SavePatchlist();">Speichern</a></div>
	{/if}
{else}
	Du hast keine Rechte für diese Seite!
{/if}