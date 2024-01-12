<html>
    <head>
<?php
require 'background.php'; // Requires the 'background.php' file to connect to the database and check if the person is logged in

sessionCheck(); // Runs the function to see if the user is logged in, if not, they are redirected to the login page
 //  
$sql = "SELECT * FROM Library ORDER BY Name"; // Select's all from the library and order's them by their name, I would prefer genre but the NEA says Name so...
$result = $connect->query($sql); // Run the previous SQL query
$songs = ""; // This is to set the varible 'songs'
if ($result->num_rows > 0) { // This is if there is anything in the songs database
    // output data of each row
    while($row = $result->fetch_assoc()) { // This runs once per song 
        $songs .= "<tr onclick='play(\"".$row['Name']."\", \"".$row['Genre']."\")' title=\"".$row['Name']."\" id=\"".$row['Song_ID']."\" class=\"song\"><th>" . $row["Name"]. "</th><th>" . $row["Genre"]. "</th><th>" . $row["Artist"]."</th><th>" .gmdate("i:s", $row["Length"])."</th></tr>"; // This adds to the varible 'songs' and creates a list of songs, in a table format
    }
} else {
    echo "m9 add some songs plz"; // This tells the admin if there is no songs or indicates at a glitch
}

$sql = "SELECT * FROM playlists WHERE User_ID = ".$_SESSION["ID"]." ORDER BY Playlist_Name"; // Select's all from the library and order's them by their name, I would prefer genre but the NEA says Name so...
$result = $connect->query($sql); // Run the previous SQL query
$playlist = "";
if ($result->num_rows > 0) { // This is if there is anything in the songs database
    // output data of each row
    while($row = $result->fetch_assoc()) { // This runs once per song 
        $playlist .= "<li onclick=\"getPlaylist('".$row["Playlist_Name"]."')\">".$row["Playlist_Name"]."</li>"; // This adds to the varible 'playlist' and creates a list of playlists, in a list format
    }
} else {
    $playlist = "Make some playlists!"; // This tells the admin if there is no playlists or indicates at a glitch
}
$connect->close(); // Closes the connection to the database

?>
<script>

</script>

<link rel="stylesheet" type="text/css" href="css/home.css"><!-- The required CSS -->
<title> OCRTunes - Home </title>
</head>
<body>
    <div class="title">OCRtunes</div><!-- The Logo -->
    <div class="menu">Home  Prefrences</div><!-- The top menu -->
    <div class="playlist">Playlist <ul id="playlists"><?php echo $playlist; ?> <br><div onclick="newPlaylist()">Click Here To Make A New Playlist</div></div><!-- The playlist Bar -->
	<audio controls class="player" style="height: 30px;" id="player"><source id="song" src="" type="audio/mpeg">Can you please get a proper browser like firefox or chrome, Your current one doesn't support this website :(...</audio> <!-- For bad browsers that don't support HTML5 -->
	<div class="autoplay">Autoplay</div><!-- The autoplay tag text -->
	<div class="submitPlaylist">Playlist Name<br><input type='text' id='playlistName' placeholder="Playlist Name"><br> <input type='submit' onclick="submitPlaylist()" value="Save Playlist"></div>
	<input type="checkbox" id="autoplay" onchange="setCookie('autoplay',this.checked,365);"> <!-- Set's the autoplay cookie to it's value -->
    <table class="songs"><tr class="noHover"> <th> Name </th> <th> Genre </th> <th> Artist </th><th> Length </th> <?php echo $songs; ?></table><!-- The php echo is it printing the table -->
</body>
<script>
var openPlaylist = "";
var selecting = 0; // For selecting playlist
var main = document.getElementsByClassName("songs")[0].innerHTML;
var lastSong = "";
var player = document.getElementById("player"); // Set's the 'player' definition
var autoplay = document.getElementById("autoplay"); // Set's the autoplay checkbox definition
var playlists = document.getElementById("playlists");

autoplay.checked = (getCookie("autoplay") == 'true'); // Changes the autoplay to checked dependent on cookie, This also convert's the cookie to a boolean because the '.checked' property is a boolean

