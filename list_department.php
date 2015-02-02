<?php
if(!loggedIn()){
	die();
	exit();
}
?>	             
	             
	             
	             <!-- Content Header (Page header) -->
	             <!-- DATA TABLES -->
        		<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
                <section class="content-header">
                    <h1>
                        Departments
                        <small>View all departments</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Departments</a></li>
                        <li class="active">View all departments</li>
                    </ol>
                </section>

                <!-- Main content -->
                
                <section class="content">
                	<div id="update">
                	
                	</div>
                    <div class="row" id="content_area">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">List of all Departments</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Department ID</th>
                                                <th>Name</th>
                                                <th>No. of Course(s)</th>
                                                <th>No. of Teacher(s)</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
												$i=0;
												$dep = new Department();
												$departments = $dep->getAllDepartment();
												while($department = $departments->fetch_object()){
												$i++;	
											?>
                                            <tr id="<?php echo "department_row_id".$i; ?>">
                                                <td><?php echo $department->dept_id; ?></td>
                                                <td><?php echo $department->name; ?></td>
                                                <td><?php 
														$cors = new Course();
														$courses = $cors->getInfobyDept($department->dept_id);
														echo $courses->num_rows;
													?>
												</td>
                                                <td><?php
														$t = new Teacher();
														$teachers = $t->getInfobyDept($department->dept_id);
														echo $teachers->num_rows;
													?>
												</td>
												<td><button class="btn btn-default" onClick="edit_department_feild(<?php echo $i . ',' . $department->dept_id ; ?>);" > &nbsp; Edit &nbsp; </button>&nbsp;
													<button class="btn btn-danger" onClick="delete_department(<?php echo $i . ',' . $department->dept_id ; ?>)"; >Delete</button>
												</td>
                                            </tr>
                                            <?php
                                            	}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Department ID</th>
                                                <th>Name</th>
                                                <th>No. of Course(s)</th>
                                                <th>No. of Teacher(s)</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
		<!-- Edit modal -->
		<div id="editModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		    	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        	<h4 class="modal-title" id="editArea">Update here</h4>
		      	</div>
		    </div>
		  </div>
		</div>
		<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!--Page Script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
            
            function edit_department_feild($id,$dep_id){
				if(confirm('Are you sure, you want to edit this department\'s details?')){
					$('#editModal').modal();
					$('#editArea').load('edit_department.php?id='+$id+'&did='+$dep_id);
				}
			}
			
			function save_edit_dep(){
				$('#editModal').modal('hide');
				$('#content_area').load('ajax/load_department.php');
			}
	
			function delete_department($id,$dep_id){
				if(confirm('Are you sure, you want to edit this department\'s details?')){
					$('#update').load('ajax/delete_department.php?id='+$id+'&did='+$dep_id);
			
				}
				
			}
            
        </script>