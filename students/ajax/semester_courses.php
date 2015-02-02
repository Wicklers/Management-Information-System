<?php
require_once '../../core/init.php';
if(!loggedIn()){
    die();
}
if(Input::exists('get')){
    if(Input::get('sem')!=='' && Input::get('dep')!=='' && Token::check_a(Input::get('token'))){
        $i=0;
        $c = new Course();
        $courses = $c->getCoursesAvailable(Input::get('sem'), Input::get('dep'));
        if(!empty($courses)){
           ?>
           <script ></script>
<input id="courses" type="hidden" name="courses" value=" "/>
            <table class="table">
                <tr>
	                <th>S.No.</th>
	                <th>Subject Name</th>
	                <th>Subject Code</th>
	                <th>Credit Point</th>
	                <th>Select</th>
                </tr>
                <?php
                    $i=1;
                    $total_credit=0;
                    while($course = $courses->fetch_object()){
                 ?>
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $course -> course_name; ?></td>
                <td><?php echo $course -> course_code; ?>
                	<input id="course_<?php echo $i; ?>" type="hidden" value="<?php echo $course -> course_code; ?>" />
                	
                </td>
                <td><?php echo $course -> course_credit; ?></td>
                <td>
                	<input type="checkbox" name="courses_<?php echo $course -> course_code; ?>" id="regular_checkbox<?php echo $i; ?>" value="<?php echo $course -> course_credit; ?>">
                </td>
                </tr>
                <?php

                $i++;
                }
                ?>
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th colspan=2><input id="total_credits" name="total_credits" type="hidden" value="0" /><div id="total_credit">0</div>(<i>Total Credit</i>)</th>
                </tr>
            </table>
            <script><?php
        }
        for(;--$i>0;){
	?>
	
		        $(document).ready(function(){
			z<?php echo $i; ?>=0;
   $('#regular_checkbox<?php echo $i; ?>').click(function(){
                if(z<?php echo $i; ?>==0){
                    z<?php echo $i; ?>++;
   			x=Number($("#total_credit").val())+Number($(this).val());
   			$("#total_credit").val(x);
   			$("#total_credits").val(x);   //input type= hidden
   			$("#total_credit").html(x);
   			$("#courses").val($('#courses').val()+","+$('#course_<?php echo $i; ?>').val());
                }else{
                x=Number($("#total_credit").val())-Number($(this).val());
                $("#total_credit").val(x);
                $("#total_credit").html(x);
                $("#total_credits").val(x);   //input type= hidden
                z<?php echo $i; ?>--;
   			
   			res=$("#courses").val().replace(","+$('#course_<?php echo $i; ?>').val(), "");
                $("#courses").val(res);
                }

                });

                });

	<?php
    }
?></script>

<?php
}
}
?>