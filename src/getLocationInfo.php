<?php
function getLocationInfo($connect, $location_id)
{
  $sql = "SELECT * FROM locations WHERE id=" . $location_id;
  $result = mysqli_query($connect, $sql);

  if($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $location = $row;
    }
  }

  return $location;
}
 ?>
