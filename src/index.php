<?php

echo "hej";

$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

$mysqli = new mysqli($servername,$username,$password,$database);
$info = $mysqli->info;

$sql = "SELECT * FROM Ponuka";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo print_r($row);
  }
} else {
  echo "0 results";
}
?>