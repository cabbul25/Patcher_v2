<?php
require_once("php/classes/Groups.class.php");

$group = new Groups();

$smarty->assign("GroupDetails", $group->GetGroupDetails($_GET["group"]));
$smarty->assign("GroupID", $_GET["group"]);

$group = null;
?>