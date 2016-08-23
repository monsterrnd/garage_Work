<?
class PoRequest{
	
	
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
	
}
?>
