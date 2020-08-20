by_what=0;
profiles = "";
profile_avilable_count = 0;
missed_runs = 0;
pre_name = "";


function mkObj() {
	var obj;
	try{
		obj = new XMLHttpRequest();
	} catch(e){
		try{
			obj = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e){
				alert("your browser is weird");	
				return false;
			}			
		}
	}
	return (obj);
}



function set_color(para, i){
    if (i == 0){
        para.setAttribute("class", "label label-primary");
    }else if (i == 1){
        para.setAttribute("class", "label label-default");
        
    }else if (i == 2){
        para.setAttribute("class", "label label-success");
        
    }else if (i == 3){
        para.setAttribute("class", "label label-info");
        
    }else if (i == 4){
        para.setAttribute("class", "label label-warning");
        
    }else if (i == 5){
        para.setAttribute("class", "label label-danger");
        
    }
}

function make_br(){
    var con_div = document.getElementById("interest");
    var para = document.createElement("p");
    con_div.appendChild(para);
  
            }
    var mid = 0;
    function make_interest(tag, i){
        
        
        if (mid > 5){
            mid = 0;
        }
        
        // window.alert(mid);
        
        var con_div = document.getElementById("interest");
        var para = document.createElement("span");
        set_color(para, mid);
        para.innerHTML = tag;
        para.onclick = function() { // Note this is a function
            find_people_with_tag(tag);
        };
        con_div.appendChild(para);
        make_br();
        mid++;
    }
    
    function get_interest(in_id){
        $.post("../main_page_files/main_page_elements.php",{
            interest_num: in_id
        },
        function(data,status){
            // window.alert(data);
            make_interest(data, in_id);
        });
    }
    
    function get_my_interest(){
        $.post("../main_page_files/main_page_elements.php",{
            get_my_interest_num: "get"
        },
        function(data,status){
            // profile_bio = decodeURI(data);
            var i = 0;
            while (i < data){
                get_interest(i)
                i++;
            }
        });
    }
    keep_count = 0;
    profile_avilable_count = 0;
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
	
    function add_profile_data(name, propic, age, bio, count) {
        
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
        // console.log([keep_count]);
    }
    
    function are_they_blocked(name, propic, age, bio, count, i){
        $.post("../connections_page_file/check_block_list.php",{
            cheack_block_list: name
        },
        function(data,status){
            // console.log("in");
            if (data == "your_good" && pre_name != name){
            // console.log("in b");
            // window.alert("1b");
                make_profile_div_boxes(count);
                add_profile_data(name, propic, age, bio, count);
            }else {
                missed_runs++;
            }
            if (i == 5 && missed_runs > 0){
                get_profiles(missed_runs);
        // window.alert("3");
            }
        });
    }

    function get_profiles(max){
        var i = 0;
        // window.alert(profile_avilable_count);
        missed_runs = 0;
        var i = 0;
        if (max == 0){
            max = 6;
        }
        // window.alert("4");
        while (keep_count < profile_avilable_count && i < max){
            // window.alert("h");
            are_they_blocked(profiles[keep_count]["UserName"], profiles[keep_count]["profile_picture"]
            , profiles[keep_count]["age"], profiles[keep_count]["biography"], keep_count, i);
            i++;
            keep_count++;
        }
        
    }
    
    function mid_way(){
        request = mkObj();
        if (request)
        {
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    // alert(request.responseText);
                        var info = JSON.parse(request.responseText);
                        console.log(info);
                        profiles = info;
                        profile_avilable_count = info.length;
                        get_profiles(0);
                }
            }
            request.open("POST", "../main_page_files/main_page_elements.php", true);
            request.setRequestHeader("Content-Type", "application-x-www-urlencoded");
            request.send("get_profile_basic="+by_what);
        }
    }

    (function(){
        function startup(){///change this
            var my_profile_pictiure = document.getElementById("profile_pic");
            get_my_interest();
            $.post("../main_page_files/main_page_elements.php",{
                get_my_pic: "get"
            },
            function(data,status){
                my_profile_pictiure.src = data;
            });
            mid_way();
            // get_profile_view("AlekMay");
        };
        window.addEventListener('load', startup, false);
    })();
    
    $(window).scroll(function(){
        if ($(window).scrollTop() == $(document).height()-$(window).height()){
            get_profiles(0);
        }
    });

function delete_divs(){
    var i = 0;
    while (i < keep_count){
    var pTarget = document.getElementById("box1_divl"+i);
    var cTarget = document.getElementById("profiles_get");
        cTarget.removeChild(pTarget);
        i++;
    }
keep_count = 0;
}


function sort_by_location (){
    var swap;
    var i = 0;
    var end = profile_avilable_count - 1;
    while (i < end){
        if (profiles[i]["distance"] > profiles[1 + i]["distance"]){
            swap = profiles[i]["distance"];
            profiles[i]["distance"] = profiles[1 + i]["distance"];
            profiles[1 + i]["distance"] = swap;
            console.log(profiles[i]);
            i = -1;
        }
        i++;
    }
}

function get_distance(point_a, point_b)
{
	var R = 6371 * Math.pow(10,3);
	var lat1 = Number(point_a.lat)  * (Math.PI / 180);
	var lat2 = Number(point_b.lat) * (Math.PI / 180);
	var lon1 = Number(point_a.lon) * (Math.PI / 180);
	var lon2 = Number(point_b.lon)  * (Math.PI / 180);
	var latdiff = (lat2 - lat1);
	var londiff = (lon2 - lon1);
	
	var a = Math.sin(latdiff / 2) * Math.sin(latdiff / 2) + 
	Math.cos(lat1) * Math.cos(lat2) * Math.sin(londiff / 2) *
	Math.sin(londiff / 2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
	var	d = R * c;
	return (Number(d/1000));
		// console.log(d/1000);
}

function get_my_location(){
    var i = 0;
    $.post("../search_page_files/set_search_params.php",{
        get_my_location: "get"
    },
    function(data,status){
        var datas = JSON.parse(data);
        var i = 0;
        
        console.log(datas);
        // console.log(get_distance(datas, d_b));
        while (i < profile_avilable_count){
            profiles[i]["distance"] = get_distance(datas, profiles[i]);
            
            i++;
        }
            sort_by_location();
        get_profiles(0);
    });
}

function filter(num){
    by_what=num;
    pre_name = "";
    if (num != 2){
    delete_divs();
    mid_way();
    }else if (num == 2) {
        delete_divs();
        get_my_location()
    }
    // window.alert(by_what);
}

function find_people_with_tag(tag){
    by_what=tag;
    delete_divs();
    mid_way();
}

