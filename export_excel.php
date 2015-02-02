<?php
require_once 'core/init.php';
include 'header.php';
if(!loggedIn()){
	Redirect::to('index.php');
}
else if(loggedIn() && !Session::exists('teacher_id')){
	Session::destroy();
	Redirect::to('includes/errors/unauthorized.php');
}

if(Input::exists()){
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'course_id' => array(
			'required' => true
		),
		'examtype' => array(
			'required' => true
		),
		'category' => array(
			'required' => true
		)
	));
	
	if($validate->passed()){
		
		$input = Input::get('course_id');
		$input = explode(',', Input::get('course_id'));
		$m = new Marks();
		if($m->exportCSV($input[0], $input[1], Input::get('examtype'), Input::get('category'))){
			echo '<div class="alert alert-success alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    		echo '<strong>Export successful</strong>';
			echo '</div>';
		}
		else{
			echo '<div class="alert alert-danger alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
    		echo 'Temporary Error!';
			echo '</div>';
		}
	}
	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		foreach($validate->errors() as $errors){
			switch($errors){
				case 'course_id is required':
					echo 'Please select your course<br/>';
				break;
				
				case 'examtype is required':
					echo 'Please select exam type<br/>';
				break;
				case 'category is required':
					echo 'Please choose between regular course or load course<br/>';
					break;
				default:
					echo $errors;
				break;
			}
		}
		echo '</div>';
	}
}

?>
<form role="form" action="export_excel.php" method="post">
							  <div class="box box-default">
							    	<div class="box-header">
							        	<h3 class="box-title">Export CSV/Excel file</h3>
							      	</div>
							      	<div class="box-body">
							      		<div class="form-group">
							      				<label for="course">Select course with respective department</label>
							      				<select name="course_id" class="form-control">
													<option value="" >Select your Course</option>
													<?php
													                                $i=0;
													                                $c = new Course();
													                                $courses = $c->getAppointed(Session::get('teacher_id'));
													                                while(!empty($courses) && $course = $courses->fetch_object()){
													                                
													                            ?>
													                    <option  value="<?php echo $course -> course_code . ',' . $course -> course_dep; ?>">   <?php echo $course -> course_code; ?> in <?php $d = new Department();
													                                $d -> getInfo($course -> course_dep);
													                                echo $d -> getDepName();
													 ?></option>
													                    <br />
													
													                            <?php
													                            }
													                            ?>
												</select>
							      			</div>
							      			<div class="form-group">
							      				<label for="examtype">Choose exam type</label>
							      				<select name="examtype" class="form-control">
													<option value="">Choose Type</option>
													<option value="ct1">Class Test-1</option>
													<option value="ct2">Class Test-2</option>
													<option value="ct3">Class Test-3</option>
													<option value="midsem">Mid-Semester</option>
													<option value="endsem">End-Semester</option>
													<option value="all">All</option>
												</select>
							      			</div>
							      			<div class="form-group">
							      				<label for="category">Choose between Regular Course or Load Course</label>
							      				<select name="category" class="form-control">
													<option value="regular">Regular Course</option>
													<option value="load">Load Course</option>
												</select>
											</div>
							      			
							      	</div>
							      	<div class="box-footer">
							      		<button type="submit" class="btn btn-primary" name='submit'>Export</button>
		    						</div>
							</div>
							</form>
							<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- AJAX FORM -->
        <script type="text/javascript" src="js/jquery.form.js"></script>
		<script type="text/javascript" src="js/marks_form.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
							
