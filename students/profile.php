
<?php
require_once '../core/init.php';

if(!Input::exists('get') || Input::get('user')==''){
	if(!loggedIn() || privilege()==NULL){
		Redirect::to('logout.php');
	}
	include 'header.php';

	Session::put('side-nav-active', 'profile');
	Session::put('side-nav-active-sub','');
	include 'sidebar.php';
	Session::delete('side-nav-active');
	Session::delete('side-nav-active-sub');
	
	include 'profile_page.php';

	include 'footer.php';
}
else{
	$user = Input::get('user');
	$email = $user.'@student.nits.ac.in';
	$s = new Student();
	$a = $s->getInfoByEmail($email);
	if(!$a){
		include 'includes/errors/404.php';
		die();
	}
	if(!$s->getPublished()){
		include 'includes/errors/404.php';
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
        <link rel="icon" href="//sis.nits.ac.in/images/nits.png">
		<link rel="shortcut icon" href="//sis.nits.ac.in/images/nits.png" />
        <title><?php echo $s->getName(); ?> | NIT Silchar</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta description="Public college profile of <?php echo $s->getName(); ?> of National Institute of Technology, Silchar. NIT Silchar.">
        <meta keywords="<?php echo $s->getName(); ?>, Computer Science and Engineering, Harsh Vardhan Ladha, Yogesh Chauhan, Ripon Patgiri, NIT Silchar, National Institute of Technology, Silchar, Assam, Regional Engineering College, Students profile, Public, Profile, Students">
        
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
        <link href="css/publicprofile.css" rel="stylesheet" type="text/css" />

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
                <div class="user-panel">
                        <div class="pull-left image">
                            <img src="images/nits.png" class="img-circle" alt="NIT Silchar" />
                        </div>
                    </div>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <h3 ><a href="http://www.nits.ac.in">राष्ट्रीय प्रौद्योगिकी संस्थान सिलचर<br />National Institute of Technology Silchar</a></h3>
                
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        
                    </ul>
                </div>
            </nav>
        </header>
        <div class="row">
    		<div class="col-md-2">
		</div>
		<div class="col-md-6">
			        
			<div class="box box-primary">
				<div class="box-header">
					<div class="box-title pull-left">
						<h3><?php echo $s->getName(); ?></h3>
						<h4><?php 
							$d = new Department();
							$d->getInfo($s->getDep());
							echo $d->getDepName();
							unset($d);
						?></h4>
						<h4><i><?php echo $s->getEmail(); ?></i></h4>
						<h4><i><?php 
							$username = explode('@',$s->getEmail())[0];
							echo "http://nits.ac.in/s/$username";
							$name1 = strtolower(preg_replace('/\s+/', '', $s->getName()));
							$id = $s->getID();
							$filename = $name1.$id;
						?></i></h4>
						<h4>Mobile : +91 <?php 
							echo $s->getMobile();
						?></h4>
						<?php
						if($s->getCVLink()){
						?>
							<h4><u><a href="//sis.nits.ac.in/students_cv/<?php echo $s->getCVLink(); ?>" target="_blank">Curriculum Vitae</a></u></h4>
						<?php
						}
						?>
					</div>
					<div class="box-title pull-right">
						
						<img src="//sis.nits.ac.in/images/profile/<?php echo $filename ?>.jpg" width="170px" height="170px">
						
					</div>
				</div> <!-- ./box-header -->
				<hr/>
				<div class="box-body">
					<?php echo $s->getBiography(); ?>
				</div><!-- ./box-body -->
				
			</div>
		</div>
		<div class="col-md-2">
			<div class="footer">
           		<b>&copy; 2015</b> <a target="_blank" href="http://www.nits.ac.in">National Institute of Technology, Silchar</a><br/>Proudly developed by<br /><a href="#"><i>Computer Science & Engineering</i></a>
				<br/><a target="_blank" href="http://www.harshladha.com"><b>Harsh Ladha</a> &amp; <a target="_blank" href="https://in.linkedin.com/in/yogeshchauhan1">Yogesh Chauhan</b></a><br/>Under the guidance of <br /><a href="#"><i><b>Ripon Patgiri</b></i></a>
            </div>
		</div>
		<div class="col-md-1">
		</div>
    	</div>
    </body>
    <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="//sis.nits.ac.in/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="//sis.nits.ac.in/js/bootstrap.min.js" type="text/javascript"></script>
        
        <!-- AdminLTE App -->
        <script src="//sis.nits.ac.in/js/AdminLTE/app.js" type="text/javascript"></script>
	<!-- Google Analytics ;) Enabled for every user account. Users can know the number of profile visits. -->
			<script type="text/javascript">
    		     var _gaq = _gaq || [];
                      _gaq.push(['_setAccount', 'UA-58077290-1']);
                      _gaq.push(['_trackPageview']);
                      (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                      })();
                    </script>
    </html>
	<?php 
}
?>
