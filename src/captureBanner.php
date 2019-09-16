<?php
function captureBanner($connect, $banner_id, $char_id)
{
  // Get banner info
  $sqlb = "SELECT * FROM banner_posts WHERE id=" . $banner_id;
  $resultb = mysqli_query($connect, $sqlb);

  if($resultb->num_rows==1)
  {
    $rowb = $resultb->fetch_assoc();
  }
  else {
    echo "<p>Bad game! No cookie for you!</p>";
  }

  // Get char info
  $sqlc = "SELECT * FROM characters WHERE id=" . $char_id;
  $resultc = mysqli_query($connect, $sqlc);

  if($resultc->num_rows==1)
  {
    $rowc = $resultc->fetch_assoc();
  }
  else
  {
    echo "<p>Bad game! No cookie for you!</p>";
  }

  if(is_null($rowc['house_id']))
  {
    echo "<p>You must belong to a House to capture a banner.</p>";
  }
  else
  {
    if($rowb['house_id']==$rowc['house_id'])
    {
      echo "<p>Your House already controls this banner.</p>";
    }
    else {
      // Check character's age first

      // Capture banner
      $sqlcap = "UPDATE banner_posts SET house_id=" . $rowc['house_id'] . " WHERE id=" . $banner_id;
      mysqli_query($connect, $sqlcap);
      echo "<p>Banner post captured!</p>";

      // Check other Hold banners
      $sqlloc = "SELECT * FROM locations WHERE id=" . $rowb['location_id'];
      $resloc = mysqli_query($connect, $sqlloc);

      if($resloc->num_rows==1)
      {
        $rowloc = $resloc->fetch_assoc();
      }
      else
      {
        echo "<p>Bad game! No cookie for you!</p>";
      }

      $sqlban = "SELECT banner_posts.id AS id, banner_posts.house_id AS house_id FROM banner_posts LEFT JOIN locations ON banner_posts.location_id = locations.id WHERE locations.hold_id=" . $rowloc['hold_id'];
      $resban = mysqli_query($connect, $sqlban);

      if($resban->num_rows>0)
      {
        $capture = 1;

        while($rowban = $resban->fetch_assoc())
        {
          //echo $rowban['house_id'] . "<br />";
          if(!is_null($rowban['id']))
          {
            if(is_null($rowban['house_id'])){$capture=0;}
            if($rowban['house_id']!=$rowc['house_id']){$capture=0;}
          }

        }

        //echo $capture;

        if($capture==1)
        {
          $sqlhold = "UPDATE holds SET house_id=" . $rowc['house_id'] . " WHERE id=" . $rowloc['hold_id'];
          mysqli_query($connect, $sqlhold);
          echo "<p>Hold captured!</p>";
        }
      }
    }
  }
}
 ?>
