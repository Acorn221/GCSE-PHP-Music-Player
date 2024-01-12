<!DOCTYPE html>
<html>
<head>
<style>
 h1 {
    color:  rgb(249, 249, 249); /* This sets all items in 'h1' to a light grey */
    font-size: 100px; /* This sets all the items in 'h1' to the font size of 100px */
  }
body {
  background: linear-gradient(to left, #76b852, #8DC26F); /* Sets a gradient from a green to a lighter green */
  -webkit-font-smoothing: antialiased;  /* Makes the font look less pixelated */
  font-family: Arial, Helvetica, sans-serif;/* This sets the font */
}
table {
  background:  rgb(244, 244, 244);/* Sets the form area's background colour */
  max-width: 360px;/* Sets the maximum width of the form area */
  padding: 30px;/* Sets the padding around the text boxes */
  text-align: center;/* Sets the text to the center of the screen */
  box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.23), 0 8px 8px 0 rgba(0, 0, 0, 0.23);/* Sets a shadow around the input area */
}
button {
  background: #4CAF50;/* Sets the background of the button to the green theme of the background */
  cursor: pointer;/* Makes the cursor not change when the mouse is hovered over, this makes it look better because the hover function lets the user know that it is clickable */
  border: 0;/* Removes the default button border */
  padding: 12px;/* Sets the padding around the button */
  color: #FFFFFF;/* Sets the text colour to white*/
  width: 100%;/*  Set's the width of the button to make it the same width as the input boxed */
}
button:hover{
  background: #43A047;/* Changes the background of the button when the mouse is hovered over */
}
div{
  font-size: 15px;/* Set's the font size of the Register link */
  color: rgba(0, 0, 0, 0.35);
}
a {
  color: #4CAF50; /* This sets the colour of hyperlinks (anything with the tag 'a') */
  text-decoration: none; /* This removes the default underlining of the  hyperlinks*/
}
input, select{
  height: 35px; /* This makes all the input boxes and dropdown menu's, 35px high */
  width: 300px;
  font-size: 25px;
}

</style>
<?php
// This will be used to let the user know if their submition is invalid
 $message = $_GET['message']; // So the user knows what their error message is when they get rejected
 if($message != null){
   echo "<script>alert('$message')</script>"; // This is an alert containing the message recieved
 }
  ?>
  <title>OCRtunes</title><!-- This is to make the tab display 'OCRtunes' -->
</head>
<body><center>
<h1>
OCRtunes
  </h1>
  <h2>



<table cellspacing="20"  id="login" ><!-- The table tag with it's ID for the javascript to change between forms -->
<form action="sub.php" method="get" ><!-- This is the decoration of the form -->
  <input type="text" name="type" value="login" style="display: none"><!-- The tag to let sub.php know if the user is logging in or creating a new account -->
  <tr>
  <th><input type="text" name="email" style="font-size:25px;" placeholder="Email"></th><!-- This is where the user inputs their email -->
  </tr>
  <tr>
  <th><input type="password" name="password" style="font-size:25px;" placeholder="Password"></th><!-- this is where the user inputs their password -->
  </tr>
  <tr>
  <th><button type="submit" style="font-size: 30px;" hover="background: #43A047;">Submit</button></th><!-- This is the submit button to login -->
  </tr>
   <tr>
  <th><div> Not Registered? <br><a href="#" onclick="register()">Click Here To Register</a></div></th><!-- this is the button to switch between the login form and register form -->
  </tr>
  </form>
</table> 

    

<table cellspacing="20" id="register" ><!-- The table tag with it's ID for the javascript to change between forms -->
<form action="sub.php" method="get"  ><!-- This is the decoration of the form -->
  <input type="text" name="type" value="register" style="display: none"><!-- The tag to let sub.php know if the user is logging in or creating a new account -->
  <tr>
  <th><input type="text" name="name" style="font-size:25px;" placeholder="Name"></th><!-- The Name field -->
  </tr>
  <tr>
  <th><input type="text" name="email" style="font-size:25px;" placeholder="Email" onkeyup="email(this.value)" id="email"></th><!-- The Email Field -->
  </tr>
  <tr id="passCheck" style="color: orange;font-size: 16px;display: none;"><!-- This is all to let the user know if their password is valid -->
  <th>The Password Needs To Be 4-20 Characters Long And Need's One Uppercase or Non Alpha character</th>
  </tr> <!--  -->
  <tr>
  <th><input type="password" name="password" style="font-size:25px;" placeholder="Password" onkeyup="passLength(this.value)" id="password"></th><!-- This is the password entry field, the onkeyup is so the user knows if their password is valid-->
  </tr>
  <tr>
  <th><input type="password" style="font-size:25px;" placeholder="Password Again" onkeyup="samePass(this.value)"></th><!-- This is to check the user inputted their password correctly -->
  </tr>
  <tr id="passMatch" style="color: orange;font-size: 16px;display: none;"><!-- This is all to let the user know if their password is valid -->
  <th>The Password Do Not Match</th>
  </tr> <!--  -->
  <tr>
  <th><div>Select your Favorite Genre</div>
  <select name="favGenre"><!-- Here is where the user selects their favorite genre -->
  <option value="none">----------</option> <!-- For the user to select so an option isn't already selected -->
  <option value="Jazz">Jazz</option>
  <option value="Electronic">Electronic</option>
  <option value="Rock n Roll">Rock n' Roll</option>
  <option value="Alternative">Alternative</option>
  <option value="pop">Pop</option>
