<?php
require_once 'core/init.php';
if(!loggedIn() || privilege()==NULL){
	die();
}
?>
				<section class="content-header">
                    <h1>
                        Marks Entry System
                        <small>Generate result &amp; approval</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Marks Entry System</a></li>
                        <li class="active">Generate result &amp; approval</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                		<div class="row">
                			<div class="col-md-3">
                				<div class="box box-default">
                					<form role="form" id="generate_result">
                					<div class="box-header">
			                           <h3 class="box-title">Generate Result</h3>
			                  		</div> <!-- ./box-header -->
			                  		<div class="box-body">
			                  			<div class="form-group">
			                  				<label for="course">Choose your course</label>
			                  				<select class="form-control" id="course" name="course_id">
			                  					<option value="" >Select your Course</option>
																				<?php
																					$i=0;
																					$c = new Course();
																					$courses = $c->getAppointed(Session::get('teacher_id'));
																					$a = new Approval();
																					
																					
																					while(!empty($courses) && $course = $courses->fetch_object()) {
																						$matched=0;
													                                    $b = $a->underApproval();
																						while($key = $b->fetch_object()){
																							if($key->course_code==$course->course_code && $key->course_dep==$course->course_dep){
																								$matched=1;
																								break;
																							}
																						}
																						if(!$matched){
																				?>
																							<option  value="<?php echo $course -> course_code . ',' . $course -> course_dep; ?>">	<?php echo $course -> course_code.'-'; $ccn = new Course(); $ccn->getInfobyId($course->course_code); echo $ccn->getCourseName(); unset($ccn); ?> in <?php $d = new Department();
																					$d -> getInfo($course -> course_dep);
																					echo $d -> getDepName();
													 ?></option>
																							<br />
													
																				<?php }
														$i++;
														}
																				?>
			                  				</select>
			                  			</div>
			                  		</div><!-- ./box-body -->
			                  		<div class="box box-footer">
			                  			<button type="submit" class="btn btn-primary" name='submit'>Generate Result</button>
			                  		</div> <!-- ./box-footer -->
			                  		</form>
                				</div>
								
	                        </div>
	                        <div class="col-md-6">
	                          	<div class="box box-info">
	                          		<div class="box-header">
	                          			<h3 class="box-title">Approval status of your courses (generated results)</h3>
	                          		</div> <!-- ./box header -->
	                          		<div class="box-body table-responsive no-padding">
	                          			<?php
	                          					$a = new Approval();
												$b = $a->underApprovalOfTeacher(Session::get('teacher_id'));
												if(!$b->num_rows){
													?>
													<p class="box-info">You have not yet generated any of your course result. Or you may have generated but not approved it from your side.<p>
													<?php
												}else{
	                          			?>
	                          			<table class="table table-hover">
	                          				<tr>
	                          					<th>Course Code</th>
	                          					<th>Department</th>
												<th>Status</th>
												<th>Comments</th>	                          						
	                          				</tr>
	                          				<?php
													while($key = $b->fetch_object()){
											?>
											<tr>
												<td><?php echo $key -> course_code; ?></td>
												<td>
													<?php
														$d = new Department();
														$d -> getInfo($key -> course_dep);
														echo $d -> getDepName();
													?>
												</td>
												<td>
													<?php
														switch($key->status_level) {
															case 0 :
																echo "Approved by you for result.";
																break;
															case 1 :
																echo "Approved by 1 DUPC/DPPC member for result.";
																break;
															case 2 :
																echo "Approved by 2 DUPC/DPPC member for result.";
																break;
															case 3 :
																echo "Approved by 3 DUPC/DPPC member for result.";
																break;
															case 4 :
																echo "Approved by HOD for result.";
																break;
															case 5 :
																echo "Approved by DEAN for result.";
																break;
															case -1 :
																echo "Result Rejected";
																break;
														}
													?>
												</td>
												<td>
													<?php echo $key -> reject_msg; ?>
												</td>
											</tr>
											<?php
													}
												}
											?>
	                          			</table>
	                          		</div><!-- ./box body -->
	                          	</div>
	                        </div>
	                     <?php 
	                     	if(privilege()==='dupc' || privilege()==='dppc' || privilege()==='hod' || privilege()==='dean' || privilege()==='director'){?>   	
	                        <div class="col-md-3">
	                          	<div class="box box-warning">
	                          		<form id="view_result" role="form">
	                          		<div class="box-header">
	                          			<h3 class="box-title">Approve pending courses</h3>
	                          		</div><!-- ./box-header -->
	                          		<div class="box-body">
	                          			<div class="form-group">
	                          				<label for="course">Select course</label>
	                          				<select class="form-control" id="course" name="course_id">
	                          					<option value="" >Select Course</option>
																				<?php
																					$a = new Approval();
																					$b = $a->underApproval();
																					
																					while($key = $b->fetch_object()){
																						$course = $key->course_code;
																						$course_dep = $key->course_dep;
																				?>
																							<option  value="<?php echo $course . ',' . $course_dep; ?>">	<?php echo $course.'-'; $ccn = new Course(); $ccn->getInfobyId($course); echo $ccn->getCourseName(); unset($ccn); ?> in <?php $d = new Department();
																					$d -> getInfo($course_dep);
																					echo $d -> getDepName();
													 ?></option>
																							<br />
													
																				<?php
																				}
																				?>
	                          				</select>
	                          			</div>
	                          		</div><!-- ./box-body -->
	                          		<div class="box-footer">
	                          			<button type="submit" class="btn btn-success" name='submit'>Show Result</button>
	                          		</div>
	                          		</form>
	                          	</div>
	                        </div>
	                        <?php } ?>
	                    </div>
	                    <div class="row">
	                    	<div class="col-md-12" id="result">
	                    		
	                    	</div>
	                    </div>
	                       <!-- Update modal -->
							<div id="updateModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-sm">
							    <div class="modal-content">
							    	<div class="modal-header">
							        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							      	</div>
							      	<div class="modal-body">
							      		<h4 class="modal-title" id="update"></h4>
							      	</div>
							    </div>
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
       <script src="js/generate_result.js"></script>
	   <script src="js/view_result.js"></script>
       <script type="text/javascript">
       	function changeload(val) {
            if (val) {
                $('#settings').load('grade_set.php?id=' + val);
            } else {
                $('#settings').html('');
            }
        }
       </script>
