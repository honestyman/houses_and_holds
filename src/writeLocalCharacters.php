<?php
function writeLocalCharacters($connect, $location)
{
  $sql = "SELECT * FROM characters WHERE is_online=1 AND location_id=" . $location['id'];
  $result = mysqli_query($connect, $sql);

  if($result->num_rows > 0)
  {
    $path = "gamelogs/charsLoc" . $location['id'] . ".html";
    $fp = fopen($path, 'w+');
    fwrite($fp, "<table><tr><th>People</th></tr>");

    while($row = $result->fetch_assoc())
    {
      fwrite($fp, "<tr><td>");
      fwrite($fp, $row['name']);
      fwrite($fp, "</td></tr>");
    }

    fwrite($fp, "</table>");
    fclose($fp);
  }
}
 ?>
