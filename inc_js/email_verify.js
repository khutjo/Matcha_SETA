veri = 0
function resend_email(){

    var uploadrequest;    

	try{
        uploadrequest = new XMLHttpRequest();
	} catch (e){
		try{
            uploadrequest
 = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
                uploadrequest
     = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
    }
            uploadrequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "cool"){
                    document.getElementById("infrom_mail").innerHTML = "email resent";
                    document.getElementById("otp_in").value = "";
                }else {
                    document.getElementById("infrom_mail").innerHTML = "unable to send email";
                }
            }
          };
        //   window.alert("hello");index_php_files/verification_hadler.php
        uploadrequest.open("post", "../index_php_files/verification_hadler.php", true);
        uploadrequest.send("resend,email");
}

function verify_otp_db(){
    var strings = "verify,"+document.getElementById("otp_in").value;

    
    var uploadrequest;    

	try{
        uploadrequest = new XMLHttpRequest();
	} catch (e){
		try{
            uploadrequest
 = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
                uploadrequest
     = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
    }
            uploadrequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "all_set"){
                    document.getElementById("infrom_mail").innerHTML = "email verified";
                    veri = 1;
                }else {
                    document.getElementById("infrom_mail").innerHTML = "invelid OTP";
                    document.getElementById("otp_in").value = "";
                    veri = 0;
                }
            }
          };
        //   window.alert("hello");index_php_files/verification_hadler.php
        uploadrequest.open("post", "../index_php_files/verification_hadler.php", true);
        uploadrequest.send(strings);
}

function verify_otp(state){
    var otp = document.getElementById("otp_in").value;
    var print_p = document.getElementById("infrom_mail");

    if (otp.length < 6){
        var num = 6 - otp.length;
        print_p.innerHTML = "OTP missing "+num+" characters";
    }else if (otp.length > 6){
        var num = otp.length - 6;
        print_p.innerHTML = "OTP has "+num+" extra characters";
    }else{
        print_p.innerHTML = "";
        if (state == 1){
            verify_otp_db()
        }
    }

}
function doSomething() {
    
    if (veri == 1){
         location.replace("../index.php");
    }
}

setInterval(doSomething, 1000);