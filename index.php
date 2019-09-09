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
<h1>Houses and Holds</h1>

<form action="index.php" method="post">
 <input type="text" name="username" placeholder="User name (email)" /><br />
 <input type="text" name="password" placeholder="Password" /><br />
 <input type="text" name="password2" placeholder="Re-type password to join (new user)" /><br />
 <input type="submit" name="submit" />
</form>

<?php
require_once "src/dbConnect.php";
require_once "src/findUserByEmail.php";
require_once "src/displayUserCharacters.php";

// Connect to db
$connect = dbConnect();

if (mysqli_errno()) {
die('<p>Failed to connect to MySQL: '.mysql_error().'</p>');
} else {



  // Check if the form is submitted
  if ( isset( $_POST['submit'] ) ) { // retrieve the form data by using the element's name attributes value as key
    $user_email = $_POST['username'];
    $pw = $_POST['password']; // display the results
    $pw2 = $_POST['password2'];
    //echo '<h3>Form POST Method</h3>';
    //echo 'Your email is ' . $user_email . ' and your password is ' . $pw ;

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
