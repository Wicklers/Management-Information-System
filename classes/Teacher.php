<?php
/**
 * @package MIS
 * @name Teacher
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Teacher {
    private $_db, $_id, $_privilege, $_mobile, $_name, $_email, $_department, $_blocked, $_approved;

    public function __construct() {
        $this -> _id = NULL;
        $this -> _courseId = NULL;
        $this -> _privilege = NULL;
        $this -> _db = NULL;
        $this -> _mobile = NULL;
        $this -> _email = NULL;
        $this -> _department = NULL;
    }

    public function getId() {
        return ($this -> _id != NULL) ? $this -> _id : NULL;
    }

    public function getPrivilege() {
        return ($this -> _privilege != NULL) ? $this -> _privilege : NULL;
    }

    public function getName() {
        return ($this -> _name != NULL) ? $this -> _name : NULL;
    }

    public function getEmail() {
        return ($this -> _email != NULL) ? $this -> _email : NULL;
    }

    public function getDep() {
        return ($this -> _department != NULL) ? $this -> _department : NULL;
    }

    public function getMobile() {
        return ($this -> _mobile != NULL) ? $this -> _mobile : NULL;
    }

    public function getBlocked() {
        return $this -> _blocked;
    }

    public function getApproved() {
        return $this -> _approved;
    }

    private function _connect() {
        $this -> _db = new MySQLi(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this -> _db -> connect_errno) {
            die("MySQL Error : " . $this -> _db -> connect_error);
        }
    }

    public function validateLogin($email) {
        $this -> _connect();
        $email = $this -> _db -> real_escape_string(escape($email));
        $query = "SELECT * FROM teachers WHERE email = '" . $email . "' LIMIT 1";
        $result = $this -> _db -> query($query);
        if ($this -> _db -> query($query)) {
            if ($result -> num_rows) {
                while ($value = $result -> fetch_object()) {
                    if ($value -> approved == 0) {
                        return 2;
                    }
                    if ($value -> blocked == 1) {
                        return 3;
                    }
                    $this -> _id = $value -> teacher_id;
                    $this -> _name = $value -> name;
                    $this -> _privilege = $value -> privilege;
                    $this -> _department = $value -> dept_id;
                    $this -> _mobile = $value -> mobile;

                    //Setting Session Variables
                    Session::put('teacher_id', $this -> _id);
                    Session::put('teacher_email', $email);
                    Session::put('dept_id', $this -> _department);
                    Session::put('privilege', $this -> _privilege);
                    Session::put('mobile',$this->_mobile);
                }
                return 1;
            } else
                return 0;
        } else {
            die($this -> _db -> error);
        }
    }

    public function block($id) {
        $this -> _connect();
        $id = $this -> _db -> real_escape_string(escape($id));
        $query = "UPDATE teachers SET blocked=1 WHERE teacher_id='" . $id . "'";
        $result = $this -> _db -> query($query);
        if ($this -> _db -> affected_rows) {
            return 1;
        } else
            return 0;
    }

    public function add($name = '', $email = '', $privilege = 'teacher', $dept_id = '', $mobile = '', $approved = '0') {
        if (($privilege === 'director' && $this -> numOfPrivileges($privilege) == 1) || ($privilege === 'dean' && $this -> numOfPrivileges($privilege) == 1) || ($privilege === 'hod' && $this -> ifHODexists($dept_id)) || ($privilege === 'dppc' && $this -> numOfDPPC($dept_id) == 3) || ($privilege === 'dupc' && $this -> numOfDUPC($dept_id) == 3)) {
            return 4;
        } else {
            if (loggedIn() && (($privilege === 'director' && (privilege() === 'hod' || privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'dean' && (privilege() === 'hod' || privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'hod' && (privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'dppc' && (privilege() === 'teacher')) || ($privilege === 'dupc' && (privilege() === 'teacher')))) {
                return 3;
            } else if (loggedIn()) {
                if ($this -> getInfobyEmail($email)) {
                    return 2;
                } else {
                    $this -> _connect();
                    $this -> _name = $this -> _db -> real_escape_string(escape($name));
                    $this -> _email = $this -> _db -> real_escape_string(escape($email));
                    $this -> _privilege = $this -> _db -> real_escape_string(escape($privilege));
                    $this -> _department = $this -> _db -> real_escape_string(escape($dept_id));
                    $this -> _mobile = $this -> _db -> real_escape_string(escape($mobile));

                    $query = "INSERT INTO teachers (name, email, privilege, dept_id, mobile,approved) VALUES ('" . $this -> _name . "','" . $this -> _email . "','" . $this -> _privilege . "','" . $this -> _department . "', '" . $this -> _mobile . "','" . $approved . "')";
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
    }

    public function getInfo($id = '') {
        $this -> _connect();
        $this -> _id = $this -> _db -> real_escape_string(escape($id));
        $query = "SELECT * FROM teachers WHERE teacher_id = '" . $this -> _id . "'";
        $result = $this -> _db -> query($query);
        if ($result -> num_rows) {
            while ($value = $result -> fetch_object()) {
                $this -> _name = $value -> name;
                $this -> _email = $value -> email;
                $this -> _privilege = $value -> privilege;
                $this -> _department = $value -> dept_id;
                $this -> _mobile = $value -> mobile;
                $this -> _blocked = $value -> blocked;
                $this -> _approved = $value -> approved;
            }
            return 1;
        } else
            return 0;
    }

    public function getInfobyName($name = '') {
        $this -> _connect();
        $this -> _name = $this -> _db -> real_escape_string(escape($name));
        $query = "SELECT * FROM teachers WHERE name = '" . $this -> _name . "'";
        $result = $this -> _db -> query($query);
        if ($result -> num_rows) {
            while ($value = $result -> fetch_object()) {
                $this -> _name = $value -> name;
                $this -> _email = $value -> email;
                $this -> _privilege = $value -> privilege;
                $this -> _department = $value -> dept_id;
                $this -> _mobile = $value -> mobile;
                $this -> _blocked = $value -> blocked;
                $this -> _approved = $value -> approved;
            }
            return 1;
        } else
            return 0;
    }

    public function getInfobyEmail($email = '') {
        $this -> _connect();
        $this -> _email = $this -> _db -> real_escape_string(escape($email));
        $query = "SELECT * FROM teachers WHERE email = '" . $this -> _email . "'";
        $result = $this -> _db -> query($query);
        if ($result -> num_rows) {
            while ($value = $result -> fetch_object()) {
                $this -> _id = $value -> teacher_id;
                $this -> _name = $value -> name;
                $this -> _email = $value -> email;
                $this -> _privilege = $value -> privilege;
                $this -> _department = $value -> dept_id;
                $this -> _mobile = $value -> mobile;
                $this -> _blocked = $value -> blocked;
                $this -> _approved = $value -> approved;
            }
            return 1;
        } else
            return 0;
    }

    public function numOfPrivileges($privilege = '') {
        $this -> _connect();
        $this -> _privilege = $this -> _db -> real_escape_string(escape($privilege));
        $query = "SELECT * FROM teachers WHERE privilege = '" . $this -> _privilege . "'";
        $result = $this -> _db -> query($query);
        return $result -> num_rows;
    }

    public function getTeachersByDep($dep_id) {
        $this -> _connect();
        $this -> _department = $this -> _db -> real_escape_string(escape($dep_id));
        $query = "SELECT * FROM teachers WHERE dep_id = '" . $this -> _department . "' ";
        $result = $this -> _db -> query($query);
        return $result;
    }

    public function getTeachersByBlocked() {
        $this -> _connect();
        $query = "SELECT * FROM teachers WHERE blocked=1";
        $result = $this -> _db -> query($query);
        return $result;
    }

    public function getAllTeachers() {
        $this -> _connect();

        $query = "SELECT * FROM teachers";
        $result = $this -> _db -> query($query);
        return $result;
    }

    public function ifHODexists($dept_id) {
        $this -> _connect();
        $query = "SELECT * FROM teachers WHERE privilege='hod' AND dept_id='" . $dept_id . "'";
        $result = $this -> _db -> query($query);
        if ($result -> num_rows)
            return 1;
        else
            return 0;
    }

    public function numOfDUPC($dept_id) {
        $this -> _connect();
        $query = "SELECT * FROM teachers WHERE privilege='dupc' AND dept_id='" . $dept_id . "'";
        $result = $this -> _db -> query($query);
        return $result -> num_rows;
    }

    public function numOfDPPC($dept_id) {
        $this -> _connect();
        $query = "SELECT * FROM teachers WHERE privilege='dppc' AND dept_id='" . $dept_id . "'";
        $result = $this -> _db -> query($query);
        return $result -> num_rows;
    }

    public function getInfobyDept($dept_id = '') {
        $this -> _connect();
        $this -> _dept_id = $this -> _db -> real_escape_string(escape($dept_id));
        $query = "SELECT * FROM teachers WHERE dept_id = '" . $this -> _dept_id . "'";
        $result = $this -> _db -> query($query);
        return $result;
    }

    public function edit_teacher_info($name = '', $t_id = '', $email = '', $privilege = 'teacher', $dept_id = '', $mobile = '', $approved, $blocked) {
        if (($privilege === 'director' && $this -> numOfPrivileges($privilege) == 1) || ($privilege === 'dean' && $this -> numOfPrivileges($privilege) == 1) || ($privilege === 'hod' && $this -> ifHODexists($dept_id)) || ($privilege === 'dppc' && $this -> numOfDPPC($dept_id) == 3) || ($privilege === 'dupc' && $this -> numOfDUPC($dept_id) == 3)) {
            $this -> getInfo($t_id);
            if ($this -> getPrivilege() != $privilege)
                return 4;
        }

        if (loggedIn() && (($privilege === 'director' && (privilege() === 'hod' || privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'dean' && (privilege() === 'hod' || privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'hod' && (privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'dppc' && (privilege() === 'teacher')) || ($privilege === 'dupc' && (privilege() === 'teacher')))) {
            return 3;
        } else if (loggedIn()) {
            $this -> _connect();
            $this -> _name = $this -> _db -> real_escape_string(escape($name));
            $this -> _id = $this -> _db -> real_escape_string(escape($t_id));
            $this -> _email = $this -> _db -> real_escape_string(escape($email));
            $this -> _privilege = $this -> _db -> real_escape_string(escape($privilege));
            $this -> _department = $this -> _db -> real_escape_string(escape($dept_id));
            $this -> _mobile = $this -> _db -> real_escape_string(escape($mobile));

            $query = "UPDATE teachers SET name='" . $this -> _name . "', email='" . $this -> _email . "', privilege='" . $this -> _privilege . "', dept_id='" . $this -> _department . "', mobile='" . $this -> _mobile . "', approved='" . $approved . "',blocked='" . $blocked . "' WHERE teacher_id='" . $this -> _id . "'";
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

    public function deleteT($t_id = '', $privilege = 'teacher') {
        if (loggedIn() && (($privilege === 'director' && (privilege() === 'hod' || privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'dean' && (privilege() === 'hod' || privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'hod' && (privilege() === 'dupc' || privilege() === 'dppc' || privilege() === 'teacher')) || ($privilege === 'dppc' && (privilege() === 'teacher')) || ($privilege === 'dupc' && (privilege() === 'teacher')))) {
            return 'No privilege';
        }
        if(loggedIn() && $this->deleteTeacherError($t_id)){
            return "Sorry, cannot remove this teacher because he/she already has<br/>(<i>in this running session</i>)<br/>".($this->_tce!=0?" <b>$this->_tce</b> courses appointed.<br/>":"").($this->_tae!=0?" <b>$this->_tae</b> subject results not fully approved.":"");
        }
        if (loggedIn()) {
            if (Session::exists('teacher_id')) {
                if (Session::get('teacher_id') == $t_id) {
                    return 'Can\'t delete yourself.';
                }
            }
            $this -> _connect();
            $this -> _id = $this -> _db -> real_escape_string(escape($t_id));
            $query = "DELETE FROM teachers WHERE teacher_id='" . $this -> _id . "'";
            $result = $this -> _db -> query($query);
                        
            if ($this -> _db -> affected_rows) {
                if ($this -> _db -> error == '') {
                    return 'Teacher removed.';
                } else {
                    die($this -> _db -> error);
                }
            } else
                return 'Temporary Error';
        }
        if (!loggedIn()) {
            return 'Temporary error';
        }
    }

    private function deleteTeacherError($teacher_id) {

        $this -> _connect();
        $teacher_id = $this -> _db -> real_escape_string(escape($teacher_id));
        $query = "SELECT id FROM courses_appointed WHERE teacher_id='" . $teacher_id . "' AND timestamp>='" . Session::get('semester_timestamp') . "'";
        $result = $this -> _db -> query($query);
        $return = 0;
        $this -> _tce = $result -> num_rows;
        $return += $result -> num_rows;
        $query = "SELECT id FROM approval WHERE teacher_id = '" . $teacher_id . "' AND status_level<5 AND timestamp>='" . Session::get('semester_timestamp') . "'";
        $result = $this -> _db -> query($query);
        $this -> _tae = $result -> num_rows;
        $return += $result -> num_rows;
        return $return;
    }
    
    public function changeMobile($teacher_id, $mobile){
    	$l = new LDAP();
    	if(!loggedIn() || $l->Auth(Session::get('teacher_email'), Input::get('cpwd'))!=1)
    		return 3;
    	$this->_connect();
    	$teacher_id = $this -> _db -> real_escape_string(escape($teacher_id));
    	$mobile = $this -> _db -> real_escape_string(escape($mobile));
    	$query = "UPDATE teachers SET mobile = '".$mobile."' WHERE teacher_id='".$teacher_id."'";
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