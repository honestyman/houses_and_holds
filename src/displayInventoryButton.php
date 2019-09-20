<?php
function displayInventoryButton($connect, $user_email, $user_id, $char_id)
{
  echo "<form action='interaction.php' method='post'>";
  echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
  echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
  echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
  echo "<input type='submit' name='open_inventory' value='Open inventory' />";
  echo "</form>";
}
 ?>
