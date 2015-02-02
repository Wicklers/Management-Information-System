<!DOCTYPE html>
<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
}
		include 'header.php';

		Session::put('side-nav-active','course_allotment');
		Session::put('side-nav-active-sub','assign_course');
		include 'sidebar.php';
		Session::delete('side-nav-active');
		Session::delete('side-nav-active-sub');	

		include 'assign_course_teacher.php';

		include 'footer.php';
		
?>