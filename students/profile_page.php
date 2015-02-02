<?php

if(!loggedIn() || privilege()==NULL){
	Redirect::to('logout.php');
}
?>
<?php 
	$s = new Student();
	$s->getInfo(Session::get('sn'));
?>
<section class="content-header">
                    <h1>
                        Public Profile
                        <small>Your Public Profile</small>
                        <b><small>http://nits.ac.in/s/<?php $username = explode('@',$s->getEmail())[0]; echo "$username";?></small></b>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><a href="#">Public Profile</a></li>
                    </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row" id="preview">
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div id="update"></div>
			<div class="box box-info">
				<form role="form" id="update_biography">
				<div class="box-header">
					<h3 class="box-title">Create Profile</h3>
					
                  
				</div> <!-- ./box-header -->
				
				<div class="box-body">
				<div class="btn btn-success btn-file">
                  		<i class="fa fa-cloud-upload"></i>
                  			Browse CV
                  		<input type="file" name="cv">
                 </div>
                <p class="help-block">Max. 2MB</p>
				Showcase your profile by self-customizing it.<br/>Click on "Source" in Editor to make profile using HTML directly.<br/>You can also copy from word document and paste below. <br/>
                    <textarea id="editor1" name="editor1" rows="20" cols="100">
                    	<?php 
                    		if($s->getBiography()!=NULL){
                    			echo $s->getBiography();
                    		}
                    		else{
								echo "<em>Your details goes on here . . .</em>";
							}
                    	?>
                	</textarea>
				</div> <!-- ./box-body -->
				<div class="box box-footer">
					<i class="pull-right">(publishing and un-publishing doesn't saves above content)</i>
					<i class="pull-left">(your curriculum vitae i.e., CV also gets uploaded when clicked Save &amp; Preview)</i><br/>
					<?php 
						if(!$s->getPublished()){
					?>
					<input type="button" class="btn btn-success pull-right" id="publish" value="Publish" />
						
					<?php 
						}else{
					?>
					<input type="button" class="btn btn-success pull-right" id="unpublish" value="Un-Publish" />
					<?php
						}
					?>
                	<button type="submit" class="btn btn-primary" name='submit'>Save &amp; Preview</button>
                	
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
        <!-- CK Editor -->
        <script src="js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
        <!-- AJAX FORM -->
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script src="js/update_biography.js"></script>
        <!--  Main javascript files -->
        <script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('editor1');
            });
            $('#publish').click(function(){
				$('#update').load('ajax/publish_profile.php?a=1');
            });
            $('#unpublish').click(function(){
				$('#update').load('ajax/publish_profile.php?a=2');
            });
        </script>