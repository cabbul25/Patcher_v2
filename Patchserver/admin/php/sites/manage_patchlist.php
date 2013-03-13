<?php
$patchlist = "";

if (file_exists("../filelist/filelist.xml"))
{
	$file = fopen("../filelist/filelist.xml", "r");
	while (!feof($file))
	{
		$patchlist .= sprintf("%s", fgets($file));
	}
	fclose($file);
}

$smarty->assign("patchlist", $patchlist);
?>