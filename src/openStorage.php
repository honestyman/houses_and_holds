<?php
function openStorage($connect, $char_id, $user_email, $user_id, $storage_id)
{
  // check whether character is allowed to open storage
  $allowed = 0;

  $sqls = "SELECT * FROM storage WHERE id=" . $storage_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $storage = $ress->fetch_assoc();
    $loc = $storage['location_id'];

    $sqll = "SELECT * FROM locations WHERE id=" . $loc;
    $resl = mysqli_query($connect, $sqll);

    if($resl->num_rows == 1)
    {
      $location = $resl->fetch_assoc();
       if($location['is_hold'] == 0)
       {
         $allowed = 1;
       }
       else
       {
         $hold_id = $location['hold_id'];

         $sqlh = "SELECT * FROM holds WHERE id=" . $hold_id;
         $resh = mysqli_query($connect, $sqlh);

         if($resh->num_rows == 1)
         {
           $hold = $resh->fetch_assoc();

           if(!is_null($hold['house_id']))
           {
             $house_id = $hold['house_id'];

             $sqlc = "SELECT * FROM characters WHERE id=" . $char_id;
             $resc = mysqli_query($connect, $sqlc);

             if($resc->num_rows == 1)
             {
               $char = $resc->fetch_assoc();

               if($char['house_id'] == $house_id)
               {
                 $allowed = 1;
               }
             }
             else
             {
               echo "<p>Oh shit.</p>";
             }
           }
         }
         else
         {
           echo "<p>Oh shit.</p>";
         }
       }
    }
    else
    {
      echo "<p>Oh shit.</p>";
    }
  }
  else
  {
    echo "<p>Oh shit.</p>";
  }

  if($allowed == 1)
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
  else
  {
    echo "<p>You're not allowed to open this container.</p>";
  }


}
 ?>
