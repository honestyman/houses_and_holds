<?php
function inspectStorage($connect, $char_id, $user_email, $user_id, $storage_id)
{
  $sqls = "SELECT * FROM storage WHERE id=" . $storage_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $storage = $ress->fetch_assoc();

    if(!is_null($storage['description']))
    {
      echo $storage['description'];
    }
  }
  else
  {
    echo "<p>Well shit.</p>";
  }
}
 ?>
