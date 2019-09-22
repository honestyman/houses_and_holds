<html>
<body>
<?php

if(!isset($_POST['select_cars']))
{
  echo "<form action='test.php' method='post'>";
  echo "<p><input type='checkbox' name='volvo' />Volvo</p>";
  echo "<p><input type='checkbox' name='saab' />Saab</p>";
  echo "<p><input type='checkbox' name='opel' />Opel</p>";
  echo "<p><input type='checkbox' name='audi' />Audi</p>";
  echo "<p><input type='submit' name='select_cars' value='Submit'></p>";
  echo "</form>";
}
else
{

  $items = [];

  if(isset($_POST['volvo']))
  {
    array_push($items, "volvo");
  }

  if(isset($_POST['saab']))
  {
    array_push($items, "saab");
  }

  if(isset($_POST['opel']))
  {
    array_push($items, "opel");
  }

  if(isset($_POST['audi']))
  {
    array_push($items, "audi");
  }

  if($items == [])
  {
    echo "<p>No items selected</p>";
  }
  else
  {
    echo implode(",", $items);
  }
}

 ?>
</body>
</html>
