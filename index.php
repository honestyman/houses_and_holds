<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Houses and Holds</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta name="google-signin-client_id" content="433812581070-do8qp17vmag8vhurminr6kdbfloakhm9.apps.googleusercontent.com">
<!--<meta http-equiv="Content=Security-Policy" content="script-src *.housesandholds.com">-->
<script src="/src/onSignIn.js"></script>
<script src="/src/signOut.js"></script>
<script src="/src/startPlay.js"></script>
<script src="/src/stopPlay.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
  .landingPage {
    display: block;
  }

  .userDashboard {
    display: none;
  }

  .activeGame {
    display: none;
  }
</style>
</head>
<body>

<div class="landingPage">
  <h1>Houses and Holds</h1>
  <div class="g-signin2" data-onsuccess="onSignIn"></div>
</div>

<div class="userDashboard">
  <h1>Houses and Holds</h1>
  <img id="user_pic" class="img-circle" width="100" height="100" />
  <p><span id="user_email"></span></p>
  <button class="btn btn-danger" onclick="signOut();">Sign out</button>

  <?php
    require_once 'src/dbConnect.php';
    require_once 'src/findUserByEmail.php';
    require_once 'src/displayUserCharacters.php';

    // Connect to db
    $connect = dbConnect();

    if (mysqli_errno()) {
    die('<p>Failed to connect to MySQL: '.mysql_error().'</p>');
    } else {
      $user_email = $_POST["user_email"];
      echo "<p>Hello, ".$user_email."</p>";

      // Look for user in db, add if not found
      $user_id = findUserByEmail($user_email);

      // Replace user email with dummy account for testing
      $user_email = "madeup@email.com";

      // Query db for characters based on user email
      displayUserCharacters($user_email);
    }
  ?>
</div>

<div class="activeGame">
<h1>Houses and Holds</h1>
<button class="btn btn-warning" onclick="stopPlay();">Stop playing</button>
<button class="btn btn-danger" onclick="signOut();">Sign out</button>
</div>

</body>
</html>
