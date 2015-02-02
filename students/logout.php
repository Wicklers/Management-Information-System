<?php
require_once '../core/init.php';

Session::destroy();
Redirect::to('login.php');
?>