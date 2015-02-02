<?php
/**
 * @package MIS
 * @name Log
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class Log {
	private $filename;
	
	public function write($message) {
		$file ='/opt/lampp/MIS.LOGS/' . $this->filename; 
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, date('Y-m-d H:i:s') . ' - ' . print_r($message, true)  . '. IP ADDRESS : ' . $_SERVER['REMOTE_ADDR'] . "\n");
			
		fclose($handle); 
	}
	
	public function loginLog($case){
		
		$this->filename = 'login_log.txt';
		switch($case){
			case 'attempt':
				$message = strtoupper(Session::get('type')) . ' Login Attempt - username provided : ' . Input::get('a');
			break;
			
			case 'wrong credentials':
				$message = strtoupper(Session::get('type')) . ' Login Failed - Wrong Credentials.';
			break;
			
			case 'wrong OTP':
				$message = strtoupper(Session::get('type')) . ' Login Failed - Wrong OTP.';
			break;
			
			case 'success':
				$message = strtoupper(Session::get('type')) . ' Login Successful - ';
				switch(Session::get('type')){
					case 'admin':
						$message .= 'id - ' . Session::get('admin_username');
					break;
					
					case 'faculty':
						$message .= 'id - ' . Session::get('teacher_email');
					break;
					
					case 'student':
						$message .= 'id - ' . Session::get('student_email');
					break;
				}
			break;
		}
		
		$this->write($message);
		
	}
	
	public function pageRequestLog(){
		$this->filename = 'page_request_log.txt';
		$message = 'Page Requested : ' . $_SERVER['REQUEST_URI'];
		
		$this->write($message);
	}
	
	public function actionLog($type){
		$this->filename = 'action_log.txt';
		
		switch(Session::get('type')){
					case 'admin':
						$message = strtoupper(Session::get('type')) . ' : ' . Session::get('admin_username') . '.';
					break;
					
					case 'faculty':
						$message = strtoupper(Session::get('type')) . ' : ' . Session::get('teacher_email') . '.';
					break;
		}
		
		switch($type){
			
			case 'Added Department':
				$message .= ' Added Department. Name : ' . Input::get('name') . '. Id : ' . Input::get('id');
			break;
			
			case 'Edited Department':
				$message .= ' Edited Department to Name : ' . Input::get('name') . '. Id : ' . Input::get('id');
			break;
			
			case 'Deleted Department':
				$message .= ' Deleted Department. Id of Deleted Department : ' . Input::get('did');
			break;
			
			case 'Added Teacher':
				$message .= ' Added Teacher. Name : '.Input::get('name').', Email : '.Input::get('email').', Privilege : '.Input::get('privilege').', Department Id : '.Input::get('department').', Mobile : '.Input::get('mobile');
			break;
			
			case 'Student Registered':
				$message = ' Student Registered. Name : '.Session::get('displayname').', Email : '.Session::get('student_email').',  Mobile : '.Input::get('mobile');
			break;
			
			case 'Approved Teacher':
				$message .= ' Approved Teacher. Name : '.Input::get('name').', Email : '.Input::get('email').', Privilege : '.Input::get('privilege').', Department Id : '.Input::get('department').', Mobile : '.Input::get('mobile');
			break;
			
			case 'Disapproved Teacher':
				$message .= ' DisApproved Teacher. Name : '.Input::get('name').', Email : '.Input::get('email').', Privilege : '.Input::get('privilege').', Department Id : '.Input::get('department').', Mobile : '.Input::get('mobile');
			break;
			
			case 'Unblocked Teacher':
				$message .= ' Unblocked Teacher. Name : '.Input::get('name').', Email : '.Input::get('email').', Privilege : '.Input::get('privilege').', Department Id : '.Input::get('department').', Mobile : '.Input::get('mobile');
			break;
			
			case 'Blocked Teacher':
				$message .= ' Blocked Teacher. Name : '.Input::get('name').', Email : '.Input::get('email').', Privilege : '.Input::get('privilege').', Department Id : '.Input::get('department').', Mobile : '.Input::get('mobile');
			break;
			
			case 'Edited Teacher':
				$message .= ' Edited Teacher information of Name : '.Input::get('name').', Email : '.Input::get('email').', Privilege : '.Input::get('privilege').', Department Id : '.Input::get('department').', Mobile : '.Input::get('mobile');
			break;
			
			case 'Removed Teacher':
				$message .= ' Removed Teacher. Id of Removed Teacher : '.Input::get('tid');
			break;
			
			case 'Added Course':
				$message .= ' Added Course. Code : '.Input::get('coursecode').', Name : '.Input::get('coursename');
			break;
			
			case 'Edited Course':
				$message .= ' Edited Course Information of Course Code : '.Input::get('coursecode');
			break;
			
			case 'Deleted Course':
				$message .= ' Deleted Course of Code : '.Input::get('cid');
			break;
			
			case 'Appointed Course':
				$message .= ' Appointed Course, Code '.Input::get('coursecode').' to Teacher id : '.Input::get('teacher');
			break;
			
			case 'Changed Last Date':
				$message .= ' Changed Last Date of Examination '.Input::get('examtype').' to (MM/DD/YYYY):'.Input::get('lastdate');
			break;
			
			case 'Saved Marks':
				$message .= ' Saved Marks of Course Code : '.Input::get('c_code').' in department id : '.Input::get('c_dep').' exam type : '.Input::get('examtype');
			break;
		}
		
		$this->write($message);
	}
	
	public function totalLogs($filename){
		$this->filename = 'opt/lampp/MIS.LOGS/' . $filename;
		$linecount = count(file($this->filename)); 
		return $linecount;
	}
	
	public function totalActions($action_name){
		$this->filename = 'opt/lampp/MIS.LOGS/action_log.txt';
		$handle = fopen($this->filename,"r");
		$count=0;
		switch($action_name){
			case 'Added':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Added')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Edited':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Edited')!==false || strpos($line,'Changed')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Deleted':
			while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Deleted')!==false || strpos($line,'Remove')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
		}
	}
	
	public function totalNew($new_type){
		$this->filename = 'opt/lampp/MIS.LOGS/action_log.txt';
		$handle = fopen($this->filename,"r");
		$count=0;
		switch($new_type){
			case 'Department':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Added Department')!==false ){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Teacher':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Added Teacher')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Course':
			while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Added Course')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
		}
		
	}
	
	public function totalEdits($edit_type){
		$this->filename = 'opt/lampp/MIS.LOGS/action_log.txt';
		$handle = fopen($this->filename,"r");
		$count=0;
		switch($edit_type){
			case 'Department':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Edited Department')!==false ){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Teacher':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Edited Teacher')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Course':
			while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Edited Course')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
				
			case 'Last Dates':
			while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Changed Last Date')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
		}
		
	}
	
	public function totalDeleted($deleted_type){
		$this->filename = 'opt/lampp/MIS.LOGS/action_log.txt';
		$handle = fopen($this->filename,"r");
		$count=0;
		switch($deleted_type){
			case 'Department':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Deleted Department')!==false ){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Teacher':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Removed Teacher')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Course':
			while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Deleted Course')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
		}
		
	}
	
	public function totalLogins($login_type){
		$this->filename = 'opt/lampp/MIS.LOGS/login_log.txt';
		$handle = fopen($this->filename,"r");
		$count=0;
		switch($login_type){
			case 'Attempts':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Login Attempt')!==false ){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Wrong Credentials':
				while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Wrong Credentials')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
			
			case 'Wrong OTP':
			while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Wrong OTP')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
				
			case 'Success':
			while(!feof($handle)){
					$line = fgets($handle);
					if(strpos($line,'Login Successful')!==false){
						$count++;
					}
				}
			fclose($handle);
			return $count;
			break;
		}
		
	}
}
/*
print('<pre>');
print_r($_SERVER);
echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/mis/logs/hello.txt';
*/
?>
