<?php
/**
 * @package MIS
 * @name Redirect
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Redirect{
		public static function to($location = NULL){
				if($location){
						if(is_numeric($location)){
								switch($location){
										case 404:
											header('HTTP/1.0 404 Not Found');
											include 'includes/errors/404.php';
											exit();	
									}
							}
						header('Location: '. $location);
						exit();
					}
			}
	}
?>