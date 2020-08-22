function your_gender_in(){
    var opt = document.getElementById("your_gender");
    var strUser = opt.options[opt.selectedIndex].text;

    $.post("../profile_page_files/profile_elements.php",{
        my_gen: strUser
    },
    function(data,status){
    });



}

function their_gender_in(){
    var opt = document.getElementById("their_gender");
    var strUser = opt.options[opt.selectedIndex].text;
    
    $.post("../profile_page_files/profile_elements.php",{
        their_gen: strUser
    },
    function(data,status){
    });
}

function mid_age_enter_sin(){
    var age = document.getElementById("set_age");
    var printp = document.getElementById("errorhandleage");

    if (age.value < 18){
        printp.innerHTML = "you are too young to use this dating site";
    }
}

function my_age_in(){
    var age = document.getElementById("set_age");
    var printp = document.getElementById("errorhandleage");
    var real_char = new RegExp("([^0-9])");


    if (real_char.test(age.value)){
        printp.innerHTML = "thats not a number";
    }else if (age.value >= 18){
        $.post("../profile_page_files/profile_elements.php",{
            my_age: age.value
        },
        function(data,status){
        });
        printp.innerHTML = "";
    }
}
bio_me = 0;
function mid_about_me_in(){
    var bio_in = document.getElementById("my_bio");
    var printp = document.getElementById("errorhandlebio");

    // window.alert(bio_in.value[0]);
    if (bio_in.value.length < 1){
        printp.innerHTML = "you cant be that boring";
        bio_me = 0;
    }else if (bio_in.value.length > 100){
        printp.innerHTML = "that enough don't tell us your life story (max 100)";
        bio_me = 0;
    }else {
        printp.innerHTML = 100 - bio_in.value.length;
        bio_me = 1;
    }
}

function save_data(){
    var uploadrequest;
    var bio_in = document.getElementById("my_bio");
    
    var strings = encodeURI(bio_in.value);
    
    mid_about_me_in();
    if (bio_me == 1){
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
                }
              };
            //   window.alert("hello");
            uploadrequest.open("post", "../profile_page_files/profile_elements.php", true);
            uploadrequest.send(strings); 
    }
}





function set_style(obj){
    obj.style.borderRadius = "50%";
    obj.style.height = "100px";
    obj.style.width = "100px";
}

function get_pictures(){
    var get_profile_picture = document.getElementById("main_picture");
    var get_sub_picturea = document.getElementById("sub_picture1");
    var get_sub_pictureb = document.getElementById("sub_picture2");
    var get_sub_picturec = document.getElementById("sub_picture3");
    var get_sub_pictured = document.getElementById("sub_picture4");

    $.post("../profile_page_files/profile_elements.php",{
        get_pic: "get"
    },
    function(data,status){
        get_profile_picture.src = data;
        // window.alert(data);
    });
    $.post("../profile_page_files/profile_elements.php",{
        get_pic1: "get"
    },
    function(data,status){
        get_sub_picturea.src = data;
        // window.alert(data);
    });
    $.post("../profile_page_files/profile_elements.php",{
        get_pic2: "get"
    },
    function(data,status){
        get_sub_pictureb.src = data;
    });
    $.post("../profile_page_files/profile_elements.php",{
        get_pic3: "get"
    },
    function(data,status){
        get_sub_picturec.src = data;
    });
    $.post("../profile_page_files/profile_elements.php",{
        get_pic4: "get"
    },
    function(data,status){
        get_sub_pictured.src = data;
    });
    
}


(function(){
function startup(){
    var get_my_gender = document.getElementById("your_gender");
    var get_their_gender = document.getElementById("their_gender");
    var get_my_age = document.getElementById("set_age");
    var get_my_bio = document.getElementById("my_bio");



    // get_my_gender.selectedIndex = "2";
    $.post("../profile_page_files/profile_elements.php",{
        my_gender: "get"
    },
    function(data,status){
        // window.alert(data)
        // get_my_gender.options[get_my_gender.selectedIndex].text;
        get_my_gender.value = data;
    });
    $.post("../profile_page_files/profile_elements.php",{
        their_gender: "get"
    },
    function(data,status){
        get_their_gender.options[get_their_gender.selectedIndex].text = data;
        // get_their_gender.value = data;
    });
    $.post("../profile_page_files/profile_elements.php",{
        get_age: "get"
    },
    function(data,status){
        get_my_age.value = data;
    });
    $.post("../profile_page_files/profile_elements.php",{
        get_bio: "get"
    },
    function(data,status){
        get_my_bio.value = decodeURI(data);
    });
    get_pictures();

};
window.addEventListener('load', startup, false);
})();

function doSomething() {
    $.post("../index_php_files/last_seen.php",
    {        });
}

setInterval(doSomething, 1000);


function send_picture_to_database(pos){
    var uploadrequest;
    if (pos == 1){
        var strings = pos+document.getElementById("main_picture").src;
    }else{
        var strings = pos+document.getElementById("sub_picture"+(-1 + pos)).src;
    }

        try{
            uploadrequest = new XMLHttpRequest();
        }catch (e){
            try{
                uploadrequest = new ActiveXObject("Msxml2.XMLHTTP");
            }catch (e) {
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
            // document.getElementById("demo1").innerHTML += this.responseText+"<br>";
        }
              };
        uploadrequest.open("post", "../profile_page_files/profile_pictutre.php", true);
        uploadrequest.send(strings); 
    
}

function previewFile(poss){
    var preview;
    var uploadrequest = "select_file"+poss;
    if (poss == 1){
        preview = document.getElementById("main_picture");
    }else{
        preview = document.getElementById("sub_picture"+(-1 + poss));
    }
    var file = document.getElementById(uploadrequest);
// window.alert("nope");
    //    var preview = document.querySelector('img'); //selects the query named img
    //    var file    = document.querySelector('input[type=file]').files[0]; //sames as here
       var reader  = new FileReader();

       reader.onloadend = function () {
            preview.src = reader.result;
       }
       if (file.files[0]) {
           if ((file.files[0].type == "image/jpeg" || file.files[0].type == "image/png" || file.files[0].type == "image/gif") && file.files[0].size < 10000000){
           reader.readAsDataURL(file.files[0]); //reads the data as a URL
             }else{
                window.alert("invalid file");
            }
        
       } else {
           preview.src = "";
           
       }
       file.value = "";
    //    send_picture_to_database(preview.src);
    //    console.log("hello");
       
  }
function callin(poas){
  $('#select_file'+poas).trigger('click');
}

function send_picture_to_databaseall(){ 
    send_picture_to_database(1);
    send_picture_to_database(2);
    send_picture_to_database(3);
    send_picture_to_database(4);
    send_picture_to_database(5);
}

function delete_account() {
    var txt;
    var r = confirm("are you sure you want to delete this count");
    if (r == true) {
        $.post("../profile_page_files/delete_account.php",{
            delete: "my_account"
        },
        function(data,status){
            if (data == "account deleted"){
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
            }
        });
        window.alert("account Deleted");
    } else {
        window.alert("thought so\n\n\npussy");
    }
}


  