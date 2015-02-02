<?php
require_once 'core/init.php';
if(!loggedIn()){
	die();
	exit();
}
?>
				<section class="content-header">
                    <h1>
                        Courses
                        <small>Add new course</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Courses</a></li>
                        <li class="active">Add new course</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="col-md-6">
                	<div id="update">
						
					</div>
								<div class="box box-default">
	                                <div class="box-header">
	                                    <h3 class="box-title">Add New Course</h3>
	                                </div><!-- /.box-header -->
	                                <!-- form start -->
	                                <form role="form" id="add_new_course">
	                                    <div class="box-body">
	                                        <div class="form-group">
	                                            <label for="courseCode">Course Code</label>
	                                            <input type="text" class="form-control" id="courseCode" placeholder="Course Code" pattern="[A-Z0-9]{1,8}" required name="coursecode">
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="courseName">Course Name</label>
	                                            <input type="text" class="form-control" id="courseName" placeholder="Course Name" name="coursename">
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="courseDepartment">Select Department</label>
	                                            <select class="form-control" id="courseDepartment" name="department">
	                                            	<option value="" selected>Department</option>
														<?php
															$dep = new Department();
															$departments = $dep->getAllDepartment();
															while($department = $departments->fetch_object()){
														?>
															<option value="<?php echo $department->dept_id; ?>" ><?php echo $department->name; ?></option>
														<?php
															}
														?>
												</select>	
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="courseCredit">Course Credits</label>
	                                            <select class="form-control" id="courseCredit" name="credit">
	                                            	<option value="" selected>Credits</option>
	                                            	<option value="0">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
												</select>	
	                                        </div>
	                                        
	                                    </div><!-- /.box-body -->
	
	                                    <div class="box-footer">
	                                        <button type="submit" class="btn btn-primary" name='submit'>Submit</button>
	                                    </div>
	                                </form>
	                            </div>
	                     </div>
	                </section>

		<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- AJAX FORM -->
        <script type="text/javascript" src="js/jquery.form.js"></script>
		<script type="text/javascript" src="js/add_new_course.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>