<?php
function charTravel($connect, $char_id, $new_loc_id)
{
  // check character's last aggression
  $sqls = "SELECT * FROM characters WHERE id=" . $char_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $char = $ress->fetch_assoc();

    if(!is_null($char['last_aggression']))
    {
      $now = new DateTime('NOW');
      $now = $now->format('Y-m-d H:i:s');
      $now = strtotime($now) + (3600*6);
      $last_aggression = strtotime($char['last_aggression']);
      $aggression_interval = $now-$last_aggression;
    }

    if(is_null($char['last_aggression']) || $aggression_interval > $char['travel_cooldown'])
    {
      $sqlu = "UPDATE characters SET location_id=" . $new_loc_id . " WHERE id=" . $char_id;
      mysqli_query($connect, $sqlu);
    }
    else
    {
      echo "<p>You can't do that yet.</p>";
    }
  }
  else
  {
    echo "<p>Who are you?</p>";
  }
}
 ?>
