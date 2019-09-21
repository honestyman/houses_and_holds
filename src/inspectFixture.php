<?php
function inspectFixture($connect, $char_id, $user_email, $user_id, $fixture_id)
{
  $sqls = "SELECT * FROM fixtures WHERE id=" . $fixture_id;
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows == 1)
  {
    $fixture = $ress->fetch_assoc();

    if(!is_null($fixture['description']))
    {
      echo $fixture['description'];
    }
  }
  else
  {
    echo "<p>Well shit.</p>";
  }
}
 ?>
