<?php
function viewOpenTransactions($connect, $char_id, $user_email, $user_id)
{
  $sqls = "SELECT * FROM character_transactions WHERE is_closed=0 AND character_id!=" . $char_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows > 0)
  {
    echo "<table><tr><th>Open transactions</th></tr>";

    while($transo = $ress->fetch_assoc())
    {
      echo "<tr><td>";
      echo $transo['created'];
      echo "</td><td>";
      echo displayTransactionItems($connect, $transo['items']);

      // Add interaction option, if available
      $class_id = 11; // All external transactions have class id 11
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
        echo "<input type='hidden' name='obj_id' value='" . $transo['id'] . "' />";
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
    echo "<p>There are no open transactions at this time.</p>";
  }
}
 ?>
