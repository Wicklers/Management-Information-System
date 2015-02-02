<?php
require_once 'core/init.php';
if (!Session::exists('teacher_email') && !loggedIn()) {
    Redirect::to('index.php');
}
if (Input::exists('post')) {
    $validate = new Validate();
    $validation = $validate -> check($_POST, array('mobile' => array('required' => true, 'min' => 10, 'max' => 10)));

    if ($validate -> passed()) {
        $dep = new Teacher();

        $add = $dep -> add(Session::get('displayname'), Session::get('teacher_email'), 'teacher', Input::get('department'), Input::get('mobile'), '0');
        if ($add == 1) {
            Session::destroy();
            Redirect::to('includes/errors/not_approved.php');
            $log = new Log();
            $log -> actionLog('Added Teacher');
        } else if ($add == 0) {
            echo 'Temporary Error, while creating saving information.';
        }
    }
}
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/framed.css">
<link rel="icon" href="images/nits2.jpg">
<link rel="shortcut icon" href="images/nits2.jpg" />
<title>Fill Your Info | MIS</title>
</head>

<body>
	<?php
    include 'header.php';
	?>
	<div class="allcontent">
	<div class="workarea">
		<br/><br/><br/>
		<link rel="stylesheet" type="text/css" href="css/result.css">
		<div class="tableh">Your Credentials</div>
		<div class="res">
		<div id="update">
		<?php
        if (Input::exists()) {
            foreach ($validate->errors() as $errors) {
                switch($errors) {
                    case 'mobile is required' :
                        echo '<li>Mobile no. is required.</li>';
                        break;
                    case 'mobile must be minimum of 10 characters.' :
                        echo '<li>Please enter valid mobile number.</li>';
                        break;
                    case 'mobile must be maximum of 10 characters.' :
                        echo '<li>Please enter valid mobile number.</li>';
                        break;
                    default :
                        echo '<li>' . $errors . '</li>';
                        break;
                }
            }
        }
		?>
		</div>
		<table>
			<form method="post" id="signup_teacher" action="signup_teacher.php">
			<tr>
				<td class="sel">
					Your Name
				</td>
				<td>
					<input type="text" name="name" placeholder="Name" class="box" value="<?php echo Session::get('displayname'); ?>" disabled/>
				</td>
			</tr>
			<tr>
				<td class="sel">
					Email-id
				</td>
				<td>
					<input type="email" placeholder="Email-id" class="box" value="<?php echo Session::get('teacher_email'); ?>" disabled/> 
				</td>
			</tr>
			<tr>
				<td class="sel">
					Privilege
				</td>
				<td>
					<select class="box" disabled>
						<option value="teacher">Teacher</option>
					</select>
				</td>
				</tr>
				
				<tr>
					<td class="sel">
						Select Department
					</td>
					<td>
						<select name="department" class="box">
							<option value="" selected>Department</option>
							<?php
								$dep = new Department();
								$departments = $dep->getAllDepartment();
								while($department = $departments->fetch_object()){
							?>
							<option value="<?php echo $department -> dept_id; ?>" ><?php echo $department -> name; ?></option>
							<?php
                            }
							?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td class="sel">
						Mobile Number
					</td>
					<td>
						<input type="text" name="mobile" placeholder="Mobile Number" class="box" maxlength="10" required />
					</td>
				</tr>
						
				<tr>
					<td colspan="2">
						<input type="submit" class="button" name="submitt" value="Save" /><a href="logout.php"><input type="button" value="Cancel" class="button" /></a><br/>
					</td>
				</tr>
			</form>
		</table>
		</div>
	</div>
</body>
</html>