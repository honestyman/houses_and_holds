<?php
function displayTransactionItems($connect, $items)
{
  $item_id_array = explode(",", $items);
  $item_name_array = [];

  foreach ($item_id_array as $item_id)
  {
    $sqls = "SELECT * FROM items WHERE id=" . intval($item_id);
    $ress = mysqli_query($connect, $sqls);

    if($ress->num_rows == 1)
    {
      $item = $ress->fetch_assoc();
      array_push($item_name_array, $item['name']);
    }
    else
    {
      echo "<p>Crap.</p>";
    }
  }

  return implode(", ", $item_name_array);
}
 ?>
