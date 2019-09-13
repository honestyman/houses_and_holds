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

//session_start();

require_once "src/charMakeOffline.php";
require_once "src/charMakeOnline.php";
require_once "src/dbConnect.php";
require_once "src/displayUserCharacters.php";
require_once "src/findUserByEmail.php";
require_once "src/loginForm.php";
require_once "src/displayQuitButton.php";
require_once "src/displayLogoutButton.php";
require_once "src/getLocationInfo.php";

$connect = dbConnect();

// Check if login form is submitted
if(isset($_POST['login']))
{
  if($_POST['user_email'] != "")
  {
    $user_email = htmlspecialchars($_POST['user_email']);
    $pw = htmlspecialchars($_POST['password']);
    $pw2 = htmlspecialchars($_POST['password2']);
    $user_id = findUserByEmail($connect, $user_email, $pw, $pw2);
    if($user_id)
    {
      $_SESSION['user_email'] = $user_email;
      $_SESSION['user_id'] = $user_id;
    }
  }
  else
  {
    echo "<span class='error'>Please type in an email.</span>";
  }
}

// Check if play form is submitted
if (isset($_POST['play']))
{
  $char_id = $_POST['char_id'];
  $user_id = $_POST['user_id'];
  $user_email = $_POST['user_email'];
  $_SESSION['user_email'] = $user_email;
  $_SESSION['user_id'] = $user_id;
  $_SESSION['char_id'] = $char_id;
}

// Check if quit form is submitted
if(isset($_POST['quit']))
{
  $char_id = $_POST['char_id'];
  $user_id = $_POST['user_id'];
  $user_email = $_POST['user_email'];
  $_SESSION['user_email'] = $user_email;
  $_SESSION['user_id'] = $user_id;
  charMakeOffline($connect, $char_id);
}

if (mysqli_errno($connect))
{
  die('<p>Failed to connect to MySQL: '.mysql_error($connect).'</p>');
}
else
{


  if(!isset($_SESSION['user_email']))
  {
    loginForm();
  }
  else
  {
    if(!isset($_SESSION['char_id']))
    {
      echo "<p>Logged in as " . $user_email . "</p>";

      // Display button to logout user and return to login screen
      displayLogoutButton();

      // Display the user's characters
      displayUserCharacters($connect, $user_id, $user_email);
    }
    else
    {
      // Activate character and get info
      $char = charMakeOnline($connect, $char_id);
      echo "<p>Online as " . $char['name'] . "</p>";

      // Display button to deactivate character and return to dashboard
      displayQuitButton($user_email, $user_id, $char_id);

      // Get info about the location
      $location = getLocationInfo($connect, $char['location_id']);
      echo $location['name'];

    }
  }
}

// Check if the logout form is submitted
if(isset($_POST['logout']))
{
  //session_destroy();
  //header("Location: index.php");
  exit;
}

?>

</div>
</body>
</html>
