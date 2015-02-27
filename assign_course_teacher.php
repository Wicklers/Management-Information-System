<?php
require_once 'core/init.php';
if(!loggedIn()){
	die();
	exit();
}
else if(loggedIn() && (privilege()==='teacher' || privilege()==='dppc' || privilege()==='dupc' || privilege()==NULL)){
        Session::destroy();
        Redirect::to('includes/errors/unauthorized.php');
}
?>
				<section class="content-header">
                    <h1>
                        Course Allotment
                        <small>Assign a course to a teacher</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Course allotment</a></li>
                        <li class="active">Assign a course to a teacher</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="col-md-6">
                	<div id="update">
						
					</div>
								<div class="box box-default">
	                                <div class="box-header">
	                                    <h3 class="box-title">Appoint Course</h3>
	                                </div><!-- /.box-header -->
	                                <!-- form start -->
	                                <form role="form" id="assign_course_teacher">
	                                    <div class="box-body">
	                                        <div class="form-group">
	                                            <label for="asCode">Select Course</label>
	                                            <select class="form-control" id="asCourse" name="coursecode">
	                                            	<option value="" selected>Course</option>
													<?php
														$cc = new Course();
														$courses = $cc->getAllCourses();
														while($course = $courses->fetch_object()){
													?>
														<option value="<?php echo $course->course_id; ?>" ><?php echo $course->course_id.'-'.$course->course_name; ?></option>
													<?php
														}
													?>
												</select>
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="asTeacher">Select Teacher</label>
	                                            <select class="form-control" id="asCourse" name="teacher">
	                                            	<option value="" selected>Teacher</option>
													<?php
														$t = new Teacher();
														$teachers = $t->getAllTeachers();
														while($teacher = $teachers->fetch_object()){
													?>
														<option value="<?php echo $teacher->teacher_id; ?>" ><?php echo $teacher->name; ?></option>
													<?php
														}
													?>
												</select>
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="asDepartment">Select Department to teach</label>
	                                            <select class="form-control" id="asDepartment" name="department">
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
	                                            <label for="asSemester">Semester</label>
	                                            <select class="form-control" id="asSemester" name="semester">
	                                            	<option value="" selected>Semester</option>
						                            <?php
						                                $i=1;
						                                while($i<=8){
						                            ?>
						                                <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
						                            <?php
						                                $i++;
						                                }
						                            ?>
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
		<script type="text/javascript" src="js/assign_course_teacher.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
