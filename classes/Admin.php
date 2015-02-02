<?php

 /**
 * @package MIS
 * @name Admin
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */

class Admin{
	private $_id,
			$_username,
			$_privilege,
			$_mobile,
			$_blocked,
			$_name,
			$_db;
	
	private function _connect(){
		$this->_db = new MySQLi(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
		if($this->_db->connect_errno){
			die("MySQL Error : " . $this->_db->connect_error);
		}
    }
	public function setUsername($username){
		$this->_username = $username;
	}
	public function getUsername(){
		return $this->_username;
	}
	public function setMobile($mobile){
		$this->_mobile = $mobile;
	}
	public function getMobile(){
		return $this->_mobile;
	}
	public function setName($name){
		$this->_name = $name;
	}
	public function getName(){
		return $this->_name;
	}
	public function setPrivilege($privilege){
		$this->_privilege = $privilege;
	}
	public function getPrivilege(){
		return $this->_privilege;
	}
	
    /**
     * createAdmin function is used to create Admin user id for MIS system.
     *
     * @return 0,1
     * @param str $name, str $username, str $password, str $privilege, int $mobile
     * @author  Harsh Vardhan Ladha
     */
	public function createAdmin($name, $username,$password,$mobile){
		if(1){
			$this->_connect();
			$name = $this->_db->real_escape_string(escape($name));
			$username = $this->_db->real_escape_string(escape($username));
			$mobile = $this->_db->real_escape_string(escape($mobile));
			$password = $this->_db->real_escape_string($password);
			$salt = Hash::salt(24);
			$hash = Hash::make($password,$salt);
			
			$query = "INSERT INTO admin (name,username,password,salt,privilege,mobile) VALUES ('".$name."','".$username."','".$hash."','".$salt."','admin','".$mobile."')";
			$result = $this->_db->query($query);
			if($this->_db->affected_rows){
				if($this->_db->error==''){
					return 1;
				}
				else{
					die($this->_db->error);
				}
			}
			else
				return 0;
		}
		else
			return 0;
	}
	public function loginAdmin($username,$password){
		$this->_connect();
		Session::put('type','admin');
		$log = new Log();
		$log->loginLog('attempt');
		$username = $this->_db->real_escape_string(escape($username));
		$password = $this->_db->real_escape_string($password);
		$sq =  "SELECT salt FROM admin WHERE username='".$username."'";
		$rq = $this->_db->query($sq);
		if(!$rq->num_rows){
			return 0;
		}
		$salt = $rq->fetch_object()->salt;
		$query = "SELECT * FROM admin WHERE username='".$username."' AND password='".Hash::make($password,$salt)."' AND blocked=0 LIMIT 1";
		$result = $this->_db->query($query);
		if($this->_db->query($query)){
			if($result->num_rows){
				while($value = $result->fetch_object()){
					$this->_id = $value->id;
					$this->_name = $value->name;
					$this->_username = $value->username;
					$this->_privilege = $value->privilege;
					$this->_mobile = $value->mobile;
                    
                    // Setting Session Variables !! 
					Session::put('admin_id',$this->_id);
					Session::put('admin_username', $this->_username);
                    Session::put('displayname', $this->_name);
					Session::put('privilege',$this->_privilege);
					Session::put('mobile',$this->_mobile);
				}
				return 1;
			}
			else{
				$log->loginLog('wrong credentials');
				Session::destroy();
				return 0;
			}
		}
		else{
			die($this->_db->error);
		}
	}
	
}/*
require_once '../core/init.php';
$a = new Admin();
echo $a->createAdmin('Administrator', 'admin', 'mis@1234', '8254065254');
*/
?>
