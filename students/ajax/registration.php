<?php
require_once '../../core/init.php';

if(Input::exists('post')){
	$validate = new Validate();
	$_POST['mobile'] = (int)Input::get('mobile');
	$_POST['parents_mobile'] = (int)Input::get('parents_mobile');
	$validation = $validate->check($_POST,array(
		'gender' => array(
			'required' => true
		),
		'programme' => array(
			'required' => true,
		),
		'Category' => array(
			'required' => true
		),
		'mobile' => array(
			'required' => true,
			'min' => 10,
			'max' => 10
		),
		'parents_mobile' => array(
			'required' => true,
			'min' => 10,
			'max' => 10
		),
		'semester' => array(
			'required' => true
		),
		'department' => array(
			'required' => true
		),
		'courses' => array(
			'required' => true
		),
		'total_credits' => array(
			'required' => true
		),
		'hostel_address' => array(
			'required' => true
		),
		'home_address' => array(
			'required' => true
		),
	));
	
	if($validate->passed() && Token::check_a(Input::get('token'))){
		$stud = new Student();
		
		$name = Session::get('displayname');
	    $email = Session::get('student_email');
	    $scholar_no = Session::get('sn');
	    $session = Session::get('semester_session');
		$category=Input::get('Category');
		$gender=Input::get('gender');
		$programme=strtoupper(Input::get('programme'));
		$semester=Input::get('semester');
		$department=Input::get('department');
		$mobile=Input::get('mobile');
		$parents_mobile=Input::get('parents_mobile');
		$courses=Input::get('courses');
		$courses=explode(' ,',$courses);
		$courses=$courses[1];
		$courses_load = strtoupper(Input::get('loadcode1').','.Input::get('loadcode2'));
		$courses_load = rtrim($courses_load,',');
		$course_credits=Input::get('course_credits');
		$home_address=Input::get('home_address');
		$hostel_address=Input::get('hostel_address');
		
		$add = $stud->register($email, $name, $gender, $scholar_no, $category, $programme, $semester, $session, $department, $mobile, $parents_mobile, $courses, $courses_load, $home_address, $hostel_address);
		
		if($add==1){
			$log = new Log();
			$log->actionLog('Student Registered');
			echo 'Registration Successful.';
			$otp = new OTP();
			$otp->send($mobile);
			//Redirect::to('registration.php?step=2');
		}
		else{
			echo 'Something went wrong... Please try again after clicking cancel.';
		}
	}
	else{
		echo "Please fill the required fields : ";
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'programme is required':
					echo 'Programme, ';
				break;
				case 'mobile is required':
					
				case 'mobile must be minimum of 10 characters.':
					
				case 'mobile must be maximum of 10 characters.':
					echo 'Valid Mobile Number, ';
				break;
				case 'parents_mobile is required':
					
				case 'parents_mobile must be minimum of 10 characters.':
					
				case 'parents_mobile must be maximum of 10 characters.':
					echo 'Valid Parent\'s Mobile Number, ';
				break;
				case 'semester is required':
					echo 'Semester, ';
				break;
				case 'department is required':
					echo 'Department, ';
				break;
				case 'courses is required':
					echo 'Select Courses, ';
				break;
				case 'total_credits is required':
						
				break;
				case 'home_address is required':
					echo "Home Address.<br/>";
				break;
				case 'hostel_address is required':
					echo "Hostel Address, ";
				break;
				default:
					echo '<li>' . $errors . '</li>';
				break;
			}
		}
	}
}
else
	echo 'here';
?>