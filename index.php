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
require_once "src/dbConnect.php";
require_once "src/displayUserCharacters.php";
require_once "src/findUserByEmail.php";

session_start();

$connect = dbConnect();



// Login/signup form
function loginForm()
{
echo "<form action='index.php' method='post'>";
echo "<p><input type='email' name='user_email' placeholder='Email' size='40' /></p>";
echo "<p><input type='password' name='password' placeholder='Password' size='40' /></p>";
echo "<p><input type='password' name='password2' placeholder='Re-type password to join (new user)' size='40' /></p>";
echo "<p><input type='submit' name='login' value='Log in / Sign up' /></p>";
echo "</form>";
}

// Check if login form is submitted
if(isset($_POST['login']))
{
  if($_POST['user_email'] != "")
  {
    $user_email = $_POST['user_email'];
    $pw = $_POST['password'];
    $pw2 = $_POST['password2'];
    $user_id = findUserByEmail($connect, $user_email, $pw, $pw2);
    $_SESSION['user_email'] = $_POST['user_email'];
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'>" . $user_email . " has logged in.<br /></div>");
    fclose($fp);
  }
  else
  {
    echo "<span class='error'>Please type in an email.</span>";
  }
}

if(!isset($_SESSION['user_email']))
{
  loginForm();
}
else
{
  //$user_email = $_SESSION['user_email'];
  echo "<p>Logged in as " . $user_email;
  echo "<form action='index.php' method='post'>";
  echo "<input type='hidden' name='exit_email' value='" . $user_email . "' />";
  echo "<input type='submit' name='logout' value='Logout' />";
  echo "</form></p>";

  // Link to dashboard
  if (mysqli_errno())
  {
  die('<p>Failed to connect to MySQL: '.mysql_error().'</p>');
  }
  else
  {
    echo "<p>Success connecting to database!</p>";
  }
  //echo "<p><a href='dashboard.php?" . htmlspecialchars(session_id($_SESSION['user_email'])) . "'>Dashboard</a></p>";

  displayUserCharacters($connect, $user_id);

  echo "<div id='chatbox'>";
  if(file_exists("log.html") && filesize("log.html") > 0)
  {
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
if ( isset( $_POST['logout'] ) )
{
  $exit_email = $_POST['exit_email'];
  $fp = fopen("log.html", 'a');
  fwrite($fp, "<div class='msgln'>" . $exit_email . " has logged out.<br /></div>");
  fclose($fp);

  session_destroy();
  header("Location: index.php");
}

// Check if quitlogout form is submitted
if(isset($_POST['quitlogout']))
{
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
if ( isset( $_POST['logoutfail'] ) )
{
  $user_email = "";
  $pw = "";
  $pw2 = "";
  exit;
}

?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

<script type="text/javascript">
// jQuery Document
$(document).ready(function()
{
});

//jQuery Document
$(document).ready(function()
{
	//If user wants to end session
	$("#exit").click(function()
  {
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true)
    {
      window.location = 'index.php?logout=true';
    }
	});
});

//If user submits the form
$("#submitmsg").click(function()
{
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});
		$("#usermsg").attr("value", "");
		loadLog();
	return false;
});

function loadLog()
{
	var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
	$.ajax({
		url: "log.html",
		cache: false,
		success: function(html)
    {
			$("#chatbox").html(html); //Insert chat log into the #chatbox div

			//Auto-scroll
			var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
			if(newscrollHeight > oldscrollHeight)
      {
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
