<?php
function charMakeOffline($connect, $char_id){
  $sql = "UPDATE characters SET is_online=0 WHERE id=" . $char_id;
  $result = mysqli_query($connect, $sql);
}
 ?>
