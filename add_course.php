<!DOCTYPE html>
<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
}
		include 'header.php';

		Session::put('side-nav-active','courses');
		Session::put('side-nav-active-sub','add_course');
		include 'sidebar.php';
		Session::delete('side-nav-active');
		Session::delete('side-nav-active-sub');
		
		include 'add_new_course.php';

		
		include 'footer.php';

?>