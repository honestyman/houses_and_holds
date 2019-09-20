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
