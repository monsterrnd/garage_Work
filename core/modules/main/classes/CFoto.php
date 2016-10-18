<?php
class CFoto
{
	public $status ="";
	public $format = array("jpg","jpeg","png","gif");
	public $max_size = 5242880; ///5mb

	
	function AddPhotoFile($dir,$file,&$newpath)
	{
		$name = md5(microtime(true));

		if ($file["error"] == UPLOAD_ERR_OK && $file["size"] < $this->max_size) {
			$tmp_name = $file["tmp_name"];
			$ext = explode(".",$file["name"]);
			$ext = end($ext);
			if (in_array($ext, $this->format))
			{
				$newpath = $_SERVER["DOCUMENT_ROOT"].$dir."/".$name.".".$ext;;
				if (move_uploaded_file($tmp_name, $newpath))
				{
					
					$this->status = "Файл загружен успешно.";
					return true;
				}
				else
					$this->status = "Файл поврежден.";
			}
			else
				$this->status = "Неверный формат. доступные расширения: ".  implode(", ", $this->format);
			
		}
		else 
		{
			$this->status = "Размер Файла больше ".($this->max_size / 1024 / 1024)."Мб, или файл поврежден.";
		}
	}
	
	function ScaleImage($sourceImageWidth, $sourceImageHeight, $arSize, $resizeType = "proportional", &$bNeedCreatePicture, &$arSourceSize, &$arDestinationSize)
	{
		if (!is_array($arSize))
			$arSize = array();
			
		if (!array_key_exists("width", $arSize) || intval($arSize["width"]) <= 0)
			$arSize["width"] = 0;
			
		if (!array_key_exists("height", $arSize) || intval($arSize["height"]) <= 0)
			$arSize["height"] = 0;
			
		$arSize["width"] = intval($arSize["width"]);
		$arSize["height"] = intval($arSize["height"]);

		$bNeedCreatePicture = false;
		$arSourceSize = array("x" => 0, "y" => 0, "width" => 0, "height" => 0);
		$arDestinationSize = array("x" => 0, "y" => 0, "width" => 0, "height" => 0);

		if ($sourceImageWidth > 0 && $sourceImageHeight > 0)
		{
			if ($arSize["width"] > 0 && $arSize["height"] > 0)
			{
				switch ($resizeType)
				{
					case "exact":
						$bNeedCreatePicture = true;

						$ratio = (($sourceImageWidth / $sourceImageHeight) < ($arSize["width"] / $arSize["height"])) ?
							$arSize["width"] / $sourceImageWidth : $arSize["height"] / $sourceImageHeight;

						$x = max(0, round($sourceImageWidth / 2 - ($arSize["width"] / 2) / $ratio));
						$y = max(0, round($sourceImageHeight / 2 - ($arSize["height"] / 2) / $ratio));

						$arDestinationSize["width"] = $arSize["width"];
						$arDestinationSize["height"] = $arSize["height"];

						$arSourceSize["x"] = $x;
						$arSourceSize["y"] = $y;
						$arSourceSize["width"] = round($arSize["width"] / $ratio, 0);
						$arSourceSize["height"] = round($arSize["height"] / $ratio, 0);

						break;
					default:
						if ($resizeType == "proportional")
						{
							$width = max($sourceImageWidth, $sourceImageHeight);
							$height = min($sourceImageWidth, $sourceImageHeight);
						}
						else
						{
							$width = $sourceImageWidth;
							$height = $sourceImageHeight;
						}
						$ResizeCoeff["width"] = $arSize["width"] / $width;
						$ResizeCoeff["height"] = $arSize["height"] / $height;

						$iResizeCoeff = min($ResizeCoeff["width"], $ResizeCoeff["height"]);
						$iResizeCoeff = ((0 < $iResizeCoeff) && ($iResizeCoeff < 1) ? $iResizeCoeff : 1);
						$bNeedCreatePicture = ($iResizeCoeff != 1 ? true : false);

						$arDestinationSize["width"] = max(1, intval($iResizeCoeff * $sourceImageWidth));
						$arDestinationSize["height"] = max(1, intval($iResizeCoeff * $sourceImageHeight));

						$arSourceSize["x"] = 0;
						$arSourceSize["y"] = 0;
						$arSourceSize["width"] = $sourceImageWidth;
						$arSourceSize["height"] = $sourceImageHeight;
						break;
				}
			}
			else
			{
				$arSourceSize = array("x" => 0, "y" => 0, "width" => $sourceImageWidth, "height" => $sourceImageHeight);
				$arDestinationSize = array("x" => 0, "y" => 0, "width" => $sourceImageWidth, "height" => $sourceImageHeight);
			}
		}
	}
	
	function FotoResize($path_in, $arParams,$qa = 100) 
	{
		ini_set("memory_limit","256M");
		list($sourceImageWidth,$sourceImageHeight,$type) = getimagesize($path_in);
		switch($type) 
		{	
			case "1" : $img = @imagecreatefromgif($path_in); break;
			case "2" : $img = @imagecreatefromjpeg($path_in); break;
			case "3" : $img = @imagecreatefrompng($path_in); break;
		}
		
		$exif = @exif_read_data($path_in);
		
		if(!empty($exif['Orientation'])) 
		{
			switch($exif['Orientation']) 
			{
				case 8: 
					$img = imagerotate($img,90,0);
					list($sourceImageWidth,$sourceImageHeight) =  array($sourceImageHeight,$sourceImageWidth);
				break;
				case 3: 
					$img = imagerotate($img,180,0);	
					
				break;
				case 6: 
					$img = imagerotate($img,-90,0);
					list($sourceImageWidth,$sourceImageHeight) =  array($sourceImageHeight,$sourceImageWidth);
				break;
			}
		}
	
		if ($img)
		{	
			foreach ($arParams as $arParamsEl)
			{
				$arSize = array("width"=>$arParamsEl["width"],"height"=>$arParamsEl["height"]);
				$this->ScaleImage($sourceImageWidth, $sourceImageHeight, $arSize, $arParamsEl["resize_type"], $bNeedCreatePicture, $arSourceSize, $arDestinationSize);
				$img_new_size = imagecreatetruecolor($arDestinationSize["width"], $arDestinationSize["height"]);

				imagecopyresampled(
					$img_new_size, $img, 
					$arDestinationSize["x"], $arDestinationSize["y"],
					$arSourceSize["x"], $arSourceSize["y"], 
					$arDestinationSize["width"], $arDestinationSize["height"], 
					$arSourceSize["width"], $arSourceSize["height"]
				);	

				imagejpeg($img_new_size, $_SERVER["DOCUMENT_ROOT"].$arParamsEl["out"], $qa);
			}
		}
			
	}	
}