
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

make_profile_div_boxes(0);
add_profile_data("geoffree", "fuck that", "24", "im pickle rick", 0);