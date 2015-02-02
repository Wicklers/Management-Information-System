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
                        Students
                        <small>View all students</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Studets</a></li>
                        <li class="active">View all students</li>
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
                                    <h3 class="box-title">List of all Registered Students</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Scholar Number</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Sem</th>
                                                <th>Mobile</th>
                                                <th>Parent's<br/>Mobile</th>
                                                <th>Regular <br/> Courses</th>
                                                <th>Load <br/> Courses</th>
                                                <th>Total Credit Scored</th>
                                                <th>Total Credit Point</th>
                                                <th>Home<br/>Address</th>
                                                <th>Hostel<br/>Address</th>
                                                <th>Payment</th>
                                                <th>Approved</th>
                                                <th>Blocked</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php
													$i=0;
													$t = new Student();
													$students = $t->getAllStudents();
													if(!empty($students)){
													while($student = $students->fetch_object()){
														$i++;
														
											?>
                                            <tr id="<?php echo "student_row_id".$i; ?>">
                                                <td><?php echo $student->scholar_no; ?></td>
                                                <td><?php echo $student->name; ?></td>
                                                <td><?php 
														$d = new Department();
														$di = $d->getInfo($student->department);
														echo $d->getDepName();
														unset($d);
													?>
												</td>
												<td><?php echo $student->semester; ?></td>
												<td><?php echo $student->mobile; ?></td>
												<td><?php echo $student->parents_mobile; ?></td>
												<td><?php
														$courses=str_replace(',', '<br/>', $student->courses);
														echo $courses; 
												?></td>
												<td><?php
														$courses=str_replace(',', '<br/>', $student->courses_load);
														echo $courses; 
												?></td>
												<td><?php echo $student->total_score; ?></td>
												<td><?php echo $student->total_max_score; ?></td>
												<td><?php echo $student->home_address; ?></td>
												<td><?php echo $student->hostel_address; ?></td>
												<td><?php echo (($student->payment_verified)?'Completed':'Not Completed'); ?></td>
                                                <td><?php echo (($student->approved)?'Approved':'Not Approved'); ?></td>
                                                <td><?php echo (($student->blocked)?'Blocked':'-'); ?></td>
												<td><button class="btn btn-danger" onClick="edit_student_feild(<?php echo $i . ',\'' . $student->scholar_no . '\''; ?>);" >&nbsp;Edit&nbsp;</button>
												</td>
                                            </tr>
                                            <?php
                                            	}
                                            	}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Scholar Number</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Sem</th>
                                                <th>Mobile</th>
                                                <th>Parent's<br/>Mobile</th>
                                                <th>Regular <br/> Courses</th>
                                                <th>Load <br/> Courses</th>
                                                <th>Total Credit Scored</th>
                                                <th>Total Credit Point</th>
                                                <th>Home<br/>Address</th>
                                                <th>Hostel<br/>Address</th>
                                                <th>Payment</th>
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
            
            function edit_student_feild($id,$s_id){
				if(confirm('Are you sure, you want to edit this student\'s details?')){
					$('#editModal').modal();
					$('#editArea').load('edit_student.php?id='+$id+'&sid='+$s_id);
				}
			}
			
			function save_edit_s(){
				$('#editModal').modal('hide');
				$('#content_area').load('ajax/load_student.php');
			}
            
        </script>