 function sin_password(){
    var password = document.getElementById("sin_password");
    var print_p = document.getElementById("sin_pass");

    var pass_char = new RegExp("([^a-zA-Z0-9#@*&!_])");
    var pass_char_low = new RegExp("([a-z])");
    var pass_char_upp = new RegExp("([A-Z])");
    var pass_char_num = new RegExp("([0-9])");

    if (password.value.length == 0){
        print_p.innerHTML = "Enter Password";
        sin_password_err = 0;
    }else if (password.value.length > 20){
        print_p.innerHTML = "password too long";
        sin_password_err = 0;
    }else if (password.value.length < 8){
        print_p.innerHTML = "password too short";
        sin_password_err = 0;
    }else if (pass_char.test(password.value)){
        print_p.innerHTML = "allowed char a-z A-Z 0-9 # * & ! _ @";
        sin_password_err = 0;
    }else if (password.value.length > 7 && !pass_char_low.test(password.value)){
        print_p.innerHTML = "password need lowwer case a-z";
        sin_password_err = 0;
    }else if (password.value.length > 7 && !pass_char_upp.test(password.value)){
        print_p.innerHTML = "password need upper case A-Z";
        sin_password_err = 0;
    }else if (password.value.length > 7 && !pass_char_num.test(password.value)){
        print_p.innerHTML = "password need number case 0-9";
        sin_password_err = 0;
    }else{
        print_p.innerHTML = "";
        sin_password_err = 1;
    }
}

function sin_match(){
    var passworda = document.getElementById("sin_password");
    var passwordb = document.getElementById("sin_pass_match");
    var print_p = document.getElementById("sin_match");
    
    if (passwordb.value.length > 0 && passworda.value !== passwordb.value){
        print_p.innerHTML = "passwords don't match";
        sin_match_password_err = 0;
    }else if (passwordb.value.length < 1){
        print_p.innerHTML = "Enter password";
        sin_match_password_err = 0;
    }else{
        print_p.innerHTML = "";
        sin_match_password_err = 1;
    }
}

function confirm_password(){
    var password = document.getElementById("sin_password").value;
    var print_p = document.getElementById("sin_match");
    var uploadrequest;

    sin_password();
    sin_match();

    if (sin_match_password_err == 1 && sin_password_err == 1){
        try{uploadrequest = new XMLHttpRequest();} catch (e){
                try{uploadrequest = new ActiveXObject("Msxml2.XMLHTTP");} catch (e) {
                    try{uploadrequest = new ActiveXObject("Microsoft.XMLHTTP");} catch (e){
                        alert("Your browser broke!");
                        return false;
                    }
                }
            }
            uploadrequest.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == "its_cool"){
                        window.location.replace("../index.php");
                    }else if (this.responseText == "nope"){
                        print_p.innerHTML = "unable to save";
                        
                        // pass_word.value = "";
                    }
                }
            };
        uploadrequest.open("post", "../index_php_files/save_new_pass.php", true);
        uploadrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        uploadrequest.send(password); 
    }else {
        window.alert("hello");
    }
}


	