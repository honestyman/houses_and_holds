<?php
require_once "characterAge.php";

function displayCharacterStatus($connect, $char)
{
  // Display character age
  $age = characterAge($char['birth_date']);
  echo "<p>Age: ";
  echo $age;
  echo "</p>";

  // hunger level
  $full = $char['fullness'];
  echo "<p>Hunger: ";
  if($full > 9)
  {
    echo "full";
  }
  else if($full > 7)
  {
    echo "not hungry";
  }
  else if($full > 5)
  {
    echo "a little hungry";
  }
  else if($full > 3)
  {
    echo "hungry";
  }
  else if($full > 1)
  {
    echo "very hungry";
  }
  else
  {
    echo "starving";
  }
  echo "</p>";

  // health
  $health = $char['health'];
  echo "<p>Health: ";
  echo $health;
  echo "%</p>";
}
 ?>
