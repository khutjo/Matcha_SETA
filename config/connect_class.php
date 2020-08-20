<?php
  include  "connect.php";
  //include "../pages/notification.php";
  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

    class block_list_verify extends connect{

        function __construct ($dsn, $user, $password,$usr, $blocked){
            parent::__construct($dsn, $user, $password);
            $sql = "SELECT * FROM `block_list` WHERE blocker = ? AND blocked = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$usr, $blocked]);
            $blocked_db = $stmt->fetchALL();
            if ($blocked_db){
                echo "hard_luck",$usr,"=",$blocked," ";
                print_r($blocked_db);
            }else{
                // print_r($blocked_db);
                echo "your_good";
            }
        }
    }


    class add_like_to_db extends connect {

        function __construct ($dsn, $user, $password,$usr, $liked){
            parent::__construct($dsn, $user, $password);
            $sql = "SELECT have_pro_pic FROM `accounts_bio` WHERE UserName = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$usr]);
            $check_propics = $stmt->fetch();
            $sql = "SELECT * FROM `people_you_like` WHERE UserName = ? AND liked = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$usr, $liked]);
            $likes = $stmt->rowCount();
            $sql = "SELECT * FROM `people_you_like` WHERE UserName = ? AND liked = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$liked, $usr]);
            $likedd = $stmt->rowCount();
            if ($likedd > 0){
                $sql = "INSERT INTO `connections`(`user1`, `user2`) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$usr, $liked]);
                echo "hello";

                $sql = "DELETE FROM `people_you_like` WHERE liked=? AND UserName=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$usr, $liked]);

                echo "its_cool";
            }else if ($likes > 0){
                echo "your cool";
            }else{
                if ($check_propics["have_pro_pic"] == "true"){
                    $sql = "INSERT INTO `people_you_like`(`UserName`, `liked`) VALUES (?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([$usr, $liked]);
                    echo "heloo";
                    // insert function here 
                    // "liked" contain  viewed user name
                    $viewer_id = $_SESSION['id']; //liker's id
                    $viewer_name = $_SESSION['logged_in_user'];//liker's name
                    $message= "your profile was liked by $viewer_name";
                    $status ="unread";

                    $sql ="SELECT `ID` FROM `accounts_basic` WHERE `UserName`=?";
                    $check=  $this->conn->prepare($sql);
                    $check->execute([$liked]);
                    $result=$check->fetch(PDO::FETCH_ASSOC);
                
                    $viewed_id= $result['ID'];
                    insert2db($viewer_id,$viewed_id,$viewer_name,$message,$status);

                    echo "its_done";
                }
            }
        }
    }


    class liking_system extends connect {
        public $num;
        public $fnum;
        public $friends = array();
        public $profiles = array();

        function __construct ($dsn, $user, $password,$usr){
            parent::__construct($dsn, $user, $password);

            $sql = "SELECT * FROM `connections`
            LEFT JOIN `images` ON `connections`.user1 = `images`.UserName
            WHERE connections.user2=? AND images.set_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$usr, 1]);
            $hold = $stmt->fetchALL();
            // print_r($hold);
            if ($hold){
                $run = count($hold);
                $i = 0;
                while ($i < $run){
                    array_push($this->friends, $hold[$i]);
                    $i++;
                }
            }
            $sql = "SELECT *
            FROM `connections`
            LEFT JOIN `images` ON `connections`.user2 = `images`.UserName
            WHERE connections.user1=? AND images.set_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$usr, 1]);
            $hold = $stmt->fetchALL();
            if ($hold){
                $run = count($hold);
                $i = 0;
                while ($i < $run){
                    array_push($this->friends, $hold[$i]);
                    $i++;
                }

            }

            $this->fnum = count($this->friends);
    }

 

    function get_people_that_like_you($user){
        $sql = "SELECT * FROM `people_you_like`
        LEFT JOIN `images` ON `people_you_like`.UserName = `images`.UserName
        WHERE set_id=1 AND liked=?
        ORDER BY `people_you_like`.ID DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user]);
        $this->profiles = $stmt->fetchALL();
        $this->num = count($this->profiles);
      
    }

    function get_likes_bio($user){

        $sql = "SELECT * FROM `accounts_bio` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user]);
        $about = $stmt->fetch();
        echo $about["age"],"=",$about["biography"],"=",$about["fame_rating"];
    }

        function get_login_time($user){
            $sql = "SELECT last_login FROM accounts_basic WHERE UserName=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user]);
            $time = $stmt->fetch()[0];
            $time = (36000 + time()) - strtotime($time);
            if ($time < 10){
                return ("online");
            }else {
            return ("offline");
            }
        }

        function unlike_account($user, $unliked){
            echo "its_done";
            echo"<br/> kerane look here";
            $sqla = "DELETE FROM `connections` WHERE user1=? AND user2=?";
            $sqlb = "DELETE FROM `connections` WHERE user1=? AND user2=?";
            $stmt = $this->conn->prepare($sqla);
            $stmt->execute([$user, $unliked]);
            $stmt = $this->conn->prepare($sqlb);
            $stmt->execute([$unliked, $user]);

            $viewer_id = $_SESSION['id']; //acceptor id //must be ksambo id
            $viewer_name = $_SESSION['logged_in_user'];//liker's name
            $message= "your profile was unliked by $user";
            $status ="unread";

            $sql ="SELECT `ID` FROM `accounts_basic` WHERE `UserName`=?";
            $check=  $this->conn->prepare($sql);
            $check->execute([$unliked]);
            $result=$check->fetch(PDO::FETCH_ASSOC);  

            $viewed_id= $result['ID'];
            include "../pages/notification.php";
            insert2db($viewer_id,$viewed_id,$viewer_name,$message,$status);

            echo "its_done";
      
        }


        function block_account($blocker, $blocked){
            $sql = "SELECT * FROM `block_list` WHERE blocker=? && blocked=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$blocker, $blocked]);
            $user = $stmt->fetch();
            if ($user && $user["blocker"] == $blocker && $user["blocked"] == $blocked){
                $sql = "DELETE FROM `block_list` WHERE blocker=? && blocked=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$blocker, $blocked]);
                echo "cool";
            }else {
                $sql = "INSERT INTO `block_list`(`blocker`, `blocked`) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$blocker, $blocked]);
                echo "nope";
            }
        }
        function add_to_connection($user, $added){
            $sql = "SELECT * FROM `people_you_like` WHERE liked=? AND UserName=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user, $added]);
            $connection = $stmt->fetch();

            print_r($connection);
            if ($connection){
                $sql = "INSERT INTO `connections`(`user1`, `user2`) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$connection["UserName"], $connection["liked"]]);
                echo "hello";

                $sql = "DELETE FROM `people_you_like` WHERE liked=? AND UserName=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$connection["liked"], $connection["UserName"]]);
                $sql = "DELETE FROM `people_you_like` WHERE liked=? AND UserName=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$connection["UserName"], $connection["liked"]]);
                echo "its_cool";

                //insert nofication function here for like back
                $to= $connection["UserName"];
                $acceptor=$connection["liked"];
                $viewer_id = $_SESSION['id']; //acceptor id //must be ksambo id
                $viewer_name = $_SESSION['logged_in_user'];//liker's name
                $message= "your profile was liked back by $acceptor";
                $status ="unread";

                $sql ="SELECT `ID` FROM `accounts_basic` WHERE `UserName`=?";
                $check=  $this->conn->prepare($sql);
                $check->execute([$to]);
                $result=$check->fetch(PDO::FETCH_ASSOC);  
    
                $viewed_id= $result['ID'];
                include "../pages/notification.php";
                insert2db($viewer_id,$viewed_id,$viewer_name,$message,$status);
            }
        }

        function remove_from_likes($user, $remove){
            $sql = "DELETE FROM `people_you_like` WHERE liked=? AND UserName=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user, $remove]);

            echo "its_cool";
        }
    }
?>