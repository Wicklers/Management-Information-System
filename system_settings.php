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
                        System Settings
                        <small>All settings</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">System Settings</a></li>
                        <li class="active">All settings</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div id="update"></div>
                	<div class="row">
						<div class="col-md-5">
							<div class="box box-danger">
								<div class="box-header">
									<h3 class="box-title">Current Semester Details</h3>
									<div class="btn btn-success btn-lg pull-right" id="new_sem">
		                             	<i class="fa fa-refresh"></i> Start New Semester
		                             </div>
								</div> <!-- ./box-header -->
								<div class="box-body table-responsive" id="semester_details">
									<table class="table">
										<tr>
											<th>Session (year)</th>
											<td><?php echo Session::get('semester_session');?></td>
										</tr>
										<tr>
											<th>Type</th>
											<td><?php echo strtoupper(Session::get('semester_type'));?></td>
										</tr>
										<tr>
											<th>Starting Date</th>
											<td>
												<?php
												   $date = Session::get('semester_timestamp');
							                       $date = strtotime($date);
							                       $date = date('d/M/Y', $date);
							                       echo $date;
							                    ?>
											</td>
										</tr>
									</table>
								</div> <!-- ./box-body -->
								<div class="box-footer">
									It is an irreversible process. <br/>
									Starting new semester will reset course allotment and students registration details.<br/>
									Also, students will not be able to see their results.<br/>
									It is advisable to start new semester after 1-week of publishing result.
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box box-danger">
								<div class="box-header">
									<h3 class="box-title">Publish the Result</h3>
									<div class="btn btn-success btn-lg pull-right" id="publish_result">
		                             	<i class="fa fa-random"></i> Click Here
		                             </div>
								</div> <!-- ./box-header -->
								<div class="box-body">
									Click on the green button to publish the result.<br/>
									SPI (Student Performance Index) and CPI (Cummulative Performance Index) will be calculated henceforth. Please do not refresh or close the browser before getting any response.<br/>
									All students will be able to see his/her result in SIS.<br/>
									<b>Condition : All course's result must be approved prior to publishing otherwise result will not be published.</b>
									
								</div> <!-- ./box-body -->
							</div>
						</div>
						<div class="col-md-3">
							<div id="reg_update"></div>
							<?php 
								$s = new Semester();
								if(!$s->isRegistration()){
								
							?>
							<div class="box box-success">
								<div class="box-header">
									<h3 class="box-title">Online Registration</h3>
									<div class="btn btn-success btn-lg pull-right" id="start_registration">
		                             	<i class="fa fa-play"></i> Start
		                             </div>
								</div> <!-- ./box-header -->
								<div class="box-body">
									Click on Start button to start online student's registration.<br/>
									<?php 
										$s = new Student();
										$r = $s->getAllStudents();
										if(!empty($r)){
											echo "<b>".$r->num_rows."</b> Earlier Registered Students.";
										}else{
											echo "No Earlier Registered Students.";
										}
									?>									
								</div> <!-- ./box-body -->
							</div>
							<?php 
								}
								else if($s->isRegistration()){
									unset($s);
							?>
								<div class="box box-danger">
								<div class="box-header">
									<h3 class="box-title">Online Registration</h3>
									<div class="btn btn-danger btn-lg pull-right" id="stop_registration">
		                             	<i class="fa fa-stop"></i> Stop
		                             </div>
								</div> <!-- ./box-header -->
								<div class="box-body">
									Click on Stop button to stop online student's registration.	<br/>
									<?php 
										$s = new Student();
										$r = $s->getAllStudents();
										if(!empty($r)){
											echo "<b>".$r->num_rows."</b> Students Registered.";
										}else{
											echo "No Students Registered yet.";
										}
									?>								
								</div> <!-- ./box-body -->
							</div>
							<?php
								}
							?>
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
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!--Page Script -->
        <script type="text/javascript">
        	$(document).ready(function() {

		        $('#new_sem').click(function() {
		        	if(confirm('Are you sure, you want to start new semester? It is an irreversible process. Starting new semester will reset course allotment and students registration details.')){
		        		var check = prompt("Please type the following text: \nI am changing semester");
						if(check=="I am changing semester"){
							$("#semester_details").load("ajax/new_session.php");
						}
					}
		            
		        });

		        $('#start_registration').click(function(){
		        	if(confirm('Are you sure, you want to start registration process?')){
		        		$("#reg_update").load("ajax/registration_action.php?a=1");
					}
			        });
		        $('#stop_registration').click(function(){
		        	if(confirm('Are you sure, you want to stop registration process?')){
		        		$("#reg_update").load("ajax/registration_action.php?a=2");
					}
			        });
		 });	
        </script>