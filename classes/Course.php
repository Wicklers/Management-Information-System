<?php
/**
 * @package MIS
 * @name Course
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Course {
    private $_course_id, $_course_name, $_course_credit, $_course_department;

    public function __construct() {
        $this -> _course_id = NULL;
        $this -> _course_name = NULL;
        $this -> _course_semester = NULL;
    }

    public function getCourseId() {
        return ($this -> _course_id != NULL) ? $this -> _course_id : NULL;
    }

    public function getCourseName() {
        return ($this -> _course_name != NULL) ? $this -> _course_name : NULL;
    }

    public function getCourseCredit() {
        return ($this -> _course_credit != NULL) ? $this -> _course_credit : NULL;
    }

    public function getCourseDepartment() {
        return ($this -> _course_department != NULL) ? $this -> _course_department : NULL;
    }

    private function _connect() {
        $this -> _db = new MySQLi(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this -> _db -> connect_errno) {
            die("MySQL Error : " . $this -> _db -> connect_error);
        }
    }

    public function add($id = '', $name = '', $dep = '', $credit = '') {
        if (loggedIn()) {
            if ($this -> getInfobyId($id)) {
                return 2;
            } else {
		$id = strtoupper($id);


		$id = preg_replace("/[^a-zA-Z0-9_\s-]/", "", $id);
		//Make alphanumeric (removes all other characters)

		//Clean up multiple dashes or whitespaces
		$id = preg_replace("/[\s-]+/", " ", $id);
		//Convert whitespaces and underscore to dash
		$id = preg_replace("/[\s_]/", "", $id);
                $this -> _course_id = $this -> _db -> real_escape_string(escape($id));
                $this -> _course_name = $this -> _db -> real_escape_string(escape($name));
                $this -> _course_department = $this -> _db -> real_escape_string(escape($dep));
                $this -> _course_credit = $this -> _db -> real_escape_string(escape($credit));

                $query = "INSERT INTO courses(course_id,course_name,course_department,course_credit) VALUES ('" . $this -> _course_id . "', '" . $this -> _course_name . "', '" . $this -> _course_department . "','" . $this -> _course_credit . "')";
                $result = $this -> _db -> query($query);
                if ($this -> _db -> affected_rows) {
                    if ($this -> _db -> error == '') {
                        return 1;
                    } else {
                        die($this -> _db -> error);
                    }
                } else
                    return 0;
            }
        } else if (!loggedIn()) {
            return 0;
        }
    }

    public function getInfobyName($name = '') {
        $this -> _connect();
        $this -> _course_name = $this -> _db -> real_escape_string(escape($name));

        $query = "SELECT * FROM courses WHERE course_name = '" . $this -> _course_name . "' ";
        $result = $this -> _db -> query($query);

        if ($this -> _db -> query($query)) {
            if ($result -> num_rows) {
                while ($value = $result -> fetch_object()) {
                    $this -> _course_id = $value -> course_id;
                    $this -> _course_name = $value -> course_name;
                    $this -> _course_department = $value -> course_department;
                    $this -> _course_credit = $value -> course_credit;
                }
                return 1;
            } else {
                return 0;
            }
        } else {
            die($this -> _db -> error);
        }
    }

    public function getInfobyId($id = '') {
        $this -> _connect();
        $this -> _course_id = $this -> _db -> real_escape_string(escape($id));

        $query = "SELECT * FROM courses WHERE course_id = '" . $this -> _course_id . "' ";
        $result = $this -> _db -> query($query);

        if ($this -> _db -> query($query)) {
            if ($result -> num_rows) {
                while ($value = $result -> fetch_object()) {
                    $this -> _course_id = $value -> course_id;
                    $this -> _course_name = $value -> course_name;
                    $this -> _course_department = $value -> course_department;
                    $this -> _course_credit = $value -> course_credit;
                }
                return 1;
            } else {
                return 0;
            }
        } else {
            die($this -> _db -> error);
        }
    }

    public function getAllCourses() {
        $this -> _connect();

        $query = "SELECT * FROM courses ORDER by course_department,course_id,course_credit desc";
        $result = $this -> _db -> query($query);
        return $result;
    }

    public function edit_course($id = '', $name = '', $dep = '', $credit = '') {

        if (loggedIn()) {
            $this -> _connect();
            $this -> _course_id = $this -> _db -> real_escape_string(escape($id));
            $this -> _course_name = $this -> _db -> real_escape_string(escape($name));
            $this -> _course_department = $this -> _db -> real_escape_string(escape($dep));
            $this -> _course_credit = $this -> _db -> real_escape_string(escape($credit));

            $query = "UPDATE courses SET course_id='" . $this -> _course_id . "',course_name='" . $this -> _course_name . "',course_department='" . $this -> _course_department . "',course_credit='" . $this -> _course_credit . "'  WHERE course_id='" . $this -> _course_id . "'";
            $result = $this -> _db -> query($query);
            if ($this -> _db -> affected_rows) {
                if ($this -> _db -> error == '') {
                    return 1;
                } else {
                    die($this -> _db -> error);
                }
            } else
                return 2;

        } else if (!loggedIn()) {
            return 0;
        }
    }

    public function getInfobyDept($dept = '') {
        $this -> _connect();
        $this -> _dept_id = $this -> _db -> real_escape_string(escape($dept));

        $query = "SELECT course_id, course_name FROM courses WHERE course_department = '" . $this -> _dept_id . "' ";
        $result = $this -> _db -> query($query);

        if ($this -> _db -> query($query)) {

            return $result;

        } else {
            die($this -> _db -> error);
        }
    }

    public function deleteCourse($id = '') {
                    
        if(loggedIn() && $this->deleteCourseError($id)){
            return "Sorry, cannot remove this course because it already has<br/>(<i>in this running session</i>)<br/>".($this->_cae!=0?" <b>$this->_cae</b> teachers appointed.<br/>":"").($this->_cse!=0?" <b>$this->_cse</b> students enrolled.":"");
        }
        if (loggedIn()) {
            $this -> _connect();
            $query = "DELETE FROM courses WHERE course_id='" . $id . "'";
            $result = $this -> _db -> query($query);
            if ($this -> _db -> affected_rows) {
                if ($this -> _db -> error == '') {
                    return 'Course has been Removed';
                } else {
                    die($this -> _db -> error);
                }
            } else
                return 'Temporary Problem.';

        } else if (!loggedIn()) {
            return 'Temporary Problem.';
        }
    }
    
    private function deleteCourseError($course_code){
        
        $this->_connect();
        $course_code = $this->_db->real_escape_string(escape($course_code)); 
        $query = "SELECT id FROM courses_appointed WHERE course_code='".$course_code."' AND timestamp>='".Session::get('semester_timestamp')."'";
        $result = $this->_db->query($query);
        $return=0;
            $this->_cae = $result->num_rows;
            $return+=$result->num_rows;
            $query = "SELECT id FROM students_info WHERE courses LIKE '%".$course_code."%' AND timestamp>='".Session::get('semester_timestamp')."'";
            $result = $this->_db->query($query);
            $this->_cse = $result->num_rows;
            $return+=$result->num_rows;
        return $return;
    }

    public function appointCourse($teacher_id = '', $course_code = '', $course_sem = '', $course_dep = '') {
	if(loggedIn() && (privilege()==='teacher' || privilege()==='dppc' || privilege()==='dupc' || privilege()==NULL)){
        	return 0;
	}
        if (loggedIn()) {
            $this->_connect();
            $course_code = $this->_db->real_escape_string(escape($course_code));
            $course_sem = $this->_db->real_escape_string(escape($course_sem));
            $course_dep = $this->_db->real_escape_string(escape($course_dep));
            $teacher_id = $this->_db->real_escape_string(escape($teacher_id));
            if ($this -> appointError($teacher_id, $course_code, $course_dep)) {
                return 2;
            } else {
                $t = new Teacher();
                $t->getInfo($teacher_id);
                if(!$t->getApproved()){
                    unset($t);
                    return 3;
                }
                $query = "INSERT INTO courses_appointed (teacher_id,course_code,course_sem,course_dep) VALUES ('" . $teacher_id . "','" . $course_code . "','" . $course_sem . "','" . $course_dep . "')";
                $result = $this -> _db -> query($query);
                if ($this -> _db -> affected_rows) {
                    if ($this -> _db -> error == '') {
                        return 1;
                    } else {
                        die($this -> _db -> error);
                    }
                } else
                    return 0;
            }
        } else if (!loggedIn()) {
            return 0;
        }
    }

    public function appointError($teacher_id = '', $cid = '', $did = '') {
    	$this->_connect();
        $query = "SELECT id FROM courses_appointed WHERE teacher_id='" . $teacher_id . "' AND course_code='" . $cid . "' AND course_dep='" . $did . "' AND timestamp>='" . Session::get('semester_timestamp') . "' LIMIT 1";
        $result = $this -> _db -> query($query);
        if ($result -> num_rows)
            return 1;
        else
            return 0;
    }

    public function getAppointed($teacher_id = '') {
        if (loggedIn()) {
            $this -> _connect();
            $query = "SELECT * FROM courses_appointed WHERE teacher_id='" . $teacher_id . "' AND timestamp>='" . Session::get('semester_timestamp') . "'";
            $result = $this -> _db -> query($query);
            if ($result -> num_rows) {
                if ($this -> _db -> error == '') {
                    return $result;
                } else {
                    die($this -> _db -> error);
                }
            } else {
                return '';
            }
        }
    }

    public function getCoursesAvailable($semester, $department) {
        if (loggedIn()) {
            $this -> _connect();

            $query = "SELECT * FROM courses_appointed as a,courses as b WHERE a.course_sem='" . $semester . "' AND a.course_dep='" . $department . "' AND a.course_code=b.course_id AND a.timestamp>='" . Session::get('semester_timestamp') . "' GROUP BY(course_code)ORDER BY b.course_credit desc,a.course_code";
            $result = $this -> _db -> query($query);
            if ($result -> num_rows) {
                return $result;
            } else {
                return '';
            }
        }
        else {
	       die();
        }
    }
    
    public function getAllAppointed(){
        if(!loggedIn()){
            return 0;
        }
        
        $this->_connect();
        
        $query = "SELECT * FROM courses_appointed WHERE timestamp>='".Session::get('semester_timestamp')."' ORDER BY course_dep,course_sem,course_code";
        $result = $this->_db->query($query);
        if($result->num_rows){
            return $result;
        }else
            return 0;
        
    }
    
    public function getAppointedInfo($id, $course_code,$course_dep,$course_sem){
        if(!loggedIn()){
            return 0;
        }
        $this->_connect();
        $id = $this->_db->real_escape_string($id);
        $course_code = $this->_db->real_escape_string($course_code);
        $course_dep = $this->_db->real_escape_string($course_dep);
        $course_sem = $this->_db->real_escape_string($course_sem);
        
        $query = "SELECT * FROM courses_appointed WHERE id='".$id."' AND course_code='".$course_code."' AND course_dep='".$course_dep."' AND course_sem='".$course_sem."' AND timestamp>='".Session::get('semester_timestamp')."'";
        $result = $this->_db->query($query);
        if($result->num_rows){
            return $result->fetch_object();
            
        }else{
            return 0;
        }
    }
    
    public function edit_appointed_course($id,$course_code,$department,$semester,$teacher){
        if(!loggedIn()){
            return 0;
        }
        $this->_connect();
	$id = $this->_db->real_escape_string($id);
        $course_code = $this->_db->real_escape_string($course_code);
        $department = $this->_db->real_escape_string($department);
        $semester = $this->_db->real_escape_string($semester);
        $teacher = $this->_db->real_escape_string($teacher);
        
        $query = "UPDATE courses_appointed SET teacher_id='".$teacher."' WHERE id='".$id."' AND course_code='".$course_code."' AND course_dep='".$department."' AND course_sem='".$semester."' AND timestamp>='".Session::get('semester_timestamp')."'";
        
        $result = $this->_db->query($query);
        
        if($this->_db->affected_rows){
            return 1;
        }
        else {
            return 2;
        }
        
    }
    
    public function remove_appointed_course($id,$course_code,$department,$semester){
        if(!loggedIn()){
            return 'Temporary Problem.';
        }
        
        $this->_connect();
	$id = $this->_db->real_escape_string($id);
        $course_code = $this->_db->real_escape_string($course_code);
        $department = $this->_db->real_escape_string($department);
        $semester = $this->_db->real_escape_string($semester);
        
        $query = "DELETE FROM courses_appointed WHERE id='".$id."' AND course_code='".$course_code."' AND course_dep='".$department."' AND course_sem='".$semester."'AND timestamp>=' ".Session::get('semester_timestamp')."'";
        
        $result = $this->_db->query($query);
            if($this->_db->affected_rows){
                if($this->_db->error==''){
                    return 'Entry has been Deleted';
                }
                else{
                    echo '1';
                    die($this->_db->error);
                }
            }
            else
                return 'Temporary Problem.';
            
    }

}
?>
