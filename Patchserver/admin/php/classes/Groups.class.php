<?php
class Groups extends Database
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetGroups()
	{
		return $this->QuerySelect("SELECT GroupID, GroupName FROM Groups");
	}
	
	public function CheckGroupName($GroupName)
	{
		if (strlen($GroupName) < 3)
		{
			return 1;
		}
		else if (strlen($GroupName) > 20)
		{
			return 2;
		}
		else
		{
			return 0;
		}
	}
	
	public function CreateGroup($GroupName, $CanManageFiles, $CanUploadFiles, $CanDeleteFiles, $CanManageDeleteClientFiles, $CanManagePatchlist, $CanGeneratePatchliste, $CanEditPatchlist, $CanUploadNewpatcher, $CanManageUsers, $CanManageGroups)
	{
		if ($this->Query("INSERT INTO Groups (GroupName) VALUES (:GroupName)", array(":GroupName", $GroupName)))
		{
			$result = $this->QuerySelect("SELECT GroupID FROM Groups WHERE GroupName = :GroupName", array(":GroupName", $GroupName));
			if (count($result) == 1)
			{
				if ($this->Query("INSERT INTO Rights (GroupID, RightName, RightValue) VALUES (:GroupID, 'can_manage_files', :CanManageFiles), (:GroupID, 'can_upload_files', :CanUploadFiles), (:GroupID, 'can_delete_files', :CanDeleteFiles), (:GroupID, 'can_manage_delete_client_files', :CanManageDeleteClientFiles), (:GroupID, 'can_manage_patchlist', :CanManagePatchlist), (:GroupID, 'can_generate_patchlist', :CanGeneratePatchliste), (:GroupID, 'can_edit_patchlist', :CanEditPatchlist), (:GroupID, 'can_upload_newpatcher', :CanUploadNewpatcher), (:GroupID, 'can_manage_users', :CanManageUsers), (:GroupID, 'can_manage_groups', :CanManageGroups)", array(":GroupID" => $result[0]["GroupID"], ":CanManageFiles" => $CanManageFiles, ":CanUploadFiles" => $CanUploadFiles, ":CanDeleteFiles" => $CanDeleteFiles, ":CanManageDeleteClientFiles" => $CanManageDeleteClientFiles, ":CanManagePatchlist" => $CanManagePatchlist, ":CanGeneratePatchliste" => $CanGeneratePatchliste, ":CanEditPatchlist" => $CanEditPatchlist, ":CanUploadNewpatcher" => $CanUploadNewpatcher, ":CanManageUsers" => $CanManageUsers, ":CanManageGroups" => $CanManageGroups)))
				{
					return 0;
				}
				else
				{
					return 3;
				}
			}
			else
			{
				return 2;
			}
		}
		else
		{
			return 1;
		}
	}
	
	public function SaveGroup($GroupID, $GroupName, $CanManageFiles, $CanUploadFiles, $CanDeleteFiles, $CanManageDeleteClientFiles, $CanManagePatchlist, $CanGeneratePatchliste, $CanEditPatchlist, $CanUploadNewpatcher, $CanManageUsers, $CanManageGroups)
	{
		if (!$this->Query("UPDATE Groups SET GroupName = :GroupName WHERE GroupID = :GroupID", array(":GroupName" => $GroupName, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_manage_files'", array(":Value" => $CanManageFiles, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_upload_files'", array(":Value" => $CanUploadFiles, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_delete_files'", array(":Value" => $CanDeleteFiles, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_manage_delete_client_files'", array(":Value" => $CanManageDeleteClientFiles, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_manage_patchlist'", array(":Value" => $CanManagePatchlist, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_generate_patchlist'", array(":Value" => $CanGeneratePatchliste, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_edit_patchlist'", array(":Value" => $CanEditPatchlist, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_upload_newpatcher'", array(":Value" => $CanUploadNewpatcher, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_manage_users'", array(":Value" => $CanManageUsers, ":GroupID" => $GroupID)))
			return false;
		if (!$this->Query("UPDATE Rights SET RightValue = :Value WHERE GroupID = :GroupID AND RightName = 'can_manage_groups'", array(":Value" => $CanManageGroups, ":GroupID" => $GroupID)))
			return false;
		return true;
	}
	
	public function DeleteGroup($GroupID)
	{
		return $this->Query("DELETE FROM Groups WHERE GroupID = :GroupID", array(":GroupID" => $GroupID));
	}
	
	public function GetGroupDetails($GroupID)
	{
		$result = $this->QuerySelect("SELECT g.GroupName, r.RightName, r.RightValue FROM Groups AS g INNER JOIN Rights AS r ON g.GroupID = r.GroupID WHERE g.GroupID = :GroupID", array(":GroupID" => $GroupID));
		if (count($result) > 0)
		{
			$GroupName = $result[0]["GroupName"];
			$rights = array();
			foreach ($result as $key=>$val)
			{
				$rights[$val["RightName"]] = $val["RightValue"];
			}
			$response = array($GroupName, $rights);
			return $response;
		}
		else
		{
			return 0;
		}
	}
}
?>