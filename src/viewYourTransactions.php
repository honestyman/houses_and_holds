<?php
require_once "src/displayTransactionItems.php";

function viewYourTransactions($connect, $char_id, $user_email, $user_id)
{
  // display open trransactions
  $sqlo = "SELECT * FROM character_transactions WHERE character_id=" . $char_id . " AND is_closed=0";
  $reso = mysqli_query($connect, $sqlo);

  if($reso->num_rows > 0)
  {
    echo "<table><tr><th>Open transactions</th></tr>";

    while($transo = $reso->fetch_assoc())
    {
      echo "<tr><td>";
      echo $transo['created'];
      echo "</td><td>";
      echo displayTransactionItems($connect, $transo['items']);

      // Add interaction option, if available
      $class_id = 10; // All own transactions have class id 10
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
        echo "<input type='hidden' name='obj_id' value='" . $row1['id'] . "' />";
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
    echo "<p>No open transactions.</p>";
  }

  $sqlc = "SELECT * FROM character_transactions WHERE character_id=" . $char_id . " AND is_closed=1";
  $resc = mysqli_query($connect, $sqlc);

  if($resc->num_rows > 0)
  {
    echo "<table><tr><th>Closed transactions</th></tr>";

    while($transc = $resc->fetch_assoc())
    {
      echo "<tr><td>";
      echo $transc['id'];
      echo "</td><td>";
      echo displayTransactionItems($connect, $transc['items']);
      echo "</td></tr>";
    }

    echo "</table>";
  }
}
 ?>
