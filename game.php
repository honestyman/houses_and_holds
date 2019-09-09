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
require_once "src/charMakeOnline.php";

// Connect to db
$connect = dbConnect();

if (mysqli_errno()) {
die('<p>Failed to connect to MySQL: '.mysql_error().'</p>');
} else {

  // Check if the form is submitted
  if ( isset( $_POST['play'] ) ) {
    $char_id = $_POST['char_id'];
    $user_id = $_POST['user_id'];

    // Activate character
    charMakeOnline($connect, $char_id);
    echo "<p>Your character is online (character id: " . $char_id . ")</p>";

    // Display button to deactivate character and return to dashboard
    echo "<form action='dashboard.php' method='post'>";
    echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
    echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
    echo "<input type='submit' name='quit' value='Quit to dashboard' />";
    echo "</form>";

    // Display button to deactivate character and return to index
    echo "<form action='index.php' method='post'>";
    echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
    echo "<input type='submit' name='quitlogout' value='Quit and Logout' />";
    echo "</form>";

    exit;
  }
}

?>
</div>
</body>
</html>
