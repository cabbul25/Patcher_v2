<?php
class Database extends SQLite3
{
	public function __construct()
	{
		parent::__construct("cnf/db/patcher.sqlite", SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
	}
	
	public function QuerySelect($query, $values = null)
	{
		$statement = $this->prepare($query);
		if (count($values) > 0)
		{
			foreach ($values as $key=>$val)
			{
				$statement->bindValue($key, $val);
			}
		}
		$result = $statement->execute();
		$arr = array();
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
		{
			array_push($arr, $row);
		}
		return $arr;
	}
	
	public function Query($query, $values = null)
	{
		$statement = $this->prepare($query);
		if (count($values) > 0)
		{
			foreach ($values as $key=>$val)
			{
				$statement->bindValue($key, $val);
			}
		}
		if ($statement->execute() == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}
?>