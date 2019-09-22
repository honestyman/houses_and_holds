<?php
function createTransaction($connect, $char_id, $user_email, $user_id)
{
  // find all char items and display with checkboxes
  $sqls1 = "SELECT * FROM storage WHERE character_id=" . $char_id;
  $ress1 = mysqli_query($connect, $sqls1);

  if($ress1->num_rows == 1)
  {
    $satchel = $ress1->fetch_assoc();

    $sqls2 = "SELECT * FROM items WHERE storage_id=" . $satchel['id'];
    $ress2 = mysqli_query($connect, $sqls2);

    if($ress2->num_rows > 0)
    {
      echo "<p>Select the items you'd like to include in this transaction:</p>";
      echo "<form action='interaction.php' method='post'>";
      echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
      echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
      echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";

      while($item = $ress2->fetch_assoc())
      {
        echo "<p><input type='checkbox' name='" . $item['id'] . "' />" . $item['name'] . "</p>";
      }

      echo "<p><input type='submit' name='create_trade_items' value='Submit'></p>";
      echo "</form>";
    }
    else
    {
      echo "<p>You have no items in your inventory to trade.</p>";
    }
  }
  else
  {
    echo "<p>This is not working.</p>";
  }


}
 ?>
