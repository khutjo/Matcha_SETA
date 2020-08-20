    function get_my_tags(){
        var print_p = document.getElementById("show_my_tags");
        $.post("../profile_page_files/interest_tags.php",{
            get_my_tags: "get"
        //   alert("blabla");
            },function(data,status){
                // data = decodeURI(data);
                print_p.innerHTML = data;
                
                // window.alert(dec);
                // if (data == text+"removed"){
                //     but.style.background = "red";
                // }else {
                //     but.style.background = "initial";
                // }
        });
    }

    function get_this(text){
        $.post("../profile_page_files/interest_tags.php",{
            set_db_tag: text
        //   alert("blabla");
            },function(data,status){
                // window.alert(data);
                get_my_tags();
                // if (data == text+"removed"){
                //     but.style.background = "red";
                // }else {
                //     but.style.background = "initial";
                // }
        });
    }

   function add(name) {
        //Create an input type dynamically.   
        var element = document.createElement("input");
        //Assign different attributes to the element. 
        element.type = "button";
        element.value = name; // Really? You want the default value to be the type string?
        // element.name = type; // And the name too?
        element.setAttribute("class", "btn btn-primary");
        element.setAttribute("id", name);
        element.onclick = function() { // Note this is a function
            get_this(name);
        };
      
        var foo = document.getElementById("fooBar");
        //Append the element in page (in span).  
        foo.appendChild(element);
      }
  
      function safe_place(i){
          $.post("../profile_page_files/interest_tags.php",{
                get_tag_name: i
            },function(data,status){
                add(data);
                });
      }

  (function(){
    function startup(){
        var i = 0;

        $.post("../profile_page_files/interest_tags.php",{
            set_tag: "tag"
        },
        function(data,status){
            var num = data;
       
        while (i < num){
            safe_place(i);
            i++;
        }
     });
     get_my_tags();
    };
    window.addEventListener('load', startup, false);
    })();



   


    //   document.getElementById("btnAdd").onclick = function() {
    //     add("text");
    //   };



