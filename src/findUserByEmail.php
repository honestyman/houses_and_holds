<?php
function findUserByEmail($connect, $user_email, $pw, $pw2){
$sql_a = "SELECT * FROM users WHERE email = '";
$sql_z = "'";
$sql1 = "{$sql_a}{$user_email}{$sql_z}";

$result = mysqli_query($connect, $sql1);
if($result->num_rows > 0) {
  while($row = $result->fetch_assoc()){
    $user_id = $row["id"];
    $user_pw = $row["pw"];
  };
  if($pw==$user_pw){
    return $user_id;
  } else {
    echo "<p>Password doesn't match.</p>";
  }
  } else {
    if($pw==$pw2){
      $sql_a = "INSERT INTO users(email, pw) VALUES ('";
      $sql_m = "','";
      $sql_z = "')";
      $sql2 = "{$sql_a}{$user_email}{$sql_m}{$pw}{$sql_z}";
      mysqli_query($connect, $sql2);

      $result = mysqli_query($connect, $sql1);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $user_id = $row["id"];
        };
        echo "<p>User added successfully!</p>";
        return $user_id;
      } else {
        echo "<p>Failed to add user to database.</p>";
      }
    } else {
      echo "<p>Re-typed password doesn't match.</p>";
    }
  };
}
?>
