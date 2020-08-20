sin_name_err = 0;
sin_email_err = 0;
sin_username_err = 0;
password_enter = 0;
sin_password_err = 0;
sin_match_password_err = 0;

function sin_name (select){
    var name = "sin_name"+select;
    var p_name = "sign_p"+select;
    var input = document.getElementById(name);
    var print_p = document.getElementById(p_name);
    
    if (select == 0){
        var element_select = "Firstname";
    }else{
        var element_select = "Lastname";
    }

    var allow_char = new RegExp("([^a-zA-Z])");
    if (allow_char.test(input.value)){
        print_p.innerHTML = "allowed char a-z A-Z";
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
    var print_p = document.getElementById("sign_p2");
    
    var strings = email.value;

    var uploadrequest;
    
if (email.value != my_email){
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
        uploadrequest.open("post", "../index_php_files/email_test.php", true);
        uploadrequest.send(strings);
    }else {
        sin_email_err = 0;
    }
}

function sin_username(){
    var username = document.getElementById("sin_username_db");
    var print_p = document.getElementById("sign_p3");
    
    var strings = username.value;

    var uploadrequest;
    
// if (strValue === "")
// user_name.innerHTML="this is an invalid name";
if (username.value != my_username){    
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
                }else if (this.responseText === "in use"){
                    print_p.innerHTML = "username in use";
                    sin_username_err = 0;
                }else {
                    // document.getElementById("what").innerHTML = "ok";
                    print_p.innerHTML = "allowed char a-z A-Z 0-9 * & ! _";
                    sin_username_err = 0;
                    // setTimeout("location.reload(true);",0);
                }
            }
          };
        //   window.alert("hello");
        uploadrequest.open("post", "../index_php_files/username_test.php", true);
        uploadrequest.send(strings);
    }else {
        sin_username_err = 0;
    }
}

function db_valid_check(){
    var passworda = document.getElementById("sin_passworda");
    var passwordb = document.getElementById("sin_match_pass");
    var pass = document.getElementById("sin_password").value;
    var print_p = document.getElementById("sign_p4");
    var print_pa = document.getElementById("sign_p5");
    var print_pb = document.getElementById("sign_p6");
    
    if (pass.length > 0){
    $.post("../profile_page_files/edit_account.php",{
        password: pass
    },
    function(data,status){
        if (data == "valid"){
            password_enter = 1;
            passworda.disabled = false;
            sin_password();
            print_p.innerHTML = "enter new password";
        }else{
        print_p.innerHTML = "invalid password";
        print_pa.innerHTML = "";
        print_pb.innerHTML = "";
            passworda.disabled = true;
            passwordb.disabled = true;
            password_enter = 0;
        }
    });}else {
        print_p.innerHTML = "";
        print_pa.innerHTML = "";
        print_pb.innerHTML = "";
        passworda.disabled = true;
        passwordb.disabled = true;

    }
}

function sin_password(){
    var passwordb = document.getElementById("sin_match_pass");
    var password = document.getElementById("sin_passworda");
    var print_p = document.getElementById("sign_p5");

    var pass_char = new RegExp("([^a-zA-Z0-9#@*&!_])");
    var pass_char_low = new RegExp("([a-z])");
    var pass_char_upp = new RegExp("([A-Z])");
    var pass_char_num = new RegExp("([0-9])");


    if (password.value.length < 8){
        print_p.innerHTML = "Password too short";
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
        $.post("../profile_page_files/edit_account.php",{
            password: password.value
        },
        function(data,status){
            if (data == "nope"){
                passwordb.disabled = false;
                print_p.innerHTML = "";
                sin_password_err = 1;
            }else{
                passwordb.disabled = true;
                sin_password_err = 0;
                print_p.innerHTML = "this is your old password";
            }
        });
    }
}

function sin_password_match(){
    var passworda = document.getElementById("sin_passworda");
    var passwordb = document.getElementById("sin_match_pass");
    var print_p = document.getElementById("sign_p6");
    
    if (passwordb.value.length > 0 && passworda.value !== passwordb.value){
        print_p.innerHTML = "passwords don't match";
        sin_match_password_err = 0;
    }else if (passwordb.value.length < 1){
        print_p.innerHTML = "enter password";
        sin_match_password_err = 0;
    }else{
        print_p.innerHTML = "";
        sin_match_password_err = 1;
    }
}

(function(){
    function startup(){
        var fname = document.getElementById("sin_name0");
        var lname = document.getElementById("sin_name1");
        var email = document.getElementById("sin_email_db");
        var uname = document.getElementById("sin_username_db");
        var passworda = document.getElementById("sin_passworda");
        var passwordb = document.getElementById("sin_match_pass");

        
        // get_my_gender.selectedIndex = "2";
        $.post("../profile_page_files/edit_account.php",{
            firstname: "get"
        },
        function(data,status){
            fname.value = data;
        });
        $.post("../profile_page_files/edit_account.php",{
            lastname: "get"
        },
        function(data,status){
            lname.value = data;
        });
        $.post("../profile_page_files/edit_account.php",{
            email: "get"
        },
        function(data,status){
            email.value = data;
            my_email = data;
        });
        $.post("../profile_page_files/edit_account.php",{
            username: "get"
        },
        function(data,status){
            uname.value = data;
            my_username = data;
        });
        get_pictures();
        passworda.disabled = true;
        passwordb.disabled = true;
    };
    window.addEventListener('load', startup, false);
    })();

    function add_to_db (strings){
        try{
            uploadrequest = new XMLHttpRequest();
        } catch (e){
            try{
                    uploadrequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try{
                    uploadrequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e){
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        uploadrequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                }
        };
        uploadrequest.open("post", "../profile_page_files/edit_account.php", true);
        uploadrequest.send(strings);
    }
    
    function clear_password_field(){
        document.getElementById("sin_password").value = "";
        document.getElementById("sin_passworda").value = "";
        document.getElementById("sin_match_pass").value = "";
        document.getElementById("sin_passworda").disabled = true;
        document.getElementById("sin_match_pass").disabled = true;
        document.getElementById("sign_p4").innerHTML = "";
        document.getElementById("sign_p5").innerHTML = "";
        document.getElementById("sign_p6").innerHTML = "";

    }

    function save_changes(){
        var fname = document.getElementById("sin_name0");
        var lname = document.getElementById("sin_name1");
        var email = document.getElementById("sin_email_db");
        var uname = document.getElementById("sin_username_db");
        var passworda = document.getElementById("sin_passworda");
        var username = document.getElementById("sign_p3");
        
        sin_name(1);
        if (sin_name_err == 1){
            add_to_db("add_lname="+lname.value);
        }
        sin_name(0);
        if (sin_name_err == 1){
            add_to_db("add_fname="+fname.value);
        }
        sin_email();
        if (sin_email_err == 1){
            add_to_db("add_email="+email.value);
            my_email = email.value;
        }
        db_valid_check();
        if (password_enter == 1){  
            sin_password();
            sin_password_match(6);
            if (sin_password_err == 1 && sin_match_password_err ==1){
                if (password_enter == 1){
                    add_to_db("add_password="+passworda.value);
                    clear_password_field();
                }
            }
        }
        // sin_username();
        if (sin_username_err == 1){
            add_to_db("add_uname="+uname.value);
            my_username = uname.value;
            username.innerHTML = "";
        }
    }