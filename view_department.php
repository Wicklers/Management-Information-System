<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
	exit();
}

		include 'header.php';
	
		Session::put('side-nav-active','departments');
		Session::put('side-nav-active-sub','view_departments');
		include 'sidebar.php';
		Session::delete('side-nav-active');
		Session::delete('side-nav-active-sub');
		?>
		<?php 
		include 'list_department.php';
		?>
		<?php 
		include 'footer.php';

?>