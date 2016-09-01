<?
class CRestMethod{
	
	function resultQuery()
	{
		$result = array();
		$data = file_get_contents('php://input'); 
		$exploded = explode('&', $data);  
		foreach($exploded as $pair) 
		{ 
			$item = explode('=', $pair); 
			if(count($item) == 2) 
			{ 
				$result[urldecode($item[0])] = urldecode($item[1]); 
			} 
		}
		return $result;
		
	}

	function method($name,$get_uri)
	{
		$stop = false;
		$request = explode('/',  substr(trim($_SERVER['QUERY_STRING'],'/'),6));
		$call_request = $get_uri = explode('/', trim($get_uri,'/'));
		
		if (count($request) == count($get_uri))
		{
			foreach ($request as $key=>&$request_uriEl)
			{
				$get_uri[$key] = str_replace("{%}",$request_uriEl,$get_uri[$key]);
				if($request_uriEl != $get_uri[$key]) 
				{
					$stop = true;
				}
			}
		}
		else
		{
			$stop = true;
		}
		
		if((strtoupper($_SERVER['REQUEST_METHOD']) == strtoupper($name)) && $stop == false)
		{
			return array("METHOD"=>$name,"PARAMS"=>$this->resultQuery(),"REQUEST"=>$request,"CALL_REQUEST"=>$call_request);
		}
	}
}