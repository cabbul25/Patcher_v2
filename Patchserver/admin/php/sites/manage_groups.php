<?php
require_once("php/classes/Groups.class.php");

$groups = new Groups();

$smarty->assign("Groups", $groups->GetGroups());

$groups = null;
?>