<?php
function charTravel($connect, $char_id, $new_loc_id)
{
  $sql_a = "UPDATE characters SET location_id=";
  $sql_b = " WHERE id=";
  $sql = "{$sql_a}{$new_loc_id}{$sql_b}{$char_id}";
  $result = mysqli_query($connect, $sql);
}
 ?>
