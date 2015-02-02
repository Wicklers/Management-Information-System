<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
}
else if(loggedIn() && (privilege()==='teacher' || privilege()==='dppc' || privilege()==='dupc')){
	Session::destroy();
	Redirect::to('includes/errors/unauthorized.php');
}

		include 'header.php';

		Session::put('side-nav-active','departments');
		Session::put('side-nav-active-sub','add_department');
		include 'sidebar.php';
		Session::delete('side-nav-active');
		Session::delete('side-nav-active-sub');	
		
		include 'add_new_department.php';
	
		include 'footer.php';
		
?>