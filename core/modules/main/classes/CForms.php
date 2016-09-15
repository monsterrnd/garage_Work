<?
class CForms
{
	static function TypeFilds($fildType, $name = "", $value = "", $disabled = "", $req = "", $errorMsg = "", $class = "")
	{
		$res = "";
		switch ($fildType)
		{
			case "TEXT":			
				$res =  "<input " 
					. "type=\"text\" "
					. "c-data-needed=\"".(($req == "Y") ? "1" : "0")."\" "
					. "c-data-name=\"".$errorMsg."\" " 
					. ((!empty($name)) ? (" name=\"".$name."\" ") : "") 
					. "class=\"form-control ".$class."\" "
					. ((!empty($name)) ? (" id=\"".$name."_input\" ") : "")
					. ((!empty($value)) ? (" value=\"".$value."\" ") : "")
					. (($disabled == "Y") ? ("disabled=\"disabled\" ") : "")
					. ">\n";

			break;
			case "HIDDEN":			
				$res =  "<input " 
					. "type=\"hidden\" "
					. "c-data-needed=\"0\" "
					. "c-data-name=\"\" " 
					. ((!empty($name)) ? (" name=\"".$name."\" ") : "") 
					. "class=\"".$class."\" "
					. ((!empty($name)) ? (" id=\"".$name."_input\" ") : "")
					. ((!empty($value)) ? (" value=\"".$value."\" ") : "")
					. ">\n";

			break;
			case "SELECT":
				$res =  "<select "
					. "rows=\"5\" "
					. "cols=\"45\" "
					. "c-data-needed=\"".(($req == "Y") ? "1" : "0")."\" "
					. "c-data-name=\"".$errorMsg."\" " 
					. ((!empty($name)) ? (" name=\"".$name."\" ") : "") 
					. "class=\"form-control ".$class."\" "
					. ((!empty($name)) ? (" id=\"".$name."_input\" ") : "")
					. (($disabled == "Y") ? ("disabled=\"disabled\" ") : "")
					. ">"
					. $value
					. "</select>\n";
			break;
			case "TEXTAREA":
				$res =  "<textarea "
					. "rows=\"5\" "
					. "cols=\"45\" "
					. "c-data-needed=\"".(($req == "Y") ? "1" : "0")."\" "
					. "c-data-name=\"".$errorMsg."\" " 
					. ((!empty($name)) ? (" name=\"".$name."\" ") : "") 
					. "class=\"form-control ".$class."\" "
					. ((!empty($name)) ? (" id=\"".$name."_input\" ") : "")
					. (($disabled == "Y") ? ("disabled=\"disabled\" ") : "")
					. ">"
					. $value
					. "</textarea>\n";
				
			break;
		
			case "YN":	
				$res =  "<input " 
					. "type=\"checkbox\" "
					. "c-data-needed=\"".(($req == "Y") ? "1" : "0")."\" "
					. "c-data-name=\"".$errorMsg."\" " 
					. ((!empty($name)) ? (" name=\"".$name."\" ") : "") 
					. ((!empty($class)) ? (" class=\"".$name."\" ") : "") 
					. ((!empty($name)) ? (" id=\"".$name."_input\" ") : "")
					. (($value == "Y") ? ("checked=\"checked\" ") : "")
					. (($disabled == "Y") ? ("disabled=\"disabled\" ") : "")
					. ">\n";			
			break;
		}
		return $res;

	}
}
?>