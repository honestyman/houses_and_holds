<?php
function charMakeOffline($connect, $char_id){
  $sql = "UPDATE characters SET is_online=0 WHERE id=" . $char_id;
  $result = mysqli_query($connect, $sql);

  $sql = "SELECT * FROM characters WHERE id=" . $char_id;
  $result = mysqli_query($connect, $sql);
  if($result->num_rows>0)
  {
    while($row = $result->fetch_assoc())
    {
      // Info to pass to game
      $char = $row;
    }
  }

  return $char;
}
 ?>
