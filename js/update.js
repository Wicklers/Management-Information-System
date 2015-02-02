$(document).ready(function(){
    $('#update').hide();
    $('#update1').hide();
    $('.u_close1').hide();
    $('.u_close').hide();
    $('.u_close').click(function(){
        $('#update').fadeOut('fast');
        $('.u_close').fadeOut('fast');
    });
    
    $('.u_close1').click(function(){
        $('#update1').fadeOut('fast');
        $('.u_close1').fadeOut('fast');
    });
});
