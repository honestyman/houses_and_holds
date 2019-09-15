<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Houses and Holds</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div id='wrap'>
  <h1>Houses and Holds</h1>

<?php

require_once "src/dbConnect.php";

$connect = dbConnect();

if (mysqli_errno())
{
  die('<p>Failed to connect to MySQL: '.mysqli_error().'</p>');
}
else
{
  if(isset($_POST['newchar']))
  {
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];

    // Display character creation form
    echo "<form action='createcharacter.php' method='post'>";
    echo "<p><input type='text' name='char_name' placeholder='Enter name for character' size='40' /></p>";
    echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
    echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
    echo "<p><input type='submit' name='create' value='Create' /></p>";
    echo "</form>";
  }

  if(isset($_POST['create']))
  {
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $char_name = htmlspecialchars($_POST['char_name']);

    // Check if character by same name already exists
    $sql1 = "SELECT name FROM characters WHERE name='" . $char_name . "'";
    $result1 = mysqli_query($connect, $sql1);

    if($result1->num_rows > 0)
    {
      // Char name already exists
      echo "<p>Character with that name already exists. Please try another one!</p>";

      // Display character creation form
      echo "<form action='createcharacter.php' method='post'>";
      echo "<p><input type='text' name='char_name' placeholder='Enter name for character' size='40' /></p>";
      echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
      echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
      echo "<p><input type='submit' name='create' value='Create' /></p>";
      echo "</form>";
    }
    else
    {
      // Add character
      $sql2 = "INSERT INTO characters(user_id, name) VALUES (" . $user_id . ", '" . $char_name . "')";
      $result2 = mysqli_query($connect, $sql2);
      echo "<p>Character created!</p>";
    }
  }
}

echo "<form action='index.php' method='post'>";
echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
echo "<p><input type='submit' name='returntodash' value='Return to dashboard' /></p>";

 ?>

</body>
</html>
