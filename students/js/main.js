$(document).ready(function(){
   $('.u_close').click(function(){
	   $('.u_close').fadeOut();
	   $('#update').fadeOut();
   });
   $('#cancel').click(function(){
      window.location.href="../logout.php"; 
   });
   $('#back').click(function(){
	      window.location.href="registration.php?step=1"; 
	   });
    
    $('#department').change(function(){
        if($('#semester').val()!=='' && $('#department').val()!==''){
            $('#sem_courses').load('ajax/semester_courses.php?sem='+$("#semester").val()+'&dep='+$("#department").val()+'&token='+$('#token').val());
        }
    });
    
    $('#semester').change(function(){
        if($('#semester').val()!=='' && $('#department').val()!==''){
            $('#sem_courses').load('ajax/semester_courses.php?sem='+$("#semester").val()+'&dep='+$("#department").val()+'&token='+$('#token').val());
        }
    });
    

//step 1 registration
	var options = { 
		target:        '#update',   // target element(s) to be updated with server response 
		beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponsemsg,  // post-submit callback 
		url:'ajax/registration.php',
		type: 'post',
		};
		
		$('#registration').ajaxForm(options);
		

// pre-submit callback
function showRequest(formData, jqForm, options) { 
    var queryString = $.param(formData); 

	$('#loading').show();

    return true; 
} 

// post-submit callback 
function showResponsemsg(responseText, statusText, xhr, $form)  { 
    
	$('#loading').hide();
	$('#update').fadeIn();
	$('.u_close').fadeIn();
	if(responseText==="Registration Successful."){
		window.location.href="registration.php?step=2";
	}
   return true;
   
}



//mobile verification : step 2
var options1 = { 
		target:        '#update',   // target element(s) to be updated with server response 
		beforeSubmit:  showReq,  // pre-submit callback 
        success:       showRes,  // post-submit callback 
		url:'ajax/mobile_verify.php',
		type: 'post',
		};
		
		$('#mobile_verify').ajaxForm(options1);
		

// pre-submit callback
function showReq(formData, jqForm, options) { 
    var queryString = $.param(formData); 

	$('#loading').show();

    return true; 
} 

// post-submit callback 
function showRes(responseText, statusText, xhr, $form)  { 
    
	$('#loading').hide();
	$('#update').fadeIn();
	$('.u_close').fadeIn();
	if(responseText==="Verified."){
		window.location.href="registration.php?step=3";
	}
   return true;
   
}

});