<?php
require_once 'core/init.php';
require_once 'functions/createPie.php';

if(!loggedIn()){
	Redirect::to('index.php');
}
if(Input::exists('get')){
	$log = new Log();
	switch(Input::get('type')){
		case 'actions':
			$new = $log->totalActions('Added');
			$edits = $log->totalActions('Edited');
			$deleted = $log->totalActions('Deleted');
			createPie(array("Total New Entry"=>"$new","Total Entries Edited"=>"$edits","Total Entries Deleted"=>"$deleted"));
		break;
		
		case 'logins':
			$attempts = $log->totalLogins('Attempts');
			$wrong_credentials = $log->totalLogins('Wrong Credentials');
			$wrong_otp = $log->totalLogins('Wrong OTP');
			$success = $log->totalLogins('Success');
			createPie(array("Login Attempts"=>"$attempts","Wrong Credentials"=>"$wrong_credentials","Wrong OTP"=>"$wrong_otp","Successful Logins"=>"$success"));
		break;
		
		case 'new':
			$departments = $log->totalNew('Department');
			$teachers = $log->totalNew('Teacher');
			$courses = $log->totalNew('Course');
			
			createPie(array("Department"=>"$departments","Teacher"=>"$teachers","Course"=>"$courses"));
		break;
		
		case 'edits':
			$departments = $log->totalEdits('Department');
			$teachers = $log->totalEdits('Teacher');
			$courses = $log->totalEdits('Course');
			$last_dates = $log->totalEdits('Last Dates');
			
			createPie(array("Department"=>"$departments","Teacher"=>"$teachers","Course"=>"$courses","Exam Last Date"=>"$last_dates"));
		break;
		
		case 'deleted':
			$departments = $log->totalDeleted('Department');
			$teachers = $log->totalDeleted('Teacher');
			$courses = $log->totalDeleted('Course');
			
			createPie(array("Department"=>"$departments","Teacher"=>"$teachers","Course"=>"$courses"));
		break;
		
		case '';
			$action_logs = $log->totalLogs('action_log.txt');
			$login_logs = $log->totalLogs('login_log.txt');
			$page_request_logs = $log->totalLogs('page_request_log.txt');
			createPie(array("Total Actions"=>$action_logs,"Total Logins"=>$login_logs,"Total Page Requests"=>$page_request_logs));
		break;
	}
}
else{
	$log = new Log();
	$action_logs = $log->totalLogs('action_log.txt');
	$login_logs = $log->totalLogs('login_log.txt');
	$page_request_logs = $log->totalLogs('page_request_log.txt');
	createPie(array("Total Actions"=>$action_logs,"Total Logins"=>$login_logs,"Total Page Requests"=>$page_request_logs));
}
?>