<?php
require_once 'core/init.php';
if(!loggedIn() || privilege()==NULL){
	die();
}
?>
				<section class="content-header">
                    <h1>
                        Marks Entry System
                        <small>Marks entry &amp; settings</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Marks Entry System</a></li>
                        <li class="active">Marks entry &amp; settings</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                		<div class="row">
                			
							<div class="col-md-5">
								
								<div class="row">
									<div class="col-md-12">
										<div class="box box-default">
			                                <div class="box-header">
			                                    <h3 class="box-title">Marks Entry</h3>
			                                  	<div class="btn btn-primary btn-file pull-right" onClick="exporting();">
		                                    		<i class="fa fa-save"></i> Export CSV
		                                		</div>
			                                  	<div class="btn btn-success btn-file pull-right" onClick="importing();">
		                                    		<i class="fa fa-paperclip"></i> Import CSV
		                                		</div>
			                                </div><!-- /.box-header -->
			                                <!-- form start -->
			                                <form role="form" id="marks_enter">
			                                    <div class="box-body">
			                                        <div class="form-group">
			                                            <label for="course">Select course with respective department</label>
			                                            <select class="form-control" id="course" name="course_id" onchange="changeload(this.value);">
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
																							<option  value="<?php echo $course -> course_code . ',' . $course -> course_dep; ?>">	<?php echo $course -> course_code; ?> in <?php $d = new Department();
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
			                                        <div class="form-group">
			                                            <label for="examtype">Choose exam type:</label>
			                                            <select class="form-control" id="examtype" name="examtype">
			                                            	<option value="">Choose Type</option>
															<option value="ct1">Class Test-1</option>
															<option value="ct2">Class Test-2</option>
															<option value="ct3">Internal Assessment</option>
															<option value="midsem">Mid-Semester</option>
															<option value="endsem">End-Semester</option>
														</select>	
			                                        </div>
			                                        
			                                    </div><!-- /.box-body -->
			
			                                    <div class="box-footer">
			                                        <button type="submit" class="btn btn-primary" name='submit'>Go!!</button>
			                                    </div>
			                                </form>
			                            </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12" id="settings">
									</div>
								</div>
								
	                          </div>
	                          <div class="col-md-7" id="form_data">
	                          	
	                          </div>
	                       </div>
	                       <!-- update modal -->
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
		<script type="text/javascript" src="js/marks_form.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
       <!-- Page Script -->
       <script type="text/javascript">
       	function changeload(val) {
            if (val) {
                $('#settings').load('grade_set.php?id=' + val+'');
            } else {
                $('#settings').html('');
            }
        }
        function exporting() {
            window.open('export_excel.php', "popupWindow", "width=800,height=600,scrollbars=no");
        }

        function importing() {
            window.open("import_excel.php", "popupWindow", "width=800,height=600,scrollbars=no");
        }
       </script>