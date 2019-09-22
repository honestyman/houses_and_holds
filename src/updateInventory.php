<?php
require_once "characterAge.php";

function updateInventory($connect, $char)
{
  // Determine capacity based on age
  $age = characterAge($char['birth_date']);
  if($age == 'child'){ $capacity = 10.0; }
  else if($age == 'youth'){ $capacity = 50.0; }
  else if($age == 'adult'){ $capacity = 100.0; }
  else if($age == 'elder'){ $capacity = 25.0; }
  else { echo "wtf mate"; }

  // Check whether a storage unit already exists, create it if it doesn't
  $sqls = "SELECT * FROM storage WHERE character_id=" . $char['id'];
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 0)
  {
    // Create storage unit
    $sqli = "INSERT INTO storage(name, is_inventory, character_id, capacity, description) VALUES ('Satchel', 1, " . $char['id'] . ", " . $capacity . ", '<p>Someone dropped their satchel.</p>')";
    mysqli_query($connect, $sqli);
  }
  else if($ress->num_rows == 1)
  {
    // Update storage unit
    $rows = $ress->fetch_assoc();
    $sqlu = "UPDATE storage SET capacity=" . $capacity . " WHERE id=" . $rows['id'];
    mysqli_query($connect, $sqlu);
  }
  else
  {
    // Something went wrong
    echo "wtf mate";
  }
}
 ?>
