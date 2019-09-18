<?php
require_once "../src/dbConnect.php";

$connect = dbConnect();

if (mysqli_errno())
{
  // warn me
  $to = "admin@housesandholds.com";

  $subject = "Cron job failure - hunger.php";

  $message = "<p>The hunger.php cron job failed to connect to the database. Warning message: <br />";
  $message .= mysqli_errno() . "</p>";

  $headers = "From: Admin Houses and Holds <admin@housesandholds.com>\r\n";
  $headers .= "Reply-To: admin@housesandholds.com\r\n";
  $headers .= "Content-type: text/html\r\n";

  $sent = mail($to, $subject, $message, $headers);
}
else
{
  // cron reduce fullness
  $sqls = "SELECT * FROM characters WHERE death_date IS NULL";
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows > 0)
  {
    while($char = $ress->fetch_assoc())
    {
      if($char['fullness']==0)
      {
        // dies
        $sqlu = "UPDATE characters SET death_date=CURRENT_TIMESTAMP WHERE id=" . $char['id'];
        mysqli_query($connect, $sqlu);
      }
      else
      {
        // fullness drops by 1
        $new_fullness = $char['fullness'] - 1;
        $sqlu = "UPDATE characters SET fullness=" . $new_fullness . " WHERE id=" . $char['id'];
        mysqli_query($connect, $sqlu);
      }
    }
  }
}
 ?>
