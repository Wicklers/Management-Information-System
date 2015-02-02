<?php
/**
 * @package MIS
 * @name Semester
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Semester {

    private function _connect() {
        $this -> _db = new MySQLi(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this -> _db -> connect_errno) {
            die("MySQL Error : " . $this -> _db -> connect_error);
        }
    }

    public function getRunningSession() {
        $this -> _connect();
        
        $query = "SELECT * FROM semester_session WHERE starting_timestamp <= '" . date('Y-m-d H:i:s') . "' ORDER BY starting_timestamp desc LIMIT 1";
        $result = $this -> _db -> query($query);
        if ($result -> num_rows) {
            $key = $result -> fetch_object();
            Session::put('semester_timestamp', $key -> starting_timestamp);
            Session::put('semester_session', $key -> session);
            Session::put('semester_type', $key -> type);
            Session::put('semester_id', $key -> id);
        }
    }

    public function startNewSession() {
    	if(!loggedIn() && (privilege()!='dean' || privilege()!='director' || privilege()!='admin'))
    		return 0;
        $this -> _connect();

        if (!Session::exists('semester_session')) {
            $type = 'odd';
            $session = date('Y');
        } else if (Session::get('semester_type') === 'even') {
            $type = 'odd';
            $session = Session::get('semester_session');
        } else if (Session::get('semester_type') === 'odd') {
            $type = 'even';
            $session = Session::get('semester_session') + 1;
        }

        $timestamp = date('Y-m-d H:i:s');

        $query = "INSERT INTO semester_session (session,type,starting_timestamp) VALUES('" . $session . "','" . $type . "','" . $timestamp . "')";
        $result = $this -> _db -> query($query);

        if ($this -> _db -> affected_rows && $this -> _db -> error == '') {
            $this->getRunningSession();
            return 1;
        } else {
            return 0;
        }

    }
    public function isResultPublished(){
    	$this->_connect();
    	$query = "SELECT result_published FROM semester_session WHERE starting_timestamp = '".Session::get('semester_timestamp')."' LIMIT 1";
    	$result = $this->_db->query($query);
    	$d = $result->fetch_object();
    	return $d->result_published;
    }
    public function isRegistration(){
    	$this->_connect();
    	$query = "SELECT student_registration FROM semester_session WHERE starting_timestamp = '".Session::get('semester_timestamp')."' LIMIT 1";
    	$result = $this->_db->query($query);
    	$d = $result->fetch_object();
    	return $d->student_registration;
    }
    public function startRegistration(){
    	if(!loggedIn())
    		return 0;
    	$this->_connect();
    	$query = "UPDATE semester_session SET student_registration='1' WHERE starting_timestamp = '".Session::get('semester_timestamp')."'";
    	$result = $this->_db->query($query);
    	if($this->_db->error!='')
    		return 0;
    	if($this->_db->affected_rows)
    		return 1;
    	else
    		return 2;
    }
    public function stopRegistration(){
    	if(!loggedIn())
    		return 0;
    	$this->_connect();
    	$query = "UPDATE semester_session SET student_registration='0' WHERE starting_timestamp = '".Session::get('semester_timestamp')."'";
    	$result = $this->_db->query($query);
    	if($this->_db->error!='')
    		return 0;
    	if($this->_db->affected_rows)
    		return 1;
    	else
    		return 2;
    }

}
?>