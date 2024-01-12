<?php

require 'background.php';
session_start();

$type = $_GET['type']; // This checks if the user want's to login or register
$ip = $_SERVER['REMOTE_ADDR']; // Get's IP address to log all account creation 
$date = new DateTime(); // Get's the date to set when the user

if($type == "login"){ // To check if it is a login or a register request
	$email = validate($_GET['email']); // Removes all ' from the string
	$password = validate($_GET['password']); // Removes all ' from the string
	//*************Working ***************
  	$sql = "SELECT Email, Password, ID FROM Users WHERE Email = '$email'"; // This is to check the password
  	$result = $connect->query($sql); // This runs the SQL command above
  
  	if ($result->num_rows > 0) { // If there aren't any results for that email
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	if($password == $row["Password"]){ // If pass
				$_SESSION["ID"] = $row["ID"]; // Set's the User's PHP Session ID, for rembering users
				$_SESSION['Last'] = time(); // update last activity time stamp for auto logout
				//echo "You have logged in"; // was  used for testing
				header("Location: home.php", true, 301); // Redirects the user to the home.php, because they have logged in
			}else{
				echo "Your Password Is Incorrect!"; // was  used for testing 
				header("Location: index.php?message=Your+Password+Is+Incorrect!", true, 301); // Redirects the user to the home.php
			}
				    //header("Location: home.php", true, 301); // Redirects the user to the home.php
				    //exit();
  		}
  	} else {
			header("Location: index.php?message=Your+Email+Is+Invalid!", true, 301); // The '?message=' is to report back an error
		}
}elseif($type == "register"){
  $name = validate($_GET['name']); // the 'validate()' is to take out ' characters to prevent SQL injection
  $email = validate($_GET['email']);
  $password = validate($_GET['password']);
  $favGenre = validate($_GET['favGenre']); // Because all data can be change being recieved, this is why this is required
  $favArtist = validate($_GET['favArtist']);
  $DOB = validate($_GET['Year']."-".$_GET['Month']."-".$_GET['Day']); // Put's the DOB into DATE format
  $sql = "INSERT INTO Users (Name, Email, Password, favGenre, favArtist, DOB, IP) VALUES ('$name', '$email', '$password', '$favGenre', '$favArtist', '$DOB', '$ip')"; // Insert's the recieved data into the database
  if ($connect->query($sql) === TRUE) {
    echo "Your Account Was Created Successfully! :)"; // A message for debugging
	header("Location: home.php", true, 301);
	//*************Working ***************
	/*
  	$sql = "SELECT Email, Name, ID FROM Users WHERE Email = '$email'";
  	$result = $connect->query($sql);
  
  	if ($result->num_rows > 0) {
    // output data of each row
    	while($row = $result->fetch_assoc()) { // Runs for how many user's there are
    			echo "Name: " . $row["Name"]. "<br>"; // This was used for debugging and will be commented out
				echo "ID: " . $row["ID"]. "<br>";
				$_SESSION["ID"] = $row["ID"]; // Set's the User's PHP Session ID, for rembering users
				$_SESSION['Last'] = time(); // update last activity time stamp
				//header("Location: home.php", true, 301); // Redirects the user to the home.php
				exit();
    		}
  		} else {
    	  	echo "Entry not found :( "; // This is for the debugging
  		} //************* Working ***************
		*/
  	} else {
     	 echo "Your Account Was Not Created Successfully :( " . "<br>" . $connect->error; // For debugging at the moment, It should be removed when in use
  	}

 // echo "Your ID:"$result;
  
  
} elseif($type == "cPlaylist"){
	$name = validate($_GET['name']);
	$songs = validate($_GET['songs']);
	$sql = "INSERT INTO playlists (User_ID, Playlist_Name, Songs) VALUES ('".$_SESSION['ID']."', '".$name."', '".$songs."');";
	
	if ($connect->query($sql) === TRUE) {
		echo "Your Account Was Created Successfully! :)"; // A message for debugging
		header("Location: home.php", true, 301);
	}else {
     	 echo "Your Playlist Submition Was Not Done Successfully :( " . "<br>" . $connect->error; // For debugging at the moment, It should be removed when in use
  	}
} elseif($type == "gPlaylist"){
	$id = $_SESSION["ID"];
	$playlistName = validate($_GET['playlistName']);

	$sql = "SELECT Songs FROM playlists WHERE Playlist_Name = '$playlistName' LIMIT 1";
	echo "<tr class=\"noHover\"> <th> Name </th> <th> Genre </th> <th> Artist </th><th> Length </th>";
	$result = $connect->query($sql);
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$songs = $songs.$row["Songs"];
	}
	$songs = str_replace("!","'", "(".$songs.")");
	$sql = "SELECT * FROM Library WHERE Song_ID IN ".$songs." ORDER BY Name;"; // Select's all from the library where the song ID = given ID
	//echo $sql;
	$result = $connect->query($sql); // Run the previous SQL query
	$songs = ""; // This is to set the varible 'songs';
	if ($result->num_rows > 0) { // This is if there is anything in the songs database
		// output data of each row
		while($row = $result->fetch_assoc()) { // This runs once per song 
			echo "<tr onclick='play(\"".$row['Name']."\", \"".$row['Genre']."\")' title=\"".$row['Name']."\" id=\"".$row['Song_ID']."\" class=\"song\"><th>" . $row["Name"]. "</th><th>" . $row["Genre"]. "</th><th>" . $row["Artist"]."</th><th>" .gmdate("i:s", $row["Length"])."</th></tr>"; // This adds to the varible 'songs' and creates a list of songs, in a table format
		}
	} else {
	echo "No Songs Found In Playlist"; // This tells the admin if there is no songs or indicates at a glitch
	}

} elseif($type == "all"){
	echo "<tr class=\"noHover\"> <th> Name </th> <th> Genre </th> <th> Artist </th><th> Length </th>";
	$sql = "SELECT * FROM Library ORDER BY Name"; // Select's all from the library and order's them by their name, I would prefer genre but the NEA says Name so...
	$result = $connect->query($sql); // Run the previous SQL query
	$songs = ""; // This is to set the varible 'songs'
	if ($result->num_rows > 0) { // This is if there is anything in the songs database
		// output data of each row
		while($row = $result->fetch_assoc()) { // This runs once per song 
			echo "<tr onclick='play(\"".$row['Name']."\", \"".$row['Genre']."\")' title=\"".$row['Name']."\" id=\"".$row['Song_ID']."\" class=\"song\"><th>" . $row["Name"]. "</th><th>" . $row["Genre"]. "</th><th>" . $row["Artist"]."</th><th>" .gmdate("i:s", $row["Length"])."</th></tr>"; // This adds to the varible 'songs' and creates a list of songs, in a table format
		}
	} else {
		echo "m9 add some songs plz"; // This tells the admin if there is no songs or indicates at a glitch
	}
} elseif($type == "change"){
	$id = $_SESSION["ID"];
	$name = validate($_GET['name']);
	$sql = "UPDATE Users SET";
	
	if ($connect->query($sql) === TRUE) {
		echo "Success"; // A message for debugging
		header("Location: home.php", true, 301);
	}else {
     	 echo "Failure"; // For debugging at the moment, It should be removed when in use
  	}
	
}

$connect->close(); // Closes the connection to the database

function validate($in) { // Remove's every " ' " to prevent SQL injections
  return  str_replace("'","", $in); // a repace function
}


?>