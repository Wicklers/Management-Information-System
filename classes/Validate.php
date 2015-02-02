<?php

/**
 * Used to validate input fields
 * @package MIS
 * @name Validate
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Validate{
		private $_passed = false,
				$_errors = array(),
				$_db = NULL;
		public function __construct() {
				//$_db = new MySQLi(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
			}
			/**
			**********************************
			**	$source = $_POST or $_GET etc..
			**	$items = array(
								'username' => array(
									'required' => true, // don't use this required when field is actually not required
									'min'	=>	2,
									'max' =>	20,
									'unique' => 'users' // here 'users'  is a column in user_info which is checked for uniqueness
								),
								'password' => array(
									'required' => true,
									'min' => 6
								),
								'password_again' => array(
									'required' => true,
									'matches' => 'password' // self understandable :P
								)
							)
			**************************************
			*/
			
		public function check($source, $items=array()) {
				foreach($items as $item => $rules){
						foreach($rules as $rule => $rule_value){
						        
								$value = (isset($source[$item])?trim($source[$item]):"");
								$item = escape($item);
								if($rule === 'required' && empty($value)){
										$this->addError("{$item} is required");
									}
								else if(!empty($value)){
										switch($rule){
												case 'min':
													if(strlen($value) < $rule_value){
															$this->addError("{$item} must be minimum of {$rule_value} characters.");
														}
												break;
												case 'max':
													if(strlen($value) > $rule_value){
															$this->addError("{$item} must be maximum of {$rule_value} characters.");
														}
												
												break;
												case 'matches':
													if($value != $source[$rule_value]) {
															$this->addError("{$rule_value} must match {$item}");
														}
												break;
												case 'unique':
													$result = $this->_db->query("SELECT id FROM user_info WHERE {$rule_value} = $value");
													if($result->num_rows){
															$this->addError("{$item} : {$value} already exists");
														}
												break;
												case 'email':
													if(!validateEmail($value)){
														$this->addError("{$item} is invalid");
													}
												break;
											}
									}
							}
					}
				if(empty($this->_errors)){
						$this->_passed=true;
					}
			}
		public function addError($error){
				$this->_errors[] = $error;
			}
		/**
		 * Returns all the errors input fields have after validation test has been passed
		 * @return String
		 */
		public function errors(){
				return $this->_errors;
			}
		
		/**
		 * check if validation for input fields have been passed successfully or not
		 * @return boolean
		 */
		public function passed(){
				return $this->_passed;
			}
		
	}
?>