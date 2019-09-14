<?php
function readLocalCharacters($connect, $location)
{
  $path = "src/charsLoc" . $location['id'] . ".html";
  if(file_exists($path) && filesize($path) > 0)
  {
    $fp = fopen($path, 'r');
    $contents = fread($fp, filesize($path));
    fclose($fp);
    echo $contents;
  }
}
 ?>
