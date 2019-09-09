<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Houses and Holds</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--<meta http-equiv="Content=Security-Policy" content="script-src *.housesandholds.com">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div>
<?php

require_once "src/dbConnect.php";
require_once "src/findUserByEmail.php";
require_once "src/displayUserCharacters.php";



// Connect to db
$connect = dbConnect();

if (mysqli_errno()) {
die('<p>Failed to connect to MySQL: '.mysql_error().'</p>');
} else {
  // Login/signup form
  echo "<h1>Houses and Holds</h1>";
  echo "<form action='index.php' method='post'>";
  echo "<p><input type='text' name='username' placeholder='User name (email)' size='40' /></p>";
  echo "<p><input type='text' name='password' placeholder='Password' size='40' /></p>";
  echo "<p><input type='text' name='password2' placeholder='Re-type password to join (new user)' size='40' /></p>";
  echo "<p><input type='submit' name='submit' value='Log in / Sign up' /></p>";
  echo "</form>";

  // Check if the form is submitted
  if ( isset( $_POST['submit'] ) ) {
    $user_email = $_POST['username'];
    $pw = $_POST['password'];
    $pw2 = $_POST['password2'];

    // Look for user in db, add if not found
    $user_id = findUserByEmail($connect, $user_email, $pw, $pw2);
    //echo $user_id;

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
