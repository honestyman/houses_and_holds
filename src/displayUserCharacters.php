<?php
function displayUserCharacters($connect, $user_id, $user_email)
{
    $sql_a = "SELECT name, id FROM characters WHERE user_id = '";
    $sql_z = "' AND characters.death_date IS NULL";
    $sql = "{$sql_a}{$user_id}{$sql_z}";

    $result = mysqli_query($connect, $sql);
    if($result->num_rows > 0)
    {
      echo "<table><tr><th>Living character</th></tr>";
      while($row = $result->fetch_assoc())
      {
        echo "<tr><td>";
        echo $row["name"];
        echo "</td><td>";
        echo "<form action='index.php' method='post'>";
        echo "<input type='hidden' name='char_id' value='" . $row["id"] . "' />";
        echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
        echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
        echo "<input type='submit' name='play' value='Play' />";
        echo "</form>";
        echo "</td></tr>";
      };
      echo "</table>";
    }
    else
    {
      echo "<p>You have no living character. ";
      echo "<form action='createcharacter.php' method='post'>";
      echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
      echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
      echo "<input type='submit' name='newchar' value='Create one!' /></p>";
    };

    $sql_a = "SELECT name, id FROM characters WHERE user_id = '";
    $sql_z = "' AND characters.death_date IS NOT NULL";
    $sql = "{$sql_a}{$user_id}{$sql_z}";

    $result = mysqli_query($connect, $sql);
    if($result->num_rows > 0)
    {
      echo "<table><tr><th>Dead characters</th></tr>";
      while($row = $result->fetch_assoc()){
        echo "<tr><td>";
        echo $row["name"];
        echo "</td><td>";
        echo "<form action='index.php' method='post'>";
        echo "<input type='hidden' name='char_id' value='" . $row["id"] . "' />";
        echo "<input type='submit' name='view' value='View' />";
        echo "</td></tr>";
        };
      echo "</table>";
    }

}
?>
