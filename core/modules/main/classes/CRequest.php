<?
class CRequest{
	
	
	static function getRequest($val)
	{
		$reqest = array();
		
		foreach($_GET as $getKey=>$get)
		{
			$reqest[$getKey] = $get;
		}
		
		foreach($_POST as $postKey=>$post)
		{
			$reqest[$postKey] = $post;
		}
		return $reqest[$val];
	}
	
	static function GetPageParam($add_params = "", $remove_params = array())
	{
		$res = "";
		$new_GET = $_GET;

		foreach ($remove_params as $remove_paramsEL)
		{
			unset($new_GET[$remove_paramsEL]);
		}
		$new_GET = array_merge($new_GET,$add_params);
		
		
		foreach ($new_GET as $key=>$arItem) 
		{
				if(strlen($arItem))
				{
					if($res=="")
						$res = "?";
					else
						$res .= "&";

					$res .= $key."=".$arItem;
				}
		}
		//print_r($res);
		return $res;
	}
}
?>
