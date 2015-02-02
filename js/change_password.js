$(document).ready(function() {
	var options = { 
		target:        '#update',   // target element(s) to be updated with server response 
		beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponsemsg,  // post-submit callback 
		url:'ajax/change_password.php',
		type: 'post',
		};
		
		$('#change_password').ajaxForm(options);
		


function showRequest(formData, jqForm, options) { 
     
    var queryString = $.param(formData);
    
    return true; 
} 

// post-submit callback 
function showResponsemsg(responseText, statusText, xhr, $form)  { 
	$('#cpwd').val("");
	$('#newpwd2').val("");
	$('#newpwd1').val("");
   return true;
   
}
});