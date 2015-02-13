<?php
require_once 'core/init.php';
if(!loggedIn() || privilege()==NULL || privilege()=='admin'){
	die();
}
?>
				<section class="content-header">
                    <h1>
                        Attendance System
                        <small>Import attendance</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Attendance System</a></li>
                        <li class="active">Import attendance</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="row">
                		<div class="col-md-6">
							                			
							<div id="update"></div>
							<form id="attendance">
							<div class="box box-info">
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
											                    <option  value="<?php echo $course -> course_code . ',' . $course -> course_dep; ?>">   <?php echo $course -> course_code.'-'; $ccn = new Course(); $ccn->getInfobyId($course->course_code); echo $ccn->getCourseName(); unset($ccn); ?> in <?php $d = new Department();
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
                		</div>
                		<div class="col-md-6">
                			&nbsp;
                		</div>
                	</div>
                </section>
                <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- AJAX FORM -->
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
       <!-- Page Script -->
       <script src="js/import_attendance.js"></script>
       
