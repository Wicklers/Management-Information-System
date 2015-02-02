<?php
/**
 * @package MIS
 * @name Approval
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Approval {
    private $_teacher_id, $_course_code, $_course_dep, $_status_level, $_reject_msg, $_db, $_approved_by;

    private function _connect() {
        $this -> _db = new MySQLi(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this -> _db -> connect_errno) {
            die("MySQL Error : " . $this -> _db -> connect_error);
        }
    }

    public function approve($tid, $cid, $did) {
        if (!loggedIn()) {
            return 0;
        }
        $this -> _connect();
        $this -> _teacher_id = $this -> _db -> real_escape_string($tid);
        $tid = $this -> _db -> real_escape_string($tid);
        $this -> _course_code = $this -> _db -> real_escape_string($cid);
        $this -> _course_dep = $this -> _db -> real_escape_string($did);

        if ($this -> approved($cid, $did)) {
            if ($this -> _status_level < 0 && $this -> _teacher_id != $tid) {
                die('This result is already rejected.');
            }
            if ($this -> _status_level < 0 && $this -> _teacher_id == $tid) {
                $query = "UPDATE approval SET reject_msg='', status_level='0', approved_by='" . $tid . "' WHERE teacher_id='" . $this -> _teacher_id . "' AND course_code='" . $this -> _course_code . "' AND course_dep='" . $this -> _course_dep . "' AND timestamp>='" . Session::get('semester_timestamp') . "'";
            } else if ($this -> _status_level < 5) {
                $approved_by = explode(',', $this -> _approved_by);
                $t = new Teacher();
                $t -> getInfo(Session::get('teacher_id'));

                if (Session::get('privilege') === 'teacher') {
                    $i = 0;
                    while (isset($approved_by[$i])) {
                        if ($approved_by[$i] == $tid) {
                            return 2;
                            break;
                        } else {
                            $i++;
                        }
                    }
                } else if ((Session::get('privilege') === 'dupc' || Session::get('privilege') === 'dppc')) {
                    $i = 1;
                    if ($this -> _status_level >= 3) {
                        return "All DUPC or DPPC members have approved!";
                    }
                    if ($t -> getDep() != $this -> _course_dep) {
                        return "Sorry! You cannot approve this result!";
                    }
                    while (isset($approved_by[$i])) {
                        if ($approved_by[$i] == $tid) {
                            return 2;
                            break;
                        } else {
                            $i++;
                        }
                    }
                } else if (Session::get('privilege') === 'hod' && $this -> _status_level == 3) {
                    if ($t -> getDep() != $this -> _course_dep) {
                        return "Sorry! You cannot approve this result!";
                    }
                } else if (Session::get('privilege') === 'hod' && $this -> _status_level < 3) {
                    die("You cannot approve this result being HOD because DUPC or DPPC members have not approved this result yet.");
                } else if (Session::get('privilege') === 'hod' && $this -> _status_level > 3) {
                    return "You have already approved this result being HOD.";
                } else if (Session::get('privilege') === 'dean' && $this -> _status_level < 4) {
                    return "You cannot approve this result being DEAN because HOD or DUPC or DPPC members have not approved this result yet.";
                }

                $approved_by = $this -> _approved_by . ',' . $tid;
                $status_level = $this -> _status_level + 1;
                $query = "UPDATE approval SET status_level='" . $status_level . "', approved_by='" . $approved_by . "' WHERE teacher_id='" . $this -> _teacher_id . "' AND course_code='" . $this -> _course_code . "' AND course_dep='" . $this -> _course_dep . "' AND timestamp>='".Session::get('semester_timestamp')."'";
            } else {
               return "Every member has approved this result!";
            }
        } else {
            $query = "INSERT INTO approval (teacher_id,course_code,course_dep,status_level,approved_by) VALUES ('" . $this -> _teacher_id . "','" . $this -> _course_code . "','" . $this -> _course_dep . "','0','" . $this -> _teacher_id . "')";
        }

        $result = $this -> _db -> query($query);
        if ($this -> _db -> affected_rows) {
            if ($this -> _db -> error == '') {
                return 1;
            } else {
                die($this -> _db -> error);
            }
        } else {
            return 2;
        }
    }

    public function approved($cid, $did) {
        $this -> _connect();

        $cid = $this -> _db -> real_escape_string($cid);
        $did = $this -> _db -> real_escape_string($did);

        $query = "SELECT * FROM approval WHERE course_code='" . $cid . "' AND course_dep='" . $did . "' AND timestamp>='".Session::get('semester_timestamp')."'";

        $result = $this -> _db -> query($query);
        if (!$result -> num_rows) {
            return 0;
        } else {
            $key = $result -> fetch_object();
            $this -> _teacher_id = $key -> teacher_id;
            $this -> _course_code = $key -> course_code;
            $this -> _course_dep = $key -> course_dep;
            $this -> _status_level = $key -> status_level;
            $this -> _reject_msg = $key -> reject_msg;
            $this -> _approved_by = $key -> approved_by;
            return 1;
        }
    }

    public function underApproval() {
        $this -> _connect();

        $query = "SELECT course_code, course_dep FROM approval WHERE status_level<'5' AND status_level > '-1' AND timestamp>='".Session::get('semester_timestamp')."'";
        $result = $this -> _db -> query($query);
        return $result;
    }
    
    public function statusApproval($course_code,$course_dep) {
        $this -> _connect();
		$course_code = $this -> _db -> real_escape_string($course_code);
		$course_dep = $this -> _db -> real_escape_string($course_dep);
        $query = "SELECT status_level FROM approval WHERE course_code='".$course_code."' AND course_dep='".$course_dep."' AND timestamp>='".Session::get('semester_timestamp')."'";
        $result = $this -> _db -> query($query);
        return $result;
    }

    public function underApprovalOfTeacher($tid) {
        $this -> _connect();
        $tid = $this -> _db -> real_escape_string($tid);
        $query = "SELECT * FROM approval WHERE status_level<='5' AND status_level >= '-1' AND teacher_id='" . $tid . "' AND timestamp>='".Session::get('semester_timestamp')."'";
        $result = $this -> _db -> query($query);
        return $result;
    }

    public function totallyApproved() {
        $this -> _connect();

        $query = "SELECT course_code, course_dep FROM approval WHERE status_level='5' AND timestamp>='".Session::get('semester_timestamp')."'";
        $result = $this -> _db -> query($query);
        return $result;
    }

    public function reject($tid, $cid, $did, $reject_msg) {
        if (!loggedIn()) {
            return 0;
        }
        $this -> _connect();

        $this -> _teacher_id = $this -> _db -> real_escape_string($tid);
        $tid = $this -> _db -> real_escape_string($tid);
        $this -> _course_code = $this -> _db -> real_escape_string($cid);
        $this -> _course_dep = $this -> _db -> real_escape_string($did);

        if ($this -> approved($cid, $did)) {
            if ($this -> _status_level == '-1') {
                die('This result is already rejected.');
            }
            if ($this -> _status_level < 5) {
                $approved_by = explode(',', $this -> _approved_by);
                $t = new Teacher();
                $t -> getInfo(Session::get('teacher_id'));
                $reject_msg = 'By ' . $t -> getName() . '. ' . $reject_msg;
                $this -> _reject_msg = $this -> _db -> real_escape_string($reject_msg);
                if (Session::get('privilege') === 'teacher') {
                    $i = 0;
                    while (isset($approved_by[$i])) {
                        if ($approved_by[$i] == $tid) {
                            return 2;
                            break;
                        } else {
                            $i++;
                        }
                    }
                } else if ((Session::get('privilege') === 'dupc' || Session::get('privilege') === 'dppc')) {
                    $i = 1;
                    if ($this -> _status_level >= 3) {
                        die("You cannot reject because all DUPC or DPPC members have approved!");
                    }

                    if ($t -> getDep() != $this -> _course_dep) {
                        die("Sorry! You cannot reject this result!");
                    }
                    while (isset($approved_by[$i])) {
                        if ($approved_by[$i] == $tid) {
                            return 2;
                            break;
                        } else {
                            $i++;
                        }
                    }
                } else if (Session::get('privilege') === 'hod' && $this -> _status_level == 3) {
                    if ($t -> getDep() != $this -> _course_dep) {
                        die("Sorry! You cannot reject this result!");
                    }
                } else if (Session::get('privilege') === 'hod' && $this -> _status_level < 3) {
                    die("You cannot approve/reject this result being HOD because DUPC or DPPC members have not approved/rejected this result yet.");
                } else if (Session::get('privilege') === 'hod' && $this -> _status_level > 3) {
                    die("You have already approved this result being HOD. So you cannot reject.");
                } else if (Session::get('privilege') === 'dean' && $this -> _status_level < 4) {
                    die("You cannot approve/reject this result being DEAN because HOD or DUPC or DPPC members have not approved/rejected this result yet.");
                }

                $approved_by = '';
                $status_level = '-1';
                $query = "UPDATE approval SET reject_msg='" . $this -> _reject_msg . "',status_level='" . $status_level . "', approved_by='" . $approved_by . "' WHERE teacher_id='" . $this -> _teacher_id . "' AND course_code='" . $this -> _course_code . "' AND course_dep='" . $this -> _course_dep . "' AND timestamp>='".Session::get('semester_timestamp')."'";
            } else {
                die("Cannot Reject!");
            }
        } else {
            die("Reject Error");
        }

        $result = $this -> _db -> query($query);
        if ($this -> _db -> affected_rows) {
            if ($this -> _db -> error == '') {
                return 1;
            } else {
                die($this -> _db -> error);
            }
        } else {
            return 2;
        }
    }

}
?>