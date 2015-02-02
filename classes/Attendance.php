<?php
/**
 * @package MIS
 * @name Attendance
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Attendance {

    private function _connect() {
        $this -> _db = new MySQLi(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this -> _db -> connect_errno) {
            die("MySQL Error : " . $this -> _db -> connect_error);
        }
    }
	
    public function newEntry($scholar_no, $course_code, $course_dep, $classes_attended, $classes_total){
    	if(!loggedIn() || privilege()==NULL || privilege()=='admin' )
    		return 0;
    	$c = new Course();
    	if(!$c->appointError(Session::get('teacher_id'), $course_code, $course_dep)){
    		unset($c);
    		return 0;
    	}
    	$this->_connect();
    	$scholar_no = $this->_db->real_escape_string(escape($scholar_no));
    	$course_code = $this->_db->real_escape_string(escape($course_code));
    	$classes_attended = $this->_db->real_escape_string(escape($classes_attended));
    	$classes_total = $this->_db->real_escape_string(escape($classes_total));
    	$percentage = (($classes_attended*100)/$classes_total);
    	$check = $this->getEntry($scholar_no, $course_code);
    	if(empty($check))
    		$query = "INSERT INTO attendance_data (scholar_no, course_code, classes_attended, classes_total, percentage) VALUES ('".$scholar_no."','".$course_code."','".$classes_attended."','".$classes_total."','".$percentage."')";
    	else
    		$query = "UPDATE attendance_data SET classes_attended = '".$classes_attended."', classes_total = '".$classes_total."', percentage = '".$percentage."' WHERE scholar_no='".$scholar_no."' AND course_code='".$course_code."' AND timestamp>='".Session::get('semester_timestamp')."'";
    	$result = $this->_db->query($query);
    	if($this->_db->error!='')
    		die('Database error!');
    	if($this->_db->affected_rows)
    		return 1;
    	else
    		return 0;
    	
    }
    public function importCSV($course_code, $course_dep, $filename){
    	if(!loggedIn() || privilege()==NULL || privilege()=='admin' )
    		return 0;
    	$file = fopen($filename, "r");
    	$count=0;
    	while(($data = fgetcsv($file,10000,","))!==FALSE){
    		$count++;
    	
    		if($count>1){
    			$save = $this->newEntry($data[0],$course_code,$course_dep,$data[1],$data[2]);
    		}
    	}
    	fclose($file);
    	return 1;
    }
    
    public function getEntry($scholar_no, $course_code){
    	$this->_connect();
    	$scholar_no = $this->_db->real_escape_string(escape($scholar_no));
    	$course_code = $this->_db->real_escape_string(escape($course_code));
    	
    	$query = "SELECT * FROM attendance_data WHERE scholar_no='".$scholar_no."' AND course_code='".$course_code."' AND timestamp>='".Session::get('semester_timestamp')."'";
    	$result = $this->_db->query($query);
    	if($result->num_rows){
    		return $result;
    	}else{
    		return '';
    	}
    }

}
?>