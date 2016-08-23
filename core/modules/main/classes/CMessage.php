<?
class CMessage 
{
	function SendMessage($arFieldsProp)
	{
		global $DB;
		if (is_array($arFieldsProp))
		{
			$arFieldsProp = array_merge(
				$arFieldsProp,
				array(
					"DATE_MESSAGE" => microtime(true),
				)
			);
			$strTableElName = $DB->GetTableFields("po_message");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("po_message",$arFieldsProp,$strTableElName));

			$DB->Query("INSERT INTO po_message(".$sqlElColum.") VALUES (".$sqlElValues.");");	
					
			$DB->Query('SELECT MAX(ID) FROM `po_message`');
			return $DB->db_EXEC->fetchColumn();	
		}
	}
	function ShowMessage($arFieldsProp)
	{
		global $DB;
		if (is_array($arFieldsProp))
		{
			$strTableElName = $DB->GetTableFields("po_message");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("po_message",$arFieldsProp,$strTableElName));
			$DB->Query(
				 "SELECT * FROM `po_message` "
				."WHERE "
				."(`USER_ID` = '".$sqlElAll["USER_TO"]."' AND `USER_TO` = '".$sqlElAll["USER_ID"]."') "
				."OR "
				."(`USER_ID` = '".$sqlElAll["USER_ID"]."' AND `USER_TO` = '".$sqlElAll["USER_TO"]."') "
				."ORDER BY `DATE_MESSAGE` ASC"
			);

			return ($DB->DBprint());
		}
	}
}