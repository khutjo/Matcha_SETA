/* This script sends a request to the server to logout a user
** when they click the logout button. 
*/
$(document).ready(function(){
    $("#logout-btn").on('click', function(){
        $.ajax({
            type: "POST",
            url: "../pages/logout.php",
            data: {
                logout: "true",
                check: "OK",
            },
            success : function(response){
               window.location.replace("../index.php");
            }
        });
    });
});