<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	
	<div class="container">
	<br>
	<!-- bundle into an image thing via server side for gallery -->
	<!-- profile card -->
	<div class="card" style="width:300px">
		<img class="card-img-top" width="300px" height="300px" src="assets/pp.jpeg" alt="an image that the user set as a profile picture">
		<div class="card-body">
			<h4 class="card-title">uname</h4>
			<p class="card-text">bio</p>
			<a href="#" class="btn btn-primary">view profile</a>
			<a href="#" class="btn btn-primary">like</a>
			<!-- ?geolocation -->
			<p id="city"></p>
		</div>
	</div>
	</div>

<!-- ?geolocation --><p id="city"></p>
<p>location should pop unpack</p>
<script
  src="https://code.jquery.com/jquery-1.9.1.js"></script>

<!-- <script src="src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
	<!-- <script src="../jquery-1.9.1.min.js"></script> -->
	<script>
       $.get("https://ipinfo.io/", function(response) {
		   // $("#city").append(response.loc);
		   console.log(response);
           alert(response.city);
       }, "jsonp")
   </script>
</body>
</html>