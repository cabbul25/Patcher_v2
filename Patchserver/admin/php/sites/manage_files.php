<?php
require_once("php/classes/Files.class.php");
$files = new Files();

if (isset($_GET["directory"]))
{
	$smarty->assign("Directories", $files->GetDirectories("../client/".$_GET["directory"]));
	$smarty->assign("Files", $files->GetFiles("../client/".$_GET["directory"]));
	$smarty->assign("Path", $_GET["directory"]);
	$explode = explode("/", $_GET["directory"]);
	array_pop($explode);
	array_pop($explode);
	$subdir = null;
	foreach($explode as $val)
	{
		$subdir .= $val."/";
	}
	if ($_GET["directory"] == "")
	{
		$smarty->assign("subdir", "0");
	}
	else
	{
		$smarty->assign("subdir", $subdir);
	}
}
else
{
	$smarty->assign("Directories", $files->GetDirectories("../client/"));
	$smarty->assign("Files", $files->GetFiles("../client/"));
	$smarty->assign("Path", "");
	$smarty->assign("subdir", "0");
}

$files = null;
?>