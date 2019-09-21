<?php
function charMakeOffline($connect, $char_id)
{
  // check last aggression first
  $sqls = "SELECT * FROM characters WHERE id=" . $char_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $char = $ress->fetch_assoc();

    if(!is_null($char['last_aggression']))
    {
      $now = new DateTime('NOW');
      $now = $now->format('Y-m-d H:i:s');
      $now = strtotime($now);
      $last_aggression = strtotime($char['last_aggression']);
      $aggression_interval = $now-$last_aggression;
    }

    if(is_null($char['last_aggression']) || $aggression_interval > $char['travel_cooldown'])
    {
      $sql = "UPDATE characters SET is_online=0 WHERE id=" . $char_id;
      $result = mysqli_query($connect, $sql);

      $sql = "SELECT * FROM characters WHERE id=" . $char_id;
      $result = mysqli_query($connect, $sql);
      
      if($result->num_rows == 1)
      {
        $char = $result->fetch_assoc();
      }
      else
      {
        echo "<p>Who are you?</p>";
      }
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




  return $char;
}
 ?>
