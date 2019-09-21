<?php
function eat($connect, $char_id, $user_email, $user_id, $food_id)
{
  // check character fullness
  $sqlc = "SELECT * FROM characters WHERE id=" . $char_id;
  $resc = mysqli_query($connect, $sqlc);

  if($resc->num_rows == 1)
  {
    $char = $resc->fetch_assoc();

    if($char['fullness'] >= 10)
    {
      echo "<p>You're too full to eat.</p>";
    }
    else
    {
      // get food info
      $sqlf = "SELECT * FROM items WHERE id=" . $food_id;
      $resf = mysqli_query($connect, $sqlf);

      if($resf->num_rows == 1)
      {
        $food = $resf->fetch_assoc();

        // check if food is spoiled
        $creation = strtotime($food['created']);
        $now = new DateTime('NOW');
        $now = $now->format('Y-m-d H:i:s');
        $now = strtotime($now);
        $duration = $now-$creation;

        if($duration > $food['duration_s'])
        {
          $sqld = "DELETE FROM items WHERE id=" . $food_id;
          mysqli_query($connect, $sqld);
          echo "<p>The food is rotten. You throw it away.</p>";
        }
        else
        {
          $new_fullness = min(10, $char['fullness'] + $food['weight']);
          $sqlu = "UPDATE characters SET fullness=" . $new_fullness . " WHERE id=" . $char_id;
          mysqli_query($connect, $sqlu);
          $sqld = "DELETE FROM items WHERE id=" . $food_id;
          mysqli_query($connect, $sqld);
          echo "<p>You ate the food.</p>";
        }
      }
      else
      {
        echo "<p>Welp. That's wrong.</p>";
      }
    }
  }
  else
  {
    echo "<p>Welp. That's wrong.</p>";
  }
}
 ?>