function play(song, genre){ // To play the songs
	var x = document.getElementById("song");
	var id = document.querySelectorAll("[title='"+song+"']")[0].id; // the query selector all part is to get the object
	if(selecting != 1){
		x.src = "music/"+genre+"/"+song+".mp3"; // set's the SRC
		player.load(); // Loads the song
		player.play(); // Play's the sing
		if(lastSong != ""){ // If last song hasn't been set
			document.getElementById(lastSong).style = "";// Set's the colour of the old song playing back to normal
		}
		document.getElementById(id).style = "color:  rgb(40, 40, 40);";
		//playingStyle ; // Set's the colour of the song playing to darker		
		lastSong = id; // Set's the current song for the autoplay and set's the style 
	}
}
function getPlaylist(name){
	console.log("getting all from sub.php");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		document.getElementsByClassName("songs")[0].innerHTML = this.responseText;
		if(lastSong != ""){
			document.getElementById(lastSong).style = "color:  rgb(40, 40, 40);"; // This set's the current song to be darker so the user knows what's playing
		}
	}
	};
	if(name == "all"){
		xhttp.open("GET", "http://localhost/sub.php?type=all", true);
		//playlists.innerHTML = "<li onclick='getPlaylist(\"all\")'>All Songs</li>"+playlists.innerHTML;
		var z = playlists.innerHTML.indexOf("</li>")+5;
		playlists.innerHTML = playlists.innerHTML.substr(z);
	} else{
		xhttp.open("GET", "http://localhost/sub.php?type=gPlaylist&playlistName="+name, true);
		if(!playlists.innerHTML.includes("All Songs")){
			playlists.innerHTML = "<li onclick='getPlaylist(\"all\")'>All Songs</li>"+playlists.innerHTML;
		}
		openPlaylist = name; // Set's 'openPlaylist' as the playlist name
	}
	xhttp.send(); // Sends the xhttp request
	
}
function newPlaylist(){
	var x = document.getElementsByClassName("song");
	var songs = document.getElementsByClassName("songs")[0];
	var submit = document.getElementsByClassName("submitPlaylist")[0];
	
	if(selecting != 1){
		/* if(openPlaylist != "" || openPlaylist != "all"){
			var currentPlaylist = openPlaylist;
			getPlaylist("all");
			openPlaylist = currentPlaylist; // This is set so when the user want's to switch back, they can go back to their playlist they where listning to
		} */
		document.getElementsByClassName("songs")[0].innerHTML = main;
		for(i = 0; i < x.length; i++){
			var songID = x[i].id; // Get's the content's of the first <tr> tag and makes 'songName' that value
			submit.style.display = "block";
			x[i].innerHTML += "<input type='checkbox' id='"+songID+"' class='playlistSelect'>";
			selecting = 1; // This is to stop music playing when the box is checked
		}
	} else { 
		console.log("Running Selecting 0");
		submit.style.display = "none";
		for(i = 0; i < x.length; i++){ // This Code Wad Previously Needed Before 'getPlaylist("all")' To Remove The Tick Boxed
			var z = x[i].innerHTML.indexOf("<input");
			//console.log("Z Length: "+z+" and selected is: "+x[i].innerHTML);
			x[i].innerHTML = x[i].innerHTML.substr(0, z);
			selecting = 0;
		} 
		
	}
}
function submitPlaylist(){
	var x = document.getElementsByClassName("playlistSelect");
	var y = document.getElementById("playlistName").value;
	var selected = "";
	for(i = 0; i < x.length; i++){
		if(x[i].checked){
			selected += ",!"+x[i].id+"!"; // The '!' are instead of the ' character 
		}
	}
	window.location.href = "sub.php?type=cPlaylist&name="+y+"&songs="+selected.substring(1);
}
function getCookie(cname) { // This function returns the requested cookie
    var name = cname + "="; // Adds '=' to the end of cname
    var decodedCookie = decodeURIComponent(document.cookie); // Decodes the cookie
    var ca = decodedCookie.split(';'); // Split's the string where there is a ';'
    for(var i = 0; i < ca.length; i++) { // This runs for every cookie ( every part seperated by a ';'
        var c = ca[i]; // This set's 'c' as the current cookie/segment
        while (c.charAt(0) == ' ') { // while at the first char
            c = c.substring(1); // C = first letter of C
        }
        if (c.indexOf(name) == 0) { // If the start of c is name
            return c.substring(name.length, c.length); // Return cookie
        }
    }
    return ""; // Return nothing, to avoid errors
}
function setCookie(cname,cvalue,exdays) { // Set's a cookie
    var d = new Date(); // Creates New Date
    d.setTime(d.getTime() + (exdays*24*60*60*1000)); // Set's the expiration time
    var expires = "expires=" + d.toGMTString(); // creates a string for the expiration
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/"; // Puts all the information into the 'document.cookies
}
function playNext(){ // This function is used for an autoplay feature to play the next song whenever the current song has ended
	var playing = document.getElementById(lastSong); // Selects the current song playing
	var next = playing.parentNode.rows[ playing.rowIndex + 1 ];
	if(lastSong != "" && next != null){ // If last song has been set
		next.click(); // Get's the next row and clicks it, this is the shortest and most effinient way of doing this
	} else {
		playing.parentNode.rows[1].click(); // Goes Back To The Start when all the songs have been played
	}
}

if(getCookie("volume") != ""){ // This see's if the volume cookie has been set
	player.volume = getCookie("volume"); // This changes the volume to the volume cookie value
}
player.onvolumechange = function() { // This runs whenever the volume changes
    setCookie("volume", player.volume, 365); // This set's the current volume as a cookie so it is more convenient to use
}

player.onended = function() {
    if(autoplay.checked == true){ // This see's if the autoplay checkbox is ticked
		playNext(); // This Play's the next song
	}
};


</script>
</html>