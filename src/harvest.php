<?php
function harvest($connect, $char_id, $user_email, $user_id, $food_source_id)
{
  // check whether character is allowed to use this object
  $allowed = 0;

  $sqls = "SELECT * FROM fixtures WHERE id=" . $food_source_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $fixture = $ress->fetch_assoc();
    $loc = $fixture['location_id'];

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
    // get info on food source
    $sqlfs = "SELECT * FROM fixtures WHERE id=" . $food_source_id;
    $resfs = mysqli_query($connect, $sqlfs);

    if($resfs->num_rows == 1)
    {
      // found it, load info into var
      $food_source = $resfs->fetch_assoc();

      // find character's inventory
      $sqlci = "SELECT * FROM storage WHERE character_id=" . $char_id;
      $resci = mysqli_query($connect, $sqlci);

      if($resci->num_rows == 1)
      {
        // found it, load info into var
        $inventory = $resci->fetch_assoc();

        // find all items in inventory and add their weight
        $sqlsi = "SELECT * FROM items WHERE storage_id=" . $inventory['id'];
        $ressi = mysqli_query($connect, $sqlsi);

        // subtract the weight of the items in the inventory from its capacity
        $inventory_free = $inventory['capacity'];
        if($ressi->num_rows > 0)
        {
          while($item = $ressi->fetch_assoc())
          {
            $inventory_free -= $item['weight'];
          }
        }

        // compare the weight of contructed items to free inventory space
        if($inventory_free >= $food_source['contruct_num'] * $food_source['construct_weight'])
        {
          // check how long it's been since the last usage of the food source
          if(!is_null($food_source['last_used']))
          {
            $now = new DateTime('NOW');
            $now = $now->format('Y-m-d H:i:s');
            $now = strtotime($now);
            $last = strtotime($food_source['last_used']);
            $interval = $now - $last;
          }

          if($interval > $food_source['interval_s'] || is_null($food_source['last_used']))
          {
            // place construct in character inventory
            for($i = 0; $i < $food_source['construct_num']; $i++)
            {
              $sqli = "INSERT INTO items(storage_id, name, quality, class_id, weight, created) VALUES (" . $inventory['id'] . ", '" . $food_source['construct_name'] . "', '" . $food_source['construct_quality'] . "', " . $food_source['construct_class'] . ", " . $food_source['construct_weight'] . ", CURRENT_TIMESTAMP)";
              mysqli_query($connect, $sqli);
              $sqlu = "UPDATE fixtures SET last_used=CURRENT_TIMESTAMP WHERE id=" . $food_source['id'];
              mysqli_query($connect, $sqlu);
              echo "<p>You've collected " . $food_source['construct_num'] . " " . $food_source['construct_name'] . "(s).</p>";
            }
          }
          else
          {
            echo "<p>It's too soon to collect again.</p>";
          }
        }
        else
        {
          echo "<p>You don't have enough room in your inventory to collect this item.</p>";
        }

      }
      else
      {
        echo "<p>Oh this is bad.</p>";
      }
    }
    else
    {
      echo "<p>Oh this is bad.</p>";
    }
  }
  else
  {
    echo "<p>You're not allowed to use this object.</p>";
  }

}
 ?>
