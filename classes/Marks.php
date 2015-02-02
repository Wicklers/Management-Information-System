<?php
/**
 * @package MIS
 * @name Marks
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Marks{
	private $_courseId,
			$_course_dep,
			$_course_type,
			$_sch_no,
			$_type,
			$_gradeScale,
			$_sessionalFormula,
			$_teacher_id,
			$_db;
			
	public function __construct(){
		
	}
	
	private function _connect(){
		$this->_db = new MySQLi(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
		if($this->_db->connect_errno){
			die("MySQL Error : " . $this->_db->connect_error);
		}
	}
	
	public function setGradingScale($tid='',$ccode='',$cdep='',$scale=''){
		if(loggedIn()){
			$this->_connect();
			$this->_teacher_id = $this->_db->real_escape_string(escape($tid));
			$this->_courseId = $this->_db->real_escape_string(escape($ccode));
			$this->_course_dep = $this->_db->real_escape_string(escape($cdep));
			$this->_gradeScale = $this->_db->real_escape_string(escape($scale));
			$Query = "SELECT * FROM grading_scale WHERE course_code='".$this->_courseId."' AND course_dep='".$this->_course_dep."' AND timestamp>='".Session::get('semester_timestamp')."' LIMIT 1";
			
			$result = $this->_db->query($Query);
			
			if($result->num_rows==0){
			$query = "INSERT INTO grading_scale (teacher_id, course_code, course_dep, gradescale) VALUES ('".$this->_teacher_id."','".$this->_courseId."','".$this->_course_dep."','".$this->_gradeScale."')";
			} else
			{
			$query = "UPDATE grading_scale SET teacher_id ='".$this->_teacher_id."', gradescale ='".$this->_gradeScale."' WHERE course_code='".$this->_courseId."' AND course_dep=".$this->_course_dep." AND timestamp>='".Session::get('semester_timestamp')."' LIMIT 1";
			
			}
			$result = $this->_db->query($query);
			//die($this->_db->affected_rows);
			if($this->_db->affected_rows){
				if($this->_db->error==''){
					return 1;
				}
				else{
					die($this->_db->error);
				}
			}
			else{
				return 2;
			}
		}
		else{
			return 0;
		}
	}
	/*
	* formula : 1 => Highest of all.
	*           2 => Best of three.
	*           3 => Best of two.
	*           
	*/
	public function setSessionalFormula($tid='',$ccode='',$cdep='',$formula=''){
		if(loggedIn()){
			$this->_connect();
			$this->_teacher_id = $this->_db->real_escape_string(escape($tid));
			$this->_courseId = $this->_db->real_escape_string(escape($ccode));
			$this->_course_dep = $this->_db->real_escape_string(escape($cdep));
			$this->_sessionalFormula = $this->_db->real_escape_string(escape($formula));
			
			$check = $this->getSessionalFormula($tid,$ccode,$cdep);
			if(!$check->num_rows){
				$query = "INSERT INTO sessional_formula (teacher_id, course_code, course_dep, formula) VALUES ('".$this->_teacher_id."','".$this->_courseId."','".$this->_course_dep."','".$this->_sessionalFormula."')";
			}
			else{
				$query = "UPDATE sessional_formula SET formula = '".$this->_sessionalFormula."' WHERE teacher_id='".$this->_teacher_id."' AND course_code='".$this->_courseId."' AND course_dep='".$this->_course_dep."' AND timestamp>='".Session::get('semester_timestamp')."' ";
			}
			$result = $this->_db->query($query);
			if($this->_db->affected_rows){
				if($this->_db->error==''){
					return 1;
				}
				else{
					die($this->_db->error);
				}
			}
			else{
				return 2;
			}
		}
		else{
			return 0;
		}
		
		
	}
	
	public function setLastDate($type, $lastdate){
		if(loggedIn() && ((privilege()=='admin') || (privilege()=='director') || (privilege()=='dean'))){
			$this->_connect();
			$type = $this->_db->real_escape_string(escape($type));
			$lastdate = $this->_db->real_escape_string(escape($lastdate));
			$query = "UPDATE last_dates SET date = '".$lastdate."' WHERE exam_type='".$type."'";
			$result = $this->_db->query($query);
			if($this->_db->affected_rows){
				if($this->_db->error==''){
					return 1;
				}
				else
					die($this->_db->error);
			}
			else{
				return 4;
			}
		}
		else if(loggedIn()){
			return 3;
		}
		else if(!loggedIn()){
			return 0;
		}
	}
	
	public function MarksEntry($sch_no='', $ccode='', $cdep='', $type ,$marks=0){
		if(loggedIn()){
			
			$marks1 = $this->getMarks($sch_no,$ccode,'*');
			$ccode = $this->_db->real_escape_string(escape($ccode));
			$cdep = $this->_db->real_escape_string(escape($cdep));
			$sch_no = $this->_db->real_escape_string(escape($sch_no));
			$type = $this->_db->real_escape_string(escape($type));
			$marks = $this->_db->real_escape_string(escape($marks));
			
			$c = new Course();
			if(!$c->appointError(Session::get('teacher_id'), $ccode, $cdep)){
				unset($c);
				return 0;
			}
			
			if(empty($marks1)){
				$query = "INSERT INTO marks (sch_no, course_code, course_dep, ".$type.") VALUES ('".$sch_no."','".$ccode."',".$cdep.",".$marks.")";
			}
			else{
				$query = "UPDATE marks SET ".$type." = ".$marks." WHERE sch_no='".$sch_no."' AND course_code='".$ccode."' AND timestamp>='".Session::get('semester_timestamp')."'";
			}
				
			$result = $this->_db->query($query);
			if($this->_db->affected_rows){
				if($this->_db->error==''){
					
					return 1;
				}
				else{
					die($this->_db->error);
				}
			}
			else{
				//$this->calculateSessional($sch_no,$ccode,$cdep);
				return 2;
			}
		}
		else{
			return 0;
		}
	}
	public function MarksEntryLoad($sch_no='', $ccode='', $cdep='', $type ,$marks=0){
		if(loggedIn()){
			$marks1 = $this->getMarksLoad($sch_no,$ccode,'*');
				
			$ccode = $this->_db->real_escape_string(escape($ccode));
			$cdep = $this->_db->real_escape_string(escape($cdep));
			$sch_no = $this->_db->real_escape_string(escape($sch_no));
			$type = $this->_db->real_escape_string(escape($type));
			$marks = $this->_db->real_escape_string(escape($marks));
			
			
			$c = new Course();
			if(!$c->appointError(Session::get('teacher_id'), $ccode, $cdep)){
				unset($c);
				return 0;
			}
			
			if(empty($marks1)){
				$query = "INSERT INTO marks_load (sch_no, course_code, course_dep, ".$type.") VALUES ('".$sch_no."','".$ccode."',".$cdep.",".$marks.")";
			}
			else{
				$query = "UPDATE marks_load SET ".$type." = ".$marks." WHERE sch_no='".$sch_no."' AND course_code='".$ccode."' AND timestamp>='".Session::get('semester_timestamp')."'";
			}
	
			$result = $this->_db->query($query);
			if($this->_db->affected_rows){
				if($this->_db->error==''){
						
					return 1;
				}
				else{
					die($this->_db->error);
				}
			}
			else{
				//$this->calculateSessional($sch_no,$ccode,$cdep);
				return 2;
			}
		}
		else{
			return 0;
		}
	}
	
	public function importCSV($course_code='',$course_dep='',$type='',$category='regular',$filename=''){
		if(loggedIn()){
			if($category=='regular'){
				$file = fopen($filename, "r");
				$count=0;
				while(($data = fgetcsv($file,10000,","))!==FALSE){
					$count++;
				
					if($count>1){
						$save = $this->MarksEntry($data[0],$course_code,$course_dep,$type,$data[1]);
					}
				}
				fclose($file);
				return 1;
			}
			else if($category=='load'){
				$file = fopen($filename, "r");
				$count=0;
				while(($data = fgetcsv($file,10000,","))!==FALSE){
					$count++;
				
					if($count>1){
						$save = $this->MarksEntryLoad($data[0],$course_code,$course_dep,$type,$data[1]);
					}
				}
				fclose($file);
				return 1;
			}
			else
				return 0;
		}
		else{
			return 0;
		}
	}
	
	public function exportCSV($course_code, $course_dep, $type, $category){
		ob_end_clean();
		$this->_connect();
		// CSV/EXCEL FILE HEADER
		$headers = array();
		if($type==='all'){
			$headers[] = "Scholar No.";
			$headers[] = "CT1";
			$headers[] = "CT2";
			$headers[] = "CT3";
			$headers[] = "SESSIONAL";
			$headers[] = "MID SEM";
			$headers[] = "END SEM";
            $headers[] = "TOTAL";
		    $headers[] = "GRADE";
		    if($category=='regular')
				$query = "SELECT sch_no,ct1,ct2,ct3,sessional,midsem,endsem,pointer FROM marks WHERE course_code='".$course_code."' AND course_dep='".$course_dep."' AND timestamp>='".Session::get('semester_timestamp')."' ORDER BY sch_no";
		    else if($category=='load')
		    	$query = "SELECT sch_no,ct1,ct2,ct3,sessional,midsem,endsem,pointer FROM marks_load WHERE course_code='".$course_code."' AND course_dep='".$course_dep."' AND timestamp>='".Session::get('semester_timestamp')."' ORDER BY sch_no";
		}
		else{
			$headers[] = "Scholar No.";
			$headers[] = strtoupper($type);
			if($category=='regular')
				$query = "SELECT sch_no,".$type." FROM marks WHERE course_code='".$course_code."' AND course_dep='".$course_dep."' AND timestamp>='".Session::get('semester_timestamp')."' ORDER BY sch_no";
			else if($category=='load')
				$query = "SELECT sch_no,".$type." FROM marks_load WHERE course_code='".$course_code."' AND course_dep='".$course_dep."' AND timestamp>='".Session::get('semester_timestamp')."' ORDER BY sch_no";
		}
		$result = $this->_db->query($query);
		
		
		// Filename with current date
		$current_date = date("y/m/d");
		$filename = "MarksSheet_" . $course_code . "_".Session::get('semester_session').".csv";
		
		$fp = fopen('php://output', 'w');
		if ($fp && $result) {
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			header('Pragma: no-cache');
			header('Expires: 0');
			// Write mysql headers to csv
			fputcsv($fp, $headers);
			// Write mysql rows to csv
			if($type==="all"){
			    while ($row = $result->fetch_array(MYSQL_NUM)) {
			        $pointer = $row[7];
                    $row[7]=$row[4]+$row[5]+$row[6];
                    $row[8]=$this->getGradeFromPointer($pointer);
                    fputcsv($fp, array_values($row));
                }
			}
            else{
                while ($row = $result->fetch_array(MYSQL_NUM)) {
                    fputcsv($fp, array_values($row));
                }
            }
			
			fclose($fp);
			
			die;
		}
	}
	
	public function getSessionalFormula($tid='',$ccode='',$cdep=''){
		$this->_connect();
		$tid = $this->_db->real_escape_string(escape($tid));
		$ccode = $this->_db->real_escape_string(escape($ccode));
		$cdep = $this->_db->real_escape_string(escape($cdep));
		if($tid!=''){
			$query = "SELECT formula FROM sessional_formula WHERE teacher_id='".$tid."' AND course_code='".$ccode."' AND course_dep='".$cdep."' AND timestamp>='".Session::get('semester_timestamp')."'";
		}
		else{
			$query = "SELECT formula FROM sessional_formula WHERE course_code='".$ccode."' AND course_dep='".$cdep."' AND timestamp>='".Session::get('semester_timestamp')."'";
		}
		
		$result = $this->_db->query($query);
		return $result;
	}
	
	public function getMarks($sch_no='',$ccode='',$selectors=''){
		$this->_connect();
		$type = $this->_db->real_escape_string(escape($selectors));
		$ccode = $this->_db->real_escape_string(escape($ccode));
		$sch_no = $this->_db->real_escape_string(escape($sch_no));
		$query = "SELECT ".$selectors." FROM marks WHERE sch_no='".$sch_no."' AND course_code='".$ccode."' AND timestamp>='".Session::get('semester_timestamp')."'";
		$result = $this->_db->query($query);
        if($result->num_rows){
            return $result;
        }else{
            return '';    
        }
		
	}
	
	public function getMarksLoad($sch_no='',$ccode='',$selectors=''){
		$this->_connect();
		$type = $this->_db->real_escape_string(escape($selectors));
		$ccode = $this->_db->real_escape_string(escape($ccode));
		$sch_no = $this->_db->real_escape_string(escape($sch_no));
		$query = "SELECT ".$selectors." FROM marks_load WHERE sch_no='".$sch_no."' AND course_code='".$ccode."' AND timestamp>='".Session::get('semester_timestamp')."'";
		$result = $this->_db->query($query);
		if($result->num_rows){
			return $result;
		}else{
			return '';
		}
	
	}
	public function getLastDate($exam_type){
		$this->_connect();
		$query = "SELECT date FROM last_dates WHERE exam_type='".$exam_type."'";
		$result = $this->_db->query($query);
		return $result;
	}
	public function getMarksofAll($course_dep,$course_code,$selectors){
		$this->_connect();
		$query = "SELECT ".$selectors." FROM marks WHERE course_dep='".$course_dep."' AND course_code='".$course_code."' AND timestamp>='".Session::get('semester_timestamp')."' ORDER BY sch_no ";
		$result = $this->_db->query($query);
		if($result->num_rows){
            return $result;
        }else{
            return '';    
        }
	}
	public function getMarksofAllLoad($course_dep,$course_code,$selectors){
		$this->_connect();
		$query = "SELECT ".$selectors." FROM marks_load WHERE course_dep='".$course_dep."' AND course_code='".$course_code."' AND timestamp>='".Session::get('semester_timestamp')."' ORDER BY sch_no ";
		$result = $this->_db->query($query);
		if($result->num_rows){
			return $result;
		}else{
			return '';
		}
	}
	
	public function calculateSessional($sch_no='',$ccode='',$cdep='', $type='regular'){
		
		$formula = $this->getSessionalFormula(Session::get('teacher_id'),$ccode,$cdep);
		if($type=='regular'){
			$marks2 = $this->getMarks($sch_no,$ccode, '*');
			while($m = $marks2->fetch_object()){
				$ct1 = $m->ct1;
				$ct2 = $m->ct2;
				$ia = $m->ct3;
			}
			if($formula->num_rows){
				$formula = $formula->fetch_object()->formula;
				switch($formula){
					case 1: //Highest of two class test + ia
						$sessional = (max($ct1,$ct2)+$ia);
					break;
					case 2: //Average of two class test + ia
						$sessional = ((($ct1+$ct2)/2)+$ia);
					break;
					default: //Highest of two class test + ia
						$sessional = (max($ct1,$ct2)+$ia);
					break;
				}
			}
			else{
				$this->setSessionalFormula(Session::get('teacher_id'),$ccode,$cdep,1);
				$sessional = (max($ct1,$ct2)+$ia);
			}
			$sch_no = $this->_db->real_escape_string(escape($sch_no));
			$ccode = $this->_db->real_escape_string(escape($ccode));
			$cdep = $this->_db->real_escape_string(escape($cdep));
			$sessional = $this->_db->real_escape_string(escape($sessional));
			$query = "UPDATE marks SET sessional = ".$sessional." WHERE sch_no='".$sch_no."' AND course_code='".$ccode."' AND timestamp>='".Session::get('semester_timestamp')."'";
			$result = $this->_db->query($query);
		}
		else if($type=='load'){
			$marks2 = $this->getMarksLoad($sch_no,$ccode, '*');
			while($m = $marks2->fetch_object()){
				$ct1 = $m->ct1;
				$ct2 = $m->ct2;
				$ia = $m->ct3;
			}
			if($formula->num_rows){
				$formula = $formula->fetch_object()->formula;
			switch($formula){
					case 1: //Highest of two class test + ia
						$sessional = (max($ct1,$ct2)+$ia);
					break;
					case 2: //Average of two class test + ia
						$sessional = ((($ct1+$ct2)/2)+$ia);
					break;
					default: //Highest of two class test + ia
						$sessional = (max($ct1,$ct2)+$ia);
					break;
				}
			}
			else{
				$this->setSessionalFormula(Session::get('teacher_id'),$ccode,$cdep,1);
				$sessional = (max($ct1,$ct2)+$ia);
			}
			$sch_no = $this->_db->real_escape_string(escape($sch_no));
			$ccode = $this->_db->real_escape_string(escape($ccode));
			$cdep = $this->_db->real_escape_string(escape($cdep));
			$sessional = $this->_db->real_escape_string(escape($sessional));
			$query = "UPDATE marks_load SET sessional = ".$sessional." WHERE sch_no='".$sch_no."' AND course_code='".$ccode."' AND timestamp>='".Session::get('semester_timestamp')."'";
			$result = $this->_db->query($query);
		}
	}
	
	public function calculatePointer($sch_no='',$ccode='',$cdep='', $type='regular'){
		$marks2 = $this->getMarks($sch_no,$ccode, '*');
			$m = $marks2->fetch_object();
			$sessional = $m->sessional;
			$midsem = $m->midsem;
			$endsem = $m->endsem;
		$total = ($sessional+$midsem+$endsem);
		$pointer = $this->getPointer($total,$ccode,$cdep);
		$sch_no = $this->_db->real_escape_string(escape($sch_no));
		$ccode = $this->_db->real_escape_string(escape($ccode));
		$pointer = $this->_db->real_escape_string(escape($pointer));
		if($type=="regular"){
			$query = "UPDATE marks SET pointer = ".$pointer." WHERE sch_no='".$sch_no."' AND course_code='".$ccode."' AND timestamp>='".Session::get('semester_timestamp')."'";
		}
		else if($type=="load"){
			$query = "UPDATE marks_load SET pointer = ".$pointer." WHERE sch_no='".$sch_no."' AND course_code='".$ccode."' AND timestamp>='".Session::get('semester_timestamp')."'";
		}
		$result = $this->_db->query($query);
	}
	
	
	public function getGradeScale($cid,$cdep){
		$this->_connect();
		$Query = "SELECT gradescale FROM grading_scale WHERE course_code='".$cid."' AND course_dep='".$cdep."' AND timestamp>='".Session::get('semester_timestamp')."'";
		$result = $this->_db->query($Query);
		if($result->num_rows==0){
			return 0;		
		}
		$value = $result->fetch_object();
		$value = $value->gradescale;
		//$grade = explode(',',$result);
		return $value;
	}
	public function getPointer($x,$cid,$cdep){
		$this->_connect();
		$scale = $this->getGradeScale($cid,$cdep);
		$grade_set = explode(',',$scale);
		if(!isset($grade_set[1])){
			die("Set Grading Scale");
		}
		if($grade_set[1]<=$x){
			return 10;
		}else if($grade_set[3]<=$x){
			return 9;
		}else if($grade_set[5]<=$x){
			return 8;
		}else if($grade_set[7]<=$x){
			return 7;
		}else if($grade_set[9]<=$x){
			return 6;
		}else if($grade_set[11]<=$x){
			return 5;
		}else if($grade_set[13]<=$x){
			return 4;
		}
		else{
			return 0;
		}
	}
	
	public function finalPointer($sch_num){
		//die($sch_num);
		$total_credit=0;
		$pointer=0;
		$total=0;
		$this->_connect();
		$query = "Select course_credit from courses";
		$result2 = $this->_db->query($query);
		$value2 = $result2->fetch_object();
		$query = "Select course_code, sessional, midsem, endsem from marks where sch_no='".$sch_num."' AND timestamp>='".Session::get('semester_timestamp')."'";
		//die($query);
		$result = $this->_db->query($query);
		//die($result->num_rows);
		if($result->num_rows){
			while($value=$result->fetch_object()){
				$sessional = $value->sessional;
				$midsem = $value->midsem;
				$endsem = $value->endsem;
				$C_code = $value->course_code;
				$query = "Select course_credit,course_department from courses where course_id='".$C_code."'";
				$result2 = $this->_db->query($query);
				$value2 = $result2->fetch_object();
				$credit = $value2->course_credit;
				$cdep = $value2->course_department;
				$sub_pointer=$this->getPointer(($sessional+$midsem+$endsem),$C_code,$cdep);
				$total += $sub_pointer*$credit;
				$total_credit += $credit;
			}
			
			
		}

		$pointer=$total/$total_credit;
		die ("swad".$pointer);
		return $pointer;
	}
	
	public function generateResult($ccode='',$cdep=''){
		$this->_connect();
		
		$ccode = $this->_db->real_escape_string($ccode);
		$cdep = $this->_db->real_escape_string($cdep);
		
		$query = "SELECT sch_no FROM marks WHERE course_code='".$ccode."' AND course_dep='".$cdep."' AND timestamp>='".Session::get('semester_timestamp')."'";
		$result = $this->_db->query($query);
		while($key = $result->fetch_object()){
			$this->calculateSessional($key->sch_no,$ccode,$cdep, 'regular');
			$this->calculatePointer($key->sch_no,$ccode,$cdep,'regular');
		}
		$query = "SELECT sch_no FROM marks_load WHERE course_code='".$ccode."' AND course_dep='".$cdep."' AND timestamp>='".Session::get('semester_timestamp')."'";
		$result = $this->_db->query($query);
		while($key = $result->fetch_object()){
			$this->calculateSessional($key->sch_no,$ccode,$cdep, 'load');
			$this->calculatePointer($key->sch_no,$ccode,$cdep,'load');
		}
	}
	
	public function totalNumOfGivenGrade($pointer,$ccode,$cdep){
		$this->_connect();
		$pointer = $this->_db->real_escape_string($pointer);
		$ccode = $this->_db->real_escape_string($ccode);
		$cdep = $this->_db->real_escape_string($cdep);
		$query = "SELECT COUNT(pointer) as count FROM marks WHERE pointer='".$pointer."' AND course_code='".$ccode."' AND course_dep='".$cdep."' AND timestamp>='".Session::get('semester_timestamp')."'";
		$result = $this->_db->query($query);
		$count = $result->fetch_object()->count;
		$query = "SELECT COUNT(pointer) as count FROM marks_load WHERE pointer='".$pointer."' AND course_code='".$ccode."' AND course_dep='".$cdep."' AND timestamp>='".Session::get('semester_timestamp')."'";
		$result = $this->_db->query($query);
		$count += $result->fetch_object()->count;
		return $count;
	}
    
    public function getGradeFromPointer($pointer){
        switch($pointer){
            case '10':
                return 'AA';
            case '9':
                return 'AB';
            case '8':
                return 'BB';
            case '7':
                return 'BC';
            case '6':
                return 'CC';
            case '5':
                return 'CD';
            case '4':
                return 'DD';
            default:
                return 'F';
        }
    }
}
?>