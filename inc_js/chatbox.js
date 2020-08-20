function getliked(){
    $.post("../chat_page_files/my_connections.php",{
        get_caht: "get"
    },
    function(data,status){
        // get_profile_picture.src = deshilegsjkb.dsvbkhfjgata;
        window.alert(data);
    });
}