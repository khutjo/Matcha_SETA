in_count = 0;

{/* <div class="row">
            <div class="col-sm-3">
                <div class="well">
                    <p id="profile_username_1"></p>
                    <img id="profile_pic_1" src="" class="img-circle" height="55" width="55" alt="Avatar">
                </div>
            </div>
            <div class="col-sm-9">
                <div class="well">
                    <p id="profile_bio_1"></p>
                </div>
            </div>
        </div> */}


        function accept_like_request(name){
            $.post("../connections_page_file/my_connections.php",{
                accept_request: name
            // },
            // function(data,status){
                // window.alert(data);
            });
            mid();
            check_like();
        }

        function reject_like_request(name){
            $.post("../connections_page_file/my_connections.php",{
                reject_request: name
            // },
            // function(data,status){
                // window.alert(data);
            });
            check_like();
        }

    function make_div_boxes(){
        
        var con_div = document.getElementById("likes_container_div");
        var newDiv = document.createElement("div");
        newDiv.setAttribute("class", "row");
        newDiv.setAttribute("id", "box1_divl"+in_count);
        con_div.appendChild(newDiv);

        var con_div = document.getElementById("box1_divl"+in_count);
        var newDiv = document.createElement("div");
        newDiv.setAttribute("class", "col-sm-4");
        newDiv.setAttribute("id", "box2_divl"+in_count);
        con_div.appendChild(newDiv);

        var con_div = document.getElementById("box2_divl"+in_count);
        var newDiv = document.createElement("div");
        newDiv.setAttribute("class", "well");
        newDiv.setAttribute("id", "box3_divl"+in_count);
        con_div.appendChild(newDiv);

        var con_div = document.getElementById("box1_divl"+in_count);
        var newDiv = document.createElement("div");
        newDiv.setAttribute("class", "col-sm-8");
        newDiv.setAttribute("id", "box2_divlb"+in_count);
        con_div.appendChild(newDiv);

        var con_div = document.getElementById("box2_divlb"+in_count);
        var newDiv = document.createElement("div");
        newDiv.setAttribute("class", "well");
        newDiv.setAttribute("id", "box3_divlb"+in_count);
        con_div.appendChild(newDiv);
    }

function make_bio(name, age, about, ration, user_id){

    var con_div = document.getElementById("box3_divlb"+user_id);
    var para = document.createElement("p");
    para.innerHTML = "AGE: "+age;
    con_div.appendChild(para);

    var para = document.createElement("p");
    para.innerHTML = "ABOUT "+name+": "+decodeURI(about);
    con_div.appendChild(para);

    var para = document.createElement("p");
    para.innerHTML = "FAME RATING: "+ration;
    con_div.appendChild(para);

}

function get_it(name, user_id){
    $.post("../connections_page_file/my_connections.php",{
        get_bio_data: name
    },
    function(data,status){
        profile = data.split("=");
        make_bio(name, profile[0], profile[1], profile[2], user_id);
    });
}

function add_like(name, propic){
    make_div_boxes();
    get_it(name, in_count);
    var con_div = document.getElementById("box3_divl"+in_count);
    var para = document.createElement("p");
    para.setAttribute("id", "user"+in_count);
    para.innerHTML = name;
    con_div.appendChild(para);

    var x = document.createElement("IMG");
    x.setAttribute("class", "img-circle");
    x.setAttribute("id", "profile"+in_count);
    x.setAttribute("src", propic);
    x.setAttribute("width", "100");
    x.setAttribute("height", "100");
    x.setAttribute("alt", name);
    x.setAttribute("style:borderColor", "#00FF00");
    x.onclick = function(){
        get_profile_view(name);
        // modal(name);
    };
    con_div.appendChild(x);
    

    var accept = document.createElement("input");
    accept .setAttribute("type", "button");
    accept .setAttribute("value", "Like Back");
    accept .setAttribute("class", "btn btn-primary");
    accept .setAttribute("id", "accept"+in_count);
    accept.onclick = function() { // Note this is a function
        // get_it(name);
        accept_like_request(name);
    };
    con_div.appendChild(accept);

    var accept = document.createElement("input");
    accept .setAttribute("type", "button");
    accept .setAttribute("value", "X");
    accept .setAttribute("class", "btn btn-danger");
    accept .setAttribute("id", "reject"+in_count);
    accept.onclick = function() { // Note this is a function
        reject_like_request(name);};
    con_div.appendChild(accept);
    
    in_count++;
}



function get_likes(user_id){
    var i = 0;
    while (i < user_id){
        $.post("../connections_page_file/my_connections.php",{
            get_like_picture: i
        },
        function(data,status){
            profile = data.split("=");
            add_like(profile[0], profile[1]);
        });
        i++;
    }
}


function clear_div(){
    var i = 0;
    while (i < in_count){
    var pTarget = document.getElementById("likes_container_div");
    var cTarget = document.getElementById("box1_divl"+i);
    // var tr = cTarget.parentNode.parentNode;
            pTarget.removeChild(cTarget);
        //   ctr = ctr - 1;
        i++;
    }
    in_count = 0;
}

function check_like(){
    var print_p = document.getElementById("show_requests");
    $.post("../connections_page_file/my_connections.php",{
        get_likes: "get"
    },
    function(data,status){
        if (data != in_count){
            clear_div();
            get_likes(data);
            // window.alert(data);
        }else if (data == 0){
            print_p.innerHTML = "No one likes you peasant, GO AND HANG YOURSELF";
        }
        // window.alert(data);
    });
}

(function(){
    function get_connections(){
        check_like();
    }
window.addEventListener('load', get_connections, false);
})();



setInterval(check_like, 3000);

