<?php
require_once 'core/init.php';
if (loggedIn()) {
    Redirect::to('home.php');
	exit();
}
if (Input::exists()) {	
    if (Input::get('login') != '') {
        $validate = new Validate();
        $validation = $validate -> check($_POST, array('a' => array('required' => true), 'b' => array('required' => true), 'g-recaptcha-response' => array('required' => true)));
        if ($validate -> passed()) {
            $captcha_check = new Recaptcha();
            $ver = $captcha_check->verifyResponse();
            if ($ver->success) { //verify captcha
                if (validateEmail(Input::get('a'))) {
                    $ldap = new LDAP();
                    if ($ldap -> Auth(Input::get('a'), Input::get('b')) && Token::check(Input::get('token'))) {// verify using LDAP and check token!!
                        if (Session::get('type') === 'faculty') {//check who logged in, differentiating between student and faculty members' login!
                            //case for teacher's or other staff's login
                            $teacher = new Teacher();
                            $v = $teacher -> validateLogin(Input::get('a'));
                            if ($v == 1) {
                                $otp = new OTP();
                                if ($otp->send($teacher->getMobile())) {//$otp->send($teacher->getMobile()) //Send OTP
                                    Session::put('OTP Sending', 'OTP Sent, Verify Here');

                                }
                            } else if ($v == 0) {
                                //Teacher is logging in for the first time, He/she was not added before by another teacher.
                                //Show him his form to fill up his details
                                Session::put('loggedIn', 1);
                                Session::put('teacher_email', Input::get('a'));
                                Redirect::to('signup_teacher.php');
                            } else if ($v == 3) {
                                $validate -> addError('This account is currently blocked because of multiple failed login attempts');
                            } else if ($v == 2) {
                                $validate -> addError('Please ask for approval from any authority.');
                            }
                        } else if (Session::get('type') === 'student') {
                            // case for students' login!!
                            Session::destroy();
                            $validate -> addError("Please <a href='http://sis.nits.ac.in'>CLICK HERE</a> for students login area.");
                        }
                    } else {
			Session::destroy();
                        // Not valid login
                        $validate -> addError('Wrong Username or Password');
                    }
                } else {
                    $admin = new Admin();
                    if ($admin -> loginAdmin(Input::get('a'), Input::get('b'))) {
                        $otp = new OTP();
                        if ($otp->send($admin->getMobile())) {//$otp->send($admin->getMobile()) //Send OTP
                            Session::put('OTP Sending', 'OTP Sent, Verify Here');
                        }
                    } else {
                        // Not Valid Login!!!
                        $validate -> addError('Wrong Username or Password');
                    }
                }
            } else {
                $validate -> addError('Wrong Captcha');
            }
        }

    }
    if (Input::get('otpsubmit') != '') {
        $otp_validate = new Validate();
        $otp_validation = $otp_validate -> check($_POST, array('OTP' => array('required' => true, 'min' => 8, 'max' => 8)));
        if ($otp_validate -> passed() && Token::check(Input::get('token'))) {
            $otp = new OTP();
            if ($otp->verifyOTP(Input::get('OTP'))) {//$otp->verifyOTP(Input::get('OTP'))
                Session::deleteloginAttempt('OTP');
                Session::put('loggedIn', 1);
                $log = new Log();
                $log -> loginLog('success');
                Redirect::to('home.php');
            } else {
                $log = new Log();
                $log -> loginLog('wrong OTP');
                Session::put('OTP Sending', 'Incorrect, Enter Again');
                Session::loginAttempt('OTP');
                if (Session::loginAttempts('OTP') == 3) {
                    // blocking the user for further login!!
                    // check whether ADMIN or any other Email-based user was trying to login
                    if (Session::exists('teacher_id')) {
                        $teacher = new Teacher();
                        if ($teacher -> block(Session::get('teacher_id'))) {
                            Session::destroy();
                            Redirect::to('includes/errors/blocked.php');
                        }
                    } else if (Session::exists('admin_id')) {
                        $admin = new Admin();
                        if ($admin -> block(Session::get('admin_id'))) {
                            Session::destroy();
                            Redirect::to('include/errors/blocked.php');
                        }
                    }
                }
            }
        }else{
        	Session::put('OTP Sending','');
        }
    }
}
/*
 *
 * MAIN FILE GOES BELOW
 *
 *
 */
/* ****************************************************************************************************************************************************** */
/* ****************************************************************************************************************************************************** */
?>

