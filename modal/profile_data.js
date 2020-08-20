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

function modal(name){
	request = mkObj();
	if (request)
	{
		request.onreadystatechange = function() {
			if (request.readyState == 4 && request.status == 200) {
				alert(JSON.parse(request.responseText));
				var info = JSON.parse(request.responseText);
				document.getElementById('profile_picture').setAttribute('src',info.profile_picture);
				document.getElementById('user_name').innerText = info.UserName;
				document.getElementById('profile_bio').innerText = info.biography;
				document.getElementById('fame_rating').innerText = info.fame_rating;
				document.getElementById
			}
		}
		request.open("POST", "get_user_data.php", true);
		request.setRequestHeader("Content-Type", "application-x-www-urlencoded");
		request.send(name);
	}

}

function just(name){
	window.alert(name);
}
