<?php

include "connect.php";

class search_for extends connect {

    function sort_by($what){
        if ($what == "age"){
            return (" ORDER BY `accounts_bio`.age ASC");
        }else if ($what == "fame_rating"){
            return (" ORDER BY `accounts_bio`.fame_rating ASC");
        }
        return("");
    }

    function age_gap($of){
        if ($of == 1){
            return(" AND `accounts_bio`.age > 17 AND `accounts_bio`.age < 30");
        }else if ($of == 2){
            return(" AND `accounts_bio`.age > 29 AND `accounts_bio`.age < 40");
        }else if ($of == 3){
            return(" AND `accounts_bio`.age > 39 AND `accounts_bio`.age < 50");
        }else if ($of == 4){
            return(" AND `accounts_bio`.age > 49 AND `accounts_bio`.age <60");
        }else if ($of == 5){
            return(" AND `accounts_bio`.age > 59");
        }
        return("");
    }

    function fame_rating($of){
        if ($of == 1){
            return(" AND `accounts_bio`.fame_rating < 21");
        }else if ($of == 2){
            return(" AND `accounts_bio`.fame_rating > 20 AND `accounts_bio`.fame_rating < 61");
        }else if ($of == 3){
            return(" AND `accounts_bio`.fame_rating > 60 AND `accounts_bio`.fame_rating < 100");
        }else if ($of == 4){
            return(" AND `accounts_bio`.fame_rating > 99");
        }
        return("");
    }

    function add_tags($tag){
        $str = "";
        $num = 0;
        $max = sizeof($tag);
        while ($num < 14 && $num < $max){
            if ($tag[$num] == 1){
                $str = $str." AND `my_tags`.set_tag = 'sports'";
            }if ($tag[$num] == 2){
                $str = $str." AND `my_tags`.set_tag = 'coding'";
            }if ($tag[$num] == 3){
                $str = $str." AND `my_tags`.set_tag = 'cars'";
            }if ($tag[$num] == 4){
                $str = $str." AND `my_tags`.set_tag = 'guns'";
            }if ($tag[$num] == 5){
                $str = $str." AND `my_tags`.set_tag = 'movies'";
            }if ($tag[$num] == 6){
                $str = $str." AND `my_tags`.set_tag = 'music'";
            }if ($tag[$num] == 7){
                $str = $str." AND `my_tags`.set_tag = 'games'";
            }if ($tag[$num] == 8){
                $str = $str." AND `my_tags`.set_tag = 'pc muster_race'";
            }if ($tag[$num] == 9){
                $str = $str." AND `my_tags`.set_tag = 'console_peasent'";
            }if ($tag[$num] == 10){
                $str = $str." AND `my_tags`.set_tag = 'gold diggers'";
            }if ($tag[$num] == 11){
                $str = $str." AND `my_tags`.set_tag = 'hit and run'";
            }if ($tag[$num] == 12){
                $str = $str." AND `my_tags`.set_tag = 'one night stand'";
            }if ($tag[$num] == 13){
                $str = $str." AND `my_tags`.set_tag = 'dancing'";
            }
            $num++;
        }
        return $str;
    }

    function get_my_prefrance($user){
        $sql = "SELECT preferences, gender FROM accounts_bio WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user]);
        $my_pref = $stmt->fetch();
        return (" AND 'accounts_bio'.gender = '".$my_pref["preferences"].
        "' AND 'accounts_bio'.preferences = '".$my_pref['gender']."'");
    }

    function get_search_results($user, $order_by, $age_gap, $famerating, $by_tags){
        $my_pref = $this->get_my_prefrance($user);
        $my_fame = $this->fame_rating($famerating);
        $order = $this->sort_by($order_by);
        $age = $this->age_gap($age_gap);
        $my_tags = $this->add_tags($by_tags);
        $sql = "SELECT accounts_bio.UserName, accounts_bio.age, accounts_bio.fame_rating, accounts_bio.preferences, accounts_bio.gender, location.lat, location.lon,
         accounts_bio.biography FROM `accounts_basic`
        LEFT JOIN accounts_bio ON `accounts_basic`.UserName = `accounts_bio`.UserName
        LEFT JOIN `images` ON `accounts_bio`.UserName = `images`.UserName
        LEFT JOIN `location` ON `images`.UserName = `location`.UserName
        LEFT JOIN `my_tags` ON `images`.UserName = `my_tags`.UserName
        WHERE accounts_basic.UserName NOT IN (?) AND`images`.set_id = 1".$my_tags.$my_fame.$age.$order;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user]);
        return ($stmt->fetchAll());
        // return $sql;
        // return $my_tags;
    }

    function get_my_pic($user){
        $sql = "SELECT profile_picture FROM `images`
        WHERE UserName = ? AND set_id = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user]);
        return ($stmt->fetch());
    }

    function get_my_location($user){
        $sql = "SELECT lat, lon FROM `location` WHERE UserName = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user]);
        return ($stmt->fetch());
        // echo "hello";
    }
}
