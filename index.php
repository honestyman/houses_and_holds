<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Houses and Holds</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta name="google-signin-client_id" content="433812581070-do8qp17vmag8vhurminr6kdbfloakhm9.apps.googleusercontent.com">
<!--<meta http-equiv="Content=Security-Policy" content="script-src *.housesandholds.com">-->
<script>
function onSignIn(googleUser){
  var profile = googleUser.getBasicProfile();
  $(".landingPage").css("display","none");
  $(".userDashboard").css("display","block");
  $(".activeGame").css("display","none");
  $("#user_pic").attr('src',profile.getImageUrl());
  $("#user_email").text(profile.getEmail());
  var post = {};
  post.user_email = profile.getEmail();
  //post.user_email = "madeup@email.com";
  $.ajax({
    url: "index.php",
    method: "post",
    data: post,
    success: function(res){ console.log(res); }
  })
}

function signOut() {
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
    console.log('User signed out.');
  });
  $(".landingPage").css("display","block");
  $(".userDashboard").css("display","none");
  $(".activeGame").css("display","none");
  $("#pic").attr('src',"");
}

function startPlay() {
  $(".landingPage").css("display","none");
  $(".userDashboard").css("display","none");
  $(".activeGame").css("display","block");
}

function stopPlay() {
  $(".landingPage").css("display","none");
  $(".userDashboard").css("display","block");
  $(".activeGame").css("display","none");
}
</script>
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

// Connect to db
$host_name = 'db5000166612.hosting-data.io';
$database = 'dbs161672';
$user_name = 'dbu219044';
$password = 'Tig3rducky*';
$connect = mysqli_connect($host_name, $user_name, $password, $database);

if (mysqli_errno()) {
die('<p>Failed to connect to MySQL: '.mysql_error().'</p>');
} else {

$user_email = $_POST["user_email"];
echo "<p>Hello, ".$user_email."</p>";

// Look for user in db, add if not found
$sql_a = "SELECT id FROM users WHERE email = '";
$sql_z = "'";
$sql1 = "{$sql_a}{$user_email}{$sql_z}";

$result = mysqli_query($connect, $sql1);
if($result->num_rows > 0) {
while($row = $result->fetch_assoc()){
$user_id = $row["id"];
};
} else {
$sql_a = "INSERT INTO users(email) VALUES ('";
$sql_z = "')";
$sql2 = "{$sql_a}{$user_email}{$sql_z}";
mysqli_query($connect, $sql2);

$result = mysqli_query($connect, $sql);
if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    $user_id = $row["id"];
  };
} else {
  echo "<p>Failed to add user to database.</p>";
}
};

// Replace user email with dummy account for testing
$user_email = "madeup@email.com";

// Grab user characters
$sql_a = "SELECT characters.id, characters.name, users.email FROM characters INNER JOIN users ON characters.user_id = users.id WHERE users.email = '";
$sql_z = "' AND characters.death_date IS NULL";
$sql = "{$sql_a}{$user_email}{$sql_z}";

$result = mysqli_query($connect, $sql);
if($result->num_rows > 0){
echo "<p>Click your character to play.</p>";
echo "<table><tr><th>Living character</th></tr>";
while($row = $result->fetch_assoc()){
$character_id = $row["id"];
echo "<tr><td><a href='#' onclick='startPlay();'>" . $row["name"] . "</a></td></tr>";
};
echo "</table>";
} else {
echo "<p>You have no living character. Create one!</p>";
};

$sql_a = "SELECT characters.id, characters.name, users.email FROM characters INNER JOIN users ON characters.user_id = users.id WHERE users.email = '";
$sql_z = "' AND characters.death_date IS NOT NULL";
$sql = "{$sql_a}{$user_email}{$sql_z}";

$result = mysqli_query($connect, $sql);
if($result->num_rows > 0){
echo "<table><tr><th>Dead characters</th></tr>";
while($row = $result->fetch_assoc()){
echo "<tr><td>" . $row["name"] . "</td></tr>";
};
echo "</table>";
}
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
