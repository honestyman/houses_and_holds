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
