function set_forgot_loging(){
    var login_div = document.getElementById("logindiv");
    var forgot_div = document.getElementById("forgot");

    if (login_div.style.display == "none"){
        login_div.style.display = "initial";
        forgot_div.style.display = "none";
    }else{
        login_div.style.display = "none";
        forgot_div.style.display = "initial";
    }
}

function mid_process(){
    var print_p= document.getElementById("what");
    setInterval(set_forgot_loging, 5000);
    print_p.innerHTML = "";
}

function send_email(){
    var email_adde= document.getElementById("forgot_login").value;
    var print_p= document.getElementById("what");
    var uploadrequest;

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
                print_p.innerHTML = "Email sent";
                set_forgot_loging();
             }else if (this.responseText == "dont_know_you"){
                print_p.innerHTML = "Email does not exist";
                
                // pass_word.value = "";
            }
        }
    };
    uploadrequest.open("post", "index_php_files/forgot_password.php", true);
    uploadrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    uploadrequest.send(email_adde);      
}

//login function
function username_check(){
    var user_name = document.getElementById("username_in");

    var real_char = new RegExp("([^a-zA-Z0-9*&!_])");
    

    if (user_name.value.length < 5){
        document.getElementById("what").innerHTML = "username length too short";
        return (0);
    }
    else if (real_char.test(user_name.value)) {
        document.getElementById("what").innerHTML = "Allowed characters a-z A-Z 0-9  * & ! _";
        return (0);
    }
    else {
        document.getElementById("what").innerHTML = "";
        return (1);
    }
}
function password_chack(){
    var pass_word = document.getElementById("password_in");
    
    var real_char = new RegExp("([^a-zA-Z0-9@*&!_])");
    if (pass_word.value.length < 8){
        document.getElementById("what").innerHTML = "password length too short";
        return (0);
    }else if (pass_word.value.length > 20) {
        document.getElementById("what").innerHTML = "password too long";
        return (0);
    }else if (real_char.test(pass_word.value)) {
        document.getElementById("what").innerHTML = "Allowed characters a-z A-Z 0-9";
        return (0);
    }
    else {
        document.getElementById("what").innerHTML = "";
        return (1);
    }
}

function check_database(){
    
    
    // document.getElementById("submit").submit();
    
    var user_name = document.getElementById("username_in");
    var pass_word = document.getElementById("password_in");

    var strings = user_name.value+","+pass_word.value;

    var uploadrequest;
    

// if (strValue === "")
// user_name.innerHTML="this is an invalid name";
	try{
		// Opera 8.0+, Firefox, Safari
        uploadrequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
            uploadrequest
 = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
                uploadrequest
     = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
    }
            uploadrequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "not_cool"){
                    document.getElementById("what").innerHTML = "invalid username/password";
                    pass_word.value = "";
                }else {
                    // document.getElementById("what").innerHTML = this.responseText;
                    setTimeout("location.reload(true);",500);
                }
                // window.alert("this.responseText");
            }
          };
        //   window.alert("hello");index_php_files/log_user_in.php
        uploadrequest.open("post", "index_php_files/log_user_in.php", true);
        uploadrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        uploadrequest.send(strings);      

        // document.location.href = canvas.toDataURL("image/png").replace("image/png", "media/octet-stream");
    
};

function check_data(){
    if (password_chack() && username_check()){
        check_database();
    }
}

//signup functions


function sin_name (select){
    var name = "sin_name"+select;
    var p_name = "sign_p"+select;
    var input = document.getElementById(name);
    var print_p = document.getElementById(p_name);
    
    if (select == 0){
        var element_select = "First name";
    }else{
        var element_select = "Last name";
    }

    var allow_char = new RegExp("([^a-zA-Z])");
    if (allow_char.test(input.value)){
        print_p.innerHTML = "Allowed characters a-z A-Z";
        sin_name_err = 0;
    }else if (input.value.length < 1){
            print_p.innerHTML = element_select+" empty";
            sin_name_err = 0;
    }else if (input.value.length > 15){
        print_p.innerHTML = element_select+" too long";
        sin_name_err = 0;
    }else{
        print_p.innerHTML = "";
        sin_name_err = 1;
    }
}

function sin_email (){
    var email = document.getElementById("sin_email_db");
    var print_p = document.getElementById("sign_p3");
    
    var strings = email.value;

    var uploadrequest;
    

// if (strValue === "")
// user_name.innerHTML="this is an invalid name";
	try{
		// Opera 8.0+, Firefox, Safari
        uploadrequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
            uploadrequest
 = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
                uploadrequest
     = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
    }
            uploadrequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "its cool"){
                    print_p.innerHTML = "";
                    sin_email_err = 1;
                    // pass_word.value = "";
                }else if (this.responseText === "in use"){
                    print_p.innerHTML = "Email in use";
                    sin_email_err = 0;
                }else {
                    // document.getElementById("what").innerHTML = "ok";
                    print_p.innerHTML = "Invalid Email";
                    sin_email_err = 0;
                    // setTimeout("location.reload(true);",0);
                }
            }
          };
        //   window.alert("hello");
        uploadrequest.open("post", "index_php_files/email_test.php", true);
        uploadrequest.send(strings);

}

