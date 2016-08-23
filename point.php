<?php
header('Content-type: application/json');
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

////////////////////////////////////////////////////
$REST = new CRestMethod;	
	


$filelist = array();
if ($get = $REST->method("get","/archive/{%}/"))
{
	$filelist[] = $get;
}



if ($get = $REST->method("get","/archive/{%}/{%}/"))
{
	$filelist[] = $get;
}

if ($post = $REST->method("post","/archive/"))
{
	$filelist[] = $post;
}
if ($put = $REST->method("put","/archive/"))
{
	$filelist[] = $put;
}
if ($delete = $REST->method("delete","/robots/{%}/"))
{
	$filelist[] = $delete;
}



///запись
if ($filelist)
{
	$json = json_encode($filelist);
	file_put_contents('./tmp/json_'.microtime(true).'.json', $json);
	echo $json;
}

?>
