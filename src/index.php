<?php
include_once("Classes.php");

$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

$mysqli = new mysqli($servername,$username,$password,$database);


$items_array = array();
$sql = "SELECT * FROM items";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    array_push($items_array,new Items($row));
  }
} else {
  echo "0 results";
}

foreach($items_array as $item){
  echo print_r($item->getDataArray());
  echo "<br>";

}


?>

<?php

//<form action="" method="">
//<input type="text" name=name>
//<input type="submit">
//</form>
if(isset($_POST['name'])){
  echo $_POST['name'];
}
?>