function sin_username(){
    var username = document.getElementById("sin_username_db");
    var print_p = document.getElementById("sign_p4");
    
    var strings = username.value;

    var uploadrequest;
    
// if (strValue === "")
// user_name.innerHTML="this is an invalid name";
	try{
		// Opera 8.0+, Firefox, Safari
        uploadrequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
            uploadrequest
 = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
                uploadrequest
     = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
    }
            uploadrequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "its cool"){
                    print_p.innerHTML = "";
                    sin_username_err = 1;
                    // pass_word.value = "";
                }else if (this.responseText === "too short"){
                    print_p.innerHTML = "username too short";
                    sin_username_err = 0;
                }else if (this.responseText === "too long"){
                    print_p.innerHTML = "username too long";
                    sin_username_err = 0;
                }else if (this.responseText === "in use"){
                    print_p.innerHTML = "username in use";
                    sin_username_err = 0;
                }else {
                    // document.getElementById("what").innerHTML = "ok";
                    print_p.innerHTML = "Allowed characters a-z A-Z 0-9 * & ! _";
                    sin_username_err = 0;
                    // setTimeout("location.reload(true);",0);
                }
            }
          };
        //   window.alert("hello");
        uploadrequest.open("post", "index_php_files/username_test.php", true);
        uploadrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        uploadrequest.send(strings); 
}

function sin_password(){
    var password = document.getElementById("sin_password");
    var print_p = document.getElementById("sign_p5");

    var pass_char = new RegExp("([^a-zA-Z0-9#@*&!_])");
    var pass_char_low = new RegExp("([a-z])");
    var pass_char_upp = new RegExp("([A-Z])");
    var pass_char_num = new RegExp("([0-9])");

    if (password.value.length < 8){
        print_p.innerHTML = "Password too short";
        sin_password_err = 0;
    }else if (password.value.length > 20){
        print_p.innerHTML = "Password too long";
        sin_password_err = 0;
    }else if (pass_char.test(password.value)){
        print_p.innerHTML = "Allowed characters a-z A-Z 0-9 # * & ! _ @";
        sin_password_err = 0;
    }else if (password.value.length > 7 && !pass_char_low.test(password.value)){
        print_p.innerHTML = "Password need lower case a-z";
        sin_password_err = 0;
    }else if (password.value.length > 7 && !pass_char_upp.test(password.value)){
        print_p.innerHTML = "Password need upper case A-Z";
        sin_password_err = 0;
    }else if (password.value.length > 7 && !pass_char_num.test(password.value)){
        print_p.innerHTML = "password need number case 0-9";
        sin_password_err = 0;
    }else{
        print_p.innerHTML = "";
        sin_password_err = 1;
    }
}

function sin_password_match(){
    var passworda = document.getElementById("sin_password");
    var passwordb = document.getElementById("sin_match_pass");
    var print_p = document.getElementById("sign_p6");
    
    if (passwordb.value.length > 0 && passworda.value !== passwordb.value){
        print_p.innerHTML = "Passwords do not match";
        sin_match_password_err = 0;
    }else if (passwordb.value.length < 1){
        print_p.innerHTML = "Enter password";
        sin_match_password_err = 0;
    }else{
        print_p.innerHTML = "";
        sin_match_password_err = 1;
    }
}

function send_to_database(){
    var d = ",";
    var uploadrequest;
    var lname = document.getElementById("sin_name1").value;
    var fname = document.getElementById("sin_name0").value;
    var email = document.getElementById("sin_email_db").value;
    var username = document.getElementById("sin_username_db").value;
    var password = document.getElementById("sin_password").value;
    var strings = lname+d+fname+d+email+d+username+d+password;
    

// if (strValue === "")
// user_name.innerHTML="this is an invalid name";
	try{
		// Opera 8.0+, Firefox, Safari
        uploadrequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
            uploadrequest
 = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
                uploadrequest
     = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
    }
            uploadrequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "inserted"){
                    it_worked = this.responseText;
                    // window.alert(it_worked);
                }else{
                    window.alert("account was not created (ERROR 702)")
                }
                // window.alert(">"+this.responseText+"<");
            }
          };
        //   window.alert("hello");
        uploadrequest.open("post", "index_php_files/add_to_db.php", true);
        uploadrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        uploadrequest.send(strings);      
}

function clear_singup_form(){
    document.getElementById("sin_name1").value = "";
    document.getElementById("sin_name0").value = "";
    document.getElementById("sin_email_db").value = "";
    document.getElementById("sin_username_db").value = "";
    document.getElementById("sin_password").value = "";
    document.getElementById("sin_match_pass").value = "";
    document.getElementById("sign_p0").innerHTML = "";
    document.getElementById("sign_p1").innerHTML = "";
    document.getElementById("sign_p3").innerHTML = "";
    document.getElementById("sign_p4").innerHTML = "";
    document.getElementById("sign_p5").innerHTML = "";
    document.getElementById("sign_p6").innerHTML = "";
    document.getElementById("sign_p7").innerHTML = "";
}
var myWindow;

function check_signup_data (){
    var print_p = document.getElementById("sign_p7");
    sin_name(0);
    if (sin_name_err == 0){
        sin_name(1);
    }
    sin_email();
    sin_username();
    sin_password();
    sin_password_match();
    
    if (sin_name_err == 0 || sin_email_err == 0 || sin_username_err == 0 ||
        sin_password_err == 0 || sin_match_password_err == 0){
       print_p.innerHTML = "fix missing or incorrect fields";
    }else{
        print_p.innerHTML = "";
        send_to_database();
        clear_singup_form();
        myWindow = window.open("index_php_files/verify_email.php");
       
    }
}

function closeWin() {
// if (strValue === "")
// user_name.innerHTML="this is an invalid name";

	try{
		// Opera 8.0+, Firefox, Safari
        uploadrequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
            uploadrequest
 = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
                uploadrequest
     = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
    }
            uploadrequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "validated"){
                    myWindow.close();
                    // window.alert(it_worked);
                }
            }
          };
        //   window.alert("hello");
        uploadrequest.open("post", "index_php_files/verification_hadler.php", true);
        uploadrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        uploadrequest.send("valid");   
}


setInterval(closeWin, 5000);



