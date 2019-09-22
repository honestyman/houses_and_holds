<?php
require_once "../src/dbConnect.php";

$connect = dbConnect();

if (mysqli_errno())
{
  // warn me
  $to = "admin@housesandholds.com";

  $subject = "Cron job failure - clearEmptySatchels.php";

  $message = "<p>The clearEmptySatchels.php cron job failed to connect to the database. Warning message: <br />";
  $message .= mysqli_errno() . "</p>";

  $headers = "From: Admin Houses and Holds <admin@housesandholds.com>\r\n";
  $headers .= "Reply-To: admin@housesandholds.com\r\n";
  $headers .= "Content-type: text/html\r\n";

  $sent = mail($to, $subject, $message, $headers);
}
else
{
  $sqls = "SELECT * FROM storage WHERE name='Satchel' AND location_id IS NOT NULL";
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows > 0)
  {
    while($satchel = $ress->fetch_assoc())
    {
      $sqlitems = "SELECT * FROM items WHERE storage_id=" . $satchel['id'];
      $resitems = mysqli_query($connect, $sqlitems);

      if($resitems->num_rows == 0)
      {
        $sqld = "DELETE FROM storage WHERE id=" . $satchel['id'];
        mysqli_query($connect, $sqld);
      }
    }
  }
}
 ?>
