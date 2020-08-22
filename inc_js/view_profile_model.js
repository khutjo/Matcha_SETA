

function close_div(){
    var main_div = document.getElementById("main_container_div");
    document.body.removeChild(main_div);
}

function save_view(name){
    $.post("../connections_page_file/add_like_to_db.php",{
        save_view: name});
}
/* retrieves user's info from the server for the modal page */
function modal(name){
	request = mkObj();
	if (request)
	{
		request.onreadystatechange = function() {
			if (request.readyState == 4 && request.status == 200) {
				var info = JSON.parse(request.responseText);
                console.log(info);
                document.getElementById('profile_picture').setAttribute("src",info[0].profile_picture);
                document.getElementById('name_span').innerText = info[5].FirstName;
                document.getElementById('surname_span').innerText = info[5].LastName;
                document.getElementById('age').innerText = info.age;
                document.getElementById('gender_span').innerText = info.gender;
				document.getElementById('user_name').innerText = info.UserName;
                document.getElementById('profile_bio').innerText = decodeURI(info.biography);
                // if (info[6])
                    document.getElementById('location_tag').innerText = info.location;
				document.getElementById('fame_rating').innerText = info.fame_rating;			
				document.getElementById('alt_image0').setAttribute('src', info[1].profile_picture);
				document.getElementById('alt_image1').setAttribute('src', info[2].profile_picture);
				document.getElementById('alt_image2').setAttribute('src', info[3].profile_picture);
                document.getElementById('alt_image3').setAttribute('src', info[4].profile_picture);
                save_view(info.UserName);
			}
		}
		request.open("POST", "../modal/get_user_data.php", true);
		request.setRequestHeader("Content-Type", "application-x-www-urlencoded");
		request.send(name);
	}

}

/* retreives user interests */

function get_user_interests(name){
    var request = mkObj();
    console.log("name-" + name);
	if (request)
	{
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var info = JSON.parse(request.responseText);
                console.log(info);
                if (info.length == 0)
                    document.getElementById('interests_tags').innerHTML = "Has no interests:";
                else
                    for (var i = 0; i < info.length; i++){
                        document.getElementById('interests_tags').innerText += info[i].set_tag + ',';
                    }
                // save_view(info.UserName);
			}
		}
		request.open("POST", "../modal/get_user_interests.php", true);
		request.setRequestHeader("Content-Type", "application-x-www-urlencoded");
		request.send(name);
	}

}

