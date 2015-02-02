<?php
require_once 'core/init.php';
if(!loggedIn()){
	die();
	exit();
}
?>
<!-- Date Picker -->
<link href="css/datepicker/datepicker3.css" type="text/css"  rel="stylesheet"/>
				<section class="content-header">
                    <h1>
                        Marks Entry System
                        <small>Last dates of marks submission</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Marks Entry System</a></li>
                        <li class="active">Last dates</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="col-md-6">
                	<div id="update">
						
					</div>
								<div class="box box-default">
	                                <div class="box-header">
	                                    <h3 class="box-title">Last Dates</h3>
	                                </div><!-- /.box-header -->
	                                <!-- form start -->
	                                <form role="form" id="last_date_form">
	                                    <div class="box-body">
	                                        <div class="form-group">
	                                            <label for="examtype">Choose Exam Type</label>
	                                            <select class="form-control" id="examtype" name="examtype" onChange="choose_date(this.value);">
	                                            	<option value="">Choose Type</option>
													<option value="ct1">Class Test-1</option>
													<option value="ct2">Class Test-2</option>
													<option value="ct3">Internal Assessment</option>
													<option value="midsem">Mid-Semester</option>
													<option value="endsem">End-Semester</option>
												</select>
	                                        </div>
	                                        <div class="form-group">
	                                            <label for="lastdate">Last Date for Marks Submission :</label>
			                                    <div class="input-group">
				                                            <div class="input-group-addon">
				                                                <i class="fa fa-calendar"></i>
				                                            </div>
				                                     <div id="last_date">
		                                            <input placeholder="mm/dd/yyyy" type="text" class="form-control" data-provide="datepicker" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" name="lastdate" id="lastdate">
		                                            </div>
		                                        </div>	
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
		<script type="text/javascript" src="js/last_date_ajax.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- Page Script -->
     	<script type="text/javascript">
	        function choose_date($exam_type){
				$('#last_date').load('ajax/get_last_date.php?examtype='+$exam_type);
			}
			$('#lastdate').datepicker({
				format:"mm/dd/yyyy"
			});
		</script>