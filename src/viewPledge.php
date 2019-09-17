<?php
function viewPledge($connect, $char_id, $user_email, $user_id)
{
  $sqls = "SELECT * FROM pledges WHERE char_id=" . $char_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    // display
    $rows = $ress->fetch_assoc();

    $sqlh = "SELECT * FROM houses WHERE id=" . $rows['house_id'];
    $resh = mysqli_query($connect, $sqlh);

    if($resh->num_rows == 1)
    {
      // house info
      $rowh = $resh->fetch_assoc();

      echo "<p>You've pledged to House " . $rowh['name'] . ".</p>";

      if($rows['accepted']==1)
      {
        echo "<p>Your pledge was accepted.</p>";
      }
      else if($rows['rejected']==1)
      {
        echo "<p>Your pledge was rejected.</p>";
      }
      else
      {
        echo "<p>Your pledge is still open.</p>";

        echo "<form action='interaction.php' method='post'>";
        echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
        echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
        echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
        echo "<p><input type='submit' name='withdraw_pledge' value='Withdraw pledge' /></p>";
        echo "</form>";
      }
    }
    else
    {
      echo "<p>Oh shit.</p>";
    }

  }
  else if($ress->num_rows == 0)
  {
    // no pledge
    echo "<p>You have not pledged fealty to a House.</p>";
  }
  else
  {
    echo "<p>Bad game, no cookie for you!</p>";
  }
}
 ?>
