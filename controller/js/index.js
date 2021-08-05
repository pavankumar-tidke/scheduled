 

function valid_emp() {
    
}
function match_pass() {
    
}



var empsid, empsemail, empspass, empsconf_pass;
$(document).on('keyup', '#empsid', function(){
    empsid = $(this).val();
    if(empsid == '' || empsid == undefined) {
        $('#empsid_small').text('employee ID should not be black');
        $('#empsid_small').css({'color': 'red', 'font-style': 'italic'});
    }
    else {
        $('#empsid_small').text('');
    }
});
$(document).on('keyup', '#empsemail', function(){
    empsemail = $(this).val();
    if(empsemail == '' || empsemail == undefined) {
        $('#empsemail_small').text('email should not be black');
        $('#empsemail_small').css({'color': 'red', 'font-style': 'italic'});
    }
    else {
        $('#empsemail_small').text('');
    }
});
$(document).on('keyup', '#empspass', function(){
    empspass = $(this).val();
    if(empspass == '' || empspass == undefined) {
        $('#empspass_small').text('password is must');
        $('#empspass_small').css({'color': 'red', 'font-style': 'italic'});
    }
    else {
        $('#empspass_small').text('');
    }
});
$(document).on('keyup', '#empsconf_pass', function(){
    empsconf_pass = $(this).val();
    if(empsconf_pass === empspass) {
        $('#empsconf_pass_small').text('');
    }
    else {
        $('#empsconf_pass_small').text('Passwords dose not match');
        $('#empsconf_pass_small').css({'color': 'red', 'font-style': 'italic'});
    }
});