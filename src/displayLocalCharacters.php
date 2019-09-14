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
        echo "</td></tr>";
      }
    }
  }
}
 ?>
