


  function block_this_person(name){
    $.post("../connections_page_file/my_connections.php",{
        block_x_account: name});
        hold_num_of_connections = -1
  }

count = -1;
  function add_box(){

    // var con_div = document.getElementById("main_div");
    // var newDiv = document.createElement("div");
    // // newDiv.setAttribute("class", "row");
    // newDiv.setAttribute("id","container_div");
    // con_div.appendChild(newDiv);




  }

  function check_block_status(name, i){
    $.post("../connections_page_file/check_block_list.php",{
        check_block_list: name
    },
    function(data,status){
        if (data == "your_good"){
            document.getElementById("blocked"+i).setAttribute("value", "block"); 
        }else {
            document.getElementById("blocked"+i).setAttribute("value", "unblock"); 
        }
    });
  }


  function unlike_and_block(i, name){
    var con_div = document.getElementById("main_div");

   
    var unlike = document.createElement("input");
    unlike .setAttribute("type", "button");
    unlike .setAttribute("value", "unlike");
    unlike .setAttribute("class", "btn btn-primary");
    unlike .setAttribute("id", "unlike"+i);
    unlike.onclick = function() { // Note this is a function
        unlike_this_person(name);
    };
    con_div.appendChild(unlike);

    var block = document.createElement("input");
    block.setAttribute("type", "button");
    block.setAttribute("class", "btn btn-danger");
    block.setAttribute("id", "blocked"+i);
    block.onclick = function() { // Note this is a function
        block_this_person(name);
    };
    con_div.appendChild(block);
    check_block_status(name, i);
  }
  


  function add(name, propic) {
    add_box();
    var con_div = document.getElementById("main_div");
   var para = document.createElement("p");
    para.setAttribute("id", "user"+count);
    con_div.appendChild(para);
    document.getElementById("user"+count).innerHTML = name;
    
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
    unlike_and_block(count, name)
    // show_login_status("offline", count);
    // get_login_status(name, count)
    count++;
  }


function get_conns(num){
    var i = 0;
    var profile;
    while (i < num){
        $.post("../connections_page_file/my_connections.php",{
            get_conn_data: i
        },
        function(data,status){
            profile = data.split("=");
            add(profile[0], profile[1]);
        });
        // just_show(name, propic);
        i++;
    }
    
}

hold_num_of_connections = 0;

function del_div(){

    var i = 0;
    while (i < hold_num_of_connections){
    var pTarget = document.getElementById("container_div");
    var cTarget = document.getElementById("main_div");
    // var tr = cTarget.parentNode.parentNode;
            cTarget.removeChild(pTarget);
        //   ctr = ctr - 1;
        i++;
    }
    count = 0;
}


function mid(){
    var num_of_conns;
    var print_p = document.getElementById("showme");
    $.post("../connections_page_file/my_connections.php",{
        get_conns: "get"
    },
    function(data,status){
		num_of_conns = data;
		// console.log(data);
        if (hold_num_of_connections != num_of_conns && num_of_conns > 0){
			del_div();
			print_p.innerHTML = "";
            hold_num_of_connections = num_of_conns;
            get_conns(num_of_conns);
        }else if (num_of_conns == 0){
            print_p.innerHTML = "You Dont Have Connections";
            hold_num_of_connections = num_of_conns
            del_div();
        }
    });
    
}

(function(){
    function get_connections(){
        mid();
    }
window.addEventListener('load', get_connections, false);
})();



setInterval(mid, 3000);

function unlike_this_person(name){
    $.post("../connections_page_file/my_connections.php",{
        unlike_x_account: name});
    mid();
  }
  
