<!DOCTYPE html>
<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
}
		include 'header.php';

		Session::put('side-nav-active','marks_entry_system');
		Session::put('side-nav-active-sub','last_date');
		include 'sidebar.php';
		Session::delete('side-nav-active');
		Session::delete('side-nav-active-sub');	

		include 'set_last_date.php';

		include 'footer.php';
		
?>