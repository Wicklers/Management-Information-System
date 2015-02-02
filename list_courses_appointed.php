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
                        Course Allotment
                        <small>View all assigned courses</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Course allotment</a></li>
                        <li class="active">View all assigned courses</li>
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
                                    <h3 class="box-title">List of all Courses with respective Teacher</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Department</th>
                                                <th>Semester</th>
                                                <th>Appointed Teacher</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
	                                        	<?php
														$i=0;
														$c = new Course();
											            $courses = $c->getAllAppointed();
											            while(!empty($courses) && $course = $courses->fetch_object()){
											            	$i++;
												?>
                                            <tr id="<?php echo 'assigned_row_id'.$i; ?>">
                                                <td><?php echo $course->course_code; ?></td>
                                                <td>
													<?php
                                                    $cc = new Course();
                                                    $cc->getInfobyId($course->course_code);
                                                    echo $cc->getCourseName();
                                                    unset($cc);
                                                    
                                                     ?>
												</td>
                                                <td><?php 
														$d = new Department();
														$d->getInfo($course->course_dep);
														echo $d->getDepName();
														unset($d);
													?>
												</td>
												<td><?php echo $course->course_sem; ?></td>
												<td><?php 
														$t = new Teacher();
														$t->getInfo($course->teacher_id);
														echo $t->getName();
														unset($t);
													?>
												</td>
												<td><button class="btn btn-default" onClick="edit_assigned_feild(<?php echo $course->id . ',\'' . $course->course_code. '\',' . $course->course_dep. ',' . $course->course_sem ; ?>);" >&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
													<button class="btn btn-danger"  onClick="delete_assigned(<?php echo $course->id . ',\'' . $course->course_code. '\',' . $course->course_dep. ',' . $course->course_sem ; ?>);" >Remove</button>
												</td>
                                            </tr>
                                            <?php
                                            		}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Department</th>
                                                <th>Semester</th>
                                                <th>Appointed Teacher</th>
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
            
            function edit_assigned_feild($id,$course_code,$course_dep,$course_sem,$course_teacher){
				if(confirm('Are you sure, you want to edit this entry?')){
					$('#editModal').modal();
					$('#editArea').load('edit_assigned.php?id='+$id+'&cid='+$course_code+'&did='+$course_dep+'&cs='+$course_sem);
				}
			}
			
			function save_edit_a(){
				$('#editModal').modal('hide');
				$('#content_area').load('ajax/load_assigned.php');
			}
	
			function delete_assigned($id,$course_code,$course_dep,$course_sem,$course_teacher){
				if(confirm('Are you sure, you want to remove this entry?')){
					$('#update').load('ajax/remove_assigned.php?id='+$id+'&cid='+$course_code+'&did='+$course_dep+'&cs='+$course_sem);
			
				}
				
			}
            
        </script>
