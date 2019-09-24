<?php
function inspectTransaction($connect, $char_id, $user_email, $user_id, $transaction_id)
{
  $sqls = "SELECT * FROM character_transactions WHERE id=" . $transaction_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $transaction = $ress->fetch_assoc();

    $items = explode(",", $transaction['items']);
    if(count($items)>0)
    {
      echo "<table><tr><th></th></tr>";

      foreach($items as $item)
      {
        // get info about each item
        $sql_item = "SELECT * FROM items WHERE id=" . intval($item);
        $res_item = mysqli_query($connect, $sql_item);

        if($res_item->num_rows == 1)
        {
          $item_det = $res_item->fetch_assoc();

          echo "<tr><td>";
          echo $item_det['created'] . " " . $item_det['quality'] . " " . $item_det['name'];
          echo "</td></tr>";
        }
        else
        {
          echo "<p>Oh no!</p>";
        }
      }

      echo "</table>";
    }
    else
    {
      echo "<p>Huh. This transaction is empty.</p>";
    }
  }
  else
  {
    echo "<p>Well shit.</p>";
  }
}
 ?>
