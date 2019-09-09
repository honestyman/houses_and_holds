<?php
function displayUserCharacters($connect, $user_id){
  $sql_a = "SELECT * FROM characters WHERE user_id = '";
  $sql_z = "' AND characters.death_date IS NULL";
  $sql = "{$sql_a}{$user_id}{$sql_z}";

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

  $sql_a = "SELECT * FROM characters WHERE user_id = '";
  $sql_z = "' AND characters.death_date IS NOT NULL";
  $sql = "{$sql_a}{$user_id}{$sql_z}";

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
