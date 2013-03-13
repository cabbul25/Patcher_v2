<?php
require_once("php/classes/User.class.php");

$user = new User();

$smarty->assign("Users", $user->GetUsers());

$user = null;
?>