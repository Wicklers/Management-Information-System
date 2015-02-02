<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('logout.php');
}
else if(loggedIn() && (privilege()==='teacher' || privilege()==='dppc' || privilege()==='dupc' || privilege()==NULL)){
	Session::destroy();
	Redirect::to('includes/errors/unauthorized.php');
}
?>
				<section class="content-header">
                    <h1>
                        Departments
                        <small>Create new department</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Departments</a></li>
                        <li class="active">Create new department</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="col-md-6">
                	<div id="update">
						
					</div>
								<div class="box box-default">
	                                <div class="box-header">
	                                    <h3 class="box-title">Add New Department</h3>
	                                </div><!-- /.box-header -->
	                                <!-- form start -->
	                                <form role="form" id="add_new_department">
	                                    <div class="box-body">
	                                        <div class="form-group">
	                                            <label for="depName">Department Name</label>
	                                            <input type="text" class="form-control" id="depName" placeholder="Name of department" name="name">
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="depID">Department ID</label>
	                                            <input type="text" class="form-control" id="depID" placeholder="Department ID" name="id">
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
		<script type="text/javascript" src="js/add_new_department.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>