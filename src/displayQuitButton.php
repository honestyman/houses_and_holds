<?php
function displayQuitButton($user_email, $user_id, $char_id, $location_id)
{
  echo "<form action='index.php' method='post'>";
  echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
  echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
  echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
  echo "<input type='hidden' name='location_id' value='" . $location_id . "' />";
  echo "<input type='submit' name='quit' value='Quit to dashboard' />";
  echo "</form>";
}
 ?>
