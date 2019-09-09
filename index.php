<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Houses and Holds</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div>
  <h1>Houses and Holds</h1>
<?php

require_once "src/charMakeOffline.php";

// Login/signup form
echo "<form action='dashboard.php' method='post'>";
echo "<p><input type='email' name='username' placeholder='Email' size='40' /></p>";
echo "<p><input type='password' name='password' placeholder='Password' size='40' /></p>";
echo "<p><input type='password' name='password2' placeholder='Re-type password to join (new user)' size='40' /></p>";
echo "<p><input type='submit' name='login' value='Log in / Sign up' /></p>";
echo "</form>";

// Check if the logout form is submitted
if ( isset( $_POST['logout'] ) ) {
  $user_email = "";
  $pw = "";
  $pw2 = "";
  echo "<p>You are logged out</p>";
  exit;
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
</div>
</body>
</html>
