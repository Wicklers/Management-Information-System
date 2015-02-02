<?php
/**
 * 
 *
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @version 1.0
 * @copyright Computer Science & Engineering Department, NIT Silchar 
 * @package MIS
 */

if(!loggedIn()){
	die();
}
?>
<!Doctype html>
<!--

Name: National Institute of Technology, Silchar. Management Information System | Login Page


AUTHOR
Design and code by: Harsh Vardhan Ladha & Yogesh Chauhan


CREDITS
Ripon Patgiri

SUPPORT
E-mail: harsh.ladha@gmail.com , anujsingh432@gmail.com , ripon.patgiri@gmail.com

-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="images/nits.png">
		<link rel="shortcut icon" href="images/nits.png" />
        <title>SIS | NIT Silchar</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
       <!--Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Balthazar&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Student Information System
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo Session::get('displayname'); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                	<?php 
                                	$name1 = strtolower(preg_replace('/\s+/', '', Session::get('displayname')));
                                	if(Session::get('student_id')!=NULL)
                                		$id = Session::get('student_id');
                                	else
                                		$id = '';
                                	$filepath = "images/profile/".$name1.$id.".jpg";
                                	if(!file_exists($filepath))
                                		$filepath="images/profile/default.png";
                                	?>
                                	<img src=<?php echo $filepath; ?> class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo Session::get('displayname'); ?>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-danger btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>