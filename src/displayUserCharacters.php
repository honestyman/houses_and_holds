<?php
session_start();

function displayUserCharacters($connect, $user_email){
  $sql_a = "SELECT id FROM users WHERE email='";
  $sql_z = "'";
  $sql = "{$sql_a}{$user_email}{$sql_z}";

  $result = mysqli_query($connect, $sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $user_id = row['id'];
    }

    $sql_a = "SELECT * FROM characters WHERE user_id = '";
    $sql_z = "' AND characters.death_date IS NULL";
    $sql = "{$sql_a}{$user_id}{$sql_z}";

    $result = mysqli_query($connect, $sql);
    if($result->num_rows > 0){
      echo "<table><tr><th>Living character</th></tr>";
      while($row = $result->fetch_assoc()){
        $character_id = $row["id"];
          echo "<tr><td>" . $row["name"] . "</td><td><form action='game.php' method='post'><input type='hidden' name='char_id' value='" . $row["id"] . "' /><input type='hidden' name='user_id' value='" . $user_id . "' /><input type='submit' name='play' value='Play' /></form></td></tr>";
        };
      echo "</table>";
    } else {
      echo "<p>You have no living character. Create one!</p>";
    };

    $sql_a = "SELECT * FROM characters WHERE user_id = '";
    $sql_z = "' AND characters.death_date IS NOT NULL";
    $sql = "{$sql_a}{$user_id}{$sql_z}";

    $result = mysqli_query($connect, $sql);
    if($result->num_rows > 0){
      echo "<table><tr><th>Dead characters</th></tr>";
      while($row = $result->fetch_assoc()){
        echo "<tr><td>" . $row["name"] . "</td><td><button class='btn btn-default'>View</button></td></tr>";
        };
      echo "</table>";
    }
  } else {
    echo "Uh oh! Email not found in database.";
  }
}
?>
