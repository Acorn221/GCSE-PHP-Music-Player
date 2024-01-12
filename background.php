<?php // This is to save space and make the code neater
//*********PHP Session and Timeout*************
function sessionCheck() {
	session_start();
	if(!isset($_SESSION["ID"])){
		header("Location: index.php", true, 301);//Redirects if not logged in, there is no message because that would get annyoing and it's not relevent
	}

	if (isset($_SESSION['Last']) && (time() - $_SESSION['Last'] > 18000)) {// so the sessions expire after 5 hour for security
		// last request was more than 30 minutes ago
		session_unset();     // unset $_SESSION variable
		session_destroy();   // destroy session data in storage
	}
	$_SESSION['Last'] = time(); // update last activity time stamp
}
//****************** Connecting To DB ******************//
$host = "localhost";
$username = "admin";
$password = "thatdankpass12";
$dbname = "NEA";

// Make the connection to the DBs
$connect = new mysqli($host, $username, $password, $dbname);
// Check the connection to the DB
if ($connect->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 


?>