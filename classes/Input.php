<?php
/**
 * @package MIS
 * @name Input
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Input{
		public static function exists($type='post'){
				switch($type){
						case 'post':
							return (!empty($_POST))?true:false;
						break;
						case 'get':
							return (!empty($_GET))?true:false;
						break;
						default:
							return false;
						break;
					}
			}
		public static function get($item){
				if(isset($_POST[$item])){
						return $_POST[$item];
					}
				else if(isset($_GET[$item])){
						return $_GET[$item];
					}
				return '';
			}
		public static function image($item, $filename){
			$image_tempname1 = $_FILES[$item]['name'];
			$ImageName = $image_tempname1;
			if(move_uploaded_file($_FILES[$item]['tmp_name'], $ImageName))
			{
				list($width, $height, $type, $attr) = getimagesize($ImageName);
				if($type==2)
				{
					rename($ImageName, $filename);
				}
				else
				{
					If($type==1)
					{
						$image_old = imagecreatefromgif($ImageName);
					}
					ElseIf($type==3)
					{
						$image_old = imagecreatefrompng($ImageName);
					}
					$image_jpg = imagecreatetruecolor($width, $height);
					imagecopyresampled($image_jpg, $image_old,0,0,0,0,$width,$height,$width,$height);
					imagejpeg($image_jpg, $filename);
					imagedestroy($image_old);
					imagedestroy($image_jpg);
				}
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public static function file($item, $filename){
			$tempname1 = $_FILES[$item]['name'];
			$Name = $tempname1;
			if(move_uploaded_file($_FILES[$item]['tmp_name'], $Name))
			{
				rename($Name,$filename);
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public static function fileexists($item){
			return (!empty($_FILES[$item]['name']))?true:false;
			return false;
		}
		public static function filename($item){
			return $_FILES[$item]['name'];
		}
	}
?>