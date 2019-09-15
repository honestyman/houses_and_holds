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
        echo "</td></tr>";
      }
    }

    if($result2->num_rows > 0)
    {
      while($row2 = $result2->fetch_assoc())
      {
        echo "<tr><td>";
        echo $row2['name'];
        echo "</td></tr>";
      }
    }

    if($result3->num_rows > 0)
    {
      while($row3 = $result3->fetch_assoc())
      {
        echo "<tr><td>";
        echo $row3['name'];
        echo "</td></tr>";
      }
    }

    echo "</table>";
  }
}
 ?>
