<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
}

		include 'header.php';
	
		Session::put('side-nav-active','teachers');
		Session::put('side-nav-active-sub','view_teachers');
		include 'sidebar.php';
		Session::delete('side-nav-active');
		Session::delete('side-nav-active-sub');
			
		include 'list_teacher.php';
		
		include 'footer.php';
?>