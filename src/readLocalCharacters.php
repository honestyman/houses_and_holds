<?php
function readLocalCharacters($connect, $location)
{
  $path = "gamelogs/charsLoc" . $location['id'] . ".html";
  if(file_exists($path) && filesize($path) > 0)
  {
    $fp = fopen($path, 'r');
    $contents = fread($fp, filesize($path));
    fclose($fp);
    echo $contents;
  }
}
 ?>
