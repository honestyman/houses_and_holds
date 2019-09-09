<?php
function dbConnect(){
  $host_name = 'db5000166612.hosting-data.io';
  $database = 'dbs161672';
  $user_name = 'dbu219044';
  $password = 'Tig3rducky*';
  $connect = mysqli_connect($host_name, $user_name, $password, $database);

  return $connect;
}
 ?>
