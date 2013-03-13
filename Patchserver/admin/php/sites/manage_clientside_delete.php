<?php
require_once("php/classes/Files.class.php");

$files = new Files();

$smarty->assign("DeletedFiles", $files->GetDeletedFiles());

$files = null;
?>