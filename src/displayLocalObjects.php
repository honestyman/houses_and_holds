<?php
function displayLocalObjects($connect, $user_email, $user_id, $char, $location)
{
  $sql1 = "SELECT * FROM banner_posts WHERE location_id=" . $location['id'];
  $result1 = mysqli_query($connect, $sql1);
  $sql2 = "SELECT * FROM fixtures WHERE location_id=" . $location['id'];
  $result2 = mysqli_query($connect, $sql2);
  $sql3 = "SELECT * FROM storage WHERE location_id=" . $location['id'];
  $result3 = mysqli_query($connect, $sql3);

  if($result1->num_rows + $result2->num_rows + $result3->num_rows > 0)
  {
    echo "<table><tr><th>Objects</th></tr>";

    if($result1->num_rows > 0)
    {
      while($row1 = $result1->fetch_assoc())
      {
        echo "<tr><td>";
        echo $row1['name'];

        // Add interaction option, if available
        $class_id = 1; // All banner posts have class id 1
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
          echo "<input type='hidden' name='obj_id' value='" . $row1['id'] . "' />";
          echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
          echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
          echo "<input type='hidden' name='char_id' value='" . $char['id'] . "' />";
          echo "<input type='submit' name='interact' value='Do' />";
          echo "</form>";
        }

        echo "</td></tr>";
      }
    }

    if($result2->num_rows > 0)
    {
      while($row2 = $result2->fetch_assoc())
      {
        echo "<tr><td>";
        echo $row2['name'];

        // Add interaction option, if available
        $class_id = $row2['class_id']; // Fixtures each have a class depending on what they do
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
          echo "<input type='hidden' name='obj_id' value='" . $row2['id'] . "' />";
          echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
          echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
          echo "<input type='hidden' name='char_id' value='" . $char['id'] . "' />";
          echo "<input type='submit' name='interact' value='Do' />";
          echo "</form>";
        }

        echo "</td></tr>";
      }
    }

    if($result3->num_rows > 0)
    {
      while($row3 = $result3->fetch_assoc())
      {
        echo "<tr><td>";
        echo $row3['name'];

        // Add interaction option, if available
        $class_id = 2; // All storage units have class id 2
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
          echo "<input type='hidden' name='obj_id' value='" . $row3['id'] . "' />";
          echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
          echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
          echo "<input type='hidden' name='char_id' value='" . $char['id'] . "' />";
          echo "<input type='submit' name='interact' value='Do' />";
          echo "</form>";
        }

        echo "</td></tr>";
      }
    }

    echo "</table>";
  }
}
 ?>
