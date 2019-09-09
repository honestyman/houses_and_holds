<?php
function charMakeOnline($connect, $char_id){
  $sql = "UPDATE characters SET is_online=1 WHERE id=" . $char_id;
  $result = mysqli_query($connect, $sql);
}
 ?>
