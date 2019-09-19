<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Houses and Holds</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div id='wrap'>
  <h1>Houses and Holds</h1>

<?php

require_once "src/dbConnect.php";
require_once "src/inspectBanner.php";
require_once "src/captureBanner.php";
require_once "src/registerHouse.php";
require_once "src/pledgeHouse.php";
require_once "src/viewPledge.php";
require_once "src/reviewPledges.php";

$connect = dbConnect();

if (mysqli_errno())
{
  die('<p>Failed to connect to MySQL: '.mysqli_error().'</p>');
}
else
{

  if(isset($_POST['interact']))
  {
    $interaction = $_POST['interaction'];
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $char_id = $_POST['char_id'];
    $obj_id = $_POST['obj_id'];

    //echo $interaction;

    if($interaction=='inspect_banner')
    {
      inspectBanner($connect, $obj_id);
    }

    if($interaction=='capture_banner')
    {
      captureBanner($connect, $obj_id, $char_id);
    }

    if($interaction=='register_house')
    {
      registerHouse($connect, $char_id, $user_email, $user_id);
    }

    if($interaction=='pledge_house')
    {
      pledgeHouse($connect, $char_id, $user_email, $user_id);
    }

    if($interaction=='view_pledge')
    {
      viewPledge($connect, $char_id, $user_email, $user_id);
    }

    if($interaction=='review_pledges')
    {
      reviewPledges($connect, $char_id, $user_email, $user_id);
    }
  }

  if(isset($_POST['house_register']))
  {
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $char_id = $_POST['char_id'];
    $house_name = htmlspecialchars($_POST['house_name']);

    $sqls = "SELECT * FROM houses WHERE name='" . $house_name . "'";
    $results = mysqli_query($connect, $sqls);

    if($results->num_rows > 0)
    {
      echo "<p>Sorry, that name already exists. Please choose another one.</p>";
      registerHouse($connect, $char_id, $user_email, $user_id);
    }
    else
    {
      $sqli = "INSERT INTO houses(name) VALUES ('" . $house_name . "')";
      mysqli_query($connect, $sqli);
      echo "<p>New House created.</p>";

      $results = mysqli_query($connect, $sqls);

      if($results->num_rows == 1)
      {
        $rows = $results->fetch_assoc();

        $sqlu = "UPDATE characters SET house_id=" . $rows['id'] . " WHERE id=" . $char_id;
        mysqli_query($connect, $sqlu);
        echo "<p>Character updated.</p>";
      }
      else
      {
        echo "<p>Uh oh! Something went wrong.</p>";
      }
    }
  }

  if(isset($_POST['pledge_house']))
  {
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $char_id = $_POST['char_id'];
    $house_name = htmlspecialchars($_POST['house_name']);

    $sqls = "SELECT * FROM houses WHERE name='" . $house_name . "'";
    $results = mysqli_query($connect, $sqls);

    if($results->num_rows < 1)
    {
      echo "<p>It looks like the House you entered doesn't exist. Try a different one below or go back to create it.</p>";
      pledgeHouse($connect, $char_id, $user_email, $user_id);
    }
    else if($results->num_rows > 1)
    {
      echo "<p>Uh oh! Something went wrong.</p>";
    }
    else
    {
      // Delete previous pledges by character
      $sqld = "DELETE FROM pledges WHERE char_id=" . $char_id;
      mysqli_query($connect, $sqld);

      // Create new pledge
      $rows = $results->fetch_assoc();
      $sqli = "INSERT INTO pledges(char_id, house_id) VALUES ('" . $char_id . "', '" . $rows['id'] . "')";
      mysqli_query($connect, $sqli);
      echo "<p>Pledge created.</p>";
    }
  }

  if(isset($_POST['withdraw_pledge']))
  {
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $char_id = $_POST['char_id'];

    $sqld = "DELETE FROM pledges WHERE char_id=" . $char_id;
    mysqli_query($connect, $sqld);
    echo "<p>Pledge withdrawn.</p>";
  }

  if(isset($_POST['decide_pledge']))
  {
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $char_id = $_POST['char_id'];
    $decision = $_POST['decision'];
    $pledge_id = $_POST['pledge_id'];

    if($decision=="accept")
    {
      // accept
      $sqlu = "UPDATE pledges SET accepted=1 WHERE id=" . $pledge_id;
      mysqli_query($connect, $sqlu);

      // get the house to pass to the pledge
      $sqls = "SELECT * FROM characters WHERE id=" . $char_id;
      $ress = mysqli_query($connect, $sqls);

      if($ress->num_rows == 1)
      {
        // do things
        $char = $ress->fetch_assoc();
        $house_id = $char['house_id'];

        $sqlp = "SELECT * FROM pledges WHERE id=" . $pledge_id;
        $resp = mysqli_query($connect, $sqlp);

        if($resp->num_rows == 1)
        {
          // get pc id
          $rowp = $resp->fetch_assoc();
          $pc_id = $rowp['char_id'];

          $sqlu = "UPDATE characters SET house_id=" . $house_id . " WHERE id=" . $pc_id;
          mysqli_query($connect, $sqlu);
          echo "<p>Pledge accepted.</p>";
        }
        else
        {
          echo "<p>Game broke.</p>";
        }
      }
      else
      {
        echo "<p>Oh shit wtf</p>";
      }
    }
    else if($decision=="reject")
    {
      // reject
      $sqlu = "UPDATE pledges SET rejected=1 WHERE id=" . $pledge_id;
      mysqli_query($connect, $sqlu);
      echo "<p>Pledge rejected.</p>";
    }
    else
    {
      echo "<p>Oh this is bad.</p>";
    }
  }
}

echo "<form action='index.php' method='post'>";
echo "<input type='hidden' name='user_email' value='" . $user_email . "' />";
echo "<input type='hidden' name='user_id' value='" . $user_id . "' />";
echo "<input type='hidden' name='char_id' value='" . $char_id . "' />";
echo "<input type='submit' name='play' value='Back' />";
echo "</form>";

 ?>

</body>
</html>