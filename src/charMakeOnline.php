<?php
function charMakeOnline($connect, $char_id){
  $sql = "UPDATE characters SET is_online=1 WHERE id=" . $char_id;
  $result = mysqli_query($connect, $sql);

  $sql = "SELECT * FROM characters WHERE id=" . $char_id;
  $result = mysqli_query($connect, $sql);
  if($result->num_rows>0)
  {
    while($row = $result->fetch_assoc())
    {
      // Info to pass to game
      $char = $row;

      // Check if character has null birth date
      if(is_null($char['birth_date']))
      {
        // Character is born
        $sqlb = "UPDATE characters SET birth_date=CURRENT_TIMESTAMP WHERE id=" . $char_id;
        $resultb = mysqli_query($connect, $sqlb);
        echo "<p>Happy birthday, " . $char['name'] . "!</p>";

        // Pass new birth date
        $sqlb = "SELECT birth_date FROM characters WHERE id=" . $char_id;
        $resultb = mysqli_query($connect, $sqlb);
        if($resultb->num_rows>0)
        {
          while($rowb = $resultb->fetch_assoc())
          {
            $char['birth_date'] = $rowb['birth_date'];
          }
        }
      }
    }
  }

  return $char;
}
 ?>
