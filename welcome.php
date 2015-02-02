<?php
if(!loggedIn()){
	die();
}
?>
<section class="content-header">
                    <h1>
                        Home
                        <small>Your Profile Settings</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    </ol>
</section>

<!-- Main content -->

<section class="content">
						<div id="update"></div>
                		<div class="row">
                			<div class="col-md-4">
                				<div class="box box-default">
                					<form role="form" id="change_mobile">
                					<div class="box-header">
			                           <h3 class="box-title">Change Mobile Number</h3>
			                  		</div> <!-- ./box-header -->
			                  		<div class="box-body">
			                  			<div class="form-group">
			                  				<label for="mobile">Enter your mobile number below</label>
			                  				<input type="text" maxlength="10" class="form-control" id="mobile" name="mobile" placeholder="without +91 and 0" value="<?php echo Session::get('mobile'); ?>" />
			                  			</div>
			                  			<div class="form-group">
			                  				<label for="confirm_password">Enter your current password</label>
			                  				<input type="password" class="form-control" id="confirm_password" name="cpwd" placeholder="current password" />
			                  			</div>
			                  		</div><!-- ./box-body -->
			                  		<div class="box box-footer">
			                  			<button type="submit" class="btn btn-primary" name='submit'>Save</button>
			                  		</div> <!-- ./box-footer -->
			                  		</form>
                				</div>
								
	                        </div>
	                        <div class="col-md-4">
	                          	<div class="box box-info">
	                          		<form role="form" id="change_photo">
                					<div class="box-header">
			                           <h3 class="box-title">Change Profile Photo</h3>
			                           
			                  		</div> <!-- ./box-header -->
			                  		<div class="box-body">
			                  			<div class="form-group">
			                  				<div class="btn btn-success btn-file">
			                  				<i class="fa fa-cloud-upload"></i>
			                  				Browse
			                  				<input type="file" name="photo">
			                  				</div>
			                  				<p class="help-block">Max. 500KB<br/> Click on save to continue</p>
			                  			</div>
			                  		</div><!-- ./box-body -->
			                  		<div class="box box-footer">
			                  			<button type="submit" value="submit" class="btn btn-warning" name='submit'>Save</button>
			                  		</div> <!-- ./box-footer -->
			                  		</form>
	                          	</div>
	                        </div>  	
	                        <div class="col-md-4">
	                          	<div class="box box-warning">
	                          		<form role="form" id="change_password">
                					<div class="box-header">
			                           <h3 class="box-title">Change Password</h3>
			                           
			                  		</div> <!-- ./box-header -->
			                  		&nbsp;&nbsp;(your web mail and lms password will also be changed)
			                  		<div class="box-body">
			                  			<div class="form-group">
			                  				<label for="newpwd1">Enter new password</label>
			                  				<input type="password" class="form-control" id="newpwd1" name="newpwd1" placeholder="New password" />
			                  			</div>
			                  			<div class="form-group">
			                  				<label for="newpwd2">Confirm new password</label>
			                  				<input type="password" class="form-control" id="newpwd2" name="newpwd2" placeholder="Confirm new password" />
			                  			</div>
			                  			<div class="form-group">
			                  				<label for="cpwd">Enter your current password</label>
			                  				<input type="password" class="form-control" id="cpwd" name="cpwd" placeholder="current password" />
			                  			</div>
			                  		</div><!-- ./box-body -->
			                  		<div class="box box-footer">
			                  			<button type="submit" class="btn btn-danger" name='submit'>Save</button>
			                  		</div> <!-- ./box-footer -->
			                  		</form>
	                          	</div>
	                        </div>
	                    </div>
</section><!-- /.content -->

		
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!--  Main javascript files -->
        <!-- AJAX FORM -->
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script src="js/change_mobile.js"></script>
        <script src="js/change_password.js"></script>
        <script src="js/change_photo.js"></script>