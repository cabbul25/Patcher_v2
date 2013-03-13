<?php
require_once("php/classes/User.class.php");

$user = new User();

$smarty->assign("UserDetails", $user->GetUserDetails($_GET["user"]));
$smarty->assign("UserID", $_GET["user"]);

$user = null;

require_once("php/classes/Groups.class.php");

$groups = new Groups();

$smarty->assign("Groups", $groups->GetGroups());

$groups = null;
?>