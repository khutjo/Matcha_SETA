<?php

	function debug($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
		return ;
	}
	
	class User extends connection
	{
		private $fist_name;
		private $last_name;
		private $user_password;
		private $email;
		private $account_status;
		public 	$gender;
		public 	$age;
		public 	$sexual_preferences;
		public 	$biography;
		public 	$interests;
		public 	$pictures;
		public	$fame_rating;
		private $confirm;
		public 	$subject = "confirming an account";
		public 	$headers = 'MIME-Version: 1.0\r\nContent-type: text/html;charset=UTF-8'.'From: <matcha@getlaid.com>';
		
		function __construct()
		{
			parent::__construct();
		}

		public function reset_user()
		{
			session_start();
			if (isset($_SESSION['email']))
			{
				if (isset($_POST['password']) && isset($_POST['password_confirm']))
				{
					if ($_POST['password'] === $_POST['password_confirm'])
					{
						$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
						$query = $this->conn->prepare("UPDATE matcha.users SET password = :password WHERE email= :email");
						$query->bindParam(":password", $password);
						$query->bindParam(":email", $_SESSION['email']);
						$query->execute();
						header("Location: http://localhost/Matcha-master/login.php?message=password changed&type=success");	
					}			
					else
					{
						header("Location: http://localhost/Matcha-master/login.php?message=database failure&type=warning");
						die();
					}			
				
				}
				else
				{
					header("Location: http://localhost/Matcha-master/login.php?message=failure&type=warning");	
				}
			}
			else
			{
				header("Location: http://localhost/Matcha-master/login.php?message=something is wrong&type=danger");
			}
		}

		public function reset_password()
		{
			$params = [];
			$setStr = "";
			foreach ($_POST as $key => $value)
			{
				if ($key != "email" && $key != "forgot_password")
				{
					unset($_POST[$key]);
				}
				if ($key === "forgot_password")
					continue;
				$setStr .= "`" . str_replace("`", "`", $key)."` = :".$key.",";
				$params[$key] = $_POST[$key];
			}
			$setStr = rtrim($setStr, ',');
			$query = $this->conn->prepare("SELECT username FROM matcha.users WHERE $setStr");
			$query->execute($params);
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if (!$result)
			{
				header("Location: http://localhost/Matcha-master/forgot_password.php?message=go and register peasant&type=warning");
			}
			else
			{ 
				session_start();
				$_SESSION['email'] = $_POST['email'];
				$ms = "Click here to reset your password http://localhost/Matcha-master/reset.php>";
				mail($_POST['email'], "reset password", $ms,$this->headers);

				/* echo '<div class="container">
				<div class="alert alert-success" role="alert">
				<strong>click the link in your email</strong>
				</div> 
				</div>'; */
				header("Location: http://localhost/Matcha-master/forgot_password.php?message=click the link in your email to reset&type=info");
			}
		}
		
		//profile management, inserting and updating profile
		public function insert_user()
		{
			if (isset($_POST['register']))
			{
				$params = [];
				$allowed = ["first_name","last_name","email","age", "chash","username","password","confirm"];
				$setStr = "";
				foreach ($allowed as $key)
				{
					if ($key === "passwd_verify")
						continue ;
					if (isset($_POST[$key]) && $key != "id")
					{
						$setStr .= "`" . str_replace("`", "`", $key)."` = :".$key.",";
						if ($key === "password")
						{
							if ($_POST[$key] === $_POST['passwd_verify'])
							{
								$params[$key] = password_hash($_POST[$key], PASSWORD_DEFAULT);
								continue ;	
							}			
							else
							{
								die();
							}			
						}	
						if ($key === "email")
						{
							if (filter_var($_POST[$key], FILTER_VALIDATE_EMAIL))
							{
								$this->confirm = hash("md5", $_POST['email']);
								$params['chash'] = $this->confirm;
								$setStr .= "`" . str_replace("`", "`", "chash")."` = :"."chash".",";
								$email = $_POST['email'];
							}
							else
							{
								echo "invalid email address";
								die();
							}
						}
						$params[$key] = $_POST[$key];
					}
				}
				$params['confirm'] = 0;
				$setStr .= "`" . str_replace("`", "`", "confirm")."` = :"."confirm".",";
				$setStr = rtrim($setStr, ",");
				$q = $this->conn->prepare("INSERT INTO matcha.users SET $setStr");
				
				$q->execute($params);
				$this->subject = "a link should appear for you to confirm your account";
				$ms = "http://localhost/Matcha-master/run.php?verify=true&ash=".$this->confirm."&email=".$email;
				mail($email, $this->subject, $ms, $this->headers);
			}
			if (isset($_POST['update_profile']))
			{
				$params = [];
				$setStr = "";
				$allowed = ["gender", "sexual_preferences","bio","interests","username"];
				// $this->user_is_logged_in();
				// $uname = $_SESSION['login'];
				foreach ($allowed as $key)
				{
					if ($key == "username")
					{
						$this->user_is_logged_in();
						$uname = $_SESSION['login'];
					//	$setStr .= "`" . str_replace("`", "`", $key)."` = :".$key.",";
						$params[$key] = $_SESSION['login'];
						continue;
					}
					if (isset($_POST[$key]) && $key != "id")
					{
						$setStr .= "`" . str_replace("`", "`", $key)."` = :".$key.",";
					}
					$params[$key] = $_POST[$key];
				}
				
				$setStr = rtrim($setStr, ",");
				$q = $this->conn->prepare("UPDATE matcha.users SET $setStr WHERE username = :username");
				$q->execute($params);
			}
		}

		public function user_is_logged_in()
		{
			session_start();
			if (isset($_SESSION['login']))
			{
				return TRUE;
			}
			else
			{
				session_destroy();
				return FALSE;
			}
		}

		public function sign_user_in()
		{
			
			if ($this->user_is_logged_in())
			{
				session_start();
				header("Location: http://localhost/Matcha-master/home.php");
				return;
			}
			if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['login']))
			{
				session_start();
				try{
					$q = $this->conn->prepare("SELECT * FROM matcha.users WHERE `username` = ? AND `confirm` = 1");
					$q->execute([$_POST['username']]);
					$result = $q->fetch();
					if ($result && $result['confirm'] == 1 && password_verify($_POST['password'], $result['password']))
					{
						$_SESSION['login'] = $_POST['username'];
						header("Location: http://localhost/Matcha-master/home.php");
					}
					else
					{
						session_destroy();
						// $error =  '<div class="alert alert-info" role="alert"><strong>Incorrect username/password combination</strong><span class="text-warning">try again</span></div>';
						header("Location: http://localhost/Matcha-master/login.php?type=danger&message=Incorrect username/password combination, try again");
					}
				} catch ( PDOException $e) {
					die( $e->getMessage() );
				}
			}
		}

		public function verify_user($verification, $hash, $email)
		{
			if ($verification === "true" && isset($hash) && filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$query =  $this->conn->prepare("SELECT username FROM matcha.users WHERE email = ? AND chash = ?");
				$query->execute([$email, $hash]);
				$result = $query->fetch(PDO::FETCH_ASSOC);
				if (!$result)
				{
					header("Location: http://localhost/Matcha-master/login.php?type=danger&message=go fuck yourself peasant");
					// header("Content-type", "application/x-www-form-urlencoded");
				}
				else
				{
					$request = $this->conn->prepare("UPDATE matcha.users SET confirm = 1 WHERE email = ?");
					$request->execute([$email]);
					header("Location: http://localhost/Matcha-master/login.php?type=success&message=account confirmed, you may now log in");
				}
				// hash("md5", $_POST['email']);
			}
		}

		public function sign_user_out()
		{
			if ($this->user_is_logged_in() && isset($_GET['log_out']))
			{
				unset($_SESSION['login']);
				session_destroy();
				header("Location: http://localhost/Matcha-master",true,303);
				exit;
			}
			return (false);
		}

		function __destruct()
		{
			parent::__destruct();
		}

	}
?>