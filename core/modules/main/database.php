<?
class CDatabase
{
	var $DBEngine; 
	var $DBName;
	var $DBHost;
	var $DBLogin;
	var $DBPassword;
	var $db_Conn;
	var $db_EXEC;
	var $column_cache = array();
	var $setParamsFrist = array();
	
	function Connect($DBHost,$DBEngine, $DBName, $DBLogin, $DBPassword)
	{
		$this->DBEngine=$DBEngine;
		$this->DBHost = $DBHost;
		$this->DBName = $DBName;
		$this->DBLogin = $DBLogin;
		$this->DBPassword = $DBPassword;

		return $this->DoConnect();
	}
	
	function DoConnect()
	{
		try {
			$enh = $this->DBEngine.':dbname='.$this->DBName.";host=".$this->DBHost; 
			$this->db_Conn = new PDO($enh, $this->DBLogin, $this->DBPassword);
		} catch (PDOException $errMysql) {
				echo "<font color=#ff0000>Error! ".$errMysql->getMessage()."</font><br>";
			return false;
		}
		return true;
	}	
	

	
	function Query($strSql, $bIgnoreErrors=false)
	{

		echo "<div style=\"border:1px solid #f00; color: #f00; padding: 10px; margin: 10px 0;\">";
		print_r($strSql);
		
		
		$start_timeSQL = microtime();
		$start_arraySQL = explode(" ",$start_timeSQL);
		$start_timeSQL = $start_arraySQL[1] + $start_arraySQL[0];
		
		$this->db_EXEC = $this->db_Conn->prepare($strSql);
		$this->Execute();
		
		$end_timeSQL = microtime();
		$end_arraySQL = explode(" ",$end_timeSQL);
		$end_timeSQL = $end_arraySQL[1] + $end_arraySQL[0];
		$timeSQL = $end_timeSQL - $start_timeSQL;
		echo "<br><b>";
		printf("Запрос за %f секунд",  $timeSQL);
		echo "</b></div>";
		
		return true;
	}	
	

	function Execute()
	{
		$this->db_EXEC->execute();
		return true;
	}	

	
	function StartTransaction()
	{
		$this->db_Conn->beginTransaction();
	}

	function Commit()
	{
		$this->db_Conn->commit();
	}

	function Rollback()
	{
		$this->db_Conn->rollBack();
	}	
	
	function DBprint()
	{
		$res = $this->db_EXEC->fetchAll(PDO::FETCH_CLASS);
		foreach ($res as &$elres)
		{
			$elres = (array)$elres;
		}
		return $res;
	}
	
	function getTimeToMicroseconds($t) 
	{
		$micro = sprintf("%06d", ($t - floor($t)) * 1000000);
		$d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));

		return $d->format("Y-m-d H:i:s"); 
	}	
	
	function KeySession($regenerate = false)
	{
		if (isset($_SESSION['public_key']) && ! $regenerate)
		{
			$key = $_SESSION['public_key'];
		} 
		else 
		{
			$key = hash_hmac('sha1', microtime(), mt_rand());
			$_SESSION['public_key'] = $key;
		}
		return $key;
	}
	/////////////////////////////////////////////////////////////////////////////
	//////$this->column_cache[$table]=
	//////[DESCRIPTION_47] => Array
    //////(																		
    //////	[NAME] => DESCRIPTION_47
    //////	[TYPE] => VAR_STRING
    //////)
	/////////////////////////////////////////////////////////////////////////////
	function GetTableFields($table)
	{
		if(!array_key_exists($table, $this->column_cache))
		{
			$this->column_cache[$table] = array();
			$select = $this->db_Conn->query('SELECT * FROM '.$table." LIMIT 1");
			$total_column = $select->columnCount();

			for ($counter = 0; $counter < $total_column; $counter ++) 
			{
				$meta = $select->getColumnMeta($counter);
				$rs[] = $meta;
				$ar = array(
				 "NAME" => $rs[$counter]["name"],
				 "TYPE" => $rs[$counter]["native_type"],
				);
				$this->column_cache[$table][$ar["NAME"]] = $ar;
			}	
		}
		return $this->column_cache[$table];
		
	}
	///////////////////////////////////////////////////////////////////////////
	function ForSql($strValue, $iMaxLength = 0)
	{
		if ($iMaxLength > 0)
			$strValue = substr($strValue, 0, $iMaxLength);
		//return $this->db_Conn->quote($strValue);
		return $strValue;
	}
	////////////////////////////////////////////////////////////////////////////
	function PrepareInsert($strTableName, $arFields, $strNoTable="", $offst=false)
	{
		$strInsert1 = "";
		$strInsert2 = "";
		$strInsert3 = "";
		if ($strNoTable == "")
		{
			$arColumns = $this->GetTableFields($strTableName);
		}
		else
		{
			$arColumns = $strNoTable;
		}
		foreach($arColumns as $strColumnName => $arColumnInfo)
		{
			$type = $arColumnInfo["TYPE"];
			if(isset($arFields[$strColumnName]))
			{
				
				$value = $arFields[$strColumnName];
				$strInsert3[$strColumnName] = $value;
				if($value === false)
				{
					$strInsert1 .= ", `".$strColumnName."`";
					$strInsert2 .= ",  NULL ";
				}
				else
				{
					$strInsert1 .= ", `".$strColumnName."`";
					switch ($type)
					{
						case "DATETIME":
								$strInsert2 .= ", NULL ";
							break;
						case "DATE":
						case "TIMESTAMP":
								$strInsert2 .= ", NULL ";
							break;
						case "LONG":
							$strInsert2 .= ", '".IntVal($value)."'";
							break;
						case "REAL":
							$strInsert2 .= ", '".DoubleVal($value)."'";
							break;
						default:
							$strInsert2 .= ", '".$this->ForSql($value)."'";
					}
				}
			}
			elseif(array_key_exists("~".$strColumnName, $arFields))
			{
				$strInsert1 .= ", `".$strColumnName."`";
				$strInsert2 .= ", ".$arFields["~".$strColumnName];
			}
		}

		if($strInsert1!="")
		{
			$strInsert1 = substr($strInsert1, 2);
			$strInsert2 = substr($strInsert2, 2);
		}
		if ($offst == false)
		{
			return array($strInsert1, $strInsert2, $strInsert3);
		}
		else
		{
			return "(".$strInsert2.")";
		}
	}

	function insertQuery($table,$arFields)
	{
		$arInsert = $this->PrepareInsert($table, $arFields);
		$this->Query("INSERT INTO ".$table."(".$arInsert[0].") VALUES(".$arInsert[1].")");
		return true;
	}		

}
?>