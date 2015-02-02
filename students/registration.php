<!-- Latest compiled and minified CSS -->
<?php
require_once '../core/init.php';

if(!loggedIn()){
    Redirect::to("index.php");
    die();
}
else{
	$s = new Semester();
	if(!$s->isRegistration()){
		Session::destroy();
		unset($s);
		include 'includes/errors/registration.php';
		die();
	}
    $name = Session::get('displayname');
    $email = Session::get('student_email');
    $sch_no = Session::get('sn');
    $session = Session::get('semester_session');
}
?>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<link rel="stylesheet" href="css/main.css" />

<html>
    
   <head>
      <link rel="icon" href="../images/nits2.jpg">
      <link rel="shortcut icon" href="../images/nits2.jpg" />
      <title>New Semester Registration</title>
   </head>
   <body> 
   	<div id="loading"><img src="../images/loading.gif" /></div>
   	<div id="update"></div><div class="u_close">CLOSE</div>
<?php
if(Input::get('step')==''){
	Redirect::to('registration.php?step=1');
}
if(Input::get('step')==1){
       	 include 'header.php';
         ?>
      <div class="container">
         <form class="form-horizontal" id="registration" action="ajax/registration.php">
            <fieldset>
               <!-- Form Name -->
               <div class="well">
                  <center>
                     <legend>Online Semester Registration<br />NATIONAL INSTITUTE OF TECHNOLOGY, SILCHAR</legend>
                     <h4>Step 1 of 3</h4>
                  </center>
                  
              	
               </div>
              
    <table class="table">
		 <tr>
			<td>
                  <label class="control-label" for="student_name">1. Name</label> 
			</td>
			<td>
				<?php echo $name; ?>
				<input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>" >
			</td>
		<td>
                <label class="control-label" for="Category">2. Category</label>
         </td>
         <td>
              <label class="radio-inline" for="Category-0">
                     <input type="radio" name="Category" id="Category-1" value="SC">
                     SC
                     </label> 
                     <label class="radio-inline" for="Category-2">
                     <input type="radio" name="Category" id="Category-2" value="ST">
                     ST
                     </label> 
                     <label class="radio-inline" for="Category-3">
                     <input type="radio" name="Category" id="Category-3" value="OBC">
                     OBC
                     </label> 
                     <label class="radio-inline" for="Category-4">
                     <input type="radio" name="Category" id="Category-4" value="GEN" checked />
                     GEN
                     </label> 
                     <label class="radio-inline" for="Category-5">
                     <input type="radio" name="Category" id="Category-5" value="PwD">
                     PwD
                     </label>
         </td>
		 </tr>
		 <tr>
         
			<td> 
                
                <label class="control-label" for="gender">3. Gender</label>
            </td>
         <td>
            <select id="gender" name="gender" class="form-control">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
         </td>
         	
         <td>
                  <label class="control-label" for="registration_no">4. Registration No.</label>
            </td>
            <td>
                  <?php echo $sch_no; ?>
            </td>
            
         
         </tr>
		 <tr>
			
			<td>
                  <label class="control-label" for="programme">5. Programme</label>    
            </td>
			
			<td>
			     <input type="text" name="programme" class="form-control" placeholder="E.g., : B.Tech,M.Tech,MBA,etc " /> 
			</td>
			<td>
                
                  <label class="control-label" for="session">6. Session</label>  
               
            </td>
            
            <td>
              <?php echo $session; ?>  
                 
             
                  
           
            </td>
		 </tr>
		 <tr>
			<td>
                
                  <label class="control-label" for="semester">7. Semester</label>  
                 
              
            </td>
            
            <td>
                
                <select name="semester" id="semester" class="form-control">
                    <option value="">Select Semester</option>
                     <?php 
                        $i=(Session::get('semester_type')=='even'?2:1);
                        while($i<=8){
                            echo "<option value='".$i."'>".$i."</option>";
                            $i+=2;
                        }
                     
                     ?> 
                  
            
            </td>
            
            <td>
                  <label class="control-label" for="department">8. Department</label>  

            </td>
            
            <td>
                
                <select name="department" id="department" class="form-control">
                    <option value="">Select Department</option>
                     <?php
                                $dep = new Department();
                                $departments = $dep->getAllDepartment();
                                while($department = $departments->fetch_object()){
                            ?>
                            <option value="<?php echo $department -> dept_id; ?>" ><?php echo $department -> name; ?></option>
                            <?php
                            }
                            ?>
                  
            
            </td>
			
		 </tr>
		 <tr>
		     <td> 
                <label class="control-label" for="mobile" >9. Mobile</label>
            </td>
		     <td>
                <input type="text" maxlength="10" name="mobile" id="mobile" class="form-control" required>
            </td>
            <td> 
                <label class="control-label" for="parents_mobile" required>10. Father's/Guardian's Mobile</label>
            </td>
             <td>
                <input type="text" maxlength="10" name="parents_mobile" id="parents_mobile" class="form-control" required>
            </td>
		 </tr>
	</table>
                   
      <label class="control-label">11. Regular subjects of current semester to register as per syllabus : </label>      
      <div class="container">
         <div class="panel panel-default">
			<div id="sem_courses">
            Select semester and department.    
            </div>
         </div>
      </div>
      
      <label class="control-label">12. <b>Extra Load</b> to be taken for back-log subjects with proper permission, if any : </label>
	  <div class="container">
         <div class="panel panel-default">
         </table>
         <table class="table">
         <tr>
         <th>S.No.</th>
         <th>Subject Name</th>
         <th>Subject Code</th>
         <th>Credit Point</th>
         </tr>
         <?php
            for($i=1;$i<=2;$i++){
            ?>
         <tr>
         <td><?php echo $i; ?></td>
         <td>
			<div id="loadname<?php echo $i; ?>"> - </div> 
		 </td>
         <td>
			<input id="loadcode<?php echo $i; ?>" name="loadcode<?php echo $i; ?>" type="text" placeholder="Subject Code" class="form-control input-md" />
		 </td>	
         <td>
			<div id="loadcredit<?php echo $i; ?>"> - </div>
		 </td>
         </tr>
         <?php
            }
            ?>
         </table>
         </div>
         
         <label class="control-label">13. Present Address : </label>
		 <table class="table">
				<tr>
					<td>
						<b>Home Address</b>
					</td>
					<td>
						<b>Hostel Address</b>
					</td>
				
				</tr>
				<tr>
					<td>
						<textarea name="home_address" class="form-control" style="resize: none;" rows="4" placeholder="Street
City
Pincode
State"></textarea>
					</td>
					<td>
						<textarea name="hostel_address" class="form-control" style="resize: none;" rows="4" placeholder="Room No. XX, Hostel No. XX
NIT Silchar
788010
Assam"></textarea>
					</td>
				
				</tr>
		 </table>
      </div>

				<div class="form-group">
				
				<div class="col-md-12">
					<input type="button" class="btn btn-primary" id="cancel" value="Cancel" />
					<button id="singlebutton" name="singlebutton" class="btn btn-primary pull-right">NEXT</button>
				</div>
				</div>
			</fieldset>
         </form>
      </div>

<?php 
}
if(Input::get('step')==2){
	include 'header.php';
?>
      <div class="container">
         <form class="form-horizontal" id="mobile_verify" action="ajax/mobile_verify.php">
            <fieldset>
               <!-- Form Name -->
               <div class="well">
                  <center>
                     <legend>Online Semester Registration<br />NATIONAL INSTITUTE OF TECHNOLOGY, SILCHAR</legend>
                     <h4>Step 2 of 3</h4>
                  </center>
                  
              	
               </div>
    
				<div class="form-group">
					<table class="table">
					<tr>
			
					<td colspan="4">
		                  <label class="control-label" for="otpcode">Enter password recieved on your mobile to continue to payment step. </label>    
		            </td>
					
					<td colspan="1">
						 <input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>" >
					     <input type="text" name="otpcode" class="form-control" placeholder="8 character password" maxlength="8" required/> 
					</td>
            		</tr>
            		</table>
					<div class="col-md-12">
						<input type="button" class="btn btn-primary" id="cancel" value="Cancel" />
						<input type="button" class="btn btn-primary" id="back" value="Back" />
						<button id="singlebutton" name="singlebutton" class="btn btn-primary pull-right">NEXT</button>
					</div>
				</div>
			</fieldset>
         </form>
      </div>
<?php
}
if(Input::get('step')==3){
	include "/opt/lampp/htdocs/www/MIS/students/includes/errors/not_approved.php";
	Session::destroy();
	die();
}
?>

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
        <script src="js/main.js"></script>
        <script type="text/javascript">
		$('#loadcode1').keyup(function(){
			$code = $('#loadcode1').val()
			$('#loadname1').load('ajax/course_load_info.php?cid='+$code+'&t=1');
			$('#loadcredit1').load('ajax/course_load_info.php?cid='+$code+'&t=2');
		});
		$('#loadcode2').keyup(function(){
			$code = $('#loadcode2').val()
			$('#loadname2').load('ajax/course_load_info.php?cid='+$code+'&t=1');
			$('#loadcredit2').load('ajax/course_load_info.php?cid='+$code+'&t=2');
		});
		 </script>

	<script type="text/javascript">
    		     var _gaq = _gaq || [];
                      _gaq.push(['_setAccount', 'UA-58077290-1']);
                      _gaq.push(['_trackPageview']);
                      (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                      })();
                    </script>
