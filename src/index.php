<?php
include_once("Classes.php");
session_start();
$_SESSION['items']=array("cervena"=>1,100=>"10");
if(isset($_POST['name'])){
  echo $_POST['name'];
  echo print_r($_SESSION['items']);
}

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
  echo "Shop is empty";
}

foreach($items_array as $item){
  echo print_r($item->getDataArray());
  $data = $item->getDataArray();
  echo "<div>
  <h3>".$data[1]."</h3>
  <p>".$data[2]."->".$data[3]."</p>
  </div>";

}


?>


<form action="index.php" method="POST">
<input type="text" name="name" placeholder="Your name">
<input type="text" name="surname">
<input type="email" name="email">
<input type="tel" name="tel_num" pattern="^[0-9]{4} ?[0-9]{3} ?[0-9]{3}$" title="Write your number in pattern: XXXX XXX XXX">
<input type="text" name="address">
<input type="submit" value="Submit">
</form>

