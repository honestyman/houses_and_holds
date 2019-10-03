<?php
require_once "characterAge.php";

function updateCooldown($connect, $char)
{
  $age = characterAge($char['birth_date']);
  if($age == 'child'){ $travel_cd = 10.0; }
  else if($age == 'youth'){ $travel_cd = 20.0; }
  else if($age == 'adult'){ $travel_cd = 30.0; }
  else if($age == 'elder'){ $travel_cd = 30.0; }
  else { echo "wtf mate"; $travel_cd = 30.0; }

  $sql_u = "UPDATE characters SET travel_cooldown=" . $travel_cd . " WHERE id=" . $char['id'];
  mysqli_query($connect, $sql_u);
}
 ?>
