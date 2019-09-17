<?php
function reviewPledges($connect, $char_id, $user_email, $user_id)
{
  $sqls = "SELECT * FROM characters WHERE id=" . $char_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $char = $ress->fetch_assoc();

    if(is_null($char['house_id']))
    {
      echo "<p>You don't belong to a House.</p>";
    }
    else
    {
      $sqlp = "SELECT * FROM pledges WHERE house_id=" . $char['house_id'];
      $resp = mysqli_query($connect, $sqlp);

      if($resp->num_rows > 0)
      {
        // display pledges as a table
        echo "<table><tr><th>Pledges</th></tr>";
        while($pledge = $resp->fetch_assoc())
        {
          // one line
          $sqlc = "SELECT * FROM characters WHERE id=" . $pledge['char_id'];
          $resc = mysqli_query($connect, $sqlc);

          if($resc->num_rows == 1)
          {
            $pc = $resc->fetch_assoc();

            echo "<tr><td>";
            echo $pc['name'];
            echo "</td><td>";

            // Check status, add button
            if($pledge['accepted']==1)
            {
              echo "Accepted";
            }
            else if($pledge['rejected']==1)
            {
              echo "Rejected";
            }
            else
            {
              echo "<form action='interaction.php' method='post'>";
              echo "<select name='decision'>";
              echo "<option value='accept'>Accept</option>";
              echo "<option value='reject'>Reject</option>";
              echo "</select>";
              echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
              echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
              echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
              echo "<input type='hidden' name='pledge_id' value='" . $pledge['id'] . "' />";
              echo "<input type='submit' name='decide_pledge' value='Do' />";
              echo "</form>";
            }

            echo "</td></tr>";
          }
          else
          {
            echo "<p>Oh, this is broken isn't it?</p>";
          }
        }
        echo "</table>";
      }
      else
      {
        echo "<p>Your House has no pledges.</p>";
      }
    }
  }
  else
  {
    echo "<p>WTF, you're not real!</p>";
  }
}
 ?>
