<?php
require_once "../src/dbConnect.php";

$connect = dbConnect();

if (mysqli_errno())
{
  // warn me
  $to = "admin@housesandholds.com";

  $subject = "Cron job failure - olgAge.php";

  $message = "<p>The oldAge.php cron job failed to connect to the database. Warning message: <br />";
  $message .= mysqli_errno() . "</p>";

  $headers = "From: Admin Houses and Holds <admin@housesandholds.com>\r\n";
  $headers .= "Reply-To: admin@housesandholds.com\r\n";
  $headers .= "Content-type: text/html\r\n";

  $sent = mail($to, $subject, $message, $headers);
}
else
{
  // cron reduce fullness
  $sqls = "SELECT * FROM characters WHERE death_date IS NULL AND birth_date IS NOT NULL";
  $ress = mysqli_query($connect, $sqls);

  if($ress->num_rows > 0)
  {
    while($char = $ress->fetch_assoc())
    {
      // roll for old age death

      // Calculate how old character is in days
      $birth = strtotime($char['birth_date']);
      $now = new DateTime('NOW');
      $now = $now->format('Y-m-d H:i:s');
      $now = strtotime($now) + (3600*6);
      $days = ($now-$birth)/(60*60*24);

      // calculate probability of death based on age
      $L = 100.0;
      $k = 0.5;
      $xo = 80.0;

      $prob = $L / (1 + exp(-$k * ($days - $xo)));

      // roll a random number between 0 and 100
      $rand = rand(1, 100);

      // char dies if rand is less than prob
      if($rand < $prob)
      {
        $sqlu = "UPDATE characters SET death_date=CURRENT_TIMESTAMP WHERE id=" . $char['id'];
        mysqli_query($connect, $sqlu);

        // drop satchel
        $sqlu = "UPDATE storage SET location_id=" . $char['location_id'] . " WHERE character_id=" . $char['id'];
        mysqli_query($connect, $sqlu);
      }
    }
  }
}
 ?>
