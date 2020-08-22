function delete_notification(notice_id){
    $.post("../pages/notification.php",{
        Delete_notice: notice_id
    },
    function(data,status){
        console.log(data)
        location.reload()
    });
}

function make_profile_div_boxes(count){
        
    var con_div = document.getElementById("profiles_get");
    var newDiv = document.createElement("div");
    newDiv.setAttribute("class", "row");
    newDiv.setAttribute("id", "box1_divl"+count);
    con_div.appendChild(newDiv);
    
    var con_div = document.getElementById("box1_divl"+count);
    var newDiv = document.createElement("div");
    newDiv.setAttribute("class", "col-sm-4");
    newDiv.setAttribute("id", "box2_divl"+count);
    con_div.appendChild(newDiv);
    
    var con_div = document.getElementById("box2_divl"+count);
    var newDiv = document.createElement("div");
    newDiv.setAttribute("class", "well");
    newDiv.setAttribute("id", "box3_divl"+count);
    con_div.appendChild(newDiv);
    
    var con_div = document.getElementById("box1_divl"+count);
    var newDiv = document.createElement("div");
    newDiv.setAttribute("class", "col-sm-8");
    newDiv.setAttribute("id", "box2_divlb"+count);
    con_div.appendChild(newDiv);
    
    var con_div = document.getElementById("box2_divlb"+count);
    var newDiv = document.createElement("div");
    newDiv.setAttribute("class", "well");
    newDiv.setAttribute("id", "box3_divlb"+count);
    con_div.appendChild(newDiv);
    
}

function add_profile_data(name, propic, age, bio, notification, notice_id, count) {
        
    var con_div = document.getElementById("box3_divl"+count);
    var para = document.createElement("p");
    para.setAttribute("id", "user"+count);
    para.innerHTML = name;
    con_div.appendChild(para);
    
    var x = document.createElement("IMG");
    x.setAttribute("class", "img-circle");
    x.setAttribute("id", "profile"+count);
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

    bio = decodeURI(bio);
    var con_div = document.getElementById("box3_divlb"+count);
    var para = document.createElement("p");
    para.innerHTML = "AGE: "+age;
    con_div.appendChild(para);
    
    var para = document.createElement("p");
    para.innerHTML = "ABOUT: "  + bio;
    con_div.appendChild(para);
    pre_name = name;

    var para = document.createElement("p");
    para.innerHTML = "NOTIFICATION: "  + notification;
    con_div.appendChild(para);
    pre_name = name;
    // console.log([keep_count]);

    
    var butt = document.createElement("button");
    butt.setAttribute("class", "btn btn-danger");
    butt.setAttribute("id", "notice_id"+notice_id);
    butt.onclick = function(){
        delete_notification(notice_id);
        // modal(name);
    };
    var text = document.createTextNode("Delete");
    butt.appendChild(text);
    con_div.appendChild(butt);

}



function get_notification(){
    $.post("../pages/notification.php",{
        notification: "get_full_notification"
    },
    function(data,status){
        if (data == "nothing")
        console.log("hello i got nothing")
        else{
            count = 0;
            notification = JSON.parse(data)
            notification.forEach(element => {
                make_profile_div_boxes(count);
                add_profile_data(element[0], element[3], element[4], decodeURI(element[5]), element[1], element[2], count);
                count++
            });
        }
    });
}

(function(){
    function get_connections(){
        get_notification();
    }
window.addEventListener('load', get_connections, false);
})();