</select></th><!-- To select the genre-->
  </tr>
  <tr>
  <th><div>Select your Favorite Artist</div>
  <select name="favArtist">
  <option value="none">----------</option><!-- For the user to select so an option isn't already selected -->
  <option value="Wynton Marsalis">Wynton Marsalis</option><!-- The Jazz Artist, This would be an input box but with a small selection of songs, that would not be applicable -->
  <option value="Deadmau5">Deadmau5</option>
  <option value="Daft Punk">Daft Punk</option>
  <option value="Jimmy DeKnight ">Jimmy DeKnight </option>
  <option value="Mike Dirnt">Mike Dirnt</option>
  <option value="Logan Paul">Jake Paul</option>
  <option value="Jake Paul">Logan Paul</option>
  </select>
  </th>
  </tr>
  <tr>
  <th><div>Please Enter Your Date Of Brith</div>
  <select name="Day" id="day" style="width: 50px;">
  </select>
  <select name="Month" id="month" style="width: 150px;">
  </select>
  <select name="Year" id="year" style="width: 90px;">
  </select>
  </th>
  </tr>
  <tr>
  <th><button type="submit" id="submit" style="font-size: 30px;" hover="background: #43A047;">Submit</button></th><!-- The register submit button -->
  </tr>
   <tr>
  <th><div>Registered? <br><a href="#" id="login" onclick="login()">Click Here To Login</a></div></th><!-- The button to go back to the login area -->
  </tr>
  </form>
</table> 


  <script>
//***********Day*********** This is to iterate the day's so the page loads faster on bad internet, because most people will use this page to login, It also looks nice and get's those sweet marks ;)
var day = "";
for (var i = 1; i < 32; i++) {
    day += "<option value='"+i+"'>"+i+"</option><br>";
}
document.getElementById("day").innerHTML = day; // Set's the above option to what it had just made
//***********Month***********  This is to iterate the month's so the page loads faster on bad internet, because most people will use this page to login, It also looks nice and get's those sweet marks ;)
var months = ["January","Febuary","March","April","May","June","July","August","September","October","November","December"]; // Lists the days of the month to iterate
var month = "";
for (var i = 0; i < 12; i++) { // Run's 12 times
    month += "<option value='"+parseInt(i+1)+"'>"+months[i]+"</option><br>"; // I have the parseInt because i+1 would add 1 to the end as a string, creating problems, and it has to add 1 because otherwise, the month would start at 0
}

document.getElementById("month").innerHTML = month; // Set's the above option to what it had just made
//***********Year*********** This is to iterate the year's so the page loads faster on bad internet, because most people will use this page to login, It also looks nice and get's those sweet marks ;)
var year = "";
var y = new Date().getFullYear(); // Get's the current year in an interger format
var year = "";
for (i = y-1; i > y-100; i--) { // This count's back 100 year's because there is no need for a minimum age ( past 1y for trolls/spammers ) and I don't think anyone above 100 will use OCRtunes, Unless DJ uses some serious anti-ageing cream
	year += "<option value='"+i+"'>"+i+"</option><br>";
}

document.getElementById("year").innerHTML = year; // Set's the above option to what it had just made


document.getElementById('register').style.display = "none";// This is to hide the register
document.getElementById("submit").disabled = true;
function register(){// this is the function to switch between login and register
  document.getElementById('login').style.display = "none";//Hides the login form
  document.getElementById('register').style.display = "block";//Shows the register form
}
    
function login(){// This is the function to switch between register and login
  document.getElementById('register').style.display = "none";//This hides the  Register form
  document.getElementById('login').style.display = "block";//This shows the login form
}
    
function passLength(pass){// This function verifies the password validity
  var upper = false;// This is here because it needs to be reset every run of the function
   for(var i=0; i < pass.length; i++){ // This for loop goes through all of the characters looking for upper case characters or special characters that can't be uppercase
     if(pass[i] == pass[i].toUpperCase()){ // This checks if the selected character is the same if it is uppercase to see if it is already uppercase or is non alpha
       upper = true; // This indicates it has encountered a uppercase or non alpha character
     } 
   }
   if(pass.length > 3 && pass.length < 21 && upper){ // this checks the password length is between 4 and 20, and checks if upper is true 
     document.getElementById('passCheck').style.display = "none"; // This hides the message saying the password specifications
     document.getElementById("submit").disabled = false;// This is so the submit button cannot be pressed when the password(s) entered are invalid
   } else {
     document.getElementById('passCheck').style.display = "block"; // This shows the message saying the password specifications
     document.getElementById("submit").disabled = true;// This is so the submit button cannot be pressed when the password(s) entered are invalid
   }
}
    
function samePass(pass){
  var firstPass = document.getElementById('password').value;// This gets the value of the first password entered
  if(pass != firstPass){
    document.getElementById('passMatch').style.display = "block"; // This shows the message saying the 2 passwords entered are different
    document.getElementById("submit").disabled = true; // This is so the submit button cannot be pressed when the password(s) entered are invalid
  } else {
    document.getElementById('passMatch').style.display = "none"; // This hides the message saying the 2 passwords entered are different
    document.getElementById("submit").disabled = false;// This is so the submit button cannot be pressed when the password(s) entered are invalid
  }
}

function email(email){
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  
}
  
</script>
  </h2> </center>

</body>
</html>
