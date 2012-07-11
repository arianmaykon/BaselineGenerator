<?php
ini_set('display_errors', 'On');
#error_reporting(E_PARSE | E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR | E_USER_ERROR);
error_reporting(E_ALL);


$failed = 0;
//log them out
$logout = isset($_GET['logout'])?$_GET['logout']:null;
if ($logout == "yes") { //destroy the session
	session_start();
	$_SESSION = array();
	session_destroy();
}

//force the browser to use ssl (STRONGLY RECOMMENDED!!!!!!!!)
/*if ($_SERVER["SERVER_PORT"] != 443){ 
#    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']); 
    header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']); 
    exit(); 
}*/

//you should look into using PECL filter or some form of filtering here for POST variables
$username = isset($_POST["username"])?strtoupper($_POST["username"]):null; //remove case sensitivity on the username
$password = isset($_POST["password"])?$_POST["password"]:null;
$formage = isset($_POST["formage"])?$_POST["formage"]:null;

if (isset($_POST["oldform"]) && $_POST["oldform"]) { //prevent null bind

	if ($username != NULL && $password != NULL){
		//include the class and create a connection
		include (dirname(__FILE__) . "/../src/adLDAP.php");
        try {
		    $adldap = new adLDAP();
        }
        catch (adLDAPException $e) {
            echo $e; 
            exit();   
        }
		
		//authenticate the user
		if ($adldap->authenticate($username, $password)){
			//establish your session and redirect
			session_start();
			$_SESSION["username"] = $username;
            $_SESSION["userinfo"] = $adldap->user()->info($username);
#			$redir = "Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/menu.php";
			$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/menu.php";
			header($redir);
			exit;
		}
	}
	$failed = 1;
}

?>

<html>
<head>
<title>adLDAP example</title>
</head>

<body>

This area is restricted.<br>
Please login to continue.<br>

<form method='post' action='<?php echo $_SERVER["PHP_SELF"]; ?>'>
<input type='hidden' name='oldform' value='1'>

Username: <input type='text' name='username' value='<?php echo ($username); ?>'><br>
Password: <input type='password' name='password'><br>
<br>

<input type='submit' name='submit' value='Submit'><br>
<?php if ($failed){ echo ("<br>Login Failed!<br><br>\n"); } ?>
</form>

<?php if ($logout=="yes") { echo ("<br>You have successfully logged out."); } ?>


</body>

</html>

