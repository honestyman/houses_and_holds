<?php
function inspectBanner($connect, $banner_id)
{
  $sqlbanner = "SELECT * FROM banner_posts WHERE id=" . $banner_id;
  $resultbanner = mysqli_query($connect, $sqlbanner);

  if($resultbanner->num_rows == 1)
  {
    $rowbanner = $resultbanner->fetch_assoc();
    echo "<p>Banner post: " . $rowbanner['name'] . "</p>";

    // Get location info
    $sqllocation = "SELECT * FROM locations WHERE id=" . $rowbanner['location_id'];
    $resultlocation = mysqli_query($connect, $sqllocation);

    if($resultlocation->num_rows == 1)
    {
      $rowlocation = $resultlocation->fetch_assoc();
      echo "<p>Location: " . $rowlocation['name'] . "</p>";
    }
    else
    {
      echo "<p>Uh oh! Something went wrong.</p>";
    }

    // Get hold info
    $sqlhold = "SELECT * FROM holds WHERE id=" . $rowlocation['hold_id'];
    $resulthold = mysqli_query($connect, $sqlhold);

    if($resulthold->num_rows == 1)
    {
      $rowhold = $resulthold->fetch_assoc();
      echo "<p>Hold: " . $rowhold['name'] . "</p>";
    }
    else
    {
      echo "<p>Uh oh! Something went wrong.</p>";
    }

    if(!is_null($rowhold['house_id']))
    {
      // Get hold house info
      $sqlhhouse = "SELECT * FROM houses WHERE id=" . $rowhold['house_id'];
      $resulthhouse = mysqli_query($connect, $sqlhhouse);

      if($resulthhouse->num_rows == 1)
      {
        $rowhhouse = $resulthhouse->fetch_assoc();
        echo "<p>Hold controlled by: " . $rowhhouse['name'] . "</p>";
      }
      else
      {
        echo "<p>Uh oh! Something went wrong.</p>";
      }
    }
    else {
      echo "<p>Hold controlled by: no one</p>";
    }

    if(!is_null($rowbanner['house_id']))
    {
      // Get banner house info
      $sqlbhouse = "SELECT * FROM houses WHERE id=" . $rowbanner['house_id'];
      $resultbhouse = mysqli_query($connect, $sqlbhouse);

      if($resultbhouse->num_rows == 1)
      {
        $rowbhouse = $resultbhouse->fetch_assoc();
        echo "<p>Post controlled by: " . $rowbhouse['name'] . "</p>";
      }
      else
      {
        echo "<p>Uh oh! Something went wrong.</p>";
      }
    }
    else {
      echo "<p>Post controlled by: no one</p>";
    }

  }
  else
  {
    echo "<p>Uh oh! Something went wrong.</p>";
  }
}
 ?>
