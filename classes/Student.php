<?php
/**
 * @package MIS
 * @name Student
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Student {

    private $_db, $_id, $_scholar_no, $_mobile, $_parents_mobile, $_name, $_gender, $_category, $_email, $_department, $_programme, $_courses,$_courses_load,$_spi, $_session, $_semester,$_total_score,$_max_score, $_cpi, $_home_address, $_hostel_address,$_payment, $_blocked, $_biography,$_cv_link, $_published,$_approved;

    public function getName() {
        return ($this -> _name != NULL) ? $this -> _name : NULL;
    }
    public function getID() {
    	return ($this -> _id != NULL) ? $this -> _id : NULL;
    }

    public function getEmail() {
        return ($this -> _email != NULL) ? $this -> _email : NULL;
    }
    public function getSchNO() {
    	return ($this -> _scholar_no != NULL) ? $this -> _scholar_no : NULL;
    }

    public function getDep() {
        return ($this -> _department != NULL) ? $this -> _department : NULL;
    }

    public function getMobile() {
        return ($this -> _mobile != NULL) ? $this -> _mobile : NULL;
    }
    public function getParentsMobile() {
    	return ($this -> _parents_mobile != NULL) ? $this -> _parents_mobile : NULL;
    }
    public function getTotalScore() {
    	return ($this -> _total_score != NULL) ? $this -> _total_score : NULL;
    }
    public function getMaxScore() {
    	return ($this -> _max_score != NULL) ? $this -> _max_score : NULL;
    }
    public function getCourses() {
    	return ($this -> _courses != NULL) ? $this -> _courses : NULL;
    }
    public function getCoursesLoad() {
    	return ($this -> _courses_load != NULL) ? $this -> _courses_load : NULL;
    }

    public function getBlocked() {
        return $this -> _blocked;
    }

    public function getApproved() {
        return $this -> _approved;
    }
    public function getPayment() {
    	return $this -> _payment;
    }
    public function getHomeAddress() {
    	return $this -> _home_address;
    }
    public function getHostelAddress() {
    	return $this -> _hostel_address;
    }
    public function getSemester() {
    	return $this -> _semester;
    }
    public function getSPI() {
    	return $this -> _spi;
    }
    public function getCPI() {
    	return $this -> _cpi;
    }
    public function getBiography() {
    	return $this -> _biography;
    }
    public function getPublished() {
    	return $this -> _published;
    }
    public function getCVLink() {
    	return $this -> _cv_link;
    }

    private function _connect() {
        $this -> _db = new MySQLi(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this -> _db -> connect_errno) {
            die("MySQL Error : " . $this -> _db -> connect_error);
        }
    }

    public function validateLogin() {
        $this -> _connect();
        $sn = Session::get('sn');
        $sn = $this -> _db -> real_escape_string(escape($sn));
        $query = "SELECT * FROM students_info WHERE scholar_no = '" . $sn . "' AND timestamp>='" . Session::get('semester_timestamp') . "' LIMIT 1";
        $result = $this -> _db -> query($query);
        if ($this -> _db -> query($query)) {
            if ($result -> num_rows) {
                while ($value = $result -> fetch_object()) {
                	if(!$value -> mobile_verified)
                		return 4;
			/*
                	if($value -> mobile_verified && !$value -> payment_verified)
                		return 5;
			*/
                    if ($value -> approved == 0) {
                        return 2;
                    }
                    if ($value -> blocked == 1) {
                        return 3;
                    }
                    $this -> _id = $value -> id;
                    $this -> _email = $value -> email;
                    $this -> _name = $value -> name;
                    $this -> _semester = $value -> semester;
                    $this -> _department = $value -> dept_id;
                    $this -> _mobile = $value -> mobile;

                    //Setting Session Variables
                    Session::put('student_id', $this -> _id);
                    Session::put('student_email', $this->_email);
                    Session::put('dept_id', $this -> _department);
                    Session::put('semester', $this -> _semester);
                    Session::put('privilege', 'student');
                    Session::put('mobile',$this->_mobile);
                }
                return 1;
            } else
                return 0;
        } else {
            die($this -> _db -> error);
        }
    }

    public function register($email,$name,$gender,$scholar_no,$category,$programme,$semester,$session,$department,$mobile,$parents_mobile,$courses,$courses_load,$home_address,$hostel_address){
        if(loggedIn()){
            $this->_connect();
            
            $email = $this -> _db -> real_escape_string(escape($email));
            $name = $this -> _db -> real_escape_string(escape($name));
            $gender = $this -> _db -> real_escape_string(escape($gender));
            $scholar_no = $this -> _db -> real_escape_string(escape($scholar_no));
            $category = $this -> _db -> real_escape_string(escape($category));
            $programme = $this -> _db -> real_escape_string(escape($programme));
            $semester = $this -> _db -> real_escape_string(escape($semester));
	    $session = $this -> _db -> real_escape_string(escape($session));
            $department = $this -> _db -> real_escape_string(escape($department));
            $mobile = $this -> _db -> real_escape_string(escape($mobile));
            $parents_mobile = $this -> _db -> real_escape_string(escape($parents_mobile));
            $courses = $this -> _db -> real_escape_string(escape($courses));
            $courses_load = $this -> _db -> real_escape_string(escape($courses_load));
            $home_address = $this -> _db -> real_escape_string(escape($home_address));
            $hostel_address = $this -> _db -> real_escape_string(escape($hostel_address));
            
            if($this->checkSN($scholar_no)){
                $query = "UPDATE students_info 
                           SET
                           semester='".$semester."',
                           department='".$department."',
                           mobile='".$mobile."',
                           mobile_verified='0',
                           parents_mobile='".$parents_mobile."',
                           courses='".$courses."',
                           courses_load='".$courses_load."',
                           home_address='".$home_address."',
                           hostel_address='".$hostel_address."',
                           approved='0',
                           blocked='0'
                           WHERE
                           scholar_no='".$scholar_no."'
                         ";
            }
            else{
                $query = "INSERT INTO students_info (email,name,gender,scholar_no,category,programme,semester,session,department,mobile,mobile_verified,parents_mobile,courses,courses_load,home_address,hostel_address,approved,blocked)
                          VALUES ('".$email."',
                                  '".$name."',
                                  '".$gender."',
                                  '".$scholar_no."',
                                  '".$category."',
                                  '".$programme."',
                                  '".$semester."',
                                  '".$session."',
                                  '".$department."',
                                  '".$mobile."',
                                  '0',
                                  '".$parents_mobile."',
                                  '".$courses."',
                                  '".$courses_load."',
                                  '".$home_address."',
                                  '".$hostel_address."',
                                  '0',
                                  '0'
                                  )";
            }
            
            $result = $this->_db->query($query);
            
            if($this->_db->error==''){
                if($this->_db->affected_rows){
                    return 1;
                }
                else {
	                return 0;
                }
            }
            else{
                die($this->_db->error);
            }
        }
        else{
            return 0;
        }
    }
    
    
    public function block($id){
                $this->_connect();
                $id = $this->_db->real_escape_string(escape($id));
                $query = "UPDATE students_info SET blocked=1 WHERE id='".$id."'";
                $result = $this->_db->query($query);
                if($this->_db->affected_rows){
                        return 1;
                    }
                else 
                    return 0;
            }
    
    public function checkSN($scholar_no){
        $this->_connect();
        $sn = $this->_db->real_escape_string(escape($scholar_no));
        $query="SELECT id FROM students_info WHERE scholar_no='".$sn."'";
        $result=$this->_db->query($query);
        if($result->num_rows){
            return 1;
        }
        else{
            return 0;
        }
    }
    
    public function CourseDepStudents($department,$course_code){
        
        if(!loggedIn()){
            return 0;
        }
        $this->_connect();
        $course_code = $this->_db->real_escape_string($course_code);
        $department = $this->_db->real_escape_string($department);
        $query = "SELECT scholar_no FROM students_info WHERE courses LIKE '%".$course_code."%' AND department='".$department."' AND approved='1' AND timestamp>='".Session::get('semester_timestamp')."' ORDER BY scholar_no";
        $result = $this->_db->query($query);
        
        if($result->num_rows){
            return $result;
        }else{
            return '';
        }
    }
    public function CourseDepStudentsLoad($course_code){
    
    	if(!loggedIn()){
    		return 0;
    	}
    	$this->_connect();
    	$course_code = $this->_db->real_escape_string($course_code);
    	$department = $this->_db->real_escape_string($department);
    	$query = "SELECT scholar_no FROM students_info WHERE courses_load LIKE '%".$course_code."%' AND approved='1' AND timestamp>='".Session::get('semester_timestamp')."' ORDER BY scholar_no";
    	$result = $this->_db->query($query);
    
    	if($result->num_rows){
    		return $result;
    	}else{
    		return '';
    	}
    }
    
    public function verifyMobile($scholar_no){
    	if(!loggedIn()){
    		return 0;
    	}
    	$this->_connect();
    	$scholar_no = $this->_db->real_escape_string($scholar_no);
    	$query = "UPDATE students_info SET mobile_verified=1 WHERE scholar_no = '".$scholar_no."'";
    	$result = $this->_db->query($query);
    	if($this->_db->error==''){
    		if($this->_db->affected_rows){
    			return 1;
    		}
    		else {
    			return 0;
    		}
    	}
    	else{
    		die($this->_db->error);
    	}
    	
    }
	public function getAllStudents() {
        $this -> _connect();

        $query = "SELECT * FROM students_info WHERE timestamp>='".Session::get('semester_timestamp')."' ORDER BY semester, department, scholar_no";
        $result = $this -> _db -> query($query);
        if($result->num_rows)
        	return $result;
        else
        	return '';
    }
	public function getInfo($scholar_no) {
        $this -> _connect();
        $this->_scholar_no = $this -> _db -> real_escape_string(escape($scholar_no));
        $query = "SELECT * FROM students_info WHERE scholar_no = '" . $this->_scholar_no . "'";
        $result = $this -> _db -> query($query);
        if ($result -> num_rows) {
            while ($value = $result -> fetch_object()) {
            	$this -> _id = $value -> id;
                $this -> _name = $value -> name;
                $this -> _email = $value -> email;
                $this -> _department = $value -> department;
                $this -> _gender = $value -> gender;
                $this -> _category = $value -> category;
                $this -> _programme = $value -> programme;
                $this -> _session = $value -> session;
                $this -> _semester = $value -> semester;
                $this -> _mobile = $value -> mobile;
                $this -> _parents_mobile = $value -> parents_mobile;
                $this -> _courses = $value -> courses;
                $this -> _courses_load = $value -> courses_load;
                $this -> _spi = $value -> spi;
                $this -> _total_score = $value -> total_score;
                $this -> _max_score = $value -> total_max_score;
                $this -> _cpi = $value -> cpi;
                $this -> _home_address = $value -> home_address;
                $this -> _hostel_address = $value -> hostel_address;
                $this -> _payment = $value -> payment_verified;
                $this -> _blocked = $value -> blocked;
                $this -> _approved = $value -> approved;
                $this -> _biography = $value -> biography;
                $this -> _published = $value -> published;
                $this -> _cv_link = $value -> cv_link;
            }
            return 1;
        } else
            return 0;
    }
    public function getInfoByEmail($email) {
    	$this -> _connect();
    	$this->_email = $this -> _db -> real_escape_string(escape($email));
    	$query = "SELECT scholar_no FROM students_info WHERE email = '" . $this->_email . "' LIMIT 1";
    	$result = $this -> _db -> query($query);
    	if ($result -> num_rows) {
    		while ($value = $result -> fetch_object()) {
    			$this->getInfo($value->scholar_no);
    		}
    		return 1;
    	} else
    		return 0;
    }
    
    public function editInfo($scholar_no, $mobile, $parents_mobile, $department,$courses, $courses_load, $total_score, $max_score, $home_address, $hostel_address, $approved, $blocked){
    	if(!loggedIn())
    		return 0;
    	$this->_connect();
    	$scholar_no = $this -> _db -> real_escape_string(escape($scholar_no));
    	$department = $this -> _db -> real_escape_string(escape($department));
    	$courses = $this -> _db -> real_escape_string(escape($courses));
    	$courses_load = $this -> _db -> real_escape_string(escape($courses_load));
    	$mobile = $this -> _db -> real_escape_string(escape($mobile));
    	$parents_mobile = $this -> _db -> real_escape_string(escape($parents_mobile));
    	$total_score = $this -> _db -> real_escape_string(escape($total_score));
    	$max_score = $this -> _db -> real_escape_string(escape($max_score));
    	$home_address = $this -> _db -> real_escape_string(escape($home_address));
    	$hostel_address = $this -> _db -> real_escape_string(escape($hostel_address));
    	$approved = $this -> _db -> real_escape_string(escape($approved));
    	$blocked = $this -> _db -> real_escape_string(escape($blocked));
    	$cpi = (float)($total_score/$max_score);
    	$query = "UPDATE students_info SET
    										mobile = '".$mobile."',
    										parents_mobile = '".$parents_mobile."',
										department = '".$department."',
										courses = '".$courses."',
										courses_load = '".$courses_load."',
    										total_score = '".$total_score."',
    										total_max_score = '".$max_score."',
    										cpi = '".$cpi."',
    										home_address = '".$home_address."',
    										hostel_address = '".$hostel_address."',
    										approved = '".$approved."',
    										blocked = '".$blocked."'
    									WHERE scholar_no = '".$scholar_no."'";
    	$result = $this->_db->query($query);
    	
    	if($this->_db->error!='')
    		return 0;
    	if($this->_db->affected_rows)
    		return 1;
    	else
    		return 2;
    										
    }
    
    public function changeMobile($scholar_no, $mobile){
    	$l = new LDAP();
    	if(!loggedIn() || $l->Auth(Session::get('student_email'), Input::get('cpwd'))!=1)
    		return 3;
    	$this->_connect();
    	$scholar_no = $this -> _db -> real_escape_string(escape($scholar_no));
    	$mobile = $this -> _db -> real_escape_string(escape($mobile));
    	$query = "UPDATE students_info SET mobile = '".$mobile."' WHERE scholar_no='".$scholar_no."'";
    	$result = $this->_db->query($query);
    	if($this->_db->error==''){
    		if($this->_db->affected_rows)
    			return 1;
    		else
    			return 2;
    	}
    	else
    		return 0;
    }
    
	public function publishProfile($scholar_no){
    	if(!loggedIn() || privilege()==NULL){
    		return 0;
    	}
    	$this->_connect();
    	$scholar_no = $this -> _db -> real_escape_string(escape($scholar_no));
    	$query = "UPDATE students_info SET published = '1' WHERE scholar_no='".$scholar_no."'";
    	$result = $this->_db->query($query);
    	if($this->_db->error==''){
    		if($this->_db->affected_rows)
    			return 1;
    		else
    			return 2;
    	}
    	else
    		return 0;
    }
    public function unpublishProfile($scholar_no){
    	if(!loggedIn() || privilege()==NULL){
    		return 0;
    	}
    	$this->_connect();
    	$scholar_no = $this -> _db -> real_escape_string(escape($scholar_no));
    	$query = "UPDATE students_info SET published = '0' WHERE scholar_no='".$scholar_no."'";
    	$result = $this->_db->query($query);
    	if($this->_db->error==''){
    		if($this->_db->affected_rows)
    			return 1;
    		else
    			return 2;
    	}
    	else
    		return 0;
    }
    public function updateBiography($scholar_no, $biography, $cv=''){
    	if(!loggedIn() || privilege()==NULL){
    		return 0;
    	}
    	$this->_connect();
    	$scholar_no = $this -> _db -> real_escape_string(escape($scholar_no));
    	$biography = $this -> _db -> real_escape_string($biography);
    	if($cv=='')
    		$query = "UPDATE students_info SET biography = '".$biography."' WHERE scholar_no='".$scholar_no."'";
    	else{
    		$cv = $this->_db->real_escape_string($cv);
    		$query = "UPDATE students_info SET biography = '".$biography."', cv_link='".$cv."' WHERE scholar_no='".$scholar_no."'";
    	}
    	$result = $this->_db->query($query);
    	if($this->_db->error==''){
    		if($this->_db->affected_rows)
    			return 1;
    		else
    			return 2;
    	}
    	else
    		return 0;
    }
}
?>
