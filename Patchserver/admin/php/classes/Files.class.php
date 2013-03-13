<?php
class Files extends Database
{
	private $Files = array();
	private $Directories = array();
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetDirectories($directory)
	{
		$dirs = array();
		$handle = opendir($directory);
		while ($file = readdir($handle))
		{
			if ($file != "." && $file != "..")
			{
				if (is_dir($directory.$file))
				{
					array_push($dirs, preg_replace("|$directory|", "", $directory.$file));
				}
			}
		}
		closedir($handle);
		natcasesort($dirs);
		return $dirs;
	}
	
	public function GetDirectoriesForXML($directory)
	{
		$handle = opendir($directory);
		while ($datei = readdir($handle))
		{
			if ($datei != "." && $datei != "..")
			{
				if (is_dir($directory.$datei))
				{
					$return = preg_replace("|../client/|", "", $directory.$datei);
					$return = preg_replace("|/|", "\\", $return);
					array_push($this->Directories, $return);
					$this->GetDirectoriesForXML($directory.$datei.'/');
				}
			}
		}
		closedir($handle);
	}
	
	public function GetFiles($directory)
	{
		$files = array();
		$handle =  opendir($directory);
		while ($datei = readdir($handle))
		{
			if ($datei != "." && $datei != "..")
			{
				if (!is_dir($directory.$datei))
				{
					array_push($files, preg_replace("|$directory|", "", $directory.$datei));
				}
			}
		}
		closedir($handle);
		natcasesort($files);
		return $files;
	}
	
	public function GetFilesWithHash($directory)
	{
		$handle =  opendir($directory);
		while ($datei = readdir($handle))
		{
			if ($datei != "." && $datei != "..")
			{
				if (is_dir($directory.$datei))
				{
					$this->GetFilesWithHash($directory.$datei.'/'); 
				} else {
					$return = preg_replace("|../client/|", "", $directory.$datei);
					$return = preg_replace("|/|", "\\", $return);
					array_push($this->Files, array("FileName" => $return, "FileHash" => md5_file($directory.$datei)));
				}
			}
		}
		closedir($handle);
	}
	
	public function DeleteFile($File)
	{
		return unlink($File);
	}
	
	public function MoveFiles($source, $destiny)
	{ 
		$handle =  opendir($source);
		while ($file = readdir($handle))
		{
			if ($file != "." && $file != "..")
			{
				if (is_dir($source.$file))
				{
					$return = preg_replace("|tmp/client/|", "", $source.$file);
					echo $return;
					if (!is_dir($destiny.$return))
					{
						mkdir($destiny.$return);
					}
					$this->MoveFiles($source.$file.'/', $destiny); 
				} 
				else 
				{
					$return = preg_replace("|tmp/client/|", "", $source.$file);
					if (file_exists($destiny.$return))
					{
						unlink($destiny.$return);
						rename($source.$file, $destiny.$return);
					}
					else
					{
						rename($source.$file, $destiny.$return);
					}
				}
			}
		}
		closedir($handle);
	}
	
	function DeleteRecursive ($path) {
		// http://aktuell.de.selfhtml.org/artikel/php/verzeichnisse/
		// schau' nach, ob das ueberhaupt ein Verzeichnis ist
		if (!is_dir ($path)) {
			return -1;
		}
		// oeffne das Verzeichnis
		$dir = @opendir ($path);
		
		// Fehler?
		if (!$dir) {
			return -2;
		}
		
		// gehe durch das Verzeichnis
		while (($entry = @readdir($dir)) !== false) {
			// wenn der Eintrag das aktuelle Verzeichnis oder das Elternverzeichnis
			// ist, ignoriere es
			if ($entry == '.' || $entry == '..') continue;
			// wenn der Eintrag ein Verzeichnis ist, dann 
			if (is_dir ($path.'/'.$entry)) {
				// rufe mich selbst auf
				$res = $this->DeleteRecursive($path.'/'.$entry);
				// wenn ein Fehler aufgetreten ist
				if ($res == -1) { // dies duerfte gar nicht passieren
					@closedir ($dir); // Verzeichnis schliessen
					return -2; // normalen Fehler melden
				} else if ($res == -2) { // Fehler?
					@closedir ($dir); // Verzeichnis schliessen
					return -2; // Fehler weitergeben
				} else if ($res == -3) { // nicht unterstuetzer Dateityp?
					@closedir ($dir); // Verzeichnis schliessen
					return -3; // Fehler weitergeben
				} else if ($res != 0) { // das duerfe auch nicht passieren...
					@closedir ($dir); // Verzeichnis schliessen
					return -2; // Fehler zurueck
				}
			} else if (is_file ($path.'/'.$entry) || is_link ($path.'/'.$entry)) {
				// ansonsten loesche diese Datei / diesen Link
				$res = @unlink ($path.'/'.$entry);
				// Fehler?
				if (!$res) {
					@closedir ($dir); // Verzeichnis schliessen
					return -2; // melde ihn
				}
			} else {
				// ein nicht unterstuetzer Dateityp
				@closedir ($dir); // Verzeichnis schliessen
				return -3; // tut mir schrecklich leid...
			}
		}
		
		// schliesse nun das Verzeichnis
		@closedir ($dir);
		
		// versuche nun, das Verzeichnis zu loeschen
		$res = @rmdir ($path);
		
		// gab's einen Fehler?
		if (!$res) {
			return -2; // melde ihn
		}
		
		// alles ok
		return 0;
	}
	
