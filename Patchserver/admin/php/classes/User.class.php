<?php
class User extends Database
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetUsers()
	{
		return $this->QuerySelect("SELECT UserID, Username FROM User");
	}
	
	public function CheckUserData($Username, $Password)
	{
		$Password = bin2hex(mhash(MHASH_SHA512, sprintf("%s%s", strtolower($Username), $Password)));
		$count = $this->QuerySelect("SELECT count(UserID) AS count FROM User WHERE lower(Username) = lower(:Username) AND Password = :Password", array(":Username" => $Username, ":Password" => $Password));
		if ($count[0]["count"] >= 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function GetUserID($Username)
	{
		$result = $this->QuerySelect("SELECT UserID FROM User WHERE lower(Username) = lower(:Username)", array(":Username" => $Username));
		if (count($result) == 1)
		{
			return $result[0]["UserID"];
		}
		else
		{
			return "0";
		}
	}
	
	public function GetUsername($UserID)
	{
		$result = $this->QuerySelect("SELECT Username FROM User WHERE UserID = :UserID", array(":UserID" => $UserID));
		if (count($result) == 1)
		{
			return $result[0]["Username"];
		}
		else
		{
			return "0";
		}
	}
	
	public function CheckPassword($Password1, $Password2)
	{
		if ($Password1 != $Password2)
		{
			return 1;
		}
		else if (strlen($Password1) < 6)
		{
			return 2;
		}
		else if (strlen($Password1) > 30)
		{
			return 3;
		}
		else
		{
			return 0;
		}
	}
	
	public function ChangePassword($Username, $Password)
	{
		$Password = bin2hex(mhash(MHASH_SHA512, sprintf("%s%s", strtolower($Username), $Password)));
		return $this->Query("UPDATE User SET Password = :Password WHERE Username = :Username", array(":Password" => $Password, ":Username" => $Username));
	}
	
	public function CheckUsername($Username)
	{
		if (strlen($Username) < 5)
		{
			return 1;
		}
		else if (strlen($Username) > 16)
		{
			return 2;
		}
		else if (!preg_match("/[a-zA-Z0-9]{5,16}$/", $Username))
		{
			return 3;
		}
		else
		{
			$count = $this->QuerySelect("SELECT COUNT(UserID) AS count FROM User WHERE lower(Username) = lower(:Username)", array(":Username" => $Username));
			if ($count[0]["count"] == 0)
			{
				return 0;
			}
			else
			{
				return 4;
			}
		}
	}
	
	public function CreateUser($Username, $Password, $GroupID)
	{
		$Password = bin2hex(mhash(MHASH_SHA512, sprintf("%s%s", strtolower($Username), $Password)));
		return $this->Query("INSERT INTO User (Username, Password, GroupID) VALUES (:Username, :Password, :GroupID)", array(":Username" => $Username, ":Password" => $Password, ":GroupID" => $GroupID));
	}
	
	public function DeleteUser($UserID)
	{
		return $this->Query("DELETE FROM User WHERE UserID = :UserID", array(":UserID" => $UserID));
	}
	
	public function GetUserDetails($UserID)
	{
		$result = $this->QuerySelect("SELECT Username, GroupID FROM User WHERE UserID = :UserID", array(":UserID" => $UserID));
		if (count($result) > 0)
		{
			return array("Username" => $result[0]["Username"], "GroupID" => $result[0]["GroupID"]);
		}
		else
		{
			return 0;
		}
	}
	
	public function SaveUser($UserID, $GroupID, $Password = null)
	{
		if ($Password == null)
		{
			return $this->Query("UPDATE User SET GroupID = :GroupID WHERE UserID = :UserID", array(":GroupID" => $GroupID, ":UserID" => $UserID));
		}
		else
		{
			$Password = bin2hex(mhash(MHASH_SHA512, sprintf("%s%s", strtolower($this->GetUsername($UserID)), $Password)));
			return $this->Query("UPDATE User SET GroupID = :GroupID, Password = :Password WHERE UserID = :UserID", array(":GroupID" => $GroupID, ":Password" => $Password, ":UserID" => $UserID));
		}
	}
	
	public function GetRights($Username)
	{
		$Rights = array();
		$result = $this->QuerySelect("SELECT r.RightName, r.RightValue FROM User AS u INNER JOIN Rights AS r ON u.GroupID = r.GroupID WHERE lower(u.Username) = lower(:Username)", array(":Username" => $Username));
		foreach ($result as $key=>$val)
		{
			$Rights[$val["RightName"]] = $val["RightValue"];
		}
		return $Rights;
	}
}
?>