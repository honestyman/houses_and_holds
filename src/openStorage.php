<?php
function openStorage($connect, $char_id, $user_email, $user_id, $storage_id)
{
  // find character's inventory
  $sqlb = "SELECT * FROM storage WHERE character_id=" . $char_id;
  $resb = mysqli_query($connect, $sqlb);

  if($resb->num_rows == 1)
  {
    // select character inventory
    $rowb = $resb->fetch_assoc();
    $inventory_id = $rowb['id'];

    // display objects in the storage unit
    $sqls = "SELECT * FROM items WHERE storage_id=" . $storage_id;
    $ress = mysqli_query($connect, $sqls);

    if($ress->num_rows > 0)
    {
      echo "<table><tr><th>Items in storage container</th></tr>";

      while($item = $ress->fetch_assoc())
      {
        echo "<tr><td>";
        echo $item['name'];
        echo "</td><td>";
        echo "<form action='interaction' method='post'>";
        echo "<input type='hidden' name='item_id' value='" . $item['id'] . "' />";
        echo "<input type='hidden' name='storage_id' value='" . $storage_id . "' />";
        echo "<input type='hidden' name='inventory_id' value='" . $inventory_id . "' />";
        echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
        echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
        echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
        echo "<input type='submit' name='move_item' value='Take' />";
        echo "</form>";
        echo "</td></tr>";
      }

      echo "</table>";
    }
    else
    {
      echo "<p>This storage container is empty.</p>";
    }

    // display items in character inventory
    $sqli = "SELECT * FROM items WHERE storage_id=" . $inventory_id;
    $resi = mysqli_query($connect, $sqli);

    if($resi->num_rows > 0)
    {
      // items
      echo "<table><tr><th>Items in inventory</th></tr>";

      while($itemi = $resi->fetch_assoc())
      {
        echo "<tr><td>";
        echo $itemi['name'];
        echo "</td><td>";
        echo "<form action='interaction' method='post'>";
        echo "<input type='hidden' name='item_id' value='" . $itemi['id'] . "' />";
        echo "<input type='hidden' name='storage_id' value='" . $storage_id . "' />";
        echo "<input type='hidden' name='inventory_id' value='" . $inventory_id . "' />";
        echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
        echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
        echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
        echo "<input type='submit' name='move_item' value='Place' />";
        echo "</form>";
        echo "</td></tr>";
      }

      echo "</table>";
    }
    else
    {
      echo "<p>Your inventory is empty.</p>";
    }
  }
  else
  {
    echo "<p>Well shit.</p>";
  }
}
 ?>