	public function UnpackZIP($ZipName, $Destiny)
	{
		$zip = new ZipArchive;
		if ($zip->open($ZipName) === TRUE) {
			$zip->extractTo($Destiny);
			$zip->close();
			return true;
		} else {
			return false;
		}
	}
	
	public function CheckDeletedFileExistsInDB($FileName)
	{
		$count = $this->QuerySelect("SELECT count(PatternID) AS count FROM Deleted WHERE Name = :FileName", array(":FileName" => $FileName));
		if ($count[0]["count"] >= 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function AddDeletedFile($FileName)
	{
		return $this->Query("INSERT INTO Deleted (Name) VALUES (:FileName)", array(":FileName" => $FileName));
	}
	
	public function GetDeletedFiles()
	{
		return $this->QuerySelect("SELECT PatternID, Name FROM Deleted");
	}
	
	public function DeletePattern($PatternID)
	{
		return $this->Query("DELETE FROM Deleted WHERE PatternID = :PatternID", array(":PatternID" => $PatternID));
	}
	
	public function GeneratePatchlist()
	{
		$DeletedFiles = $this->GetDeletedFiles();
		$this->GetDirectoriesForXML("../client/");
		$this->GetFilesWithHash("../client/");
		
		$doc = new DOMDocument("1.0", "UTF-8");
		$doc->formatOutput = true;
		
		$patcher = $doc->createElement("PatchList");
		
		if (count($DeletedFiles) > 0)
		{
			$delfiles = $doc->createElement("DeleteFiles");
			foreach($DeletedFiles as $key=>$val)
			{
				$name = $doc->createElement("DeleteFile");
				$filename = $doc->createElement("Name", $val["Name"]);
				$name->appendChild($filename);
				$delfiles->appendChild($name);
			}
			$patcher->appendChild($delfiles);
		}
		if (count($this->Directories) > 0)
		{
			$patchdirectories = $doc->createElement("PatchDirectories");
			foreach ($this->Directories as $val)
			{
				$name = $doc->createElement("PatchDirectory");
				$filename = $doc->createElement("Name", $val);
				$name->appendChild($filename);
				$patchdirectories->appendChild($name);
			}
			$patcher->appendChild($patchdirectories);
		}
		if (count($this->Files) > 0)
		{
			$patchfiles = $doc->createElement("PatchFiles");
			foreach($this->Files as $val)
			{
				$file = $doc->createElement("PatchFile");
				$filename = $doc->createElement("Name", $val["FileName"]);
				$filehash = $doc->createElement("Hash", $val["FileHash"]);
				$file->appendChild($filename);
				$file->appendChild($filehash);
				$patchfiles->appendChild($file);
			}
			$patcher->appendChild($patchfiles);
		}
		
		$doc->appendChild($patcher);
		return $doc->save("../filelist/filelist.xml");
	}
	
	public function SavePatchlist($Patchlist)
	{
		$file = fopen("../filelist/filelist.xml", "w");
		fwrite($file, $Patchlist);
		fclose($file);
	}
	
	public function SetNewVersion($Version)
	{
		return $this->Query("INSERT INTO PatcherVersion (Version, Date) VALUES (:Version, datetime('now'))", array(":Version" => $Version));
	}
	
	public function GetCurrentPatcherVersion()
	{
		$result = $this->QuerySelect("SELECT Version FROM PatcherVersion ORDER BY VersionID DESC LIMIT 1");
		if (count($result) > 0)
		{
			return $result[0]["Version"];
		}
		else
		{
			return 0;
		}
	}
}
?>