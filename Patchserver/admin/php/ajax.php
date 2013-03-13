<?php
if (isset($_GET["login"]))
{
	require_once("php/classes/User.class.php");
	$user = new User();
	if ($user->CheckUserData($_POST["username"], $_POST["password"]))
	{
		$_SESSION["logged"] = true;
		$_SESSION["Username"] = $_POST["username"];
		$_SESSION["UserID"] = $user->GetUserID($_POST["username"]);
		echo "1";
	}
	else
	{
		echo "0";
	}
}
else if (isset($_GET["version"]))
{
	require_once("php/classes/Files.class.php");
	
	$file = new Files();
	
	echo $file->GetCurrentPatcherVersion();

	$file = null;
}
else if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true)
{
	if (isset($_GET["logout"]))
	{
		if (session_destroy())
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
	else if (isset($_GET["site"]))
	{
		if (file_exists(sprintf("tmpl/%s.tpl", $_GET["site"])))
		{
			if (file_exists(sprintf("php/sites/%s.php", $_GET["site"])))
			{
				require_once(sprintf("php/sites/%s.php", $_GET["site"]));
			}
			$smarty->display(sprintf("%s.tpl", $_GET["site"]));
		}
	}
	else if (isset($_GET["creategroup"]) && $Rights["can_manage_groups"] == 1)
	{
		require_once("php/classes/Groups.class.php");
		
		$group = new Groups();
		
		if (($e = $group->CheckGroupName($_POST["GroupName"])) != 0)
		{
			if ($e == 1)
			{
				echo "1";
			}
			else if ($e == 2)
			{
				echo "2";
			}
		}
		else if (($e = $group->CreateGroup($_POST["GroupName"], $_POST["can_manage_files"], $_POST["can_upload_files"], $_POST["can_delete_files"], $_POST["can_manage_delete_client_files"], $_POST["can_manage_patchlist"], $_POST["can_generate_patchlist"], $_POST["can_edit_patchlist"], $_POST["can_upload_newpatcher"], $_POST["can_manage_users"], $_POST["can_manage_groups"])) != 0)
		{
			if ($e == 1)
			{
				echo "3";
			}
			else if ($e == 2)
			{
				echo "4";
			}
			else if ($e == 3)
			{
				echo "5";
			}
		}
		else
		{
			echo "0";
		}
		
		$group = null;
	}
	else if (isset($_GET["createuser"]) && $Rights["can_manage_users"] == 1)
	{
		require_once("php/classes/User.class.php");
		$user = new User();
		
		if (($e = $user->CheckUsername($_POST["Username"])) != 0)
		{
			if ($e == 1)
			{
				echo "1";
			}
			else if ($e == 2)
			{
				echo "2";
			}
			else if ($e == 3)
			{
				echo "3";
			}
			else if ($e == 4)
			{
				echo "4";
			}
		}
		else if (($e = $user->CheckPassword($_POST["Password1"], $_POST["Password2"])) != 0)
		{
			if ($e == 1)
			{
				echo "5";
			}
			else if ($e == 2)
			{
				echo "6";
			}
			else if ($e == 3)
			{
				echo "7";
			}
		}
		else if (!$user->CreateUser($_POST["Username"], $_POST["Password1"], $_POST["GroupID"]))
		{
			echo "8";
		}
		else
		{
			echo "0";
		}
		
		$user = null;
	}
	else if (isset($_GET["savegroup"]) && $Rights["can_manage_groups"] == 1)
	{
		require_once("php/classes/Groups.class.php");
		
		$group = new Groups();
		
		if (($e = $group->CheckGroupName($_POST["GroupName"])) != 0)
		{
			if ($e == 1)
			{
				echo "1";
			}
			else if ($e == 2)
			{
				echo "2";
			}
		}
		else if (!$group->SaveGroup($_POST["GroupID"], $_POST["GroupName"], $_POST["can_manage_files"], $_POST["can_upload_files"], $_POST["can_delete_files"], $_POST["can_manage_delete_client_files"], $_POST["can_manage_patchlist"], $_POST["can_generate_patchlist"], $_POST["can_edit_patchlist"], $_POST["can_upload_newpatcher"], $_POST["can_manage_users"], $_POST["can_manage_groups"]))
		{
			echo "3";
		}
		else
		{
			echo "0";
		}
		
		$group = null;
	}
	else if (isset($_GET["saveuser"]) && $Rights["can_manage_users"] == 1)
	{
		require_once("php/classes/User.class.php");
		
		$user = new User();
		
		if ($_POST["Password1"] != "")
		{
			if (($e = $user->CheckPassword($_POST["Password1"], $_POST["Password2"])) != 0)
			{
				if ($e == 1)
				{
					echo "1";
				}
				else if ($e == 2)
				{
					echo "2";
				}
				else if ($e == 3)
				{
					echo "3";
				}
			}
			else if (!$user->SaveUser($_POST["UserID"], $_POST["GroupID"], $_POST["Password1"]))
			{
				echo "4";
			}
			else
			{
				echo "0";
			}
		}
		else
		{
			if (!$user->SaveUser($_POST["UserID"], $_POST["GroupID"]))
			{
				echo "4";
			}
			else
			{
				echo "0";
			}
		}
		
		$user = null;
	}
	else if (isset($_GET["deletegroup"]) && $Rights["can_manage_groups"] == 1)
	{
		require_once("php/classes/Groups.class.php");
		
		$group = new Groups();
		
		if ($_POST["GroupID"] == "1")
		{
			echo "1";
		}
		else if (!$group->DeleteGroup($_POST["GroupID"]))
		{
			echo "2";
		}
		else
		{
			echo "0";
		}
		
		$group = null;
	}
	else if (isset($_GET["deleteuser"]) && $Rights["can_manage_users"] == 1)
	{
		require_once("php/classes/User.class.php");
		
		$user = new User();
		
		if (!$user->DeleteUser($_POST["UserID"]))
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
		
		$user = null;
	}
	else if (isset($_GET["changepassword"]))
	{
		require_once("php/classes/User.class.php");
		
		$user = new User();
		
		if (!$user->CheckUserData($_SESSION["Username"], $_POST["OldPW"]))
		{
			echo "1";
		}
		else if (($e = $user->CheckPassword($_POST["PW1"], $_POST["PW2"])) != 0)
		{
			if ($e == 1)
			{
				echo "2";
			}
			else if ($e == 2)
			{
				echo "3";
			}
			else if ($e == 3)
			{
				echo "4";
			}
		}
		else if (!$user->ChangePassword($_SESSION["Username"], $_POST["PW1"]))
		{
			echo "5";
		}
		else
		{
			echo "0";
		}
		
		$user = null;
	}
	else if (isset($_GET["deletefile"]) && $Rights["can_delete_files"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		
		if (!$file->DeleteFile("../client/".$_GET["deletefile"]))
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
		
		$file = null;
	}
	else if (isset($_GET["deletedirectory"]) && $Rights["can_delete_files"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		
		if ($file->DeleteRecursive("../client/".$_GET["deletedirectory"]) != "0")
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
		
		$file = null;
	}
	else if (isset($_GET["uploadzip"]) && $Rights["can_upload_files"] == 1)
	{
		$filename = sprintf("tmp/%s.zip", basename($_FILES["file"]["tmp_name"]));
		move_uploaded_file($_FILES["file"]["tmp_name"], $filename);
		echo $filename;
	}
	else if (isset($_GET["uploadpatcher"]) && $Rights["can_upload_newpatcher"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		if (!$file->SetNewVersion($_POST["Version"]))
		{
			echo "1";
		}
		else if (move_uploaded_file($_FILES["file"]["tmp_name"], "../update/Patcher.exe"))
		{
			echo "0";
		}
		else
		{
			echo "2";
		}
		
		$file = null;
	}
	else if (isset($_GET["unpackzip"]) && $Rights["can_manage_files"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		
		if ($file->UnpackZIP($_GET["unpackzip"], "tmp/"))
		{
			unlink($_GET["unpackzip"]);
			echo "0";
		}
		else
		{
			unlink($_GET["unpackzip"]);
			$file->DeleteRecursive("tmp/client/");
			echo "1";
		}
		
		$file = null;
	}
	else if (isset($_GET["movefiles"]) && $Rights["can_manage_files"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		
		$file->MoveFiles("tmp/client/", "../client/");
		$file->DeleteRecursive("tmp/client/");
		echo 0;
		
		$file = null;
	}
	else if (isset($_GET["adddeletedfile"]) && $Rights["can_manage_delete_client_files"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		
		if ($file->CheckDeletedFileExistsInDB($_POST["File"]))
		{
			echo "1";
		}
		else if (!$file->AddDeletedFile($_POST["File"]))
		{
			echo "2";
		}
		else
		{
			echo "0";
		}
		
		$file = null;
	}
	else if (isset($_GET["deletepattern"]) && $Rights["can_manage_delete_client_files"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		
		if (!$file->DeletePattern($_GET["deletepattern"]))
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
		
		$file = null;
	}
	else if (isset($_GET["generatepatchlist"]) && $Rights["can_generate_patchlist"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		
		if (!$file->GeneratePatchlist())
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
		
		$file = null;
	}
	else if (isset($_GET["savepatchlist"]) && $Rights["can_edit_patchlist"] == 1)
	{
		require_once("php/classes/Files.class.php");
		
		$file = new Files();
		
		$file->SavePatchlist($_POST["Patchlist"]);
		echo "0";
		
		$file = null;
	}
	else
	{
		echo "r";
	}
}
?>