<!DOCTYPE html>
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
	<link rel="icon" href="images/nits.png">
	<link rel="shortcut icon" href="images/nits.png" />
    <title>MIS | NIT Silchar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
    <!--Login CSS -->
    <link href="css/login.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    <!--  Google Recaptcha api -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <!--Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Balthazar&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <!--Font Awesome-->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <div class="mis login-form">
        <div class="col-sm-6 col-md-5 col-lg-4 col-sm-offset-6 text-center login-popup-wrap">
        	<?php
        		if(isset($validate)){
                     foreach ($validate->errors() as $errors) {
                          switch($errors) {
                             case 'a is required' :
								echo '<div class="alert alert-warning alert-dismissible" role="alert">';
								echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                                echo 'Please enter your email';
								echo '</div>';
                             break;
                             case 'b is required' :
                                echo '<div class="alert alert-warning alert-dismissible" role="alert">';
								echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                                echo 'Password field cannot be left blank';
								echo '</div>';
                             break;
                             case 'g-recaptcha-response is required' :
                                echo '<div class="alert alert-warning alert-dismissible" role="alert">';
								echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                                echo 'Please verify you\'re not a robot';
								echo '</div>';
                             break;
                             default :
                             	echo '<div class="alert alert-danger alert-dismissible" role="alert">';
								echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                                echo $errors;
								echo '</div>';
                             break;
                           }
                       }
					unset($validate);
				}
			if (isset($otp_validate)) {
                foreach ($otp_validate->errors() as $errors) {
             	    echo '<div class="alert alert-warning alert-dismissible" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                    echo $errors;
					echo '</div>';
				}
				unset($otp_validate);
             }
			if(Session::exists('OTP Sending') && Session::get('OTP Sending')!='Incorrect, Enter Again' && Session::get('OTP Sending')!=''){
				echo '<div class="alert alert-success alert-dismissible" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                echo Session::get('OTP Sending');
				echo '</div>';
			}
			if(Session::exists('OTP Sending') && Session::get('OTP Sending')=='Incorrect, Enter Again'){
				echo '<div class="alert alert-danger alert-dismissible" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                echo Session::get('OTP Sending');
				echo '</div>';
			}
			if(!Session::exists('OTP Sending') && !Session::exists('OTPCode')){
				
			?>
            <div class="login-popup">
            	<div id="logo"> </div>
                <h1 class="title"><strong>Management Information System</strong></h1>
                <form role="form" method="post" action="login.php">
                    <div class="form-group input-group">
						<span rel="tooltip" data-original-title="Institute Email. e.g., ripon@cse.nits.ac.in" class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input rel="tooltip" data-original-title="Institute Email. e.g., ripon@cse.nits.ac.in" type="text" class="form-control text-center text" id="" placeholder="Institute Email" value="<?php echo Input::get('a'); ?>" name="a">
                    </div>
                    <div class="form-group input-group">
						<span rel="tooltip" data-original-title="Password" class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                        <input rel="tooltip" data-original-title="Password" type="password" class="form-control text-center text" id="" placeholder="Password" name="b">
                    </div>
                    <div class="form-group input-group" >
						<span class="input-group-addon" rel="tooltip" data-original-title="Captcha"><i class="glyphicon glyphicon-qrcode"></i></span>
                        <div class="g-recaptcha" data-sitekey="6LeWw_4SAAAAAIvtg-Z91hPaXAv85HCmM232V8q6"></div>
                    </div>
                    <div class="form-group">
                    	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
						<a href="forget.php">Forget Password?</a>
                        <input type="submit" class="btn btn-default submit" value="Sign In" name="login">
                    </div>
                </form>
            </div>
            <?php
            	}
				else if(Session::exists('OTP Sending') || Session::exists('OTPCode')){
					Session::delete('OTP Sending');
			?>
            <div class="login-popup">
                <h1 class="title"><strong>One Time Password</strong></h1>
                <form role="form" method="post" action="login.php">
                    <div class="form-group input-group">
						<span rel="tooltip" data-original-title="One Time Password" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input autofocus rel="tooltip" data-original-title="Enter OTP which is sent to your mobile phone" type="text" class="form-control text-center text" name="OTP" placeholder="OTP(One Time Password)" class="rect" maxlength="8" autocomplete="off" />
                    </div>
                    <div class="form-group">
                    	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <input type="submit" class="btn btn-default submit" value="Verify" name="otpsubmit"><br/><br/>
                        <a href="logout.php"><input type="button" class="btn btn-danger cancel" value="Cancel"></a>
                    </div>
                </form>
            </div>
            <?php
				}
			?>
            
            <div class="footer">
           		<b>&copy; 2015</b> <a target="_blank" href="http://www.nits.ac.in">National Institute of Technology, Silchar</a><br/>Proudly developed by <a href="#"><i>Computer Science & Engineering</i></a>
				<br/><a target="_blank" href="http://www.harshladha.com"> <b>Harsh Vardhan Ladha</a> &amp; <a target="_blank" href="https://in.linkedin.com/in/yogeshchauhan1">Yogesh Chauhan</b></a><br/>Under the guidance of <a href="#"><i><b>Ripon Patgiri</b></i></a>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script>
    	$('[rel=tooltip]').tooltip();
    </script>

	            <script type="text/javascript">
    		     var _gaq = _gaq || [];
                      _gaq.push(['_setAccount', 'UA-58094042-1']);
                      _gaq.push(['_trackPageview']);
                      (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                      })();
                    </script>
</body>
</html>
