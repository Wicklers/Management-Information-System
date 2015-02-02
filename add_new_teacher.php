<?php
require_once 'core/init.php';
if(!loggedIn()){
	die();
	exit();
}
?>
				<section class="content-header">
                    <h1>
                        Teachers
                        <small>Add new teacher</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Teachers</a></li>
                        <li class="active">Add new teacher</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="col-md-6">
                	
                	<div id="update">
						
					</div>
								<div class="box box-default">
	                                <div class="box-header">
	                                    <h3 class="box-title">Add New Teacher</h3>
	                                </div><!-- /.box-header -->
	                                <!-- form start -->
	                                <form role="form" id="add_new_teacher">
	                                    <div class="box-body">
	                                        <div class="form-group">
	                                            <label for="teacherName">Name of Teacher</label>
	                                            <input type="text" class="form-control" id="teacherName" placeholder="Name of teacher" name="name">
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="teacherEmail">Email</label>
	                                            <input type="text" class="form-control" id="teacherEmail" placeholder="email@nits.ac.in" name="email">
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="teacherPrivilege">Privilege</label>
	                                            <select class="form-control" id="teacherPrivilege" name="privilege">
	                                            	<option value="" selected>Privilege</option>
													<option value="director">Director</option>
													<option value="dean">Dean</option>
													<option value="hod">HOD</option>
													<option value="dupc">DUPC</option>
													<option value="dppc">DPPC</option>
													<option value="teacher">Teacher</option>
												</select>	
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="teacherDepartment">Department</label>
	                                            <select class="form-control" id="teacherDepartment" name="department">
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
	                                            <label for="teacherMobile">Mobile</label>
	                                            <input type="text" class="form-control" id="teacherMobile" placeholder="Mobile Number without +91 or 0" name="mobile" maxlength="10">
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
		<script type="text/javascript" src="js/add_new_teacher.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>