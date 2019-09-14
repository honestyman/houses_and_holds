<?php
function displayNavigation($connect, $user_email, $user_id, $char_id, $location)
{
  $sql = "SELECT location_connections.end_location, locations.name FROM location_connections LEFT JOIN locations ON location_connections.end_location = locations.id WHERE location_connections.start_location = " . $location['id'];
  $result = mysqli_query($connect, $sql);

  if($result->num_rows > 0)
  {
    echo "<table><tr><th>Navigation</th></tr>";
    while($row = $result->fetch_assoc())
    {
      echo "<tr><td>";
      echo $row['name'];
      echo "</td><td>";
      echo "<form action='index.php' method='post'>";
      echo "<input type='hidden' name='new_loc_id' value='" . $row['end_location'] . "' />";
      echo "<input type='hidden' name='old_loc_id' value='" . $location['id'] . "' />";
      echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
      echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
      echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
      echo "<input type='submit' name='travel' value='Travel' />";
      echo "</form>";
      echo "</td></tr>";
    }
    echo "</table>";
  }
  else {
    echo "<p>Uh oh. Dead end.</p>";
  }
}
 ?>
