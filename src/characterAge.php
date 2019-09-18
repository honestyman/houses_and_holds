<?php
function characterAge($birth_date)
{
  // Calculate how old character is in days
  $birth = strtotime($birth_date);
  $now = new DateTime('NOW');
  $now = $now->format('Y-m-d H:i:s');
  $now = strtotime($now);
  $days = ($now-$birth)/(60*60*24);

  if($days < 7)
  {
    return "child";
  }
  else if($days < 21)
  {
    return "youth";
  }
  else if($days < 63)
  {
    return "adult";
  }
  else
  {
    return "elder";
  }
}
 ?>
