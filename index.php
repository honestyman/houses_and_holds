<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Houses and Holds</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
#chatbox {
    text-align:left;
    margin-bottom:10px;
    margin-top:10px;
    padding:10px;
    background:#fff;
    height:270px;
    width:450px;
    border:1px solid #000;
    overflow:auto; }
</style>
</head>
<body>
<div>
  <h1>Houses and Holds</h1>
<?php

require_once "src/charMakeOffline.php";

session_start();

// Login/signup form
function loginForm(){
echo "<form action='index.php' method='post'>";
echo "<p><input type='email' name='user_email' placeholder='Email' size='40' /></p>";
echo "<p><input type='password' name='password' placeholder='Password' size='40' /></p>";
echo "<p><input type='password' name='password2' placeholder='Re-type password to join (new user)' size='40' /></p>";
echo "<p><input type='submit' name='login' value='Log in / Sign up' /></p>";
echo "</form>";
}

// Check if login form is submitted
if(isset($_POST['login'])){
  if($_POST['user_email'] != ""){
    $_SESSION['user_email'] = stripslashes(htmlspecialchars($_POST['user_email']));
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'>" . $_SESSION['user_email'] . " has logged in.<br /></div>");
    fclose($fp);
  } else {
    echo "<span class='error'>Please type in an email.</span>";
  }
}

if(!isset($_SESSION['user_email'])){
  loginForm();
} else {
  echo "<p>Logged in as " . $_SESSION['user_email'];
  echo "<form action='index.php' method='post'>";
  echo "<input type='hidden' name='exit_email' value='" . $_SESSION['user_email'] . "' />";
  echo "<input type='submit' name='logout' value='Logout' />";
  echo "</form></p>";

  echo "<div id='chatbox'>";
  if(file_exists("log.html") && filesize("log.html") > 0){
    $handle = fopen("log.html", "r");
    $contents = fread($handle, filesize("log.html"));
    fclose($handle);

    echo $contents;
  }
  echo "</div>";
  echo "<form name='message' action=''>";
  echo "<input name='usermsg' type='text' id='usermsg' size='63' />";
  echo "<input name='submitmsg' type='submit' id='submitmsg' value='Send' />";
  echo "</form>";
}

// Check if the logout form is submitted
if ( isset( $_POST['logout'] ) ) {
  $exit_email = $_POST['exit_email'];
  $fp = fopen("log.html", 'a');
  fwrite($fp, "<div class='msgln'>" . $exit_email . " has logged out.<br /></div>");
  fclose($fp);

  session_destroy();
  header("Location: index.php");
}

// Check if quitlogout form is submitted
if(isset($_POST['quitlogout'])){
  $char_id = $_POST['char_id'];
  charMakeOffline($connect, $char_id);
  echo "<p>Your character is no longer online</p>";
  $user_email = "";
  $pw = "";
  $pw2 = "";
  echo "<p>You are logged out</p>";
  exit;
}

// Check if the logoutfail form is submitted
if ( isset( $_POST['logoutfail'] ) ) {
  $user_email = "";
  $pw = "";
  $pw2 = "";
  exit;
}

?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});

//jQuery Document
$(document).ready(function(){
	//If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){window.location = 'index.php?logout=true';}
	});
});

//If user submits the form
$("#submitmsg").click(function(){
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});
		$("#usermsg").attr("value", "");
		loadLog();
	return false;
});

function loadLog(){
	var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
	$.ajax({
		url: "log.html",
		cache: false,
		success: function(html){
			$("#chatbox").html(html); //Insert chat log into the #chatbox div

			//Auto-scroll
			var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
			if(newscrollHeight > oldscrollHeight){
				$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
			}
	  	},
	});
}

setInterval (loadLog, 2500);
</script>

</div>
</body>
</html>
