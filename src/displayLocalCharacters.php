<?php
function displayLocalCharacters($connect, $user_email, $user_id, $char, $location)
{
  $sql = "SELECT * FROM characters WHERE is_online=1 AND location_id=" . $location['id'];
  $result = mysqli_query($connect, $sql);

  if($result->num_rows > 1)
  {
    echo "<table><tr><th>People</th></tr>";

    while($row = $result->fetch_assoc())
    {
      if($row['id'] != $char['id'])
      {
        echo "<tr><td>";
        echo $row['name'];

        if(!is_null($row['house_id']))
        {
          $sqlh = "SELECT * FROM houses WHERE id=" . $row['house_id'];
          $resh = mysqli_query($connect, $sqlh);

          if($resh->num_rows == 1)
          {
            $house = $resh->fetch_assoc();
            echo " " . $house['name'];
          }
          else
          {
            echo "What the shit";
          }
        }

        // Add interaction option, if available
        $class_id = 8; // All characters have class id 8
        $sqli = "SELECT * FROM class_interactions WHERE class_id=" . $class_id;
        $resulti = mysqli_query($connect, $sqli);

        if($resulti->num_rows > 0)
        {
          echo "</td><td>";
          echo "<form action='interaction.php' method='post'>";
          echo "<select name='interaction'>";

          while($rowi = $resulti->fetch_assoc())
          {
            echo "<option value='" . $rowi['name'] . "'>" . $rowi['displayname'] . "</option>";
          }

          echo "</select>";
          echo "<input type='hidden' name='obj_id' value='" . $row['id'] . "' />";
          echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
          echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
          echo "<input type='hidden' name='char_id' value='" . $char['id'] . "' />";
          echo "<input type='submit' name='interact' value='Do' />";
          echo "</form>";
        }

        echo "</td></tr>";
      }
    }
  }
}
 ?>
