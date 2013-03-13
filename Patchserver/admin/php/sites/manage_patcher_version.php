<?php
require_once("php/classes/Files.class.php");
$file = new Files();

$smarty->assign("Version", $file->GetCurrentPatcherVersion());

$file = null;
?>