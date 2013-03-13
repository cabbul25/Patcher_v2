<?php
ini_set("display_errors", 1);
if (isset($_GET["ajax"]))
{
	$sqlite = "cnf/db/patcher.sqlite";
	
	if (isset($_GET["install"]) && $_GET["install"] == "db")
	{
		$db = new SQLite3($sqlite, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		$db->exec("CREATE TABLE IF NOT EXISTS Deleted (PatternID INTEGER PRIMARY KEY AUTOINCREMENT, Name TEXT)");
		$db->exec("CREATE TABLE IF NOT EXISTS Groups (GroupID INTEGER PRIMARY KEY AUTOINCREMENT, GroupName TEXT)");
		$db->exec("CREATE TABLE IF NOT EXISTS PatcherVersion (VersionID INTEGER PRIMARY KEY AUTOINCREMENT, Version TEXT, Date TEXT)");
		$db->exec("CREATE TABLE IF NOT EXISTS Rights (RightID INTEGER PRIMARY KEY AUTOINCREMENT, GroupID INTEGER, RightName TEXT, RightValue INTEGER)");
		$db->exec("CREATE TABLE IF NOT EXISTS User (UserID INTEGER PRIMARY KEY AUTOINCREMENT, Username TEXT, Password TEXT, GroupID INTEGER)");
		$db->close();
		echo 0;
	}
	else if (isset($_GET["install"]) && $_GET["install"] == "groups")
	{
		$db = new SQLite3($sqlite, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		if ($db->exec("INSERT INTO Groups (GroupName) VALUES ('Admin')") == false)
			echo "1";
		$db->close();
		echo "0";
	}
	else if (isset($_GET["install"]) && $_GET["install"] == "rights")
	{
		$db = new SQLite3($sqlite, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_manage_files', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_upload_files', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_delete_files', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_manage_delete_client_files', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_manage_patchlist', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_generate_patchlist', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_edit_patchlist', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_upload_newpatcher', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_manage_users', 1)") == false)
			echo "1";
		if ($db->exec("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (1, 'can_manage_groups', 1)") == false)
			echo "1";
		$db->close();
		echo "0";
	}
	else if (isset($_GET["install"]) && $_GET["install"] == "admin")
	{
		$password = bin2hex(mhash(MHASH_SHA512, sprintf("%s%s", strtolower("admin"), "admin123")));
		$db = new SQLite3($sqlite, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		if ($db->exec("INSERT INTO User (Username, Password, GroupID) VALUES ('admin', '".$password."', 1)") == false)
			echo "1";
		$db->close();
		echo "0";
	}
	else if (isset($_GET["install"]) && $_GET["install"] == "install")
	{
		echo "0";
	}
}
else
{
	require_once("php/libs/SmartyBC.class.php");

	$smarty = new Smarty();

	if (substr(sprintf("%o", fileperms("cache/")), -3) != "777")
	{
		die("The directory \"cache\" is not writeable");
	}

	$rights = array("cache/" => substr(sprintf("%o", fileperms("cache/")), -3),
					"cnf/" => substr(sprintf("%o", fileperms("cnf/")), -3),
					"cnf/db/" => substr(sprintf("%o", fileperms("cnf/db/")), -3),
					"tmp/" => substr(sprintf("%o", fileperms("tmp/")), -3),
					"../filelist/" => substr(sprintf("%o", fileperms("tmp/")), -3),
					"../client/" => substr(sprintf("%o", fileperms("tmp/")), -3),
					"../update/" => substr(sprintf("%o", fileperms("tmp/")), -3));

	$smarty->assign("Rights", $rights);
	$smarty->display("install.tpl");

	$smarty = null;
}
?>