// $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
//   console.log(JSON.stringify(data, null, 2));

//     $.post("../profile_page_files/set_user_location.php",{
//         user_info: data
//     },
//     function(data,status){
//         console.log(data)
//     });
// })
function send(data){
    $.post("../profile_page_files/set_user_location.php",{
        user_info: data
    },
    function(data,status){
        console.log(data)
        
    });
}
function i_asked_kindly(){

    $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
            console.log(JSON.stringify(data, null, 2));
            send(data)
              
          }).fail(function() { send("") });
}

function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, i_asked_kindly);
    } else { 
        i_asked_kindly()
    }
  }
  function showPosition(data) {
    send(data)
  }

  function setCookie() {
    var time = new Date();
    time.setTime(time.getTime() + (30*60*1000));
    var timestamp = time.toUTCString();
    document.cookie = "Matcha=location;expires=" +timestamp+ ";path=/";
  }
  

  function getCookie() {
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf("Matcha=") == 0) {
        return true;
      }
    }
    return false;
  }


  (function(){
    function startup(){
      if(!getCookie()){
          getLocation();
          setCookie();
      }
    }
window.addEventListener('load', startup, false);
})();



function initMap() {


  const input = document.getElementById("my_location");
  const autocomplete = new google.maps.places.Autocomplete(input);

        // autocomplete.setTypes("address");
  autocomplete.addListener("place_changed", () => {


    const place = autocomplete.getPlace();

    if (!place.geometry) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    console.log(place.geometry.viewport.Va.i.toString())
    console.log(place.geometry.viewport.Za.i.toString())
    console.log(place.formatted_address)
    
    console.log(place)
    var address = place.formatted_address
    var city = place.address_components[4].long_name
    var street = place.address_components[1].long_name
    var country = place.address_components[6].long_name
    var latitude = place.geometry.viewport.Va.i.toString()
    var longitude = place.geometry.viewport.Za.i.toString()

    var data = {
      address:address,
      city:city,
      street:street,
      country:country,
      latitude:latitude,
      longitude:longitude
    }

    send(data)
  });


  }