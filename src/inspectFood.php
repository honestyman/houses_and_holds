<?php
function inspectFood($connect, $char_id, $user_email, $user_id, $food_id)
{
  $sqls = "SELECT * FROM items WHERE id=" . $food_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $food = $ress->fetch_assoc();

    $now = new DateTime('NOW');
    $now = $now->format('Y-m-d H:i:s');
    $now = strtotime($now) + (3600*6);
    $created = strtotime($food['created']);
    $interval = $now - $created;



    if($interval > $food['duration_s'])
    {
      $sqld = "DELETE FROM items WHERE id=" . $food_id;
      mysqli_query($connect, $sqld);
      echo "<p>This was a " . $food['quality'] . " " . $food['name'] . ", but it's rotten. You throw it away.</p>";
    }
    else
    {
      echo "<p>This is a " . $food['quality'] . " " . $food['name'] . ".</p>";
    }
  }
  else
  {
    echo "<p>That's not good.</p>";
  }
}
 ?>
