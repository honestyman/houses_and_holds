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

  if(isset($_POST['newpassword']))
  {
    $user_email = $_POST['user_email'];
    $pw1 = htmlspecialchars($_POST['pw1']);
    $pw2 = htmlspecialchars($_POST['pw2']);
    $token_id = $_POST['token_id'];

    if($pw1==$pw2)
    {
      // Check whether user exists
      $sql1 = "SELECT * FROM users WHERE email='" . $user_email . "'";
      $result1 = mysqli_query($connect, $sql1);

      if($result1->num_rows > 1)
      {
        echo "Uh oh, something went wrong!";
      }
      else if($result1->num_rows < 1)
      {
        echo "<p>User email not found. Adding as new user.</p>";
        $hash = password_hash($pw1, PASSWORD_DEFAULT);
        $sql2 = "INSERT INTO users (email, pw) VALUES ('" . $user_email . "', '" . $hash . "')";
        $result2 = mysqli_query($connect, $sql2);
      }
      else
      {
        // Update password
        $hash = password_hash($pw1, PASSWORD_DEFAULT);
        $sql3 = "UPDATE users SET pw='" . $hash . "' WHERE email='" . $user_email . "'";
        $result3 = mysqli_query($connect, $sql3);
      }

      // Done with token, delete
      $sql4 = "DELETE FROM password_reset WHERE id=" . $token_id;
      $result4 = mysqli_query($connect, $sql4);
    }
    else
    {
      echo "<p>Re-typed password doesn't match the first.</p>";
    }
  }
  //echo $_GET['token'];

  if(isset($_GET['token']))
  {
    $token = $_GET['token'];
    $onehourago = date('Y-m-d H:i:s', strtotime('-1 hour'));
    $sql = "SELECT * FROM password_reset WHERE created > '" . $onehourago . "'";
    $result = mysqli_query($connect, $sql);

    if($result->num_rows < 1)
    {
      echo "<p>No valid reset token.</p>";
    }
    else if($result->num_rows > 1)
    {
      echo "<p>Uh oh! Something went wrong.</p>";
    }
    else
    {
      // Single token found, change password
      while($row = $result->fetch_assoc())
      {
        $user_token = $row['token'];
        if(password_verify($token, $user_token))
        {
          $user_email = $row['email'];
          echo "<p>Password reset token accepted.</p>";
          echo "<form action='accountrecovery.php' method='post'>";
          echo "<p><input type='password' name='pw1' placeholder='Enter new password' size='40' /></p>";
          echo "<p><input type='password' name='pw2' placeholder='Re-type new password' size='40' /></p>";
          echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
          echo "<input type='hidden' name='token_id' value='" . $row['id'] . "' />";
          echo "<input type='submit' name='newpassword' value='Submit' />";
          echo "</form>";
        }
        else
        {
          echo "<p>Reset token not valid.</p>";
        }
      }
    }
  }

  else
  {

    if(isset($_POST['requestreset']))
    {
      $user_email = htmlspecialchars($_POST['user_email']);

      // Create tokens
      //$selector = bin2hex(random_bytes(8));
      $token = bin2hex(random_bytes(32));

      //$url = sprintf('%accountrecovery.php?%s', ABS_URL, http_build_query([
        //'selector' => $selector,
        //'validator' => bin2hex($token)
      //]));
      $url = "https://www.housesandholds.com/accountrecovery.php?token=" . $token;

      // Token expiration
      //$expires = new DateTime('NOW');
      //$expires->add(new DateInterval('PT01H')); // 1 hour

      // Delete any existing tokens for this user
      $sqld = "DELETE FROM password_reset WHERE email='" . $user_email . "'";
      $resultd = mysqli_query($connect, $sqld);

      $sqli = "INSERT INTO password_reset (email, token, created) VALUES ('" . $user_email . "', '" . password_hash($token, PASSWORD_DEFAULT) ."', CURRENT_TIMESTAMP)";
      $resulti = mysqli_query($connect, $sqli);

      // Send the email
      // Recipient
      $to = $user_email;

      // Subject
      $subject = 'Your password reset link';

      // Message
      $message = '<p>We recieved a password reset request. The link to reset your password is below. ';
      $message .= 'If you did not make this request, you can ignore this email.</p>';
      $message .= '<p>Here is your password reset link:<br />';
      $message .= '<a href="' . $url . '">' . $url . '</a></p>';
      $message .= '<p>Thanks!</p>';

      // Headers
      $headers = "From: Admin Houses and Holds <admin@housesandholds.com>\r\n";
      $headers .= "Reply-To: admin@housesandholds.com\r\n";
      $headers .= "Content-type: text/html\r\n";

      // Send email
      $sent = mail($to, $subject, $message, $headers);
    }
    else
    {
      echo "<p>Enter your email in the field below. If the account exist, a reset link will be sent to that email.</p>";
      echo "<form action='accountrecovery.php' method='post'>";
      echo "<p><input type='email' name='user_email' placeholder='Email' size='40' /></p>";
      echo "<p><input type='submit' name='requestreset' value='Submit'></p>";
      echo "</form>";
    }
  }
}

 ?>

 <a href="index.php">Go back to login</a>

</body>
</html>
