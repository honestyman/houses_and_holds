<?php
require_once "characterAge.php";

function pledgeHouse($connect, $char_id, $user_email, $user_id)
{
  // check character's age
  $sqls = "SELECT * FROM characters WHERE id=" . $char_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $char = $ress->fetch_assoc();
    $age = characterAge($char['birth_date']);

    if($age == 'child')
    {
      echo "<p>Children cannot pledge loyalty to a House.</p>";
    }
    else if($age == 'youth' || $age == 'adult' || $age == 'elder')
    {
      echo "<form action='interaction.php' method='post'>";
      echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
      echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
      echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
      echo "<p><input type='text' name='house_name' placeholder='Enter name of House' size='40' /></p>";
      echo "<p><input type='submit' name='pledge_house' value='Submit' /></p>";
    }
    else
    {
      echo "<p>Oh shit.</p>";
    }

  }
  else
  {
    echo "<p>Uh oh!</p>";
  }
}
 ?>