function make_div(name){
    
    
    var div = document.createElement("div");
    div.setAttribute("id", "main_container_div");
    document.body.appendChild(div);
    
    var main_div = document.getElementById("main_container_div");
    var div = document.createElement("div");
    div.setAttribute("id", "info_container_div");
    div.setAttribute('class', 'text-center');
    main_div.appendChild(div);


    /* creates a button to close the modal page */
    var main_div = document.getElementById("info_container_div");
    var para = document.createElement("h1");
    para.setAttribute("id", "exit_button");
    para.innerHTML = "X";
    para.onclick = function() { // Note this is a function
        close_div()};
    main_div.appendChild(para);
    
    var line = document.createElement("h1");
    line.setAttribute("id", "user_name");
    line.innerHTML = "name";
    main_div.appendChild(line);       
    
    var line = document.createElement("hr");
    line.setAttribute("id", "draw_lines");
    main_div.appendChild(line);

    /* container for profile image and user details */
    var modal_body = document.createElement("div");
    modal_body.setAttribute("id", "modal_body");
    modal_body.setAttribute('class', 'text-left');
    modal_body.style.justifyContent = 'center';
    main_div.appendChild(modal_body);

    var profile_image = document.createElement("img");
    profile_image.setAttribute("id", "profile_picture");
    profile_image.setAttribute('class', 'img-circle');
    profile_image.setAttribute('height', '300px');
    profile_image.setAttribute('width', '300px');
    profile_image.setAttribute("src", "../media/resources/nopropic.png");
    profile_image.setAttribute("alt", name);
    modal_body.appendChild(profile_image);
    
    var user_details = document.createElement('div');
    user_details.setAttribute('id', 'user_details');
    modal_body.appendChild(user_details);

    var para = document.createElement("strong");
    para.setAttribute("id", "name");
	para.innerHTML = "Name:";
	user_details.appendChild(para);
	
    var para = document.createElement('span');
    para.setAttribute("id", "name_span");
    para.setAttribute('class', 'label-details');
    para.innerHTML = "Person's name";
	user_details.appendChild(para);
    user_details.appendChild(document.createElement('br'));

    var para = document.createElement("strong");
    para.setAttribute("id", "surname");
	para.innerHTML = "Surname:";
	user_details.appendChild(para);
	
    var para = document.createElement('span');
    para.setAttribute("id", "surname_span");
    para.setAttribute('class', 'label-details');
    para.innerHTML = "Person's surname";
	user_details.appendChild(para);
    user_details.appendChild(document.createElement('br'));


	var para = document.createElement("strong");
    para.setAttribute("id", "about_them");
	para.innerHTML = "About me:";
	user_details.appendChild(para);
	
    var para = document.createElement('span');
    para.setAttribute("id", "profile_bio");
    para.setAttribute('class', 'label-details');
    para.innerHTML = "This is me:";
	user_details.appendChild(para);
    user_details.appendChild(document.createElement('br'));

	var para = document.createElement("strong");
    para.setAttribute("id", "agetag");
    para.innerHTML = "Age:";
    user_details.appendChild(para);
    
    var para = document.createElement("span");
    para.setAttribute("id", "age");
    para.setAttribute('class', 'label-details');
    para.innerHTML = "Age:";
    user_details.appendChild(para);
    user_details.appendChild(document.createElement('br'));

    var para = document.createElement("strong");
    para.setAttribute("id", "gender");
    para.innerHTML = "Gender:";
    user_details.appendChild(para);
    
    var para = document.createElement("span");
    para.setAttribute("id", "gender_span");
    para.setAttribute('class', 'label-details');
    para.innerHTML = "Gender value:";
    user_details.appendChild(para);
    user_details.appendChild(document.createElement('br'));
	
	
	var para = document.createElement("strong");
    para.setAttribute("id", "fame_ratingtag");
    para.innerHTML = "Rating:";
    user_details.appendChild(para);
    
    var para = document.createElement("span");
    para.setAttribute("id", "fame_rating");
    para.setAttribute('class', 'label-details');
    para.innerHTML = "Has no rating";
    user_details.appendChild(para);
    user_details.appendChild(document.createElement('br'));

    var para = document.createElement("strong");
    para.setAttribute("id", "interests_label");
    para.innerHTML = "Interest:";
    user_details.appendChild(para);
    
    var para = document.createElement("span");
    para.setAttribute("id", "interests_tags");
    para.setAttribute('class', 'label-details');
	user_details.appendChild(para);
    user_details.appendChild(document.createElement('br'));
    
    var para = document.createElement("strong");
    para.setAttribute("id", "location_label");
    para.innerHTML = "Location:";
    user_details.appendChild(para);
    
    var para = document.createElement("span");
    para.setAttribute("id", "location_tag");
    para.setAttribute('class', 'label-details');
    para.innerHTML = "Not specified";
	user_details.appendChild(para);
    user_details.appendChild(document.createElement('br'));
    
    /* This div containers all the images of the user */
    var images_container = document.createElement("div");
    images_container.setAttribute("id", "images_container")
    main_div.appendChild(images_container);
    
    /* four images*/
	var image = document.createElement("img");
    image.setAttribute("id", "alt_image0");
    image.setAttribute("class", 'thumbnail-image img-thumbnail');
    image.setAttribute("src", "../media/resources/nopropic.png");
	image.setAttribute("alt", "name");
	images_container.appendChild(image);
	
	var image = document.createElement("img");
    image.setAttribute("id", "alt_image1");
    image.setAttribute("class", 'thumbnail-image img-thumbnail');
    image.setAttribute("src", "../media/resources/nopropic.png");
	image.setAttribute("alt", "name");
	images_container.appendChild(image);
	
	var image = document.createElement("img");
    image.setAttribute("id", "alt_image2");
    image.setAttribute("class", 'thumbnail-image img-thumbnail');
    image.setAttribute("src", "../media/resources/nopropic.png");
	image.setAttribute("alt", "name");
    images_container.appendChild(image);
	
	var image = document.createElement("img");
    image.setAttribute("id", "alt_image3");
    image.setAttribute("class", 'thumbnail-image img-thumbnail');
    image.setAttribute("src", "../media/resources/nopropic.png");
	image.setAttribute("alt", "name");
	images_container.appendChild(image);
    
    /* var line = document.createElement("hr");
    line.setAttribute("id", "draw_lines_full");
    main_div.appendChild(line);
    */
   var modal_footer = document.createElement("div");
   modal_footer.setAttribute("class", 'modal-footer');
   main_div.appendChild(modal_footer);
   
   var like_btn = document.createElement('button');
   like_btn.setAttribute('class', 'btn btn-primary btn-lg');
   like_btn.innerHTML = "Like";
   modal_footer.appendChild(like_btn);
   
   /* sends like request when clicked */
   like_btn.onclick = function() { // Note this is a function
    like_by_kerane(name);
};


}

/* Sends a like request */
function like_by_kerane(name)
{
    $.post("../connections_page_file/add_like_to_db.php",
    {like_account: name}
    );
}
/*  */
function get_profile_view(name){
    make_div(name);
    modal(name);
    get_user_interests(name);
}