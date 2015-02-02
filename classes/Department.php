<?php
/**
 * @package MIS
 * @name Department
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Department{
	private $_dept_id,
			$_name,
			$_db;
	
	public function __construct(){
		$this->_dept_id=NULL;
		$this->_name=NULL;
		$this->_db=NULL;
	}
	
	private function _connect(){
		$this->_db = new MySQLi(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
		if($this->_db->connect_errno){
			die("MySQL Error : " . $this->_db->connect_error);
		}
	}
	public function getDepName(){
		return ($this->_name!=NULL)?$this->_name:NULL;
	}
	public function add($dept_id='',$name=''){
		
		if(loggedIn() && (privilege()==='teacher' || privilege()==='dppc' || privilege()==='dupc')){
			return 3;
		}
		else if(loggedIn()){
			if($this->getInfobyName($name) || $this->getInfo($dept_id)){
				return 2;
			}
			else{
				$this->_connect();
				$this->_dept_id = $this->_db->real_escape_string(escape($dept_id));
				$this->_name = $this->_db->real_escape_string(escape($name));
				$query = "INSERT INTO department(dept_id,name) VALUES ('".$this->_dept_id."', '".$this->_name."')";
				$result = $this->_db->query($query);
				if($this->_db->affected_rows){
					if($this->_db->error==''){
						$log = new Log();
						$log->actionLog('Added Department');
						return 1;
					}
					else{
						die($this->_db->error);
					}
				}
				else
					return 0;
			}
		}
		else if(!loggedIn()){
			return 0;
		}
	}
	
	public function getInfo($id=''){
		$this->_connect();
		$this->_dept_id = $this->_db->real_escape_string(escape($id));
		
		$query = "SELECT * FROM department WHERE dept_id = '".$this->_dept_id."' ";
		$result = $this->_db->query($query);
		
		if($this->_db->query($query)){
			if($result->num_rows){
				while($value = $result->fetch_object()){
					$this->_dept_id = $value->dept_id;
					$this->_name = $value->name;
				}
				return 1;
			}
			else{
				return 0;
			}
		}
		else{
			die($this->_db->error);
		}
	}
	public function getInfobyName($name=''){
		$this->_connect();
		$this->_name = $this->_db->real_escape_string(escape($name));
		
		$query = "SELECT * FROM department WHERE name = '".$this->_name."' ";
		$result = $this->_db->query($query);
		
		if($this->_db->query($query)){
			if($result->num_rows){
				while($value = $result->fetch_object()){
					$this->_dept_id = $value->dept_id;
					$this->_name = $value->name;
				}
				return 1;
			}
			else{
				return 0;
			}
		}
		else{
			die($this->_db->error);
		}
	}
	public function getAllDepartment(){
		$this->_connect();
		
		$query = "SELECT dept_id,name FROM department ORDER BY dept_id";
		$result = $this->_db->query($query);
		$rows = $result->num_rows;
		return $result;
	}
	
	public function edit_dep($dept_id='',$name=''){
		
		if(loggedIn() && (privilege()==='teacher' || privilege()==='dppc' || privilege()==='dupc')){
			return 3;
		}
		else if(loggedIn()){
			$this->_connect();
			$this->_dept_id = $this->_db->real_escape_string(escape($dept_id));
			$this->_name = $this->_db->real_escape_string(escape($name));
			$query = "UPDATE department SET name = '".$this->_name."' WHERE dept_id='".$this->_dept_id."'";
			$result = $this->_db->query($query);
			if($this->_db->affected_rows){
				if($this->_db->error==''){
					$log = new Log();
					$log->actionLog('Edited Department');
					return 1;
				}
				else{
					die($this->_db->error);
				}
			}
			else
				return 2;
			
		}
		else if(!loggedIn()){
			return 0;
		}
	}
	public function deleteDep($dept_id=''){
		
		if(loggedIn() && (privilege()==='teacher' || privilege()==='dppc' || privilege()==='dupc')){
			return 'No privilege.';
		}
        if(loggedIn() && $this->deleteDepError($dept_id)){
            return "Sorry, cannot remove this department because it already has<br/>".($this->_dce!=0?" <b>$this->_dce</b> courses.<br/>":"").($this->_dte!=0?" <b>$this->_dte</b> teachers.":"");
        }
		else if(loggedIn()){
			$this->_connect();
			$this->_dept_id = $this->_db->real_escape_string(escape($dept_id));
			$query = "DELETE FROM department WHERE dept_id='".$this->_dept_id."'";
			$result = $this->_db->query($query);
			if($this->_db->affected_rows){
				if($this->_db->error==''){
					return 'Department has been Deleted';
				}
				else{
					die($this->_db->error);
				}
			}
			else
				return 'Temporary Problem.';
			
		}
		else if(!loggedIn()){
			return 'Temporary Problem';
		}
	}
    
    private function deleteDepError($dept_id){
        
        $this->_connect();
        $dept_id = $this->_db->real_escape_string(escape($dept_id)); 
        $query = "SELECT course_id FROM courses WHERE course_department='".$dept_id."'";
        $result = $this->_db->query($query);
        $return=0;
            $this->_dce = $result->num_rows;
            $return+=$result->num_rows;
            $query = "SELECT teacher_id FROM teachers WHERE dept_id = '".$dept_id."'";
            $result = $this->_db->query($query);
            $this->_dte = $result->num_rows;
            $return+=$result->num_rows;
        return $return;
    }
}
?>