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

require_once "src/dbConnect.php";
require_once "src/findUserByEmail.php";
require_once "src/displayUserCharacters.php";
require_once "src/charMakeOffline.php";

// Connect to db
$connect = dbConnect();

if (mysqli_errno()) {
die('<p>Failed to connect to MySQL: '.mysql_error().'</p>');
} else {


  // Check if the login form is submitted
  if ( isset( $_POST['login'] ) ) {
    $user_email = $_POST['username'];
    $pw = $_POST['password'];
    $pw2 = $_POST['password2'];

    // Look for user in db, add if not found
    $user_id = findUserByEmail($connect, $user_email, $pw, $pw2);
    //echo $user_id;

    // Grab user characters
    if($user_id){
      echo "<p>You are logged in as " . $user_email;

      // Logout form
      echo "<form action='index.php' method='post'>";
      echo "<input type='submit' name='logout' value='Log out' />";
      echo "</form></p>";      

      displayUserCharacters($connect, $user_id);
    } else {
      echo "Uh oh!";
    }
    exit;
  }

  // Check if quit form is submitted
  if(isset($_POST['quit'])){
    $char_id = $_POST['char_id'];
    $user_id = $_POST['user_id'];

    // Make the character offline
    charMakeOffline($connect, $char_id);
    echo "<p>Your character is no longer online</p>";

    // Grab user characters
    if($user_id){
      displayUserCharacters($connect, $user_id);
    } else {
      echo "Uh oh!";
    }

    exit;
  }
}

?>
</div>
</body>
</html>
