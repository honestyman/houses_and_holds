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
