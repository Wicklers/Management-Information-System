<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
	exit();
}

		include 'header.php';
	
		Session::put('side-nav-active','course_allotment');
		Session::put('side-nav-active-sub','courses_appointed');
		include 'sidebar.php';
		Session::delete('side-nav-active');
		Session::delete('side-nav-active-sub');
		
		include 'list_courses_appointed.php';
	
		include 'footer.php';

?>