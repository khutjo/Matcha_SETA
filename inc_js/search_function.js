age_gap = 0;
famerating_gap = 0;
tags = "";
order_by = "";
no_dis = 0;
keep_count = 0;
max_profiles = 0;
profiles = "";
missed_runs = 0;
pre_name = "";

function delete_divs(){
    var i = 0;
    while (i < keep_count){
    var pTarget = document.getElementById("box1_divl"+i);
    var cTarget = document.getElementById("profiles_get");
    // var tr = cTarget.parentNode.parentNode;
    if (pTarget){
        cTarget.removeChild(pTarget);
    }
        //   ctr = ctr - 1;
        i++;
    }
keep_count = 0;
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

function add_pictures(name, count, data){
    var con_div = document.getElementById("box3_divl"+count);
    var x = document.createElement("IMG");
    x.setAttribute("class", "img-circle");
    x.setAttribute("id", "profile"+count);
    x.setAttribute("src", data);
    x.setAttribute("width", "100");
    x.setAttribute("height", "100");
    x.setAttribute("alt", name);
    x.setAttribute("style:borderColor", "#00FF00");
    x.onclick = function(){
        get_profile_view(name);
        // modal(name);
    };
    con_div.appendChild(x);
}

function get_pictures(name, count){
    $.post("../search_page_files/set_search_params.php",{
        get_x_picture: name
    },
    function(data,status){
        var datas = JSON.parse(data);
        // console.log(data);
        add_pictures(name, count, datas["profile_picture"]);
    });
}

function add_profile_data(name, propic, bio, age, gender, preferences, fame, dis, count) {
    
    var con_div = document.getElementById("box3_divl"+count);
    var para = document.createElement("p");
    para.setAttribute("id", "user"+count);
    para.innerHTML = name;
    con_div.appendChild(para);
    
    // var x = document.createElement("IMG");
    // x.setAttribute("class", "img-circle");
    // x.setAttribute("id", "profile"+count);
    // x.setAttribute("src", "../media/resources/nopropic.png");
    // x.setAttribute("width", "100");
    // x.setAttribute("height", "100");
    // x.setAttribute("alt", name);
    // x.setAttribute("style:borderColor", "#00FF00");
    // x.onclick = function(){
    //     get_profile_view(name);
    //     // modal(name);
    // };
    // con_div.appendChild(x);
    
    bio = decodeURI(bio);
    var con_div = document.getElementById("box3_divlb"+count);
    var para = document.createElement("p");
    para.innerHTML = "AGE: "+age;
    con_div.appendChild(para);

    var para = document.createElement("p");
    para.innerHTML = "GENDER: "+gender;
    con_div.appendChild(para);

    var para = document.createElement("p");
    para.innerHTML = "PREFERANCE: "+preferences;
    con_div.appendChild(para);
    
    var para = document.createElement("p");
    para.innerHTML = "FAME-RATING: "+fame;
    con_div.appendChild(para);
    // pre_name = name;

    // str = dis.split(".");
    var para = document.createElement("p");
    para.innerHTML = "DISTANCE: "+dis+" KM";
    con_div.appendChild(para);
    pre_name = name;
    get_pictures(name, count);
}

function are_they_blocked(name, propic, bio, age, gender, preferences, fame, dis, count, i){
    
    $.post("../connections_page_file/check_block_list.php",{
        cheack_block_list: name
    },
    function(data,status){
        if (data == "your_good" && name != pre_name){
            make_profile_div_boxes(count);
            add_profile_data(name, propic, bio, age, gender, preferences, fame, dis, count);
        }else {
            missed_runs++;
        }
        if (i == 5 && missed_runs > 0){
            // console.log(i + " try " + missed_runs+" "+ keep_count+" "+max_profiles);
            get_profile_data(missed_runs);
        }
    });
}

function get_profile_data(max){
    // profiles = data;
    missed_runs = 0;
    var i = 0;
    if (max == 0){
        max = 6;
    }
    while (keep_count < max_profiles){
        are_they_blocked(profiles[keep_count]["UserName"], profiles[keep_count]["profile_picture"],
        profiles[keep_count]["biography"], profiles[keep_count]["age"], profiles[keep_count]["gender"], 
        profiles[keep_count]["preferences"], profiles[keep_count]["fame_rating"], profiles[keep_count]["distance"], keep_count, i);
        i++;
        keep_count++;
    }
}

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

function clear_all_but_this_age(twenty){
    var i = 1;
    while (i < 6){
        if (i != twenty){
            // window.alert(i);
            document.getElementById("checkbox_age_"+i).checked = false;
        }
        i++;
    }
}

function clear_all_but_this_rating(a_hanit){
    var i = 1;
    while (i < 5){
        if (i != a_hanit){
            // window.alert(i);
            document.getElementById("checkbox_famerating_"+i).checked = false;
        }
        i++;
    }
}

function clear_all_but_distance(miles){
    var i = 1;
    while (i < 4){
        if (i != miles){
            // window.alert(i);
            document.getElementById("checkbox_distance_"+i).checked = false;
        }
        i++;
    }
}

function search_for_distance(old){
    if (old < 5 || old > 1){
        no_dis = old;
        clear_all_but_distance(old);
    }
}

function del_all_search(){
    delete_divs();
    keep_count = 0;
    max_profiles = 0;
    var i = 1;
    while (i < 14){
        var FIND_THIS = document.getElementById("checkbox_tags_"+i).checked = false;
        i++;
    }
    clear_all_but_distance(0);
    clear_all_but_this_rating(0);
    clear_all_but_this_age(0);
    no_dis = 0;
    age_gap = 0;
    famerating_gap = 0;
    tags = "";
    order_by = "";
}


function search_for_age(old){
    if (old < 5 || old > 1){
        age_gap = old;
        clear_all_but_this_age(old);
    }
}

function search_for_famerating(famous){
    if (famous < 4 || famous > 1){
        famerating_gap = famous;
        clear_all_but_this_rating(famous);
    }
}

function search_for_tag(num) {
    tags = "";
    var i = 1;
    while (i < 14){
        var FIND_THIS = document.getElementById("checkbox_tags_"+i);
        if(FIND_THIS.checked == true){
            tags = tags+"="+i;
        }
        i++;
    }
}

function order(what){
    order_by = what;
}

function no_results(){
    var con_div = document.getElementById("profiles_get");
    var para = document.createElement("p");
    para.innerHTML = "No Search Results";
    para.setAttribute("id", "box1_div0");
    con_div.appendChild(para);
    keep_count = 1;
}

function sort_by_location (){
    var swap;
    var i = 0;
    var end = max_profiles - 1;
    while (i < end){
        if (profiles[i]["distance"] > profiles[1 + i]["distance"]){
            swap = profiles[i]["distance"];
            profiles[i]["distance"] = profiles[1 + i]["distance"];
            profiles[1 + i]["distance"] = swap;
            // console.log(profiles[i]);
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
        // console.log(profiles);
        // console.log(get_distance(datas, d_b));
        while (i < max_profiles){
            profiles[i]["distance"] = get_distance(datas, profiles[i]);
            
            i++;
        }
        if (order_by == "location"){
            sort_by_location();
        }
        // console.log(datas);
        // console.log("lat = "+datas["lat"]); 
        // console.log("lon = "+datas["lon"]);   
        // alert(data);
        get_profile_data(0);
    });
}

function search_for_this(){
    send = " "+age_gap+" "+famerating_gap+" "+tags+" "+order_by;
    delete_divs();
    request = mkObj();
	if (request)
	{
		request.onreadystatechange = function() {
			if (request.readyState == 4 && request.status == 200) {
				// alert(request.responseText);
                    var info = JSON.parse(request.responseText);
                    profiles = info;
                    max_profiles = info.length;
                    // console.log(info);

                    if (max_profiles == 0){
                        no_results();
                    }
                    get_my_location();
                // console.log(info);
                // console.log(info.length);
			}
		}
		request.open("POST", "../search_page_files/set_search_params.php", true);
		request.setRequestHeader("Content-Type", "application-x-www-urlencoded");
		request.send(send);
	}
}




