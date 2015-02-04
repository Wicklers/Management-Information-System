<?php 
require_once '../../core/init.php';

if(Input::exists('post')){
	$biography = Input::get('editor1');
	$s = new Student();
	if(Input::fileexists('cv')){
		if(Input::filetype('cv')=='application/pdf'){
			$main = Input::filename('cv');
			$name = strtolower(preg_replace('/\s+/', '', Session::get('displayname')));
			$id = Session::get('student_id');
			$final = $name.$id.$main;
			$path = '/opt/lampp/htdocs/www/MIS/students/students_cv/';
			$file = Input::file('cv',$path,$final);
		
		}else{
			echo '<div class="alert alert-warning alert-dismissible" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			echo 'Please upload your CV in PDF format ONLY!';
			echo '</div>';
			$final = '';
		}
	}else
		$final = '';
	
	$a = $s->updateBiography(Session::get('sn'), $biography, $final);
	
	if($a==1){
		echo '<div class="alert alert-success alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		echo 'Saved Successfully. Below is your public profile preview.';
		echo '</div>';
	}
	else if($a==2){
		echo '<div class="alert alert-warning alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		echo 'No changes made. Below is your public profile preview.';
		echo '</div>';
	}
	else if($a==0){
		echo '<div class="alert alert-danger alert-dismissible" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
		echo 'Invalid authentication. Please try again later or re-login.';
		echo '</div>';
		die();
	}
	$s->getInfo(Session::get('sn'));
	?>
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
			<div class="box box-primary">
				<div class="box-header">
					<div class="box-title pull-left">
						<h3><?php echo $s->getName(); ?></h3>
						<h4><?php 
							$d = new Department();
							$d->getInfo($s->getDep());
							echo $d->getDepName();
							unset($d);
						?></h4>
						<h4><i><?php echo $s->getEmail(); ?></i></h4>
						<h4><i><?php 
							$username = explode('@',$s->getEmail())[0];
							echo "http://nits.ac.in/s/$username";
							$name1 = strtolower(preg_replace('/\s+/', '', $s->getName()));
							$id = $s->getID();
							$filename = $name1.$id;
						?></i></h4>
						<h4>Mobile : +91 <?php 
							echo $s->getMobile();
						?></h4>
						<h4><u><a href="students_cv/<?php echo $s->getCVLink(); ?>" target="_blank">Curriculum Vitae</a></u></h4>
					</div>
					<div class="box-title pull-right">
						
						<img src="images/profile/<?php echo $filename ?>.jpg" width="200px" height="200px">
						
					</div>
				</div> <!-- ./box-header -->
				<hr/>
				<div class="box-body">
					<?php echo $s->getBiography(); ?>
				</div><!-- ./box-body -->
				
			</div>
		</div>
		<div class="col-md-2">
		</div>
		
	<?php
}


?>
