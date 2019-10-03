<?php
function attack($connect, $char_id, $user_email, $user_id, $victim_id)
{
  $sql_a = "SELECT * FROM characters WHERE id=" . $char_id;
  $res_a = mysqli_query($connect, $sql_a);

  if($res_a->num_rows == 1)
  {
    $char = $res_a->fetch_assoc();
    $age_a = characterAge($char['birth_date']);

    $sql_v = "SELECT * FROM characters WHERE id=" . $victim_id;
    $res_v = mysqli_query($connect, $sql_v);

    if($res_v->num_rows == 1)
    {
      $victim = $res_v->fetch_assoc();
      $age_v = characterAge($victim['birth_date']);

      if($age_a=="child")
      {
        $damage = rand(1, 2);
      }
      else if($age_a=="youth")
      {
        $damage = rand(5, 15);
      }
      else if($age_a=="adult")
      {
        $damage = rand(10, 30);
      }
      else if($age_a=="elder")
      {
        $damage = rand(3, 6);
      }
      else
      {
        echo "<p>What are you?</p>";
        $damage = 0;
      }

      echo "<p>Your attack caused " . $damage . " points of damage.</p>";
      $new_health = max(0, $victim['health'] - $damage);

      $sql_u = "UPDATE characters SET health=" . $new_health . " WHERE id=" . $victim_id;
      mysqli_query($connect, $sql_u);

      $sql_c = "UPDATE characters SET last_aggression=CURRENT_TIMESTAMP WHERE id=" . $char_id;
      mysqli_query($connect, $sql_c);

      if($new_health==0)
      {
        $sql_d = "UPDATE characters SET death_date=CURRENT_TIMESTAMP WHERE id=" . $victim_id;
        mysqli_query($connect, $sql_d);

        $sql_o = "UPDATE characters SET is_online=0 WHERE id=" . $victim_id;
        mysqli_query($connect, $sql_o);

        echo "<p>You killed " . $victim['name'] . ".</p>";
      }
    }
    else
    {
      echo "<p>So that didn't work.</p>";
    }
  }
  else
  {
    echo "<p>So that didn't work.</p>";
  }
}
 ?>
