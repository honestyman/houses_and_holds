<?php
function findUserByEmail($connect, $user_email, $pw, $pw2)
{
  $user_id = 0;

  $sql_a = "SELECT * FROM users WHERE email = '";
  $sql_z = "'";
  $sql1 = "{$sql_a}{$user_email}{$sql_z}";

  $result = mysqli_query($connect, $sql1);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
      $user_id = $row["id"];
      $user_pw = $row["pw"];
    };
    if(password_verify($pw,$user_pw)){
      //$_SESSION["user_id"] = $user_id;
      //header("location:dashboard.php");
      return $user_id;
    } else {
      echo "<p>Password doesn't match.</p>";
      // Logoutfail form
      //echo "<form action='index.php' method='post'>";
      //echo "<input type='submit' name='logoutfail' value='Back to Login' />";
      //echo "</form></p>";
    }
  }
  else
  {
      if($user_email=="") {
        echo "<p>User name (email) cannot be blank.</p>";
        // Logoutfail form
        //echo "<form action='index.php' method='post'>";
        //echo "<input type='submit' name='logoutfail' value='Back to Login' />";
        //echo "</form></p>";
      } else if($pw=="") {
        echo "<p>Password cannot be blank.</p>";
        // Logoutfail form
        //echo "<form action='index.php' method='post'>";
        //echo "<input type='submit' name='logoutfail' value='Back to Login' />";
        //echo "</form></p>";
      } else if($pw==$pw2){
        $hash = password_hash($pw, PASSWORD_DEFAULT);
        $sql_a = "INSERT INTO users(email, pw) VALUES ('";
        $sql_m = "','";
        $sql_z = "')";
        $sql2 = "{$sql_a}{$user_email}{$sql_m}{$hash}{$sql_z}";
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
          // Logoutfail form
          //echo "<form action='index.php' method='post'>";
          //echo "<input type='submit' name='logoutfail' value='Back to Login' />";
          //echo "</form></p>";
        }
      }
      else
      {
        echo "<p>Re-typed password doesn't match.</p>";
        // Logoutfail form
        //echo "<form action='index.php' method='post'>";
        //echo "<input type='submit' name='logoutfail' value='Back to Login' />";
        //echo "</form></p>";
    }
  };
}
?>
