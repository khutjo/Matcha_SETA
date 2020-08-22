<?php 
include "../config/profile_classes.php";
session_start();
    $data = urldecode(file_get_contents('php://input'));
    // echo im in
    $where_from  = "user_set";
    function location_received ($data, &$where_from){
        $temp = explode("&", $data);
        foreach($temp as $tval) {
            $t = explode(']=', $tval);
            if (strpos($t[0], "user_info[coords][") === 0){
                $t[0] = str_replace("user_info[coords][","",$t[0]);
                $where_from  = "html";
            }else if (strpos($t[0], "[user_info[geobytes") === 0){
                $t[0] = str_replace("user_info[geobytes","",$t[0]);
                $where_from  = "geobytes";
            }else {
                $t[0] = str_replace("user_info[","",$t[0]);
            }
            $output[$t[0]] = $t[1];
        }
        return $output;
    }
    // "user_info[address]=639 Lonsdale St, Melbourne VIC 3000, Australia&user_info[city][long_name]=Victoria&user_info[city][short_name]=VIC&user_info[city][types][]=administrative_area_level_1&user_info[city][types][]=political&user_info[street][long_name]=Lonsdale Street&user_info[street][short_name]=Lonsdale St&user_info[street][types][]=route&user_info[country][long_name]=3000&user_info[country][short_name]=3000&user_info[country][types][]=postal_code&user_info[latitude]=144.9518964697085&user_info[longitude]=-37.8163239302915"
    
    
    $set_locaton = new location_info($dsn, $user, $password, $_SESSION["logged_in_user"]);
    
    if ("user_info=" != $data){
        var_dump($data);
        $data = location_received($data, $where_from);
        var_dump($data);
        if ($where_from == "html")
            $set_locaton->set_current_location_html($_SESSION["logged_in_user"],$data);
        else if ($where_from == "geobytes")
            $set_locaton->set_current_location_geobytes($_SESSION["logged_in_user"],$data);
        else if ($where_from == "user_set")
            $set_locaton->user_set_location($_SESSION["logged_in_user"],$data);
    }
    // else{
    //     echo 'fuck you';
    //     $set_locaton->set_current_location($_SESSION["logged_in_user"],$data);

 
    // }
//     header("Location: ../index.php");

?>