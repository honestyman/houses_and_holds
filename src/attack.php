<?php
function attack($connect, $attacker_id, $user_email, $user_id, $victim_id)
{
  $sql_a = "SELECT * FROM characters WHERE id=" . $attacker_id;
  $res_a = mysqli_query($connect, $sql_a);

  if($res_a->num_rows == 1)
  {
    $attacker = $res_a->fetch_assoc();
    $age_a = characterAge($attacker['birth_date']);

    $sql_v = "SELECT * FROM characters WHERE id=" . $victim_id;
    $res_v = mysqli_query($connect, $sql_v);

    if($res_v->num_rows == 1)
    {
      $victim = $res_v->fetch_assoc();
      $age_v = characterAge($victim['birth_date']);
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
