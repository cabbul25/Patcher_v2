<?php
ini_set("display_errors", 1);
session_start();

require_once("php/classes/Database.class.php");
require_once("php/libs/SmartyBC.class.php");

$smarty = new Smarty();
$Rights = null;
if (isset($_SESSION["logged"]))
{
	require_once("php/classes/User.class.php");
	$user = new User();
	$Rights = $user->GetRights($_SESSION["Username"]);
	$smarty->assign("Rights", $Rights);
	$user = null;
}

if (isset($_GET["ajax"]))
{
	require_once("php/ajax.php");
}
else
{
	if (file_exists("install.php"))
	{
		header("Location: install.php");
	}

	if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true)
	{
		$smarty->assign("Username", $_SESSION["Username"]);
		$smarty->display("header.tpl");
		require_once("php/sites/manage_files.php");
		$smarty->display("manage_files.tpl");
		$smarty->display("footer.tpl");
	}
	else
	{
		$smarty->display("login.tpl");
	}
}

$smarty = null;
?>