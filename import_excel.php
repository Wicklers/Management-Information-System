<?php
require_once 'core/init.php';
include 'header.php';
if(!loggedIn()){
	Redirect::to('index.php');
}

if((loggedIn() && !Session::exists('teacher_id')) || privilege()==NULL){
	Session::destroy();
	Redirect::to('includes/errors/unauthorized.php');
}?>
<div id="update"></div>
<form id="import" method="post" action="import_excel.php">
<div class="box box-default">
	<div class="box-header">
		<h3 class="box-title">Import CSV/Excel file</h3>
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
													<option value="ct3">Internal Asessment</option>
													<option value="midsem">Mid-Semester</option>
													<option value="endsem">End-Semester</option>
												</select>
											</div>
											<div class="form-group">
							      				<label for="category">Choose between Regular Course or Load Course</label>
							      				<select name="category" class="form-control">
													<option value="regular">Regular Course</option>
													<option value="load">Load Course</option>
												</select>
											</div>
											<div class="form-group">
				                                <div class="btn btn-success btn-file">
				                                    <i class="fa fa-paperclip"></i> Select File
				                                    <input type="file" name="file">
				                                </div>
				                                <p class="help-block">Max. 4MB</p>
				                            </div>
	</div>
	<div class="box-footer">
		<button type="submit" class="btn btn-primary" name='submit'>Import</button>
	</div>
</div>
</form>

							<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- AJAX FORM -->
        <script type="text/javascript" src="js/jquery.form.js"></script>
		<script type="text/javascript" src="js/marks_form.js"></script>
		<script src="js/import_excel.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
