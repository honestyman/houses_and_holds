<?php
function openInventory($connect, $user_email, $user_id, $char_id, $inventory)
{
  // find and display items in the inventory
  $sqls = "SELECT * FROM items WHERE storage_id=" . $inventory['id'];
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows > 0)
  {
    // display items
    echo "<table><tr><th>Items in your inventory</th></tr>";

    while($item = $ress->fetch_assoc())
    {
      echo "<tr><td>";
      echo $item['name'];

      // add interactions if available
      $class_id = $item['class_id'];
      $sqli = "SELECT * FROM class_interactions WHERE class_id=" . $class_id;
      $resulti = mysqli_query($connect, $sqli);

      if($resulti->num_rows > 0)
      {
        echo "</td><td>";
        echo "<form action='interaction.php' method='post'>";
        echo "<select name='interaction'>";

        while($rowi = $resulti->fetch_assoc())
        {
          echo "<option value='" . $rowi['name'] . "'>" . $rowi['displayname'] . "</option>";
        }

        echo "</select>";
        echo "<input type='hidden' name='obj_id' value='" . $item['id'] . "' />";
        echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
        echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
        echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
        echo "<input type='submit' name='interact' value='Do' />";
        echo "</form>";
      }

      echo "</td></tr>";
    }

    echo "</table>";
  }
  else
  {
    echo "<p>Your inventory is empty.</p>";
  }
}
 ?>
