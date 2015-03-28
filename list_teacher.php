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
                        Teachers
                        <small>View all teachers</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Teachers</a></li>
                        <li class="active">View all teachers</li>
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
                                    <h3 class="box-title">List of all Teachers</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Privilege</th>
                                                <th>Department</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Approved</th>
                                                <th>Blocked</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php
													$i=0;
													$t = new Teacher();
													$teachers = $t->getAllTeachers();
													while($teacher = $teachers->fetch_object()){
														if(Session::exists('teacher_id') && Session::get('teacher_id')==$teacher->teacher_id){
															$i++;
														}
														else{
															$i++;
											?>
                                            <tr id="<?php echo "teacher_row_id".$i; ?>">
                                                <td><?php echo $teacher->name; ?></td>
                                                <td><?php echo strtoupper($teacher->privilege);  if($teacher->privilege=='dean'){echo ' ACADEMICS';} ?></td>
                                                <td><?php 
														$d = new Department();
														$di = $d->getInfo($teacher->dept_id);
														echo $d->getDepName();
													?>
												</td>
												<td><?php echo $teacher->email; ?></td>
												<td><?php echo $teacher->mobile; ?></td>
                                                <td><?php echo (($teacher->approved)?'Approved':'Not Approved'); ?></td>
                                                <td><?php echo (($teacher->blocked)?'Blocked':'-'); ?></td>
												<td><button class="btn btn-default" onClick="edit_teacher_feild(<?php echo $i . ',' . $teacher->teacher_id ; ?>);" >&nbsp;&nbsp; &nbsp;Edit&nbsp; &nbsp;&nbsp;</button>
													<button class="btn btn-danger" onClick="delete_teacher(<?php echo $i . ',' . $teacher->teacher_id.',\''.$teacher->privilege . '\''; ?>)"; >Remove</button>
												</td>
                                            </tr>
                                            <?php
                                            		}
                                            	}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Privilege</th>
                                                <th>Department</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Approved</th>
                                                <th>Blocked</th>
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
            
            function edit_teacher_feild($id,$t_id){
				if(confirm('Are you sure, you want to edit this teacher\'s details?')){
					$('#editModal').modal();
					$('#editArea').load('edit_teacher.php?id='+$id+'&tid='+$t_id);
				}
			}
			
			function save_edit_t(){
				$('#editModal').modal('hide');
				$('#content_area').load('ajax/load_teacher.php');
			}
	
			function delete_teacher($id,$t_id,$p){
				if(confirm('Are you sure, you want to remove this teacher?')){
					$('#update').load('ajax/delete_teacher.php?id='+$id+'&tid='+$t_id+'&p='+$p);
			
				}
				
			}
            
        </script>
