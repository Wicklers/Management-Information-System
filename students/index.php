<?php
require_once '../core/init.php';
if(loggedIn())
	Redirect::to('home.php');
else
	require_once 'login.php';

?>