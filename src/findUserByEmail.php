<?php
function findUserByEmail($connect, $user_email, $pw){
$sql_a = "SELECT id FROM users WHERE email = '";
$sql_z = "'";
$sql1 = "{$sql_a}{$user_email}{$sql_z}";

$result = mysqli_query($connect, $sql1);
if($result->num_rows > 0) {
while($row = $result->fetch_assoc()){
$user_id = $row["id"];
};
} else {
$sql_a = "INSERT INTO users(email) VALUES ('";
$sql_z = "')";
$sql2 = "{$sql_a}{$user_email}{$sql_z}";
mysqli_query($connect, $sql2);

$result = mysqli_query($connect, $sql);
if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    $user_id = $row["id"];
  };
} else {
  echo "<p>Failed to add user to database.</p>";
}
};
return $user_id;
}
?>
